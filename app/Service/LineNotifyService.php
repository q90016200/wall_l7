<?php
namespace App\Service;

use Log;
use Illuminate\Http\Request;
use Exception;

use App\Models\User;
use App\Models\UsersSocial;

class LineNotifyService
{
    /**
     * line notify document
     * https://notify-bot.line.me/doc/en/
     */

    protected $accessToken;

    public function __construct($accessToken){
        $this->accessToken = $accessToken;
    }

    /**
     * 產生 auth 網址
     */
    public static function auth($encrypted) {
        $clientId = env("LINE_NOTIFY_CLIENT_ID");
        $clientSecret = env("LINE_NOTIFY_CLIENT_SECRET");
        $callbackUrl = env("LINE_NOTIFY_CALLBACK_URL");

        return "https://notify-bot.line.me/oauth/authorize?response_type=code&scope=notify&response_mode=form_post&client_id={$clientId}&redirect_uri={$callbackUrl}&state=". $encrypted;
    }

    /**
     * oauth/token
     * POST https://notify-bot.line.me/oauth/token
     * Method	POST
     * Content-Type	application/x-www-form-urlencoded
     */
    public static function oauthToken($user_id, $code) {
        $clientId = env("LINE_NOTIFY_CLIENT_ID");
        $clientSecret = env("LINE_NOTIFY_SECRET_KEY");
        $callbackUrl = env("LINE_NOTIFY_CALLBACK_URL");

        # 先檢查 user 是否有關聯過 lineNotify
        $users = User::where('id', $user_id)->first();
        $lineNotifyLink = $users->social()->first();
        if (isset($lineNotifyLink->line_notify)) {
            # 關聯過執行撤銷
            // return "1";
            $lineNotify = new LineNotifyService($lineNotifyLink->line_notify);
            $lineNotify->revoke();
        } else {
            // return "2";
        }

        # get access_token
        $postUrl = "https://notify-bot.line.me/oauth/token";
        $postParams = [
            "grant_type" => "authorization_code",
            "code" => $code,
            "redirect_uri" => $callbackUrl,
            "client_id" => $clientId,
            "client_secret" => $clientSecret,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $postUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: application/x-www-form-urlencoded']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postParams));

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        // print_r("response:{$response}");
        // print_r("err:{$error}");
        // return ;

        $response = json_decode($response, true);
        if ($error == null && isset($response["access_token"])) {
            if (!isset($lineNotifyLink->line_notify)) {
                $users->social()->save(new UsersSocial(['line_notify' => $response["access_token"]]));
            } else {
                $users->social()->update(['line_notify' => $response["access_token"]]);
            }

            return $response["access_token"];
        }

    }


    /**
     * 傳送訊息
     * POST https://notify-api.line.me/api/notify
     * Content-Type	application/x-www-form-urlencoded OR multipart/form-data
     * Authorization	Bearer <access_token>
     */
    public function sendMessage($message = "") {
        $accessToken = $this->accessToken;

        if ($accessToken != "" && $message != "") {

            $postParams = [
                "message" => $message,
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $accessToken
            ]);
            curl_setopt($ch, CURLOPT_URL, "https://notify-api.line.me/api/notify");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postParams));
            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);

            Log::info("[line notify send] response:{$response}");
            Log::info("[line notify send] err:{$error}");

            return json_decode($response, true) ;
        }
    }

    /**
     * 撤銷 access_token
     * https://notify-api.line.me/api/revoke
     * Content-Type	application/x-www-form-urlencoded
     * Authorization	Bearer <access_token>
     */
    public function revoke() {
        $accessToken = $this->accessToken;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Content-type: application/x-www-form-urlencoded'
        ]);

        curl_setopt($ch, CURLOPT_URL, "https://notify-api.line.me/api/revoke");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([]));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);


        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);


        // Log::info("[line notify revoke]response:{$response}");
        // Log::info("[line notify revoke]err:{$error}");
    }

}
