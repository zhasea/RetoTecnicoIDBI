<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Auth\AuthenticationException;
use Closure;

class CustomAuthenticate extends Middleware
{
    protected function unauthenticated($request, array $guards)
    {
        abort(response()->json([
            'error' => 'Usuario no autenticado',
            'message' => 'Debe proporcionar un token de autenticación válido.'
        ], 401));
    }
}
