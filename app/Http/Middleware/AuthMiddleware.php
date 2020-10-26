<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;

class AuthMiddleware
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
    if(session('access_token') && !Carbon::parse(session('expires_at'))->isPast()){
      return $next($request);
    }
    session()->flush();

    return redirect()->route('login');
  }
}
