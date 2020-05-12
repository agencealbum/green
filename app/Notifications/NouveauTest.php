<?php

namespace App\Notifications;

use App\Scan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NouveauTest extends Notification
{
    use Queueable;

    private $scan;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Scan $scan)
    {
        $this->scan = $scan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->subject('Nouveau test green')
            ->greeting($this->scan->url)
            ->line('Email : ' . $this->scan->email)
            ->line('IP : ' . $this->scan->ip)
            ->line('Hébergement : ' . $this->scan->hosting_score . '%')
            ->line('Performance : ' . $this->scan->performance_score . '%')
            ->line('Adaptabilité : ' . $this->scan->responsive_score . '%')
            ->line('Bilan carbone : ' . $this->scan->carbon_score . '%')
            ->line('Score total : ' . $this->scan->total_score . '%');
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
            //
        ];
    }
}
