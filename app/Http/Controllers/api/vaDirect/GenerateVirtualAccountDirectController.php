<?php

// namespace App\Http\Controllers\api\vaDirect;
namespace Nicepay\NicepayLaravel\Http\Controllers\api\vaDirect;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Models\Helper\Helpers;
use App\Models\va\RequestVA;
use Carbon\Carbon;


class GenerateVirtualAccountDirectController extends Controller
{

    protected $iMid;
    protected $merchantKey;
    protected $amt;
     

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->iMid = env('CLIENT_ID');
        $this->merchantKey = env('MER_KEY');
        $this->amt = '15000';
    }

    /**
     * generate virtual account direct
     * 
     * @return json
     */
    public function generateVirtualAccountDirect()
    {

        $apiUrl = 'https://dev.nicepay.co.id/nicepay/direct/v2/registration';
        $ch = curl_init($apiUrl);
        $date = Carbon::now();
        $time_stamp = $date->format("YmdHis");
        $timeStamp = date('Ymd').date('His');
        $merchantKey = $this->merchantKey;
        $generatedReferenceNo = "MrVATst" . $time_stamp . Str::random(5);

        
        $jsonData = array(
            'timeStamp' => $timeStamp,
            'iMid' =>  $this->iMid,
            'payMethod' => '02',
            'referenceNo' => $generatedReferenceNo, // Invoice Number or Reference Number Generated by merchant
            'currency' => 'IDR',
            'amt' => $this->amt, // Total Gross Amount
            'description' => 'Payment of Invoice No '.$generatedReferenceNo, // Transaction Description
            'goodsNm' => 'Test Transaction',

            'billingNm' => 'John Doe', // Customer name
            'billingPhone' => '082111111111', // Customer Phone Number
            'billingEmail' => 'john@example.com', // Customer Email
            'billingCity' => 'Jakarta Pusat',
            'billingState' => 'DKI Jakarta',
            'billingPostCd' => '10210',
            'billingCountry' => 'Indonesia',

            'deliveryNm' => 'John Doe',
            'deliveryPhone' => '02112345678',
            'deliveryAddr' => 'Jl. Jend. Sudirman No. 28',
            'deliveryCity' => 'Jakarta Pusat',
            'deliveryState' => 'DKI Jakarta',
            'deliveryPostCd' => '10210',
            'deliveryCountry' => 'Indonesia',

            'reqDt' => date('Ymd'),
            'reqTm' => date('His'),
            'bankCd' => 'CENA', // Bank Code - Virtual Account (VA)
            'vacctValidDt' => '', // Expired Date - Virtual Account (VA)
            'vacctValidTm' => '', // Expired Time - Virtual Account (VA)
            'merFixAcctId' => '',
            'dbProcessUrl' => 'https://ptsv2.com/t/jhon/post',
            'merchantToken' => hash('sha256', $timeStamp.$this->iMid.$generatedReferenceNo.$this->amt.$merchantKey)
        );

        $jsonDataEncoded = json_encode($jsonData);
        curl_setopt($ch, CURLOPT_POST, 1);
        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $curl_result = curl_exec($ch);
        $response = json_decode($curl_result);



        try {
            $data = [
                "data" => $response
            ];
        } catch (\Throwable $th) {
            throw $th;

            return response()->json([
                'status' => 500,
                'message' => "Internal Server Error",
                'data' => $th
            ]);
        }

        return response()->json([
            'data' => $data
        ]);

    }
}