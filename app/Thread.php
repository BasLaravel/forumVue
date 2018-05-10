<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\ThreadWasUpdated;

class Thread extends Model
{

    use RecordsActivity;

    protected $guarded =[];
    protected $with=['creator', 'channel'];
    protected $appends=['isSubscribed'];
   

    
    protected static function boot()
    {

        parent::boot();

     
        static::deleting(function($thread){
            $thread->replies->each->delete();
        });

    }


    public function replies()
    {
        return $this->hasMany('App\Reply');
       
         
    }

    public function creator()
    {
        return $this->belongsTo('App\User','user_id');

    }

 
    public function channel()
    {
        return $this->belongsTo('App\Channel');

    }

    public function activity()
    {
        return $this->morphMany('App\Activity','subject');
    }



    public function subscriptions()
    {
        return $this->hasMany('App\ThreadSubscription');
    }





//---------------------------------custom-model-functies------------------------------------------------------

 
        public function addReply($reply)
        {
            $reply = $this->replies()->create($reply);

             $this->notifySubscribers($reply);

        }

        public function notifySubscribers($reply){

        //meld aan iedere subscriber dat er een nieuwe reply op de thread is gekomen
                foreach($this->subscriptions as $subscription){
                    if($subscription->user_id != $reply->user_id){
                    $subscription->user->notify(new ThreadWasUpdated($this, $reply));
                    }
                }
        }




        public function latestReply()
        {
            return $this->replies()->latest()->first()->id;

        }


    public function subscribe()
    {
         return $this->subscriptions()->create([
            'user_id'=> auth()->id()

         ]);
    }

    public function unsubscribe()
    {
          $this->subscriptions()->where('user_id', auth()->id())
            ->delete();

    }


     //-------------------------------Attributen--------------------------------------------
    
     public function getIsSubscribedAttribute() 
     {
       $count = $this->subscriptions->where('user_id', auth()->id())->count();
       return $count;
     }

   



}
