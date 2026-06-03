<?php

use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-notification', function () {
    $user = User::find(2);

    Notification::make()
        ->title('Filament Test')
        ->body('This is a test')
        ->sendToDatabase($user);

    return 'Notification sent';
});
