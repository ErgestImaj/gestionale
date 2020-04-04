<?php

namespace App\Mail;

use App\Models\Config;
use PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FastTrackOrderShipped extends Mailable
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
			return $this->view('emails.orders.fast-track')
				->with([
				 'cliente' => $this->fastTrackOrder->user->lastname,
				 'orderNumber' => $this->fastTrackOrder->order_number,
				 'orderPrice' => price_formater( $this->fastTrackOrder->price),
			 ])
				->to($this->fastTrackOrder->user->email)
				->subject('Ordine confermato')
			  ->attachData($pdf->output(),'invoice.pdf');
    }
}
