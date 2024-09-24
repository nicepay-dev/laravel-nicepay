<?php

namespace App\Http\Controllers\api\qris;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Models\Helper\Helpers;
use Carbon\Carbon;

class RefundQrisController extends Controller{

    protected $partner_id = ""; //String partner id / merchantId
    protected $domain = "https://dev.nicepay.co.id/nicepay";
    protected $end_point_refund = "/api/v1.0/qr/qr-mpm-refund";
    PROTECTED $key = "-----BEGIN RSA PRIVATE KEY-----" . "\r\n" .
    "" . // string private key
    "\r\n" .
    "-----END RSA PRIVATE KEY-----";
    PROTECTED $client_secret = ""; // string credential
    PROTECTED $access_token = "";
    PROTECTED $store_id = "";

    // for amount
    PROTECTED $amt = "100.00";
    /* 
     * if want to partial refund (not full partial), 
     * need to change amount manual in refundQris function 
     * */
    PROTECTED $cancel_type = 1; 

    /**
     * refund transaction qris
     * 
     * @return json
     */
    public function refundQris()
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
        $partner_refund_no = "refndNoQr" . $time_stamp . Str::random(5);
        
        $refundAmount = [
            "value" => $this->amt,
            "currency" => "IDR"
        ]; 

        $additionalInfo = [
            "cancelType" => $this->cancel_type
        ];

        $body = [
            "originalReferenceNo" => $original_reference_no,
            "originalPartnerReferenceNo" => $reference_no,
            "partnerRefundNo" => $partner_refund_no,
            "merchantId" => $partner_id,
            "externalStoreId" => $store_id,
            "refundAmount" => $refundAmount,
            "reason" => "Hit refund from plugin laravel",
            "additionalInfo" => $additionalInfo
        ];

        $string_to_sign = $helper->generateStringToSign(
                $http_method, 
                $this->end_point_refund, 
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
            $response = Http::withHeaders($header)->post($this->domain . $this->end_point_refund, $body);
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