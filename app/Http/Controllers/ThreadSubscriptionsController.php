<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;

class ThreadSubscriptionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }



    public function store($channelId, Thread $thread, Request $request)
    {
        if(!$thread->subscriptions()->where(['user_id'=>auth()->id()])->exists()){
            
            $thread->subscribe();
        
        }
            
    }

    public function destroy($channelId, Thread $thread, Request $request)
    {
        if($thread->subscriptions()->where(['user_id'=>auth()->id()])->exists()){

         $thread->subscriptions()->where(['user_id'=>auth()->id()])->get()->each->delete();
   
    }
            
    }

}


