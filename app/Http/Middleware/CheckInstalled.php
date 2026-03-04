<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckInstalled
{
    public function handle(Request $request, Closure $next)
    {
        // Skip check for install routes
        if ($request->is('install*')) {
            return $next($request);
        }

        // If not installed, redirect to installer
        if (!file_exists(storage_path('.installed'))) {
            return redirect('/install');
        }

        return $next($request);
    }
}
