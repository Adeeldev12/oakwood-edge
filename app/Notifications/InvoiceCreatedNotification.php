<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class InvoiceCreatedNotification extends Notification
{
    public function __construct(public $invoiceId) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Invoice Created',
            'message' => "Invoice #{$this->invoiceId} has been created.",
        ];
    }
}
