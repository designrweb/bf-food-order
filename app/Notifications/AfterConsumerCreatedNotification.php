<?php

namespace App\Notifications;

use App\Consumer;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AfterConsumerCreatedNotification extends Notification
{

    /**
     * @var Consumer
     */
    public $consumer;

    /**
     * @var
     */
    public $menuCategories;

    /**
     * AfterConsumerCreatedNotification constructor.
     *
     * @param Consumer $consumer
     * @param          $menuCategories
     */
    public function __construct(Consumer $consumer, $menuCategories)
    {
        $this->consumer       = $consumer;
        $this->menuCategories = $menuCategories;
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
            ->subject(__('user.Welcome to My Food Order'))
            ->view('mail.user.after_consumer_created', [
                'user'           => $notifiable,
                'consumer'       => $this->consumer,
                'menuCategories' => $this->menuCategories,
            ]);
    }
}
