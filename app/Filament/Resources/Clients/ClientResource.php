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
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
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

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;

    // protected static string|Heroicon|null $navigationIcon =
    // Heroicon::OutlinedUsers;

    protected static ?string $recordTitleAttribute = 'nt-resource Invoice';

    public static function form(Schema $schema): Schema
    {
        return ClientForm::configure($schema)
            ->schema([

    //           Section::make('Client Information')
    // ->icon('heroicon-o-user')
    // ->description('Basic client and solicitor details')
    // ->columns(3)
    // ->schema([

    //     TextInput::make('ref_no')
    //         ->label('Reference No')
    //         ->maxLength(100),

    //     TextInput::make('client_name')
    //         ->required()
    //         ->maxLength(255)
    //         ->columnSpan(2),

    //     TextInput::make('mobile_number')
    //         ->label('Mobile Number')
    //         ->tel(),

    //     TextInput::make('email')
    //         ->email()
    //         ->label('Client Email')
    //         ->columnSpan(2),

    //     DatePicker::make('date_of_birth')
    //         ->label('Date of Birth')
    //         ->required(),

    //     TextInput::make('sol_ref')
    //         ->label('Solicitor Ref')
    //         ->maxLength(100),

    //     Select::make('solicitor_id')
    //         ->label('Solicitor')
    //         ->relationship('solicitor', 'name')
    //         ->native(false)
    //         ->columnSpan(2),

    //     // ✅ MAIN TOGGLE
    //     Toggle::make('interpreter_required')
    //         ->label('Interpreter Required')
    //         ->reactive()
    //         ->columnSpanFull(),

    //     // ✅ Choose Mode
    //     Toggle::make('use_existing_interpreter')
    //         ->label('Select Existing Interpreter')
    //         ->reactive()
    //         ->visible(fn ($get) => $get('interpreter_required'))
    //         ->columnSpanFull(),

    //     // =========================
    //     // ✅ EXISTING INTERPRETER
    //     // =========================
    //     Select::make('interpreter_id')
    //         ->label('Interpreter')
    //         ->relationship('interpreter', 'interpreter_name')
    //         ->searchable()
    //         ->preload()
    //         ->native(false)
    //         ->visible(fn ($get) =>
    //             $get('interpreter_required') && $get('use_existing_interpreter')
    //         )
    //         ->required(fn ($get) =>
    //             $get('interpreter_required') && $get('use_existing_interpreter')
    //         )
    //         ->columnSpan(2),

    //     // =========================
    //     // ✅ NEW INTERPRETER FIELDS
    //     // =========================
    //     Grid::make(3)
    //         ->schema([

    //             TextInput::make('interpreter_name')
    //                 ->label('Interpreter Name')
    //                 ->required(fn ($get) =>
    //                     $get('interpreter_required') && !$get('use_existing_interpreter')
    //                 ),

    //             TextInput::make('interpreter_email')
    //                 ->email()
    //                 ->label('Interpreter Email')
    //                 ->required(fn ($get) =>
    //                     $get('interpreter_required') && !$get('use_existing_interpreter')
    //                 ),

    //             TextInput::make('interpreter_language')
    //                 ->label('Language')
    //                 ->required(fn ($get) =>
    //                     $get('interpreter_required') && !$get('use_existing_interpreter')
    //                 ),

    //             TextInput::make('interpreter_ref')
    //                 ->label('Interpreter Ref'),

    //         ])
    //         ->visible(fn ($get) =>
    //             $get('interpreter_required') && !$get('use_existing_interpreter')
    //         )
    //         ->columnSpanFull(),

    Section::make('Client Information')
    ->icon('heroicon-o-user')
    ->description('Basic client and solicitor details')
    ->columns(3)
    ->schema([

        TextInput::make('ref_no')
            ->label('Reference No')
            ->maxLength(100),

        TextInput::make('client_name')
            ->label('Client Name')
            ->required()
            ->maxLength(255)
            ->columnSpan(2),

        TextInput::make('mobile_number')
            ->label('Mobile Number')
            ->tel(),

        TextInput::make('email')
            ->email()
            ->label('Client Email')
            ->columnSpan(2),

        DatePicker::make('date_of_birth')
            ->label('Date of Birth')
            ->native(false)
            ->required(),

        Select::make('solicitor_id')
            ->label('Solicitor')
            ->relationship('solicitor', 'name')
            ->native(false)
            ->columnSpan(2),

            TextInput::make('sol_ref')
            ->label('Solicitor Ref')
            ->maxLength(100),

        // =========================
        // ✅ Interpreter Toggle
        // =========================
        // Toggle::make('interpreter_required')
        //     ->label('Interpreter Required')
        //     ->inline(false)
        //     ->reactive()
        //     ->columnSpan(2)
        //     ->afterStateUpdated(function ($state, callable $set) {
        //         if (!$state) {
        //             $set('interpreter_id', null);
        //             $set('interpreter_ref', null);
        //             $set('interpreter_email', null);
        //             $set('interpreter_language', null);
        //         }
        //     }),

        Select::make('interpreter_required')
    ->label('Interpreter Required')
    ->options([
        1 => 'Yes',
        0 => 'No',
    ])
    ->native(false)
    ->columnspan(2)
    ->reactive(),

        // =========================
        // ✅ Interpreter Fields (Simple)
        // =========================
        Grid::make(3)
            ->schema([

                Select::make('interpreter_id')
                    ->label('Interpreter')
                    ->relationship('interpreter', 'interpreter_name')
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->required(fn ($get) => $get('interpreter_required'))
                    ->columnSpan(2),

                TextInput::make('interpreter_ref')
                    ->label('Interpreter Ref')
                    ->columnSpan(1),
                TextInput::make('interpreter_email')
                ->email()
                    ->label('Interpreter Email')
                    ->columnSpan(2),
                TextInput::make('interpreter_language')
                    ->label('Interpreter Language')
                    ->columnSpan(1),

            ])
            ->visible(fn ($get) => $get('interpreter_required'))
            ->columnSpanFull(),

        /*
        =========================
        🔒 FUTURE (Hybrid Approach)
        =========================

        Toggle::make('use_existing_interpreter')
            ->label('Select Existing Interpreter')
            ->reactive(),

        TextInput::make('interpreter_name'),
        TextInput::make('interpreter_email'),
        TextInput::make('interpreter_language'),
        */
    // ]);
    // ])


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
                                 'immigration' => 'Immigration',
        'family_criminal' => 'Family & Criminal Cases',
        'addendum_waiver' => 'Addendum / Waiver Form',
                            ])
                            ->searchable()
                            ->required()
                            ->columnSpan(2),

                        TextInput::make('expert_name')
                            ->label('Expert')
                            ->columnSpan(2),

                            Select::make('speciality')
    ->label('Speciality')
    ->options([
        'Social Work Reports' => 'Social Work Reports',
        'Orthopaedics' => 'Orthopaedics',
        'Psychiatry' => 'Psychiatry',
        'Psychology' => 'Psychology',
        'Physiotherapy' => 'Physiotherapy',
        'Country Expert' => 'Country Expert',
        'GP Reports' => 'GP Reports',
        'Probation Reports' => 'Probation Reports',
        'Detention Centre Assessment' => 'Detention Centre Assessment',
        'Family & Criminal Law' => 'Family & Criminal Law',
        'Scar Report' => 'Scar Report',
        'ADHD/Anxiety/Stress/mental health awareness report' => 'ADHD/Anxiety/Stress/mental health awareness report',
        'Forensic Scientist' => 'Forensic Scientist',
        'Forensic Psychiatrist' => 'Forensic Psychiatrist',
    ])
    ->required()
    ->native(false)
    ->columnSpan(2),

                        DatePicker::make('instruction_date')
                            ->label('Date of Instruction')
                            ->native(false)
                            ->columnSpan(2),
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
                        ->label('Appointment Time')
                            ->placeholder('e.g. 10:00 AM or 6–8 PM')
                            ->seconds(false),

                        Select::make('medical_attended')
                            ->label('Medical Attended')
                            ->options([
                                'yes' => 'Yes',
                                'no' => 'No',
                            ])->native(false),

                             // ✅ UPDATED VENUE
        Select::make('venue')
            ->label('Venue')
            ->options([
                'remote' => 'Remote',
                'prison' => 'Prison',
                'face_to_face' => 'Face to Face',
            ])
            ->placeholder('Select Venue')
            ->native(false)
            ->reactive()
            ->afterStateUpdated(function ($state, callable $set) {
                // reset all dependent fields
                $set('remote_type', null);
                $set('remote_link', null);
                $set('prison_name', null);
                $set('prison_number', null);
                $set('prison_address', null);
                $set('prison_link', null);
            }),

        // =========================
        // ✅ REMOTE TYPE
        // =========================
        Select::make('remote_type')
            ->label('Remote Type')
            ->options([
                'video' => 'Video Link',
                'whatsapp' => 'WhatsApp Video Call',
                'zoom' => 'Zoom / Google Meet',
            ])
            ->native(false)
            ->visible(fn ($get) => $get('venue') === 'remote')
            ->reactive(),

        TextInput::make('remote_link')
            ->label('Link')
            ->placeholder('Paste meeting link here')
            ->visible(fn ($get) =>
                $get('venue') === 'remote' && $get('remote_type')
            )
            ->columnSpanFull(),

        // =========================
        // ✅ PRISON FIELDS
        // =========================
        Grid::make(2)
            ->schema([

                TextInput::make('prison_name')
                    ->label('Prison Name'),

                TextInput::make('prison_number')
                    ->label('Prison Number'),

                TextInput::make('prison_address')
                    ->label('Prison Address')
                    ->columnSpanFull(),

                TextInput::make('prison_link')
                    ->label('Prison Link')
                    ->columnSpanFull(),

            ])
            ->visible(fn ($get) => $get('venue') === 'prison')
            ->columnSpanFull(),
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
                                'quotation_sent' => 'Quotation Sent',
    'awaiting_payment' => 'Awaiting Payment',
    'payment_received' => 'Payment Received',
    'partial_payment_received' => 'Partial Payment Received',
    'case_settled' => 'Case Settled',
                            ])
                            ->searchable()
                            ->label('Invoice Status')
    ->placeholder('Select Invoice Status')
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
                            ->placeholder('Select an option')
                            ->label('Current Status')
                            ->native(false),
                    ]),

                Section::make('Client Documents')
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
                               'awaiting_appointment' => 'Awaiting Appointment',
    'awaiting_report' => 'Awaiting Report',
    'report_vetting' => 'Report Vetting',
    'report_sent' => 'Report Sent',
    'amendment_required' => 'Amendment Required',
                            ])
                            ->label('Report Status')
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

                TextColumn::make('interpreter.interpreter_name')
                    ->label('Interpreter')
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

                    TextColumn::make('speciality')
                ->label('Speciality')
                ->sortable()
                ->searchable(),

                TextColumn::make('instruction_date')
                    ->date()
                    ->sortable(),

                TextColumn::make('invoice_no')
                    ->label('Invoice No'),

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
