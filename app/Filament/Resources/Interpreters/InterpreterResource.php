<?php

namespace App\Filament\Resources\Interpreters;

use BackedEnum;
use Filament\Tables\Table;
use App\Models\Interpreter;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\BaseResource;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\Interpreters\Pages\EditInterpreter;
use App\Filament\Resources\Interpreters\Pages\ListInterpreters;
use App\Filament\Resources\Interpreters\Pages\CreateInterpreter;
use App\Filament\Resources\Interpreters\Schemas\InterpreterForm;
use App\Filament\Resources\Interpreters\Tables\InterpretersTable;

class InterpreterResource extends BaseResource
{
    protected static ?string $model = Interpreter::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLanguage;

    public static function form(Schema $schema): Schema
    {
        return InterpreterForm::configure($schema)

        ->components([
                TextInput::make('interpreter_name')
            ->label('Interpreter Name')
            ->required()
            ->maxLength(255),

        TextInput::make('national_language')
            ->label('National Language')
            ->required()
            ->maxLength(255),

        TextInput::make('mobile_number')
            ->label('Mobile Number')
            ->tel()
            ->required()
            ->maxLength(20),

        TextInput::make('email')
            ->email()
            ->maxLength(255),

        Textarea::make('address')
            ->rows(3)
            ->columnSpanFull(),

        TextInput::make('referral')
            ->maxLength(255),

    ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return InterpretersTable::configure($table)

         ->columns([

            TextColumn::make('interpreter_name')
                ->label('Interpreter')
                ->searchable()
                ->sortable(),

            TextColumn::make('national_language')
                ->label('Language')
                ->searchable(),

            TextColumn::make('mobile_number')
                ->label('Mobile'),

            TextColumn::make('email')
                ->searchable(),

            TextColumn::make('referral')
                ->toggleable(),

        ])
        ->defaultSort('created_at', 'desc')
        ->actions([
            EditAction::make()
                ->visible(fn () =>
                    auth()->user()?->isAdmin() || auth()->user()?->isSuperAdmin()
                ),
        ])
        ->bulkActions([
            DeleteBulkAction::make(),
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
            'index' => ListInterpreters::route('/'),
            'create' => CreateInterpreter::route('/create'),
            'edit' => EditInterpreter::route('/{record}/edit'),
        ];
    }
}
