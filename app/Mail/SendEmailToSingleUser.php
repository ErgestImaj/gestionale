<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailToSingleUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

     protected $logged_user;
     protected $user;
     protected $soggetto;
     protected $descrizione;
     protected $cc_email;
     protected $bcc_email;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($logged_user,$user,$soggetto,$descrizione,$cc_email=null,$bcc_email=null)
    {
        //
        $this->logged_user = $logged_user;
        $this->user = $user;
        $this->soggetto = $soggetto;
        $this->descrizione = $descrizione;
        $this->cc_email =$cc_email;
        $this->bcc_email = $bcc_email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->cc_email !=null) $this->cc($this->cc_email);
        if ($this->bcc_email !=null) $this->bcc($this->bcc_email);
        return $this->view('emails.single.single',['descrizione'=>$this->descrizione])
                     ->from($this->logged_user)
                     ->to($this->user)
                     ->replyTo($this->logged_user)
                     ->subject($this->soggetto);

    }
}
