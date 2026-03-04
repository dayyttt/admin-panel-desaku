<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckNotInstalled
{
    public function handle(Request $request, Closure $next)
    {
        // If already installed, redirect to admin
        if (file_exists(storage_path('.installed'))) {
            return redirect('/admin');
        }

        return $next($request);
    }
}
