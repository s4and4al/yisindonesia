@props(['program'])

<article class="group flex h-full flex-col overflow-hidden rounded-[1.6rem] border border-[#e2e7df] bg-white transition hover:-translate-y-1 hover:shadow-xl hover:shadow-[#173d2b]/[.08]">
    <div class="soft-grid relative flex min-h-52 items-end overflow-hidden bg-[#e9f0e7] p-6">
        @if ($program->coverMedia && $program->coverMedia->consent_ok && str_starts_with($program->coverMedia->mime_type, 'image/'))
            <img src="{{ \Illuminate\Support\Facades\Storage::url($program->coverMedia->url) }}" alt="{{ $program->coverMedia->alt_text }}" loading="lazy" decoding="async" class="absolute inset-0 h-full w-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-[#103d2b]/75 via-transparent to-transparent"></div>
        @else
            <div class="absolute -right-10 -top-16 h-48 w-48 rounded-full border-[25px] border-[#17633f]/10"></div>
            <div class="absolute right-12 top-9 h-24 w-24 rounded-full bg-[#f2b01e]/45"></div>
        @endif
        <span class="relative rounded-full bg-white/85 px-3 py-1.5 text-xs font-bold text-[#17633f]">{{ $program->year_start }}{{ $program->year_end && $program->year_end !== $program->year_start ? '–'.$program->year_end : '' }}</span>
    </div>
    <div class="flex flex-1 flex-col p-6">
        <div class="flex flex-wrap gap-2">
            @foreach ($program->pillars as $pillar)
                <span class="rounded-full bg-[#f2f5ee] px-3 py-1 text-[.68rem] font-bold text-[#17633f]">{{ $pillar->name }}</span>
            @endforeach
        </div>
        <h3 class="serif mt-4 text-2xl leading-tight group-hover:text-[#17633f]">{{ $program->title }}</h3>
        <p class="mt-3 line-clamp-3 text-sm leading-6 text-[#66746d]">{{ $program->summary }}</p>
        <div class="mt-auto flex items-center justify-between gap-3 pt-6 text-xs font-semibold text-[#78857e]">
            <span>{{ $program->location ?: 'Jawa Timur' }}</span>
            <a class="focus-ring rounded-md text-[#a3131b] no-underline" href="{{ route('programs.show', $program) }}">Lihat program <span aria-hidden="true">↗</span></a>
        </div>
    </div>
</article>
