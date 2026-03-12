@extends('layouts.app')

@section('body_class', 'ui-body')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-10">
        <div class="ui-toolbar mb-6 flex flex-wrap items-center justify-between gap-3">
            <div class="text-lg font-semibold">Админка постов</div>
            <div class="flex flex-wrap gap-2">
                <a class="ui-button" href="{{ route('admin.post.index') }}">Список</a>
                <a class="ui-button" href="{{ route('admin.post.edit', ['post' => $post]) }}">Редактировать</a>
                <a class="ui-button-primary" href="{{ route('admin.post.create') }}">Новый пост</a>
            </div>
        </div>

        <div class="ui-panel">
            <div class="mb-3 flex flex-wrap items-center gap-3 text-xs text-slate-600">
                <span class="ui-chip">Пост</span>
                <span>Время чтения: {{ $post->duration }} мин</span>
            </div>
            @if($post->preview_path)
                <img class="mb-4 h-64 w-full rounded-lg object-cover" src="{{ asset('storage/' . $post->preview_path) }}" alt="{{ $post->title }}">
            @endif
            <h1 class="text-2xl font-semibold">{{ $post->title }}</h1>
            <div class="mt-3 whitespace-pre-wrap text-sm leading-6 text-slate-700">{{ $post->description }}</div>
        </div>
    </div>
@endsection
