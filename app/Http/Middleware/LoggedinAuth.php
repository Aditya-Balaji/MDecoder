<?php

namespace App\Http\Middleware;

use Closure;
use Session;
class LoggedinAuth
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
        if(Session::has('user_id'))
        {
            return redirect('/home');
        }
        else
        {
            return $next($request);
        }
    }
}
