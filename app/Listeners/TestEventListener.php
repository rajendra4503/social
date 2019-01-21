<?php

namespace App\Listeners;

use App\Events\TestEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use App\Jobs\MyJob;

class TestEventListener
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
     * @param  TestEvent  $event
     * @return void
     */
    public function handle(TestEvent $event)
    {
        dispatch(new MyJob());
        //Log::info('=== TestEventListener  ========');
    }
}
