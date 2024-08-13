<?php

namespace App\Http\Controllers\api\accessToken;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

use App\Models\Helper\Helpers;
use Carbon\Carbon;

class GenerateAccessTokenController extends Controller
{
    protected $client_id = ""; 
    protected $base_url = "https://dev.nicepay.co.id/nicepay/v1.0/access-token/b2b";
    PROTECTED $key = "-----BEGIN RSA PRIVATE KEY-----" . "\r\n" .
    "" . // string private key
    "\r\n" .
    "-----END RSA PRIVATE KEY-----";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * generate access token
     * 
     * @return json
     */
    public function generateAccessToken()
    {
        $helper = new Helpers();
        $x_time_stamp = Carbon::now()->toIso8601String();
        $client_id = $this->client_id;

        $addInfo = new \stdClass();

        $bd = [
            "grantType" => "client_credentials",
            "additionalInfo" => json_encode($addInfo)
        ];

        $string_to_sign = $client_id . "|" . $x_time_stamp;
        print_r($string_to_sign);
        print_r("\r\n");

        $signature = $helper->generateSignature($string_to_sign, $this->key, OPENSSL_ALGO_SHA256);
        print_r($signature);
        print_r("\r\n");
        
        $header = $helper->generateHeaderAccessToken($x_time_stamp, $client_id, $signature);
        print_r($header);
        print_r("\r\n");

        try {
            $response = Http::withHeaders($header)->post($this->base_url, $bd);
        } catch (\Throwable $th) {
            // throw $th;

            return response()->json([
                'status' => $response->status(),
                'message' => $response->successful(),
                'data' => $response->json()
            ]);
        }

        return response()->json([
            'status' => $response->status(),
            'message' => $response->successful(),
            'data' => $response->json()
        ]);
    }
}
