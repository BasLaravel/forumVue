<?php

namespace App\Inspections;

use Exception;
use Illuminate\Validation\ValidationException;

class InvalidKeywords
{

    protected $keywords=[
        'spam'
    ];

    public function detect($body){
       
        foreach($this->keywords as $keyword){
         
                if(stripos($body,$keyword)!==false){
                $error = ValidationException::withMessages(['body'=> 'Dit is spam']); 
                throw $error;
                }

        }

    }

}