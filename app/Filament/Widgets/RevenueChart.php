<?php

namespace App\Filament\Widgets;

use App\Models\SolicitorInvoice;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
// use Carbon\CarbonPeriod;

class RevenueChart extends ChartWidget
{
    protected ?string $heading = 'Revenue Chart';
    protected static ?int $sort = 2;

    public ?string $range = null;
    public ?string $solicitor_id = null;

    protected $listeners = [
        'filtersUpdated' => 'updateFilters',
    ];

    public function updateFilters($filters): void
    {
        $this->range = $filters['range'] ?? null;
        $this->solicitor_id = $filters['solicitor_id'] ?? null;

        $this->dispatch('$refresh');
    }

    protected function getType(): string
    {
        return 'line';
    }

    // protected function getData(): array
    // {
    //     $query = SolicitorInvoice::query()
    //         ->where('payment_status', 'paid');

    //     if ($this->solicitor_id) {
    //         $query->where('solicitor_id', $this->solicitor_id);
    //     }

    //     // 🔥 Determine date range
    //     if ($this->range === 'week') {
    //         $start = now()->startOfWeek();
    //         $end = now()->endOfWeek();
    //         $interval = '1 day';
    //         $format = 'd M';
    //     } elseif ($this->range === 'year') {
    //         $start = now()->startOfYear();
    //         $end = now()->endOfYear();
    //         $interval = '1 month';
    //         $format = 'M';
    //     } else {
    //         // default month
    //         $start = now()->startOfMonth();
    //         $end = now()->endOfMonth();
    //         $interval = '1 day';
    //         $format = 'd M';
    //     }

    //     $query->whereBetween('created_at', [$start, $end]);

    //     // 🔥 Get DB results
    //     $results = $query
    //         ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
    //         ->groupBy('date')
    //         ->pluck('total', 'date');

    //     // 🔥 Create full date range
    //     $period = CarbonPeriod::create($start, $interval, $end);

    //     $labels = [];
    //     $data = [];

    //     foreach ($period as $date) {
    //         $key = $date->format('Y-m-d');

    //         $labels[] = $date->format($format);
    //         $data[] = $results[$key] ?? 0; // fill missing with 0
    //     }

    //     return [
    //         'labels' => $labels,
    //         'datasets' => [
    //             [
    //                 'label' => 'Revenue',
    //                 'data' => $data,
    //                 'borderColor' => '#3b82f6',
    //                 'backgroundColor' => 'rgba(59,130,246,0.2)',
    //                 'tension' => 0.4,
    //                 'fill' => true,
    //             ],
    //         ],
    //     ];
    // }

    protected function getData(): array
{
    $query = SolicitorInvoice::query()
        ->where('payment_status', 'paid');

    if ($this->solicitor_id) {
        $query->where('solicitor_id', $this->solicitor_id);
    }

    // ===== WEEK =====
    if ($this->range === 'week') {
        $start = now()->startOfWeek();
        $end = now()->endOfWeek();

        $query->whereBetween('created_at', [$start, $end]);

        $results = $query
            ->selectRaw('DATE(created_at) as label, SUM(total_amount) as total')
            ->groupBy('label')
            ->pluck('total', 'label');

        $labels = [];
        $data = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $start->copy()->addDays($i);
            $key = $date->format('Y-m-d');

            $labels[] = $date->format('D');
            $data[] = $results[$key] ?? 0;
        }
    }

    // ===== YEAR =====
    elseif ($this->range === 'year') {
        $start = now()->startOfYear();
        $end = now()->endOfYear();

        $query->whereBetween('created_at', [$start, $end]);

        $results = $query
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $labels = [];
        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] =  Carbon::create()->month($i)->format('M');
            $data[] = $results[$i] ?? 0;
        }
    }

    // ===== MONTH (DEFAULT) =====
    else {
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();

        $query->whereBetween('created_at', [$start, $end]);

        $results = $query
            ->selectRaw('DATE(created_at) as label, SUM(total_amount) as total')
            ->groupBy('label')
            ->pluck('total', 'label');

        $labels = [];
        $data = [];

        for ($i = 0; $i < $start->daysInMonth; $i++) {
            $date = $start->copy()->addDays($i);
            $key = $date->format('Y-m-d');

            $labels[] = $date->format('d');
            $data[] = $results[$key] ?? 0;
        }
    }

    return [
        'labels' => $labels,
        'datasets' => [
            [
                'label' => 'Revenue',
                'data' => $data,
                'borderColor' => '#3b82f6',
                'backgroundColor' => 'rgba(59,130,246,0.2)',
                'tension' => 0.4,
                'fill' => true,
            ],
        ],
    ];
}
}
