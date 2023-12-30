<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RfqNotification extends Notification
{
    use Queueable;

    public $purchase;

    /**
     * Create a new notification instance.
     */
    public function __construct($purchase)
    {
        $this->purchase = $purchase;
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
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pages.purchase.rfq-print', ['purchase' => $this->purchase]);
        $pdfData = $pdf->output();

        return (new MailMessage)
            ->subject('RFQ ' . $this->purchase->kode_purchase)
            ->line('Halo, ' . $this->purchase->vendor->name)
            ->line('Berikut kami kirimkan lampiran RFQ ' . $this->purchase->kode_purchase)
            ->line('Terima kasih.')
            ->attachData($pdfData, 'RFQ ' . $this->purchase->kode_purchase . '.pdf', [
                'mime' => 'application/pdf',
            ]);
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
