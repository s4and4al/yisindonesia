<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Concerns\RestrictsFileUploadsToSchemaComponents;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class BrandSettings extends Page
{
    use RestrictsFileUploadsToSchemaComponents;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan';

    protected static ?string $navigationLabel = 'Logo situs';

    protected static ?string $title = 'Logo publik';

    protected string $view = 'filament.pages.brand-settings';

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public function mount(): void
    {
        $setting = SiteSetting::query()->find('branding');

        $this->form->fill([
            'logo_path' => $setting?->value['logo_path'] ?? null,
            'about_image_path' => $setting?->value['about_image_path'] ?? null,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('logo_path')
                    ->label('Logo situs publik')
                    ->image()
                    ->disk('public')
                    ->directory('branding')
                    ->visibility('public')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(2048)
                    ->helperText('Format JPG, PNG, atau WebP. Ukuran maksimal 2 MB.'),
                FileUpload::make('about_image_path')
                    ->label('Gambar halaman Tentang')
                    ->image()
                    ->disk('public')
                    ->directory('branding')
                    ->visibility('public')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(5120)
                    ->helperText('Gambar ini menggantikan judul “Ketahanan berawal dari kekuatan yang telah ada” di halaman Tentang. Maksimal 5 MB.'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        SiteSetting::query()->updateOrCreate(
            ['key' => 'branding'],
            ['value' => [
                'logo_path' => $data['logo_path'] ?? null,
                'about_image_path' => $data['about_image_path'] ?? null,
            ]],
        );

        Notification::make()
            ->success()
            ->title('Pengaturan visual publik berhasil diperbarui')
            ->send();
    }
}
