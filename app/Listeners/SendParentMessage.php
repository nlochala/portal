<?php

namespace App\Listeners;

use App\Events\ParentMessageSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendParentMessage implements ShouldQueue
{
    use InteractsWithQueue;

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
     * @param  ParentMessageSent  $event
     * @return void
     */
    public function handle(ParentMessageSent $event)
    {
        $message = $event->message;
    }
}
