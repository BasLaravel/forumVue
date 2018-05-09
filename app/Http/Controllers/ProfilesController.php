<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;

class ProfilesController extends Controller
{
    public function show(\App\User $user)
    {
      
    $profileUser = $user;
    
    $activities=Activity::feed($user);
    
   
        return view('profiles.show',compact('profileUser','activities'));

    }

}
