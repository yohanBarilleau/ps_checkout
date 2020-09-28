<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 */

use PrestaShop\Module\PrestashopCheckout\Exception\PsCheckoutException;

/**
 * This controller receive ajax call on customer click on a payment button
 */
class Ps_CheckoutCheckModuleFrontController extends AbstractApiModuleFrontController
{
    /**
     * @see FrontController::postProcess()
     *
     * @todo Move logic to a Service
     */
    public function postProcess()
    {
        try {
            if (false === $this->checkIfContextIsValid()) {
                throw new PsCheckoutException('The context is not valid', PsCheckoutException::PRESTASHOP_CONTEXT_INVALID);
            }

            if (false === $this->checkIfPaymentOptionIsAvailable()) {
                throw new PsCheckoutException('This payment method is not available.', PsCheckoutException::PRESTASHOP_PAYMENT_UNAVAILABLE);
            }

            $customer = new Customer($this->context->cart->id_customer);

            if (false === Validate::isLoadedObject($customer)) {
                throw new PsCheckoutException('Customer is not loaded yet');
            }

            $bodyContent = file_get_contents('php://input');

            if (empty($bodyContent)) {
                throw new PsCheckoutException('Payload invalid', PsCheckoutException::PSCHECKOUT_WEBHOOK_BODY_EMPTY);
            }

            $bodyValues = json_decode($bodyContent, true);

            if (empty($bodyValues)) {
                throw new PsCheckoutException('Payload invalid', PsCheckoutException::PSCHECKOUT_WEBHOOK_BODY_EMPTY);
            }

            if (false === empty($bodyValues['fundingSource']) && false !== Validate::isGenericName($bodyValues['fundingSource'])) {
                $psCheckoutCartCollection = new PrestaShopCollection('PsCheckoutCart');
                $psCheckoutCartCollection->where('id_cart', '=', (int) $this->context->cart->id);

                /** @var PsCheckoutCart|false $psCheckoutCart */
                $psCheckoutCart = $psCheckoutCartCollection->getFirst();

                if (false !== $psCheckoutCart) {
                    $psCheckoutCart->paypal_funding = $bodyValues['fundingSource'];
                    $psCheckoutCart->update();
                } else {
                    $psCheckoutCart = new PsCheckoutCart();
                    $psCheckoutCart->id_cart = (int) $this->context->cart->id;
                    $psCheckoutCart->paypal_funding = $bodyValues['fundingSource'];
                    $psCheckoutCart->add();
                }

                $this->context->cookie->__set('ps_checkout_fundingSource', $bodyValues['fundingSource']);
            }

            $this->sendOkResponse($bodyValues);
        } catch (Exception $exception) {
            $this->sendBadRequestError($exception);
        }

        exit;
    }
}
