<?php

namespace App\Filament\Resources\LegalIdentities;

use App\Filament\Resources\LegalIdentities\Pages\ManageLegalIdentities;
use App\Filament\Concerns\AllowsAdministrators;
use App\Models\LegalIdentity;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class LegalIdentityResource extends Resource
{
    protected static ?string $model = LegalIdentity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    use AllowsAdministrators;

    protected static string|UnitEnum|null $navigationGroup = 'Profil YISI';

    protected static ?string $navigationLabel = 'Identitas legal';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')->label('Kunci')->required()->maxLength(80)->unique(ignoreRecord: true),
                TextInput::make('label')->label('Nama informasi')->required()->maxLength(120),
                TextInput::make('value')->label('Nilai')->required()->maxLength(300),
                TextInput::make('sort_order')->label('Urutan tampil')->numeric()->default(0)->required(),
                Toggle::make('is_public')->label('Tampilkan secara publik')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('label')->label('Informasi')->searchable()->sortable(),
                TextColumn::make('value')->label('Nilai')->limit(55),
                IconColumn::make('is_public')->label('Publik')->boolean(),
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
            'index' => ManageLegalIdentities::route('/'),
        ];
    }
}
