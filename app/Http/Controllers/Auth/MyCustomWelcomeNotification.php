<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\WelcomeNotification\WelcomeController;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class MyCustomWelcomeNotification extends WelcomeController
{
    public function buildWelcomeNotificationMessage(): MailMessage
    {
        return (new MailMessage)
            ->subject('Welcome to my app')
            ->action(Lang::get('Set initial password'), $this->showWelcomeFormUrl);
    }
}
