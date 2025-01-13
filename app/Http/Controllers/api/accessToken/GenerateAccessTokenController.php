<?php

// namespace App\Http\Controllers\api\accessToken;
namespace Nicepay\NicepayLaravel\Http\Controllers\api\accessToken;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
// use App\Models\Helper\Helpers;
use Nicepay\NicepayLaravel\Models\Helper\Helpers;
use Carbon\Carbon;

class GenerateAccessTokenController extends Controller
{
    protected $client_id;
    protected $base_url;
    protected $key;
    protected $client_secret;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->client_id = env('CLIENT_ID', 'default_client_id'); // Default value for safety
        $this->base_url = env('BASE_URL', 'https://dev.nicepay.co.id/nicepay/v1.0/access-token/b2b'); // Default base URL
        $this->key = env('RSA_PRIVATE_KEY');
        $this->client_secret = env('CLIENT_SECRET');
    }

    /**
     * Generate access token
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

        $signature = $helper->generateSignature($string_to_sign, $this->key, OPENSSL_ALGO_SHA256);

        $header = $helper->generateHeaderAccessToken($x_time_stamp, $client_id, $signature);

        try {
            $response = Http::withHeaders($header)->post($this->base_url, $bd);

            dd($response);

            if ($response->successful()) {
                $access_token = $response->json()['accessToken'];

                // Return the access token only
                return $access_token;
            }

            // Handle unsuccessful response
            return response()->json([
                'status' => $response->status(),
                'message' => $response->json()['message'] ?? 'Failed to generate access token',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Internal Server Error',
                'error' => $th->getMessage()
            ]);
        }
    }
}

