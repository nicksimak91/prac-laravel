<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class ApartmentsVerifyToken
{
    const EROR = [
        'eroros' => [
            'Authorized' => ['Erorr token by Middleware']
        ],
    ];

    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        $user = $request->setUserResolver(fn () => User::where('api_token', $token)->first());

        if (!$user) {
            return response(self::EROR, 401);
        }

        return $next($request);
    }
}
