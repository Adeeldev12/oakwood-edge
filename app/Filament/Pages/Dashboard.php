<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardFilters;
use App\Filament\Widgets\InvoiceStatusChart;
use App\Filament\Widgets\RevenueChart;
use App\Filament\Widgets\StatsOverview;
use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
     public function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
            RevenueChart::class,
            InvoiceStatusChart::class,
            DashboardFilters::class,
        ];
    }
    // protected function getFiltersForm(): array
    // {
    //     return [
    //         Select::make('range')
    //             ->options([
    //                 'week' => 'This Week',
    //                 'month' => 'This Month',
    //                 'year' => 'This Year',
    //             ])
    //             ->default('month'),

    //         Select::make('solicitor_id')
    //             ->label('Solicitor')
    //             ->relationship('solicitor', 'name')
    //             ->searchable()
    //             ->preload(),
    //     ];
    // }
}
