<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Log;

class AuthController extends Controller
{
    public function user(){
        return Auth::user();
    }

    public function login(Request $request) {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw new AuthenticationException();
        }

        $tokenName = "default";

        $user->tokens()->where('name', $tokenName)->delete();

        return response([
            'access_token' => $user->createToken($tokenName)->plainTextToken,
        ]);
    }

    public function logout() {
        Auth::user()->tokens()->delete();

        return response([
            "code" => 0,
            "message" => "logout success"
        ], 204);
    }

    public function logoutResponse() {
        return response()->json([
            "code" => 400,
            "message" => "user not logined"
        ], 400);
    }
}
