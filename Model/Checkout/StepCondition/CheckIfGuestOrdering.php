<?php

declare(strict_types=1);

namespace Elgentos\HyvaCheckoutOnePageWithLoginStep\Model\Checkout\StepCondition;

use Hyva\Checkout\Model\CustomConditionInterface;
use Magento\Checkout\Model\Session as SessionCheckout;
use Magento\Customer\Model\Session as SessionCustomer;
use Magento\Framework\App\Request\Http;
use Magento\Framework\UrlInterface;

class CheckIfGuestOrdering implements CustomConditionInterface
{
    public function __construct(
        protected SessionCheckout $sessionCheckout,
        private Http $request,
        private SessionCustomer $sessionCustomer,
        private UrlInterface $url
    ) {
    }

    public function validate(): bool
    {
        if ($this->request->getMethod() === $this->request::METHOD_POST) {
            return false;
        }

        $isGuest = (bool) $this->sessionCheckout->getQuote()->getCustomerIsGuest();
        $guestOrder = (bool) $this->request->has('guestorder');

        $this->sessionCustomer->setBeforeAuthUrl(
            $this->url->getUrl('checkout', ['_current' => true])
        );

        if ($isGuest) {
            if ($guestOrder) {
                return false;
            }

            return true;
        }

        return false;
    }
}
