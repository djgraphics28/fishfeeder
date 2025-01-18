<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HighTemperatureAlertEmailNotification extends Notification
{
    use Queueable;

    public $temperature;
    public $location;

    /**
     * Create a new notification instance.
     *
     * @param  float  $temperature
     * @param  string  $location
     * @return void
     */
    public function __construct($temperature, $location)
    {
        $this->temperature = $temperature;
        $this->location = $location;
    }

    /**
     * Get the notification's mail representation.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('High Temperature Alert!')
            ->markdown('emails.high_temperature_alert', [
                'temperature' => $this->temperature,
                'location' => $this->location,
            ]);
    }
}
