<?php

namespace Nicepay\LaravelSnap\Data\Model;

class InquiryStatus
{
    // SNAP 

    // VA
    private $partnerServiceId;
    private $customerNo;
    private $virtualAccountNo;
    private $inquiryRequestId;
    private $additionalInfo; // totalAmount, tXidVA, trxId

    // EWALLET

    private $merchantId;
    private $subMerchantId;
    private $originalPartnerReferenceNo;
    private $originalReferenceNo;

    private $serviceCode;
    private $transactionDate;
    private $externalStoreId;
    private array $amount;

    // PAYOUT

    private $beneficiaryAccountNo;



    // V2
    private $iMid;
    private $timeStamp;
    private $tXid;
    private $merchantToken;
    private $referenceNo;
    private $amt;

    public function getMerchantToken()
    {
        return $this->merchantToken;
    }
    public function setMerchantToken($merchantToken)
    {
        $this->merchantToken = $merchantToken;
    }


    public function __construct(InquiryStatusBuilder $builder)
    {
        $this->partnerServiceId = $builder->getPartnerServiceId();
        $this->customerNo = $builder->getCustomerNo();
        $this->virtualAccountNo = $builder->getVirtualAccountNo();
        $this->additionalInfo = $builder->getAdditionalInfo();
        $this->inquiryRequestId = $builder->getInquiryRequestId();

        $this->timeStamp = $builder->getTimeStamp();
        $this->tXid = $builder->getTxId();
        $this->merchantToken = $builder->getMerchantToken();
        $this->referenceNo = $builder->getReferenceNo();
        $this->amt = $builder->getAmt();
        $this->iMid = $builder->getImid();

        // ewallet 
        $this->merchantId = $builder->getMerchantId();
        $this->subMerchantId = $builder->getSubMerchantId();
        $this->originalPartnerReferenceNo = $builder->getOriginalPartnerReferenceNo();
        $this->originalReferenceNo = $builder->getOriginalReferenceNo();
        $this->serviceCode = $builder->getServiceCode();
        $this->transactionDate = $builder->getTransactionDate();
        $this->externalStoreId = $builder->getExternalStoreId();
        $this->amount = $builder->getAmount();

        // PAYOUT
        $this->beneficiaryAccountNo = $builder->getBeneficiaryAccountNo();
    }

    public static function builder(): InquiryStatusBuilder
    {
        return new InquiryStatusBuilder();
    }

    public function toArray(): array
    {
        return [
            'partnerServiceId' => $this->partnerServiceId,
            'customerNo' => $this->customerNo,
            'virtualAccountNo' => $this->virtualAccountNo,
            'inquiryRequestId' => $this->inquiryRequestId,
            'additionalInfo' => empty($this->additionalInfo) ? (object) [] : $this->additionalInfo,
            'merchantId' => $this->merchantId,
            'subMerchantId' => $this->subMerchantId,
            'originalPartnerReferenceNo' => $this->originalPartnerReferenceNo,
            'originalReferenceNo' => $this->originalReferenceNo,
            'serviceCode' => $this->serviceCode,
            'transactionDate' => $this->transactionDate,
            'externalStoreId' => $this->externalStoreId,
            'amount' => $this->amount,
            'beneficiaryAccountNo' => $this->beneficiaryAccountNo,
        ];
    }

    public function toArrayV2(): array
    {
        return [
            'timeStamp' => $this->timeStamp,
            'tXid' => $this->tXid,
            'merchantToken' => $this->merchantToken,
            'referenceNo' => $this->referenceNo,
            'amt' => $this->amt,
            'iMid' => $this->iMid

        ];
    }
}

class InquiryStatusBuilder
{

    // SNAP
    private $partnerServiceId;
    private $customerNo;
    private $virtualAccountNo;
    private $inquiryRequestId;
    private $additionalInfo;

    // EWALLET
    private $merchantId;
    private $subMerchantId;
    private $originalPartnerReferenceNo;
    private $originalReferenceNo;
    private $serviceCode;
    private $transactionDate;
    private $externalStoreId;
    private array $amount = [];


    // PAYOUT

    private $beneficiaryAccountNo;

    //  V2

    private $timeStamp;
    private $txId;
    private $merchantToken;
    private $referenceNo;
    private $amt;

    private $iMid;


    // getter 

    public function getPartnerServiceId()
    {
        return $this->partnerServiceId;
    }

    public function getCustomerNo()
    {
        return $this->customerNo;
    }

    public function getVirtualAccountNo()
    {
        return $this->virtualAccountNo;
    }

    public function getInquiryRequestId()
    {
        return $this->inquiryRequestId;
    }
    public function getAdditionalInfo()
    {
        return $this->additionalInfo;
    }


    public function getTimeStamp()
    {
        return $this->timeStamp;
    }

