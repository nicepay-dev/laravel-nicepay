# PHP - NICEPAY

NICEPAY ❤️PHP!

This is the Official PHP API client/library for NICEPAY Payment API. Visit [PHP Library](https://github.com/nicepay-dev/java-nicepay). 
More information about the product and see documentation at [NICEPAY Docs](https://docs.nicepay.co.id/) for more technical details.
This library provides access to Nicepay BI SNAP APIs.


## 1. Installation
### 1.1 Manual Install
You can clone or [download](https://github.com/nicepay-dev/nicepay-php) our source code, then import the folder manually into your project.
### 1.2 Composer Install
If you are using [Composer](https://getcomposer.org), you can install via composer CLI:
```
composer require nicepay/nicepay-php
```

## 2. Usage
### 2.1 Client Initialization and Configuration
Get your Credentials from [Nicepay Dashboard](https://bo.nicepay.co.id/)
Initialize Nicepay Config

```php
    protected $client_id = ""; 
    protected $base_url = "https://dev.nicepay.co.id/nicepay/v1.0/access-token/b2b";
    PROTECTED $key = "-----BEGIN RSA PRIVATE KEY-----" . "\r\n" .
```

### 2.2 Request for Access-Token

```php

    public function generateAccessToken()
    {
        $helper = new Helpers();
        $x_time_stamp = Carbon::now()->toIso8601String();
        $client_id = $this->client_id;

        $addInfo = new \stdClass();

        $bd = [
            "grantType" => "client_credentials",
            "additionalInfo" => json_encode($addInfo)
        ];

        $string_to_sign = $client_id . "|" . $x_time_stamp;
        print_r($string_to_sign);
        print_r("\r\n");

        $signature = $helper->generateSignature($string_to_sign, $this->key, OPENSSL_ALGO_SHA256);
        print_r($signature);
        print_r("\r\n");
        
        $header = $helper->generateHeaderAccessToken($x_time_stamp, $client_id, $signature);
        }
```

### 2.2 Request for Payment (i.e. Virtual Account)

```php

    public function generateVirtualAccount()
    {

        $helper = new Helpers();
        $http_method = "POST";
        $date = Carbon::now();
        $x_time_stamp = $date->toIso8601String();
        $time_stamp = $date->format("YmdHis");
        $partner_id = "TNICEVA023";
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


        try {
            $response = Http::withHeaders($header)->post($this->domain . $this->end_point, $bodyModel);

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
            'status' => $response->status(),
            'message' => $response->successful(),
            'data' => $data
        ]);
    }

```

## Notes
This library is meant to be implemented on your backend server using PHP.

## Get help

- [NICEPAY Docs](https://docs.nicepay.co.id/)
- [NICEPAY Dashboard ](https://bo.nicepay.co.id/)
- [SNAP documentation](https://docs.nicepay.co.id/nicepay-api-snap)
- Can't find answer you looking for? email to [cs@nicepay.co.id](mailto:cs@nicepay.co.id)