<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\User;
use App\Notifications\TrialExpiringNotification;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Console\Command;

class CheckTrialExpirations extends Command
{
    protected $signature = 'app:check-trial-expirations';

    protected $description = 'Check for expiring trials';

    public function handle(): void
    {
        $clients = Client::all();

        foreach ($clients as $client) {

            if (!$client->trial_ends_at) {
                continue;
            }

            $daysLeft = now()->startOfDay()
                ->diffInDays($client->trial_ends_at->startOfDay(), false);

            if (!in_array($daysLeft, [2, 1, 0])) {
                continue;
            }

            foreach (User::all() as $user) {

                /**
                 * 🔥 FIX: simple reliable duplicate check
                 * We check SAME class + SAME client + SAME day
                 */
                // $alreadySent = $user->notifications()
                //     ->where('type', TrialExpiringNotification::class)
                //     ->whereDate('created_at', today())
                //     ->whereRaw("JSON_EXTRACT(data, '$.client_name') = ?", [$client->client_name])
                //     ->exists();
                $alreadySent = $user->notifications()
    ->whereDate('created_at', today())
    ->where('data->title', 'Trial Expiring Soon')
    ->where('data->body', $client->client_name . ' expires in ' . $daysLeft . ' day(s)')
    ->exists();

                if ($alreadySent) {
                    continue;
                }

                // $alreadySent = false;

                // $user->notify(
                //     new TrialExpiringNotification(
                //         $daysLeft,
                //         $client->client_name
                //     )
                // );
                Notification::make()
    ->title('Trial Expiring Soon')
    ->body(
        $client->client_name . ' expires in ' . $daysLeft . ' day(s)'
    )
    ->warning()
    ->sendToDatabase($user);
            }
        }

        $this->info('Done');
    }
}