    public function getTxId()
    {
        return $this->txId;
    }
    public function getMerchantToken()
    {
        return $this->merchantToken;
    }

    public function getReferenceNo()
    {
        return $this->referenceNo;
    }

    public function getAmt()
    {
        return $this->amt;
    }

    public function getIMid()
    {
        return $this->iMid;
    }

    public function getMerchantId()
    {
        return $this->merchantId;
    }

    public function getSubMerchantId()
    {
        return $this->subMerchantId;
    }

    public function getOriginalPartnerReferenceNo()
    {
        return $this->originalPartnerReferenceNo;
    }

    public function getOriginalReferenceNo()
    {
        return $this->originalReferenceNo;
    }

    public function getServiceCode()
    {
        return $this->serviceCode;
    }

    public function getTransactionDate()
    {
        return $this->transactionDate;
    }
    public function getExternalStoreId()
    {
        return $this->externalStoreId;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getBeneficiaryAccountNo()
    {
        return $this->beneficiaryAccountNo;
    }

    // Setter
    public function setPartnerServiceId($partnerServiceId): InquiryStatusBuilder
    {
        $this->partnerServiceId = $partnerServiceId;
        return $this;
    }

    public function setCustomerNo($customerNo): InquiryStatusBuilder
    {
        $this->customerNo = $customerNo;
        return $this;
    }

    public function setVirtualAccountNo($virtualAccountNo): InquiryStatusBuilder
    {
        $this->virtualAccountNo = $virtualAccountNo;
        return $this;
    }

    public function setInquiryRequestId($inquiryRequestId): InquiryStatusBuilder
    {
        $this->inquiryRequestId = $inquiryRequestId;
        return $this;
    }


    public function setTotalAmount($value, $currency): InquiryStatusBuilder
    {
        $this->additionalInfo["totalAmount"] = [
            "value" => $value,
            "currency" => $currency,
        ];
        return $this;
    }

    public function setTrxId($trxId): InquiryStatusBuilder
    {
        $this->additionalInfo["trxId"] = $trxId;
        return $this;
    }

    public function setTxIdVA($txIdVA): InquiryStatusBuilder
    {
        $this->additionalInfo["tXidVA"] = $txIdVA;
        return $this;
    }


    public function setTimeStamp($timeStamp): InquiryStatusBuilder
    {
        $this->timeStamp = $timeStamp;
        return $this;
    }

    public function setTxId($txId): InquiryStatusBuilder
    {
        $this->txId = $txId;
        return $this;
    }

    public function setMerchantToken($timeStamp, $iMid, $reffNo, $amount, $merchantKey): InquiryStatusBuilder
    {

        $this->merchantToken = $timeStamp . $iMid . $reffNo . $amount . $merchantKey;
        return $this;
    }

    public function setReferenceNo($reffNo): InquiryStatusBuilder
    {
        $this->referenceNo = $reffNo;
        return $this;
    }

    public function setAmt($amt): InquiryStatusBuilder
    {
        $this->amt = $amt;
        return $this;
    }

    public function setIMid($iMid): InquiryStatusBuilder
    {
        $this->iMid = $iMid;
        return $this;
    }

    public function setMerchantId($merchantId): InquiryStatusBuilder
    {
        $this->merchantId = $merchantId;
        return $this;
    }

    public function setSubMerchantId($subMerchantId)
    {
        $this->subMerchantId = $subMerchantId;
        return $this;
    }

    public function setOriginalPartnerReferenceNo($originalPartnerReferenceNo)
    {
        $this->originalPartnerReferenceNo = $originalPartnerReferenceNo;
        return $this;
    }

    public function setOriginalReferenceNo($originalReferenceNo)
    {
        $this->originalReferenceNo = $originalReferenceNo;
        return $this;
    }

    public function setServiceCode($serviceCode)
    {
        $this->serviceCode = $serviceCode;
        return $this;
    }

    public function setTransactionDate($transactionDate)
    {
        $this->transactionDate = $transactionDate;
        return $this;
    }

    public function setExternalStoreId($externalStoreId)
    {
        $this->externalStoreId = $externalStoreId;
        return $this;
    }

    public function setAmount($value, $currency)
    {
        $amount = [
            "value" => $value,
            "currency" => $currency,
        ];
        $this->amount = $amount;
        return $this;
    }

    public function setAdditionalInfo($additionalInfo): InquiryStatusBuilder
    {
        $this->additionalInfo = $additionalInfo;
        return $this;
    }

    public function setBeneficiaryAccountNo($beneficiaryAccountNo): InquiryStatusBuilder
    {
        $this->beneficiaryAccountNo = $beneficiaryAccountNo;
        return $this;
    }


    // build
    public function build(): InquiryStatus
    {
        return new InquiryStatus($this);
    }
}