<?php

namespace App\Filament\Resources\Todos;

use App\Filament\Resources\Todos\Pages\CreateTodo;
use App\Filament\Resources\Todos\Pages\EditTodo;
use App\Filament\Resources\Todos\Pages\ListTodos;
use App\Filament\Resources\Todos\Schemas\TodoForm;
use App\Filament\Resources\Todos\Tables\TodosTable;
use App\Models\Todo;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TodoResource extends Resource
{
    protected static ?string $model = Todo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'todo';

    protected static bool $shouldRegisterNavigation = false;
    public static function form(Schema $schema): Schema
    {
          return $schema
        ->components([
            Textarea::make('content')
                ->label('Task')
                ->required()
                ->rows(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        // return TodosTable::configure($table);
         return $table
        ->columns([
            TextColumn::make('content')
                ->label('Task')
                ->searchable()
                ->weight('bold'),
                // ->limit(50),

            IconColumn::make('completed_at')
                ->label('Done')
                ->boolean(fn ($record) => $record->completed_at !== null),

            TextColumn::make('created_at')
                ->label('Created')
                ->dateTime('d M Y'),
        ])
        ->actions([
            EditAction::make(),

            Action::make('complete')
                ->icon('heroicon-o-check')
                ->color('success')
                ->action(function ($record) {
                    $record->update([
                        'completed_at' => now(),
                    ]);
                })
                ->visible(fn ($record) => !$record->completed_at),

            DeleteAction::make(),
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
            'index' => ListTodos::route('/'),
            'create' => CreateTodo::route('/create'),
            'edit' => EditTodo::route('/{record}/edit'),
        ];
    }
}
