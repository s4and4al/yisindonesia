<?php

namespace App\Filament\Resources\Tags;

use App\Filament\Resources\Tags\Pages\ManageTags;
use App\Filament\Concerns\AllowsEditors;
use App\Models\Tag;
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
use Illuminate\Support\Str;
use UnitEnum;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    use AllowsEditors;

    protected static string|UnitEnum|null $navigationGroup = 'Konten';

    protected static ?string $navigationLabel = 'Tag artikel';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Nama tag')->required()->maxLength(80)->live(onBlur: true)
                    ->afterStateUpdated(fn (?string $state, callable $set) => $set('slug', Str::slug($state ?? ''))),
                TextInput::make('slug')->label('Slug')->required()->maxLength(100)->unique(ignoreRecord: true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Tag')->searchable()->sortable(),
                TextColumn::make('slug')->label('Slug'),
                TextColumn::make('posts_count')->label('Artikel')->counts('posts'),
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
            'index' => ManageTags::route('/'),
        ];
    }
}
