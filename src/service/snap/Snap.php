<?php

namespace Nicepay\LaravelSnap\Service\Snap;

use Nicepay\LaravelSnap\common\{NICEPay, HttpRequest};
use Nicepay\LaravelSnap\data\response\NicepayResponse;
use Nicepay\LaravelSnap\data\model\AccessToken;
use Nicepay\LaravelSnap\utils\Helper;
use Nicepay\LaravelSnap\Common\NicepayError;
use Illuminate\Support\Facades\Log;

/**
 * Snap object used to do request to Nicepay SNAP API
 */
class Snap
{
    private NICEPay $apiConfig;
    private $httpClient;
    private $helper;

    public function __construct(NICEPay $config)
    {
        $this->apiConfig = $config;
        $this->httpClient = new HttpRequest();
        $this->helper = new Helper();
    }


    /**
     * Sends a request to the Nicepay SNAP API to execute a transaction.
     *
     * @param mixed $parameter The request parameters to be sent in the transaction.
     * @param string $endPoint The API endpoint for the transaction.
     * @param string $accessToken The access token required for authorization.
     * @param string $method The HTTP method to be used for the request (e.g., "POST").
     * @return NicepayResponse The response from the Nicepay API.
     */
    public function requestSnapTransaction($parameter, $endPoint, $accessToken, $method): NicepayResponse
    {

        $config = $this->apiConfig;
        $jsonData = json_encode($parameter->toArray());

        $url = $this->apiConfig->getNicepayBaseUrl() . $endPoint;
        $headers = self::getHeaders($method, null, $accessToken, $jsonData, $endPoint);


        $response = $this->httpClient->request($headers, $url, $jsonData, $method, $config->isRetryFlag(), $config->getRetryCount());
        return NicepayResponse::fromArray($response);
    }


    /**
     * Sends a request to the Nicepay SNAP API to get an access token.
     *
     * @param AccessToken $parameter The request parameters to be sent in the transaction.
     * @return NicepayResponse The response from the Nicepay API.
     */
    public function requestSnapAccessToken(AccessToken $parameter): NicepayResponse
    {

        $config = $this->apiConfig;
        $url = $config->getNicepayBaseUrl() . "v1.0/access-token/b2b";

        // Prepare headers
        $headers = self::getHeaders(null, $parameter->getGrantType(), null, null, null);
        // Make the HTTP request using HttpRequest class
        $jsonData = json_encode($parameter->toArray());

        $response = $this->httpClient->request($headers, $url, $jsonData, "POST", $config->isRetryFlag(), $config->getRetryCount());

        return NicepayResponse::fromArray($response);
    }


    public function getHeaders($httpMethod, $grantType, $accessToken, $data, $endPoint): array
    {

        $headers = [];

        $partnerID = $this->apiConfig->getPartnerId();
        $privateKey = $this->apiConfig->getPrivateKey();
        $secretKey = $this->apiConfig->getClientSecret();
        $externalId = $this->apiConfig->getExternalID();
        $timeStamp = $this->apiConfig->getTimeStamp();
        $channelId = $partnerID . "01";


        if ($grantType != null) {
            $stringToSign = $this->apiConfig->getPartnerId() . "|" . $timeStamp;
            $signature = $this->helper->getSignatureAccessToken(
                Helper::getKey($privateKey),
                $stringToSign
            );

            $headers = [
                'Content-Type: application/json',
                'X-TIMESTAMP: ' . $timeStamp,
                'X-CLIENT-KEY: ' . $this->apiConfig->getPartnerId(),
                'X-SIGNATURE: ' . $signature
            ];
        } else {

            $hexPayload = $this->helper->getEncodePayload($data);
            $stringToSign = "$httpMethod:/$endPoint:$accessToken:$hexPayload:$timeStamp";

            $signature = $this->helper->getRegistSignature(
                $stringToSign,
                $secretKey
            );

            $headers = [
                'Content-Type: application/json',
                'X-TIMESTAMP: ' . $timeStamp,
                'X-SIGNATURE: ' . $signature,
                'Authorization: Bearer ' . $accessToken,
                'X-PARTNER-ID: ' . $partnerID,
                'X-EXTERNAL-ID: ' . $externalId,
                'CHANNEL-ID: ' . $channelId
            ];
        }
        return $headers;
    }
}