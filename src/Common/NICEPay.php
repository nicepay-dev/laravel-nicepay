<?php

namespace Nicepay\LaravelSnap\Common;
use Nicepay\LaravelSnap\Utils\NicepayCons;


class NICEPay
{


    private $partnerId;
    private $clientSecret;
    private bool $isProduction = false;
    private $externalID;
    private $timestamp;
    private $privateKey;
    private bool $retryFlag = true;
    private int $retryCount = 1;

    function __construct(NICEPayBuilder $builder)
    {
        $this->partnerId = $builder->getPartnerId();
        $this->clientSecret = $builder->getClientSecret();
        $this->isProduction = $builder->isProduction();
        $this->externalID = $builder->getExternalID();
        $this->timestamp = $builder->getTimestamp();
        $this->privateKey = $builder->getPrivateKey();
        $this->retryFlag = $builder->isRetryFlag();
        $this->retryCount = $builder->getRetryCount();
    }


    // Getters
    public function getPartnerId()
    {
        return $this->partnerId;
    }

    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    public function isProduction(): bool
    {
        return $this->isProduction;
    }

    public function getExternalID()
    {
        return $this->externalID;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    public function isRetryFlag(): bool
    {
        return $this->retryFlag;
    }


    public function getRetryCount(): int
    {
        return $this->retryCount;
    }

    // Get base url

    public function getNicepayBaseUrl()
    {
        if ($this->isProduction) {
            return NicepayCons::getProductionBaseUrl();
        } else {
            return  NicepayCons::getSandboxBaseUrl();
        }
    }

    // Builder Class
    public static function builder(): NICEPayBuilder
    {
        return new NICEPayBuilder();
    }
}

class NICEPayBuilder
{
    private $partnerId;
    private $clientSecret;
    private bool $isProduction = false;
    private $externalID;
    private $timestamp;
    private $privateKey;
    private $retryFlag = false;
    private int $retryCount = 1;

    // Setters
    public function setPartnerId($partnerId): NICEPayBuilder
    {
        $this->partnerId = $partnerId;
        return $this;
    }

    public function setClientSecret($clientSecret): NICEPayBuilder
    {
        $this->clientSecret = $clientSecret;
        return $this;
    }

    public function setIsProduction(bool $isProduction): NICEPayBuilder
    {
        $this->isProduction = $isProduction;
        return $this;
    }

    public function setExternalID($externalID): NICEPayBuilder
    {
        $this->externalID = $externalID;
        return $this;
    }

    public function setTimestamp($timestamp): NICEPayBuilder
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    public function setPrivateKey($privateKey): NICEPayBuilder
    {
        $this->privateKey = $privateKey;
        return $this;
    }

    public function setRetryFlag($retryFlag): NICEPayBuilder
    {
        $this->retryFlag = $retryFlag;
        return $this;
    }


    public function setRetryCount($retryCount): NICEPayBuilder
    {
        $this->retryCount = $retryCount;
        return $this;
    }

    // Getters for Builder
    public function getPartnerId()
    {
        return $this->partnerId;
    }

    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    public function isProduction(): bool
    {
        return $this->isProduction;
    }

    public function getExternalID()
    {
        return $this->externalID;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    public function isRetryFlag(): bool
    {
        return $this->retryFlag;
    }


    public function getRetryCount()
    {
        return $this->retryCount;
    }

    // Build method
    public function build(): NICEPay
    {
        return new NICEPay($this);
    }
}