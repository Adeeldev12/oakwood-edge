<?php

namespace App\Filament\Resources\Dmrs\Pages;

use App\Filament\Resources\Dmrs\DmrResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDmr extends EditRecord
{
    protected static string $resource = DmrResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
