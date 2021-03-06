<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class AuthVerifyToken
{
    const EROR = [
        'eroros' => [
            'Authorized' => ['Erorr token by Middleware']
        ],
    ];

    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        $user = User::where('remember_token', $token)->first();

        if (!$user) {
            return response(self::EROR, 401);
        }

        return $next($request);
    }
}
