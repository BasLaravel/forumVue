<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserNotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index($user){
        $ar=[];

        $user=User::find($user);

        foreach($user->unreadNotifications as $data){
            $ar[]=$data->data;
        }

        return response($ar);
        
        }


    public function destroy($user, $notificationId){

    $user=User::find($user);
    $user->notifications()->findOrfail($notificationId)->delete();
    }
}