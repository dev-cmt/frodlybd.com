<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class EnsureTokenIsValid
{
    public function handle(Request $request, Closure $next)
    {
        // Get token from header or query param
        $token = $request->header('X-API-TOKEN') ?? $request->query('token');

        if (!$token) {
            return response()->json(['error' => 'API Token missing'], 401);
        }

        // Retrieve user by token
        $user = User::where('api_token', $token)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid API token'
            ], 401);
        }

        // Authenticate this user for the request
        // auth()->setUser($user);

        return $next($request);
    }
}
