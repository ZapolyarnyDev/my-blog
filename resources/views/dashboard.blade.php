<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="p-6 text-slate-900">
                    <h3 class="text-lg font-semibold">Рабочая панель</h3>
                    <p class="mt-1 text-sm text-slate-600">Здесь можно быстро перейти к ключевым действиям.</p>

                    @if (auth()->user()->hasRole('admin'))
                        <div class="mt-4 rounded-lg border border-slate-200 bg-slate-50 p-4">
                            <h4 class="text-sm font-semibold text-slate-900">Создание постов</h4>
                            <p class="mt-1 text-sm text-slate-600">Раздел доступен только администраторам.</p>
                            <a href="{{ route('admin.post.create') }}" class="mt-3 inline-flex items-center rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-800">
                                Создать пост
                            </a>
                        </div>
                    @else
                        <p class="mt-4 text-sm text-slate-600">У вас нет прав администратора для создания постов.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
