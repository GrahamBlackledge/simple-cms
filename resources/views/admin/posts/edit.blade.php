<x-layout>
    <a href="{{ route('admin.posts.index') }}" class="block mb-4 text-xs text-blue-500">
        &larr; Back to posts
    </a>

    <h1 class="title">Admin Edit Post</h1>

    <form action="{{ route('admin.posts.update', $post) }}" method="post" enctype="multipart/form-data" class="card">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label>Post Title</label>
            <input name="title" value="{{ old('title', $post->title) }}" class="input">
            @error('title') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label>Post Content</label>
            <textarea name="body" rows="5" class="input">{{ old('body', $post->body) }}</textarea>
            @error('body') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label>Filter</label>
            <select name="filter" class="input">
                <option value="">No filter</option>
                <option value="warm" @selected($post->filter === 'warm')>Warm</option>
                <option value="cool" @selected($post->filter === 'cool')>Cool</option>
                <option value="black-white" @selected($post->filter === 'black-white')>Black and white</option>
            </select>
        </div>

        @if ($post->image)
            <div class="mb-4">
                <label>Current featured image</label>
                <img src="{{ asset('storage/' . $post->image) }}" alt="" class="rounded-md mt-2 max-h-64">
            </div>
        @endif

        <div class="mb-4">
            <label>Featured image</label>
            <input type="file" name="image">
            @error('image') <p class="error">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label>Author</label>
            <select name="user_id" class="input">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @selected($post->user_id === $user->id)>
                        {{ $user->username }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn">Update</button>
    </form>
</x-layout>