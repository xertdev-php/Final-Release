<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CheckLogin
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
        if(!Session::has('admin_session')) {
            if (!$request->ajax()) {
                Session::forget('admin_session');
                Session::flash("login_error", "You don't authorized for this action. Please Login Again");
                return redirect(url('/'));
            } else {
                return response()->json(array("status" => "success", "msg" => "You don't authorized for this action. Please Login Again"));
            }
        }else{
            return $next($request);
        }
    }
}
