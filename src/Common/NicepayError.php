<?php

namespace Nicepay\LaravelSnap\Common;

use Exception;

class NicepayError extends Exception
{
    protected $httpStatusCode;
    protected $apiResponse;
    protected $rawHttpClientData;

    public function __construct(
        $message,
        $httpStatusCode = null,
        $apiResponse = null,
        $rawHttpClientData = null
    ) {
        parent::__construct($message);
        $this->httpStatusCode = $httpStatusCode;
        $this->apiResponse = $apiResponse;
        $this->rawHttpClientData = $rawHttpClientData;
    }

    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }

    public function getApiResponse()
    {
        return $this->apiResponse;
    }

    public function getRawHttpClientData()
    {
        return $this->rawHttpClientData;
    }
}