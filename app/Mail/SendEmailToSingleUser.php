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
     protected $bcc_emial;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($logged_user,$user,$soggetto,$descrizione,$cc_email=null,$bcc_emial=null)
    {
        //
        $this->logged_user = $logged_user;
        $this->user = $user;
        $this->soggetto = $soggetto;
        $this->descrizione = $descrizione;
        $this->cc_email =$cc_email;
        $this->bcc_emial = $bcc_emial;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.single.single',['descrizione'=>$this->descrizione])
                     ->from($this->logged_user)
                     ->to($this->user)
                     ->replyTo($this->logged_user)
                     ->subject($this->subject)
                     ->cc($this->cc_email)
                     ->bcc($this->bcc_emial);

    }
}
