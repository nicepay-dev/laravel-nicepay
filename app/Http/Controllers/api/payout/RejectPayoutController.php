<?php
namespace App\Http\Controllers\api\payout;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Models\Helper\Helpers;
use Carbon\Carbon;

class RejectPayoutController extends Controller
{

    protected $partner_id = "IONPAYTEST";
    protected $domain = "https://dev.nicepay.co.id/nicepay";
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
    
}

?>