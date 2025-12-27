<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;
use App\Models\User_table;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'user_id',
        'rating',
        'comment',
    ];

    // --------------------------------
    // Review belongs to a Book
    // --------------------------------
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // --------------------------------
    // Review belongs to a User
    // (custom user table)
    // --------------------------------
    public function user()
    {
        return $this->belongsTo(User_table::class, 'user_id');
    }
}
