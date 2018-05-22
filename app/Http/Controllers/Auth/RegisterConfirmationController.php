<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\user;

class RegisterConfirmationController extends Controller
{

 public function index(){
    try{
        User::where('confirmation_token', request('token'))
            ->firstOrFail()
            ->update(['confirmed' => 1,
                      'confirmation_token' => NULL
            ]);
            
    }catch(\Exception $e){

        session()->flash('message', 'token niet herkend');
        return redirect('/threads');
    }
   

            session()->flash('message', 'Uw account is geactiveerd');
            return redirect('/threads');
    }







}
