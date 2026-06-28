<x-layout>
    <a href="{{ route('dashboard') }}" class="block mb-4 text-xs text-blue-500">
        &larr; Go back to your dashboard
    </a>

    <div class="card">
        <h1 class="title">Update your inspiration</h1>

        <form action="{{ route('posts.update', $post) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title">Title</label>
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
                <label for="body">Reflection</label>
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
                <label for="filter">Category</label>

                <select name="filter" class="input">
                    <option value="">No category</option>
                    <option value="quote" @selected(old('filter', $post->filter) === 'quote')>Quote</option>
                    <option value="reflection" @selected(old('filter', $post->filter) === 'reflection')>Reflection</option>
                    <option value="goal" @selected(old('filter', $post->filter) === 'goal')>Goal</option>
                    <option value="memory" @selected(old('filter', $post->filter) === 'memory')>Memory</option>
                    <option value="idea" @selected(old('filter', $post->filter) === 'idea')>Idea</option>
                    <option value="lesson" @selected(old('filter', $post->filter) === 'lesson')>Lesson</option>
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