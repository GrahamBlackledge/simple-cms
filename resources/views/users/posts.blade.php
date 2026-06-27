<x-layout>
    <h1 class="title">
        {{ $user->username }}'s Posts — {{ $posts->total() }}
    </h1>

    <div class="grid grid-cols-2 gap-6">
        @foreach ($posts as $post)
            <x-postCard :post="$post" />
        @endforeach
    </div>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>
</x-layout>