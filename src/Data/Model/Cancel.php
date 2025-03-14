<?php

namespace Nicepay\LaravelSnap\Data\Model;

class Cancel
{

    //    VA
    private $partnerServiceId;
    private $customerNo;
    private $virtualAccountNo;
    private $trxId;
    private $additionalInfoMap;

    // V2 VA
    private $timeStamp;
    private $tXid;
    private $iMid;
    private $payMethod;
    private $cancelType;
    private $amt;
    private $merchantToken;
    private $referenceNo;

    //    V2
    private $cancelMsg;
    private $cancelServerIp;
    private $cancelUserId;
    private $cancelUserIp;
    private $cancelUserInfo;
    private $cancelRetryCnt;
    private $worker;

    //    E-Wallet
    private $merchantId;
    private $subMerchantId;
    private $originalPartnerReferenceNo;
    private $originalReferenceNo;
    private $serviceCode;
    private $transactionDate;
    private $externalStoreId;
    private array $refundAmount;

    //refund
    private $partnerRefundNo;
    private $reason;

    private array $totalAmount;
    private array $additionalInfo;

    // Constructor 

    function __construct(CancelBuilder $builder)
    {
        // VA
        $this->partnerServiceId = $builder->getPartnerServiceId();
        $this->customerNo = $builder->getCustomerNo();
        $this->virtualAccountNo = $builder->getVirtualAccountNo();
        $this->trxId = $builder->getTrxId();
        $this->additionalInfoMap = $builder->getAdditionalInfoMap();

        // V2 VA
        $this->timeStamp = $builder->getTimeStamp();
        $this->tXid = $builder->getTXid();
        $this->iMid = $builder->getIMid();
        $this->payMethod = $builder->getPayMethod();
        $this->cancelType = $builder->getCancelType();
        $this->amt = $builder->getAmt();
        $this->merchantToken = $builder->getMerchantToken();
        $this->referenceNo = $builder->getReferenceNo();

        // V2
        $this->cancelMsg = $builder->getCancelMsg();
        $this->cancelServerIp = $builder->getCancelServerIp();
        $this->cancelUserId = $builder->getCancelUserId();
        $this->cancelUserIp = $builder->getCancelUserIp();
        $this->cancelUserInfo = $builder->getCancelUserInfo();
        $this->cancelRetryCnt = $builder->getCancelRetryCnt();
        $this->worker = $builder->getWorker();

        // E-Wallet
        $this->merchantId = $builder->getMerchantId();
        $this->subMerchantId = $builder->getSubMerchantId();
        $this->originalPartnerReferenceNo = $builder->getOriginalPartnerReferenceNo();
        $this->originalReferenceNo = $builder->getOriginalReferenceNo();
        $this->serviceCode = $builder->getServiceCode();
        $this->transactionDate = $builder->getTransactionDate();
        $this->externalStoreId = $builder->getExternalStoreId();
        $this->refundAmount = $builder->getRefundAmount();

        // Refund
        $this->partnerRefundNo = $builder->getPartnerRefundNo();
        $this->reason = $builder->getReason();

        $this->totalAmount = $builder->getTotalAmount();
        $this->additionalInfo = $builder->getAdditionalInfo();
    }

    // To Array


    public function toArray(): array
    {
        return [
            'partnerServiceId' => $this->partnerServiceId,
            'customerNo' => $this->customerNo,
            'virtualAccountNo' => $this->virtualAccountNo,
            'trxId' => $this->trxId,
            'additionalInfo' => $this->additionalInfo,
            'merchantId' => $this->merchantId,
            'subMerchantId' => $this->subMerchantId,
            'originalPartnerReferenceNo' => $this->originalPartnerReferenceNo,
            'originalReferenceNo' => $this->originalReferenceNo,
            'serviceCode' => $this->serviceCode,
            'transactionDate' => $this->transactionDate,
            'externalStoreId' => $this->externalStoreId,
            'refundAmount' => $this->refundAmount,
            'partnerRefundNo' => $this->partnerRefundNo,
            'reason' => $this->reason,
            'totalAmount' =>  empty($this->totalAmount) ? (object) [] : $this->totalAmount,
        ];
    }

    public function toArrayV2(): array
    {
        return [
            'timeStamp' => $this->timeStamp,
            'tXid' => $this->tXid,
            'referenceNo' => $this->referenceNo,
            'merchantToken' => $this->merchantToken,
            'payMethod' => $this->payMethod,
            'cancelType' => $this->cancelType,
            'amt' => $this->amt,
            'iMid' => $this->iMid,
        ];
    }

    // Builder
    public static function builder(): CancelBuilder
    {
        return new CancelBuilder();
    }

    // Getter
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

    public function getTrxId()
    {
        return $this->trxId;
    }

    public function getAdditionalInfoMap()
    {
        return $this->additionalInfoMap;
    }

    // V2 VA
    public function getTimeStamp()
    {
        return $this->timeStamp;
    }

