<?php

namespace App\Mail;

use App\Models\Config;
use PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResendInvoice extends Mailable
{
    use Queueable, SerializesModels;

	public $fastTrackOrder;


	/**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fastTrackOrder)
    {
        //
			$this->fastTrackOrder = $fastTrackOrder;
		}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
			$config = Config::where('name', 'cart')->pluck('config_values')->first();
			$fastTrack = $this->fastTrackOrder;
			$pdf=  PDF::loadView('orders.invoice-fast-track',compact('fastTrack','config'));
			return $this->view('emails.orders.resend-invoice')
				->with([
					'cliente' => $this->fastTrackOrder->user->lastname,
				])
				->to($this->fastTrackOrder->user->email)
				->subject('Fattura del ordine: '. $this->fastTrackOrder->order_number)
				->attachData($pdf->output(),'invoice.pdf');
		}
}
