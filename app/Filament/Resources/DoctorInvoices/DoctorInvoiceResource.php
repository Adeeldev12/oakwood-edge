<?php

namespace App\Filament\Resources\DoctorInvoices;

use App\Filament\Resources\BaseResource;
use App\Filament\Resources\DoctorInvoices\Pages\CreateDoctorInvoice;
use App\Filament\Resources\DoctorInvoices\Pages\EditDoctorInvoice;
use App\Filament\Resources\DoctorInvoices\Pages\ListDoctorInvoices;
use App\Filament\Resources\DoctorInvoices\Schemas\DoctorInvoiceForm;
use App\Filament\Resources\DoctorInvoices\Tables\DoctorInvoicesTable;
use App\Models\DoctorInvoice;
use BackedEnum;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class DoctorInvoiceResource extends BaseResource
{
    protected static ?string $model = DoctorInvoice::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocument;

    public static function form(Schema $schema): Schema
    {
        return DoctorInvoiceForm::configure($schema)
            ->components([
                Select::make('doctor_id')
                  // ->label('Doctor')
                    ->relationship('doctor', 'name')
                  // ->searchable()
                    ->native(false)
                  // ->preload()
                    ->required()
                    ->label('Dr Name')
                    ->required(),
                // ->maxLength(255),

                TextInput::make('our_ref')
                    ->label('Our Ref')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(50),

                Select::make('client_id')
                    ->label('Client Name')
                    ->relationship('client', 'client_name')
                    ->native(false)
                    // ->searchable()
                    // ->preload()
                    ->required(),

                TextInput::make('amount')
                    ->numeric()
                    ->prefix('£')
                    ->required()
                    ->live(onBlur: true),

                Select::make('vat_rate')
                    ->label('VAT')
                    ->native(false)
                    ->options([
                        0 => '0%',
                        10 => '10%',
                        20 => '20%',
                    ])
                    ->live()
                    //
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
    $amount = (float) $get('amount');

    if ($amount !== null) {
        $vatAmount = ($amount * $state) / 100;

        $set('vat_amount', number_format($vatAmount, 2, '.', ''));
        $set('total_amount', number_format($amount + $vatAmount, 2, '.', ''));
    }
}),

                TextInput::make('vat_amount')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(),

                TextInput::make('total_amount')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(),

                Select::make('payment_status')
                    ->label('Payment Status')
                    ->options([
                        'paid' => 'Paid',
                        'unpaid' => 'Unpaid',
                    ])
                    ->default('unpaid')
                    ->native(false)
                    ->required(),

                Textarea::make('description')
                    ->label('Invoice Description')
                    ->rows(2)
                    ->columnSpanFull(),

                DatePicker::make('due_date')
                    ->label('Due Date')
                    ->native(false)
                    ->displayFormat('Y-m-d')
                    ->closeOnDateSelection(),

                FileUpload::make('doctor_invoice_files')
                    ->label('Doctor Invoices')
                    ->disk('public')
                    ->visibility('public') // 🔥 ADD THIS
                    ->multiple()
                    ->directory('doctor-invoices')
                    ->preserveFilenames()
                    ->maxSize(51200)
                    ->acceptedFileTypes([
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'image/*',
                    ])
                    ->downloadable()
                    ->openable(),

            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return DoctorInvoicesTable::configure($table)
            ->columns([

                TextColumn::make('doctor.name')
                    ->label('Dr Name')
                    ->searchable(),

                TextColumn::make('our_ref')
                    ->label('Our Ref')
                    ->searchable(),

                TextColumn::make('client.client_name')
                    ->searchable(),

  TextColumn::make('created_at')
    ->date()
    ->label('Invoice Date')
    ->sortable(),
                    TextColumn::make('due_date')
    ->date()
    ->sortable(),

                TextColumn::make('amount')
                    ->money('GBP')
                    ->sortable(),

                TextColumn::make('vat_rate')
                    ->label('VAT')
                    ->formatStateUsing(fn ($state) => $state ? $state.'%' : '-'),

                TextColumn::make('vat_amount')
                    ->money('GBP', true)
                    ->label('VAT Amount'),

                TextColumn::make('total_amount')
                    ->money('GBP', true)
                    ->label('Total')
                    ->weight('bold'),

                TextColumn::make('payment_status')
                    ->badge()
                    ->colors([
                        'success' => 'paid',
                        'danger' => 'unpaid',
                    ]),

                IconColumn::make('doctor_invoice_files')
                    ->label('Doctor Invoice')
                    ->boolean(fn ($record) => ! empty($record->doctor_invoice_files))
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('payment_status')
                    ->options([
                        'paid' => 'Paid',
                        'unpaid' => 'Unpaid',
                    ]),
            ])
            ->actions([
                EditAction::make()
                    ->visible(fn () => auth()->user()?->isAdmin() || auth()->user()?->isSuperAdmin()
                    ),
                Action::make('openDoctorInvoice')
                    ->label('Open Invoice')
                    ->icon('heroicon-o-document')
                    ->url(fn ($record) => ! empty($record->doctor_invoice_files)
                            ? Storage::disk('public')->url($record->doctor_invoice_files[0])
                            : null
                    )
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => ! empty($record->doctor_invoice_files)),

                Action::make('downloadInvoice')
                    ->label('Invoice')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('primary')
                    ->action(function ($record) {
                        $pdf = Pdf::loadView('invoices.doctor-invoice', [
                            'invoice' => $record,
                        ]);

                        return response()->streamDownload(
                            fn () => print ($pdf->output()),
                            'doctor-invoice-'.$record->invoice_no.'.pdf'
                        );
                    }),
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
            'index' => ListDoctorInvoices::route('/'),
            'create' => CreateDoctorInvoice::route('/create'),
            'edit' => EditDoctorInvoice::route('/{record}/edit'),
        ];
    }
}
