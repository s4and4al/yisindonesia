@extends('layouts.app')

@section('title', 'YISI — Ketahanan tumbuh dari komunitas')
@section('content')
    <section class="relative overflow-hidden bg-[#f1f3e9]">
        <div class="absolute inset-y-0 right-0 hidden w-[52%] bg-[#e7eddf] lg:block"></div>
        <div class="container-wide relative grid min-h-[600px] items-center gap-8 py-12 lg:grid-cols-[1.1fr_.9fr] lg:py-16">
            <div class="relative z-10 max-w-2xl">
                <p class="eyebrow flex items-center gap-3"><span class="h-px w-8 bg-[#a3131b]"></span> Yayasan Investasi Sosial Indonesia</p>
                <h1 class="serif mt-7 text-[clamp(3.4rem,7.4vw,6.6rem)] leading-[.96] text-[#143d2b]">Ketahanan sejati <em class="font-normal text-[#a3131b]">tumbuh</em> dari komunitas.</h1>
                <p class="mt-7 max-w-xl text-lg leading-8 text-[#52645a]">Bersama masyarakat, kami menumbuhkan ekonomi yang inklusif, lingkungan yang regeneratif, dan pendidikan yang emansipatoris.</p>
                <div class="mt-9 flex flex-wrap items-center gap-4">
                    <a href="{{ route('about') }}" class="focus-ring inline-flex items-center rounded-full bg-[#a3131b] px-6 py-4 text-sm font-bold text-white no-underline transition hover:bg-[#7f0d14]">Kenali perjalanan kami <span class="ml-3" aria-hidden="true">↗</span></a>
                    <a href="{{ route('programs.index') }}" class="focus-ring rounded-full px-4 py-4 text-sm font-bold text-[#17633f] no-underline hover:underline">Jelajahi program</a>
                </div>
                <div class="mt-14 flex items-center gap-4 border-t border-[#cbd6c8] pt-5 text-xs font-semibold text-[#64736b]">
                    <span class="flex -space-x-2" aria-hidden="true"><i class="h-7 w-7 rounded-full border-2 border-[#f1f3e9] bg-[#f2b01e]"></i><i class="h-7 w-7 rounded-full border-2 border-[#f1f3e9] bg-[#17633f]"></i><i class="h-7 w-7 rounded-full border-2 border-[#f1f3e9] bg-[#a3131b]"></i></span>
                    <span>Berakar di Pasuruan, bertumbuh bersama komunitas.</span>
                </div>
            </div>
            <div class="relative mx-auto aspect-square w-full max-w-[490px]" aria-label="Ilustrasi tiga pilar YISI">
                <div class="absolute inset-[10%] rounded-full border border-[#17633f]/20"></div>
                <div class="absolute inset-[22%] rounded-full border border-dashed border-[#17633f]/30"></div>
                <div class="absolute inset-[35%] rounded-full bg-[#f8f8f3] shadow-[0_25px_80px_rgba(17,62,43,.14)]"></div>
                <div class="absolute left-1/2 top-1/2 grid h-32 w-32 -translate-x-1/2 -translate-y-1/2 place-items-center rounded-full bg-[#17633f] text-center text-white shadow-xl shadow-[#17633f]/20 sm:h-40 sm:w-40">
                    <span><strong class="serif block text-5xl">YISI</strong><small class="mt-2 block text-[.58rem] font-bold uppercase tracking-[.18em] text-white/75">Investasi sosial</small></span>
                </div>
                <div class="absolute left-[6%] top-[20%] grid h-28 w-28 place-items-center rounded-full bg-[#f2b01e] text-center shadow-lg shadow-[#8a6514]/15 sm:h-36 sm:w-36">
                    <span class="text-xs font-extrabold leading-5 text-[#3d3213]">Ekonomi<br>inklusif</span>
                </div>
                <div class="absolute right-[4%] top-[19%] grid h-28 w-28 place-items-center rounded-full bg-[#a3131b] text-center shadow-lg shadow-[#a3131b]/20 sm:h-36 sm:w-36">
                    <span class="text-xs font-extrabold leading-5 text-white">Lingkungan<br>regeneratif</span>
                </div>
                <div class="absolute bottom-[6%] left-1/2 grid h-28 w-28 -translate-x-1/2 place-items-center rounded-full bg-[#dce9dc] text-center shadow-lg sm:h-36 sm:w-36">
                    <span class="text-xs font-extrabold leading-5 text-[#17633f]">Pendidikan<br>emansipatoris</span>
                </div>
                <span class="absolute right-[16%] top-[5%] h-4 w-4 rounded-full bg-[#f2b01e]"></span>
                <span class="absolute bottom-[20%] left-[5%] h-3 w-3 rounded-full bg-[#a3131b]"></span>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 h-1 w-1/3 bg-[#f2b01e]"></div><div class="absolute bottom-0 left-1/3 h-1 w-1/3 bg-[#17633f]"></div><div class="absolute bottom-0 right-0 h-1 w-1/3 bg-[#a3131b]"></div>
    </section>

    <section class="border-b border-[#e3e7de] bg-white">
        <div class="container-wide grid divide-y divide-[#e5e9e2] py-7 sm:grid-cols-3 sm:divide-x sm:divide-y-0">
            <div class="px-4 py-4 sm:px-8"><strong class="serif block text-3xl text-[#17633f]">2015</strong><span class="mt-1 block text-xs font-semibold text-[#718078]">Resmi berbadan hukum yayasan</span></div>
            <div class="px-4 py-4 sm:px-8"><strong class="serif block text-3xl text-[#17633f]">3 pilar</strong><span class="mt-1 block text-xs font-semibold text-[#718078]">Ekonomi, lingkungan, pendidikan</span></div>
            <div class="px-4 py-4 sm:px-8"><strong class="serif block text-3xl text-[#17633f]">Jawa Timur</strong><span class="mt-1 block text-xs font-semibold text-[#718078]">Berkedudukan di Pasuruan</span></div>
        </div>
    </section>

    <section class="section-pad">
        <div class="container-wide">
            <x-section-heading eyebrow="Cara kami bekerja" title="Perubahan yang berakar, bukan sekadar hadir." description="YISI mendampingi masyarakat untuk menemukan kekuatan, pengetahuan, dan sumber daya yang sudah tumbuh di dalam komunitas." />
            <div class="mt-8 grid gap-5 md:grid-cols-3">
                @foreach ($pillars as $index => $pillar)
                    <article class="rounded-[1.6rem] border border-[#e2e7df] bg-white p-7 {{ $index === 1 ? 'md:translate-y-5' : '' }}">
                        <span class="grid h-12 w-12 place-items-center rounded-2xl text-xl font-black text-white" style="background-color: {{ $pillar->color_hex ?: '#17633f' }}">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                        <h3 class="serif mt-7 text-2xl leading-tight">{{ $pillar->name }}</h3>
                        <p class="mt-3 text-sm leading-6 text-[#64736b]">{{ $pillar->summary }}</p>
                        <a class="mt-6 inline-flex text-sm font-bold text-[#a3131b] no-underline hover:underline" href="{{ route('pillars') }}">Pelajari pendekatan <span class="ml-2">↗</span></a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-pad bg-white">
        <div class="container-wide">
            <x-section-heading eyebrow="Testimoni" title="Suara dari komunitas." description="Cerita nyata dari mitra dan komunitas yang telah tumbuh bersama YISI." />
            @if ($testimonials->isNotEmpty())
                <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($testimonials as $testimonial)
                        <figure class="flex h-full flex-col overflow-hidden rounded-[1.6rem] border border-[#e2e7df] bg-[#fbfcf9]">
                            @if ($testimonial->photo)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($testimonial->photo->url) }}" alt="{{ $testimonial->photo->alt_text }}" class="h-52 w-full object-cover" loading="lazy" decoding="async">
                            @endif
                            <div class="flex flex-1 flex-col p-7">
                                <span class="serif text-6xl leading-none text-[#17633f]/25" aria-hidden="true">&ldquo;</span>
                                <blockquote class="mt-2 flex-1 text-base leading-7 text-[#3b4a42]">{{ $testimonial->content }}</blockquote>
                                <figcaption class="mt-6 flex items-center gap-3 border-t border-[#e9ede6] pt-5">
                                    <span class="grid h-12 w-12 shrink-0 place-items-center rounded-full bg-[#17633f] text-white" aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-bold text-[#143d2b]">{{ $testimonial->name }}</p>
                                        @if ($testimonial->social_url)
                                            <a class="mt-0.5 inline-flex items-center gap-1 text-xs font-semibold text-[#17633f] no-underline hover:underline" href="{{ $testimonial->social_url }}" target="_blank" rel="noopener noreferrer">{{ $testimonial->social_platform }} <span aria-hidden="true">↗</span></a>
                                        @elseif ($testimonial->social_platform)
                                            <p class="mt-0.5 text-xs font-semibold text-[#7b8981]">{{ $testimonial->social_platform }}</p>
                                        @endif
                                    </div>
                                </figcaption>
                            </div>
                        </figure>
                    @endforeach
                </div>
            @else
                <div class="mt-7 rounded-[1.5rem] border border-dashed border-[#c5cec3] px-6 py-10 text-center">
                    <p class="serif text-2xl text-[#25392e]">Belum ada testimoni yang ditampilkan.</p>
                    <p class="mt-2 text-sm text-[#64736b]">Suara dari mitra dan komunitas akan muncul di sini setelah ditinjau.</p>
                </div>
            @endif
            <div class="mt-8 grid gap-8 rounded-[1.7rem] border border-[#e2e7df] bg-[#f0eadb] p-7 sm:p-9 lg:grid-cols-[.8fr_1.2fr]">
                <div>
                    <p class="eyebrow">Bagikan pengalaman</p>
                    <h2 class="serif mt-4 text-3xl">Punya cerita tumbuh bersama YISI?</h2>
                    <p class="mt-3 text-sm leading-6 text-[#62716a]">Isi formulir di samping. Testimoni yang Anda kirim akan tampil setelah ditinjau tim YISI.</p>
                </div>
                <form method="POST" action="{{ route('testimonials.store') }}" enctype="multipart/form-data" class="grid gap-4">
                    @csrf
                    <label class="grid gap-2 text-sm font-semibold">Nama <input required name="name" value="{{ old('name') }}" maxlength="150" class="focus-ring rounded-xl border border-[#dce3da] bg-white px-4 py-3 font-normal"></label>
                    <label class="grid gap-2 text-sm font-semibold">Isi testimoni <textarea required minlength="10" maxlength="2000" rows="4" name="content" class="focus-ring resize-y rounded-xl border border-[#dce3da] bg-white px-4 py-3 font-normal">{{ old('content') }}</textarea></label>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="grid gap-2 text-sm font-semibold">Platform sosial media
                            <select required name="social_platform" class="focus-ring rounded-xl border border-[#dce3da] bg-white px-4 py-3 font-normal">
                                <option value="">Pilih platform</option>
                                <option value="instagram" @selected(old('social_platform') === 'instagram')>Instagram</option>
                                <option value="facebook" @selected(old('social_platform') === 'facebook')>Facebook</option>
                                <option value="linkedin" @selected(old('social_platform') === 'linkedin')>LinkedIn</option>
                                <option value="tiktok" @selected(old('social_platform') === 'tiktok')>TikTok</option>
                                <option value="lainnya" @selected(old('social_platform') === 'lainnya')>Lainnya</option>
                            </select>
                        </label>
                        <label class="grid gap-2 text-sm font-semibold">Tautan sosial media <span class="text-xs font-normal text-[#78857e]">Opsional</span><input type="url" name="social_url" value="{{ old('social_url') }}" maxlength="300" placeholder="https://..." class="focus-ring rounded-xl border border-[#dce3da] bg-white px-4 py-3 font-normal"></label>
                    </div>
                    <label class="grid gap-2 text-sm font-semibold">Foto dokumentasi/kegiatan <input required type="file" name="photo" accept="image/jpeg,image/png,image/webp" class="focus-ring rounded-xl border border-[#dce3da] bg-white px-4 py-3 text-sm font-normal file:mr-3 file:rounded-full file:border-0 file:bg-[#17633f] file:px-4 file:py-2 file:text-xs file:font-bold file:text-white"></label>
                    <label class="flex items-start gap-2 text-xs leading-5 text-[#62716a]"><input type="checkbox" name="consent" value="1" required class="mt-0.5 accent-[#17633f]">Saya setuju nama dan foto saya ditampilkan secara publik di website YISI.</label>
                    @if ($errors->any())<div class="rounded-xl border border-[#e9c0c0] bg-[#fff1f1] p-4 text-sm text-[#8e171e]" role="alert"><p class="font-bold">Mohon periksa kembali formulir:</p><ul class="mt-2 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                    <button class="focus-ring w-fit rounded-full bg-[#17633f] px-6 py-3 text-sm font-bold text-white no-underline transition hover:bg-[#0f4d30]">Kirim testimoni</button>
                </form>
            </div>
        </div>
    </section>

    <section class="section-pad bg-[#eaf0e7]">
        <div class="container-wide">
            <div class="flex flex-col justify-between gap-6 sm:flex-row sm:items-end">
                <x-section-heading eyebrow="Kerja bersama" title="Program yang menjawab kebutuhan nyata." description="Setiap inisiatif tumbuh dari konteks lokal, pengetahuan masyarakat, dan kolaborasi lintas sektor." />
                <a href="{{ route('programs.index') }}" class="focus-ring mb-1 w-fit rounded-full border border-[#17633f]/30 px-5 py-3 text-sm font-bold text-[#17633f] no-underline hover:bg-white">Semua program ↗</a>
            </div>
            @if ($programs->isNotEmpty())
                <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($programs as $program)<x-program-card :program="$program" />@endforeach
                </div>
            @else
                <div class="mt-7 rounded-[1.5rem] border border-dashed border-[#aebcaf] bg-white/60 px-6 py-10 text-center">
                    <p class="serif text-2xl text-[#25392e]">Program YISI akan segera ditampilkan.</p>
                    <p class="mt-2 text-sm text-[#64736b]">Tim kami sedang menyiapkan ringkasan program yang telah diverifikasi.</p>
                </div>
            @endif
        </div>
    </section>

    <section class="section-pad">
        <div class="container-wide">
            <div class="flex flex-col justify-between gap-6 sm:flex-row sm:items-end">
                <x-section-heading eyebrow="Dari lapangan" title="Cerita dan kabar terbaru." description="Ikuti pembelajaran, kabar lembaga, dan gagasan yang tumbuh dari kerja bersama komunitas." />
                <a href="{{ route('news.index') }}" class="focus-ring mb-1 w-fit rounded-full border border-[#17633f]/30 px-5 py-3 text-sm font-bold text-[#17633f] no-underline hover:bg-[#edf2e9]">Jelajahi berita ↗</a>
            </div>
            @if ($posts->isNotEmpty())
                <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($posts as $post)<x-post-card :post="$post" />@endforeach
                </div>
            @else
                <div class="mt-7 rounded-[1.5rem] border border-dashed border-[#c5cec3] px-6 py-10 text-center">
                    <p class="serif text-2xl text-[#25392e]">Cerita YISI segera hadir.</p>
                    <p class="mt-2 text-sm text-[#64736b]">Berita dan publikasi akan muncul di sini setelah diterbitkan.</p>
                </div>
            @endif
        </div>
    </section>

    <section class="pb-12">
        <div class="container-wide overflow-hidden rounded-[2rem] bg-[#103d2b] px-7 py-10 text-white sm:px-12 sm:py-12">
            <div class="grid items-center gap-8 md:grid-cols-[1fr_auto]">
                <div class="max-w-2xl">
                    <p class="text-xs font-bold uppercase tracking-[.18em] text-[#f2b01e]">Bertumbuh bersama</p>
                    <h2 class="serif mt-4 text-4xl leading-tight sm:text-5xl">Perubahan besar dimulai dari kemitraan yang setara.</h2>
                    <p class="mt-4 max-w-xl text-sm leading-7 text-white/70">Mari bertukar gagasan dan membangun kolaborasi yang berpihak pada ketahanan komunitas.</p>
                </div>
                <a href="{{ route('contact') }}" class="focus-ring w-fit rounded-full bg-[#f2b01e] px-6 py-4 text-sm font-extrabold text-[#103d2b] no-underline hover:bg-[#ffd15a]">Hubungi tim YISI ↗</a>
            </div>
        </div>
    </section>
@endsection
