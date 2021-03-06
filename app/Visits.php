<?php

namespace App;

use Redis;

class Visits
{
protected $thread;

    public function __construct($thread){
        $this->thread = $thread;
    }

    public function record()
    {
        Redis::incr($this->cacheKey());
        return $this->thread;
    }


    public function count()
    {
       return Redis::get($this->cacheKey()) ?? 0;
    }

    public function delete()
        {
        Redis::del($this->cacheKey());
        }

    
    public function cacheKey()
    {
       return 'threads'.$this->thread->id.'visits';
    }

    






}