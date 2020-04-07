<?php

namespace App\Listeners;

use App\Events\ExamSectionCreated;
use App\Notifications\ExamSectionNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewExamSectionCreated implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ExamSectionCreated  $event
     * @return void
     */
    public function handle(ExamSectionCreated $event)
    {

			try {
				if ($event->examiner) $event->examiner->notify(new ExamSectionNotification($event->exam, $event->creator));
				if ($event->inigilator) $event->inigilator->notify(new ExamSectionNotification($event->exam, $event->creator));
				if ($event->inestigator) $event->inestigator->notify(new ExamSectionNotification($event->exam, $event->creator));

			} catch (\Exception $exception) {
				logger($exception->getMessage());
			}
    }
}
