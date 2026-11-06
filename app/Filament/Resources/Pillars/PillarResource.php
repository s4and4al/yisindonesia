<?php

namespace App\Filament\Resources\Pillars;

use App\Filament\Resources\Pillars\Pages\ManagePillars;
use App\Filament\Concerns\AllowsEditors;
use App\Models\Pillar;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class PillarResource extends Resource
{
    protected static ?string $model = Pillar::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    use AllowsEditors;

    protected static string|UnitEnum|null $navigationGroup = 'Profil YISI';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Nama pilar')->required()->maxLength(120),
                TextInput::make('slug')->label('Slug')->required()->maxLength(120)->unique(ignoreRecord: true),
                Textarea::make('summary')->label('Ringkasan')->maxLength(500)->rows(3),
                ColorPicker::make('color_hex')->label('Warna pilar'),
                TextInput::make('sort_order')->label('Urutan tampil')->numeric()->default(0)->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Pilar')->searchable()->sortable(),
                TextColumn::make('slug')->label('Slug'),
                TextColumn::make('color_hex')->label('Warna'),
                TextColumn::make('sort_order')->label('Urutan')->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePillars::route('/'),
        ];
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }
}
