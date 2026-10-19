<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use Carbon\Carbon;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class ClientAppointmentCalendar extends FullCalendarWidget
{
    public static function canView(): bool
    {
        return auth()->check()
        && request()->routeIs('filament.admin.pages.appointments-calendar');
    }

    public function config(): array
    {
        return [
            'initialView' => 'timeGridWeek',
            'firstDay' => 1,
            'nowIndicator' => true,
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay',
            ],
        ];
    }

    public function fetchEvents(array $info): array
    {
        return Client::query()
            ->whereNotNull('appointment_date')
            ->whereNotNull('appointment_time')
            ->whereBetween('appointment_date', [
                Carbon::parse($info['start'])->toDateString(),
                Carbon::parse($info['end'])->toDateString(),
            ])
            ->get()
            ->map(function (Client $client) {
                $start = Carbon::parse(
                    $client->appointment_date . ' ' . $client->appointment_time
                );

                return [
                    'id' => (string) $client->id,
                    'title' => $client->client_name
                        . ' — '
                        . ($client->expert_name ?: 'Doctor not assigned'),
                    'start' => $start->toIso8601String(),
                    'url' => route(
                        'filament.admin.resources.clients.edit',
                        ['record' => $client->id]
                    ),
                ];
            })
            ->all();
    }
}
