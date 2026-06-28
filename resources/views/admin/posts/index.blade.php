<x-layout>
    <a href="{{ route('admin.dashboard') }}" class="block mb-4 text-xs text-blue-500">
        &larr; Back to admin dashboard
    </a>

    <h1 class="title">Manage Posts</h1>

    @if (session('success'))
        <x-flash-msg msg="{{ session('success') }}" />
    @endif

    <div class="card overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-slate-100 text-left">
                    <th class="p-2">ID</th>
                    <th class="p-2">Title</th>
                    <th class="p-2">Author</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($posts as $post)
                    <tr class="border-t">
                        <td class="p-2">{{ $post->id }}</td>
                        <td class="p-2">{{ $post->title }}</td>
                        <td class="p-2">{{ $post->user->username }}</td>
                        <td class="p-2 flex gap-2">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="text-blue-600">
                                Edit
                            </a>

                            <form action="{{ route('admin.posts.destroy', $post) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button class="text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
</x-layout>