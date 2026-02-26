<?php

namespace App\Filament\Resources\Interpreters\Pages;

use App\Filament\Resources\Interpreters\InterpreterResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInterpreter extends EditRecord
{
    protected static string $resource = InterpreterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
