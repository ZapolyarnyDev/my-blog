<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CreatePostRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::query()
            ->with(['tags', 'author'])
            ->get();

        return view('admin.post.list', [
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();

        return view('admin.post.create', [
            'tags' => $tags
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request)
    {
        $temp = 1500;
        $wordsLength = mb_strlen(strip_tags($request->description));
        $minutes = ceil($wordsLength / $temp);
        $previewPath = $request->file('preview')?->store('posts/previews', 'public');

        $model = Post::query()->create([
            'title' => $request->title,
            'description' => $request->description,
            'duration' => $minutes,
            'author_id' => Auth::id(),
            'preview_path' => $previewPath,
        ]);

        $model->tags()->attach([$request->tags]);

        return to_route('admin.post.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('admin.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $postTag = $post->tags()->first();
        $allTags = Tag::all();

        return view('admin.post.edit', compact('post', 'postTag', 'allTags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => ['required', 'max:255'],
            'description' => ['required'],
            'tags' => ['required', 'exists:tags,id'],
            'preview' => ['nullable', 'image', 'max:2048'],
        ]);

        $temp = 1500;
        $wordsLength = mb_strlen(strip_tags($validated['description']));
        $minutes = ceil($wordsLength / $temp);

        if ($request->hasFile('preview')) {
            if ($post->preview_path) {
                Storage::disk('public')->delete($post->preview_path);
            }

            $post->preview_path = $request->file('preview')->store('posts/previews', 'public');
        }

        $post->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'duration' => $minutes,
            'author_id' => Auth::id(),
            'preview_path' => $post->preview_path,
        ]);

        $post->tags()->sync([$validated['tags']]);

        return to_route('admin.post.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->preview_path) {
            Storage::disk('public')->delete($post->preview_path);
        }

        $post->delete();

        return to_route('admin.post.index');
    }
}
