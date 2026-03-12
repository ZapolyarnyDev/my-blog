@extends('layouts.app')

@section('body_class', 'ui-body')

@section('content')
    <div class="mx-auto max-w-5xl px-4 py-10">
        <div class="ui-toolbar mb-6 flex flex-wrap items-center justify-between gap-3">
            <div class="text-lg font-semibold">Админка постов</div>
            <div class="flex flex-wrap gap-2">
                <a class="ui-button" href="{{ route('admin.post.index') }}">Список</a>
                <a class="ui-button-primary" href="{{ route('admin.post.create') }}">Добавить пост</a>
            </div>
        </div>

        <h1 class="mb-4 text-xl font-semibold">Все посты</h1>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse($posts as $post)
            <article class="ui-card flex h-full flex-col">
                @if($post->preview_path)
                    <img class="mb-3 h-44 w-full rounded-lg object-cover" src="{{ asset('storage/' . $post->preview_path) }}" alt="{{ $post->title }}">
                @endif

                <div class="mb-2 flex items-center gap-3 text-xs text-slate-600">
                    @if($post->author?->avatar_path)
                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . $post->author->avatar_path) }}" alt="{{ $post->author->name }}">
                    @else
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 text-[10px] font-semibold text-slate-600">
                            {{ strtoupper(mb_substr($post->author->name ?? 'U', 0, 1)) }}
                        </div>
                    @endif
                    <span>Автор: {{ $post->author->name }}</span>
                    <span>Время чтения: {{ $post->duration }} мин</span>
                </div>

                <h2 class="text-lg font-semibold">{{ $post->title }}</h2>
                <p class="mt-1 flex-1 text-sm text-slate-600">{{ $post->description }}</p>

                <form class="mt-3 flex flex-wrap gap-3" action="{{ route('admin.post.delete', ['post' => $post]) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button class="ui-button-danger" type="submit">Удалить</button>
                    <a class="ui-button" href="{{ route('admin.post.edit', ['post' => $post]) }}">Изменить</a>
                    <a class="ui-button" href="{{ route('admin.post.show', ['post' => $post]) }}">Открыть</a>
                </form>
            </article>
            @empty
                <div class="ui-card text-center text-sm text-slate-600">Данных нет</div>
            @endforelse
        </div>
    </div>
@endsection
