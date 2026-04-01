<?php

namespace App\Filament\Widgets;

use App\Models\Solicitor;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Widgets\Widget;

class DashboardFilters extends Widget implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected string $view = 'filament.widgets.dashboard-filters';

    // Start with no selection
    public ?string $range = null;
    public ?string $solicitor_id = null;

    public function mount(): void
    {
        $this->form->fill([
            'range' => $this->range,
            'solicitor_id' => $this->solicitor_id,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make(2) // 2 columns for compact layout
                ->schema([

                    Select::make('range')
                        ->options([
                            'week' => 'This Week',
                            'month' => 'This Month',
                            'year' => 'This Year',
                        ])
                        ->placeholder('Select Range')
                        ->live() // real-time updates
                        ->afterStateUpdated(fn () => $this->applyFilters())
                        ->native(false), // cleaner dropdown

                    Select::make('solicitor_id')
                        ->label('Solicitor')
                        ->options(Solicitor::pluck('name', 'id')->toArray())
                        ->searchable()
                        ->placeholder('Select Solicitor')
                        ->live()
                        ->afterStateUpdated(fn () => $this->applyFilters()),
                ]),
        ];
    }

    // Only keep applyFilters — no need for updated()
    public function applyFilters(): void
    {
        $this->dispatch('filtersUpdated', [
            'range' => $this->range,
            'solicitor_id' => $this->solicitor_id,
        ]);
    }
}
