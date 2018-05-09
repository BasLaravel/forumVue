<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Thread;
use App\Reply;


class RepliesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    
    public function store($channelId, Thread $thread, Request $request){

        
        $this->validate(request(),[
            'body'=> 'required',
            ]);
       
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
