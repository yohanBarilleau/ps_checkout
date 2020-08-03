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

namespace PrestaShop\Module\PrestashopCheckout;

use PrestaShop\Module\PrestashopCheckout\Entity\PaypalAccount;
use PrestaShop\Module\PrestashopCheckout\Entity\PsAccount;

/**
 * Not really an entity.
 * Define and manage data regarding paypal account
 */
class PersistentConfiguration
{
    /**
     * Save / update paypal account in database
     *
     * @param PaypalAccount $paypalAccount
     *
     * @return bool
     */
    public function savePaypalAccount(PaypalAccount $paypalAccount)
    {
        return \Configuration::updateValue(
                PaypalAccount::PS_CHECKOUT_PAYPAL_ID_MERCHANT,
                $paypalAccount->getMerchantId(),
                false,
                null,
                (int) \Context::getContext()->shop->id
            )
            && \Configuration::updateValue(
                PaypalAccount::PS_CHECKOUT_PAYPAL_EMAIL_MERCHANT,
                $paypalAccount->getEmail(),
                false,
                null,
                (int) \Context::getContext()->shop->id
            )
            && \Configuration::updateValue(
                PaypalAccount::PS_CHECKOUT_PAYPAL_EMAIL_STATUS,
                $paypalAccount->getEmailIsVerified(),
                false,
                null,
                (int) \Context::getContext()->shop->id
            )
            && \Configuration::updateValue(
                PaypalAccount::PS_CHECKOUT_PAYPAL_PAYMENT_STATUS,
                $paypalAccount->getPaypalPaymentStatus(),
                false,
                null,
                (int) \Context::getContext()->shop->id
            )
            && \Configuration::updateValue(
                PaypalAccount::PS_CHECKOUT_CARD_HOSTED_FIELDS_STATUS,
                $paypalAccount->getCardPaymentStatus(),
                false,
                null,
                (int) \Context::getContext()->shop->id
            );
    }

    /**
     * Save / update ps account in database
     *
     * @param PsAccount $psAccount
     *
     * @return bool
     */
    public function savePsAccount(PsAccount $psAccount)
    {
        return \Configuration::updateValue(
                PsAccount::PS_PSX_FIREBASE_EMAIL,
                $psAccount->getEmail(),
                false,
                null,
                (int) \Context::getContext()->shop->id
            )
            && \Configuration::updateValue(
                PsAccount::PS_PSX_FIREBASE_ID_TOKEN,
                $psAccount->getIdToken(),
                false,
                null,
                (int) \Context::getContext()->shop->id
            )
            && \Configuration::updateValue(
                PsAccount::PS_PSX_FIREBASE_LOCAL_ID,
                $psAccount->getLocalId(),
                false,
                null,
                (int) \Context::getContext()->shop->id
            )
            && \Configuration::updateValue(
                PsAccount::PS_PSX_FIREBASE_REFRESH_TOKEN,
                $psAccount->getRefreshToken(),
                false,
                null,
                (int) \Context::getContext()->shop->id
            )
            && \Configuration::updateValue(
                PsAccount::PS_CHECKOUT_PSX_FORM,
                $psAccount->getPsxForm(),
                false,
                null,
                (int) \Context::getContext()->shop->id
            );
    }
}
