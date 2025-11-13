<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Post;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Post $post)
    {
        $like = $post->likes()->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
        } else {
            $post->likes()->create(['user_id' => Auth::id()]);
            // Create notification if not liking own post
            if ($post->user_id !== Auth::id()) {
                \App\Models\Notification::create([
                    'user_id' => $post->user_id,
                    'type' => 'like',
                    'from_user_id' => Auth::id(),
                    'post_id' => $post->id,
                ]);
            }
        }

        return back();
    }
}
