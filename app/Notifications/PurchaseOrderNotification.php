<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PurchaseOrderNotification extends Notification
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
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pages.purchase.purchaseOrder-print', ['purchase' => $this->purchase]);
        $pdfData = $pdf->output();

        return (new MailMessage)
            ->subject('Purchase Order ' . $this->purchase->kode_purchase)
            ->line('Halo, ' . $this->purchase->vendor->name)
            ->line('Berikut kami kirimkan lampiran Purchase Order ' . $this->purchase->kode_purchase)
            ->line('Terima kasih.')
            ->attachData($pdfData, 'Purchase Order ' . $this->purchase->kode_purchase . '.pdf', [
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
