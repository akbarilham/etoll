<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Request;

class AdminRole
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
        $uri = explode('/', Request::path());

        $allowed = []; // store allowed  scaffolding route to access here as array value ex : ['user', 'role', 'cash', etc]

        /*Add change password */
        $allowed[] = 'changepassword';

        $authorization = Session::get('logged_user')['authorization'];

        foreach($authorization as $key=>$url)
        {
            if(is_array($url)) {

                foreach($url as $child_url) {
                    $allowed[] = $child_url->route;
                }

            }else {
                $allowed[] = $url->route;
            }
            
        }

       if(in_array($uri[0], $allowed))
        {
            return $next($request);
        }else{
            return redirect('/welcome');
        }

        return $next($request);
    }
}
