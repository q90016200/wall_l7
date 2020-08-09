<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use App\Models\User;

use App\Service\LineNotifyService;

class LineNotifyController extends Controller
{
    public function __construct() {

    }

    public function auth(Request $request) {
        // return response()->json(auth()->user());

        // 确定当前用户是否已经认证
        if (Auth::check()) {
            // 获取当前通过认证的用户...
            $user = Auth::user();

            //  获取当前通过认证的用户 ID...
            $userId = Auth::id();

            // return $user->email;

            $encrypted = Crypt::encrypt(json_encode([$user]));

            return response()->json(
                [
                    'code' => 0,
                    'redirect' => LineNotifyService::auth($encrypted),

                ], 200
            );
        } else {
            return $this->errResponse("Not logged in");
        }

    }

    public function callback(Request $request) {
        $encryptedValue = $request->input("state");
        $code = $request->input("code");

        try {
            $decrypted = decrypt($encryptedValue);
        } catch (DecryptException $e) {
            return $this->errResponse("Decrypt Exception");
        }

        $user = json_decode($decrypted, true);
        $user_id = $user[0]["id"];

        try {
            // throw new \Exception("Error Processing Request", 1);

            $oauth = LineNotifyService::oauthToken($user_id, $code);
            if (empty($oauth)) {
                throw new \Exception("Error accessToken");
            } else {
                return redirect(env('APP_URL'));
            }

        } catch (\Throwable $th) {
            //throw $th;
            return $this->errResponse($th->getMessage());
        }
    }

    public function message(Request $request) {
        if (Auth::check()) {
            // 获取当前通过认证的用户...
            $user = Auth::user();

            //  获取当前通过认证的用户 ID...
            $userId = Auth::id();

            $users = User::where('id', $userId)->first();
            $lineNotifyAccessToken = $users->social()->first();

            // Log::info($lineNotifyAccessToken->line_notify);

            try {
                if ($lineNotifyAccessToken->line_notify) {
                    $lineNotify = new LineNotifyService($lineNotifyAccessToken->line_notify);
                    $lineNotifyresponse = $lineNotify->sendMessage($request->input("message"));

                    if (!isset($lineNotifyresponse["status"]) || $lineNotifyresponse["status"] != 200) {
                        throw new \Exception("send message fail");
                    }
                } else {
                    throw new \Exception("Error accessToken");
                }
            } catch (\Throwable $th) {
                return $this->errResponse($th->getMessage());
            }

            return response()->json([
                'code' => 0,
                'message' => 'line message send success',
            ]);

        } else {
            return $this->errResponse("Not logged in");
        }
    }

    private function errResponse($message = "") {
        return response()->json(
                [
                    'code' => 400,
                    'message' => $message,

                ], 400
            );
    }
}
