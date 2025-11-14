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

    public function edit($userId)
    {
        $user = \App\Models\User::findOrFail($userId);
        // Ensure only owner can edit
        if ($user->id !== Auth::id()) {
            abort(403);
        }
        return view('profile_edit', compact('user'));
    }

    public function update(Request $request, $userId)
    {
        $user = \App\Models\User::findOrFail($userId);
        if ($user->id !== Auth::id()) {
            abort(403);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id . '|regex:/^[a-zA-Z0-9_]+$/',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date|before:today',
        ], [
            'username.unique' => 'Username sudah digunakan, silakan pilih yang lain',
            'username.regex' => 'Username hanya boleh mengandung huruf, angka, dan underscore',
            'date_of_birth.before' => 'Date of birth must be before today'
        ]);
        $user->update($request->only(['name', 'username', 'email', 'gender', 'date_of_birth']));
        return redirect()->route('profile.show', $user->id)->with('success', 'Profile updated successfully.');
    }
}
