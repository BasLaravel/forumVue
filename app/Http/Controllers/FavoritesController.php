<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Reply;
use App\Thread;

use Illuminate\Http\Request;
//om een hash in te voegen.
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class FavoritesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function store(Reply $reply)
    {

        if(!$reply->favorites()->where(['user_id'=>auth()->id()])->exists()){
             Favorite::create([
                'user_id'=> auth()->id(),
                'favorited_id'=> $reply->id,
                'favorited_type'=> get_class($reply)    

            ]);

        $reply=$reply->refresh();

        return response($reply);
     
       }

       
    }



    public function destroy(Reply $reply)
    {
        if($reply->favorites()->where(['user_id'=>auth()->id()])->exists()){

         $reply->favorites()->where(['user_id'=>auth()->id()])->get()
         ->each->delete();

         $reply=$reply->refresh();

        return response($reply);
       }


    }





}
