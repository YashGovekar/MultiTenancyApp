<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Config;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            $url_parts = explode('.', request()->getHttpHost());

            if (count($url_parts) > 2) {
                return route('subdomain.login.index', $request->route()->account);
            }

            return route('login.index');
        }
    }
}
