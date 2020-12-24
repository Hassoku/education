<?php

namespace App\Listeners;

use App\Events\TutorStatus;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TutorStatusListener
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
     * @param  TutorStatus  $event
     * @return void
     */
    public function handle(TutorStatus $event)
    {
        //
    }
}
