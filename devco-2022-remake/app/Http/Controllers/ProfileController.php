<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show($userId)
    {
        $user = \App\Models\User::findOrFail($userId);
        $posts = \App\Models\Post::where('user_id', $user->id)->latest()->get();
        $reposts = \App\Models\Repost::where('user_id', $user->id)->with('post')->latest()->get();
        return view('profile', compact('user', 'posts', 'reposts'));
    }
}
