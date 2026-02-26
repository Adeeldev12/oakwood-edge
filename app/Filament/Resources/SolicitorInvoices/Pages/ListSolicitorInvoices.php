<?php

namespace App\Filament\Resources\SolicitorInvoices\Pages;

use App\Filament\Resources\SolicitorInvoices\SolicitorInvoiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSolicitorInvoices extends ListRecords
{
    protected static string $resource = SolicitorInvoiceResource::class;

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
