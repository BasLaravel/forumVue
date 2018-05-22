<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilters;
use App\Channel;
use App\Thread;
use App\Inspections\Spam;
use App\Trending;

use Illuminate\Http\Request;

class ThreadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index','show');
    }


    /**
     * Display a listing of the resource.
     * 
     * gebruikt queryIndexBuilder($channel) methode
     * 
     * 
     */
    public function index($channel=null, Trending $trending)
    {
        $threads=($this->queryIndexBuilder($channel)->get());   

       return view('threads.index', [
           'threads' => $threads,
           'trending' => $trending->get()
       ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateThread();

        $thread = Thread::create([
        'title'=> request('title'),
        'channel_id'=> request('channel_id'),
        'body'=> request('body'),
        'user_id'=> auth()->id(),
        'slug'=> str_slug(request('title'))
        ]);

        session()->flash('message', 'Uw thread is gepost.');
        return redirect(route('thread.show', [$thread->channel->slug, $thread->slug]));      
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channel, Thread $thread, Trending $trending)
    {
        $replies= $thread->replies()->paginate(25);
    
        $trending->push($thread);

        $thread->visits()->record();
            
        return view('threads.show',compact('thread','replies'));

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($channel, Thread $thread, Trending $trending)
    {
        $this->authorize('update', $thread);

        $thread->delete();

        $thread->visits()->delete();
       
        session()->flash('message', 'Uw thread is verwijderd.');

        return redirect('/threads');
    }



    protected function validateThread(){

        $this->validate(request(),[
            'title'=> 'required|max:100',
            'body'=> 'required',
            'channel_id'=> 'required|exists:channels,id' 
        ]);

        resolve(Spam::class)->detect(request('title'), 'title');
        resolve(Spam::class)->detect(request('body'), 'body');
    }



/**
     * bouwt een query op
     *
     * optie 1 per channel
     * optie 2 all()
     * optie 3 naar naam
     * optie 4 naar populariteit
     * 
     * @param $channel
     *
     */
    public function queryIndexBuilder($channel)
    {  
        if(!empty($channel)){
            $channel = Channel::where('name',$channel)->firstOrFail();
            $threads = $channel->threads()->latest();
        }else{
        $threads = Thread::latest();
        }
        
        if($username = request('by')){
            $user = \App\User::where('name',$username)->firstOrFail();
        $threads->where('user_id',$user->id);
        }
 
        if(request('popular')){
        $threads->getQuery()->orders=[];
        $threads->orderBy('replies_count','desc');
        }

        if(request('unanswered')){
            $threads->where('replies_count', 0);
            }

        return $threads;
    }



}
