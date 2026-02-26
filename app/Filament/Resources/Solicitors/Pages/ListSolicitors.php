<?php

namespace App\Filament\Resources\Solicitors\Pages;

use App\Filament\Resources\Solicitors\SolicitorResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSolicitors extends ListRecords
{
    protected static string $resource = SolicitorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn () =>
                    auth()->user()?->isAdmin() || auth()->user()?->isSuperAdmin()
                ),
        ];
    }
}
