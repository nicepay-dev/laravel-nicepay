<?php

namespace App\Http\Controllers\api\va;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Models\Helper\Helpers;
use App\Models\va\RequestVA;
use Carbon\Carbon;


class GenerateVirtualAccountController extends Controller
{

    protected $client_id = "";
    protected $domain = "https://dev.nicepay.co.id/nicepay";
    protected $end_point = "/api/v1.0/transfer-va/create-va";
    PROTECTED $key = "-----BEGIN RSA PRIVATE KEY-----" . "\r\n" .
    "" . // string private key
    "\r\n" .
    "-----END RSA PRIVATE KEY-----";
    
    PROTECTED $client_secret = ""; // string CLIENT SECRET
    PROTECTED $access_token = "";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * generate virtual account
     * 
     * @return json
     */
    public function generateVirtualAccount()
    {
        // TODO
        /**
         * 1. get data dari ui
         * 2. validasi data
         * 3. update request body sesuai kebutuhan & data yang didapat dari ui
         * 4. generate header, body, dll sesuai spec nicepay
         * 5. hit nicepay
         * 6. balikkan data ke UI
         * 7. di halaman UI, tampilkan response
         * 
         */

        $helper = new Helpers();
        $http_method = "POST";
        $date = Carbon::now();
        $x_time_stamp = $date->toIso8601String();
        $time_stamp = $date->format("YmdHis");
        $partner_id = "TNICEVA023";
        // $client_secret = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJJT05QQVlURVNUIiwiaXNzIjoiTklDRVBBWSIsIm5hbWUiOiJCQkJBIiwiZXhwIjoiMjAyMy0wMi0wMlQwNjoyNDozNFoifQ==.J7hVhOxwF7fQN_cxM9f9I_lOAxQ8-qq0xuExQobkLrc=";
        $client_secret = $this->client_secret;

        $access_token = $this->access_token;

        $external_id = "MrVATst" . $time_stamp . Str::random(5);

        $totalAmount = [
            "value" => "15000.00",
            "currency" => "IDR"
        ];     
        
        $additionalInfo = [
            "bankCd" => "CENA",
            "goodsNm" => "CENA",
            "dbProcessUrl" => "https://ptsv2.com/t/jhon/post",
            "vacctValidDt" => "",
            "vacctValidTm" => "",
            "msId" => "",
            "msFee" => "",
            "mbFee" => "",
            "mbFeeType" => ""
        ];

        $body = [
            "partnerServiceId" => "",
            "customerNo" => "", //for fix
            "virtualAccountNo" => "",
            "virtualAccountName" => "Testing Create Virtual Account Nicepay",
            "trxId" => "trxIdVa" . $time_stamp,
            "totalAmount" => $totalAmount,
            "additionalInfo" => $additionalInfo
        ];

        $bodyModel = [
        "partnerServiceId" => "",
        "customerNo" => "",
        "virtualAccountNo" => "",
        "virtualAccountName" => "Laravel SNAP VA",
        "trxId" => "trxIdVa" . $time_stamp,
        "totalAmount" => $totalAmount,
        "additionalInfo" => $additionalInfo
        ];

        // $encBody = json_encode($bodyModel); //minify body
        $string_to_sign = $helper->generateStringToSign(
                $http_method, 
                $this->end_point, 
                $access_token, 
                $bodyModel, 
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
                $partner_id . "02"
            );
        print_r($string_to_sign); 
        
        print_r("\r\n");
        
        print_r($header);
        print_r($body);


        try {
            $response = Http::withHeaders($header)->post($this->domain . $this->end_point, $bodyModel);

            $data = [
                "data" => $response
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
        ]);
    }
}
