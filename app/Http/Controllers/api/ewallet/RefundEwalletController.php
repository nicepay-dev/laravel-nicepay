<?php

namespace App\Http\Controllers\api\ewallet;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Models\Helper\Helpers;
use Carbon\Carbon;


class RefundEwalletController extends Controller
{

    protected $partner_id = "TNICEEW051";
    protected $domain = "https://dev.nicepay.co.id/nicepay";
    protected $end_point_refund = "/api/v1.0/debit/refund";
    PROTECTED $key = "-----BEGIN RSA PRIVATE KEY-----" . "\r\n" .
    "" . // string private key
    "\r\n" .
    "-----END RSA PRIVATE KEY-----";
    PROTECTED $client_secret = ""; // string client secret
    PROTECTED $access_token = ""; // string access token
    PROTECTED $store_id = "249668074512960";

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
     * refund transaction ewallet
     * 
     * @return json
     */
    public function refundEwallet()
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

        $external_id = "MrEwTst" . $time_stamp . Str::random(5);
        $original_reference_no = "TNICEEW05105202408081348437590";
        $reference_no = "refNoEw20240808134839IXL1X";
        $partner_refund_no = "refndNoEw" . $time_stamp . Str::random(5);
        
        $refundAmount = [
            "value" => "11.00",
            "currency" => "IDR"
        ]; 

        $additionalInfo = [
            "refundType" => $this->cancel_type
        ];

        $body = [
            "merchantId" => $partner_id,
            "subMerchantId" => $partner_id,
            "originalReferenceNo" => $original_reference_no,
            "originalPartnerReferenceNo" => $reference_no,
            "partnerRefundNo" => $partner_refund_no,
            "refundAmount" => $refundAmount,
            "externalStoreId" => $store_id,
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