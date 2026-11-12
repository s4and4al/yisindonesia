@extends('layouts.app')
@section('title', 'Tim & Tata Kelola — YISI')
@section('content')
    <section class="w-full bg-[#f8f8f3] py-10 sm:py-14">
        @if ($members->isNotEmpty())
            <div data-team-carousel role="region" aria-roledescription="carousel" aria-label="Tim Yayasan Investasi Sosial Indonesia" class="w-full">
                <header class="mx-auto max-w-2xl text-center">
                    <p class="eyebrow">Tim & tata kelola</p>
                    <h1 class="serif mt-4 text-4xl leading-tight text-[#172821] sm:text-5xl">Orang-orang di balik kerja bersama.</h1>
                    <p class="mt-4 text-sm leading-6 text-[#62716a] sm:text-base">YISI bekerja melalui tata kelola yayasan dan tim program yang berkolaborasi bersama mitra serta komunitas.</p>
                </header>

                <div class="team-carousel__viewport mt-10 sm:mt-12" data-team-viewport tabindex="0" aria-label="Anggota tim YISI">
                    <div class="team-carousel__track" data-team-track>
                        @foreach ($members as $member)
                            <article data-team-slide @class([
                                'team-carousel__slide',
                                'is-active' => $loop->first,
                            ]) role="group" aria-roledescription="slide" aria-label="{{ $loop->iteration }} dari {{ $loop->count }}" aria-current="{{ $loop->first ? 'true' : 'false' }}">
                                <div class="team-carousel__portrait">
                                    @if ($member->photo && $member->photo->consent_ok && str_starts_with($member->photo->mime_type, 'image/'))
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($member->photo->url) }}" alt="{{ $member->photo->alt_text ?: $member->name }}" loading="lazy" decoding="async">
                                    @else
                                        <div class="grid h-full w-full place-items-center bg-[#eaf0e7] text-3xl font-bold text-[#17633f]" aria-hidden="true">{{ collect(explode(' ', $member->name))->take(2)->map(fn ($part) => mb_substr($part, 0, 1))->join('') }}</div>
                                    @endif
                                </div>
                                <div class="team-carousel__details">
                                    <p class="text-xs font-bold uppercase tracking-[.12em] text-[#17633f]">{{ $member->group_name }}{{ $member->division ? ' · '.$member->division : '' }}</p>
                                    <h2 class="serif mt-2 text-xl font-semibold text-[#172821]">{{ $member->name }}</h2>
                                    <p class="mt-1 text-sm font-medium text-[#62716a]">{{ $member->position }}</p>
                                    @if ($member->bio)
                                        <p class="mt-3 line-clamp-3 text-sm leading-6 text-[#62716a]">{{ $member->bio }}</p>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>

                @if ($members->count() > 1)
                    <div class="mt-8 flex items-center justify-between gap-5 px-4 sm:mt-10 sm:px-8 lg:px-14">
                        <div class="h-px flex-1 bg-[#e8ebe6]" role="progressbar" aria-label="Posisi anggota yang ditampilkan" aria-valuemin="1" aria-valuemax="{{ $members->count() }}" aria-valuenow="1" data-team-progress>
                            <span class="team-carousel__progress-fill block h-full w-0"></span>
                        </div>
                        <div class="flex shrink-0 gap-2">
                            <button type="button" class="focus-ring grid h-10 w-10 place-items-center rounded-full bg-[#172821] text-white transition hover:bg-[#17633f] disabled:cursor-not-allowed disabled:opacity-40" data-team-prev aria-label="Tampilkan anggota sebelumnya">
                                <svg aria-hidden="true" viewBox="0 0 20 20" fill="none" class="h-4 w-4"><path d="m12 4-6 6 6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                            <button type="button" class="focus-ring grid h-10 w-10 place-items-center rounded-full bg-[#172821] text-white transition hover:bg-[#17633f] disabled:cursor-not-allowed disabled:opacity-40" data-team-next aria-label="Tampilkan anggota berikutnya">
                                <svg aria-hidden="true" viewBox="0 0 20 20" fill="none" class="h-4 w-4"><path d="m8 4 6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        @else
            <div class="mx-auto max-w-2xl px-5 py-12 text-center">
                <p class="eyebrow">Tim & tata kelola</p>
                <h1 class="serif mt-4 text-3xl text-[#172821] sm:text-4xl">Struktur tim akan segera diperbarui.</h1>
                <p class="mt-3 text-sm leading-6 text-[#64736b]">Nama dan jabatan akan ditampilkan setelah mendapat persetujuan resmi dari YISI.</p>
            </div>
        @endif
    </section>
@endsection
