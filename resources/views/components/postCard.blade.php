@props(['post', 'full' => false])

<div class="card">
    <h2 class="font-bold text-xl mb-4">{{ $post->title }}</h2>

    <div class="h-52 rounded-md mb-4 w-full object-cover overflow-hidden">
        @if ($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" alt="" class="w-full h-full object-cover">
        @else
            <img src="{{ asset('img/avatar5.png') }}" alt="" class="w-full h-full object-cover">
        @endif
    </div>

    <div class="text-xs mb-2">
        <span>Posted {{ $post->created_at->diffForHumans() }} by</span>

        <a href="{{ route('posts.user', $post->user) }}" class="text-blue-500 font-medium">
            {{ $post->user->username }}
        </a>
    </div>

    @if ($post->filter)
        <p class="text-xs text-slate-500 mb-2">
            Filter: {{ $post->filter }}
        </p>
    @endif

    @if ($full)
        <div class="text-sm">
            <p>{{ $post->body }}</p>
        </div>
    @else
        <div class="text-sm">
            <p>{{ Str::words($post->body, 15) }}</p>

            <a href="{{ route('posts.show', $post) }}" class="text-blue-500">
                Read more &rarr;
            </a>
        </div>
    @endif

    <div class="flex items-center justify-end gap-4 mt-6">
        {{ $slot }}
    </div>
</div>