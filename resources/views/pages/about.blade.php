@extends('layouts.app')
@section('title', 'Tentang YISI — Investasi Sosial Indonesia')
@section('description', 'Kenali latar belakang, visi, nilai, dan cara kerja Yayasan Investasi Sosial Indonesia.')
@section('content')
    <section class="bg-[#eaf0e7] py-12 sm:py-16">
        <div class="container-wide">
            <p class="eyebrow">Tentang YISI</p>
            <h1 class="serif mt-5 max-w-4xl text-5xl leading-[1.04] text-[#143d2b] sm:text-7xl">Mendampingi perubahan yang <em class="font-normal text-[#a3131b]">dimiliki</em> komunitas.</h1>
            <p class="mt-7 max-w-2xl text-lg leading-8 text-[#52645a]">Yayasan Investasi Sosial Indonesia hadir untuk memperkuat inisiatif lokal dan membangun ekosistem komunitas yang mandiri, inklusif, serta tangguh.</p>
        </div>
    </section>
    <section class="section-pad">
        <div class="container-wide grid gap-9 lg:grid-cols-[.75fr_1.25fr]">
            <div><p class="eyebrow">Mengapa YISI ada</p><h2 class="serif mt-4 text-4xl leading-tight">Ketahanan berawal dari kekuatan yang telah ada.</h2></div>
            <div class="prose-yisi">
                <p>YISI adalah yayasan yang berkedudukan di Kabupaten Pasuruan, Jawa Timur, dengan kantor program di Situbondo. Sejak berdiri secara hukum pada 7 April 2015, YISI bekerja bersama masyarakat dan mitra untuk menjawab tantangan sosial dan lingkungan.</p>
                <p>Kami percaya bahwa perubahan yang bertahan lama tumbuh melalui proses yang partisipatif: mendengar pengalaman warga, menghargai pengetahuan lokal, dan menghubungkan komunitas dengan sumber daya serta jejaring yang relevan.</p>
                <p>Kerja YISI berfokus pada tiga pilar yang saling terkait: ekonomi inklusif dan berkeadilan, lingkungan regeneratif dan tangguh bencana, serta pendidikan emansipatoris dan siaga bencana.</p>
            </div>
        </div>
    </section>
    <section class="section-pad bg-[#f0f1e8]">
        <div class="container-wide grid gap-8 md:grid-cols-2">
            <article class="rounded-[1.7rem] bg-[#17633f] p-8 text-white sm:p-10"><p class="text-xs font-bold uppercase tracking-[.16em] text-[#f2d27e]">Visi</p><h2 class="serif mt-5 text-3xl leading-snug sm:text-4xl">Masyarakat yang inklusif, mandiri, dan tangguh tumbuh dari kekuatan komunitasnya.</h2></article>
            <article class="rounded-[1.7rem] bg-white p-8 sm:p-10"><p class="eyebrow">Cara kerja</p><h2 class="serif mt-5 text-3xl leading-snug sm:text-4xl">Membangun bersama, bukan menggantikan.</h2><p class="mt-5 leading-7 text-[#62716a]">Kami menghubungkan pengetahuan lokal, pembelajaran, dan kolaborasi lintas sektor untuk menumbuhkan solusi yang sesuai konteks serta dapat dilanjutkan oleh komunitas.</p></article>
        </div>
    </section>
    <section class="section-pad"><div class="container-wide"><x-section-heading eyebrow="Nilai yang dijaga" title="Inklusif, partisipatif, dan berakar." /><div class="mt-7 grid gap-5 md:grid-cols-3">@foreach ([['01', 'Inklusif', 'Membuka ruang bagi keberagaman, akses yang setara, dan suara kelompok yang kerap tidak terwakili.'], ['02', 'Partisipatif', 'Menempatkan masyarakat sebagai pengambil peran dan pemilik proses perubahan.'], ['03', 'Kontekstual', 'Menghargai kearifan lokal dan merancang kerja sesuai kebutuhan serta kondisi setempat.']] as [$number, $title, $text])<div class="border-t-2 border-[#f2b01e] pt-5"><span class="text-xs font-black text-[#a3131b]">{{ $number }}</span><h3 class="serif mt-3 text-2xl">{{ $title }}</h3><p class="mt-3 text-sm leading-6 text-[#62716a]">{{ $text }}</p></div>@endforeach</div></div></section>
@endsection
