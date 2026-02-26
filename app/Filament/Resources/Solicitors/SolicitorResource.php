<?php

namespace App\Filament\Resources\Solicitors;

use BackedEnum;
use App\Models\Solicitor;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\BaseResource;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Solicitors\Pages\EditSolicitor;
use App\Filament\Resources\Solicitors\Pages\ListSolicitors;
use App\Filament\Resources\Solicitors\Pages\CreateSolicitor;
use App\Filament\Resources\Solicitors\Schemas\SolicitorForm;
use App\Filament\Resources\Solicitors\Tables\SolicitorsTable;

class SolicitorResource extends BaseResource
{
    protected static ?string $model = Solicitor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    public static function form(Schema $schema): Schema
    {
        return SolicitorForm::configure($schema)

        ->components([
                TextInput::make('name')
                    ->label('Solicitor Name')
                    ->required()
                    ->maxLength(255)
                    ->autofocus(),

                TextInput::make('email')
                    ->label('Solicitor Email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(
                        table: 'solicitors',
                        column: 'email',
                        ignoreRecord: true
                    ),

                TextInput::make('phone')
                    ->label('Solicitor Phone')
                    ->tel()
                    ->numeric()
                    ->required()
                    ->maxLength(20)
                    ->regex('/^[0-9+\-\s]+$/')
                    ->helperText('Numbers, spaces, + and - only'),
            ]);

    }

    public static function table(Table $table): Table
    {
        return SolicitorsTable::configure($table)

            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
             ->actions([
                EditAction::make()
                ->visible(fn () =>
                    auth()->user()?->isAdmin() || auth()->user()?->isSuperAdmin()
                ),
                DeleteAction::make()
                ->visible(fn () =>
                    auth()->user()?->isAdmin() || auth()->user()?->isSuperAdmin()
                ),
             ]);
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
            'index' => ListSolicitors::route('/'),
            'create' => CreateSolicitor::route('/create'),
            'edit' => EditSolicitor::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
