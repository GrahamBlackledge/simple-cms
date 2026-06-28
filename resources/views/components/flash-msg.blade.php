@props(['msg', 'bg' => 'bg-green-600'])

<p class="mb-3 text-sm font-medium text-white px-4 py-2 rounded-xl {{ $bg }}">
    {{ $msg }}
</p>