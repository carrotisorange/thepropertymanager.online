<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use DB;
use Auth;
use App\User;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!Auth::check()) {
			
            Session::flash('message', trans('errors.session_label'));
            Session::flash('type', 'warning');
          
            return redirect()->route('home');
          
          }
          
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
    
}
