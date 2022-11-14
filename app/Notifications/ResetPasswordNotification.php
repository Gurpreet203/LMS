<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Crypt;

class ResetPasswordNotification extends Notification
{
    use Queueable;
    private $user;
    private $password;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, $pass)
    {
        $this->user = $user;
        $this->password = $pass;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->greeting('Password Change,')
                ->line('Hi ' . $notifiable->name)
                ->line('Your Email Is = '.$notifiable->email)
                ->line('Your New Password Is = '.$this->password)
                ->line('Thank you');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'email' => $this->user->email,
            'to' => $notifiable->email,
            'message' => 'Reset Password : '.$notifiable->slug
        ];
    }
}
