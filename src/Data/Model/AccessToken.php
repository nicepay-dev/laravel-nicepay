<?php

namespace Nicepay\LaravelSnap\Data\Model;


class AccessToken
{
    private $grantType;
    private $additionalInfo;

    public function __construct(AccessTokenBuilder $builder)
    {
        $this->grantType = $builder->getGrantType();
        $this->additionalInfo = $builder->getAdditionalInfo();
    }

    // Getter
    public function getGrantType()
    {
        return $this->grantType;
    }
    public function getAdditionalInfo()
    {
        return $this->additionalInfo;
    }

    // Setter
    public function setGrantType(string $grantType): void
    {
        $this->grantType = $grantType;
    }


    public function setAdditionalInfo(array $additionalInfo): void
    {
        $this->additionalInfo = $additionalInfo;
    }

    public static function builder(): AccessTokenBuilder
    {
        return new AccessTokenBuilder();
    }

    public function toArray(): array
    {
        return [
            'grantType' => $this->grantType,
            'additionalInfo' => $this->additionalInfo,
        ];
    }
}

class AccessTokenBuilder
{
    private $grantType;
    private $additionalInfo = [];

    // Setter
    public function setGrantType(string $grantType): AccessTokenBuilder
    {
        $this->grantType = $grantType;
        return $this;
    }

    public function setAdditionalInfo(array $additionalInfo): AccessTokenBuilder
    {
        $this->additionalInfo = $additionalInfo;
        return $this;
    }

    // Getter
    public function getGrantType(): string
    {
        return $this->grantType;
    }

    public function getAdditionalInfo(): array
    {
        return $this->additionalInfo;
    }

    public function build(): AccessToken
    {
        return new AccessToken($this);
    }
}

?>