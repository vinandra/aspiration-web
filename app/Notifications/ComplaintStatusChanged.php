<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ComplaintStatusChanged extends Notification
{
    use Queueable;

    protected $complaint;
    protected $oldStatus;
    protected $newStatus;
    protected $role;
    protected $forwarded;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        $complaint,
        $oldStatus = null,
        $newStatus = null,
        $role = null,
        $forwarded = false
    ) {
        $this->complaint = $complaint;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
        $this->role = $role;
        $this->forwarded = $forwarded;
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
        if ($this->forwarded) {
            // Jika ini adalah notifikasi penerusan aspirasi
            return [
                'complaint_id' => $this->complaint->id,
                'title' => $this->complaint->title,
                'role' => $this->role,
                'message' => "Aspirasi '{$this->complaint->title}' telah diteruskan ke role '{$this->role}'.",
            ];
        }

        // Jika ini adalah notifikasi perubahan status
        return [
            'complaint_id' => $this->complaint->id,
            'title' => $this->complaint->title,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' => "Status Aspirasi '{$this->complaint->title}' status saat ini '{$this->oldStatus}' menjadi '{$this->newStatus}'.",
        ];
    }
}
