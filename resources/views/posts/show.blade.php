<x-layout>
    <a href="{{ route('posts.index') }}" class="block mb-4 text-xs text-blue-500">
        &larr; Back to posts
    </a>

    <x-postCard :post="$post" full />
</x-layout>