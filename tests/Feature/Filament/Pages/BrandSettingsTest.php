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
