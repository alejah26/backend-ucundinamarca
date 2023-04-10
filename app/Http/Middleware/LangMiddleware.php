<?php

namespace App\Http\Middleware;

use Closure;

class LangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       // $lang = $request->header()['x-localization'][0]; //TODO no funciona en backend el cambio de idioma desde un controller

        $local = ($request->hasHeader('X-localization')) ? $request->header('X-localization') : 'es';

        app()->setLocale($local);

        return $next($request);
    }
}
