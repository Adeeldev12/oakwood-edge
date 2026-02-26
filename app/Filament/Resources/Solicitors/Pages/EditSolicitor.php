<?php

namespace App\Filament\Resources\Solicitors\Pages;

use App\Filament\Resources\Solicitors\SolicitorResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditSolicitor extends EditRecord
{
    protected static string $resource = SolicitorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
