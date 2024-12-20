<?php

namespace App\Http\Controllers\api\vaDirect;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Models\Helper\Helpers;
use App\Models\va\RequestVA;
use Carbon\Carbon;


class CancelVirtualAccountDirectController extends Controller
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
     * cancel virtual account direct
     * 
     * @return json
     */

    public function cancelVirtualAccountStatusDirect()
    {

        $apiUrl = 'https://dev.nicepay.co.id/nicepay/direct/v2/cancel';
        $ch = curl_init($apiUrl);
        $date = Carbon::now();
        $timeStamp = date('Ymd').date('His');
        $merchantKey = $this->merchantKey;

        
        $jsonData = array(
            'timeStamp' => $timeStamp,
            'iMid' => $this->iMid,
            'tXid' => 'TNICEVA02302202412191524448270',
            'payMethod' => "02",
            'merchantToken' => hash('sha256', $timeStamp.$this->iMid.'TNICEVA02302202412191524448270'.$this->amt.$merchantKey),
            'amt' => $this->amt,
            'cancelType' => "1",
            'cancelMsg' => "Cancel Transaction",
            'cancelUserId' => "",
            'cancelUserIp' => "127.0.0.1",
            'cancelServerIp' => "127.0.0.1",
            'cancelUserInfo' => "",
            'cancelRetryCnt' => "",
            'worker' => ""
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