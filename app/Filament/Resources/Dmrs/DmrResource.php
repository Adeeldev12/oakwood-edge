<?php

namespace App\Filament\Resources\Dmrs;

use App\Filament\Resources\Dmrs\Pages\CreateDmr;
use App\Filament\Resources\Dmrs\Pages\EditDmr;
use App\Filament\Resources\Dmrs\Pages\ListDmrs;
use App\Filament\Resources\Dmrs\Schemas\DmrForm;
use App\Filament\Resources\Dmrs\Tables\DmrsTable;
use App\Models\Dmr;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DmrResource extends Resource
{
    protected static ?string $model = Dmr::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'DMR';

    public static function form(Schema $schema): Schema
    {
        return DmrForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DmrsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDmrs::route('/'),
            'create' => CreateDmr::route('/create'),
            'edit' => EditDmr::route('/{record}/edit'),
        ];
    }
}
