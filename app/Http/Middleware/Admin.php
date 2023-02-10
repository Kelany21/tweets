<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
        if(auth()->guest()){
            return redirect('login');
            abort('404');
        }
        if(auth()->user()->group->can_access_admin != 'yes'){
            return redirect('/');
            abort('404');
        }
        return $next($request);
    }
}