    public function getTXid()
    {
        return $this->tXid;
    }

    public function getIMid()
    {
        return $this->iMid;
    }

    public function getPayMethod()
    {
        return $this->payMethod;
    }

    public function getCancelType()
    {
        return $this->cancelType;
    }

    public function getAmt()
    {
        return $this->amt;
    }

    public function getMerchantToken()
    {
        return $this->merchantToken;
    }

    public function getReferenceNo()
    {
        return $this->referenceNo;
    }

    // V2
    public function getCancelMsg()
    {
        return $this->cancelMsg;
    }

    public function getCancelServerIp()
    {
        return $this->cancelServerIp;
    }

    public function getCancelUserId()
    {
        return $this->cancelUserId;
    }

    public function getCancelUserIp()
    {
        return $this->cancelUserIp;
    }

    public function getCancelUserInfo()
    {
        return $this->cancelUserInfo;
    }

    public function getCancelRetryCnt()
    {
        return $this->cancelRetryCnt;
    }

    public function getWorker()
    {
        return $this->worker;
    }

    // E-Wallet
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

    public function getRefundAmount(): array
    {
        return $this->refundAmount;
    }

    // Refund
    public function getPartnerRefundNo()
    {
        return $this->partnerRefundNo;
    }

    public function getReason()
    {
        return $this->reason;
    }

    // Totals
    public function getTotalAmount(): array
    {
        return $this->totalAmount;
    }

    public function getAdditionalInfo(): array
    {
        return $this->additionalInfo;
    }

    // SETTER 

    public function setMerchantToken($merchantToken)
    {
        $this->merchantToken = $merchantToken;
    }
}


class CancelBuilder
{


    //    VA
    private $partnerServiceId;
    private $customerNo;
    private $virtualAccountNo;
    private $trxId;
    private $additionalInfoMap;

    // V2 VA
    private $timeStamp;
    private $tXid;
    private $iMid;
    private $payMethod;
    private $cancelType;
    private $amt;
    private $merchantToken;
    private $referenceNo;

    //    V2
    private $cancelMsg;
    private $cancelServerIp;
    private $cancelUserId;
    private $cancelUserIp;
    private $cancelUserInfo;
    private $cancelRetryCnt;
    private $worker;

    //    E-Wallet
    private $merchantId;
    private $subMerchantId;
    private $originalPartnerReferenceNo;
    private $originalReferenceNo;
    private $serviceCode;
    private $transactionDate;
    private $externalStoreId;
    private array $refundAmount = [];

    //refund
    private $partnerRefundNo;
    private $reason;

    private array $totalAmount = [];
    private array $additionalInfo = [];



    // Getter
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

    public function getTrxId()
    {
        return $this->trxId;
    }

    public function getAdditionalInfoMap()
    {
        return $this->additionalInfoMap;
    }

    // V2 VA
    public function getTimeStamp()
    {
        return $this->timeStamp;
    }

    public function getTXid()
    {
        return $this->tXid;
    }

    public function getIMid()
    {
        return $this->iMid;
    }

    public function getPayMethod()
    {
        return $this->payMethod;
    }

    public function getCancelType()
    {
        return $this->cancelType;
    }

    public function getAmt()
    {
        return $this->amt;
    }

    public function getMerchantToken()
    {
        return $this->merchantToken;
    }

    public function getReferenceNo()
    {
        return $this->referenceNo;
    }

    // V2
    public function getCancelMsg()
    {
        return $this->cancelMsg;
    }

    public function getCancelServerIp()
    {
        return $this->cancelServerIp;
    }

    public function getCancelUserId()
    {
        return $this->cancelUserId;
    }

    public function getCancelUserIp()
    {
        return $this->cancelUserIp;
    }

    public function getCancelUserInfo()
    {
        return $this->cancelUserInfo;
    }

    public function getCancelRetryCnt()
    {
        return $this->cancelRetryCnt;
    }

    public function getWorker()
    {
        return $this->worker;
    }

    // E-Wallet
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

    public function getRefundAmount(): array
    {
        return $this->refundAmount;
    }

    // Refund
    public function getPartnerRefundNo()
    {
        return $this->partnerRefundNo;
    }

    public function getReason()
    {
        return $this->reason;
    }

    // Totals
    public function getTotalAmount(): array
    {
        return $this->totalAmount;
    }

    public function getAdditionalInfo(): array
    {
        return $this->additionalInfo;
    }

    // Setter 
    public function setPartnerServiceId($partnerServiceId): CancelBuilder
    {
        $this->partnerServiceId = $partnerServiceId;
        return $this;
    }

    public function setCustomerNo($customerNo): CancelBuilder
    {
        $this->customerNo = $customerNo;
        return $this;
    }

    public function setVirtualAccountNo($virtualAccountNo): CancelBuilder
    {
        $this->virtualAccountNo = $virtualAccountNo;
        return $this;
    }

    public function setTrxId($trxId): CancelBuilder
    {
        $this->trxId = $trxId;
        return $this;
    }

