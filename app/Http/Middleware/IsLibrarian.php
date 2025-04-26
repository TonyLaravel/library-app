<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsLibrarian
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()?->role !== 'Librarian') {
            abort(403);
        }
        return $next($request);
    }
}
