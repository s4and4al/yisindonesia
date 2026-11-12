@extends('layouts.app')
@section('title', ($post->seo_title ?: $post->title).' — YISI')
@section('description', $post->seo_description ?: ($post->excerpt ?? ''))
@section('og_type', 'article')
@if ($post->coverMedia && $post->coverMedia->consent_ok && str_starts_with($post->coverMedia->mime_type, 'image/'))
    @section('og_image', \Illuminate\Support\Facades\Storage::disk('public')->url($post->coverMedia->url))
@endif
@section('content')
    <article>
        <header class="bg-[#eaf0e7] py-10 sm:py-14"><div class="container-wide max-w-4xl"><a href="{{ route('news.index') }}" class="text-sm font-bold text-[#17633f] no-underline">← Semua berita</a><p class="eyebrow mt-7">{{ $post->category?->name ?? 'Jurnal YISI' }} · {{ $post->published_at?->translatedFormat('d F Y') }}</p><h1 class="serif mt-4 text-4xl leading-[1.05] text-[#143d2b] sm:text-5xl">{{ $post->title }}</h1>@if ($post->excerpt)<p class="mt-6 text-xl leading-8 text-[#52645a]">{{ $post->excerpt }}</p>@endif@if ($post->coverMedia && $post->coverMedia->consent_ok && str_starts_with($post->coverMedia->mime_type, 'image/'))<img src="{{ \Illuminate\Support\Facades\Storage::url($post->coverMedia->url) }}" alt="{{ $post->coverMedia->alt_text }}" class="mt-7 max-h-[480px] w-full rounded-[1.7rem] object-cover" fetchpriority="high">@endif</div></header>
        <div class="container-wide grid gap-8 py-10 lg:grid-cols-[minmax(0,760px)_240px] lg:justify-center">
            <div class="prose-yisi">@foreach ($post->tags as $tag)<a href="{{ route('news.index', ['tag' => $tag->slug]) }}" class="mr-2 inline-flex rounded-full bg-[#eaf0e7] px-3 py-1 text-xs font-bold text-[#17633f] no-underline">{{ $tag->name }}</a>@endforeach<div class="mt-7">{!! str($post->content)->markdown(['html_input' => 'strip', 'allow_unsafe_links' => false, 'attributes' => ['allow' => ['width']]], [new \League\CommonMark\Extension\Attributes\AttributesExtension()]) !!}</div></div>
            <aside class="h-fit rounded-2xl bg-[#f0f1e8] p-6"><p class="eyebrow">Bagikan cerita</p><p class="mt-3 text-sm leading-6 text-[#62716a]">Sebarkan pembelajaran ini kepada jejaring Anda.</p><x-share-buttons class="mt-5" :url="request()->fullUrl()" :title="$post->title" /><button type="button" onclick="navigator.clipboard.writeText(window.location.href).then(() => this.textContent = 'Tautan tersalin')" class="focus-ring mt-4 w-full rounded-xl border border-[#cad5c9] bg-white px-4 py-3 text-sm font-bold text-[#17633f]">Salin tautan</button></aside>
        </div>
    </article>
    @if ($relatedPosts->isNotEmpty())<section class="section-pad bg-[#eaf0e7]"><div class="container-wide"><x-section-heading eyebrow="Lanjutkan membaca" title="Cerita lainnya."/><div class="mt-7 grid gap-5 md:grid-cols-3">@foreach ($relatedPosts as $related)<x-post-card :post="$related" />@endforeach</div></div></section>@endif
@endsection
