<x-layout>
    <a href="{{ route('admin.dashboard') }}" class="block mb-4 text-xs text-blue-500">
        &larr; Back to admin dashboard
    </a>

    <h1 class="title">Manage Users</h1>

    <a href="{{ route('admin.users.create') }}" class="inline-block mb-4 bg-slate-600 text-white px-4 py-2 rounded">
        + Add New User
    </a>

    @if (session('success'))
        <x-flashMsg msg="{{ session('success') }}" />
    @endif

    <div class="card overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-slate-100 text-left">
                    <th class="p-2">Username</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Role</th>
                    <th class="p-2">Avatar</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                    <tr class="border-t">
                        <td class="p-2">{{ $user->username }}</td>
                        <td class="p-2">{{ $user->email }}</td>
                        <td class="p-2">{{ $user->role }}</td>
                        <td class="p-2">
                            @if ($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="" class="h-10 w-10 rounded-full object-cover">
                            @endif
                        </td>
                        <td class="p-2 flex gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600">
                                Edit
                            </a>

                            <form action="{{ route('admin.users.destroy', $user) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button class="text-red-600">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</x-layout>