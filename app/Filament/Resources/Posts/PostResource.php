<?php

namespace App\Filament\Resources\Posts;

use App\Filament\Concerns\UsesMediaUpload;
use App\Filament\Resources\Posts\Pages\ManagePosts;
use App\Models\Post;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use UnitEnum;

class PostResource extends Resource
{
    use UsesMediaUpload;

    protected static ?string $model = Post::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Konten';

    protected static ?string $navigationLabel = 'Artikel';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->maxLength(220)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (?string $state, callable $set) => $set('slug', Str::slug($state ?? ''))),
                TextInput::make('slug')
                    ->label('URL artikel')
                    ->required()
                    ->maxLength(240)
                    ->unique(ignoreRecord: true),
                Textarea::make('excerpt')
                    ->label('Ringkasan')
                    ->rows(3)
                    ->maxLength(400)
                    ->columnSpanFull(),
                Textarea::make('content')
                    ->label('Isi artikel (Markdown)')
                    ->required()
                    ->rows(14)
                    ->columnSpanFull(),
                static::mediaUpload('cover_media_id', 'Gambar utama', 'Gambar utama artikel'),
                Select::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                Select::make('tags')->label('Tag')->relationship('tags', 'name')->multiple()->searchable()->preload(),
                Select::make('programs')->label('Program terkait')->relationship('programs', 'title')->multiple()->searchable()->preload(),
                Select::make('author_id')
                    ->label('Penulis')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload()
                    ->visible(fn (): bool => auth()->user()?->role !== 'author'),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draf',
                        'review' => 'Perlu ditinjau',
                        'scheduled' => 'Terjadwal',
                        'published' => 'Terbit',
                        'archived' => 'Arsip',
                    ])
                    ->default('draft')
                    ->required()
                    ->visible(fn (): bool => auth()->user()?->role !== 'author'),
                DateTimePicker::make('published_at')
                    ->label('Waktu terbit')
                    ->required(fn (Get $get): bool => $get('status') === 'published')
                    ->visible(fn (): bool => auth()->user()?->role !== 'author'),
                Toggle::make('is_featured')->label('Tampilkan sebagai unggulan'),
                TextInput::make('seo_title')->label('Judul SEO')->maxLength(160),
                Textarea::make('seo_description')->label('Deskripsi SEO')->rows(2)->maxLength(300),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Judul')->searchable()->sortable()->limit(55),
                TextColumn::make('category.name')->label('Kategori')->placeholder('—'),
                TextColumn::make('status')->label('Status')->badge()->color(fn (string $state): string => match ($state) {
                    'published' => 'success',
                    'review', 'scheduled' => 'warning',
                    'archived' => 'gray',
                    default => 'gray',
                }),
                TextColumn::make('published_at')->label('Tanggal terbit')->dateTime('d M Y')->sortable()->placeholder('Belum dijadwalkan'),
                TextColumn::make('view_count')->label('Dibaca')->numeric()->sortable(),
                TextColumn::make('author.name')->label('Penulis')->placeholder('—'),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'draft' => 'Draf',
                    'review' => 'Perlu ditinjau',
                    'scheduled' => 'Terjadwal',
                    'published' => 'Terbit',
                    'archived' => 'Arsip',
                ]),
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
            'index' => ManagePosts::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()->with(['category', 'author']);

        if (auth()->user()?->role === 'author') {
            $query->where('author_id', auth()->id());
        }

        return $query;
    }

    public static function canEdit(Model $record): bool
    {
        return match (auth()->user()?->role) {
            'admin', 'editor' => true,
            'author' => $record->author_id === auth()->id() && in_array($record->status, ['draft', 'review'], true),
            default => false,
        };
    }

    public static function canDelete(Model $record): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'editor'], true);
    }

    public static function canDeleteAny(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'editor'], true);
    }
}
