<?php

namespace App\Filament\Resources\DoctorInvoices\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DoctorInvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('doctor_name')
                    ->required(),
                TextInput::make('our_ref')
                    ->required(),
                TextInput::make('client_name')
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Select::make('payment_status')
                    ->options(['paid' => 'Paid', 'unpaid' => 'Unpaid'])
                    ->default('unpaid')
                    ->required(),
            ]);
    }
}
