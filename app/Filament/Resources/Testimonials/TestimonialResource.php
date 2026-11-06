<?php

namespace App\Filament\Resources\Testimonials;

use App\Filament\Concerns\AllowsEditors;
use App\Filament\Resources\Testimonials\Pages\ManageTestimonials;
use App\Models\Testimonial;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedStar;

    use AllowsEditors;

    protected static string|UnitEnum|null $navigationGroup = 'Interaksi pengunjung';

    protected static ?string $navigationLabel = 'Testimoni';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Nama')->required()->maxLength(150),
                Textarea::make('content')->label('Isi testimoni')->rows(5)->required()->maxLength(2000)->columnSpanFull(),
                Select::make('social_platform')->label('Platform sosial media')->options([
                    'instagram' => 'Instagram',
                    'facebook' => 'Facebook',
                    'linkedin' => 'LinkedIn',
                    'tiktok' => 'TikTok',
                    'lainnya' => 'Lainnya',
                ]),
                TextInput::make('social_url')->label('Tautan sosial media')->url()->maxLength(300)->placeholder('https://...'),
                Select::make('photo_media_id')->label('Foto')->relationship('photo', 'file_name')->searchable()->preload(),
                Select::make('status')->label('Status')->options([
                    'pending' => 'Menunggu tinjauan',
                    'approved' => 'Disetujui',
                    'rejected' => 'Ditolak',
                ])->required()->default('pending'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo.url')->label('Foto')->disk('public')->circular()->size(40),
                TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                TextColumn::make('social_platform')->label('Platform')->badge(),
                TextColumn::make('status')->label('Status')->badge()->color(fn (string $state): string => match ($state) {
                    'approved' => 'success',
                    'rejected' => 'danger',
                    default => 'warning',
                }),
                TextColumn::make('created_at')->label('Dikirim')->dateTime('d M Y')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'pending' => 'Menunggu tinjauan',
                    'approved' => 'Disetujui',
                    'rejected' => 'Ditolak',
                ]),
            ])
            ->recordActions([
                Action::make('approve')
                    ->label('Setujui')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Testimonial $record): bool => $record->status !== 'approved')
                    ->action(fn (Testimonial $record) => $record->update(['status' => 'approved'])),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageTestimonials::route('/'),
        ];
    }
}
