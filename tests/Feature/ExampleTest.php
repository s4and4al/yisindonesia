<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        foreach (['/', '/tentang', '/pilar', '/program', '/berita', '/berita/feed.xml', '/kontak', '/tim', '/legalitas', '/kebijakan-privasi', '/sitemap.xml'] as $path) {
            $this->get($path)->assertOk();
        }
    }

    public function test_published_article_renders_safely(): void
    {
        $post = $this->createPublishedPost();
        $outputBufferLevel = ob_get_level();
        $response = $this->get(route('news.show', $post));
        $this->assertSame($outputBufferLevel, ob_get_level());
        $response->assertOk()->assertSee('Cerita aman')->assertDontSee('<script>', false);
    }

    public function test_published_article_is_added_to_rss_feed(): void
    {
        $this->createPublishedPost();

        $this->get(route('news.feed'))->assertOk()->assertSee('Cerita Uji');
    }

    public function test_published_article_is_added_to_sitemap(): void
    {
        $post = $this->createPublishedPost();

        $this->get(route('sitemap'))->assertOk()->assertSee(route('news.show', $post), false);
    }

    public function test_author_can_only_submit_owned_posts_as_drafts(): void
    {
        $author = User::factory()->create(['role' => 'author']);
        $otherAuthor = User::factory()->create(['role' => 'author']);
        $otherPost = Post::query()->create([
            'title' => 'Artikel penulis lain',
            'slug' => 'artikel-penulis-lain',
            'content' => 'Isi artikel',
            'author_id' => $otherAuthor->id,
        ]);
        $this->actingAs($author);

        $post = Post::query()->create([
            'title' => 'Draf penulis',
            'slug' => 'draf-penulis',
            'content' => 'Isi draf',
            'author_id' => $otherAuthor->id,
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->assertSame($author->id, $post->author_id);
        $this->assertSame('draft', $post->status);
        $this->assertTrue(Gate::allows('update', $post));
        $this->assertFalse(Gate::allows('update', $otherPost));
    }

    public function test_contact_message_is_saved_with_a_hashed_ip(): void
    {
        $this->post('/kontak', [
            'name' => 'Pengunjung',
            'email' => 'visitor@example.com',
            'organization' => 'Komunitas',
            'topic' => 'kemitraan',
            'message' => 'Kami ingin berdiskusi tentang peluang kolaborasi.',
        ])->assertRedirect();

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'visitor@example.com',
            'status' => 'new',
        ]);
        $this->assertNotNull(\App\Models\ContactMessage::query()->firstOrFail()->ip_hash);
    }

    public function test_contact_message_validation_rejects_invalid_email(): void
    {
        $this->from('/kontak')->post('/kontak', [
            'name' => 'Pengunjung',
            'email' => 'not-an-email',
            'topic' => 'kemitraan',
            'message' => 'Pesan yang cukup panjang.',
        ])->assertSessionHasErrors('email');
    }

    public function test_newsletter_requires_consent_and_confirms_before_activation(): void
    {
        Mail::fake();

        $this->from('/')->post('/kabari', ['email' => 'reader@example.com'])
            ->assertSessionHasErrors('consent');

        $this->from('/')->post('/kabari', [
            'email' => 'reader@example.com',
            'consent' => '1',
        ])->assertRedirect();

        $subscriber = Subscriber::query()->where('email', 'reader@example.com')->firstOrFail();
        $this->assertNull($subscriber->confirmed_at);

        $this->get(route('newsletter.confirm', $subscriber->token))->assertRedirect(route('home'));
        $this->assertNotNull($subscriber->fresh()->confirmed_at);

        $this->get(route('newsletter.unsubscribe.show', $subscriber->token))->assertOk();
        $this->post(route('newsletter.unsubscribe'), ['token' => $subscriber->token])->assertRedirect(route('home'));
        $this->assertNotNull($subscriber->fresh()->unsubscribed_at);
    }

    private function createPublishedPost(): Post
    {
        $category = PostCategory::query()->create([
            'name' => 'Cerita Lapangan',
            'slug' => 'cerita-lapangan',
            'sort_order' => 1,
        ]);

        return Post::query()->create([
            'title' => 'Cerita Uji',
            'slug' => 'cerita-uji',
            'content' => '<script>alert(1)</script>'."\n\n".'**Cerita aman**',
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now()->subMinute(),
        ]);
    }
}
