<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class SavePetStatusToCookie
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('status')) {
            $status = $request->input('status');
            Cookie::queue('pet_status', $status, 60);
        }

        return $next($request);
    }
}
