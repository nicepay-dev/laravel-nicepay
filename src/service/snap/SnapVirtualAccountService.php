<?php

namespace Nicepay\LaravelSnap\Service\Snap;

use Nicepay\LaravelSnap\common\NICEPay;
use Nicepay\LaravelSnap\Data\Model\{VirtualAccount, InquiryStatus, Cancel};
use Nicepay\LaravelSnap\data\response\NicepayResponse;
use  Nicepay\LaravelSnap\utils\NicepayCons;

class SnapVirtualAccountService
{

    private Snap $snap;

    public function __construct(NICEPay $config)
    {
        $this->snap = new Snap($config);
    }

    /**
     * Generate a virtual account using Snap API
     *
     * @param VirtualAccount $requestBody The request body to be sent in the transaction
     * @param string $accessToken The access token to be used in the transaction
     * @return NicepayResponse The response from the Nicepay API
     */
    public function generateVA(VirtualAccount $requestBody, string $accessToken): NicepayResponse
    {
        return $this->snap->requestSnapTransaction($requestBody, NicepayCons::getCreateVASnapEndpoint(), $accessToken, "POST");
    }

    /**
     * Retrieves the status of a virtual account transaction using the given request body and access token.
     *
     * @param InquiryStatus $requestBody The request body containing virtual account inquiry status details.
     * @param string $accessToken The access token for authentication.
     * @return NicepayResponse The response from the inquiry status request.
     */
    public function inquiryStatus(InquiryStatus $requestBody, string $accessToken): NicepayResponse
    {
        return $this->snap->requestSnapTransaction($requestBody, NicepayCons::getInquiryStatusVAEndpoint(), $accessToken, "POST");
    }


    /**
     * Cancels a virtual account transaction using the given request body and access token.
     *
     * @param Cancel $requestBody The request body containing virtual account cancel details.
     * @param string $accessToken The access token for authentication.
     * @return NicepayResponse The response from the cancel request.
     */
    public function cancel(Cancel $requestBody, string $accessToken): NicepayResponse
    {
        return $this->snap->requestSnapTransaction($requestBody, NicepayCons::getCancelVAEndpoint(), $accessToken, "DELETE");
    }
}