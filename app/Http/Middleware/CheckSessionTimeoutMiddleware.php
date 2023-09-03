<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Helpers\SessionManager;

class CheckSessionTimeoutMiddleware
{
    public function handle($request, Closure $next)
    {
        if (session()->has('idUser')) {
            SessionManager::checkSessionTimeout($request);
        }
        return $next($request);
    }
}
