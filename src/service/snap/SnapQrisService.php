<?php

namespace Nicepay\LaravelSnap\Service\Snap;

use Nicepay\LaravelSnap\common\NICEPay; 
use Nicepay\LaravelSnap\Data\Model\{Qris, InquiryStatus, Cancel};
use Nicepay\LaravelSnap\data\response\NicepayResponse;
use  Nicepay\LaravelSnap\utils\NicepayCons;






class SnapQrisService
{


    private Snap $snap;


    public function __construct(NICEPay $config)
    {
        $this->snap = new Snap($config);
    }


    /**
     * Generates a QRIS code using the given request body and access token.
     * 
     * @param Qris $requestBody The request body containing the details for generating a QRIS code.
     * @param string $accessToken The access token for authentication.
     * @return NicepayResponse The response from the generate QRIS code request.
     */
    public function generateQris(Qris $requestBody, string $accessToken): NicepayResponse
    {
        return $this->snap->requestSnapTransaction($requestBody, NicepayCons::getGenerateQrisEndpoint(), $accessToken, "POST");
    }

    /**
     * Retrieves the status of a QRIS transaction using the given request body and access token.
     * 
     * @param InquiryStatus $requestBody The request body containing the details for retrieving the status of a QRIS transaction.
     * @param string $accessToken The access token for authentication.
     * @return NicepayResponse The response from the inquiry status request.
     */
    public function inquiryStatus(InquiryStatus $requestBody, string $accessToken): NicepayResponse
    {
        return $this->snap->requestSnapTransaction($requestBody, NicepayCons::getInquiryStatusQrisEndpoint(), $accessToken, "POST");
    }


    /**
     * Refunds a QRIS transaction using the given request body and access token.
     * 
     * @param Cancel $requestBody The request body containing the details for refunding a QRIS transaction.
     * @param string $accessToken The access token for authentication.
     * @return NicepayResponse The response from the refund request.
     */
    public function refund(Cancel $requestBody, string $accessToken): NicepayResponse
    {
        return $this->snap->requestSnapTransaction($requestBody, NicepayCons::getRefundQrisEndpoint(), $accessToken, "POST");
    }
}