<x-layout>
    <div class="section-heading">
        <h1 class="title">Welcome back, {{ auth()->user()->username }}</h1>
            <p class="page-subtitle">
                Capture a new thought, image, or idea that inspired you today.
            </p>
    </div>

    <div class="card mb-6">
        <h2 class="font-bold mb-4">Capture a new inspiration</h2>

        @if (session('success'))
            <<x-flash-msg msg="{{ session('success') }}" />
        @elseif (session('delete'))
            <x-flash-msg msg="{{ session('delete') }}" bg="bg-red-500" />
        @endif

        <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="title">Title</label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title') }}"
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
                >{{ old('body') }}</textarea>

                @error('body')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="filter">Category</label>

                <select name="filter" class="input">
                    <option value="">No category</option>
                    <option value="quote">Quote</option>
                    <option value="reflection">Reflection</option>
                    <option value="goal">Goal</option>
                    <option value="memory">Memory</option>
                    <option value="idea">Idea</option>
                    <option value="lesson">Lesson</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="image">Featured image</label>
                <input type="file" name="image" id="image">

                @error('image')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <button class="btn">Save Inspiration</button>
        </form>
    </div>

    <h2 class="font-bold mb-4">Your Saved Inspirations</h2>

    <div class="grid grid-cols-2 gap-6">
        @foreach ($posts as $post)
            <x-post-card :post="$post">
                <a
                    href="{{ route('posts.edit', $post) }}"
                    class="bg-green-500 text-white px-2 py-1 text-xs rounded-md"
                >
                    Update
                </a>

                <form action="{{ route('posts.destroy', $post) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button class="bg-red-500 text-white px-2 py-1 text-xs rounded-md">
                        Delete
                    </button>
                </form>
            </x-post-card>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>
</x-layout>