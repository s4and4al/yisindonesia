@props(['post'])

<article class="group flex h-full flex-col overflow-hidden rounded-[1.6rem] border border-[#e2e7df] bg-white transition hover:-translate-y-1 hover:shadow-xl hover:shadow-[#173d2b]/[.08]">
    <a href="{{ route('news.show', $post) }}" class="focus-ring soft-grid relative flex min-h-48 items-end bg-[#f0eadb] p-5 no-underline" aria-label="Baca cerita: {{ $post->title }}">
        @if ($post->coverMedia && $post->coverMedia->consent_ok && str_starts_with($post->coverMedia->mime_type, 'image/'))
            <img src="{{ \Illuminate\Support\Facades\Storage::url($post->coverMedia->url) }}" alt="{{ $post->coverMedia->alt_text }}" loading="lazy" decoding="async" class="absolute inset-0 h-full w-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-[#103d2b]/75 via-transparent to-transparent"></div>
        @else
            <div class="absolute -right-3 -top-10 h-36 w-36 rotate-12 rounded-[2rem] bg-[#a3131b]/10"></div>
            <div class="absolute right-14 top-9 h-20 w-20 rounded-full bg-[#f2b01e]/50"></div>
        @endif
        <span class="relative rounded-full bg-white/85 px-3 py-1.5 text-xs font-bold text-[#17633f]">{{ $post->category?->name ?? 'Cerita YISI' }}</span>
    </a>
    <div class="flex flex-1 flex-col p-6">
        <p class="text-xs font-semibold text-[#7b8981]">{{ $post->published_at?->translatedFormat('d F Y') }}</p>
        <h3 class="serif mt-3 text-2xl leading-tight group-hover:text-[#17633f]">
            <a class="no-underline" href="{{ route('news.show', $post) }}">{{ $post->title }}</a>
        </h3>
        <p class="mt-3 line-clamp-3 text-sm leading-6 text-[#66746d]">{{ $post->excerpt }}</p>
        <div class="mt-auto flex items-center justify-between gap-3 pt-6">
            <a class="focus-ring inline-flex w-fit items-center rounded-full bg-[#17633f] px-4 py-2 text-sm font-bold text-white no-underline transition hover:-translate-y-0.5 hover:bg-[#0f4d30]" href="{{ route('news.show', $post) }}">Baca cerita <span class="ml-2" aria-hidden="true">↗</span></a>
            <x-share-buttons :url="route('news.show', $post)" :title="$post->title" />
        </div>
    </div>
</article>
