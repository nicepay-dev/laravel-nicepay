<?php

namespace App\Http\Controllers\api\qris;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Models\Helper\Helpers;
use Carbon\Carbon;

class GenerateQrisController extends Controller
{
    protected $partner_id = "IONPAYTEST";
    protected $domain = "https://dev.nicepay.co.id/nicepay";
    protected $end_point_generate = "/api/v1.0/qr/qr-mpm-generate";
    protected $end_point_inquiry = "/api/v1.0/qr/qr-mpm-query";
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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * generate transaction qris
     * 
     * @return json
     */
    public function generateQris()
    {
        $helper = new Helpers();

        $http_method = "POST";
        $date = Carbon::now();
        $x_time_stamp = $date->toIso8601String();
        $time_stamp = $date->format("YmdHis");
        $validity_period = $date->addMinutes("5")->addSeconds("30")->toIso8601String();

        $partner_id = $this->partner_id; //merchantId
        $client_secret = $this->client_secret;
        $access_token = $this->access_token;
        $store_id = $this->store_id;
        $result = array();

        $external_id = "MrQrTst" . $time_stamp . Str::random(5);
        $reference_no = "refNoQr" . $time_stamp . Str::random(5);

        $totalAmount = [
            "value" => $this->amt,
            "currency" => "IDR"
        ];     

        $cartData = [
            "count" => "1",
            "item" => [
                "img_url" => "https://d3nevzfk7ii3be.cloudfront.net/igi/vOrGHXlovukA566A.medium",
                "goods_name" => "Nokia 3360",
                "goods_detail" => "Old Nokia 3360",
                "goods_amount" => $this->amt,
                "goods_quantity" => "1"
            ]
        ];
        
        $additionalInfo = [
            "goodsNm" => "QRIS",
            "billingNm" => "QRIS",
            "billingPhone" => "08123456789",
            "billingEmail" => "email@qris.com",
            "billingCity" => "Jakarta Selatan",
            "billingState" => "Jakarta",
            "billingPostCd" => "12870",
            "billingCountry" => "Indonesia",
            "dbProcessUrl" => "https://ptsv2.com/t/jhon/post",
            "callBackUrl"=> "https://ptsv2.com/t/jhon/post",
            "userIP" => "127.0.0.1",
            "cartData" => json_encode($cartData),
            "mitraCd" => "QSHP"
        ];

        $body = [
            "partnerReferenceNo" => $reference_no,
            "amount" => $totalAmount,
            "merchantId" => $partner_id,
            "storeId" => $store_id,
            // "validityPeriod" => "", //optional, if not used, will set default setting from nicepay 5 minutes
            "validityPeriod" => $validity_period, //optional, if not used, will set default setting from nicepay 5 
            "additionalInfo" => $additionalInfo
        ];

        $string_to_sign = $helper->generateStringToSign(
                $http_method, 
                $this->end_point_generate, 
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
            $response = Http::withHeaders($header)->post($this->domain . $this->end_point_generate, $body);

            
            $obj_response = $response->object();
            
            $result = [
                "responseCode" => $obj_response->responseCode,
                "responseMessage" => $obj_response->responseMessage,
                "referenceNo" => $obj_response->referenceNo,
                "partnerReferenceNo" => $obj_response->partnerReferenceNo,
                "validityPeriod" => $obj_response->additionalInfo->validityPeriod,
                "qrUrl" => $obj_response->qrUrl
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
            'data' => $result
        ])->setEncodingOptions(JSON_UNESCAPED_SLASHES);
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
        $original_reference_no = "originalReferenceNo";
        $reference_no = "originalPartnerReferenceNo";
        
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
        $original_reference_no = "originalReferenceNo";
        $reference_no = "originalPartnerReferenceNo";
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