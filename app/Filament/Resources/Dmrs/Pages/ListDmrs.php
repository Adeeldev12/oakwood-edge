<?php

namespace App\Filament\Resources\Dmrs\Pages;

use App\Filament\Resources\Dmrs\DmrResource;
use App\Models\Dmr;
use App\Models\Solicitor;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Resources\Pages\ListRecords;

class ListDmrs extends ListRecords
{
    protected static string $resource = DmrResource::class;

    public int $year;

    public array $cases = [];

    public ?string $startDate = null;

public ?string $endDate = null;

    public function mount(): void
    {
        parent::mount();

        $this->year = now()->year;

        $this->loadCases();
    }

    public function loadCases(): void
{
    $solicitors = Solicitor::query()
        ->orderBy('name')
        ->get();

    $query = Dmr::query()
        ->where('year', $this->year);

    /*
     * If a date filter has been applied,
     * determine which months should be displayed.
     */
    if ($this->startDate && $this->endDate) {

        $start = \Carbon\Carbon::parse($this->startDate);
        $end = \Carbon\Carbon::parse($this->endDate);

        $startMonth = $start->month;
        $endMonth = $end->month;

        /*
         * Make sure the selected dates belong to
         * the currently selected reporting year.
         */
        if ($start->year !== $this->year || $end->year !== $this->year) {
            $this->cases = [];

            foreach ($solicitors as $solicitor) {
                foreach (range(1, 12) as $month) {
                    $this->cases[$solicitor->id][$month] = 0;
                }
            }

            return;
        }

        $query->whereBetween('month', [
            $startMonth,
            $endMonth,
        ]);
    }

    $records = $query
        ->get()
        ->keyBy(function ($record) {
            return $record->solicitor_id . '-' . $record->month;
        });

    $this->cases = [];

    foreach ($solicitors as $solicitor) {

        foreach (range(1, 12) as $month) {

            $key = $solicitor->id . '-' . $month;

            /*
             * If there is no filter, show the normal value.
             *
             * If there is a filter, only show values for
             * months inside the selected range.
             */
            if (
                $this->startDate &&
                $this->endDate
            ) {

                $start = \Carbon\Carbon::parse($this->startDate);
                $end = \Carbon\Carbon::parse($this->endDate);

                if ($month < $start->month || $month > $end->month) {
                    $this->cases[$solicitor->id][$month] = 0;
                    continue;
                }
            }

            $this->cases[$solicitor->id][$month] =
                $records->get($key)?->cases ?? 0;
        }
    }
}


    public function updatedYear(): void
    {
        $this->loadCases();
    }

    public function applyDateFilter(): void
{
    $this->resetErrorBag();

    if (!$this->startDate || !$this->endDate) {
        $this->addError(
            'startDate',
            'Please select both a start date and an end date.'
        );

        return;
    }

    $start = \Carbon\Carbon::parse($this->startDate);
    $end = \Carbon\Carbon::parse($this->endDate);

    if ($start->greaterThan($end)) {
        $this->addError(
            'startDate',
            'Start date cannot be after the end date.'
        );

        return;
    }

    if (
        $start->year !== $this->year ||
        $end->year !== $this->year
    ) {
        $this->addError(
            'startDate',
            'Start date and end date must be within the selected reporting year.'
        );

        return;
    }

    $this->loadCases();
}

public function clearDateFilter(): void
{
    $this->startDate = null;
    $this->endDate = null;

    $this->resetErrorBag();

    $this->loadCases();
}



    public function save(): void
    {
        foreach ($this->cases as $solicitorId => $months) {
            foreach ($months as $month => $cases) {

                Dmr::updateOrCreate(
                    [
                        'solicitor_id' => $solicitorId,
                        'year' => $this->year,
                        'month' => $month,
                    ],
                    [
                        'cases' => (int) ($cases ?? 0),
                    ]
                );
            }
        }

        \Filament\Notifications\Notification::make()
            ->title('DMR saved successfully')
            ->success()
            ->send();
    }

    public function getViewData(): array
    {
        return [
            'solicitors' => Solicitor::query()
                ->orderBy('name')
                ->get(),

            'months' => [
                1 => 'January',
                2 => 'February',
                3 => 'March',
                4 => 'April',
                5 => 'May',
                6 => 'June',
                7 => 'July',
                8 => 'August',
                9 => 'September',
                10 => 'October',
                11 => 'November',
                12 => 'December',
            ],
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getView(): string
{
    return 'filament.resources.dmrs.pages.list-dmrs';
}


public function downloadPdf()
{
    $solicitors = Solicitor::query()
        ->orderBy('name')
        ->get();

    $months = [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ];

   $query = Dmr::query()
    ->where('year', $this->year);

if ($this->startDate && $this->endDate) {

    $start = \Carbon\Carbon::parse($this->startDate);
    $end = \Carbon\Carbon::parse($this->endDate);

    $query->whereBetween('month', [
        $start->month,
        $end->month,
    ]);
}

$records = $query
    ->get()
    ->keyBy(function ($record) {
        return $record->solicitor_id . '-' . $record->month;
    });


    $cases = [];

    foreach ($solicitors as $solicitor) {

        foreach ($months as $month => $monthName) {

            $key = $solicitor->id . '-' . $month;

            $cases[$solicitor->id][$month] =
                $records->get($key)?->cases ?? 0;
        }
    }

    $pdf = Pdf::loadView('dmr.pdf', [
        'year' => $this->year,
        'solicitors' => $solicitors,
        'months' => $months,
        'cases' => $cases,

        // Date filter information
    'startDate' => $this->startDate,
    'endDate' => $this->endDate,
    ]);

    $pdf->setPaper('a4', 'landscape');

    return response()->streamDownload(
        fn () => print($pdf->output()),
        "DMR-Report-{$this->year}.pdf"
    );
}

}
