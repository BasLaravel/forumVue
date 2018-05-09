<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Favorite;


class Reply extends Model
{

    use RecordsActivity;
    
    protected $guarded =[];

    protected $with=['owner','favorites'];

    protected $appends = ['favoritesCount', 'isFavorited', 'testCount'];

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

    //-------------------------------Attributen--------------------------------------------
    
    public function getFavoritesCountAttribute() 
    {
        return $this->favorites->count();

    }

    public function getIsFavoritedAttribute() 
    {
        return $this->isFavorited();

    }

    public function getTestCountAttribute() 
    {
        return $this->thread->replies_count;
      

    }


   

}
