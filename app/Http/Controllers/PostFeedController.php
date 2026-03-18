<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function showAdminPost(Post $post): View
    {
        $this->ensureAdminAuthoredPost($post);

        $post->load([
            'author',
            'tags',
            'comments.user',
        ]);

        return view('posts.admin-show', [
            'post' => $post,
        ]);
    }

    public function storeComment(Request $request, Post $post): RedirectResponse
    {
        $this->ensureAdminAuthoredPost($post);

        $validated = $request->validate([
            'content' => ['required', 'string', 'max:1000'],
        ]);

        $post->comments()->create([
            'user_id' => $request->user()->id,
            'content' => $validated['content'],
        ]);

        return to_route('posts.admin.show', ['post' => $post])->with('status', 'comment-created');
    }

    private function ensureAdminAuthoredPost(Post $post): void
    {
        $isAdminAuthored = $post->author()
            ->whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })
            ->exists();

        abort_unless($isAdminAuthored, 404);
    }
}
