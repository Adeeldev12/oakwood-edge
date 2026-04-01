<?php

namespace App\Filament\Widgets;

use App\Models\SolicitorInvoice;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected $listeners = ['filtersUpdated' => 'updateFilters'];

    public $range = 'month';
    public $solicitor_id = null;

    public function updateFilters($filters)
    {
        $this->range = $filters['range'] ?? 'month';
        $this->solicitor_id = $filters['solicitor_id'] ?? null;

        $this->dispatch('$refresh'); // ✅ THIS FIXES YOUR ERROR
    }

    protected function getStats(): array
    {
        $query = SolicitorInvoice::query();

        // Filter by solicitor
        if ($this->solicitor_id) {
            $query->where('solicitor_id', $this->solicitor_id);
        }

        // Filter by date
        if ($this->range === 'week') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        }

        if ($this->range === 'month') {
            $query->whereMonth('created_at', now()->month);
        }

        if ($this->range === 'year') {
            $query->whereYear('created_at', now()->year);
        }

       return [
    Stat::make('Total Invoices', $query->count())
        ->description('All invoices')
        ->descriptionIcon('heroicon-m-document-text')
        ->color('primary'),

    Stat::make('Paid Invoices', (clone $query)->where('payment_status', 'paid')->count())
        ->description('Successfully paid')
        ->descriptionIcon('heroicon-m-check-circle')
        ->color('success'),

    Stat::make('Unpaid Invoices', (clone $query)->where('payment_status', 'unpaid')->count())
        ->description('Pending payments')
        ->descriptionIcon('heroicon-m-clock')
        ->color('danger'),

    Stat::make('Paid Amount', '£ ' . number_format((clone $query)->where('payment_status', 'paid')->sum('total_amount'), 2))
        ->description('Revenue received')
        ->descriptionIcon('heroicon-m-banknotes')
        ->color('success'),

    Stat::make('Unpaid Amount', '£ ' . number_format((clone $query)->where('payment_status', '!=', 'paid')->sum('total_amount'), 2))
        ->description('Pending balance')
        ->descriptionIcon('heroicon-m-exclamation-circle')
        ->color('warning'),
];
    }
}
