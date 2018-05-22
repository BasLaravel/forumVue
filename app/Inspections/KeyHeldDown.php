<?php

namespace App\Inspections;

use Exception;
use Illuminate\Validation\ValidationException;

class KeyHeldDown
{

    public function detect($request, $name){
        if(preg_match('/(.)\\1{4,}/u', $request)){
          $error = ValidationException::withMessages([$name => ['Dit is spam']]);  
           throw $error;
        }
        
    }

}

