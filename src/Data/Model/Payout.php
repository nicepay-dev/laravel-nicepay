<?php

namespace Nicepay\LaravelSnap\Data\Model;

class Payout
{

    private $merchantId;
    private $beneficiaryAccountNo;
    private $beneficiaryName;
    private $beneficiaryPhone;
    private $beneficiaryCustomerResidence;
    private $beneficiaryCustomerType;
    private $beneficiaryPostalCode;
    private $payoutMethod;
    private $beneficiaryBankCode;
    private array $amount;
    private $partnerReferenceNo;
    private $description;
    private $deliveryName;
    private $deliveryId;
    private $reservedDt;
    private $reservedTm;

    private $originalReferenceNo;

    private $originalPartnerReferenceNo;

    private $accountNo;
    private $additionalInfo;

    // CONSTRUCT 

    public function __construct(PayoutBuilder $builder)
    {

        $this->merchantId = $builder->getMerchantId();
        $this->beneficiaryAccountNo = $builder->getBeneficiaryAccountNo();
        $this->beneficiaryName = $builder->getBeneficiaryName();
        $this->beneficiaryPhone = $builder->getBeneficiaryPhone();
        $this->beneficiaryCustomerResidence = $builder->getBeneficiaryCustomerResidence();
        $this->beneficiaryCustomerType = $builder->getBeneficiaryCustomerType();
        $this->beneficiaryPostalCode = $builder->getBeneficiaryPostalCode();
        $this->payoutMethod = $builder->getPayoutMethod();
        $this->beneficiaryBankCode = $builder->getBeneficiaryBankCode();
        $this->amount = $builder->getAmount();
        $this->partnerReferenceNo = $builder->getPartnerReferenceNo();
        $this->description = $builder->getDescription();
        $this->deliveryName = $builder->getDeliveryName();
        $this->deliveryId = $builder->getDeliveryId();
        $this->reservedDt = $builder->getReservedDt();
        $this->reservedTm = $builder->getReservedTm();

        $this->originalReferenceNo = $builder->getOriginalReferenceNo();
        $this->originalPartnerReferenceNo = $builder->getOriginalPartnerReferenceNo();
        $this->accountNo = $builder->getAccountNo();
        $this->additionalInfo = $builder->getAdditionalInfo();
    }

    //  builder 

    public static function builder(): PayoutBuilder
    {
        return new PayoutBuilder();
    }

    // TO ARRAY

    public function toArray()
    {
        return [
            "merchantId" => $this->merchantId ?? null,
            "beneficiaryAccountNo" => $this->beneficiaryAccountNo ?? null,
            "beneficiaryName" => $this->beneficiaryName ?? null,
            "beneficiaryPhone" => $this->beneficiaryPhone ?? null,
            "beneficiaryCustomerResidence" => $this->beneficiaryCustomerResidence ?? null,
            "beneficiaryCustomerType" => $this->beneficiaryCustomerType ?? null,
            "beneficiaryPostalCode" => $this->beneficiaryPostalCode ?? null,
            "payoutMethod" => $this->payoutMethod ?? null,
            "beneficiaryBankCode" => $this->beneficiaryBankCode ?? null,
            "amount" => $this->amount ?? [],
            "partnerReferenceNo" => $this->partnerReferenceNo ?? null,
            "description" => $this->description ?? null,
            "deliveryName" => $this->deliveryName ?? null,
            "deliveryId" => $this->deliveryId ?? null,
            "reservedDt" => $this->reservedDt ?? null,
            "reservedTm" => $this->reservedTm ?? null,
            "originalReferenceNo" => $this->originalReferenceNo ?? null,
            "originalPartnerReferenceNo" => $this->originalPartnerReferenceNo ?? null,
            "accountNo" => $this->accountNo ?? null,
            "additionalInfo" => $this->additionalInfo ?? null,
        ];
    }


    // GETTER

    public function getMerchantId()
    {
        return $this->merchantId;
    }

    public function getBeneficiaryAccountNo()
    {
        return $this->beneficiaryAccountNo;
    }

    public function getBeneficiaryName()
    {
        return $this->beneficiaryName;
    }

    public function getBeneficiaryPhone()
    {
        return $this->beneficiaryPhone;
    }

    public function getBeneficiaryCustomerResidence()
    {
        return $this->beneficiaryCustomerResidence;
    }

    public function getBeneficiaryCustomerType()
    {
        return $this->beneficiaryCustomerType;
    }

    public function getBeneficiaryPostalCode()
    {
        return $this->beneficiaryPostalCode;
    }

    public function getPayoutMethod()
    {
        return $this->payoutMethod;
    }

