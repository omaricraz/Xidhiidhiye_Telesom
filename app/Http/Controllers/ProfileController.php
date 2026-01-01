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
}


