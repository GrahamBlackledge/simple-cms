<x-layout>
    <div class="section-heading">
        <h1 class="title">
            {{ $user->username }}'s Inspirations
        </h1>

        <p class="page-subtitle">
            {{ $posts->total() }} saved thoughts, ideas, and moments.
        </p>
    </div>

    <div class="post-grid">
        @foreach ($posts as $post)
            <x-post-card :post="$post" />
        @endforeach
    </div>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>
</x-layout>