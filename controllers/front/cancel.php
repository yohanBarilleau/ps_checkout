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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * This controller receive ajax call on customer canceled payment
 */
class Ps_CheckoutCancelModuleFrontController extends ModuleFrontController
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
        try{
            $request = Request::createFromGlobals();

            $orderID = $request->get('orderID');

            if ($orderID === null) {
                throw new \Exception("orderId cannot be null");
            }

            $this->module->getLogger()->info(sprintf(
                'Customer canceled payment - PayPal Order %s',
                $orderID
            ));

            //@todo remove cookie
            $this->context->cookie->__unset('ps_checkout_orderId');
            $this->context->cookie->__unset('ps_checkout_fundingSource');

            $response = new Response(
                sprintf('The payment  with orderID : %s have been canceled successfully.', $orderID),
                Response::HTTP_OK,
                ['content-type' => 'text/html']
            );
            $response->send();
        }
        catch( \Exception $exception) {
            $response = new Response(
                sprintf('An error occurred during the canceled action : %s',$exception->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR,
                ['content-type' => 'text/html']
            );
            $response->send();
        }

        exit;
    }
}
