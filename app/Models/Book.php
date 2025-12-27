<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use App\Models\Order;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'price',
        'description',
        'cover_image',
        'genre',
        'stock',
        'publisher',
        'year',
        'language',
        'rating'
    ];

    // -----------------------------
    // Relation: Book → Reviews
    // -----------------------------
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // -----------------------------
    // Relation: Book → Orders
    // (needed for Best Sellers)
    // -----------------------------
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // -----------------------------
    // Average rating of this book
    // -----------------------------
    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

    // -----------------------------
    // Total number of reviews
    // -----------------------------
    public function reviewsCount()
    {
        return $this->reviews()->count();
    }
}
