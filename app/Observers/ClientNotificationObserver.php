<?php

namespace App\Observers;

use App\Models\Client;
use App\Models\User;
use App\Notifications\ClientCreatedNotification;

class ClientNotificationObserver
{
    /**
     * Handle the Client "created" event.
     */
    public function created(Client $client): void
    {
        //
         foreach (User::all() as $user) {

            $user->notify(
                new ClientCreatedNotification($client)
            );

        }
    }

    /**
     * Handle the Client "updated" event.
     */
    public function updated(Client $client): void
    {
        //
    }

    /**
     * Handle the Client "deleted" event.
     */
    public function deleted(Client $client): void
    {
        //
    }

    /**
     * Handle the Client "restored" event.
     */
    public function restored(Client $client): void
    {
        //
    }

    /**
     * Handle the Client "force deleted" event.
     */
    public function forceDeleted(Client $client): void
    {
        //
    }
}
