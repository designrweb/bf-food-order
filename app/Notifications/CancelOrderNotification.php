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
     * @var
     */
    private $consumer;

    /**
     * CancelOrderNotification constructor.
     *
     * @param $date
     * @param $consumer
     */
    public function __construct($date, $consumer)
    {
        $this->date     = $date;
        $this->consumer = $consumer;
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
                'vacationPeriod' => $this->date,
                'consumer'       => $this->consumer,
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
