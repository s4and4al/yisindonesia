<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Media;
use App\Models\Post;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SiteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_shows_a_carousel_with_consented_published_images(): void
    {
        Storage::fake('public');

        $firstImage = $this->createImage(consentOk: true);
        $secondImage = $this->createImage(consentOk: true);
        $unapprovedImage = $this->createImage(consentOk: false);

        foreach ([
            ['title' => 'Berita pertama', 'slug' => 'berita-pertama', 'image' => $firstImage],
            ['title' => 'Berita kedua', 'slug' => 'berita-kedua', 'image' => $secondImage],
            ['title' => 'Berita belum disetujui', 'slug' => 'berita-belum-disetujui', 'image' => $unapprovedImage],
        ] as $article) {
            Post::query()->create([
                'title' => $article['title'],
                'slug' => $article['slug'],
                'content' => 'Isi berita',
                'cover_media_id' => $article['image']->id,
                'status' => 'published',
                'published_at' => now()->subMinute(),
            ]);
        }

        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertSee('Selamat datang di halaman Yayasan Investasi Sosial Indonesia.')
            ->assertSee('data-hero-prev', false)
            ->assertSee(Storage::url($firstImage->url), false)
            ->assertDontSee(Storage::url($unapprovedImage->url), false);
        $this->assertSame(2, substr_count($response->getContent(), 'data-hero-slide'));
    }

    public function test_news_slide_limits_long_headlines_to_two_lines(): void
    {
        $title = 'Cerita panjang tentang perubahan yang tumbuh bersama masyarakat dan menguatkan ketahanan komunitas di berbagai wilayah Indonesia';

        Post::query()->create([
            'title' => $title,
            'slug' => 'cerita-perubahan-komunitas',
            'content' => 'Isi berita',
            'status' => 'published',
            'published_at' => now()->subMinute(),
        ]);

        $response = $this->get(route('news.index'));

        $response->assertOk()
            ->assertSee('line-clamp-2', false)
            ->assertSee($title);
    }

    public function test_published_news_image_can_be_resized_using_markdown_width(): void
    {
        $post = Post::query()->create([
            'title' => 'Berita dengan gambar berukuran khusus',
            'slug' => 'berita-gambar-ukuran-khusus',
            'content' => '![Foto kegiatan](/storage/news/foto.png){width=600}',
            'status' => 'published',
            'published_at' => now()->subMinute(),
        ]);

        $response = $this->get(route('news.show', $post));

        $response->assertOk()
            ->assertSee('<img width="600" src="/storage/news/foto.png" alt="Foto kegiatan" />', false);
    }

    public function test_published_news_image_does_not_render_unapproved_markdown_attributes(): void
    {
        $post = Post::query()->create([
            'title' => 'Berita dengan atribut gambar',
            'slug' => 'berita-atribut-gambar',
            'content' => '![Foto kegiatan](/storage/news/foto.png){width=600 onerror=alert(1)}',
            'status' => 'published',
            'published_at' => now()->subMinute(),
        ]);

        $response = $this->get(route('news.show', $post));

        $response->assertOk()
            ->assertSee('<img width="600" src="/storage/news/foto.png" alt="Foto kegiatan" />', false)
            ->assertDontSee('onerror', false);
    }

    public function test_public_header_uses_the_configured_site_logo(): void
    {
        $logoPath = 'branding/yisi-logo.png';
        SiteSetting::query()->create([
            'key' => 'branding',
            'value' => ['logo_path' => $logoPath],
        ]);

        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertSee(Storage::disk('public')->url($logoPath), false)
            ->assertSee('alt="Yayasan Investasi Sosial Indonesia"', false);
        $this->assertSame(2, substr_count($response->getContent(), Storage::disk('public')->url($logoPath)));
    }

    public function test_public_header_keeps_the_default_branding_without_a_configured_logo(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertSee('INVESTASI SOSIAL INDONESIA')
            ->assertDontSee('branding/yisi-logo.png', false);
    }

    public function test_about_page_shows_the_image_configured_by_admin_instead_of_the_heading(): void
    {
        $imagePath = 'branding/about-yisi.png';
        SiteSetting::query()->create([
            'key' => 'branding',
            'value' => ['about_image_path' => $imagePath],
        ]);

        $response = $this->get(route('about'));

        $response->assertOk()
            ->assertSee(Storage::disk('public')->url($imagePath), false)
            ->assertSee('alt="Ketahanan berawal dari kekuatan yang telah ada"', false)
            ->assertSee('object-contain', false)
            ->assertDontSee('Ketahanan berawal dari kekuatan yang telah ada.</h2>', false);
    }

    public function test_about_page_keeps_the_heading_until_an_image_is_configured(): void
    {
        $response = $this->get(route('about'));

        $response->assertOk()
            ->assertSee('Ketahanan berawal dari kekuatan yang telah ada.');
    }

    private function createImage(bool $consentOk): Media
    {
        $file = UploadedFile::fake()->image('hero.jpg');
        $path = $file->store('media', 'public');

        return Media::query()->create([
            'file_name' => $file->getClientOriginalName(),
            'url' => $path,
            'alt_text' => 'Foto kegiatan YISI',
            'consent_ok' => $consentOk,
        ]);
    }
}
