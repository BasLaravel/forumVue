<?php

namespace App;

use Redis;
use App\Thread;


class Trending
{

    public function get(){

        //$trending is in json 
        return array_map('json_decode', Redis::zrevrange('trending_threads', 0, 4));

    }
 
    public function push($thread){

        Redis::zincrby('trending_threads', 1, json_encode([
            'title' => $thread->title,
            'path'  => $thread->path(),
            
    ]));

    }

    // nog niet in gebruik
    // public function delete($thread){

    //     Redis::delete('trending_threads'([
    //         'title' => $thread->title,
    //         'path'  => $thread->path()
            
    // ]));

    // }

}