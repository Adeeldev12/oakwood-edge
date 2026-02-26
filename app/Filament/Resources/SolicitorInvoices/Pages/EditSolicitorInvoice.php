<?php

namespace App\Filament\Resources\SolicitorInvoices\Pages;

use App\Filament\Resources\SolicitorInvoices\SolicitorInvoiceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSolicitorInvoice extends EditRecord
{
    protected static string $resource = SolicitorInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
