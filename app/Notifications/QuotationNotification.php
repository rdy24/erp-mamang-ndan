<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class QuotationNotification extends Notification
{
    use Queueable;

    public $sale;

    /**
     * Create a new notification instance.
     */
    public function __construct($sale)
    {
        $this->sale = $sale;

        // dd($this->pdf, $this->sale);
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
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pages.sale.quotation-print', ['sale' => $this->sale]);
        $pdfData = $pdf->output();

        return (new MailMessage)
            ->subject('Quotation ' . $this->sale->kode_sales)
            ->line('Berikut kami kirimkan lampiran Quotation ' . $this->sale->kode_sales)
            ->attachData($pdfData, 'Quotation ' . $this->sale->kode_sales . '.pdf', [
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
