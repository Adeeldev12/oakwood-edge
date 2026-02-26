<?php

namespace App\Filament\Resources\Interpreters\Schemas;

use Filament\Schemas\Schema;

class InterpreterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }
}
