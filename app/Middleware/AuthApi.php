<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ApiToken;
use Illuminate\Support\Facades\Hash;

class AuthApi
{
    public function handle(Request $request, Closure $next)
    {
        $header = $request->header('Authorization');

        if (!$header || !str_starts_with($header, 'Bearer ')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $plainToken = substr($header, 7);

        $token = ApiToken::with('tokenable')->get()
            ->first(fn($t) => Hash::check($plainToken, $t->token_hash));

        if (!$token) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        $token->update(['last_used_at' => now()]);

        $request->setUserResolver(fn() => $token->tokenable);

        return $next($request);
    }
}