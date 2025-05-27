<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Pengaduan;

class PengaduanStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $pengaduan;

    public function __construct(Pengaduan $pengaduan)
    {
        $this->pengaduan = $pengaduan;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Status Pengaduan Anda Diperbarui')
            ->greeting('Halo, ' . $notifiable->name)
            ->line('Pengaduan Anda dengan judul "' . $this->pengaduan->judul . '" telah diperbarui.')
            ->line('Status saat ini: **' . ucfirst($this->pengaduan->status) . '**')
            ->action('Lihat Detail', url('/masyarakat/pengaduan/' . $this->pengaduan->id))
            ->line('Terima kasih telah menggunakan sistem pengaduan kami.');
    }
}

