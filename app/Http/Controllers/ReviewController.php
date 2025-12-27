<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Book;

class ReviewController extends Controller
{
    /**
     * Store or update a review for a book
     */
    public function store(Request $request, $bookId)
    {
        // Check login (session-based)
        $userId = session('user_id');
        if (!$userId) {
            return redirect('/login')->with('error', 'Please login first to add a review.');
        }

        // Validate input
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        /**
         * Create OR update review
         * - If user already reviewed → update
         * - Else → create new
         */
        Review::updateOrCreate(
            [
                'user_id' => $userId,
                'book_id' => $bookId,
            ],
            [
                'rating'  => $request->rating,
                'comment' => $request->comment,
            ]
        );

        // Recalculate average rating safely
        $book = Book::findOrFail($bookId);
        $book->rating = round($book->reviews()->avg('rating'), 1);
        $book->save();

        return back()->with('success', 'Review submitted successfully!');
    }
}
