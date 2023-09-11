<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $segment = $request->segment(1);

        if(!in_array($segment, ['id', 'en'])){
            return redirect(url('id'));
        }

        app()->setLocale($segment);

        return $next($request);
    }
}
