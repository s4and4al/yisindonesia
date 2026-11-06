@extends('layouts.app')
@section('title', 'Legalitas & Transparansi — YISI')
@section('content')
    <section class="bg-[#eaf0e7] py-12 sm:py-16"><div class="container-wide"><p class="eyebrow">Legalitas & transparansi</p><h1 class="serif mt-5 max-w-4xl text-5xl leading-[1.04] text-[#143d2b] sm:text-7xl">Terbuka tentang identitas dan tata kelola kami.</h1><p class="mt-6 max-w-2xl text-lg leading-8 text-[#52645a]">Informasi legal dan dokumen publik YISI disediakan agar mitra dan masyarakat dapat mengenal lembaga secara lebih baik.</p></div></section>
    <section class="section-pad"><div class="container-wide grid gap-8 lg:grid-cols-[.8fr_1.2fr]">
        <div><p class="eyebrow">Identitas yayasan</p><h2 class="serif mt-4 text-3xl">Data kelembagaan</h2></div>
        <dl class="divide-y divide-[#e2e7df] rounded-2xl border border-[#e2e7df] bg-white px-6">
            @foreach ($identity as $item)<div class="grid gap-1 py-5 sm:grid-cols-[.8fr_1.2fr] sm:gap-5"><dt class="text-sm font-semibold text-[#718078]">{{ $item->label }}</dt><dd class="text-sm font-bold text-[#25392e]">{{ $item->value }}</dd></div>@endforeach
        </dl>
    </div></section>
    <section class="bg-[#f0f1e8] py-10"><div class="container-wide"><p class="eyebrow">Dokumen publik</p><h2 class="serif mt-4 text-3xl">Laporan, kajian, dan dokumen lembaga.</h2>
        @if ($documents->isNotEmpty())<div class="mt-8 grid gap-4 sm:grid-cols-2">@foreach ($documents as $document)<a href="{{ \Illuminate\Support\Facades\Storage::url($document->url) }}" class="focus-ring flex items-center justify-between gap-5 rounded-2xl bg-white p-5 no-underline hover:shadow-md"><span><strong class="block">{{ $document->title }}</strong><small class="mt-1 block text-[#718078]">{{ $document->doc_type }}{{ $document->year ? ' · '.$document->year : '' }}</small></span><span class="text-xl text-[#a3131b]" aria-hidden="true">↓</span></a>@endforeach</div>@else<p class="mt-5 max-w-xl text-sm leading-6 text-[#64736b]">Dokumen yang telah disetujui untuk publikasi akan tersedia di sini.</p>@endif
    </div></section>
@endsection
