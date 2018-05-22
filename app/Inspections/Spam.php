<?php

namespace App\Inspections;

class Spam
{

   
protected $inspections=[
    InvalidKeywords::class,
    KeyHeldDown::class
];


public function detect($request, $name){

    foreach($this->inspections as $inspection){
        app($inspection)->detect($request, $name);
    }
    return false;
}



}