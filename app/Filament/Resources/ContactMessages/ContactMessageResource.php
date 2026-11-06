<?php

namespace App\Filament\Resources\ContactMessages;

use App\Filament\Resources\ContactMessages\Pages\ManageContactMessages;
use App\Models\ContactMessage;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Interaksi pengunjung';

    protected static ?string $navigationLabel = 'Pesan masuk';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Nama')->disabled(),
                TextInput::make('email')->label('Email')->disabled(),
                TextInput::make('organization')->label('Organisasi')->disabled(),
                TextInput::make('topic')->label('Topik')->disabled(),
                Textarea::make('message')->label('Pesan')->rows(8)->disabled()->columnSpanFull(),
                Select::make('status')->label('Status tindak lanjut')->options([
                    'new' => 'Baru',
                    'read' => 'Dibaca',
                    'replied' => 'Dibalas',
                    'spam' => 'Spam',
                ])->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('organization')->label('Organisasi')->placeholder('—'),
                TextColumn::make('topic')->label('Topik')->badge(),
                TextColumn::make('status')->label('Status')->badge()->color(fn (string $state): string => match ($state) {
                    'new' => 'danger',
                    'read' => 'warning',
                    'replied' => 'success',
                    default => 'gray',
                }),
                TextColumn::make('created_at')->label('Diterima')->dateTime('d M Y, H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'new' => 'Baru',
                    'read' => 'Dibaca',
                    'replied' => 'Dibalas',
                    'spam' => 'Spam',
                ]),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageContactMessages::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()?->role === 'admin';
    }
}
