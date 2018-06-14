<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\ThreadWasUpdated;



use App\Events\ThreadReceivedNewReply;

class Thread extends Model
{
    use Traits\RecordsActivity, Traits\RecordsVisits;

    protected $guarded =[];
    protected $with=['creator', 'channel'];
    protected $appends=['isSubscribed'];
    protected $casts = ['locked' => 'boolean'];
   

    
    protected static function boot()
    {

        parent::boot();

     
        static::deleting(function($thread){
            $thread->replies->each->delete();
        });

        static::created(function($thread){
            $thread->update(['slug' => $thread->title]);
        });


    }

    public function getRouteKeyname(){
        return 'slug';
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


   public function visits(){

    return new Visits($this);
   }



//---------------------------------custom-model-functies------------------------------------------------------

 
        public function addReply($reply)
        {
            $reply = $this->replies()->create($reply);

            event(new ThreadReceivedNewReply($reply));

             return $reply;

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


    public function path(){

        $path = '/threads/' . $this->channel->slug .'/'. $this->slug;

        return $path;
    }


     //-------------------------------Attributen--------------------------------------------
    
     public function getIsSubscribedAttribute() 
     {
       $count = $this->subscriptions->where('user_id', auth()->id())->count();
       return $count;
     }



    public function setSlugAttribute($title){

        $slug = str_slug($title);

        if(static::whereSlug($slug)->exists()){

            $slug= "{$slug}-".$this->id;
        }

        $this->attributes['slug'] = $slug;
    }






}
