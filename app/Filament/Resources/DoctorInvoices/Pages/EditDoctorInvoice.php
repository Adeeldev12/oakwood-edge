<?php

namespace App\Filament\Resources\DoctorInvoices\Pages;

use App\Filament\Resources\DoctorInvoices\DoctorInvoiceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDoctorInvoice extends EditRecord
{
    protected static string $resource = DoctorInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
