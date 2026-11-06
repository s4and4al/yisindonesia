@extends('layouts.app')
@section('title', 'Tim & Tata Kelola — YISI')
@section('content')
    <section class="bg-[#eaf0e7] py-12 sm:py-16"><div class="container-wide"><p class="eyebrow">Tim & tata kelola</p><h1 class="serif mt-5 max-w-4xl text-5xl leading-[1.04] text-[#143d2b] sm:text-7xl">Orang-orang di balik kerja bersama.</h1><p class="mt-6 max-w-2xl text-lg leading-8 text-[#52645a]">YISI bekerja melalui tata kelola yayasan dan tim program yang berkolaborasi bersama mitra serta komunitas.</p></div></section>
    <section class="section-pad"><div class="container-wide">
        @if ($members->isNotEmpty())
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($members as $member)
                    <article class="rounded-[1.5rem] border border-[#e2e7df] bg-white p-7">
                        @if ($member->photo && $member->photo->consent_ok && str_starts_with($member->photo->mime_type, 'image/'))
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($member->photo->url) }}" alt="{{ $member->photo->alt_text }}" loading="lazy" decoding="async" class="h-16 w-16 rounded-full object-cover">
                        @else
                            <div class="grid h-16 w-16 place-items-center rounded-full bg-[#eaf0e7] font-bold text-[#17633f]" aria-hidden="true">{{ collect(explode(' ', $member->name))->take(2)->map(fn ($part) => mb_substr($part, 0, 1))->join('') }}</div>
                        @endif
                        <p class="eyebrow mt-6">{{ $member->group_name }}{{ $member->division ? ' · '.$member->division : '' }}</p>
                        <h2 class="serif mt-2 text-2xl">{{ $member->name }}</h2>
                        <p class="mt-1 text-sm font-semibold text-[#17633f]">{{ $member->position }}</p>
                        @if ($member->bio)<p class="mt-4 text-sm leading-6 text-[#62716a]">{{ $member->bio }}</p>@endif
                    </article>
                @endforeach
            </div>
        @else
            <div class="mx-auto max-w-2xl rounded-[1.7rem] border border-dashed border-[#c5cec3] px-7 py-10 text-center">
                <p class="eyebrow">Informasi sedang disiapkan</p>
                <h2 class="serif mt-4 text-3xl">Struktur tim akan segera diperbarui.</h2>
                <p class="mt-3 text-sm leading-6 text-[#64736b]">Nama dan jabatan akan ditampilkan setelah mendapat persetujuan resmi dari YISI.</p>
            </div>
        @endif
    </div></section>
@endsection
