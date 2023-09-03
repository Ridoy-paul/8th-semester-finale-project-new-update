<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;
use Auth;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order = $this->order;
        $pdf = PDF::loadView('admin.invoice.generate', compact('order'));
        return $this->subject('Congratulations! Your order has been placed.')
                ->from('no-reply@sakbstore.com', env('APP_NAME'))
                ->to($order->email, $order->name)
                ->view('emails.order-confirm', compact('order'))
                ->attachData($pdf->output(), 'invoice.pdf', [
                    'mime' => 'application/pdf',
                ]);
    }
}
