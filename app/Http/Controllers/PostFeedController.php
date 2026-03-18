<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class PostFeedController extends Controller
{
    public function adminPosts(): View
    {
        $posts = Post::query()
            ->with(['author.roles', 'tags'])
            ->whereHas('author.roles', function ($query) {
                $query->where('name', 'admin');
            })
            ->latest()
            ->get();

        return view('posts.admin-index', [
            'posts' => $posts,
        ]);
    }
}

