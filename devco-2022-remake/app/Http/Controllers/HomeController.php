<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // For You: Random posts from all users
        $forYouPosts = Post::with('user')->inRandomOrder()->take(20)->get();

        // Following: Posts from users that the current user follows
        $followingIds = \App\Models\Follow::where('follower_id', $user->id)->pluck('followed_id');
        $followingPosts = Post::with('user')->whereIn('user_id', $followingIds)->latest()->take(20)->get();

        return view('timeline', compact('forYouPosts', 'followingPosts'));
    }
}
