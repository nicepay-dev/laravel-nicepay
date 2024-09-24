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

    protected $client_id = "";
    protected $domain = "https://dev.nicepay.co.id/nicepay";
    protected $end_point = "/api/v1.0/transfer-va/delete-va";
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
        $partner_id = ""; //String partner id / merchantId
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