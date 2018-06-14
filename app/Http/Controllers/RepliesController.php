<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Thread;
use App\Reply;
use App\User;
use App\Inspections\Spam;
use App\Notifications\YouWereMentioned;
use Illuminate\Validation\ValidationException;


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


        if($thread->locked){
            return response('Thread is locked', 422);
        }

        try{
            $this->authorize('create', new Reply);
           } catch(\Exception $e){
                $error = ValidationException::withMessages(['body'=> ['Te snel, neem even pauze']]);  
                     throw $error;
           }

        $this->validateReply();
     
        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);


       session()->flash('message', 'Uw antwoord is gepost.');
       return redirect('/threads/'.$thread->channel->slug.'/'.$thread->slug);
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

        return response(request('body'));
           
    }


    protected function validateReply(){
  
        $this->validate(request(),[
            'body'=> 'required',
            ]);

        resolve('App\Inspections\Spam')->detect(request('body'), 'body');
    }



}
