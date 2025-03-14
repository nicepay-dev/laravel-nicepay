<?php
namespace Nicepay\LaravelSnap\Data\Model;

class Ewallet
{

    private $partnerReferenceNo;
    private $merchantId;
    private $subMerchantId;
    private $externalStoreId;
    private $validUpTo;
    private $pointOfInitiation;
    private array $amount;
    private array $additionalInfo;
    private array $urlParam;


    // Constructor

    public function __construct(EwalletBuilder $builder)
    {

        $this->partnerReferenceNo = $builder->getPartnerReferenceNo();
        $this->merchantId = $builder->getMerchantId();
        $this->subMerchantId = $builder->getSubMerchantId();
        $this->externalStoreId = $builder->getExternalStoreId();
        $this->validUpTo = $builder->getValidUpTo();
        $this->pointOfInitiation = $builder->getPointOfInitiation();
        $this->amount = $builder->getAmount();
        $this->additionalInfo = $builder->getAdditionalInfo();
        $this->urlParam = $builder->getUrlParam();
    }

    // Builder
    public static function builder(): EwalletBuilder
    {
        return new EwalletBuilder();
    }

    public function toArray(): array
    {
        return [
            "partnerReferenceNo" => $this->partnerReferenceNo,
            "merchantId" => $this->merchantId,
            "subMerchantId" => $this->subMerchantId,
            "externalStoreId" => $this->externalStoreId,
            "validUpTo" => $this->validUpTo,
            "pointOfInitiation" => $this->pointOfInitiation,
            "amount" => $this->amount,
            "additionalInfo" => $this->additionalInfo,
            "urlParam" => $this->urlParam,
        ];
    }

    // GETTER
    public function getPartnerReferenceNo()
    {
        return $this->partnerReferenceNo;
    }

    public function getMerchantId()
    {
        return $this->merchantId;
    }

    public function getSubMerchantId()
    {
        return $this->subMerchantId;
    }

    public function getExternalStoreId()
    {
        return $this->externalStoreId;
    }

    public function getValidUpTo()
    {
        return $this->validUpTo;
    }

    public function getPointOfInitiation()
    {
        return $this->pointOfInitiation;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getAdditionalInfo()
    {
        return $this->additionalInfo;
    }

    public function getUrlParam()
    {
        return $this->urlParam;
    }
}

class EwalletBuilder
{

    private $partnerReferenceNo;
    private $merchantId;
    private $subMerchantId;
    private $externalStoreId;
    private $validUpTo;
    private $pointOfInitiation;
    private array $amount = [];
    private array $additionalInfo = [];
    private array $urlParam = [];

    // GETTER

    public function getPartnerReferenceNo()
    {
        return $this->partnerReferenceNo;
    }

    public function getMerchantId()
    {
        return $this->merchantId;
    }

    public function getSubMerchantId()
    {
        return $this->subMerchantId;
    }

    public function getExternalStoreId()
    {
        return $this->externalStoreId;
    }

    public function getValidUpTo()
    {
        return $this->validUpTo;
    }

    public function getPointOfInitiation()
    {
        return $this->pointOfInitiation;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getAdditionalInfo()
    {
        return $this->additionalInfo;
    }

    public function getUrlParam()
    {
        return $this->urlParam;
    }

    // BUILDER SETTER

    public function partnerReferenceNo($partnerReferenceNo): EwalletBuilder
    {
        $this->partnerReferenceNo = $partnerReferenceNo;
        return $this;
    }

    public function merchantId($merchantId): EwalletBuilder
    {
        $this->merchantId = $merchantId;
        return $this;
    }

    public function subMerchantId($subMerchantId): EwalletBuilder
    {
        $this->subMerchantId = $subMerchantId;
        return $this;
    }

    public function externalStoreId($externalStoreId): EwalletBuilder
    {
        $this->externalStoreId = $externalStoreId;
        return $this;
    }

    public function validUpTo($validUpTo): EwalletBuilder
    {
        $this->validUpTo = $validUpTo;
        return $this;
    }

    public function pointOfInitiation($pointOfInitiation): EwalletBuilder
    {
        $this->pointOfInitiation = $pointOfInitiation;
        return $this;
    }

    public function urlParam(array $urlParams): self
    {
        $urlParamList = [];

        foreach ($urlParams as $params) {
            if (count($params) === 3) {
                $paramListMap = [
                    "url" => $params[0],
                    "type" => $params[1],
                    "isDeeplink" => $params[2]
                ];
                $urlParamList[] = $paramListMap;
            }
        }

        $this->urlParam = $urlParamList;
        return $this;
    }

    public function amount($value, $currency): EwalletBuilder
    {
        $amount = [
            "value" => $value,
            "currency" => $currency,
        ];
        $this->amount = $amount;
        return $this;
    }

    public function additionalInfo($additionalInfo): EwalletBuilder
    {
        $this->additionalInfo = $additionalInfo;
        return $this;
    }

    public function addInfoMitraCd($mitraCd): EwalletBuilder
    {
        $this->additionalInfo["mitraCd"] = $mitraCd;
        return $this;
    }

    public function addInfoGoodsNm($goodsNm): EwalletBuilder
    {
        $this->additionalInfo["goodsNm"] = $goodsNm;
        return $this;
    }
    public function addInfoBillingNm($billingNm): EwalletBuilder
    {
        $this->additionalInfo["billingNm"] = $billingNm;
        return $this;
    }


    public function addInfoBillingPhone($billingPhone): EwalletBuilder
    {
        $this->additionalInfo["billingPhone"] = $billingPhone;
        return $this;
    }

    public function addInfoCallBackUrl($callBackUrl): EwalletBuilder
    {
        $this->additionalInfo["callBackUrl"] = $callBackUrl;
        return $this;
    }

    public function addInfoDbProcessUrl($dbProcessUrl): EwalletBuilder
    {
        $this->additionalInfo["dbProcessUrl"] = $dbProcessUrl;
        return $this;
    }

    public function addInfoCartData($cartData): EwalletBuilder
    {
        $this->additionalInfo["cartData"] = $cartData;
        return $this;
    }

    public function addInfoMsId($msId): EwalletBuilder
    {
        $this->additionalInfo["msId"] = $msId;
        return $this;
    }

    public function addInfoMsfee($msfee): EwalletBuilder
    {
        $this->additionalInfo["msfee"] = $msfee;
        return $this;
    }

    public function addInfoMsfeetype($msfeetype): EwalletBuilder
    {
        $this->additionalInfo["msfeetype"] = $msfeetype;
        return $this;
    }

    public function addInfoMbfee($mbfee): EwalletBuilder
    {
        $this->additionalInfo["mbfee"] = $mbfee;
        return $this;
    }

    public function addInfoMbfeetype($mbfeetype): EwalletBuilder
    {
        $this->additionalInfo["mbfeetype"] = $mbfeetype;
        return $this;
    }

    // BUILD ()

    public function build(): Ewallet
    {
        return new Ewallet($this);
    }
}

?>

