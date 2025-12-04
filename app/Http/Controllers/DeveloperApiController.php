<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DeveloperApiController extends Controller
{
    public function index()
    {
        return view('backEnd.developer-api.index');
    }

    public function generateToken(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return back()->with('error', 'User not authenticated.');
        }

        // Generate a new JWT token for this user
        // $newToken = JWTAuth::fromUser($user);
        $token = Str::random(60);

        // Save the token in the database if you store it
        $user->update([
            // 'api_token' => $newToken
            'api_token' => hash('sha256', $token)
        ]);

        return back()->with('success', 'New API token generated!');
    }
}
