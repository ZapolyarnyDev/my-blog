<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Main</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 @yield('body_class')">
    <main class="min-h-screen">
        <header class="border-b border-slate-200 bg-white/95 backdrop-blur">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
                <a href="{{ route('dashboard') }}" class="text-base font-semibold tracking-tight text-slate-900">
                    MY AMAZING BLOG!!!!!!
                </a>

                @auth
                    <nav class="flex items-center gap-2 text-sm">
                        <a
                            href="{{ route('dashboard') }}"
                            class="rounded-md px-3 py-1.5 transition {{ request()->routeIs('dashboard') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}"
                        >
                            Dashboard
                        </a>

                        <a
                            href="{{ route('profile.edit') }}"
                            class="rounded-md px-3 py-1.5 transition {{ request()->routeIs('profile.*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}"
                        >
                            Profile
                        </a>

                        @if (auth()->user()->hasAnyRole(['admin', 'editor']))
                            <a
                                href="{{ route('admin.post.index') }}"
                                class="rounded-md px-3 py-1.5 transition {{ request()->routeIs('admin.*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}"
                            >
                                Posts
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="ml-1">
                            @csrf
                            <button type="submit" class="rounded-md px-3 py-1.5 text-slate-700 transition hover:bg-slate-100">
                                Logout
                            </button>
                        </form>
                    </nav>
                @endauth
            </div>
        </header>

        @isset($slot)
            {{ $slot }}
        @endisset

        @yield('content')
    </main>
</body>
</html>
