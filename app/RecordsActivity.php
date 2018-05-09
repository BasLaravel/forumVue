<?php

namespace App;

trait RecordsActivity
{

   
    protected static function bootRecordsActivity()
    {
        if(auth()->guest()) return;

        static::created(function($model){  
            $model->recordActivity('created');
            });

        static::deleting(function($model){
                $model->activity()->delete();
                });



    }

    protected function recordActivity($event){
        Activity::create([
                    'user_id' => auth()->id(),
                    'type' => $event.'_'.strtolower((new\ReflectionClass($this))->getShortName()), //maakt van App\Foo->foo
                    'subject_id' => $this->id,
                    'subject_type' => get_class($this)
                ]);
        }

    public function activity()
    {
        return $this->morphMany('App\Activity','subject');
    }

}