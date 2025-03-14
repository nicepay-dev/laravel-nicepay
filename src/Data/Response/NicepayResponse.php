<?php

namespace Nicepay\LaravelSnap\Data\Response;

class NicepayResponse
{

    // Base
    private  $responseCode;
    private  $responseMessage;
    private  $accessToken;
    private  $expiresIn;
    private  $tokenType;
    private array $virtualAccountData = [];  // array/map
    private array $additionalInfo = [];      // array/map
    private array $totalAmount = [];

    // Virtual Account
    private  $partnerServiceId;
    private  $customerNo;
    private  $inquiryRequestId;
    private  $virtualAccountNo;
    private  $virtualAccountName;
    private  $trxId;
    private  $transactionStatusDesc;
    private  $latestTransactionStatus;
    private  $bankCd;
    private  $tXidVA;
    private  $goodsNm;
    private  $vacctValidTm;
    private  $vacctValidDt;

    // E-wallet

    private $partnerReferenceNo;
    private $referenceNo;
    private $webRedirectUrl;

    private $refundNo;
    // Inquiry Ewallet 

    private $originalPartnerReferenceNo;
    private $originalReferenceNo;
    private $serviceCode;
    private array $transAmount;

    // QRIS

    private $qrContent;
    private $qrUrl;
    private $refundTime;

    private $paidTime;

    // QRIS refund
    private $partnerRefundNo;
    private $refundAmount;

    // PAYOUT

    private $beneficiaryaccountNo;
    private $beneficiaryName;
    private $payoutMethod;
    private $beneficiaryBankCode;
    private array $amount;

    private $beneficiaryAccountNo;
    private $transactionStatus;

    private $accountNo;
    private array $accountInfos = [];

    private $beneficiaryCustomerResidence;

    private $beneficiaryCustomerType;

    public function __construct(NicepayResponseBuilder $builder)
    {

        $this->responseCode = $builder->getResponseCode();
        $this->responseMessage = $builder->getResponseMessage();

        $this->accessToken = $builder->getAccessToken();
        $this->expiresIn = $builder->getExpiresIn();
        $this->tokenType = $builder->getTokenType();
        $this->virtualAccountData = $builder->getVirtualAccountData();
        $this->additionalInfo = $builder->getAdditionalInfo();
        $this->totalAmount = $builder->getTotalAmount();

        // Virtual Account
        $this->partnerServiceId = $builder->getPartnerServiceId();
        $this->customerNo = $builder->getCustomerNo();
        $this->inquiryRequestId = $builder->getInquiryRequestId();
        $this->virtualAccountNo = $builder->getVirtualAccountNo();
        $this->virtualAccountName = $builder->getVirtualAccountName();
        $this->trxId = $builder->getTrxId();
        $this->transactionStatusDesc = $builder->getTransactionStatusDesc();
        $this->latestTransactionStatus = $builder->getLatestTransactionStatus();
        $this->bankCd = $builder->getBankCd();
        $this->tXidVA = $builder->getTXidVA();
        $this->goodsNm = $builder->getGoodsNm();
        $this->vacctValidTm = $builder->getVacctValidTm();
        $this->vacctValidDt = $builder->getVacctValidDt();

        // Ewallet
        $this->partnerReferenceNo = $builder->getPartnerReferenceNo();
        $this->referenceNo = $builder->getReferenceNo();
        $this->webRedirectUrl = $builder->getWebRedirectUrl();
        $this->refundNo = $builder->getRefundNo();

        // Inquiry Ewallet
        $this->originalPartnerReferenceNo = $builder->getOriginalPartnerReferenceNo();
        $this->originalReferenceNo = $builder->getOriginalReferenceNo();
        $this->serviceCode = $builder->getServiceCode();
        $this->transAmount = $builder->getTransAmount();

        // Qris
        $this->qrContent = $builder->getQrContent();
        $this->refundTime = $builder->getRefundTime();
        $this->partnerRefundNo = $builder->getPartnerRefundNo();
        $this->refundAmount = $builder->getRefundAmount();
        $this->qrUrl = $builder->getQrUrl();
        $this->paidTime = $builder->getPaidTime();

        // Payout
        $this->beneficiaryaccountNo = $builder->getBeneficiaryaccountNo();
        $this->beneficiaryName = $builder->getBeneficiaryName();
        $this->payoutMethod = $builder->getPayoutMethod();
        $this->beneficiaryBankCode = $builder->getBeneficiaryBankCode();
        $this->amount = $builder->getAmount();

        $this->beneficiaryAccountNo = $builder->getBeneficiaryAccountNo();
        $this->transactionStatus = $builder->getTransactionStatus();

        $this->accountNo = $builder->getAccountNo();
        $this->accountInfos = $builder->getAccountInfos();

        $this->beneficiaryCustomerResidence = $builder->getBeneficiaryCustomerResidence();
        $this->beneficiaryCustomerType = $builder->getBeneficiaryCustomerType();
    }



