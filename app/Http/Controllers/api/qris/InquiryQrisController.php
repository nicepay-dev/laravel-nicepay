<?php

namespace App\Http\Controllers\api\qris;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Models\Helper\Helpers;
use Carbon\Carbon;
use App\Http\Controllers\api\accessToken\GenerateAccessTokenController; 


class InquiryQrisController extends Controller{

    protected $partner_id;
    protected $domain = "https://dev.nicepay.co.id/nicepay";
    protected $end_point_inquiry = "/api/v1.0/qr/qr-mpm-query";
    PROTECTED $key ;
    PROTECTED $client_secret; // string credential
    PROTECTED $access_token;
    PROTECTED $store_id = "NICEPAY";

    // for amount
    PROTECTED $amt = "100.00";
    /* 
     * if want to partial refund (not full partial), 
     * need to change amount manual in refundQris function 
     * */
    PROTECTED $cancel_type = 1; 

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GenerateAccessTokenController $accessTokenController)
    {
        $this->key = env('RSA_PRIVATE_KEY');
        $this->partner_id = env('CLIENT_ID');
        $this->client_secret = env('CLIENT_SECRET');
        // Automatically fetch a new access token
        $this->access_token = $accessTokenController->generateAccessToken();
    }

    /**
     * inquiry transaction qris
     * for check status transaction
     * 
     * @return json
     */
    public function inquiryQris()
    {
        $helper = new Helpers();
        $http_method = "POST";
        $date = Carbon::now();
        $x_time_stamp = $date->toIso8601String();
        $time_stamp = $date->format("YmdHis");
        $partner_id = $this->partner_id; //merchantId
        $client_secret = $this->client_secret;
        $access_token = $this->access_token;
        $store_id = $this->store_id;

        $external_id = "MrQrTst" . $time_stamp . Str::random(5);
        $original_reference_no = "IONPAYTEST08202411210631439601";
        $reference_no = "refNoQr20241121063143e0yIG";
        
        $additionalInfo = new \stdClass();

        $body = [
            "originalReferenceNo" => $original_reference_no,
            "originalPartnerReferenceNo" => $reference_no,
            "merchantId" => $partner_id,
            "externalStoreId" => $store_id,
            "serviceCode" => "51",
            "additionalInfo" => $additionalInfo
        ];

        $string_to_sign = $helper->generateStringToSign(
                $http_method, 
                $this->end_point_inquiry, 
                $access_token, 
                $body, 
                $x_time_stamp
            );

        $signature = $helper->hmacSHA512Encoded(
                $string_to_sign, 
                $client_secret, 
                OPENSSL_ALGO_SHA512
            );

        $header = $helper->generateHeader(
                $access_token, 
                $x_time_stamp, 
                $signature, 
                $partner_id, 
                $external_id,
                $partner_id . "08"
            );
        print_r($string_to_sign); 
        
        print_r("\r\n");
        
        print_r($header);
        print_r($body);

        try {
            $response = Http::withHeaders($header)->post($this->domain . $this->end_point_inquiry, $body);
            $data = [
                "data" => $response->json()
            ];

        } catch (\Throwable $th) {
            throw $th;
            // print_r($th);

            return response()->json([
                'status' => 500,
                'message' => "Internal Server Error",
                'data' => $th
            ]);
        }

        return response()->json([
            'status' => $response->status(),
            'message' => $response->successful(),
            'data' => $data
        ])->setEncodingOptions(JSON_UNESCAPED_SLASHES);
    }

}

?>