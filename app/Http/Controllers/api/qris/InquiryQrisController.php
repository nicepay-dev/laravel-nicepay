<?php

namespace App\Http\Controllers\api\qris;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Models\Helper\Helpers;
use Carbon\Carbon;

class InquiryQrisController extends Controller{

    protected $partner_id = "";
    protected $domain = "https://dev.nicepay.co.id/nicepay";
    protected $end_point_inquiry = "/api/v1.0/qr/qr-mpm-query";
    PROTECTED $key = "-----BEGIN RSA PRIVATE KEY-----" . "\r\n" .
    "" . // string private key
    "\r\n" .
    "-----END RSA PRIVATE KEY-----";
    PROTECTED $client_secret = "1af9014925cab04606b2e77a7536cb0d5c51353924a966e503953e010234108a"; // string credential
    PROTECTED $access_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUTklDRVFSMDgxIiwiaXNzIjoiTklDRVBBWSIsIm5hbWUiOiJOSUNFUEFZIiwiZXhwIjoiMjAyNC0wOC0xMlQwODo0MjowNVoifQ==.Ks_CPBMEsI_9eHOhlJTkCItnXfVxy-QPO-hKvwnrdk8=";
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
    public function __construct()
    {

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
        $original_reference_no = "TNICEQR08108202408121527382996";
        $reference_no = "refNoQr20240812152742rhfmL";
        
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
            'data' => $response->object()
        ])->setEncodingOptions(JSON_UNESCAPED_SLASHES);
    }

}

?>