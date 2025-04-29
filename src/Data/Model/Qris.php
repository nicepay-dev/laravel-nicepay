<?php

namespace Nicepay\LaravelSnap\Data\Model;

class Qris
{

    private $partnerReferenceNo;
    private array $amount;
    private $merchantId;

    private $storeId;
    private $validityPeriod;
    private $additionalInfo;

    public function __construct(QrisBuilder $builder)
    {

        $this->partnerReferenceNo = $builder->getPartnerReferenceNo();
        $this->amount = $builder->getAmount();
        $this->merchantId = $builder->getMerchantId();
        $this->storeId = $builder->getStoreId();
        $this->validityPeriod = $builder->getValidityPeriod();
        $this->additionalInfo = $builder->getAdditionalInfo();
    }

    public static function builder(): QrisBuilder
    {
        return new QrisBuilder;
    }

    public function toArray(): array
    {
        return [
            "partnerReferenceNo" => $this->partnerReferenceNo,
            "merchantId" => $this->merchantId,
            "storeId" => $this->storeId,
            "validityPeriod" => $this->validityPeriod,
            "amount" => $this->amount,
            "additionalInfo" => $this->additionalInfo,
        ];
    }

    // GETTER

}

class QrisBuilder
{

    private $partnerReferenceNo;
    private array $amount;
    private $merchantId;
    private $storeId;
    private $validityPeriod;
    private $additionalInfo;

    // GETTER
    public function getPartnerReferenceNo()
    {
        return $this->partnerReferenceNo;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getMerchantId()
    {
        return $this->merchantId;
    }
    public function getStoreId()
    {
        return $this->storeId;
    }
    public function getValidityPeriod()
    {
        return $this->validityPeriod;
    }
    public function getAdditionalInfo()
    {
        return $this->additionalInfo;
    }

    // SETTER

    public function partnerReferenceNo($partnerReferenceNo): QrisBuilder
    {
        $this->partnerReferenceNo = $partnerReferenceNo;
        return $this;
    }

    public function amount($value, $currency): QrisBuilder
    {
        $this->amount = [
            "value" => $value,
            "currency" => $currency,
        ];
        return $this;
    }

    public function merchantId($merchantId): QrisBuilder
    {
        $this->merchantId = $merchantId;
        return $this;
    }

    public function storeId($storeId): QrisBuilder
    {
        $this->storeId = $storeId;
        return $this;
    }

    public function validityPeriod($validityPeriod): QrisBuilder
    {
        $this->validityPeriod = $validityPeriod;
        return $this;
    }

    public function additionalInfo(
        $goodsNm,
        $billingNm,
        $billingPhone,
        $billingEmail,
        $billingCity,
        $billingAddr,
        $billingState,
        $billingPostCd,
        $billingCountry,
        $callBackUrl,
        $dbProcessUrl,
        $userIP,
        $cartData,
        $mitraCd
    ): QrisBuilder {
        $this->additionalInfo = [
            "goodsNm" => $goodsNm,
            "billingNm" => $billingNm,
            "billingPhone" => $billingPhone,
            "billingEmail" => $billingEmail,
            "billingCity" => $billingCity,
            "billingAddr" => $billingAddr,
            "billingState" => $billingState,
            "billingPostCd" => $billingPostCd,
            "billingCountry" => $billingCountry,
            "callBackUrl" => $callBackUrl,
            "dbProcessUrl" => $dbProcessUrl,
            "userIP" => $userIP,
            "cartData" => $cartData,
            "mitraCd" => $mitraCd,
        ];
        return $this;
    }

    public function build(): Qris
    {
        return new Qris($this);
    }
}