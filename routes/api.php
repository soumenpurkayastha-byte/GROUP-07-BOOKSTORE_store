<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Test route
Route::get('/ping', function () {
    return response()->json([
        'message' => 'Laravel API is working'
    ]);
});

// API Login route
Route::post('/login', [AuthController::class, 'apiLogin']);

// API Signup route
Route::post('/signup', [AuthController::class, 'apiSignup']);

// //  List all users (for testing only)
// Route::get('/users', function () {
//     return App\Models\User_table::all();
// });