    public function setAdditionalInfoMap($additionalInfoMap): CancelBuilder
    {
        $this->additionalInfoMap = $additionalInfoMap;
        return $this;
    }

    // V2 VA
    public function setTimeStamp($timeStamp): CancelBuilder
    {
        $this->timeStamp = $timeStamp;
        return $this;
    }

    public function setTXid($tXid): CancelBuilder
    {
        $this->tXid = $tXid;
        return $this;
    }

    public function setIMid($iMid): CancelBuilder
    {
        $this->iMid = $iMid;
        return $this;
    }

    public function setPayMethod($payMethod): CancelBuilder
    {
        $this->payMethod = $payMethod;
        return $this;
    }

    public function setCancelType($cancelType): CancelBuilder
    {
        $this->cancelType = $cancelType;
        return $this;
    }

    public function setAmt($amt): CancelBuilder
    {
        $this->amt = $amt;
        return $this;
    }

    public function setMerchantToken($timeStamp, $iMid, $tXid, $amount, $merchantKey): CancelBuilder
    {
        $this->merchantToken = $timeStamp . $iMid . $tXid . $amount . $merchantKey;
        return $this;
    }

    public function setReferenceNo($referenceNo): CancelBuilder
    {
        $this->referenceNo = $referenceNo;
        return $this;
    }

    // V2
    public function setCancelMsg($cancelMsg): CancelBuilder
    {
        $this->cancelMsg = $cancelMsg;
        return $this;
    }

    public function setCancelServerIp($cancelServerIp): CancelBuilder
    {
        $this->cancelServerIp = $cancelServerIp;
        return $this;
    }

    public function setCancelUserId($cancelUserId): CancelBuilder
    {
        $this->cancelUserId = $cancelUserId;
        return $this;
    }

    public function setCancelUserIp($cancelUserIp): CancelBuilder
    {
        $this->cancelUserIp = $cancelUserIp;
        return $this;
    }

    public function setCancelUserInfo($cancelUserInfo): CancelBuilder
    {
        $this->cancelUserInfo = $cancelUserInfo;
        return $this;
    }

    public function setCancelRetryCnt($cancelRetryCnt): CancelBuilder
    {
        $this->cancelRetryCnt = $cancelRetryCnt;
        return $this;
    }

    public function setWorker($worker): CancelBuilder
    {
        $this->worker = $worker;
        return $this;
    }

    // E-Wallet
    public function setMerchantId($merchantId): CancelBuilder
    {
        $this->merchantId = $merchantId;
        return $this;
    }

    public function setSubMerchantId($subMerchantId): CancelBuilder
    {
        $this->subMerchantId = $subMerchantId;
        return $this;
    }

    public function setOriginalPartnerReferenceNo($originalPartnerReferenceNo): CancelBuilder
    {
        $this->originalPartnerReferenceNo = $originalPartnerReferenceNo;
        return $this;
    }

    public function setOriginalReferenceNo($originalReferenceNo): CancelBuilder
    {
        $this->originalReferenceNo = $originalReferenceNo;
        return $this;
    }

    public function setServiceCode($serviceCode): CancelBuilder
    {
        $this->serviceCode = $serviceCode;
        return $this;
    }

    public function setTransactionDate($transactionDate): CancelBuilder
    {
        $this->transactionDate = $transactionDate;
        return $this;
    }

    public function setExternalStoreId($externalStoreId): CancelBuilder
    {
        $this->externalStoreId = $externalStoreId;
        return $this;
    }



    // Refund
    public function setPartnerRefundNo($partnerRefundNo): CancelBuilder
    {
        $this->partnerRefundNo = $partnerRefundNo;
        return $this;
    }

    public function setReason($reason): CancelBuilder
    {
        $this->reason = $reason;
        return $this;
    }

    public function setTotalAmount($value, $currency): CancelBuilder
    {
        $totalAmount = [
            "value" => $value,
            "currency" => $currency,
        ];
        $this->additionalInfo['totalAmount'] = $totalAmount;
        return $this;
    }

    public function settxIdVA($txIdVA): CancelBuilder
    {
        $this->additionalInfo['tXidVA'] = $txIdVA;
        return $this;
    }

    public function setCancelMessage($cancelMessage): CancelBuilder
    {
        $this->additionalInfo['cancelMessage'] = $cancelMessage;
        return $this;
    }

    public function setRefundType($refundType): CancelBuilder
    {
        $this->additionalInfo['refundType'] = $refundType;
        return $this;
    }

    public function setRefundAmount($value, $currency): CancelBuilder
    {
        $refundAmount = [
            'value' => $value,
            'currency' => $currency,
        ];
        $this->refundAmount = $refundAmount;
        return $this;
    }


    public function setAdditionalInfo(array $additionalInfo): CancelBuilder
    {
        $this->additionalInfo = $additionalInfo;
        return $this;
    }

    // Build
    public function build(): Cancel
    {
        return new Cancel($this);
    }
}