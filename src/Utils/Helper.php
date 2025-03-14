<?php

namespace Nicepay\LaravelSnap\utils;

use DateTime;
use DateTimeZone;
use Exception;
use DateInterval;
use Nicepay\LaravelSnap\Common\NicepayError;

class Helper
{
    /**
     * Do sign data with privateKey
     * @param  string $privateKeyString - private key in string format.
     * @param  string $stringToSign - data that will sign with private key.
     * @return string - signature from data that sign with privateKey
     */
    // public static function getSignatureAccessToken($privateKeyString, $stringToSign)
    // {
    //     try {
    //         $privateKey = openssl_pkey_get_private($privateKeyString);
    //         dd($privateKey);
    //         if (!$privateKey) {
    //             throw new NicepayError('Invalid private key');
    //         }

    //         openssl_sign($stringToSign, $signature, $privateKey, OPENSSL_ALGO_SHA256);

    //         return base64_encode($signature);
    //     } catch (NicepayError $error) {
    //         return $error->getMessage();
    //     }
    // }

    public static function getSignatureAccessToken($privateKeyString, $stringToSign)
    {
        try {
            $privateKey = openssl_pkey_get_private($privateKeyString);
            if (!$privateKey) {
                throw new NicepayError('Invalid private key');
            }

            openssl_sign($stringToSign, $signature, $privateKey, OPENSSL_ALGO_SHA256);

            return base64_encode($signature);
        } catch (NicepayError $error) {
            return $error->getMessage();
        }
    }

    /**
     * Do encode requestbody
     * @param  $requestBody - request body that will be send or use when http request.
     * @return string - encode request body
     */
    public function getEncodePayload($requestBody)
    {
        if (!(is_string($requestBody))) {
            $requestBody = json_encode($requestBody);
        }
        return strtolower(hash('sha256', $requestBody));
    }

    /**
     * Do sign data with clientSecret
     * @param  string $stringToSign - data that will sign with client secret.
     * @param  string $clientSecret - client secret you can get from dashboard back office.
     * @return string - signature from data that sign with client secret
     */
    public function getRegistSignature($stringToSign, $clientSecret)
    {
        return base64_encode(hash_hmac('sha512', $stringToSign, $clientSecret, true));
    }

    /**
     * Do get formatted date now
     * @return string - current date formatted in yyyy-MM-ddThh:mm:ss
     */
    public static function getFormattedDate()
    {
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('Asia/Jakarta')); // Set the timezone to 'Asia/Jakarta'
        return $date->format('Y-m-d\TH:i:sP');
    }

    /**
     * Do get formatted date now
     * @return string - current date formatted in yyyyMMddHHmmss
     */
    public static function getFormattedTimestampV2()
    {
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('Asia/Jakarta')); // Set the timezone to 'Asia/Jakarta'
        return $date->format('YmdHis');
    }

    /**
     * Do get formatted date that you request
     * @param  string $timeStamp - time that want to convert to SNAP format, 20230220120000 to 2023-02-20T12:00:00+07:00.
     * @return string - formatted date
     */
    public function getConvertFormatedDate($timeStamp)
    {
        $year = substr($timeStamp, 0, 4);
        $month = substr($timeStamp, 4, 2);
        $day = substr($timeStamp, 6, 2);
        $hour = substr($timeStamp, 8, 2);
        $minute = substr($timeStamp, 10, 2);
        $second = substr($timeStamp, 12, 2);
        $offset = '+07:00';

        return "{$year}-{$month}-{$day}T{$hour}:{$minute}:{$second}{$offset}";
    }

    /**
     * Do convert private key string to private key with header
     * @param  string $key - private key in string format
     * @return string - private key with header
     */
    public static function getKey($key)
    {
        return "-----BEGIN RSA PRIVATE KEY-----" . "\r\n" .
            $key .
            "\r\n" .
            "-----END RSA PRIVATE KEY-----";
    }

    /**
     * Generate merchant token
     * @param  string $tokenString - Merchant data string to generate into merchant token
     * @return string - merchant token
     */
    public static function generateMerchantToken($tokenString)
    {
        return hash('sha256', $tokenString);
    }

    /**
     * Verify String data with RSA signature
     * @param  string $stringToSign - String data to verify
     * @param  string $publicKeyString - Public key in string format
     * @param  string $signatureString - Signature in string format
     * @return boolean - true if signature is valid, false if not
     * @throws NicepayError - throws an exception if public key is invalid
     */
    public static function verifySHA256RSA($stringToSign, $publicKeyString, $signatureString)
    {
        $isVerified = false;
        try {
            // Decode the public key and signature from base64
            $publicKey = openssl_pkey_get_public("-----BEGIN PUBLIC KEY-----\n" . wordwrap($publicKeyString, 64, "\n", true) . "\n-----END PUBLIC KEY-----");
            $signature = base64_decode($signatureString);
            $stringToSignBytes = $stringToSign;

            if (!$publicKey) {
                throw new NicepayError("Invalid public key format.");
            }

            // Verify the signature using SHA256 with RSA
            $isVerified = openssl_verify($stringToSignBytes, $signature, $publicKey, OPENSSL_ALGO_SHA256) === 1;
        } catch (Exception $e) {
            echo "Error Verifying Signature: " . $e->getMessage();
        }

        return $isVerified;
    }

    /**
     * Get a custom timestamp with the specified format and additional minutes
     * 
     * @param string $format - the required format of the timestamp
     * @param int $additionalMinutes - the additional minutes to add to the current time
     * 
     * @return string - the custom timestamp in the specified format
     */
    public static function getCustomTimeStamp($format, $additionalMinutes)
    {

        $timezone = new DateTimeZone('Asia/Jakarta');

        $date = new DateTime('now', $timezone);

        // Add additional minutes
        $date->add(new DateInterval('PT' . $additionalMinutes . 'M'));

        // Format the date in the required format
        $formattedDate = $date->format($format);
        return $formattedDate;
    }
}