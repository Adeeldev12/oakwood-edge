<?php

namespace App\Filament\Resources;

use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;

abstract class BaseResource extends Resource
{
    // Everyone can see the resource
    public static function canViewAny(): bool
    {
        return true;
    }

    // Everyone can view records
    public static function canView(Model $record): bool
    {
        return true;
    }

    // ONLY admin & superadmin can create
    public static function canCreate(): bool
    {
        return auth()->user()?->isAdmin() || auth()->user()?->isSuperAdmin();
    }

    // ONLY admin & superadmin can edit
    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->isAdmin() || auth()->user()?->isSuperAdmin();
    }

    // ONLY admin & superadmin can delete
    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->isAdmin() || auth()->user()?->isSuperAdmin();
    }

    // Bulk delete restriction
    public static function canDeleteAny(): bool
    {
        return auth()->user()?->isAdmin() || auth()->user()?->isSuperAdmin();
    }
}
