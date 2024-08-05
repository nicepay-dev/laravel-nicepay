<?php

namespace App\Http\Controllers\api\ewallet;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Models\Helper\Helpers;
use Carbon\Carbon;

class GenerateEwalletController extends Controller
{
    protected $partner_id = "IONPAYTEST";
    protected $domain = "https://dev.nicepay.co.id/nicepay";
    protected $end_point_generate = "/api/v1.0/debit/payment-host-to-host";
    protected $end_point_inquiry = "/api/v1.0/debit/status";
    protected $end_point_refund = "/api/v1.0/debit/refund";
    PROTECTED $key = "-----BEGIN RSA PRIVATE KEY-----" . "\r\n" .
    "" . // string private key
    "\r\n" .
    "-----END RSA PRIVATE KEY-----";
    PROTECTED $client_secret = ""; // string client secret
    PROTECTED $access_token = ""; // string access token
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
     * generate transaction using ewallet
     * 
     * @return json
     */
    public function generateEwallet()
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

        $external_id = "MrEwTst" . $time_stamp . Str::random(5);
        $reference_no = "refNoEw" . $time_stamp . Str::random(5);

        
        $items = array();
        
        $itemA = [
            "img_url" => "https://d3nevzfk7ii3be.cloudfront.net/igi/vOrGHXlovukA566A.medium",
            "goods_name" => "Nokia 3360",
            "goods_detail" => "Old Nokia 3360",
            "goods_amt" => "10.00",
            "goods_quantity" => "1"
        ];
        array_push($items, $itemA);
        $itemB = [
            "img_url" => "https://d3nevzfk7ii3be.cloudfront.net/igi/vOrGHXlovukA566A.medium",
            "goods_name" => "Nokia 3360",
            "goods_detail" => "Old Nokia 3360",
            "goods_amt" => "1.00",
            "goods_quantity" => "1"
        ];
        array_push($items, $itemB);
        $countAmt = 0;
        $countItm = 0;
        foreach ($items as $itm) {
            $amt = $itm["goods_amt"];
            str_replace(".00", "", $amt);

            $countAmt += (int) $itm["goods_quantity"] * (int) $amt;
            $countItm++;
        }
        
        $cartData = [
            "count" => "$countItm",
            "item" => $items
        ];
        
        $totalAmount = [
            "value" => $countAmt . ".00",
            "currency" => "IDR"
        ]; 
            
        $additionalInfo = [
            "mitraCd" => "OVOE",
            "goodsNm" => "Merchant Goods 1",
            "billingNm" => "SNAP Ewallet",
            "billingPhone" => "08123456789",
            "dbProcessUrl" => "https://ptsv2.com/t/jhon/post",
            "callBackUrl"=> "https://ptsv2.com/t/jhon/post",
            "cartData" => json_encode($cartData)
        ];

        $urlParam = array();
        $paramNotify = [
            "url" => "https://ptsv2.com/t/jhon/post",
            "type" => "PAY_NOTIFY",
            "isDeeplink" => "Y"
        ];
        array_push($urlParam, $paramNotify);
        $paramReturn = [
            "url" => "https://ptsv2.com/t/jhon/post",
            "type" => "PAY_RETURN",
            "isDeeplink" => "Y"
        ];
        array_push($urlParam, $paramReturn);

        $body = [
            "partnerReferenceNo" => $reference_no,
            "merchantId" => $partner_id,
            "subMerchantId" => $partner_id,
            "amount" => $totalAmount,
            "urlParam"=> $urlParam,
            "externalStoreId" => $store_id,
            "validUpTo" => $validity_period,
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
        
        print_r(json_encode($header));
        print_r("\r\n");
        print_r(json_encode($body));
        print_r("\r\n");

        try {
            $response = Http::withHeaders($header)->post($this->domain . $this->end_point_generate, $body);

            
            $obj_response = $response->object();
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
     * inquiry transaction ewallet
     * check transaction status
     * 
     * @return json
     */
    public function inquiryEwallet()
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
        $original_reference_no = "originalReferenceNo";
        $reference_no = "originalPartnerReferenceNo";
        
        $amount = [
            "value" => "11.00",
            "currency" => "IDR"
        ];
        $additionalInfo = new \stdClass();

        $body = [
            "merchantId" => $partner_id,
            "subMerchantId" => $partner_id,
            "originalPartnerReferenceNo" => $reference_no,
            "originalReferenceNo" => $original_reference_no,
            "serviceCode" => "54",
            "transactionDate" => $x_time_stamp,
            "externalStoreId" => $store_id,
            "amount" => $amount,
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
        $original_reference_no = "originalReferenceNo";
        $reference_no = "originalPartnerReferenceNo";
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
