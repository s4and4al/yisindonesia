<?php

namespace Tests\Feature\Filament\Resources;

use App\Filament\Resources\Posts\Pages\ManagePosts;
use App\Models\Media;
use App\Models\Post;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class PostResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_editing_a_post_keeps_its_existing_cover_image_loaded(): void
    {
        Storage::fake('public');
        $image = UploadedFile::fake()->image('cover.jpg');
        $path = $image->store('media', 'public');
        $media = Media::query()->create([
            'file_name' => 'cover.jpg',
            'url' => $path,
            'alt_text' => 'Foto sampul artikel',
            'consent_ok' => true,
        ]);
        $post = Post::query()->create([
            'title' => 'Artikel uji',
            'slug' => 'artikel-uji',
            'content' => 'Isi artikel uji.',
            'cover_media_id' => $media->id,
            'status' => 'draft',
        ]);
        $admin = User::factory()->create(['role' => 'admin']);

        $livewire = Livewire::actingAs($admin)
            ->test(ManagePosts::class)
            ->mountAction(TestAction::make('edit')->table($post))
            ->assertSchemaStateSet(['cover_media_id' => $media->id]);

        $schema = $livewire->instance()->{$livewire->instance()->getMountedActionSchemaName()};
        $fileUpload = $schema->getFlatComponents(withHidden: true)['cover_media_id'];

        $this->assertSame(
            [Storage::disk('public')->url($path)],
            array_column($fileUpload->getUploadedFiles() ?? [], 'url'),
        );
    }

    public function test_editing_a_post_loads_existing_markdown_images_and_can_replace_them(): void
    {
        Storage::fake('public');
        $originalMarkdown = "Isi artikel.\n\n![Foto lama](/storage/news/foto-lama.png)";
        $replacementMarkdown = "Isi artikel.\n\n![Foto baru](/storage/news/foto-baru.png)";
        $post = Post::query()->create([
            'title' => 'Artikel dengan gambar isi',
            'slug' => 'artikel-dengan-gambar-isi',
            'content' => $originalMarkdown,
            'status' => 'draft',
        ]);
        $admin = User::factory()->create(['role' => 'admin']);

        $livewire = Livewire::actingAs($admin)
            ->test(ManagePosts::class)
            ->mountAction(TestAction::make('edit')->table($post))
            ->assertSchemaStateSet(['content' => $originalMarkdown]);

        $schema = $livewire->instance()->{$livewire->instance()->getMountedActionSchemaName()};
        $markdownEditor = $schema->getFlatComponents(withHidden: true)['content'];
        $this->assertTrue($markdownEditor->hasFileAttachments());

        $livewire
            ->fillForm(['content' => $replacementMarkdown])
            ->callMountedAction()
            ->assertHasNoFormErrors();

        $this->assertSame($replacementMarkdown, $post->refresh()->content);
    }

    public function test_editing_a_post_can_remove_an_existing_markdown_image(): void
    {
        Storage::fake('public');
        $post = Post::query()->create([
            'title' => 'Artikel tanpa gambar isi',
            'slug' => 'artikel-tanpa-gambar-isi',
            'content' => "Isi artikel.\n\n![Foto lama](/storage/news/foto-lama.png)",
            'status' => 'draft',
        ]);
        $admin = User::factory()->create(['role' => 'admin']);

        Livewire::actingAs($admin)
            ->test(ManagePosts::class)
            ->mountAction(TestAction::make('edit')->table($post))
            ->fillForm(['content' => 'Isi artikel tanpa gambar.'])
            ->callMountedAction()
            ->assertHasNoFormErrors();

        $this->assertSame('Isi artikel tanpa gambar.', $post->refresh()->content);
    }
}
