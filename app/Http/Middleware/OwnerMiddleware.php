<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class OwnerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'owner') {
            return redirect('/')->with('error', 'Akses hanya untuk pemilik kost!');
        }
        return $next($request);
    }
}