<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

// class TrialExpiringNotification extends Notification
// {
//     use Queueable;

//     /**
//      * Create a new notification instance.
//      */
//     public function __construct()
//     {
//         //
//     }

//     /**
//      * Get the notification's delivery channels.
//      *
//      * @return array<int, string>
//      */
//     public function via(object $notifiable): array
//     {
//         return ['mail'];
//     }

//     /**
//      * Get the mail representation of the notification.
//      */
//     public function toMail(object $notifiable): MailMessage
//     {
//         return (new MailMessage)
//             ->line('The introduction to the notification.')
//             ->action('Notification Action', url('/'))
//             ->line('Thank you for using our application!');
//     }

//     /**
//      * Get the array representation of the notification.
//      *
//      * @return array<string, mixed>
//      */
//     public function toArray(object $notifiable): array
//     {
//         return [
//             //
//         ];
//     }
// }

class TrialExpiringNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $daysLeft,
        public string $clientName
    ) {}

    public function via($notifiable): array
{
    return ['database'];
}

public function toDatabase($notifiable): array
{
    return [
        'title' => 'Trial Expiring Soon',
        'body' => $this->clientName . ' expires in ' . $this->daysLeft . ' day(s)',
        'client_name' => $this->clientName,
        'days_left' => $this->daysLeft,
    ];
}
}
