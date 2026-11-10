<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Office;
use App\Models\Partner;
use App\Models\Pillar;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Program;
use App\Models\Tag;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        $programs = Program::published()->with(['pillars', 'coverMedia'])->where('is_featured', true)->latest('year_start')->take(3)->get();
        $posts = Post::published()->with(['category', 'coverMedia'])->latest('published_at')->take(3)->get();

        return view('pages.home', [
            'pillars' => Pillar::query()->orderBy('sort_order')->get(),
            'programs' => $programs,
            'posts' => $posts,
            'heroSlides' => $posts->concat($programs)
                ->filter(fn (Post|Program $content): bool => $content->coverMedia?->consent_ok && str_starts_with($content->coverMedia->mime_type, 'image/'))
                ->take(5)
                ->values(),
            'testimonials' => Testimonial::approved()->with('photo')->latest()->take(6)->get(),
        ]);
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function pillars(): View
    {
        return view('pages.pillars', [
            'pillars' => Pillar::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function programs(Request $request): View
    {
        $filters = $request->validate([
            'year' => ['nullable', 'integer', 'between:2000,2100'],
            'pillar' => ['nullable', 'string', 'max:120'],
            'location' => ['nullable', 'string', 'max:120'],
            'partner' => ['nullable', 'string', 'max:120'],
        ]);

        $programs = Program::published()->with(['pillars', 'partners', 'coverMedia'])
            ->when($filters['year'] ?? null, function ($query, $year) {
                $query->where('year_start', '<=', $year)
                    ->where(function ($query) use ($year) {
                        $query->whereNull('year_end')->orWhere('year_end', '>=', $year);
                    });
            })
            ->when($filters['pillar'] ?? null, fn ($query, $slug) => $query->whereHas('pillars', fn ($query) => $query->where('slug', $slug)))
            ->when($filters['location'] ?? null, fn ($query, $location) => $query->where('location', 'like', "%{$location}%"))
            ->when($filters['partner'] ?? null, fn ($query, $partner) => $query->whereHas('partners', fn ($query) => $query->where('partners.id', $partner)))
            ->latest('year_start')
            ->paginate(9)
            ->withQueryString();

        return view('pages.programs.index', [
            'programs' => $programs,
            'pillars' => Pillar::query()->orderBy('sort_order')->get(),
            'partners' => Partner::query()->orderBy('name')->get(),
        ]);
    }

    public function program(Program $program): View
    {
        abort_unless($program->publish_status === 'published', 404);

        return view('pages.programs.show', [
            'program' => $program->load(['pillars', 'partners', 'coverMedia', 'posts' => fn ($query) => $query->published()->latest('published_at')->take(3)]),
        ]);
    }

    public function news(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'category' => ['nullable', 'string', 'max:120'],
            'tag' => ['nullable', 'string', 'max:100'],
        ]);

        $posts = Post::published()->with(['category', 'coverMedia'])
            ->when($filters['q'] ?? null, function ($query, $term) {
                $query->where(function ($query) use ($term) {
                    $needle = '%'.mb_strtolower($term).'%';
                    $query->whereRaw('LOWER(title) LIKE ?', [$needle])
                        ->orWhereRaw('LOWER(excerpt) LIKE ?', [$needle])
                        ->orWhereRaw('LOWER(content) LIKE ?', [$needle]);
                });
            })
            ->when($filters['category'] ?? null, fn ($query, $slug) => $query->whereHas('category', fn ($query) => $query->where('slug', $slug)))
            ->when($filters['tag'] ?? null, fn ($query, $slug) => $query->whereHas('tags', fn ($query) => $query->where('slug', $slug)))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('pages.news.index', [
            'heroPosts' => Post::published()->with(['category', 'coverMedia'])->latest('published_at')->take(5)->get(),
            'posts' => $posts,
            'categories' => PostCategory::query()->orderBy('sort_order')->get(),
            'tags' => Tag::query()->orderBy('name')->get(),
        ]);
    }

    public function post(Post $post): View
    {
        abort_unless($post->status === 'published' && $post->published_at?->isPast(), 404);
        $post->increment('view_count');

        return view('pages.news.show', [
            'post' => $post->load(['category', 'coverMedia', 'tags']),
            'relatedPosts' => Post::published()
                ->where('id', '!=', $post->id)
                ->when($post->category_id, fn ($query) => $query->where('category_id', $post->category_id))
                ->latest('published_at')
                ->take(3)
                ->get(),
        ]);
    }

    public function newsFeed(): Response
    {
        return response()
            ->view('pages.news.feed', [
                'posts' => Post::published()->latest('published_at')->take(30)->get(),
            ])
            ->header('Content-Type', 'application/rss+xml; charset=UTF-8');
    }

    public function sitemap(): Response
    {
        $urls = collect([
            route('home'),
            route('about'),
            route('pillars'),
            route('programs.index'),
            route('news.index'),
            route('team'),
            route('legal'),
            route('contact'),
        ])->merge(
            Program::published()->pluck('slug')->map(fn (string $slug) => route('programs.show', ['program' => $slug]))
        )->merge(
            Post::published()->pluck('slug')->map(fn (string $slug) => route('news.show', ['post' => $slug]))
        );

        return response()
            ->view('pages.sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function contact(): View
    {
        return view('pages.contact', [
            'offices' => Office::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function team(): View
    {
        return view('pages.team', [
            'members' => TeamMember::query()
                ->with('photo')
                ->where('is_visible', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function legal(): View
    {
        return view('pages.legal', [
            'identity' => DB::table('legal_identity')->where('is_public', true)->orderBy('sort_order')->get(),
            'documents' => DB::table('documents')
                ->join('media', 'documents.media_id', '=', 'media.id')
                ->where('documents.is_public', true)
                ->orderByDesc('documents.year')
                ->select('documents.*', 'media.url')
                ->get(),
        ]);
    }

    public function privacy(): View
    {
        return view('pages.privacy');
    }

    public function sendMessage(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:190'],
            'organization' => ['nullable', 'string', 'max:190'],
            'topic' => ['required', 'in:kemitraan,media,relawan,lainnya'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        $data['ip_hash'] = hash_hmac('sha256', $request->ip() ?? '', (string) config('app.key'));
        ContactMessage::query()->create($data);

        return back()->with('status', 'Terima kasih. Pesan Anda telah terkirim dan akan ditinjau oleh tim YISI.');
    }
}
