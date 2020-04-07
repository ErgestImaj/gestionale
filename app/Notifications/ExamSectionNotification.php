<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExamSectionNotification extends Notification
{
    use Queueable;

		public $exam;
		public $creator;

	/**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($exam,$creator)
    {
        //
			$this->exam = $exam;
			$this->creator = $creator;
		}

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
					          ->subject('New Exam Section Created')
                    ->line('Si prega di confermare la prezenca')
                    ->action('Conferma', url('/'))
                    ->line('Il support!')
                    ->from($this->creator->email,$this->creator->firstname);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
