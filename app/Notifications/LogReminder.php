<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use function Symfony\Component\String\s;

class LogReminder extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Time to Log your weight')
                    ->greeting('Hello ' . $notifiable->name)
                    ->line('This is a reminder to log your weight.')
                    ->action('Log weight', route('weightLog.show'))
                    ->line('You have got this!')
                    ->salutation('');
    }

}
