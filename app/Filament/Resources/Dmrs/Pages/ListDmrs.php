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

        $records = Dmr::query()
            ->where('year', $this->year)
            ->get()
            ->keyBy(function ($record) {
                return $record->solicitor_id . '-' . $record->month;
            });

        $this->cases = [];

        foreach ($solicitors as $solicitor) {
            foreach (range(1, 12) as $month) {
                $key = $solicitor->id . '-' . $month;

                $this->cases[$solicitor->id][$month] =
                    $records->get($key)?->cases ?? 0;
            }
        }
    }

    public function updatedYear(): void
    {
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

    $records = Dmr::query()
        ->where('year', $this->year)
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
    ]);

    $pdf->setPaper('a4', 'landscape');

    return response()->streamDownload(
        fn () => print($pdf->output()),
        "DMR-Report-{$this->year}.pdf"
    );
}

}
