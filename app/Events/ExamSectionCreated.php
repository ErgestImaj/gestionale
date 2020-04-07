<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExamSectionCreated
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $exam;
	public $creator;
	public $examiner;
	public $inigilator;
	/**
	 * @var null
	 */
	public $inestigator;


	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($exam, $creator, $examiner=null, $inigilator=null, $inestigator = null)
	{
		$this->exam = $exam;
		$this->creator = $creator;
		$this->examiner = $examiner;
		$this->inigilator = $inigilator;
		$this->inestigator = $inestigator;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return \Illuminate\Broadcasting\Channel|array
	 */
	public function broadcastOn()
	{
		return new PrivateChannel('channel-name');
	}
}
