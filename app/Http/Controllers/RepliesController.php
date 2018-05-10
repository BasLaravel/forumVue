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
 * @return \Illuminate\Http\RedirectResponse
 * 
 */
    public function store($channelId, Thread $thread, Request $request){

        $this->validateReply();
     
         $thread->addReply([

            'body' => request('body'),
            'user_id' => auth()->id()

        ]);
        session()->flash('message', 'Uw antwoord is gepost.');
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
       
        $this->authorize('update', $reply);

        $this->validateReply();

        $body=request('body');
        $reply->update(['body'=>$body]);

           
    }

    protected function validateReply(){

        $this->validate(request(),[
            'body'=> 'required',
            ]);

        resolve(Spam::class)->detect(request('body'));
    }



}
