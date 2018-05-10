<?php

namespace App\Inspections;

use Exception;

class KeyHeldDown
{

    public function detect($body){
        if(preg_match('/(.)\\1{4,}/u', $body)){
          $error= \Illuminate\Validation\ValidationException::withMessages(['body'=> 'Dit is spam']);  
           // throw new Exception('Your reply contains spam');
           throw $error;
        }
        
    }

}

