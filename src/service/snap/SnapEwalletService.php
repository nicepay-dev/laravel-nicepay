<?php

namespace Nicepay\LaravelSnap\Service\Snap;

use Nicepay\LaravelSnap\common\NICEPay;
use Nicepay\LaravelSnap\Data\Model\{Ewallet, InquiryStatus, Cancel};
use Nicepay\LaravelSnap\data\response\NicepayResponse;
use  Nicepay\LaravelSnap\utils\NicepayCons;


class SnapEwalletService
{


    private Snap $snap;


    public function __construct(NICEPay $config)
    {
        $this->snap = new Snap($config);
    }


    /**
     * Processes a payment transaction using e-wallet with the given request body and access token.
     *
     * @param Ewallet $requestBody The request body containing e-wallet transaction details.
     * @param string $accessToken The access token for authentication.
     * @return NicepayResponse The response from the payment transaction request.
     */
    public function paymentEwallet(Ewallet $requestBody, string $accessToken): NicepayResponse
    {
        return $this->snap->requestSnapTransaction($requestBody, NicepayCons::getPaymentEwalletEndpoint(), $accessToken, "POST");
    }

    /**
     * Retrieves the status of an e-wallet transaction using the given request body and access token.
     *
     * @param InquiryStatus $requestBody The request body containing e-wallet inquiry status details.
     * @param string $accessToken The access token for authentication.
     * @return NicepayResponse The response from the inquiry status request.
     */
    public function inquiryStatus(InquiryStatus $requestBody, string $accessToken): NicepayResponse
    {
        return $this->snap->requestSnapTransaction($requestBody, NicepayCons::getInquiryStatusEwalletEndpoint(), $accessToken, "POST");
    }


    /**
     * Refunds an e-wallet transaction using the given request body and access token.
     *
     * @param Cancel $requestBody The request body containing e-wallet refund details.
     * @param string $accessToken The access token for authentication.
     * @return NicepayResponse The response from the refund request.
     */
    public function refund(Cancel $requestBody, string $accessToken): NicepayResponse
    {
        return $this->snap->requestSnapTransaction($requestBody, NicepayCons::getRefundEwalletEndpoint(), $accessToken, "POST");
    }
}