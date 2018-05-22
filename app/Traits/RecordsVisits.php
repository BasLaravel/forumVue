<?php

namespace App\Traits;

use Redis;


trait RecordsVisits
{


    public function recordVisit()
    {
        Redis::incr($this->visitsCacheKey());
        return $this;
    }


    public function visits()
    {
       return Redis::get($this->visitsCacheKey());
    }


    public function visitsCacheKey()
    {
       return 'threads'.$this->id.'visits';
    }



}