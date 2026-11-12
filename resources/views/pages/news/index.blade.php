@extends('layouts.app')
@section('title', 'Berita & Cerita — YISI')
@section('content')
    @if ($heroPosts->isNotEmpty())
        <section class="relative" data-hero-carousel>
            <div class="relative overflow-hidden">
                <div class="flex transition-transform duration-700 ease-out" data-hero-track>
                    @foreach ($heroPosts as $post)
                        <a href="{{ route('news.show', $post) }}" class="relative flex h-[70vh] min-h-[420px] w-full shrink-0 items-end no-underline" data-hero-slide>
                            @if ($post->coverMedia && $post->coverMedia->consent_ok && str_starts_with($post->coverMedia->mime_type, 'image/'))
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($post->coverMedia->url) }}" alt="{{ $post->coverMedia->alt_text }}" class="absolute inset-0 h-full w-full object-cover" loading="{{ $loop->first ? 'eager' : 'lazy' }}" decoding="async">
                            @else
                                <div class="soft-grid absolute inset-0 bg-[#eaf0e7]"></div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0c3f2b]/90 via-[#0c3f2b]/40 to-transparent"></div>
                            <div class="container-wide relative pb-10 sm:pb-14">
                                <p class="text-xs font-bold uppercase tracking-[.16em] text-[#f2b01e]">{{ $post->category?->name ?? 'Jurnal YISI' }} · {{ $post->published_at?->translatedFormat('d F Y') }}</p>
                                <h2 class="serif mt-3 line-clamp-2 max-w-4xl text-3xl leading-tight text-white sm:text-6xl">{{ $post->title }}</h2>
                                @if ($post->excerpt)<p class="mt-4 hidden max-w-2xl text-base leading-7 text-white/80 sm:block">{{ $post->excerpt }}</p>@endif
                            </div>
                        </a>
                    @endforeach
                </div>
                @if ($heroPosts->count() > 1)
                    <button type="button" data-hero-prev class="absolute left-4 top-1/2 z-10 grid h-11 w-11 -translate-y-1/2 place-items-center rounded-full bg-white/85 text-[#17633f] shadow transition hover:bg-white" aria-label="Sebelumnya"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="m15 18-6-6 6-6"/></svg></button>
                    <button type="button" data-hero-next class="absolute right-4 top-1/2 z-10 grid h-11 w-11 -translate-y-1/2 place-items-center rounded-full bg-white/85 text-[#17633f] shadow transition hover:bg-white" aria-label="Berikutnya"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="m9 18 6-6-6-6"/></svg></button>
                    <div class="absolute bottom-4 right-6 z-10 flex items-center gap-2" data-hero-dots>
                        @foreach ($heroPosts as $index => $post)
                            <button type="button" data-hero-dot class="h-2 w-2 rounded-full bg-white opacity-50 transition-all" aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    @endif
    <section class="section-pad"><div class="container-wide">
        <form method="GET" action="{{ route('news.index') }}" class="mb-7 flex flex-col gap-3 rounded-2xl border border-[#e2e7df] bg-white p-4 sm:flex-row">
            <label class="sr-only" for="q">Cari artikel</label><input id="q" name="q" value="{{ request('q') }}" placeholder="Cari berita atau cerita..." class="focus-ring min-w-0 flex-1 rounded-xl border border-[#dce3da] px-4 py-3 text-sm">
            <label class="sr-only" for="category">Kategori</label><select id="category" name="category" class="focus-ring rounded-xl border border-[#dce3da] bg-white px-4 py-3 text-sm"><option value="">Semua kategori</option>@foreach ($categories as $category)<option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>@endforeach</select>
            <label class="sr-only" for="tag">Tag</label><select id="tag" name="tag" class="focus-ring rounded-xl border border-[#dce3da] bg-white px-4 py-3 text-sm"><option value="">Semua tag</option>@foreach ($tags as $tag)<option value="{{ $tag->slug }}" @selected(request('tag') === $tag->slug)>{{ $tag->name }}</option>@endforeach</select>
            <button class="focus-ring rounded-xl bg-[#17633f] px-5 py-3 text-sm font-bold text-white">Cari artikel</button>
        </form>
        @if ($posts->isNotEmpty())<div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">@foreach ($posts as $post)<x-post-card :post="$post" />@endforeach</div><div class="mt-7">{{ $posts->links() }}</div>@else<div class="rounded-[1.5rem] border border-dashed border-[#c5cec3] px-6 py-10 text-center"><p class="serif text-3xl text-[#25392e]">Belum ada artikel yang diterbitkan.</p><p class="mt-3 text-sm text-[#64736b]">Kabar dan cerita YISI akan muncul di sini setelah melalui proses editorial.</p></div>@endif
    </div></section>
@endsection
