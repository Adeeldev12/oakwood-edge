<?php

namespace App\Observers;

use App\Models\Client;
use App\Models\User;
use App\Notifications\TrialExpiringNotification;

class ClientObserver
{
    public function created(Client $client)
    {
        $this->sendNotification($client);
    }

    public function updated(Client $client)
    {
        $this->sendNotification($client);
    }

    private function sendNotification(Client $client)
    {
        if (!$client->trial_ends_at) {
            return;
        }

        $daysLeft = now()->diffInDays($client->trial_ends_at, false);

        if (!in_array($daysLeft, [2, 1, 0])) {
            return;
        }

        foreach (User::all() as $user) {
            $user->notify(
                new TrialExpiringNotification(
                    $daysLeft,
                    $client->client_name
                )
            );
        }
    }
}
