<?php

namespace App\Filament\Resources\Doctors;

use BackedEnum;
use App\Models\Doctor;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\BaseResource;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Doctors\Pages\EditDoctor;
use App\Filament\Resources\Doctors\Pages\ListDoctors;
use App\Filament\Resources\Doctors\Pages\CreateDoctor;
use App\Filament\Resources\Doctors\Schemas\DoctorForm;
use App\Filament\Resources\Doctors\Tables\DoctorsTable;

class DoctorResource extends BaseResource
{
    protected static ?string $model = Doctor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserCircle;

    public static function form(Schema $schema): Schema
    {
        return DoctorForm::configure($schema)

         ->schema([

            /* =============================
             * HERO: BASIC DETAILS
             * ============================= */
            Section::make('Doctor Profile')
                ->description('Core information and availability status')
                ->icon('heroicon-o-identification')
                ->columnSpanFull()
                ->columns(12)
                ->schema([

                    TextInput::make('name')
                        ->columnSpan(4)
                        ->required(),

                    TextInput::make('email')
                        ->email()
                        ->columnSpan(4)
                        ->required(),

                    TextInput::make('contact_number')
                        ->tel()
                        ->columnSpan(4),

                    TextInput::make('expertise')
                        ->columnSpan(4)
                        ->required(),

                    TextInput::make('experience_years')
                        ->label('Years of Experience')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(60)
                        ->columnSpan(4)
                        ->required(),

                    // Toggle::make('is_active')
                    //     ->label('Active')
                    //     ->inline(false)
                    //     ->columnSpan(4),

                    Textarea::make('bio')
                        ->columnSpan(4),
                ]),

            /* =============================
             * DOCUMENTS – CLEAN CARDS
             * ============================= */
            Section::make('Compliance Documents')
                ->description('Upload documents and manage validity dates')
                ->icon('heroicon-o-shield-check')
                ->columnSpanFull()
                ->schema([

                    Grid::make(2)
                        ->columnSpanFull()
                        ->schema([

                            /* CARD 1 */
                            Group::make()
                                ->schema([
                                    FileUpload::make('pii_document')
                                        ->label('Personal Indemnity Insurance')
                                        ->directory('doctors/pii')
                                        ->acceptedFileTypes(['application/pdf', 'image/*'])
                                        ->downloadable()
                                        ->openable(),

                                    Grid::make(2)->schema([
                                        DatePicker::make('pii_issue_date')->label('Issue'),
                                        DatePicker::make('pii_expiry_date')->label('Expiry'),
                                    ]),
                                ])
                                ->extraAttributes([
                                    'class' => 'rounded-xl bg-white shadow-sm p-6',
                                ]),

                            /* CARD 2 */
                            Group::make()
                                ->schema([
                                    FileUpload::make('pli_document')
                                        ->label('Public Liability Insurance')
                                        ->directory('doctors/pli')
                                        ->acceptedFileTypes(['application/pdf', 'image/*'])
                                        ->downloadable()
                                        ->openable(),

                                    Grid::make(2)->schema([
                                        DatePicker::make('pli_issue_date')->label('Issue'),
                                        DatePicker::make('pli_expiry_date')->label('Expiry'),
                                    ]),
                                ])
                                ->extraAttributes([
                                    'class' => 'rounded-xl bg-white shadow-sm p-6',
                                ]),

                            /* CARD 3 */
                            Group::make()
                                ->schema([
                                    FileUpload::make('ico_document')
                                        ->label('ICO Certificate')
                                        ->directory('doctors/ico')
                                        ->acceptedFileTypes(['application/pdf', 'image/*'])
                                        ->downloadable()
                                        ->openable(),

                                    Grid::make(2)->schema([
                                        DatePicker::make('ico_issue_date')->label('Issue'),
                                        DatePicker::make('ico_expiry_date')->label('Expiry'),
                                    ]),
                                ])
                                ->extraAttributes([
                                    'class' => 'rounded-xl bg-white shadow-sm p-6',
                                ]),

                            /* CARD 4 */
                            Group::make()
                                ->schema([
                                    FileUpload::make('dbs_document')
                                        ->label('DBS Certificate')
                                        ->directory('doctors/dbs')
                                        ->acceptedFileTypes(['application/pdf', 'image/*'])
                                        ->downloadable()
                                        ->openable(),

                                    Grid::make(2)->schema([
                                        DatePicker::make('dbs_issue_date')->label('Issue'),
                                        DatePicker::make('dbs_expiry_date')->label('Expiry'),
                                    ]),
                                ])
                                ->extraAttributes([
                                    'class' => 'rounded-xl bg-white shadow-sm p-6',
                                ]),

                            /* CARD 5 – FULL WIDTH */
                            Group::make()
                                ->columnSpanFull()
                                ->schema([
                                    FileUpload::make('cv_document')
                                        ->label('Curriculum Vitae (CV)')
                                        ->directory('doctors/cv')
                                        ->acceptedFileTypes(['application/pdf'])
                                        ->downloadable()
                                        ->openable(),
                                ])
                                ->extraAttributes([
                                    'class' => 'rounded-xl bg-white shadow-sm p-6',
                                ]),
                        ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return DoctorsTable::configure($table)

         ->columns([
            TextColumn::make('name')->searchable(),
            TextColumn::make('email'),
            TextColumn::make('contact_number'),
            TextColumn::make('expertise'),
            TextColumn::make('bio'),
            TextColumn::make('experience_years')
                ->label('Experience (Years)')
                ->sortable(),

            IconColumn::make('is_active')
                ->label('Status')
                ->boolean(),
         ])
          ->actions([
            EditAction::make()
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
            'index' => ListDoctors::route('/'),
            'create' => CreateDoctor::route('/create'),
            'edit' => EditDoctor::route('/{record}/edit'),
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
