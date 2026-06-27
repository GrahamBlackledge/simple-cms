<x-layout>
    <a href="{{ route('admin.users.index') }}" class="block mb-4 text-xs text-blue-500">
        &larr; Back to users
    </a>

    <h1 class="title">Edit User</h1>

    <form action="{{ route('admin.users.update', $user) }}" method="post" enctype="multipart/form-data" class="card max-w-md mx-auto">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label>Username</label>
            <input name="username" value="{{ old('username', $user->username) }}" class="input">
            @error('username') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label>Email</label>
            <input name="email" type="email" value="{{ old('email', $user->email) }}" class="input">
            @error('email') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label>Role</label>
            <select name="role" class="input">
                <option value="user" @selected($user->role === 'user')>User</option>
                <option value="admin" @selected($user->role === 'admin')>Admin</option>
            </select>
        </div>

        <div class="mb-4">
            <label>Avatar</label>
            <input type="file" name="avatar" class="input">

            @if ($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="" class="h-16 w-16 rounded-full mt-2 object-cover">
            @endif
        </div>

        <button class="btn">Save</button>
    </form>
</x-layout>