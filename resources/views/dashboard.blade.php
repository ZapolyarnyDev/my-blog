<x-app-layout>
    <div class="py-16">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white p-8">
                <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-start gap-4">
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-slate-900 text-white">
                            <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M4 6h16"></path>
                                <path d="M4 12h16"></path>
                                <path d="M4 18h10"></path>
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">Read admin posts</h2>
                            <p class="mt-1 text-sm text-slate-600">Open the feed with posts published by admin users.</p>
                        </div>
                    </div>

                    <a
                        href="{{ route('posts.admin.index') }}"
                        class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
                    >
                        View posts
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