    public static function fromArray(array $data): self
    {
        $builder = (new NicepayResponseBuilder())
            ->setResponseCode($data['responseCode'] ?? null)
            ->setResponseMessage($data['responseMessage'] ?? null)
            ->setAccessToken($data['accessToken'] ?? null)
            ->setExpiresIn($data['expiresIn'] ?? null)
            ->setTokenType($data['tokenType'] ?? null)
            ->setVirtualAccountData($data['virtualAccountData'] ?? [])
            ->setAdditionalInfo($data['additionalInfo'] ?? [])
            ->setTotalAmount($data['totalAmount'] ?? [])
            ->setPartnerServiceId($data['partnerServiceId'] ?? null)
            ->setCustomerNo($data['customerNo'] ?? null)
            ->setInquiryRequestId($data['inquiryRequestId'] ?? null)
            ->setVirtualAccountNo($data['virtualAccountNo'] ?? null)
            ->setVirtualAccountName($data['virtualAccountName'] ?? null)
            ->setTrxId($data['trxId'] ?? null)
            ->setTransactionStatusDesc($data['transactionStatusDesc'] ?? null)
            ->setLatestTransactionStatus($data['latestTransactionStatus'] ?? null)
            ->setBankCd($data['bankCd'] ?? null)
            ->setTXidVA($data['tXidVA'] ?? null)
            ->setGoodsNm($data['goodsNm'] ?? null)
            ->setVacctValidTm($data['vacctValidTm'] ?? null)
            ->setVacctValidDt($data['vacctValidDt'] ?? null)
            ->setPartnerReferenceno($data['partnerReferenceNo'] ?? null)
            ->setReferenceNo($data['referenceNo'] ?? null)
            ->setWebRedirectUrl($data['webRedirectUrl'] ?? null)
            ->setOriginalPartnerReferenceNo($data['originalPartnerReferenceNo'] ?? null)
            ->setOriginalReferenceNo($data['originalReferenceNo']  ?? null)
            ->setServiceCode($data['serviceCode']  ?? null)
            ->setTransAmount($data['transAmount']  ?? [])
            ->setQrContent($data['qrContent'] ?? null)
            ->setPartnerRefundNo($data['partnerRefundNo'] ?? null)
            ->setRefundAmount($data['refundAmount'] ?? [])
            ->setBeneficiaryaccountNo($data['beneficiaryAccountNo'] ?? $data['beneficiaryaccountNo'] ?? null)
            ->setBeneficiaryName($data['beneficiaryName'] ?? null)
            ->setPayoutMethod($data['payoutMethod'] ?? null)
            ->setBeneficiaryBankCode($data['beneficiaryBankCode'] ?? null)
            ->setAmount($data['amount'] ?? [])
            ->setTransactionStatus($data['transactionStatus'] ?? null)
            ->setAccountNo($data['accountNo'] ?? null)
            ->setAccountInfos($data['accountInfos'] ?? [])
            ->setBeneficiaryCustomerResidence($data['beneficiaryCustomerResidence'] ?? null)
            ->setBeneficiaryCustomerType($data['beneficiaryCustomerType'] ?? null)
            ->setQrUrl($data['qrUrl'] ?? null)
            ->setRefundTime($data['refundTime'] ?? null)
            ->setRefundNo($data['refundNo'] ?? null)
            ->setPaidTime($data['paidTime'] ?? null);

        return new self($builder);
    }

