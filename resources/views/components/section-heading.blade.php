@props(['eyebrow', 'title', 'description' => null, 'center' => false])

<div class="{{ $center ? 'mx-auto text-center' : '' }} max-w-2xl">
    <p class="eyebrow">{{ $eyebrow }}</p>
    <h2 class="serif mt-4 text-4xl leading-[1.08] text-[#172821] sm:text-5xl">{{ $title }}</h2>
    @if ($description)
        <p class="mt-5 text-base leading-7 text-[#64736b]">{{ $description }}</p>
    @endif
</div>
