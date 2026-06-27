<x-layout>
    <a href="{{ route('admin.users.index') }}" class="block mb-4 text-xs text-blue-500">
        &larr; Back to users
    </a>

    <h1 class="title">Add New User</h1>

    <form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data" class="card max-w-md mx-auto">
        @csrf

        <div class="mb-4">
            <label>Username</label>
            <input name="username" value="{{ old('username') }}" class="input">
            @error('username') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label>Email</label>
            <input name="email" type="email" value="{{ old('email') }}" class="input">
            @error('email') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label>Password</label>
            <input name="password" type="password" class="input">
            @error('password') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label>Confirm Password</label>
            <input name="password_confirmation" type="password" class="input">
        </div>

        <div class="mb-4">
            <label>Role</label>
            <select name="role" class="input">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <div class="mb-4">
            <label>Avatar</label>
            <input type="file" name="avatar" class="input">
        </div>

        <button class="btn">Create User</button>
    </form>
</x-layout>