<x-layout>
    <a href="{{ route('dashboard') }}" class="block mb-4 text-xs text-blue-500">
        &larr; Go back to your dashboard
    </a>

    <div class="card">
        <h1 class="title">Update your post</h1>

        <form action="{{ route('posts.update', $post) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title">Post Title</label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title', $post->title) }}"
                    class="input @error('title') ring-red-500 @enderror"
                >

                @error('title')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="body">Post Content</label>
                <textarea
                    name="body"
                    rows="5"
                    class="input @error('body') ring-red-500 @enderror"
                >{{ old('body', $post->body) }}</textarea>

                @error('body')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="filter">Filter</label>
                <select name="filter" class="input">
                    <option value="">No filter</option>
                    <option value="warm" @selected(old('filter', $post->filter) === 'warm')>Warm</option>
                    <option value="cool" @selected(old('filter', $post->filter) === 'cool')>Cool</option>
                    <option value="black-white" @selected(old('filter', $post->filter) === 'black-white')>Black and white</option>
                </select>
            </div>

            @if ($post->image)
                <div class="mb-4">
                    <label>Current featured image</label>
                    <img src="{{ asset('storage/' . $post->image) }}" alt="" class="rounded-md mt-2 max-h-64">
                </div>
            @endif

            <div class="mb-4">
                <label for="image">Replace featured image</label>
                <input type="file" name="image" id="image">

                @error('image')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <button class="btn">Update</button>
        </form>
    </div>
</x-layout>