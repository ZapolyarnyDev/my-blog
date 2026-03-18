@extends('layouts.app')

@section('body_class', 'ui-body')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10">
        <div class="ui-toolbar mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold text-slate-900">Admin posts</h1>
                <p class="text-sm text-slate-600">Posts created by users with the admin role.</p>
            </div>

            <a href="{{ route('dashboard') }}" class="ui-button">Back to dashboard</a>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($posts as $post)
                <article class="ui-card flex h-full flex-col">
                    @if ($post->preview_path)
                        <img class="mb-3 h-44 w-full rounded-lg object-cover" src="{{ asset('storage/' . $post->preview_path) }}" alt="{{ $post->title }}">
                    @endif

                    <div class="mb-3 flex items-center gap-3 text-xs text-slate-600">
                        @if ($post->author?->avatar_path)
                            <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . $post->author->avatar_path) }}" alt="{{ $post->author->name }}">
                        @else
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 text-[10px] font-semibold text-slate-600">
                                {{ strtoupper(mb_substr($post->author->name ?? 'U', 0, 1)) }}
                            </div>
                        @endif
                        <span>{{ $post->author->name ?? 'Unknown author' }}</span>
                        <span>{{ $post->duration }} min</span>
                    </div>

                    <h2 class="text-lg font-semibold text-slate-900">{{ $post->title }}</h2>
                    <p class="mt-2 line-clamp-4 flex-1 text-sm text-slate-600">{{ strip_tags($post->description) }}</p>

                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach ($post->tags as $tag)
                            <span class="ui-chip">{{ $tag->name }}</span>
                        @endforeach
                    </div>

                    <a href="{{ route('posts.admin.show', ['post' => $post]) }}" class="mt-4 inline-flex items-center rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                        Open post
                    </a>
                </article>
            @empty
                <div class="ui-card col-span-full text-center text-sm text-slate-600">
                    No admin posts yet.
                </div>
            @endforelse
        </div>
    </div>
@endsection
