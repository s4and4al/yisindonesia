<?php

namespace App\Filament\Concerns;

use Illuminate\Database\Eloquent\Model;

trait AllowsAdministrators
{
    public static function canViewAny(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()?->role === 'admin';
    }
}
