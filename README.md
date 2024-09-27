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
> **WARNING:** Credentials used here are for testing purposes only.

```php
    protected $client_id = "IONPAYTEST"; 
    protected $base_url = "https://dev.nicepay.co.id/nicepay/v1.0/access-token/b2b";
    PROTECTED $key = "-----BEGIN RSA PRIVATE KEY-----" . "\r\n" ."MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAInJe1G22R2fMchIE6BjtYRqyMj6lurP/zq6vy79WaiGKt0Fxs4q3Ab4ifmOXd97ynS5f0JRfIqakXDcV/e2rx9bFdsS2HORY7o5At7D5E3tkyNM9smI/7dk8d3O0fyeZyrmPMySghzgkR3oMEDW1TCD5q63Hh/oq0LKZ/4Jjcb9AgMBAAECgYA4Boz2NPsjaE+9uFECrohoR2NNFVe4Msr8/mIuoSWLuMJFDMxBmHvO+dBggNr6vEMeIy7zsF6LnT32PiImv0mFRY5fRD5iLAAlIdh8ux9NXDIHgyera/PW4nyMaz2uC67MRm7uhCTKfDAJK7LXqrNVDlIBFdweH5uzmrPBn77foQJBAMPCnCzR9vIfqbk7gQaA0hVnXL3qBQPMmHaeIk0BMAfXTVq37PUfryo+80XXgEP1mN/e7f10GDUPFiVw6Wfwz38CQQC0L+xoxraftGnwFcVN1cK/MwqGS+DYNXnddo7Hu3+RShUjCz5E5NzVWH5yHu0E0Zt3sdYD2t7u7HSr9wn96OeDAkEApzB6eb0JD1kDd3PeilNTGXyhtIE9rzT5sbT0zpeJEelL44LaGa/pxkblNm0K2v/ShMC8uY6Bbi9oVqnMbj04uQJAJDIgTmfkla5bPZRR/zG6nkf1jEa/0w7i/R7szaiXlqsIFfMTPimvRtgxBmG6ASbOETxTHpEgCWTMhyLoCe54WwJATmPDSXk4APUQNvX5rr5OSfGWEOo67cKBvp5Wst+tpvc6AbIJeiRFlKF4fXYTb6HtiuulgwQNePuvlzlt2Q8hqQ=="."\r\n"."-----END RSA PRIVATE KEY-----"
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