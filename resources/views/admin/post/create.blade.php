@extends('layouts.app')

@section('body_class', 'ui-body')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-10">
        <div class="ui-toolbar mb-6 flex flex-wrap items-center justify-between gap-3">
            <div class="text-lg font-semibold">Posts Admin</div>
            <div class="flex flex-wrap gap-2">
                <a class="ui-button" href="{{ route('admin.post.index') }}">List</a>
                <a class="ui-button-primary" href="{{ route('admin.post.create') }}">New post</a>
            </div>
        </div>

        <div class="ui-panel">
            <h1 class="mb-4 text-xl font-semibold">Create post</h1>

            @if($errors->any())
                <div class="mb-4 rounded-lg border border-rose-200 bg-rose-50 p-3 text-sm text-rose-700">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.post.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="text-sm font-semibold" for="title">Title</label>
                    <input class="mt-1 ui-input" type="text" name="title" id="title" placeholder="For example: How to build a clean CRUD">
                </div>
                <div>
                    <label class="text-sm font-semibold" for="description">Description</label>
                    <textarea class="mt-1 min-h-[160px] ui-input" name="description" id="description" cols="30" rows="10" placeholder="Short and clear text..."></textarea>
                    <div class="mt-1 text-xs text-slate-600">Content length affects read time.</div>
                </div>
                <div>
                    <label class="text-sm font-semibold" for="tags">Tag</label>
                    <select class="mt-1 ui-input" name="tags" id="tags">
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-sm font-semibold" for="preview">Post preview (up to 2MB)</label>
                    <input class="mt-1 ui-input" type="file" name="preview" id="preview" accept="image/*">
                </div>
                <div class="flex flex-wrap gap-2">
                    <button class="ui-button-primary" type="submit">Create</button>
                    <a class="ui-button" href="{{ route('admin.post.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
