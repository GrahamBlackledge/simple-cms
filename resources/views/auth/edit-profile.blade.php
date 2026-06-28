<x-layout>
    <h1 class="title">Edit Profile</h1>

    <div class="mx-auto max-w-screen-sm card">
        @if (session('success'))
            <x-flash-msg msg="{{ session('success') }}" />
        @endif

        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="username">Username</label>
                <input
                    type="text"
                    name="username"
                    value="{{ old('username', $user->username) }}"
                    class="input @error('username') ring-red-500 @enderror"
                >

                @error('username')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email">Email</label>
                <input
                    type="text"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    class="input @error('email') ring-red-500 @enderror"
                >

                @error('email')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password">New Password</label>
                <input type="password" name="password" class="input">

                @error('password')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" class="input">
            </div>

            <div class="mb-6">
                <label for="avatar">Profile Image</label>
                <input type="file" name="avatar" class="input">

                @if ($user->avatar)
                    <img
                        src="{{ asset('storage/' . $user->avatar) }}"
                        class="w-16 h-16 rounded-full mt-2 object-cover"
                        alt="Profile image"
                    >
                @endif

                @error('avatar')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <button class="btn">Update Profile</button>
        </form>
    </div>
</x-layout>