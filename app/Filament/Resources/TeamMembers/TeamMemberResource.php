<?php

namespace App\Filament\Resources\TeamMembers;

use App\Filament\Resources\TeamMembers\Pages\ManageTeamMembers;
use App\Filament\Concerns\AllowsEditors;
use App\Filament\Concerns\UsesMediaUpload;
use App\Models\TeamMember;
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
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class TeamMemberResource extends Resource
{
    protected static ?string $model = TeamMember::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    use AllowsEditors;
    use UsesMediaUpload;

    protected static string|UnitEnum|null $navigationGroup = 'Profil YISI';

    protected static ?string $navigationLabel = 'Tim';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Nama')->required()->maxLength(150),
                TextInput::make('position')->label('Jabatan')->required()->maxLength(150),
                TextInput::make('group_name')->label('Kelompok')->placeholder('Organ Yayasan, Manajemen, Divisi')->required()->maxLength(80),
                TextInput::make('division')->label('Divisi')->maxLength(190),
                static::mediaUpload('photo_media_id', 'Foto', 'Foto anggota tim'),
                TextInput::make('sort_order')->label('Urutan tampil')->numeric()->default(0)->required(),
                Toggle::make('is_visible')->label('Tampilkan di website')->default(true),
                MarkdownEditor::make('bio')->label('Biografi singkat')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                TextColumn::make('position')->label('Jabatan')->searchable(),
                TextColumn::make('group_name')->label('Kelompok')->badge(),
                IconColumn::make('is_visible')->label('Tampil')->boolean(),
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
            'index' => ManageTeamMembers::route('/'),
        ];
    }
}
