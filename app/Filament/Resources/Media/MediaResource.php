<?php

namespace App\Filament\Resources\Media;

use App\Filament\Resources\Media\Pages\ManageMedia;
use App\Filament\Concerns\AllowsEditors;
use App\Models\Media;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class MediaResource extends Resource
{
    protected static ?string $model = Media::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    use AllowsEditors;

    protected static string|UnitEnum|null $navigationGroup = 'Konten';

    protected static ?string $navigationLabel = 'Pustaka media';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('url')
                    ->label('Unggah file')
                    ->disk('public')
                    ->directory('media')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'application/pdf'])
                    ->maxSize(10240)
                    ->required(),
                TextInput::make('file_name')->label('Nama file')->required()->maxLength(255),
                TextInput::make('alt_text')->label('Teks alternatif / deskripsi')->required()->maxLength(255),
                TextInput::make('credit')->label('Kredit foto / sumber')->maxLength(190),
                Toggle::make('consent_ok')->label('Izin penggunaan telah dikonfirmasi')->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('file_name')->label('File')->searchable()->limit(45),
                TextColumn::make('mime_type')->label('Jenis')->badge(),
                TextColumn::make('size_bytes')->label('Ukuran (KB)')->formatStateUsing(fn (?int $state): string => $state ? number_format($state / 1024, 0, ',', '.').' KB' : '—'),
                TextColumn::make('alt_text')->label('Teks alternatif')->limit(45),
                IconColumn::make('consent_ok')->label('Izin')->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
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
            'index' => ManageMedia::route('/'),
        ];
    }
}
