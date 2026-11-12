<?php

namespace Tests\Feature\Filament\Pages;

use App\Filament\Pages\BrandSettings;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class BrandSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_save_a_logo_for_the_public_site(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);
        $logo = UploadedFile::fake()->image('logo.png', 400, 160);

        Livewire::actingAs($admin)
            ->test(BrandSettings::class)
            ->set('data.logo_path', $logo)
            ->call('save')
            ->assertHasNoErrors();

        $setting = SiteSetting::query()->findOrFail('branding');

        $this->assertIsString($setting->value['logo_path']);
        Storage::disk('public')->assertExists($setting->value['logo_path']);
    }

    public function test_admin_can_save_an_about_image_without_removing_the_site_logo(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);
        UploadedFile::fake()->image('existing-logo.png')->storeAs('branding', 'existing-logo.png', 'public');
        SiteSetting::query()->create([
            'key' => 'branding',
            'value' => ['logo_path' => 'branding/existing-logo.png'],
        ]);
        $image = UploadedFile::fake()->image('about.png', 1200, 800);

        Livewire::actingAs($admin)
            ->test(BrandSettings::class)
            ->set('data.about_image_path', $image)
            ->call('save')
            ->assertHasNoErrors();

        $setting = SiteSetting::query()->findOrFail('branding');

        $this->assertSame('branding/existing-logo.png', $setting->value['logo_path']);
        $this->assertIsString($setting->value['about_image_path']);
        Storage::disk('public')->assertExists($setting->value['about_image_path']);
    }

    #[DataProvider('unauthorizedRoles')]
    public function test_non_admin_cannot_access_logo_settings(string $role): void
    {
        $user = User::factory()->create(['role' => $role]);

        Livewire::actingAs($user)
            ->test(BrandSettings::class)
            ->assertForbidden();
    }

    public static function unauthorizedRoles(): array
    {
        return [
            'editor' => ['editor'],
            'author' => ['author'],
        ];
    }
}
