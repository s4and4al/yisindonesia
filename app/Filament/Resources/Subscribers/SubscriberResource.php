<?php

namespace App\Filament\Resources\Subscribers;

use App\Filament\Resources\Subscribers\Pages\ManageSubscribers;
use App\Filament\Concerns\AllowsAdministrators;
use App\Models\Subscriber;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class SubscriberResource extends Resource
{
    protected static ?string $model = Subscriber::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    use AllowsAdministrators;

    protected static string|UnitEnum|null $navigationGroup = 'Interaksi pengunjung';

    protected static ?string $navigationLabel = 'Pelanggan kabar';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('email')->label('Email')->disabled(),
                TextInput::make('name')->label('Nama')->disabled(),
                TextInput::make('consent_at')->label('Persetujuan')->disabled(),
                TextInput::make('confirmed_at')->label('Dikonfirmasi')->disabled(),
                TextInput::make('unsubscribed_at')->label('Berhenti')->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email')->label('Email')->searchable()->sortable(),
                TextColumn::make('name')->label('Nama')->placeholder('—'),
                TextColumn::make('confirmed_at')->label('Status')->badge()->getStateUsing(fn (Subscriber $record): string => match (true) {
                    filled($record->unsubscribed_at) => 'Berhenti',
                    filled($record->confirmed_at) => 'Aktif',
                    default => 'Menunggu konfirmasi',
                })->color(fn (string $state): string => match ($state) {
                    'Aktif' => 'success',
                    'Berhenti' => 'gray',
                    default => 'warning',
                }),
                TextColumn::make('consent_at')->label('Persetujuan')->dateTime('d M Y, H:i')->sortable(),
            ])
            ->filters([])
            ->recordActions([
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageSubscribers::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }
}
