<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User_table;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Show user profile page
    public function showProfile()
    {
        $user = User_table::find(session('user_id'));

        if (!$user) {
            return redirect('/login')->with('error', 'Please login first.');
        }

        return view('auth.profile', compact('user'));
    }

    // Handle profile update
    public function updateProfile(Request $request)
    {
        $user = User_table::find(session('user_id'));

        if (!$user) {
            return redirect('/login')->with('error', 'Please login first.');
        }

        // Validation
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
            $folder = public_path('images/profiles');
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }

            // Delete old image if exists
            if ($user->profile_image && file_exists($folder . '/' . $user->profile_image)) {
                unlink($folder . '/' . $user->profile_image);
            }

            $image = $request->file('profile_image');
            $imageName = 'profile_' . $user->id . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move($folder, $imageName);
            $user->profile_image = $imageName;
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}
