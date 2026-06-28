<x-layout>
    <section class="mb-6">
        <h1 class="title">Life Post Publisher</h1>
        <p class="text-sm text-slate-600">
            This page uses JavaScript fetch requests to process REST API JSON data.
        </p>
    </section>

    <section class="card mb-6">
        <h2 class="font-bold mb-4">Capture a new inspiration</h2>

        <div id="api-message" class="mb-4 hidden"></div>

        <form id="api-post-form" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="api-title">Title</label>
                <input id="api-title" name="title" type="text" class="input">
                <p id="title-error" class="error hidden"></p>
            </div>

            <div class="mb-4">
                <label for="api-body">Reflection</label>
                <textarea id="api-body" name="body" rows="5" class="input"></textarea>
                <p id="body-error" class="error hidden"></p>
            </div>

            <div class="mb-4">
                <label for="api-filter">Category</label>

                <select id="api-filter" name="filter" class="input">
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
                <label for="api-image">Featured image</label>
                <input id="api-image" name="image" type="file" accept=".jpg,.jpeg,.png,.webp">
                <p id="image-error" class="error hidden"></p>
            </div>

            <button class="btn" type="submit">Save Inspiration</button>
        </form>
    </section>

    <section>
        <div class="flex gap-4 mb-4">
            <button id="load-latest-posts" class="btn" type="button">Load latest inspirations</button>
            <button id="load-my-posts" class="btn" type="button">Load my inspirations</button>
        </div>

        <div id="posts-list" class="grid grid-cols-2 gap-6"></div>
    </section>

    @vite(['resources/js/cms-api.js'])
</x-layout>