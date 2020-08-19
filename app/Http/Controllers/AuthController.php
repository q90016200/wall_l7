<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Log;

use App\Traits\ResponseTrait;

class AuthController extends Controller
{
    use ResponseTrait;

    public function user(){
        // return Auth::user();

        return $this->successResponse(Auth::user());
    }

    public function login(Request $request) {
        # 認證欄位
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns|exists:App\Models\User,email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse([
                "message" => $validator->errors()
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw new AuthenticationException();
        }

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            throw new AuthenticationException();
        }

        // # 產生 token
        // $tokenName = "default";

        // $user->tokens()->where('name', $tokenName)->delete();

        return $this->successResponse([
            'user' => Auth::user(),
            // 'access_token' => $user->createToken($tokenName)->plainTextToken,
        ]);

    }

    public function logout() {
        Auth::user()->tokens()->delete();

        return $this->successResponse(null, 'logout success', 204);
    }

    public function logoutResponse() {
        return $this->errorResponse(null, "user not logined");
    }
}
