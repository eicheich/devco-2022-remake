<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Post;
use Illuminate\Support\Facades\Auth;

class RepostController extends Controller
{
    public function store(Post $post)
    {
        $repost = $post->reposts()->where('user_id', Auth::id())->first();

        if ($repost) {
            $repost->delete();
        } else {
            $post->reposts()->create(['user_id' => Auth::id()]);
            // Create notification if not reposting own post
            if ($post->user_id !== Auth::id()) {
                \App\Models\Notification::create([
                    'user_id' => $post->user_id,
                    'type' => 'repost',
                    'from_user_id' => Auth::id(),
                    'post_id' => $post->id,
                ]);
            }
        }

        return back();
    }
}
