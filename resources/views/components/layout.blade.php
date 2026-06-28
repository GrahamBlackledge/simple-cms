<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ env('APP_NAME', 'Life Post') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gradient-to-br from-stone-50 via-white to-blue-50 text-slate-950 min-h-screen">
    <header class="site-header">
        <nav>
            <a href="{{ route('posts.index') }}" class="brand-link">
                <span class="brand-mark">&amp;</span>

                <span class="brand-text">
                    <span class="brand-name">Life Post</span>
                    <span class="brand-tagline">Remember what inspires you.</span>
                </span>
            </a>

            @auth
                <div class="relative grid place-items-center" x-data="{ open: false }">
                    <button @click="open = !open" type="button" class="round-btn">
                        <img
                            src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('img/avatar5.png') }}"
                            alt="profile"
                            class="w-full h-full object-cover"
                        >
                    </button>

                    <div
                        x-cloak
                        x-show="open"
                        @click.outside="open = false"
                        class="bg-white shadow-lg absolute top-12 right-0 rounded-2xl overflow-hidden font-light min-w-[190px] z-50 border border-slate-200"
                    >
                        <p class="username">{{ auth()->user()->username }}</p>

                        @if (Route::has('admin.dashboard') && auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="block hover:bg-blue-50 px-4 py-2">
                                Admin Panel
                            </a>
                        @endif

                        @if (Route::has('dashboard'))
                            <a href="{{ route('dashboard') }}" class="block hover:bg-blue-50 px-4 py-2">
                                Dashboard
                            </a>
                        @endif

                        @if (Route::has('cms-app'))
                            <a href="{{ route('cms-app') }}" class="block hover:bg-blue-50 px-4 py-2">
                                JS CMS App
                            </a>
                        @endif

                        @if (Route::has('profile.edit'))
                            <a href="{{ route('profile.edit') }}" class="block hover:bg-blue-50 px-4 py-2">
                                Edit Profile
                            </a>
                        @endif

                        <form action="{{ route('logout') }}" method="post">
                            @csrf

                            <button class="block w-full text-left hover:bg-red-50 text-red-600 pl-4 pr-8 py-2">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endauth

            @guest
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                    <a href="{{ route('register') }}" class="btn-secondary">Register</a>
                </div>
            @endguest
        </nav>
    </header>

    <main class="py-10 px-4 mx-auto max-w-screen-xl">
        {{ $slot }}
    </main>
    <footer class="py-8 px-4 text-center text-sm text-slate-500">
    <p>
        <span class="font-semibold text-slate-700">Life Post</span>
        &mdash; Remember what inspires you.
    </p>
</footer>
</body>
</html>