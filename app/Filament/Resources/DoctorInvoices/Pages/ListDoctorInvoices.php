<?php

namespace App\Filament\Resources\DoctorInvoices\Pages;

use App\Filament\Resources\DoctorInvoices\DoctorInvoiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDoctorInvoices extends ListRecords
{
    protected static string $resource = DoctorInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn () =>
                    auth()->user()?->isAdmin() || auth()->user()?->isSuperAdmin()
                ),
            //      Actions\Action::make('generateInvoice')
            // ->label('Generate Invoice')
            // ->icon('heroicon-o-document-arrow-down')
            // ->color('primary')
            // ->action(function () {
            //     $invoice = $this->record;

            //     $pdf = Pdf::loadView('invoices.doctor-invoice', [
            //         'invoice' => $invoice,
            //     ]);

            //     return response()->streamDownload(
            //         fn () => print($pdf->output()),
            //         'doctor-invoice-' . $invoice->invoice_no . '.pdf'
            //     );
            // }),
        ];
    }
}
