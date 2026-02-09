<?php

namespace Modules\Content\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Modules\Content\Models\Content;

class ContentCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $tries = 0;

    public $backoff = [60, 600, 3600];

    public $maxExceptions = 2;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Content $content) {}

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    public function viaQueue($notifiable): array {}

    public function viaConnection($notifiable) {}

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => __('content created'),
            'message' => __('content created with title: '.$this->content->title),
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
