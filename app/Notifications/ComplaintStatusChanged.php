<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ComplaintStatusChanged extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected $complaint,
        protected $oldStatus,
        protected $newStatus
    )
    {
        
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
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'complaint_id' => $this->complaint->id,
            'title' => $this->complaint->title,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' => "Status Aspirasi {$this->complaint->title} status saat ini {$this->oldStatus} menjadi {$this->newStatus}",
        ];
    }
}
