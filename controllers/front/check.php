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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * This controller receive ajax call on customer click on a payment button
 */
class Ps_CheckoutCheckModuleFrontController extends ModuleFrontController
{
    /**
     * @var Ps_checkout
     */
    public $module;

    /**
     * @see FrontController::postProcess()
     *
     * @todo Move logic to a Service
     */
    public function postProcess()
    {
        try {
            if (false === $this->checkIfPaymentOptionIsAvailable()) {
                throw new PsCheckoutException('This payment method is not available.', PsCheckoutException::PRESTASHOP_PAYMENT_UNAVAILABLE);
            }

            $customer = new Customer($this->context->cart->id_customer);

            if (false === Validate::isLoadedObject($customer)) {
                throw new PsCheckoutException('Customer is not loaded yet');
            }

            $request = Request::createFromGlobals();

            $fundingSource = $request->get('fundingSource');

            if (empty($fundingSource)) {
                throw new PsCheckoutException('FundingSource cannot be null', PsCheckoutException::PSCHECKOUT_WEBHOOK_BODY_EMPTY);
            }

            if (false !== Validate::isGenericName($fundingSource)) {
                $psCheckoutCartCollection = new PrestaShopCollection('PsCheckoutCart');
                $psCheckoutCartCollection->where('id_cart', '=', (int) $this->context->cart->id);

                /** @var PsCheckoutCart|false $psCheckoutCart */
                $psCheckoutCart = $psCheckoutCartCollection->getFirst();

                if (false !== $psCheckoutCart) {
                    $psCheckoutCart->paypal_funding = $fundingSource;
                    $psCheckoutCart->update();
                } else {
                    $psCheckoutCart = new PsCheckoutCart();
                    $psCheckoutCart->id_cart = (int) $this->context->cart->id;
                    $psCheckoutCart->paypal_funding = $fundingSource;
                    $psCheckoutCart->add();
                }
            }

            $response = new JsonResponse(
                sprintf('The payment  with cart : %s have been checked successfully.', $this->context->cart->id)
            );
            $response->send();
        } catch (Exception $exception) {
            $response = new JsonResponse(
                sprintf('An error occurred during the check action : %s (code %s)',$exception->getMessage(), $exception->getCode()),
                Response::HTTP_BAD_REQUEST
            );
            $response->send();
        }

        exit;
    }

    /**
     * Check that this payment option is still available in case the customer changed
     * his address just before the end of the checkout process
     *
     * @todo Move to main module class
     *
     * @return bool
     */
    private function checkIfPaymentOptionIsAvailable()
    {
        $modules = Module::getPaymentModules();

        if (empty($modules)) {
            return false;
        }

        foreach ($modules as $module) {
            if (isset($module['name']) && $this->module->name === $module['name']) {
                return true;
            }
        }

        return false;
    }
}
