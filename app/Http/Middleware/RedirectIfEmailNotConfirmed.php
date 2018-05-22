<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfEmailNotConfirmed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */


    public function handle($request, Closure $next)
    {
        if(!request()->user()->confirmed){
            session()->flash('message', 'U moet nog bevestiging. U heeft een email ontvangen');
            return redirect('/threads');
            
        }

        return $next($request);
    }
}
