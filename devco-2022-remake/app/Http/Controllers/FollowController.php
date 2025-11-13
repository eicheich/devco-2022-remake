<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function store(User $user)
    {
        if (!\App\Models\Follow::where('follower_id', Auth::id())->where('followed_id', $user->id)->exists()) {
            \App\Models\Follow::create([
                'follower_id' => Auth::id(),
                'followed_id' => $user->id,
            ]);
            // Create notification
            \App\Models\Notification::create([
                'user_id' => $user->id,
                'type' => 'follow',
                'from_user_id' => Auth::id(),
            ]);
        }
        return redirect()->back();
    }

    public function destroy(User $user)
    {
        \App\Models\Follow::where('follower_id', Auth::id())->where('followed_id', $user->id)->delete();
        return redirect()->back();
    }
}
