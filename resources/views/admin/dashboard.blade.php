<x-layout>
    <h1 class="title text-center">Admin Dashboard</h1>

    <div class="space-y-4 max-w-md mx-auto">
        <a href="{{ route('admin.users.index') }}" class="block p-5 bg-slate-700 text-white rounded-lg text-center">
            Manage Users
        </a>

        <a href="{{ route('admin.posts.index') }}" class="block p-5 bg-slate-700 text-white rounded-lg text-center">
            Manage Posts
        </a>
    </div>
</x-layout>