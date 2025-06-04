<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordCodeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($code)
{
    $this->code = $code;
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
    public function toMail($notifiable)
{
    return (new MailMessage)
                ->subject('Kode Verifikasi Reset Password')
                ->line('Kode verifikasi Anda adalah: ' . $this->code)
                ->line('Kode ini berlaku selama 15 menit.');
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
