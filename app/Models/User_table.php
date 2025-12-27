<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Review;
use App\Models\Listing;

class User_table extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_seller',
        'profile_image',
    ];

    // -----------------------------
    // User → Orders
    // -----------------------------
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // -----------------------------
    // User → Reviews
    // -----------------------------
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // -----------------------------
    // User → Listings
    // -----------------------------
    public function listings()
    {
        return $this->hasMany(Listing::class);
    }
}
