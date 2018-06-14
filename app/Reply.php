<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Favorite;
use Carbon\Carbon;


class Reply extends Model
{

    use Traits\RecordsActivity;
    
    protected $guarded =[];

    protected $with=['owner','favorites'];

    protected $appends = ['favoritesCount', 'isFavorited', 'axiosCount', 'isBest'];

    protected static function boot()
    {

        parent::boot();

        static::deleting(function($reply){
        $reply->favorites->each->delete();
        });

        static::created(function($reply){
            $reply->thread->increment('replies_count');
            });

        static::deleting(function($reply){
               $reply->thread->decrement('replies_count');
            });

    }


    public function owner()
    {
        return $this->belongsTo('App\User','user_id');

    }

    public function thread()
    {
        return $this->belongsTo('App\Thread');
        
    }

    public function favorites()
    {
        return $this->morphMany('App\Favorite','favorited');

    }

    public function isFavorited()
    {
        return $this->favorites->where('user_id', auth()->id())->count();

    }

    public function wasJustPublished(){
        return $this->created_at->gt(Carbon::now()->subMinute());
    }




    //-------------------------------Attributen--------------------------------------------
    
    public function getFavoritesCountAttribute() 
    {
        return $this->favorites->count();

    }

    
    public function getIsFavoritedAttribute() 
    {
        return $this->isFavorited();

    }


    public function getAxiosCountAttribute() 
    {
        return $this->thread->replies_count;
      
    }


    public function setBodyAttribute($body){

        $this->attributes['body'] = preg_replace('/@([\w\-]+)/', '<a href="/profiles/$1">$0</a>', $body);
    }


    
    public function isBest(){

        return $this->thread->best_reply_id == $this->id;

    }
   
    public function getIsBestAttribute(){

        return $this->isBest();
    }

}
