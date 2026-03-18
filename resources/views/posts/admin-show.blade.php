@extends('layouts.app')

@section('body_class', 'ui-body')

@section('content')
    <div class="mx-auto max-w-4xl px-4 py-10">
        <div class="ui-toolbar mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold text-slate-900">Post details</h1>
                <p class="text-sm text-slate-600">Read and discuss this post.</p>
            </div>
            <a href="{{ route('posts.admin.index') }}" class="ui-button">Back to posts</a>
        </div>

        <article class="ui-panel">
            <div class="mb-3 flex items-center gap-3 text-xs text-slate-600">
                <span class="ui-chip">Admin</span>
                <span>{{ $post->author->name ?? 'Unknown author' }}</span>
                <span>{{ $post->duration }} min</span>
            </div>

            @if ($post->preview_path)
                <img class="mb-4 h-72 w-full rounded-lg object-cover" src="{{ asset('storage/' . $post->preview_path) }}" alt="{{ $post->title }}">
            @endif

            <h2 class="text-2xl font-semibold text-slate-900">{{ $post->title }}</h2>
            <div class="mt-3 whitespace-pre-wrap text-sm leading-6 text-slate-700">{{ $post->description }}</div>
        </article>

        <section class="ui-panel mt-6">
            <h3 class="text-lg font-semibold text-slate-900">Comments</h3>

            <form action="{{ route('posts.admin.comments.store', ['post' => $post]) }}" method="POST" class="mt-4">
                @csrf
                <label for="content" class="mb-2 block text-sm font-medium text-slate-700">Add comment</label>
                <textarea id="content" name="content" rows="4" class="ui-input" placeholder="Write your thoughts..." required>{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                @enderror

                <button type="submit" class="ui-button-primary mt-3">Send comment</button>
            </form>

            <div class="mt-6 space-y-4">
                @forelse ($post->comments->sortByDesc('created_at') as $comment)
                    <article class="rounded-lg border border-slate-200 bg-white p-4">
                        <div class="mb-2 flex items-center justify-between gap-2 text-xs text-slate-500">
                            <span class="font-semibold text-slate-700">{{ $comment->user->name ?? 'User' }}</span>
                            <span>{{ $comment->created_at?->format('d.m.Y H:i') }}</span>
                        </div>
                        <p class="whitespace-pre-wrap text-sm text-slate-700">{{ $comment->content }}</p>
                    </article>
                @empty
                    <p class="text-sm text-slate-600">No comments yet. Be the first to comment.</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection

