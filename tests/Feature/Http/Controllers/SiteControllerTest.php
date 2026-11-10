<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Media;
use App\Models\Post;
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
