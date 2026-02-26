<?php

namespace App\Filament\Resources\Interpreters\Pages;

use App\Filament\Resources\Interpreters\InterpreterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInterpreters extends ListRecords
{
    protected static string $resource = InterpreterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn () =>
                    auth()->user()?->isAdmin() || auth()->user()?->isSuperAdmin()
                ),
        ];
    }
}