    public function getBeneficiaryBankCode()
    {
        return $this->beneficiaryBankCode;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getPartnerReferenceNo()
    {
        return $this->partnerReferenceNo;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDeliveryName()
    {
        return $this->deliveryName;
    }

    public function getDeliveryId()
    {
        return $this->deliveryId;
    }

    public function getReservedDt()
    {
        return $this->reservedDt;
    }

    public function getReservedTm()
    {
        return $this->reservedTm;
    }

    public function getOriginalReferenceNo()
    {
        return $this->originalReferenceNo;
    }

    public function getOriginalPartnerReferenceNo()
    {
        return $this->originalPartnerReferenceNo;
    }

    public function getAccountNo()
    {
        return $this->accountNo;
    }

    public function getAdditionalInfo()
    {
        return $this->additionalInfo;
    }
}

class PayoutBuilder
{

    private $merchantId;
    private $beneficiaryAccountNo;
    private $beneficiaryName;
    private $beneficiaryPhone;
    private $beneficiaryCustomerResidence;
    private $beneficiaryCustomerType;
    private $beneficiaryPostalCode;
    private $payoutMethod;
    private $beneficiaryBankCode;
    private array $amount = [];
    private $partnerReferenceNo;
    private $description;
    private $deliveryName;
    private $deliveryId;
    private $reservedDt;
    private $reservedTm;

    private $originalReferenceNo;

    private $originalPartnerReferenceNo;

    private $accountNo;

    private $additionalInfo;


    // BUILD 


    public function build(): Payout
    {
        return new Payout($this);
    }

    // GETTER

    public function getMerchantId()
    {
        return $this->merchantId;
    }

    public function getBeneficiaryAccountNo()
    {
        return $this->beneficiaryAccountNo;
    }

    public function getBeneficiaryName()
    {
        return $this->beneficiaryName;
    }

    public function getBeneficiaryPhone()
    {
        return $this->beneficiaryPhone;
    }

    public function getBeneficiaryCustomerResidence()
    {
        return $this->beneficiaryCustomerResidence;
    }

    public function getBeneficiaryCustomerType()
    {
        return $this->beneficiaryCustomerType;
    }

    public function getBeneficiaryPostalCode()
    {
        return $this->beneficiaryPostalCode;
    }

    public function getPayoutMethod()
    {
        return $this->payoutMethod;
    }

    public function getBeneficiaryBankCode()
    {
        return $this->beneficiaryBankCode;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getPartnerReferenceNo()
    {
        return $this->partnerReferenceNo;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDeliveryName()
    {
        return $this->deliveryName;
    }

    public function getDeliveryId()
    {
        return $this->deliveryId;
    }

    public function getReservedDt()
    {
        return $this->reservedDt;
    }

    public function getReservedTm()
    {
        return $this->reservedTm;
    }

    public function getOriginalReferenceNo()
    {
        return $this->originalReferenceNo;
    }

    public function getOriginalPartnerReferenceNo()
    {
        return $this->originalPartnerReferenceNo;
    }

    public function getAccountNo()
    {
        return $this->accountNo;
    }

    public function getAdditionalInfo()
    {
        return $this->additionalInfo;
    }


    //  SETTER

    public function merchantId($merchantId): PayoutBuilder
    {
        $this->merchantId = $merchantId;
        return $this;
    }

    public function beneficiaryAccountNo($beneficiaryAccountNo): PayoutBuilder
    {
        $this->beneficiaryAccountNo = $beneficiaryAccountNo;
        return $this;
    }

    public function beneficiaryName($beneficiaryName): PayoutBuilder
    {
        $this->beneficiaryName = $beneficiaryName;
        return $this;
    }

    public function beneficiaryPhone($beneficiaryPhone): PayoutBuilder
    {
        $this->beneficiaryPhone = $beneficiaryPhone;
        return $this;
    }

    public function beneficiaryCustomerResidence($beneficiaryCustomerResidence): PayoutBuilder
    {
        $this->beneficiaryCustomerResidence = $beneficiaryCustomerResidence;
        return $this;
    }

    public function beneficiaryCustomerType($beneficiaryCustomerType): PayoutBuilder
    {
        $this->beneficiaryCustomerType = $beneficiaryCustomerType;
        return $this;
    }

    public function beneficiaryPostalCode($beneficiaryPostalCode): PayoutBuilder
    {
        $this->beneficiaryPostalCode = $beneficiaryPostalCode;
        return $this;
    }

    public function payoutMethod($payoutMethod): PayoutBuilder
    {
        $this->payoutMethod = $payoutMethod;
        return $this;
    }

    public function beneficiaryBankCode($beneficiaryBankCode): PayoutBuilder
    {
        $this->beneficiaryBankCode = $beneficiaryBankCode;
        return $this;
    }

    public function amount($value, $currency): PayoutBuilder
    {
        $this->amount = [
            "value" => $value,
            "currency" => $currency,
        ];
        return $this;
    }

    public function partnerReferenceNo($partnerReferenceNo)
    {
        $this->partnerReferenceNo = $partnerReferenceNo;
        return $this;
    }

    public function description($description)
    {
        $this->description = $description;
        return $this;
    }

    public function deliveryName($deliveryName): self
    {
        $this->deliveryName = $deliveryName;
        return $this;
    }

    public function deliveryId($deliveryId): self
    {
        $this->deliveryId = $deliveryId;
        return $this;
    }

    public function reservedDt($reservedDt): self
    {
        $this->reservedDt = $reservedDt;
        return $this;
    }

    public function reservedTm($reservedTm): self
    {
        $this->reservedTm = $reservedTm;
        return $this;
    }

    public function originalReferenceNo($originalReferenceNo): self
    {

        $this->originalReferenceNo = $originalReferenceNo;
        return $this;
    }

    public function originalPartnerReferenceNo($originalPartnerReferenceNo): self
    {
        $this->originalPartnerReferenceNo = $originalPartnerReferenceNo;
        return $this;
    }

    public function accountNo($accountNo)
    {
        $this->accountNo = $accountNo;
        return $this;
    }

    public function additionalInfo($additionalInfo)
    {
        $this->additionalInfo = $additionalInfo;
        return $this;
    }
}