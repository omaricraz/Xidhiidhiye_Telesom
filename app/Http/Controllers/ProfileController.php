<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the authenticated user's profile.
     */
    public function show()
    {
        $user = Auth::user();
        $user->load('team');
        
        return view('profile.show', compact('user'));
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'status' => 'required|in:active,holiday,sick_leave,remote,offline',
        ]);
        
        $user->update($validated);
        
        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }
}






