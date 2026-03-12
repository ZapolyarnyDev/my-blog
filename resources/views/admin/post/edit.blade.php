@extends('layouts.app')

@section('body_class', 'ui-body')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-10">
        <div class="ui-toolbar mb-6 flex flex-wrap items-center justify-between gap-3">
            <div class="text-lg font-semibold">Админка постов</div>
            <div class="flex flex-wrap gap-2">
                <a class="ui-button" href="{{ route('admin.post.index') }}">Список</a>
                <a class="ui-button-primary" href="{{ route('admin.post.create') }}">Новый пост</a>
            </div>
        </div>

        <div class="ui-panel">
            <h1 class="mb-4 text-xl font-semibold">Редактирование поста</h1>

            @if($errors->any())
                <div class="mb-4 rounded-lg border border-rose-200 bg-rose-50 p-3 text-sm text-rose-700">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.post.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="text-sm font-semibold" for="title">Название</label>
                    <input class="mt-1 ui-input" type="text" name="title" id="title" value="{{ old('title', $post->title) }}">
                </div>
                <div>
                    <label class="text-sm font-semibold" for="description">Описание</label>
                    <textarea class="mt-1 min-h-[160px] ui-input" name="description" id="description" cols="30" rows="10">{{ old('description', $post->description) }}</textarea>
                    <div class="mt-1 text-xs text-slate-600">После обновления пересчитается время чтения.</div>
                </div>
                <div>
                    <label class="text-sm font-semibold" for="tags">Тег</label>
                    <select class="mt-1 ui-input" name="tags" id="tags">
                        @foreach($allTags as $tag)
                            <option value="{{ $tag->id }}" @selected((int) old('tags', optional($postTag)->id) === $tag->id)>{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-sm font-semibold" for="preview">Превью поста (до 2MB)</label>
                    <input class="mt-1 ui-input" type="file" name="preview" id="preview" accept="image/*">
                    @if($post->preview_path)
                        <img class="mt-3 h-36 w-full rounded-lg object-cover" src="{{ asset('storage/' . $post->preview_path) }}" alt="{{ $post->title }}">
                    @endif
                </div>
                <div class="flex flex-wrap gap-2">
                    <button class="ui-button-primary" type="submit">Сохранить</button>
                    <a class="ui-button" href="{{ route('admin.post.index') }}">Отмена</a>
                </div>
            </form>
        </div>
    </div>
@endsection
