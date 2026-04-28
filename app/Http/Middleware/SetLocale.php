<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $locale = session('locale');
            if ($locale) {
                app()->setLocale($locale);
            }
        } catch (\Exception $e) {
            // session mmazalt makanatsh
        }
        return $next($request);
    }
}