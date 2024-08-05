<?php

namespace App\Http\Controllers\api\va;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Models\Helper\Helpers;
use Carbon\Carbon;

use Illuminate\Http\Response;

class DeleteVirtualAccountController extends Controller
{

    protected $client_id = "TNICEVA023";
    protected $domain = "https://dev.nicepay.co.id/nicepay";
    protected $end_point = "/api/v1.0/transfer-va/delete-va";
    PROTECTED $key = "-----BEGIN RSA PRIVATE KEY-----" . "\r\n" .
    "MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAInJe1G22R2fMchIE6BjtYRqyMj6lurP/zq6vy79WaiGKt0Fxs4q3Ab4ifmOXd97ynS5f0JRfIqakXDcV/e2rx9bFdsS2HORY7o5At7D5E3tkyNM9smI/7dk8d3O0fyeZyrmPMySghzgkR3oMEDW1TCD5q63Hh/oq0LKZ/4Jjcb9AgMBAAECgYA4Boz2NPsjaE+9uFECrohoR2NNFVe4Msr8/mIuoSWLuMJFDMxBmHvO+dBggNr6vEMeIy7zsF6LnT32PiImv0mFRY5fRD5iLAAlIdh8ux9NXDIHgyera/PW4nyMaz2uC67MRm7uhCTKfDAJK7LXqrNVDlIBFdweH5uzmrPBn77foQJBAMPCnCzR9vIfqbk7gQaA0hVnXL3qBQPMmHaeIk0BMAfXTVq37PUfryo+80XXgEP1mN/e7f10GDUPFiVw6Wfwz38CQQC0L+xoxraftGnwFcVN1cK/MwqGS+DYNXnddo7Hu3+RShUjCz5E5NzVWH5yHu0E0Zt3sdYD2t7u7HSr9wn96OeDAkEApzB6eb0JD1kDd3PeilNTGXyhtIE9rzT5sbT0zpeJEelL44LaGa/pxkblNm0K2v/ShMC8uY6Bbi9oVqnMbj04uQJAJDIgTmfkla5bPZRR/zG6nkf1jEa/0w7i/R7szaiXlqsIFfMTPimvRtgxBmG6ASbOETxTHpEgCWTMhyLoCe54WwJATmPDSXk4APUQNvX5rr5OSfGWEOo67cKBvp5Wst+tpvc6AbIJeiRFlKF4fXYTb6HtiuulgwQNePuvlzlt2Q8hqQ==" . // string private key
    "\r\n" .
    "-----END RSA PRIVATE KEY-----";
    
    PROTECTED $client_secret = "1af9014925cab04606b2e77a7536cb0d5c51353924a966e503953e010234108a"; // string CLIENT SECRET
    PROTECTED $access_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJUTklDRVZBMDIzIiwiaXNzIjoiTklDRVBBWSIsIm5hbWUiOiJCTklOIiwiZXhwIjoiMjAyNC0wOC0wNVQwMToyODoyMVoifQ==.S3Pr2LsPU-eGFvKo2ZxiHKfO2ka9zYRxrHY8ulxi8sM=";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * delete virtual account
     * 
     * @return json
     */

     public function deleteVirtualAccount()
     {

        $helper = new Helpers();
        $http_method = "DELETE";
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
            "totalAmount" => $totalAmount,
            "tXidVA" => "TNICEVA02302202408021409400767",
            "cancelMessage" => "Cancel Virtual Account"            
        ];
        
        $body = [
            "partnerServiceId" => "1234567",
            "customerNo" => "",
            "virtualAccountNo" => "9912304000008867",
            "trxId" => "trxIdVa20240802140941",
            "additionalInfo" => $additionalInfo,
        ];

        $bodyModel = [
            "partnerServiceId" => "",
            "customerNo" => "",
            "virtualAccountNo" => "9912304000008867",
            "trxId" => "trxIdVa20240802140941",
            "additionalInfo" => $additionalInfo,
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
        $response = Http::withHeaders($header)->delete($this->domain . $this->end_point, $bodyModel);

        dd($header, $bodyModel, $response->json());

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
        'data' => $response->json()
    ]);

     }

}

?>