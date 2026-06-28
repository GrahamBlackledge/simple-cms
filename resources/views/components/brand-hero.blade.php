@props([
    'title' => 'Life Post',
    'subtitle' => 'Remember what inspires you.',
])

<section class="hero-panel">
    <div class="hero-icon" aria-hidden="true">
        <span class="hero-ampersand">&amp;</span>
    </div>

    <h1 class="hero-title">{{ $title }}</h1>

    <p class="hero-subtitle">{{ $subtitle }}</p>

   
</section>