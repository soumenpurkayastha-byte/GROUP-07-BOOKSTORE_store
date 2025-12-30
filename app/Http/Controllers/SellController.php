<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User_table;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SellController extends Controller
{
    // Show all listings
    public function index(Request $request)
    {
        $search = $request->query('search');
        $condition = $request->query('condition');
        $sort = $request->query('sort', 'created_at');

        $query = Listing::with('user')->where('status', 'active');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('author', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            });
        }

        if ($condition && $condition != 'all') {
            $query->where('condition', $condition);
        }

        $listings = $query->orderBy($sort, 'desc')->paginate(12);

        return view('sell.index', compact('listings', 'search', 'condition', 'sort'));
    }

    // Show create listing form
    public function create()
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Please login first.');
        }

        $user = User_table::find($userId);
        
        if (!$user->is_seller) {
            return redirect('/sell')->with('error', 'You need to be registered as a seller to create listings.');
        }

        return view('sell.create');
    }

    // Store new listing
    public function store(Request $request)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Please login first.');
        }

        $user = User_table::find($userId);
        
        if (!$user->is_seller) {
            return redirect('/sell')->with('error', 'You need to be registered as a seller.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0.01|max:9999.99',
            'condition' => 'required|in:new,like-new,used',
            'genre' => 'nullable|string|max:100',
            'quantity' => 'required|integer|min:1|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $photoName = null;
        
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_' . Str::random(10) . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images/listings'), $photoName);
        }

        Listing::create([
            'user_id' => $userId,
            'title' => $request->title,
            'author' => $request->author,
            'description' => $request->description,
            'price' => $request->price,
            'condition' => $request->condition,
            'genre' => $request->genre,
            'quantity' => $request->quantity,
            'photo' => $photoName,
            'status' => 'active'
        ]);

        return redirect('/my-listings')->with('success', 'Book listed successfully!');
    }

    // Show single listing
    public function show($id)
    {
        $listing = Listing::with('user')->findOrFail($id);
        return view('sell.show', compact('listing'));
    }

    // Show user's own listings
    public function myListings()
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Please login first.');
        }

        $listings = Listing::where('user_id', $userId)
                           ->latest()
                           ->paginate(10);

        return view('sell.my-listings', compact('listings'));
    }

    // Delete listing
    public function destroy($id)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Please login first.');
        }

        $listing = Listing::where('id', $id)->where('user_id', $userId)->firstOrFail();
        
        // Delete photo if exists
        if ($listing->photo && file_exists(public_path('images/listings/' . $listing->photo))) {
            unlink(public_path('images/listings/' . $listing->photo));
        }

        $listing->delete();

        return back()->with('success', 'Listing deleted successfully!');
    }
}