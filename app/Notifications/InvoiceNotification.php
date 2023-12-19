<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceNotification extends Notification
{
    use Queueable;

    public $sale;

    /**
     * Create a new notification instance.
     */
    public function __construct($sale)
    {
        $this->sale = $sale;
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
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pages.sale.invoice-print', ['sale' => $this->sale]);
        $pdfData = $pdf->output();

        return (new MailMessage)
            ->subject('Invoice ' . $this->sale->kode_sales)
            ->line('Berikut kami kirimkan lampiran Invoice ' . $this->sale->kode_sales)
            ->attachData($pdfData, 'Invoice ' . $this->sale->kode_sales . '.pdf', [
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
