<?php

namespace App\Filament\Widgets;

use App\Models\SolicitorInvoice;
use Filament\Widgets\ChartWidget;

class InvoiceStatusChart extends ChartWidget
{
    protected ?string $heading = 'Invoice Status';
    protected static ?int $sort = 3;

    protected $listeners = ['filtersUpdated' => 'updateFilters'];

    public $range = 'month';
    public $solicitor_id = null;

    public function updateFilters($filters)
    {
        $this->range = $filters['range'] ?? 'month';
        $this->solicitor_id = $filters['solicitor_id'] ?? null;

        $this->dispatch('$refresh');
    }

    protected function getData(): array
    {
        $query = SolicitorInvoice::query();

        // solicitor filter
        if ($this->solicitor_id) {
            $query->where('solicitor_id', $this->solicitor_id);
        }

        // date filter
        if ($this->range === 'week') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        }

        if ($this->range === 'month') {
            $query->whereMonth('created_at', now()->month);
        }

        if ($this->range === 'year') {
            $query->whereYear('created_at', now()->year);
        }

        $paid = (clone $query)->where('payment_status', 'paid')->count();
        $unpaid = (clone $query)->where('payment_status', 'unpaid')->count();
        $pending = (clone $query)->where('payment_status', 'pending')->count();

        return [
            'datasets' => [
                [
                    'data' => [$paid, $unpaid, $pending],
                    'backgroundColor' => ['#22c55e', '#ef4444', '#f59e0b'],
                ],
            ],
            'labels' => ['Paid', 'Unpaid', 'Pending'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
