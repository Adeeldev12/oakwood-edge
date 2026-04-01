<?php

namespace App\Filament\Resources\SolicitorInvoices;

use App\Filament\Resources\BaseResource;
use App\Filament\Resources\SolicitorInvoices\Pages\CreateSolicitorInvoice;
use App\Filament\Resources\SolicitorInvoices\Pages\EditSolicitorInvoice;
use App\Filament\Resources\SolicitorInvoices\Pages\ListSolicitorInvoices;
use App\Filament\Resources\SolicitorInvoices\Schemas\SolicitorInvoiceForm;
use App\Filament\Resources\SolicitorInvoices\Tables\SolicitorInvoicesTable;
use App\Models\SolicitorInvoice;
use BackedEnum;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class SolicitorInvoiceResource extends BaseResource
{
    protected static ?string $model = SolicitorInvoice::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentText;

    public static function form(Schema $schema): Schema
{
    return $schema
        ->columns(1) // important: prevents tight layout
        ->components([

        Section::make('Invoice Details')
            ->icon('heroicon-o-document-text')
            ->columns(3)
            ->schema([

                TextInput::make('ref')
                    ->label('Reference')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->extraAttributes(['class' => 'py-3 text-base'])
                    ->columnSpan(1),

                DatePicker::make('due_date')
                    ->required()
                    ->extraAttributes(['class' => 'py-3 text-base'])
                    ->columnSpan(1),

                Select::make('payment_status')
                    ->options([
                        'paid' => 'Paid',
                        'unpaid' => 'Unpaid',
                    ])
                    ->default('unpaid')
                    ->native(false)
                    ->required()
                    ->extraAttributes(['class' => 'py-3 text-base'])
                    ->columnSpan(1),
            ])
            ->collapsible(false)
            ->compact(false),



        Section::make('Client & Expert')
            ->icon('heroicon-o-user')
            ->columns(2)
            ->schema([

                Select::make('client_id')
                    ->relationship('client', 'client_name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->extraAttributes(['class' => 'py-3 text-base'])
                    ->columnSpan(1),

                Select::make('expert_type')
                    ->options([
                        'psychiatrist' => 'Psychiatrist',
                        'psychologist' => 'Psychologist',
                        'gp' => 'GP',
                        'orthopaedic' => 'Orthopaedic',
                        'social_work' => 'Social Work',
                        'probation_report' => 'Probation Report',
                        'country_expert' => 'Country Expert',
                        'cbt' => 'CBT',
                    ])
                    ->searchable()
                    ->required()
                    ->extraAttributes(['class' => 'py-3 text-base'])
                    ->columnSpan(1),

                    Select::make('solicitor_id')
    ->label('Solicitor')
    ->relationship('solicitor', 'name') // change 'name' if different
    ->searchable()
    ->preload()
    ->required()
    ->native(false),

                Textarea::make('solicitor_address')
                    // ->rows(3)
                    // ->columnSpanFull()
                    ->extraAttributes(['class' => 'py-3 text-base']),
            ])
            ->compact(false),



        Section::make('Financial Details')
            ->icon('heroicon-o-banknotes')
            ->columns(3)
            ->schema([

                TextInput::make('amount')
    ->label('Base Amount')
    ->numeric()
    ->prefix('£')
    ->required()
    ->live(onBlur: true)
    ->extraAttributes(['class' => 'py-4 text-lg'])
    ->afterStateUpdated(function ($state, callable $set, callable $get) {

        $vatRate = (float) ($get('vat_rate') ?? 0);
        $amount = (float) $state;

        if ($vatRate == 0) {
            $set('vat_amount', 0);
            $set('total_amount', $amount);
            return;
        }

        $vatAmount = ($amount * $vatRate) / 100;

        $set('vat_amount', round($vatAmount, 2));
        $set('total_amount', round($amount + $vatAmount, 2));
    })
    ->columnSpan(1),

                // TextInput::make('vat_rate')
                //     ->label('VAT Rate (%)')
                //     ->numeric()
                //     ->default(0)
                //     ->live()
                //     ->extraAttributes(['class' => 'py-4 text-lg'])
                //     ->afterStateUpdated(function ($state, callable $set, callable $get) {
                //         $amount = $get('amount') ?? 0;
                //         $vatAmount = ($amount * $state) / 100;
                //         $set('vat_amount', round($vatAmount, 2));
                //         $set('total_amount', round($amount + $vatAmount, 2));
                //     })
                Select::make('vat_rate')
    ->label('VAT Rate (%)')
    ->options([
        '0' => '0%',
    '10' => '10%',
    '20' => '20%',
    ])
    ->default(0)
    ->required()
    ->native(false)
    ->live()
    ->afterStateUpdated(function ($state, callable $set, callable $get) {

        $amount = (float) ($get('amount') ?? 0);

        if ($state == 0) {
            $set('vat_amount', 0);
            $set('total_amount', $amount);
            return;
        }

        $vatAmount = ($amount * $state) / 100;

        $set('vat_amount', round($vatAmount, 2));
        $set('total_amount', round($amount + $vatAmount, 2));
    })
    ->columnSpan(1),

                TextInput::make('vat_amount')
                    ->numeric()
                    ->prefix('£')
                    ->readOnly()
                    ->extraAttributes(['class' => 'py-4 text-lg bg-gray-100'])
                    ->columnSpan(1),

                TextInput::make('total_amount')
                    ->numeric()
                    ->prefix('£')
                    ->readOnly()
                    ->columnSpanFull()
                    ->extraAttributes([
                        'class' => 'py-5 text-xl font-bold bg-primary-50 border-primary-300'
                    ]),
            ])
            ->compact(false),



        Section::make('Attachments & Notes')
            ->icon('heroicon-o-paper-clip')
            ->schema([

                Textarea::make('description')
                    ->rows(4)
                    ->columnSpanFull()
                    ->extraAttributes(['class' => 'py-3 text-base']),

                FileUpload::make('client_invoice_files')
                    ->disk('public')
                    ->directory('client-invoices')
                    ->multiple()
                    ->preserveFilenames()
                    ->downloadable()
                    ->openable()
                    ->columnSpanFull(),
            ])
            ->compact(false),

    ]);
}

    public static function table(Table $table): Table
    {
        return SolicitorInvoicesTable::configure($table)

        ->columns([
            TextColumn::make('ref')
                    ->label('Ref')
                    ->searchable(),

                    TextColumn::make('solicitor.name')
    ->label('Solicitor'),

                TextColumn::make('client.client_name')
                ->label('Client')
                ->searchable()
                ->sortable(),

                TextColumn::make('expert_type')
                    ->badge()
                    ->formatStateUsing(fn ($state) => str_replace('_', ' ', ucfirst($state))),

                TextColumn::make('amount')
                    ->money('GBP')
                    ->sortable(),

                    TextColumn::make('vat_rate')
    ->label('VAT %')
    ->formatStateUsing(fn ($state) => $state !== null ? $state . '%' : '-'),

            TextColumn::make('vat_amount')
                ->money('GBP', true),

            TextColumn::make('total_amount')
                ->money('GBP', true)
                ->weight('bold')
                ->sortable(),

                TextColumn::make('payment_status')
                    ->badge()
                    ->colors([
                        'success' => 'paid',
                        'danger'  => 'unpaid',
                    ]),

                    TextColumn::make('created_at')
                    ->label('Created Date')
                ->date()
                ->searchable()
                ->sortable(),
                    IconColumn::make('client_invoice_files')
    ->label('Client Invoice')
    ->boolean(fn ($record) => ! empty($record->client_invoice_files))
    ->trueIcon('heroicon-o-check-circle')
    ->falseIcon('heroicon-o-x-circle')
    ->trueColor('success')
    ->falseColor('danger'),


            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('payment_status')
                    ->options([
                        'paid'   => 'Paid',
                        'unpaid' => 'Unpaid',
                    ]),
            ])
            ->actions([
        //         ViewAction::make()
        // ->label('View'),
                EditAction::make()
                ->visible(fn () =>
                    auth()->user()?->isAdmin() || auth()->user()?->isSuperAdmin()
                ),
                Action::make('openInvoice')
    ->label('Open Invoice')
    ->icon('heroicon-o-document')
    ->url(fn ($record) =>
        $record->client_invoice_files
            ? Storage::url($record->client_invoice_files[0])
            : null
    )
    ->openUrlInNewTab()
    ->visible(fn ($record) => ! empty($record->client_invoice_files)),

    Action::make('downloadInvoice')
    ->label('Invoice')
    ->icon('heroicon-o-arrow-down-tray')
    ->color('primary')
    ->action(function ($record) {

        $pdf = Pdf::loadView('invoices.solicitor-invoice', [
            'invoice' => $record,
        ]);

        return response()->streamDownload(
            fn () => print ($pdf->output()),
            'solicitor-invoice-' . $record->invoice_no . '.pdf'
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
            'index' => ListSolicitorInvoices::route('/'),
            'create' => CreateSolicitorInvoice::route('/create'),
            'edit' => EditSolicitorInvoice::route('/{record}/edit'),
            // 'view' => Pages\ViewSolicitorInvoice::route('/{record}'),
        ];
    }
}
