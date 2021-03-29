<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CancelOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $date;

    /**
     * Create a new notification instance.
     *
     * @param $date
     */
    public function __construct($date)
    {
        $this->date = $date;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Stornierung Essen - myfoodorder')
            ->view('mail.cancel-order', [
                'user'           => $notifiable,
                'vacationPeriod' => $this->date
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
