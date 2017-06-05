<?php

namespace App\Http\Middleware;

use Closure,Route,Session;

class AuthAdminMiddleware
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

        if (!Session::has('admin')) {
            $url = route('adminLogin');
            header('Location:'.$url);
            exit;
        }
        else
        return $next($request);
    }
}
