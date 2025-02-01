<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (! $user) {
                return response()->json(['error' => 'Usuário não encontrado'], Response::HTTP_UNAUTHORIZED);
            }
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return response()->json(['error' => 'Token inválido'], Response::HTTP_UNAUTHORIZED);
            }

            if ($e instanceof TokenExpiredException) {
                return response()->json(['error' => 'Token expirado'], Response::HTTP_UNAUTHORIZED);
            }

            return response()->json(['error' => 'Erro na autenticação'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
