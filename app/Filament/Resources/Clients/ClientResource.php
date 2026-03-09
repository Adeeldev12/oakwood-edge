<?php

namespace App\Filament\Resources\Clients;

use App\Filament\Resources\BaseResource;
use App\Filament\Resources\Clients\Pages\CreateClient;
use App\Filament\Resources\Clients\Pages\EditClient;
use App\Filament\Resources\Clients\Pages\ListClients;
use App\Filament\Resources\Clients\Schemas\ClientForm;
use App\Filament\Resources\Clients\Tables\ClientsTable;
use App\Models\Client;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ClientResource extends BaseResource
{
    protected static ?string $model = Client::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    // protected static string|Heroicon|null $navigationIcon =
    // Heroicon::OutlinedUsers;

    protected static ?string $recordTitleAttribute = 'nt-resource Invoice';

    public static function form(Schema $schema): Schema
    {
        return ClientForm::configure($schema)
            ->schema([

                /* =========================
             | Client Information
             ========================= */
                Section::make('Client Information')
                    ->icon('heroicon-o-user')
                    ->description('Basic client and solicitor details')
                    ->columns(3)
                    ->schema([

                        TextInput::make('ref_no')
                            ->label('Reference No')
                            ->maxLength(100),

                        TextInput::make('client_name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),

                            TextInput::make('mobile_number')
                            ->label('Mobile Number')
                            ->tel()
                            ->columnSpan(1),

                        TextInput::make('email')
                            ->email()
                            ->label('Client Email')
                            ->columnSpan(2),

                        TextInput::make('sol_ref')
                            ->label('Solicitor Ref')
                            ->maxLength(100),

                        Select::make('solicitor_id')
                            ->label('Solicitor')
                            ->relationship('solicitor', 'name')
                              // ->searchable()
                            ->native(false)
                              // ->preload()
                            ->columnSpan(2),



                        // FileUpload::make('loi_bundle')
                        //     ->label('LOI & Bundle')
                        //     ->multiple()
                        //     ->disk('public')
                        //     ->visibility('public') // 🔥 ADD THIS
                        //     ->directory('clients/loi-bundles')
                        //     ->preserveFilenames()
                        //     ->maxSize(51200) // 50 MB per file
                        //     ->acceptedFileTypes([
                        //             'application/pdf',
                        //             'application/msword',
                        //             'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        //             'application/vnd.ms-excel',
                        //             'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        //             'image/*',
                        //     ])
                        //     ->downloadable()
                        //     ->openable()
                        //     ->previewable(true)
                        //     ->columnSpan(3),

                    ]),

                /* =========================
             | Claim & Expert
             ========================= */
                Section::make('Claim & Expert Details')
                    ->icon('heroicon-o-briefcase')
                    ->description('Type of claim and assigned expert')
                    ->columns(1)
                    ->schema([

                        Select::make('claim_type')
                            ->options([
                                'GP' => 'GP',
                                'Psychiatrist' => 'Psychiatrist',
                                'Psychologist' => 'Psychologist',
                                'X-Ray review' => 'X-Ray review',
                                'Country Expert' => 'Country Expert',
                            ])
                            ->searchable()
                            ->required(),

                        TextInput::make('expert_name')
                            ->label('Expert')
                            ->columnSpan(2),

                        DatePicker::make('instruction_date')
                            ->label('Date of Instruction')
                            ->native(false),
                    ]),

                /* =========================
             | Appointment Details
             ========================= */
                Section::make('Appointment Details')
                    ->icon('heroicon-o-calendar')
                    ->description('Appointment scheduling information')
                    ->columns(2)
                    ->schema([

                        DatePicker::make('appointment_date')
                            ->label('Appointment Date')
                            ->native(false),

                        TimePicker::make('appointment_time')
                            ->placeholder('e.g. 10:00 AM or 6–8 PM')
                            ->seconds(false),

                        Select::make('venue')
                            ->options([
                                'Remote' => 'Remote',
                                'In Person' => 'In Person',
                            ])
                            ->default('Remote')
                            ->native(false),

                        Select::make('medical_attended')
                            ->label('Medical Attended')
                            ->options([
                                'yes' => 'Yes',
                                'no' => 'No',
                            ])->native(false),
                    ]),

                /* =========================
             | Invoice Information
             ========================= */
                Section::make('Invoice Information')
                    ->icon('heroicon-o-document-text')
                    ->description('Invoice reference and payment status')
                    ->columns(2)
                    ->schema([

                        TextInput::make('invoice_no')
                            ->label('Invoice No'),

                        Select::make('invoice_status')
                            ->options([
                                'Paid' => 'Paid',
                                'Sent' => 'Sent',
                                'Pending' => 'Pending',
                            ])
                            ->default('Pending')
                            ->native(false),

                        DatePicker::make('invoice_sent_date')
                            ->label('Invoice Sent Date')
                            ->native(false),

                        Select::make('current_status')
                            ->options([
                                'Done' => 'Done',
                                'Waiting Payment' => 'Waiting Payment',
                                'On Hold' => 'On Hold',
                                'Pending' => 'Pending',
                            ])
                            ->default('Pending')
                            ->native(false),
                    ]),

                Section::make('Cleint Documents')
                    ->icon('heroicon-o-pencil-square')
                    ->schema([

                        FileUpload::make('loi_bundle')
                            ->label('LOI & Bundle')
                            ->multiple()
                            ->disk('public')
                            ->visibility('public') // 🔥 ADD THIS
                            ->directory('clients/loi-bundles')
                            ->preserveFilenames()
                            ->maxSize(51200) // 50 MB per file
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'image/*',
                            ])
                            ->downloadable()
                            ->openable()
                            ->previewable(true)
                            ->columnSpan(3),

                        FileUpload::make('medical_records')
                            ->label('Medical Records')
                            ->directory('medical-records')
                            ->acceptedFileTypes(['application/pdf', 'image/*'])
                           ->maxSize(51200) // 50 MB per file
                            ->downloadable()
                            ->openable(),

                        FileUpload::make('supporting_records')
                            ->label('Supporting / Relevant Records')
                            ->directory('supporting-records')
                            ->acceptedFileTypes(['application/pdf', 'image/*'])
                            ->maxSize(51200) // 50 MB per file
                            ->downloadable()
                            ->openable(),
                    ]),
                /* =========================
             | Report & Status
             ========================= */
                Section::make('Report & Status')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->description('Report delivery and progress')
                    ->columns(2)
                    ->schema([

                        Select::make('report_status')
                            ->options([
                                'sent' => 'Sent',
                                'pending' => 'Pending',
                                'yes' => 'Yes',
                            ])
                            ->native(false),

                        DatePicker::make('report_sent_date')
                            ->label('Report Sent Date')
                            ->native(false),
                    ]),

                //     /* =========================
                //  | Notes
                //  ========================= */
                //     Section::make('Additional Notes')
                //         ->icon('heroicon-o-pencil-square')
                //         ->schema([

                //             Textarea::make('notes')
                //                 ->rows(4)
                //                 ->placeholder('Internal notes, comments, or special instructions...')
                //                 ->columnSpanFull(),
                //         ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return ClientsTable::configure($table)
            ->columns([

                TextColumn::make('id')
                    ->searchable()
                    ->sortable()
                    ->label('NO'),

                TextColumn::make('client_name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('ref_no')
                    ->label('Ref No')
                    ->searchable(),

                TextColumn::make('solicitor.name')
                    ->label('Solicitor')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('mobile_number')
                    ->toggleable(),

                BadgeColumn::make('claim_type')
                    ->colors([
                        'primary' => 'Psychiatrist',
                        'success' => 'Psychologist',
                        'warning' => 'GP',
                    ]),

                TextColumn::make('expert_name')
                    ->label('Expert')
                    ->toggleable(),

                TextColumn::make('instruction_date')
                    ->date()
                    ->sortable(),

                TextColumn::make('invoice_no')
                    ->label('Invoice'),

                BadgeColumn::make('invoice_status')
                    ->colors([
                        'success' => 'Paid',
                        'warning' => 'Sent',
                        'danger' => 'Pending',
                    ]),

                TextColumn::make('appointment_date')
                    ->date()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('appointment_time')
                    ->toggleable(),

                TextColumn::make('venue')
                    ->toggleable(),

                BadgeColumn::make('current_status')
                    ->colors([
                        'success' => 'Done',
                        'warning' => 'Waiting Payment',
                        'danger' => 'On Hold',
                    ]),

                IconColumn::make('loi_bundle')
                    ->label('LOI & Bundle')
                    ->boolean(fn ($record) => ! empty($record->loi_bundle))
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                IconColumn::make('medical_records')
                    ->label('Medical Records')
                    ->boolean(fn ($record) => ! empty($record->medical_records))
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                IconColumn::make('supporting_records')
                    ->label('Supporting Records')
                    ->boolean(fn ($record) => ! empty($record->supporting_records))
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

            ])
            ->defaultSort('instruction_date', 'desc')
            ->filters([])
            ->actions([
                ViewAction::make(),
                EditAction::make()
                    ->visible(fn () => auth()->user()?->isAdmin() || auth()->user()?->isSuperAdmin()
                    ),
                Action::make('openLoi')
                    ->label('Open LOI')
                    ->icon('heroicon-o-document')
                    ->url(fn ($record) => ! empty($record->loi_bundle)
                            ? Storage::disk('public')->url($record->loi_bundle[0])
                            : null
                    )
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => ! empty($record->loi_bundle)),
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
            'index' => ListClients::route('/'),
            'create' => CreateClient::route('/create'),
            'edit' => EditClient::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->isAdmin() || auth()->user()?->isSuperAdmin();
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->isAdmin() || auth()->user()?->isSuperAdmin();
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->isAdmin() || auth()->user()?->isSuperAdmin();
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()?->isAdmin() || auth()->user()?->isSuperAdmin();
    }
}
