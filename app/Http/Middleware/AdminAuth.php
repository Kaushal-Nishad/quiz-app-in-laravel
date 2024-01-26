<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path=$request->path();

        if(( $path == "/") && Session::get('admin')){
            return redirect('admin/dashboard');
        }
        else if(($path != '/') && (!Session::get('admin'))){
            return redirect('/');
        }else{
            return $next($request);
        }
    }
}
