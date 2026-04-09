<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users' => User::count(),
            'posts' => Post::count(),
            'comments' => Comment::count(),
            'tags' => Tag::count(),
        ];

        $popularPosts = Post::with('user')
            ->withCount('comments')
            ->orderByDesc('comments_count')
            ->limit(5)
            ->get();

        $popularTags = Tag::withCount('posts')
            ->orderByDesc('posts_count')
            ->limit(5)
            ->get();

        $latestUsers = User::latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact([
            'stats',
            'popularPosts',
            'popularTags',
            'latestUsers'
        ]));
    }
}
