<?php

namespace App\Filament\Resources\SolicitorInvoices\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SolicitorInvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('ref')
                    ->required(),
                Textarea::make('solicitor_address')
                    ->columnSpanFull(),
                TextInput::make('client_name')
                    ->required(),
                Select::make('expert_type')
                    ->options([
            'psychiatrist' => 'Psychiatrist',
            'psychologist' => 'Psychologist',
            'gp' => 'Gp',
            'orthopaedic' => 'Orthopaedic',
            'social_work' => 'Social work',
            'probation_report' => 'Probation report',
            'country_expert' => 'Country expert',
            'cbt' => 'Cbt',
        ])
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
