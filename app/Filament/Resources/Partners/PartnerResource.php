<?php

namespace App\Filament\Resources\Partners;

use App\Filament\Resources\Partners\Pages\ManagePartners;
use App\Filament\Concerns\AllowsEditors;
use App\Filament\Concerns\UsesMediaUpload;
use App\Models\Partner;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    use AllowsEditors;
    use UsesMediaUpload;

    protected static string|UnitEnum|null $navigationGroup = 'Konten';

    protected static ?string $navigationLabel = 'Mitra';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Nama mitra')->required()->maxLength(190)->live(onBlur: true)
                    ->afterStateUpdated(fn (?string $state, callable $set) => $set('slug', Str::slug($state ?? ''))),
                TextInput::make('slug')->label('Slug')->required()->maxLength(200)->unique(ignoreRecord: true),
                TextInput::make('website_url')->label('Situs web')->url()->maxLength(300),
                Select::make('partner_type')->label('Jenis mitra')->options([
                    'korporasi' => 'Korporasi',
                    'pemerintah' => 'Pemerintah',
                    'donor' => 'Donor',
                    'akademisi' => 'Akademisi',
                    'komunitas' => 'Komunitas',
                ]),
                static::mediaUpload('logo_media_id', 'Logo', 'Logo mitra'),
                Toggle::make('show_logo')->label('Izin tertulis untuk menampilkan logo telah diperoleh')->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')->label('Mitra')->searchable()->sortable(),
                TextColumn::make('partner_type')->label('Jenis')->badge(),
                IconColumn::make('show_logo')->label('Izin logo')->boolean(),
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
            'index' => ManagePartners::route('/'),
        ];
    }
}
