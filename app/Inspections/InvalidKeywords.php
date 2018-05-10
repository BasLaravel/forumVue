<?php

namespace App\Inspections;

use Exception;

class InvalidKeywords
{

    protected $keywords=[
        'spam'
    ];

    public function detect($body){
       
        foreach($this->keywords as $keyword){
         
                if(stripos($body,$keyword)!==false){
                $error= \Illuminate\Validation\ValidationException::withMessages(['body'=> 'Dit is spam']); 
                //throw new Exception('Your reply contains spam');
                throw $error;
                }

        }

    }

}