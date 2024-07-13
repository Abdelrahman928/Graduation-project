<?php

namespace App\Notifications;

use App\Models\Partners;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VendorAddedNotification extends Notification
{
    use Queueable;
    protected $partner;

    /**
     * Create a new notification instance.
     */
    public function __construct(Partners $partner)
    {
        $this->partner = $partner;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase(object $notifiable):array
    {
        return
        [
            'partner_id' => $this->partner->id,
            'title' => 'NEW VENDOR!',
            'message' => 'New vendor added, check it out!: ' . $this->partner->name,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
