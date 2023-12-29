<?php

namespace App\Notifications;

use App\Models\Media;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class NewMediaNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private string $url;

    /**
     * Create a new notification instance.
     */
    public function __construct(private readonly Media $media)
    {
        $this->url = Storage::url($media->path);
    }

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
            ->line('New media file was uploaded')
            ->attach(url($this->url))
            ->action('View media', url($this->url));
    }
}
