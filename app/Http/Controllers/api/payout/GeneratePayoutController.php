<?php

namespace App\Http\Controllers\api\payout;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Models\Helper\Helpers;
use Carbon\Carbon;

class GeneratePayoutController extends Controller
{
    protected $partner_id = "IONPAYTEST";
    // protected $domain = "https://dev.nicepay.co.id/nicepay/";
    protected $domain = "https://dev.nicepay.co.id/nicepay";
    protected $end_point_generate = "/api/v1.0/transfer/registration";
    protected $end_point_approve = "/api/v1.0/transfer/approve";
    protected $end_point_inquiry = "/api/v1.0/transfer/inquiry";
    protected $end_point_balance_inquiry = "/api/v1.0/transfer/balance-inquiry";
    protected $end_point_cancel = "/api/v1.0/transfer/cancel";
    protected $end_point_reject = "/api/v1.0/transfer/reject";
    PROTECTED $key = "-----BEGIN RSA PRIVATE KEY-----" . "\r\n" .
    "" . // string private key
    "\r\n" .
    "-----END RSA PRIVATE KEY-----";
    PROTECTED $client_secret = ""; // string credential
    PROTECTED $access_token = ""; // String access token
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
     * generate payout
     * 
     * @return json
     */
    public function generatePayout()
    {
        $helper = new Helpers();

        $http_method = "POST";
        $date = Carbon::now();
        $x_time_stamp = $date->toIso8601String();
        $time_stamp = $date->format("YmdHis");

        $partner_id = $this->partner_id; //merchantId
        $client_secret = $this->client_secret;
        $access_token = $this->access_token;

        $external_id = "MrQrTst" . $time_stamp . Str::random(5);
        $reference_no = "refNoQr" . $time_stamp . Str::random(5);

        $totalAmount = [
            "value" => $this->amt,
            "currency" => "IDR"
        ];     

        $body = [
            "merchantId" => $partner_id,
            "msId" => "",
            "beneficiaryAccountNo" => "",
            "beneficiaryName" => "Laravel Test",
            "beneficiaryPhone" => "08123456789",
            "beneficiaryCustomerResidence" => "1",
            "beneficiaryCustomerType" => "1",
            "beneficiaryPostalCode" => "123456",
            "payoutMethod" => "2",
            "beneficiaryBankCode" => "",
            "amount" => $totalAmount,
            "partnerReferenceNo" => $reference_no,
            "reservedDt" => "20230309",
            "reservedTm" => "120000",
            "description" => "SNAP Payout from Laravel",
            "deliveryName" => "Laravel",
            "deliveryId" => "",
            "beneficiaryPOE" => "",
            "beneficiaryDOE" => "",
            "beneficiaryCoNo" => "",
            "beneficiaryAddress" => "",
            "beneficiaryAuthPhoneNumber" => "",
            "beneficiaryMerCategory" => "",
            "beneficiaryCoMgmtName" => "",
            "beneficiaryCoShName" => ""
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
            'data' => $obj_response
        ])->setEncodingOptions(JSON_UNESCAPED_SLASHES);
    }

    /**
     * approve payout transaction
     *
     * @return json
     */
    public function approvePayout()
    {
        $helper = new Helpers();

        $http_method = "POST";
        $date = Carbon::now();
        $x_time_stamp = $date->toIso8601String();
        $time_stamp = $date->format("YmdHis");

        $partner_id = $this->partner_id; //merchantId
        $client_secret = $this->client_secret;
        $access_token = $this->access_token;

        $external_id = "MrQrTst" . $time_stamp . Str::random(5);
        $reference_no = "originalPartnerReferenceNo";
        $txid = "originalReferenceNo";

        $body = [
            "originalPartnerReferenceNo" => $reference_no,
            "originalReferenceNo" => $txid,
            "merchantId" => $partner_id
        ];

        $string_to_sign = $helper->generateStringToSign(
                $http_method, 
                $this->end_point_approve, 
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
            $response = Http::withHeaders($header)->post($this->domain . $this->end_point_approve, $body);

            
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
            'data' => $obj_response
        ])->setEncodingOptions(JSON_UNESCAPED_SLASHES);
    }

    /**
     * reject payout ransaction
     *
     * @return json
     */
    public function rejectPayout()
    {
        $helper = new Helpers();

        $http_method = "POST";
        $date = Carbon::now();
        $x_time_stamp = $date->toIso8601String();
        $time_stamp = $date->format("YmdHis");

        $partner_id = $this->partner_id; //merchantId
        $client_secret = $this->client_secret;
        $access_token = $this->access_token;

        $external_id = "MrQrTst" . $time_stamp . Str::random(5);
        $reference_no = "originalPartnerReferenceNo";
        $txid = "originalReferenceNo";     

        $body = [
            "originalPartnerReferenceNo" => $reference_no,
            "originalReferenceNo" => $txid,
            "merchantId" => $partner_id
        ];

        $string_to_sign = $helper->generateStringToSign(
                $http_method, 
                $this->end_point_reject, 
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
            $response = Http::withHeaders($header)->post($this->domain . $this->end_point_reject, $body);

            
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
            'data' => $obj_response
        ])->setEncodingOptions(JSON_UNESCAPED_SLASHES);
    }

    /**
     * cancel payout transaction
     *
     * @return json
     */
    public function cancelPayout()
    {
        $helper = new Helpers();

        $http_method = "POST";
        $date = Carbon::now();
        $x_time_stamp = $date->toIso8601String();
        $time_stamp = $date->format("YmdHis");

        $partner_id = $this->partner_id; //merchantId
        $client_secret = $this->client_secret;
        $access_token = $this->access_token;

        $external_id = "MrQrTst" . $time_stamp . Str::random(5);
        $reference_no = "originalPartnerReferenceNo";
        $txid = "originalReferenceNo";

        $body = [
            "originalPartnerReferenceNo" => $reference_no,
            "originalReferenceNo" => $txid,
            "merchantId" => $partner_id
        ];

        $string_to_sign = $helper->generateStringToSign(
                $http_method, 
                $this->end_point_cancel, 
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
            $response = Http::withHeaders($header)->post($this->domain . $this->end_point_cancel, $body);

            
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
            'data' => $obj_response
        ])->setEncodingOptions(JSON_UNESCAPED_SLASHES);
    }

    /**
     * inquiry payout transaction
     * check transaction status
     * 
     * @return json
     */
    public function inquiryPayout()
    {
        $helper = new Helpers();
        $http_method = "POST";
        $date = Carbon::now();
        $x_time_stamp = $date->toIso8601String();
        $time_stamp = $date->format("YmdHis");
        $partner_id = $this->partner_id; //merchantId
        $client_secret = $this->client_secret;
        $access_token = $this->access_token;

        $external_id = "MrQrTst" . $time_stamp . Str::random(5);
        $original_reference_no = "originalReferenceNo";
        $reference_no = "originalPartnerReferenceNo";
        $beneficiaryAccountNo = "5345000060";

        $body = [
            "merchantId" => $partner_id,
            "originalReferenceNo" => $original_reference_no,
            "originalPartnerReferenceNo" => $reference_no,
            "beneficiaryAccountNo" => $beneficiaryAccountNo
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
     * inquiry balance merchant id
     * check balance
     * 
     * @return json
     */
    public function balanceInquiryPayout()
    {
        $helper = new Helpers();
        $http_method = "POST";
        $date = Carbon::now();
        $x_time_stamp = $date->toIso8601String();
        $time_stamp = $date->format("YmdHis");
        $partner_id = $this->partner_id; //merchantId
        $client_secret = $this->client_secret;
        $access_token = $this->access_token;

        $external_id = "MrQrTst" . $time_stamp . Str::random(5);

        $additionalInfo = [
            "msId" => ""
        ];

        $body = [
            "merchantId" => $partner_id,
            "additionalInfo" =>  $additionalInfo
        ];

        $string_to_sign = $helper->generateStringToSign(
                $http_method, 
                $this->end_point_balance_inquiry, 
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
            $response = Http::withHeaders($header)->post($this->domain . $this->end_point_balance_inquiry, $body);
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
