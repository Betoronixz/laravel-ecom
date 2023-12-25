<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response; // Update this import statement
use Illuminate\Http\RedirectResponse; // Add this import statement

class UserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse  // Update the return type here
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->path() == "login" && $request->session()->has("user")) {
            return redirect()->route("home");
        }

        return $next($request);
    }
}
