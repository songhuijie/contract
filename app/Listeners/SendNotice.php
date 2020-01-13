<?php

namespace App\Listeners;

use App\Events\Notice;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotice
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
     * @param  Notice  $event
     * @return void
     */
    public function handle(Notice $event)
    {
        //
        $user_id = $event->user_id;
        $message = $event->message;

        dd($user_id,$message);
    }
}
