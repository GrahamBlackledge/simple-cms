<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-slate-100 text-slate-900">
    <header class="bg-slate-800 shadow-lg">
        <nav>
            <a href="{{ route('posts.index') }}" class="nav-link">Home</a>

            @auth
                <div class="relative grid place-items-center" x-data="{ open: false }">
                    <button @click="open = !open" type="button" class="round-btn">
                        <img
                            src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('img/avatar5.png') }}"
                            alt="profile"
                            class="w-8 h-8 rounded-full object-cover"
                        >
                    </button>

                    <div
                        x-show="open"
                        @click.outside="open = false"
                        class="bg-white shadow-lg absolute top-10 right-0 rounded-lg overflow-hidden font-light min-w-[180px] z-50"
                    >
                        <p class="px-4 py-2 text-sm text-gray-700 border-b text-center font-semibold">
                            {{ auth()->user()->username }}
                        </p>

                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="block hover:bg-slate-100 px-4 py-2">
                                Admin Panel
                            </a>
                        @endif

                        <a href="{{ route('dashboard') }}" class="block hover:bg-slate-100 px-4 py-2">
                            Dashboard
                        </a>

                        <a href="{{ route('cms-app') }}" class="block hover:bg-slate-100 px-4 py-2">
                            JS CMS App
                        </a>

                        <a href="{{ route('profile.edit') }}" class="block hover:bg-slate-100 px-4 py-2">
                            Edit Profile
                        </a>

                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="block w-full text-left hover:bg-slate-100 pl-4 pr-8 py-2">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endauth

            @guest
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                    <a href="{{ route('register') }}" class="nav-link">Register</a>
                </div>
            @endguest
        </nav>
    </header>

    <main class="py-8 px-4 mx-auto max-w-screen-lg">
        {{ $slot }}
    </main>
</body>
</html>