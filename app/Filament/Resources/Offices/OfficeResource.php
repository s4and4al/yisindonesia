<?php

namespace App\Filament\Resources\Offices;

use App\Filament\Resources\Offices\Pages\ManageOffices;
use App\Filament\Concerns\AllowsEditors;
use App\Models\Office;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class OfficeResource extends Resource
{
    protected static ?string $model = Office::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    use AllowsEditors;

    protected static string|UnitEnum|null $navigationGroup = 'Profil YISI';

    protected static ?string $navigationLabel = 'Kantor';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Nama kantor')->required()->maxLength(120),
                TextInput::make('address')->label('Alamat')->required()->maxLength(400)->columnSpanFull(),
                TextInput::make('phone')->label('Telepon')->tel()->maxLength(40),
                TextInput::make('email')->label('Email')->email()->maxLength(190),
                TextInput::make('latitude')->label('Latitude')->numeric()->minValue(-90)->maxValue(90),
                TextInput::make('longitude')->label('Longitude')->numeric()->minValue(-180)->maxValue(180),
                TextInput::make('sort_order')->label('Urutan tampil')->numeric()->default(0)->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Kantor')->searchable()->sortable(),
                TextColumn::make('address')->label('Alamat')->limit(60),
                TextColumn::make('email')->label('Email')->placeholder('—'),
                TextColumn::make('sort_order')->label('Urutan')->sortable(),
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
            'index' => ManageOffices::route('/'),
        ];
    }
}
