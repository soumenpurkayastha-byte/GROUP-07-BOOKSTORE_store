<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'author',
        'description',
        'price',
        'condition',
        'genre',
        'quantity',
        'photo',
        'status'
    ];

    // Relationship with user
    public function user()
    {
        return $this->belongsTo(User_table::class);
    }
}