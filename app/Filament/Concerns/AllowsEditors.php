<?php

namespace App\Filament\Concerns;

use Illuminate\Database\Eloquent\Model;

trait AllowsEditors
{
    public static function canViewAny(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'editor'], true);
    }

    public static function canCreate(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'editor'], true);
    }

    public static function canEdit(Model $record): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'editor'], true);
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
