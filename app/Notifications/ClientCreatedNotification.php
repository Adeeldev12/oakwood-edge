<?php

namespace App\Notifications;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ClientCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Client $client
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'New Client Created',
            'body' => 'Client "' . $this->client->client_name . '" was created.',
        ];
    }
}
