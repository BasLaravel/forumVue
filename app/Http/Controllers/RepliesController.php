<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Thread;
use App\Reply;
use App\Inspections\Spam;


class RepliesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

/**
 * Persist a new Reply
 * 
 * @param integer $channelId
 * @param Thread $thread
 * @param Request $request
 * @param Spam $spam
 * @return \Illuminate\Http\RedirectResponse
 * 
 */
    public function store($channelId, Thread $thread, Request $request, Spam $spam){

        
        $this->validate(request(),[
            'body'=> 'required',
            ]);

        $spam->detect(request('body'));

         $thread->addReply([

            'body' => request('body'),
            'user_id' => auth()->id()

        ]);
       return redirect('/threads/'.$thread->channel->slug.'/'.$thread->id);
    }



        public function destroy(Request $request, Reply $reply)
    {
       
        $this->authorize('update', $reply);

         $reply->delete();

        return response($reply);

    
    }


    public function update(Reply $reply)
    {
        
        $this->validate(request(),[
            'body'=> 'required|min:2'
   
            ]);

        $this->authorize('update', $reply);

        $body=request('body');

        $reply->update(['body'=>$body]);

           
    }




}
