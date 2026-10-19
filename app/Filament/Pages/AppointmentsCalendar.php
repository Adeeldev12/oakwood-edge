<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ClientAppointmentCalendar;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class AppointmentsCalendar extends Page
{
    protected static string|\BackedEnum|null $navigationIcon =
        Heroicon::OutlinedCalendarDays;

    protected static ?string $navigationLabel = 'Appointments';

    protected static ?string $title = 'Appointments Calendar';

    protected string $view = 'filament.pages.appointments-calendar';

    protected function getHeaderWidgets(): array
    {
        return [
            ClientAppointmentCalendar::class,
        ];
    }
}
