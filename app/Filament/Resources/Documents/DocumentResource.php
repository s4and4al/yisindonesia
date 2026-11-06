<?php

namespace App\Filament\Resources\Documents;

use App\Filament\Resources\Documents\Pages\ManageDocuments;
use App\Filament\Concerns\AllowsEditors;
use App\Models\Document;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    use AllowsEditors;

    protected static string|UnitEnum|null $navigationGroup = 'Konten';

    protected static ?string $navigationLabel = 'Dokumen';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->label('Judul dokumen')->required()->maxLength(220),
                Select::make('doc_type')->label('Jenis')->options([
                    'laporan' => 'Laporan',
                    'kajian' => 'Kajian',
                    'legalitas' => 'Legalitas',
                    'lainnya' => 'Lainnya',
                ])->required()->default('lainnya'),
                Select::make('media_id')->label('File')->relationship('media', 'file_name')->searchable()->preload()->required(),
                Select::make('program_id')->label('Program terkait')->relationship('program', 'title')->searchable()->preload(),
                TextInput::make('year')->label('Tahun')->numeric()->minValue(2000)->maxValue(2100),
                Toggle::make('is_public')->label('Publikasikan dokumen')->default(false),
                MarkdownEditor::make('description')->label('Deskripsi (Markdown)')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Dokumen')->searchable()->sortable(),
                TextColumn::make('doc_type')->label('Jenis')->badge(),
                TextColumn::make('year')->label('Tahun')->sortable(),
                TextColumn::make('media.file_name')->label('File'),
                IconColumn::make('is_public')->label('Publik')->boolean(),
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
            'index' => ManageDocuments::route('/'),
        ];
    }
}
