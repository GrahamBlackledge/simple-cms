<x-layout>
    <section class="mb-6">
        <h1 class="title">JavaScript CMS Publishing App</h1>
        <p class="text-sm text-slate-600">
            This page uses JavaScript fetch requests to process REST API JSON data.
        </p>
    </section>

    <section class="card mb-6">
        <h2 class="font-bold mb-4">Create image post</h2>

        <div id="api-message" class="mb-4 hidden"></div>

        <form id="api-post-form" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="api-title">Title</label>
                <input id="api-title" name="title" type="text" class="input">
                <p id="title-error" class="error hidden"></p>
            </div>

            <div class="mb-4">
                <label for="api-body">Description</label>
                <textarea id="api-body" name="body" rows="5" class="input"></textarea>
                <p id="body-error" class="error hidden"></p>
            </div>

            <div class="mb-4">
                <label for="api-filter">Filter</label>
                <select id="api-filter" name="filter" class="input">
                    <option value="">No filter</option>
                    <option value="warm">Warm</option>
                    <option value="cool">Cool</option>
                    <option value="black-white">Black and white</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="api-image">Featured image</label>
                <input id="api-image" name="image" type="file" accept=".jpg,.jpeg,.png,.webp">
                <p id="image-error" class="error hidden"></p>
            </div>

            <button class="btn" type="submit">Publish</button>
        </form>
    </section>

    <section>
        <div class="flex gap-4 mb-4">
            <button id="load-latest-posts" class="btn" type="button">Load latest posts</button>
            <button id="load-my-posts" class="btn" type="button">Load my posts</button>
        </div>

        <div id="posts-list" class="grid grid-cols-2 gap-6"></div>
    </section>

    @vite(['resources/js/cms-api.js'])
</x-layout>