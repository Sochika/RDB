<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Developer
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    // Check if the user is authenticated and if their ID is 1
    if (Auth::check() && Auth::id() == 1) {
      return $next($request); // Proceed if user ID is 1
    }

    // Redirect or deny access if not authorized
    return abort(403, 'Unauthorized action.');
  }
}
