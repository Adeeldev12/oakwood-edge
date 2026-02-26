<?php

namespace App\Filament\Resources\DoctorInvoices\Pages;

use App\Filament\Resources\DoctorInvoices\DoctorInvoiceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDoctorInvoice extends CreateRecord
{
    protected static string $resource = DoctorInvoiceResource::class;
}
