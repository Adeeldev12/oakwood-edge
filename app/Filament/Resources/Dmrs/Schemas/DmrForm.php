<?php

namespace App\Filament\Resources\Dmrs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DmrForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('solicitor_id')
                    ->required()
                    ->numeric(),
                TextInput::make('year')
                    ->required()
                    ->numeric(),
                TextInput::make('month')
                    ->required()
                    ->numeric(),
                TextInput::make('cases')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
