<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class TeacherAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path=$request->path();
     
        if(( $path == "teacher/login") && Session::get('teacher_id')){
            return redirect('/teacher/home');
        }
        else if( $path != 'teacher/login' && !Session::get('teacher_id')){
            return redirect('teacher/login');
        }
        return $next($request);
    }
}
