<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SellController;
use App\Http\Middleware\CheckUserSession;

/*
|--------------------------------------------------------------------------
| Home & Recommendation
|--------------------------------------------------------------------------
*/
// Redirect home to books
Route::get('/', function () {
    return redirect('/books');
});

// Recommendation page
Route::get('/recommendations', [BookController::class, 'home'])
    ->name('recommendations');

/*
|--------------------------------------------------------------------------
| Authentication (Public)
|--------------------------------------------------------------------------
*/

Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'storeSignup'])->name('signup.store');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'storeLogin'])->name('login.store');

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes (Require Login)
|--------------------------------------------------------------------------
*/

Route::middleware(CheckUserSession::class)->group(function () {

    /*
    |-----------------
    | Books
    |-----------------
    */

    Route::get('/books', [BookController::class, 'index'])->name('books.index');

    // Best sellers (code1 feature)
    Route::get('/books/best-sellers', [BookController::class, 'bestSellers'])
        ->name('books.best-sellers');

    Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');

    // Buying flow
    Route::get('/books/{id}/buy', [BookController::class, 'showBuyPage'])->name('books.buy');
    Route::post('/books/{id}/purchase', [BookController::class, 'purchase'])->name('books.purchase');
    Route::get('/orders/{id}/success', [BookController::class, 'orderSuccess'])->name('orders.success');
    Route::get('/my-orders', [BookController::class, 'purchaseHistory'])
        ->name('books.purchase-history');

    /*
    |-----------------
    | Profile
    |-----------------
    */

    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');

    /*
    |-----------------
    | Sell / Marketplace
    |-----------------
    */

    Route::get('/sell', [SellController::class, 'index'])->name('sell.index');
    Route::get('/sell/create', [SellController::class, 'create'])->name('sell.create');
    Route::post('/sell', [SellController::class, 'store'])->name('sell.store');
    Route::get('/sell/{id}', [SellController::class, 'show'])->name('sell.show');
    Route::get('/my-listings', [SellController::class, 'myListings'])->name('sell.my-listings');
    Route::delete('/sell/{id}', [SellController::class, 'destroy'])->name('sell.destroy');

    /*
    |-----------------
    | Reviews
    |-----------------
    */

    Route::post('/books/{bookId}/reviews', [ReviewController::class, 'store'])
        ->name('reviews.store');
});
