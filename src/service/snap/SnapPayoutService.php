<?php

namespace Nicepay\LaravelSnap\Service\Snap;

use Nicepay\LaravelSnap\common\NICEPay;
use Nicepay\LaravelSnap\Data\Model\{Payout, InquiryStatus, Cancel};
use Nicepay\LaravelSnap\data\response\NicepayResponse;
use  Nicepay\LaravelSnap\utils\NicepayCons;





class SnapPayoutService
{


    private Snap $snap;


    public function __construct(NICEPay $config)
    {
        $this->snap = new Snap($config);
    }


    /**
     * Registration API for Payout
     *
     * @param Payout $requestBody The request body for Payout registration
     * @param string $accessToken The access token for the request
     * @return NicepayResponse The response from the registration API
     */
    public function registration(Payout $requestBody, string $accessToken): NicepayResponse
    {
        return $this->snap->requestSnapTransaction($requestBody, NicepayCons::getRegistPayoutEndpoint(), $accessToken, "POST");
    }

    /**
     * Approve API for Payout
     *
     * @param Payout $requestBody The request body for Payout approve
     * @param string $accessToken The access token for the request
     * @return NicepayResponse The response from the approve API
     */
    public function approve(Payout $requestBody, string $accessToken): NicepayResponse
    {
        return $this->snap->requestSnapTransaction($requestBody, NicepayCons::getApprovePayoutEndpoint(), $accessToken, "POST");
    }

    /**
     * Retrieves the status of a payout transaction using the given request body and access token.
     *
     * @param InquiryStatus $requestBody The request body containing payout inquiry status details.
     * @param string $accessToken The access token for authentication.
     * @return NicepayResponse The response from the inquiry status request.
     */
    public function inquiryStatus(InquiryStatus $requestBody, string $accessToken): NicepayResponse
    {
        return $this->snap->requestSnapTransaction($requestBody, NicepayCons::getInquiryStatusPayoutEndpoint(), $accessToken, "POST");
    }

    /**
     * Checks the balance of a payout transaction using the given request body and access token.
     *
     * @param Payout $requestBody The request body containing details for checking balance.
     * @param string $accessToken The access token for authentication.
     * @return NicepayResponse The response from the check balance request.
     */
    public function checkBalance(Payout $requestBody, string $accessToken): NicepayResponse
    {
        return $this->snap->requestSnapTransaction($requestBody, NicepayCons::getCheckBalancePayoutEndpoint(), $accessToken, "POST");
    }

    /**
     * Cancels a payout transaction using the given request body and access token.
     *
     * @param Cancel $requestBody The request body containing payout cancel details.
     * @param string $accessToken The access token for authentication.
     * @return NicepayResponse The response from the cancel request.
     */
    public function cancel(Cancel $requestBody, string $accessToken): NicepayResponse
    {
        return $this->snap->requestSnapTransaction($requestBody, NicepayCons::getCancelPayoutEndpoint(), $accessToken, "POST");
    }

    /**
     * Rejects a payout transaction using the given request body and access token.
     *
     * @param Cancel $requestBody The request body containing payout reject details.
     * @param string $accessToken The access token for authentication.
     * @return NicepayResponse The response from the reject request.
     */
    public function reject(Cancel $requestBody, string $accessToken): NicepayResponse
    {
        return $this->snap->requestSnapTransaction($requestBody, NicepayCons::getRejectPayoutEndpoint(), $accessToken, "POST");
    }
}