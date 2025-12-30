<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Listing;
use App\Models\Order;
use App\Models\User_table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

use Twilio\Rest\Client; #api work
use Illuminate\Support\Facades\Auth; #api work

class BookController extends Controller
{
    // -------------------------------------------------
    // Feature 1,2,3: Book list + search + sorting
    // Includes official books + user listings
    // -------------------------------------------------
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'title');
        $allowedSorts = ['title', 'author', 'price'];

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'title';
        }

        $search = $request->query('search');

        // Official books
        $booksQuery = Book::query();
        if ($search) {
            $booksQuery->where('title', 'like', "%$search%")
                ->orWhere('author', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%");
        }
        $officialBooks = $booksQuery->orderBy($sort)->get();

        // User listings
        $listingsQuery = Listing::with('user')->where('status', 'active');
        if ($search) {
            $listingsQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('author', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });
        }
        $userListings = $listingsQuery->orderBy($sort)->get();

        // Format user listings
        $formattedListings = $userListings->map(function ($listing) {
            return (object)[
                'id' => $listing->id,
                'title' => $listing->title,
                'author' => $listing->author,
                'price' => $listing->price,
                'description' => $listing->description,
                'cover_image' => $listing->photo ?: 'default-book.jpg',
                'stock' => $listing->quantity,
                'genre' => $listing->genre,
                'rating' => 0,
                'is_user_listing' => true,
                'seller_name' => $listing->user?->name,
                'condition' => $listing->condition,
                'listing_id' => $listing->id
            ];
        });

        // Format official books
        $formattedOfficialBooks = $officialBooks->map(function ($book) {
            $bookObj = (object)$book->toArray();
            $bookObj->is_user_listing = false;
            return $bookObj;
        });

        // Merge & sort
        $allBooks = $formattedOfficialBooks->concat($formattedListings);

        if ($sort === 'price') {
            $allBooks = $allBooks->sortBy('price');
        } elseif ($sort === 'author') {
            $allBooks = $allBooks->sortBy('author');
        } else {
            $allBooks = $allBooks->sortBy('title');
        }

        $allBooks = $allBooks->values();

        return view('books.index', compact('allBooks', 'sort', 'search'));
    }

    // -------------------------------------------------
    // Book details + Wikipedia integration
    // -------------------------------------------------
    public function show($id)
    {
        $book = Book::with(['reviews' => function ($query) {
            $query->with('user')->latest();
        }])->findOrFail($id);

        $wikiPageUrl = 'https://en.wikipedia.org/wiki/Special:Search?search='
            . rawurlencode($book->title . ' (book)');
        $wikiData = null;

        try {
            $response = Http::get(
                "https://en.wikipedia.org/api/rest_v1/page/summary/" .
                rawurlencode($book->title . ' (book)')
            );

            if ($response->ok()) {
                $wikiData = $response->json();
                if (isset($wikiData['content_urls']['desktop']['page'])) {
                    $wikiPageUrl = $wikiData['content_urls']['desktop']['page'];
                }
            }
        } catch (\Exception $e) {
            $wikiData = null;
        }

        return view('books.show', compact('book', 'wikiData', 'wikiPageUrl'));
    }

    // -------------------------------------------------
    // Buy page
    // -------------------------------------------------
    public function showBuyPage($id)
    {
        $book = Book::findOrFail($id);

        if (!session('user_id')) {
            return redirect('/login')->with('error', 'Please login first to purchase books.');
        }

        return view('books.buy', compact('book'));
    }

    // -------------------------------------------------
    // Purchase book
    // -------------------------------------------------
    public function purchase(Request $request, $id)
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect('/login')->with('error', 'Please login first to purchase books.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $book = Book::findOrFail($id);
        $quantity = $request->quantity;

        if ($book->stock < $quantity) {
            return back()->with('error', "Sorry, only {$book->stock} copies are available.");
        }

        $totalPrice = $book->price * $quantity;

        try {
            $order = Order::create([
                'user_id' => $userId,
                'book_id' => $book->id,
                'quantity' => $quantity,
                'total_price' => $totalPrice,
            ]);

            $book->decrement('stock', $quantity);

            return redirect()
                ->route('orders.success', $order->id)
                ->with('success', 'Purchase successful!');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong. Try again.');
        }
    }

    // -------------------------------------------------
    // Order success
    // -------------------------------------------------
    public function orderSuccess($orderId)
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect('/login');
        }

        $order = Order::with(['book', 'user'])
            ->where('id', $orderId)
            ->where('user_id', $userId)
            ->firstOrFail();

        return view('books.order-success', compact('order'));
    }

    // -------------------------------------------------
    // Purchase history
    // -------------------------------------------------
    public function purchaseHistory()
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect('/login');
        }

        $orders = Order::with('book')
            ->where('user_id', $userId)
            ->latest()
            ->paginate(10);

        return view('books.purchase-history', compact('orders'));
    }

    // -------------------------------------------------
    // Best sellers ranking
    // -------------------------------------------------
    public function bestSellers()
    {
        $books = Book::withCount([
            'orders as total_sold' => function ($query) {
                $query->select(DB::raw('SUM(quantity)'));
            }
        ])
            ->orderByDesc('total_sold')
            ->orderBy('title')
            ->get();

        $rank = 1;
        foreach ($books as $book) {
            $book->rank = $rank++;
        }

        return view('books.best-sellers', compact('books'));
    }

    // -------------------------------------------------
    // Home / Recommendation page
    // -------------------------------------------------
    public function home()
    {
        $mostCommented = Book::withCount('reviews')
            ->orderByDesc('reviews_count')
            ->take(3)
            ->get();

        $highestRated = Book::orderByDesc('rating')
            ->take(5)
            ->get();

        $topBuyers = DB::table('orders')
            ->join('user_tables', 'orders.user_id', '=', 'user_tables.id')
            ->select('user_tables.name', DB::raw('SUM(orders.quantity) as total_books'))
            ->groupBy('user_tables.name')
            ->orderByDesc('total_books')
            ->take(5)
            ->get();

        $topSellers = DB::table('listings')
            ->join('user_tables', 'listings.user_id', '=', 'user_tables.id')
            ->select('user_tables.name', DB::raw('SUM(listings.quantity) as total_listed'))
            ->groupBy('user_tables.name')
            ->orderByDesc('total_listed')
            ->take(5)
            ->get();

        return view('welcome', compact(
            'mostCommented',
            'highestRated',
            'topBuyers',
            'topSellers'
        ));
    }
}
