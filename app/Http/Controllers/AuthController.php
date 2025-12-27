<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User_table;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Constructor to apply middleware to all methods except login/signup
    public function __construct()
    {
        $this->middleware(\App\Http\Middleware\CheckUserSession::class)
             ->except(['showLoginForm', 'storeLogin', 'showSignupForm', 'storeSignup']);
    }

    // Show signup page
    public function showSignupForm()
    {
        return view('auth.signup');
    }

    // Handle signup form submission
    public function storeSignup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user_tables,email',
            'password' => 'required|string|min:6',
        ]);

        User_table::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_seller' => $request->has('is_seller') ? true : false,
        ]);

        return redirect('/books')->with('success', 'Signup successful!');
    }

    // Show login page
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login form submission
    public function storeLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User_table::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            session(['user_id' => $user->id]); // store user session
            return redirect('/books');
        } else {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }
    }

    // Logout user
    public function logout()
    {
        session()->forget('user_id');
        return redirect()->route('login');
    }

    // Show user profile page
    public function showProfile()
    {
        $user = User_table::find(session('user_id'));
        return view('auth.profile', compact('user'));
    }

    // Handle profile update (name, email, password, profile image)
    public function updateProfile(Request $request)
    {
        $user = User_table::find(session('user_id'));

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user_tables,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Ensure folder exists
            if (!file_exists(public_path('images/profiles'))) {
                mkdir(public_path('images/profiles'), 0755, true);
            }

            $image = $request->file('profile_image');
            $imageName = 'profile_' . $user->id . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/profiles'), $imageName);
            $user->profile_image = $imageName;
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}
