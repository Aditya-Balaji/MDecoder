<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App\Day as Day;

class APISessionAuth
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
            $session_user_id = Session::get('user_id');
            if($request->user_id == $session_user_id)
            {
                if($request->day != Day::first()->pluck('day'))
                {
                    $data['status'] = 112;
                    $data['description'] = "You cannot request for a different day!";
                    return json_encode($data);
                }
                else
                    return $next($request);

            }
            else
            {
                $data['status'] = 110;
                $data['description'] = "Session mismatch!";
                return json_encode($data);
                return Day::first()->pluck('day');
            }
        }
        else
        {
            $data['status'] = 111;
            $data['description'] = 'Session not set!';
            return json_encode($data);
        }
    }
}