    // Getters


    public function getRefundNo()
    {
        return $this->refundNo;
    }
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    public function getResponseMessage()
    {
        return $this->responseMessage;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    public function getTokenType()
    {
        return $this->tokenType;
    }

    public function getVirtualAccountData(): array
    {
        return $this->virtualAccountData;
    }

    public function getAdditionalInfo(): array
    {
        return $this->additionalInfo;
    }

    public function getTotalAmount(): array
    {
        return $this->totalAmount;
    }

    public function getPartnerReferenceNo()
    {
        return $this->partnerReferenceNo;
    }

    public function getReferenceNo()
    {
        return $this->referenceNo;
    }

    public function getWebRedirectUrl()
    {
        return $this->webRedirectUrl;
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

    public function getTransAmount()
    {
        return $this->transAmount;
    }

    // Virtual Account Getters
    public function getPartnerServiceId()
    {
        return $this->partnerServiceId;
    }

    public function getCustomerNo()
    {
        return $this->customerNo;
    }

    public function getInquiryRequestId()
    {
        return $this->inquiryRequestId;
    }

    public function getVirtualAccountNo()
    {
        return $this->virtualAccountNo;
    }

    public function getVirtualAccountName()
    {
        return $this->virtualAccountName;
    }

    public function getTrxId()
    {
        return $this->trxId;
    }

    public function getTransactionStatusDesc()
    {
        return $this->transactionStatusDesc;
    }

    public function getLatestTransactionStatus()
    {
        return $this->latestTransactionStatus;
    }

    public function getBankCd()
    {
        return $this->bankCd;
    }

    public function getTXidVA()
    {
        return $this->tXidVA;
    }

    public function getGoodsNm()
    {
        return $this->goodsNm;
    }

    public function getVacctValidTm()
    {
        return $this->vacctValidTm;
    }

    public function getVacctValidDt()
    {
        return $this->vacctValidDt;
    }

    public function getQrContent()
    {
        return $this->qrContent;
    }

    public function getQrUrl()
    {
        return $this->qrUrl;
    }

    public function getRefundTime()
    {
        return $this->refundTime;
    }

    public function getPartnerRefundNo()
    {
        return $this->partnerRefundNo;
    }

    public function getRefundAmount()
    {
        return $this->refundAmount;
    }

    public function getBeneficiaryAccountNo()
    {
        return $this->beneficiaryaccountNo ?? $this->beneficiaryAccountNo;
    }

    public function getBeneficiaryName()
    {
        return $this->beneficiaryName;
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

    public function getTransactionStatus()
    {
        return $this->transactionStatus;
    }

    public function getAccountNo()
    {
        return $this->accountNo;
    }

    public function getAccountInfos()
    {
        return $this->accountInfos;
    }

    public function getBeneficiaryCustomerResidence()
    {
        return $this->beneficiaryCustomerResidence;
    }

    public function getBeneficiaryCustomerType()
    {
        return $this->beneficiaryCustomerType;
    }

    public function getPaidTime(){
        return $this->paidTime;
    }
    // Builder Class
    public static function builder(): NicepayResponseBuilder
    {
        return new NicepayResponseBuilder();
    }
}

class NicepayResponseBuilder
{
    private  $responseCode;
    private  $responseMessage;
    private  $accessToken;
    private  $expiresIn;
    private  $tokenType;
    private array $virtualAccountData = [];  // array/map
    private array $additionalInfo = [];      // array/map
    private array $totalAmount = [];

    // Virtual Account
    private  $partnerServiceId;
    private  $customerNo;
    private  $inquiryRequestId;
    private  $virtualAccountNo;
    private  $virtualAccountName;
    private  $trxId;
    private  $transactionStatusDesc;
    private  $latestTransactionStatus;
    private  $bankCd;
    private  $tXidVA;
    private  $goodsNm;
    private  $vacctValidTm;
    private  $vacctValidDt;

    // Ewallet 
    private $partnerReferenceNo;
    private $referenceNo;
    private $webRedirectUrl;
    private $refundNo;

    // Inquiry Status Ewallet
    private $originalPartnerReferenceNo;
    private $originalReferenceNo;
    private $serviceCode;
    private array $transAmount = [];

    // QRIS
    private $qrContent;
    private $qrUrl;
    private $partnerRefundNo;
    private $refundAmount;
    private $refundTime;
    private $paidTime;

    // PAYOUT

    private $beneficiaryaccountNo;
    private $beneficiaryName;
    private $payoutMethod;
    private $beneficiaryBankCode;
    private $amount;

    private $beneficiaryAccountNo;
    private $transactionStatus;

    private $accountNo;
    private array $accountInfos;

    private $beneficiaryCustomerResidence;

    private $beneficiaryCustomerType;



    // Setters

    public function setRefundNo($refundNo): NicepayResponseBuilder
    {
        $this->refundNo = $refundNo;
        return $this;
    }

    public function setResponseCode($responseCode): NicepayResponseBuilder
    {
        $this->responseCode = $responseCode;
        return $this;
    }


    public function setresponseMessage($responseMessage): NicepayResponseBuilder
    {
        $this->responseMessage = $responseMessage;
        return $this;
    }

    public function setAccessToken($accessToken): NicepayResponseBuilder
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    public function setExpiresIn($expiresIn): NicepayResponseBuilder
    {
        $this->expiresIn = $expiresIn;
        return $this;
    }

    public function setTokenType($tokenType): NicepayResponseBuilder
    {
        $this->tokenType = $tokenType;
        return $this;
    }

    public function setVirtualAccountData(array $virtualAccountData): NicepayResponseBuilder
    {
        $this->virtualAccountData = $virtualAccountData;
        return $this;
    }

    public function setAdditionalInfo(array $additionalInfo): NicepayResponseBuilder
    {
        $this->additionalInfo = $additionalInfo;
        return $this;
    }

    public function setTotalAmount(array $totalAmount): NicepayResponseBuilder
    {
        $this->totalAmount = $totalAmount;
        return $this;
    }

    // Virtual Account Setters
    public function setPartnerServiceId($partnerServiceId): NicepayResponseBuilder
    {
        $this->partnerServiceId = $partnerServiceId;
        return $this;
    }

    public function setCustomerNo($customerNo): NicepayResponseBuilder
    {
        $this->customerNo = $customerNo;
        return $this;
    }

    public function setInquiryRequestId($inquiryRequestId): NicepayResponseBuilder
    {
        $this->inquiryRequestId = $inquiryRequestId;
        return $this;
    }

    public function setVirtualAccountNo($virtualAccountNo): NicepayResponseBuilder
    {
        $this->virtualAccountNo = $virtualAccountNo;
        return $this;
    }

    public function setVirtualAccountName($virtualAccountName): NicepayResponseBuilder
    {
        $this->virtualAccountName = $virtualAccountName;
        return $this;
    }

    public function setTrxId($trxId): NicepayResponseBuilder
    {
        $this->trxId = $trxId;
        return $this;
    }

    public function setTransactionStatusDesc($transactionStatusDesc): NicepayResponseBuilder
    {
        $this->transactionStatusDesc = $transactionStatusDesc;
        return $this;
    }

    public function setLatestTransactionStatus($latestTransactionStatus): NicepayResponseBuilder
    {
        $this->latestTransactionStatus = $latestTransactionStatus;
        return $this;
    }

    public function setBankCd($bankCd): NicepayResponseBuilder
    {
        $this->bankCd = $bankCd;
        return $this;
    }

    public function setTXidVA($tXidVA): NicepayResponseBuilder
    {
        $this->tXidVA = $tXidVA;
        return $this;
    }

    public function setGoodsNm($goodsNm): NicepayResponseBuilder
    {
        $this->goodsNm = $goodsNm;
        return $this;
    }

    public function setVacctValidTm($vacctValidTm): NicepayResponseBuilder
    {
        $this->vacctValidTm = $vacctValidTm;
        return $this;
    }

    public function setVacctValidDt($vacctValidDt): NicepayResponseBuilder
    {
        $this->vacctValidDt = $vacctValidDt;
        return $this;
    }

    public function setPartnerReferenceNo($partnerReferenceNo): NicepayResponseBuilder
    {
        $this->partnerReferenceNo = $partnerReferenceNo;
        return $this;
    }

    public function setReferenceNo($referenceNo): NicepayResponseBuilder
    {
        $this->referenceNo = $referenceNo;
        return $this;
    }

    public function setWebRedirectUrl($webRedirectUrl): NicepayResponseBuilder
    {
        $this->webRedirectUrl = $webRedirectUrl;
        return $this;
    }

    public function setOriginalPartnerReferenceNo($originalPartnerReferenceNo): NicepayResponseBuilder
    {
        $this->originalPartnerReferenceNo = $originalPartnerReferenceNo;
        return $this;
    }

    public function setOriginalReferenceNo($originalReferenceNo): NicepayResponseBuilder
    {
        $this->originalReferenceNo = $originalReferenceNo;
        return $this;
    }

    public function setServiceCode($serviceCode): NicepayResponseBuilder
    {
        $this->serviceCode = $serviceCode;
        return $this;
    }

    public function setTransAmount($transAmount): NicepayResponseBuilder
    {
        $this->transAmount = $transAmount;
        return $this;
    }

    public function setQrContent($qrContent): NicepayResponseBuilder
    {
        $this->qrContent = $qrContent;
        return $this;
    }

    public function setQrUrl($qrUrl) :NicepayResponseBuilder{
        $this -> qrUrl = $qrUrl;
        return $this;
    }

    public function setRefundTime($refundTime):NicepayResponseBuilder 
    {
        $this -> refundTime = $refundTime;
        return $this;
    }

    public function setPartnerRefundNo($partnerRefundNo): NicepayResponseBuilder
    {
        $this->partnerRefundNo = $partnerRefundNo;
        return $this;
    }

    public function setRefundAmount($refundAmount): NicepayResponseBuilder
    {
        $this->refundAmount = $refundAmount;
        return $this;
    }

    public function setBeneficiaryaccountNo($beneficiaryaccountNo)
    {
        $this->beneficiaryaccountNo = $beneficiaryaccountNo;
        $this->beneficiaryAccountNo = $beneficiaryaccountNo;
        return $this;
    }

    public function setBeneficiaryName($beneficiaryName)
    {
        $this->beneficiaryName = $beneficiaryName;
        return $this;
    }

    public function setPayoutMethod($payoutMethod)
    {
        $this->payoutMethod = $payoutMethod;
        return $this;
    }

    public function setBeneficiaryBankCode($beneficiaryBankCode)
    {
        $this->beneficiaryBankCode = $beneficiaryBankCode;
        return $this;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    public function setTransactionStatus($transactionStatus): self
    {
        $this->transactionStatus = $transactionStatus;
        return $this;
    }

    public function setAccountNo($accountNo): NicepayResponseBuilder
    {
        $this->accountNo = $accountNo;
        return $this;
    }

    public function setAccountInfos($accountInfos): NicepayResponseBuilder
    {
        $this->accountInfos = $accountInfos;
        return $this;
    }

    public function setBeneficiaryCustomerResidence($beneficiaryCustomerResidence): NicepayResponseBuilder
    {
        $this->beneficiaryCustomerResidence = $beneficiaryCustomerResidence;
        return $this;
    }

    public function setBeneficiaryCustomerType($beneficiaryCustomerType): NicepayResponseBuilder
    {
        $this->beneficiaryCustomerType = $beneficiaryCustomerType;
        return $this;
    }

    public function setPaidTime($paidTime): NicepayResponseBuilder {
        $this->paidTime = $paidTime;
        return $this;
    }

    // Getters 

    public function getRefundNo(){
        return $this->refundNo;
    }

    public function getPaidTime(){
        return $this->paidTime;
    }

    public function getQrUrl()
    {
        return $this->qrUrl;
    }

    public function getRefundTime(){
        return $this -> refundTime;
    }
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    public function getResponseMessage()
    {
        return $this->responseMessage;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    public function getTokenType()
    {
        return $this->tokenType;
    }

    public function getVirtualAccountData(): array
    {
        return $this->virtualAccountData;
    }

    public function getAdditionalInfo(): array
    {
        return $this->additionalInfo;
    }

    public function getTotalAmount(): array
    {
        return $this->totalAmount;
    }

    // Virtual Account Getters
    public function getPartnerServiceId()
    {
        return $this->partnerServiceId;
    }

    public function getCustomerNo()
    {
        return $this->customerNo;
    }

    public function getInquiryRequestId()
    {
        return $this->inquiryRequestId;
    }

    public function getVirtualAccountNo()
    {
        return $this->virtualAccountNo;
    }

    public function getVirtualAccountName()
    {
        return $this->virtualAccountName;
    }

    public function getTrxId()
    {
        return $this->trxId;
    }

    public function getTransactionStatusDesc()
    {
        return $this->transactionStatusDesc;
    }

    public function getLatestTransactionStatus()
    {
        return $this->latestTransactionStatus;
    }

    public function getBankCd()
    {
        return $this->bankCd;
    }

    public function getTXidVA()
    {
        return $this->tXidVA;
    }

    public function getGoodsNm()
    {
        return $this->goodsNm;
    }

    public function getVacctValidTm()
    {
        return $this->vacctValidTm;
    }

    public function getVacctValidDt()
    {
        return $this->vacctValidDt;
    }

    public function getPartnerReferenceNo()
    {
        return $this->partnerReferenceNo;
    }

    public function getReferenceNo()
    {
        return $this->referenceNo;
    }

    public function getWebRedirectUrl()
    {
        return $this->webRedirectUrl;
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

    public function getTransAmount()
    {
        return $this->transAmount;
    }

    public function getQrContent()
    {
        return $this->qrContent;
    }

    public function getPartnerRefundNo()
    {
        return $this->partnerRefundNo;
    }

    public function getRefundAmount()
    {
        return $this->refundAmount;
    }

    public function getBeneficiaryaccountNo()
    {
        return $this->beneficiaryaccountNo ?? $this->beneficiaryAccountNo;
    }

    public function getBeneficiaryName()
    {
        return $this->beneficiaryName;
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

    public function getTransactionStatus()
    {
        return $this->transactionStatus;
    }

    public function getAccountNo()
    {
        return $this->accountNo;
    }
    public function getAccountInfos()
    {
        return $this->accountInfos;
    }

    public function getBeneficiaryCustomerResidence()
    {
        return $this->beneficiaryCustomerResidence;
    }

    public function getBeneficiaryCustomerType()
    {
        return $this->beneficiaryCustomerType;
    }
    // Build method
    public function build(): NicepayResponse
    {
        return new NicepayResponse($this);
    }
}