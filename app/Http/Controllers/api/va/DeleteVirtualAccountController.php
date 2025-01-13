<?php

// namespace App\Http\Controllers\api\va;
namespace Nicepay\NicepayLaravel\Http\Controllers\api\va;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

// use App\Models\Helper\Helpers;
use Nicepay\NicepayLaravel\Models\Helper\Helpers;
use Carbon\Carbon;
// use App\Http\Controllers\api\accessToken\GenerateAccessTokenController;
use Nicepay\NicepayLaravel\Http\Controllers\api\accessToken\GenerateAccessTokenController;
 

class DeleteVirtualAccountController extends Controller
{

    protected $client_id;
    protected $domain = "https://dev.nicepay.co.id/nicepay";
    protected $end_point = "/api/v1.0/transfer-va/delete-va";
    PROTECTED $key;
    
    PROTECTED $client_secret;
    PROTECTED $access_token;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GenerateAccessTokenController $accessTokenController)
    {
        $this->key = env('RSA_PRIVATE_KEY');
        $this->client_id = env('CLIENT_ID');
        $this->client_secret = env('CLIENT_SECRET');
        // Automatically fetch a new access token
        $this->access_token = $accessTokenController->generateAccessToken();
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
        $partner_id = $this->client_id; //String partner id / merchantId
        $client_secret = $this->client_secret;

        $access_token = $this->access_token;

        $external_id = "MrVATst" . $time_stamp . Str::random(5);

        $totalAmount = [
            "value" => "15000.00",
            "currency" => "IDR"
        ];

        $additionalInfo = [
            "totalAmount" => $totalAmount,
            "tXidVA" => "TNICEVA02302202412021355361953",
            "cancelMessage" => "Cancel Virtual Account"            
        ];
        
        // $body = [
        //     "partnerServiceId" => "1234567",
        //     "customerNo" => "",
        //     "virtualAccountNo" => "9912304000062540",
        //     "trxId" => "trxIdVa20241118162517",
        //     "additionalInfo" => $additionalInfo,
        // ];

        $bodyModel = [
            "partnerServiceId" => "",
            "customerNo" => "",
            "virtualAccountNo" => "9912304000062666",
            "trxId" => "trxIdVa20241202135537",
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
    // print_r($body);

    try {
        $response = Http::withHeaders($header)->delete($this->domain . $this->end_point, $bodyModel);



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