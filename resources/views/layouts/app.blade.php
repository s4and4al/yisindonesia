<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f8f8f3">
    <meta name="description" content="@yield('description', 'Yayasan Investasi Sosial Indonesia — membangun ketahanan komunitas melalui ekonomi inklusif, lingkungan regeneratif, dan pendidikan emansipatoris.')">
    <meta property="og:site_name" content="YISI">
    <meta property="og:locale" content="id_ID">
    <meta property="og:title" content="@yield('title', 'YISI — Investasi Sosial Indonesia')">
    <meta property="og:description" content="@yield('description', 'Bersama komunitas, menumbuhkan masa depan yang tangguh dan inklusif.')">
    <meta property="og:type" content="@yield('og_type', 'website')">
    @if (request()->routeIs('news.show'))
        <link rel="alternate" type="application/rss+xml" title="RSS Berita YISI" href="{{ route('news.feed') }}">
    @endif
    @if (request()->routeIs('news.index'))
        <link rel="alternate" type="application/rss+xml" title="RSS Berita YISI" href="{{ route('news.feed') }}">
    @endif
    <link rel="canonical" href="{{ url()->current() }}">
    <script type="application/ld+json">{"@@context":"https://schema.org","@type":"Organization","name":"Yayasan Investasi Sosial Indonesia","alternateName":"YISI","url":"{{ url('/') }}"}</script>
    <title>@yield('title', 'YISI — Investasi Sosial Indonesia')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body>
    <a href="#main" class="focus-ring sr-only fixed left-4 top-4 z-50 rounded-lg bg-white px-4 py-3 text-sm font-bold shadow-lg focus:not-sr-only">Lewati ke konten</a>
    <header class="relative z-20 border-b border-[#e3e7de] bg-[#f8f8f3]/95">
        <div class="container-wide flex min-h-[82px] items-center justify-between gap-6">
            <a href="{{ route('home') }}" class="focus-ring flex items-center gap-3 rounded-md no-underline" aria-label="YISI, halaman utama">
                <span class="relative grid h-11 w-11 place-items-center rounded-full bg-[#17633f] text-sm font-black tracking-tight text-white">
                    Y<span class="absolute -right-1 -top-1 h-3 w-3 rounded-full bg-[#f2b01e]"></span>
                </span>
                <span class="leading-tight">
                    <span class="block text-lg font-extrabold tracking-[-.04em]">YISI</span>
                    <span class="block text-[.61rem] font-semibold tracking-[.12em] text-[#65736b]">INVESTASI SOSIAL INDONESIA</span>
                </span>
            </a>
            <nav class="hidden items-center gap-2 text-[.88rem] font-semibold lg:flex" aria-label="Navigasi utama">
                <a href="{{ route('about') }}" @class([
                    'focus-ring rounded-full border px-4 py-2 no-underline transition',
                    'border-[#17633f]/40 text-[#17633f] hover:border-[#17633f] hover:bg-[#17633f] hover:text-white' => !request()->routeIs('about'),
                    'border-[#17633f] bg-[#17633f] text-white' => request()->routeIs('about'),
                ])>Tentang</a>
                <a href="{{ route('pillars') }}" @class([
                    'focus-ring rounded-full border px-4 py-2 no-underline transition',
                    'border-[#17633f]/40 text-[#17633f] hover:border-[#17633f] hover:bg-[#17633f] hover:text-white' => !request()->routeIs('pillars'),
                    'border-[#17633f] bg-[#17633f] text-white' => request()->routeIs('pillars'),
                ])>Pilar</a>
                <a href="{{ route('programs.index') }}" @class([
                    'focus-ring rounded-full border px-4 py-2 no-underline transition',
                    'border-[#17633f]/40 text-[#17633f] hover:border-[#17633f] hover:bg-[#17633f] hover:text-white' => !request()->routeIs('programs.*'),
                    'border-[#17633f] bg-[#17633f] text-white' => request()->routeIs('programs.*'),
                ])>Program</a>
                <a href="{{ route('news.index') }}" @class([
                    'focus-ring rounded-full border px-4 py-2 no-underline transition',
                    'border-[#17633f]/40 text-[#17633f] hover:border-[#17633f] hover:bg-[#17633f] hover:text-white' => !request()->routeIs('news.*'),
                    'border-[#17633f] bg-[#17633f] text-white' => request()->routeIs('news.*'),
                ])>Berita</a>
                <a href="{{ route('team') }}" @class([
                    'focus-ring rounded-full border px-4 py-2 no-underline transition',
                    'border-[#17633f]/40 text-[#17633f] hover:border-[#17633f] hover:bg-[#17633f] hover:text-white' => !request()->routeIs('team'),
                    'border-[#17633f] bg-[#17633f] text-white' => request()->routeIs('team'),
                ])>Tim</a>
                <a href="{{ route('legal') }}" @class([
                    'focus-ring rounded-full border px-4 py-2 no-underline transition',
                    'border-[#17633f]/40 text-[#17633f] hover:border-[#17633f] hover:bg-[#17633f] hover:text-white' => !request()->routeIs('legal'),
                    'border-[#17633f] bg-[#17633f] text-white' => request()->routeIs('legal'),
                ])>Legalitas</a>
            </nav>
            <a href="{{ route('contact') }}" class="focus-ring hidden rounded-full bg-[#a3131b] px-5 py-3 text-sm font-bold text-white no-underline transition hover:bg-[#7f0d14] sm:inline-flex">Mari berkolaborasi <span class="ml-2" aria-hidden="true">↗</span></a>
            <details class="relative lg:hidden">
                <summary class="focus-ring flex h-11 w-11 cursor-pointer list-none items-center justify-center rounded-full border border-[#dce3da] text-xl" aria-label="Buka menu">☰</summary>
                <nav class="absolute right-0 top-14 grid min-w-52 gap-1 rounded-2xl border border-[#e3e7de] bg-white p-3 text-sm font-semibold shadow-xl" aria-label="Navigasi seluler">
                    <a href="{{ route('about') }}" @class([
                        'rounded-xl border px-4 py-3 no-underline transition',
                        'border-[#17633f]/30 text-[#17633f] hover:bg-[#17633f] hover:text-white' => !request()->routeIs('about'),
                        'border-[#17633f] bg-[#17633f] text-white' => request()->routeIs('about'),
                    ])>Tentang</a>
                    <a href="{{ route('pillars') }}" @class([
                        'rounded-xl border px-4 py-3 no-underline transition',
                        'border-[#17633f]/30 text-[#17633f] hover:bg-[#17633f] hover:text-white' => !request()->routeIs('pillars'),
                        'border-[#17633f] bg-[#17633f] text-white' => request()->routeIs('pillars'),
                    ])>Pilar & pendekatan</a>
                    <a href="{{ route('programs.index') }}" @class([
                        'rounded-xl border px-4 py-3 no-underline transition',
                        'border-[#17633f]/30 text-[#17633f] hover:bg-[#17633f] hover:text-white' => !request()->routeIs('programs.*'),
                        'border-[#17633f] bg-[#17633f] text-white' => request()->routeIs('programs.*'),
                    ])>Program</a>
                    <a href="{{ route('news.index') }}" @class([
                        'rounded-xl border px-4 py-3 no-underline transition',
                        'border-[#17633f]/30 text-[#17633f] hover:bg-[#17633f] hover:text-white' => !request()->routeIs('news.*'),
                        'border-[#17633f] bg-[#17633f] text-white' => request()->routeIs('news.*'),
                    ])>Berita</a>
                    <a href="{{ route('team') }}" @class([
                        'rounded-xl border px-4 py-3 no-underline transition',
                        'border-[#17633f]/30 text-[#17633f] hover:bg-[#17633f] hover:text-white' => !request()->routeIs('team'),
                        'border-[#17633f] bg-[#17633f] text-white' => request()->routeIs('team'),
                    ])>Tim</a>
                    <a href="{{ route('legal') }}" @class([
                        'rounded-xl border px-4 py-3 no-underline transition',
                        'border-[#17633f]/30 text-[#17633f] hover:bg-[#17633f] hover:text-white' => !request()->routeIs('legal'),
                        'border-[#17633f] bg-[#17633f] text-white' => request()->routeIs('legal'),
                    ])>Legalitas</a>
                    <a class="rounded-xl bg-[#a3131b] px-4 py-3 text-white" href="{{ route('contact') }}">Hubungi YISI ↗</a>
                </nav>
            </details>
        </div>
    </header>

    <main id="main">
        @if (session('status'))
            <div class="container-wide pt-6" role="status">
                <p class="rounded-xl border border-[#b7d7c3] bg-[#e8f4eb] px-5 py-4 text-sm font-semibold text-[#155234]">{{ session('status') }}</p>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="bg-[#103d2b] text-white">
        <div class="container-wide grid gap-8 py-10 md:grid-cols-[1.2fr_.8fr_.8fr]">
            <div>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 text-white no-underline">
                    <span class="grid h-11 w-11 place-items-center rounded-full bg-[#f2b01e] font-black text-[#103d2b]">Y</span>
                    <span><strong class="block text-lg">YISI</strong><small class="text-xs text-white/65">Investasi Sosial Indonesia</small></span>
                </a>
                <p class="mt-5 max-w-sm text-sm leading-7 text-white/70">Bersama komunitas, menumbuhkan ketahanan yang inklusif, berkeadilan, dan berakar pada kearifan lokal.</p>
            </div>
            <div>
                <h2 class="mb-5 text-xs font-extrabold uppercase tracking-[.16em] text-[#f2b01e]">Jelajahi</h2>
                <div class="grid gap-3 text-sm text-white/75">
                    <a class="hover:text-white" href="{{ route('about') }}">Tentang YISI</a>
                    <a class="hover:text-white" href="{{ route('programs.index') }}">Program</a>
                    <a class="hover:text-white" href="{{ route('news.index') }}">Berita & cerita</a>
                    <a class="hover:text-white" href="{{ route('legal') }}">Legalitas & transparansi</a>
                </div>
                <div>
                    <h2 class="mb-5 text-xs font-extrabold uppercase tracking-[.16em] text-[#f2b01e]">Kabar dari YISI</h2>
                    <p class="mb-4 text-sm leading-6 text-white/70">Terima cerita dan publikasi terbaru langsung ke email Anda.</p>
                    <form method="POST" action="{{ route('newsletter.subscribe') }}" class="grid gap-3">
                        @csrf
                        <label class="sr-only" for="newsletter-email">Alamat email untuk langganan kabar</label>
                        <input id="newsletter-email" name="email" type="email" required maxlength="190" placeholder="Alamat email" class="focus-ring rounded-xl border border-white/20 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-white/55">
                        <label class="flex items-start gap-2 text-xs leading-5 text-white/70"><input type="checkbox" name="consent" value="1" required class="mt-1 accent-[#f2b01e]">Saya setuju menerima kabar YISI dan memahami <a href="{{ route('privacy') }}" class="underline">kebijakan privasi</a>.</label>
                        <button class="focus-ring w-fit rounded-full bg-[#f2b01e] px-4 py-3 text-xs font-extrabold text-[#103d2b] hover:bg-[#ffd15a]">Berlangganan</button>
                    </form>
                </div>
            </div>
            <div>
                <h2 class="mb-5 text-xs font-extrabold uppercase tracking-[.16em] text-[#f2b01e]">Terhubung</h2>
                <div class="grid gap-3 text-sm text-white/75">
                    <a class="hover:text-white" href="{{ route('contact') }}">Kontak dan kemitraan</a>
                    <a class="hover:text-white" href="mailto:investasisosialindonesia@gmail.com">investasisosialindonesia@gmail.com</a>
                    <a class="hover:text-white" href="{{ route('privacy') }}">Kebijakan privasi</a>
                    <a class="hover:text-white" href="{{ url('/admin') }}">Kelola konten</a>
                </div>
            </div>
        </div>
        <div class="border-t border-white/15">
            <div class="container-wide flex flex-col gap-2 py-5 text-xs text-white/55 sm:flex-row sm:items-center sm:justify-between">
                <span>© {{ date('Y') }} Yayasan Investasi Sosial Indonesia</span>
                <span>Berakar di komunitas. Bertumbuh bersama.</span>
            </div>
        </div>
    </footer>
</body>
</html>
