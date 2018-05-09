<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ParticipateInForumTest extends TestCase
{

    use RefreshDatabase;


    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->be($user = factory('App\User')->create());
        $thread = factory('App\Thread')->create();

        
        $reply = factory('App\Reply')->make();
        $this->post(route('reply.store', [$thread->channel->slug, $thread->id]), $reply->toArray());

      
        $response = $this->get('/threads/'. $thread->channel->slug .'/'.$thread->id);
        $response->assertSee($reply->body); 
    }


}