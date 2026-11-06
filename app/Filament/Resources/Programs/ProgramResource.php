<?php

namespace App\Filament\Resources\Programs;

use App\Filament\Resources\Programs\Pages\ManagePrograms;
use App\Models\Program;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Konten';

    protected static ?string $navigationLabel = 'Program';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->label('Nama program')->required()->maxLength(220)->live(onBlur: true)
                    ->afterStateUpdated(fn (?string $state, callable $set) => $set('slug', Str::slug($state ?? ''))),
                TextInput::make('slug')->label('URL program')->required()->maxLength(240)->unique(ignoreRecord: true),
                Textarea::make('summary')->label('Ringkasan')->rows(3)->maxLength(500)->columnSpanFull(),
                MarkdownEditor::make('description')->label('Deskripsi (Markdown)')->columnSpanFull(),
                MarkdownEditor::make('focus_activity')->label('Fokus kegiatan (Markdown)')->columnSpanFull(),
                TextInput::make('location')->label('Lokasi')->maxLength(220),
                TextInput::make('province')->label('Provinsi')->maxLength(80),
                Select::make('cover_media_id')->label('Gambar utama')->relationship('coverMedia', 'file_name')->searchable()->preload(),
                TextInput::make('year_start')->label('Tahun mulai')->numeric()->minValue(2000)->maxValue(2100)->required(),
                TextInput::make('year_end')->label('Tahun selesai')->numeric()->minValue(2000)->maxValue(2100),
                Select::make('status')->label('Status program')->options([
                    'planned' => 'Direncanakan',
                    'ongoing' => 'Berjalan',
                    'completed' => 'Selesai',
                ])->required()->default('completed'),
                Select::make('pillars')->label('Pilar')->relationship()->multiple()->preload()->searchable(),
                Select::make('partners')->label('Mitra')->relationship()->multiple()->preload()->searchable(),
                MarkdownEditor::make('impact_summary')->label('Hasil dan pembelajaran (Markdown)')->columnSpanFull(),
                Select::make('publish_status')->label('Status publikasi')->options([
                    'draft' => 'Draf',
                    'review' => 'Perlu ditinjau',
                    'scheduled' => 'Terjadwal',
                    'published' => 'Terbit',
                    'archived' => 'Arsip',
                ])->required()->default('draft'),
                Toggle::make('is_featured')->label('Tampilkan sebagai unggulan'),
                TextInput::make('seo_title')->label('Judul SEO')->maxLength(160),
                Textarea::make('seo_description')->label('Deskripsi SEO')->rows(2)->maxLength(300),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Program')->searchable()->sortable()->limit(55),
                TextColumn::make('location')->label('Lokasi')->placeholder('—'),
                TextColumn::make('year_start')->label('Mulai')->sortable(),
                TextColumn::make('status')->label('Status program')->badge(),
                TextColumn::make('publish_status')->label('Publikasi')->badge()->color(fn (string $state): string => $state === 'published' ? 'success' : 'gray'),
            ])
            ->filters([
                SelectFilter::make('publish_status')->label('Publikasi')->options([
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
            'index' => ManagePrograms::route('/'),
        ];
    }
}
