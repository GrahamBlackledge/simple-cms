<x-layout>
    <x-brand-hero />

    <div class="section-heading">
        <h2 class="title">Latest Inspirations</h2>

        <p class="page-subtitle">
            Browse recent thoughts, images, and moments shared by the Life Post community.
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