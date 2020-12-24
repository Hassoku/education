<?php

namespace App\Listeners;

use App\Events\SendLearningSessionRequestToTutorEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendLearningSessionRequestToTutorListener
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
     * @param  SendLearningSessionRequestToTutorEvent  $event
     * @return void
     */
    public function handle(SendLearningSessionRequestToTutorEvent $event)
    {

    }
}
