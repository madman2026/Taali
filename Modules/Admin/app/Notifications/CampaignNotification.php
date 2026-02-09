<?php

namespace Modules\Admin\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CampaignNotification extends Notification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(public $channel) {}

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        if (empty($this->channel)) {
            return [];
        } else {
            return [$this->channel];
        }
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', 'https://laravel.com')
            ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => __('yalda mobarak!'),
            'message' => __('code takhfif: 1234!'),
        ];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [];
    }
}
