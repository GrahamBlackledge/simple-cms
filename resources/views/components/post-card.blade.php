@props(['post', 'full' => false])

<div class="card">
    {{-- Title --}}
    <h2 class="font-bold text-2xl mb-4 text-slate-950">
        {{ $post->title }}
    </h2>

    {{-- Featured image --}}
    @if ($post->image)
        <img
            src="{{ asset('storage/' . $post->image) }}"
            alt="Post image"
            class="{{ $full ? 'post-image-full' : 'post-image' }}"
        >
    @else
        <img
            src="{{ asset('img/avatar5.png') }}"
            alt="Default post image"
            class="{{ $full ? 'post-image-full' : 'post-image' }}"
        >
    @endif

    {{-- Author and date --}}
    <div class="post-meta">
        <span>Posted {{ $post->created_at->diffForHumans() }} by</span>

        @if ($post->user)
            <a href="{{ route('posts.user', $post->user) }}" class="post-link">
                {{ $post->user->username }}
            </a>
        @else
            <span>Unknown user</span>
        @endif
    </div>

    {{-- Category --}}
    @if ($post->filter)
        <p class="text-xs text-slate-500 mb-3">
            Category: {{ ucfirst($post->filter) }}
        </p>
    @endif

    {{-- Body --}}
    @if ($full)
        <div class="text-sm text-slate-700 leading-7 whitespace-pre-line">
            <p>{{ $post->body }}</p>
        </div>
    @else
        <div class="text-sm text-slate-700 leading-7">
            <p>{{ \Illuminate\Support\Str::words($post->body, 15) }}</p>

            <a href="{{ route('posts.show', $post) }}" class="post-link inline-block mt-3">
                Continue reading &rarr;
            </a>
        </div>
    @endif

    {{-- Optional update/delete buttons --}}
    <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
        {{ $slot }}
    </div>
</div>