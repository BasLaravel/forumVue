<?php

namespace App\Listeners;

use App\Events\ThreadReceivedNewReply;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Notifications\ThreadWasUpdated;

class NotifySubscribers
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
     * @param  ThreadReceivedNewReply  $event
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        $thread=$event->reply->thread;
        
        foreach($thread->subscriptions as $subscription){
            if($subscription->user_id != $event->reply->user_id){
            $subscription->user->notify(new ThreadWasUpdated($thread, $event->reply));
            }
        }
    }
}
