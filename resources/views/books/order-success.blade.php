<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;

Route::get('/', function () {
    return redirect('/books');
});

// Book routes
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');

// Enhanced Buy feature routes
Route::get('/books/{id}/buy', [BookController::class, 'showBuyPage'])->name('books.buy');
Route::post('/books/{id}/purchase', [BookController::class, 'purchase'])->name('books.purchase');
Route::get('/orders/{id}/success', [BookController::class, 'orderSuccess'])->name('orders.success');
Route::get('/my-orders', [BookController::class, 'purchaseHistory'])->name('books.purchase-history');

// Auth routes
Route::get('/signup', [AuthController::class, 'showSignupForm']);
Route::post('/signup', [AuthController::class, 'storeSignup'])->name('signup.store');
Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'storeLogin'])->name('login.store');

// Profile routes
Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');
Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');

// Logout
Route::get('/logout', function() {
    session()->forget('user_id');
    return redirect('/login');
});

// Review routes
Route::post('/books/{id}/reviews', [ReviewController::class, 'store'])->name('reviews.store');