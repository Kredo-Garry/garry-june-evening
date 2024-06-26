<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; //class use to authenticate the user
use App\Models\User; // represents the users table


class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
            #   True      &&              1      ===         1
        if (Auth::check() && Auth::user()->role_id === User::ADMIN_ROLE_ID) { //True
            # Auth::check() --> check if the user is login, if the user is not login,
            # the program will redirect the user to the login page
            # Auth::user->role_id --> check the role id from the database table
            # User::ADMIN_ROLE_ID --> the Admin role id which 1


            return $next($request);
        }

        return redirect()->route('index'); //homepage
    }
}
