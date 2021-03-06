<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatethreadsTest extends TestCase
{

    use RefreshDatabase;

/** @test */
public function guest_may_not_create_threads()
{
    $this->expectException('Illuminate\Auth\AuthenticationException');
    
    $thread = factory('App\Thread')->make();

    $this->post('/threads', $thread->toArray());

   
}



    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        
        $this->be($user = factory('App\User')->create());
        $thread = factory('App\Thread')->make();

        $response = $this->post('/threads', $thread->toArray());
        $response = $this->get($response->headers->get('location'));
        $response->assertSee($thread->body); 
    
    }


}