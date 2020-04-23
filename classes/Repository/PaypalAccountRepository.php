<?php
/**
 * 2007-2020 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

namespace PrestaShop\Module\PrestashopCheckout\Repository;

use PrestaShop\Module\PrestashopCheckout\Entity\PaypalAccount;
use PrestaShop\Module\PrestashopCheckout\Updater\PaypalAccountUpdater;

/**
 * Repository for PaypalAccount
 */
class PaypalAccountRepository
{
    /**
     * Get the current paypal account onboarded
     *
     * @return PaypalAccount
     */
    public function getOnboardedAccount()
    {
        $paypalAccount = new PaypalAccount(
            $this->getMerchantId(),
            $this->getMerchantEmail(),
            $this->getMerchantEmailStatus(),
            $this->getPaypalPaymentStatus(),
            $this->getCardHostedFieldsStatus()
        );

        return $paypalAccount;
    }

    /**
     * Get the status of the paypal onboarding
     *
     * @return bool
     */
    public function onbardingIsCompleted()
    {
        return !empty($this->getMerchantId());
    }

    /**
     * Check if the paypal email was confirmed or not
     *
     * @return bool
     */
    public function paypalEmailIsValid()
    {
        return (bool) $this->getMerchantEmailStatus();
    }

    /**
     * Get if the payment method by hosted fields is enabled for the current merchant
     *
     * @return bool
     */
    public function cardHostedFieldsIsAllowed()
    {
        $cardStatus = $this->getCardHostedFieldsStatus();

        if ($cardStatus === PaypalAccountUpdater::SUBSCRIBED
        || $cardStatus === PaypalAccountUpdater::LIMITED) {
            return true;
        }

        return false;
    }

    /**
     * Merchant can disable hosted fields in module configuration
     *
     * @return bool
     */
    public function cardHostedFieldsIsEnabled()
    {
        return (bool) \Configuration::get(
            PaypalAccount::PS_CHECKOUT_CARD_HOSTED_FIELDS_ENABLED,
            null,
            null,
            (int) \Context::getContext()->shop->id
        );
    }

    /**
     * Get if hosted fields are enabled by Paypal and merchant
     *
     * @return bool
     */
    public function cardHostedFieldsIsAvailable()
    {
        return $this->cardHostedFieldsIsEnabled()
            && $this->cardHostedFieldsIsAllowed();
    }

    /**
     * Get if the payment method by paypal is enabled for the current merchant
     *
     * @return bool
     */
    public function paypalPaymentMethodIsValid()
    {
        return (bool) $this->getPaypalPaymentStatus();
    }

    /**
     * Get the merchant id for the current onboarded merchant
     *
     * @return string|bool
     */
    public function getMerchantId()
    {
        return \Configuration::get(
            PaypalAccount::PS_CHECKOUT_PAYPAL_ID_MERCHANT,
            null,
            null,
            (int) \Context::getContext()->shop->id
        );
    }

    /**
     * Get the merchant email
     *
     * @return string|bool
     */
    public function getMerchantEmail()
    {
        return \Configuration::get(
            PaypalAccount::PS_CHECKOUT_PAYPAL_EMAIL_MERCHANT,
            null,
            null,
            (int) \Context::getContext()->shop->id
        );
    }

    /**
     * Get the merchant email status
     *
     * @return string|bool
     */
    public function getMerchantEmailStatus()
    {
        return \Configuration::get(
            PaypalAccount::PS_CHECKOUT_PAYPAL_EMAIL_STATUS,
            null,
            null,
            (int) \Context::getContext()->shop->id
        );
    }

    /**
     * Get the paypal payment method status for the current merchant
     *
     * @return string|bool
     */
    public function getPaypalPaymentStatus()
    {
        return \Configuration::get(
            PaypalAccount::PS_CHECKOUT_PAYPAL_PAYMENT_STATUS,
            null,
            null,
            (int) \Context::getContext()->shop->id
        );
    }

    /**
     * Get the card payment status for the current merchant
     *
     * @return string|bool
     */
    public function getCardHostedFieldsStatus()
    {
        return \Configuration::get(
            PaypalAccount::PS_CHECKOUT_CARD_HOSTED_FIELDS_STATUS,
            null,
            null,
            (int) \Context::getContext()->shop->id
        );
    }

    /**
     * @return bool
     */
    public function isCreditOrDebitCardsEnabled()
    {
        return (bool) \Configuration::get(
            PaypalAccount::PS_CHECKOUT_FUNDING_SOURCE_CARDS_ENABLED,
            null,
            null,
            (int) \Context::getContext()->shop->id,
            true
        );
    }

    /**
     * @return bool
     */
    public function isPayPalCreditEnabled()
    {
        return (bool) \Configuration::get(
            PaypalAccount::PS_CHECKOUT_FUNDING_SOURCE_PAYPAL_CREDIT_ENABLED,
            null,
            null,
            (int) \Context::getContext()->shop->id,
            true
        );
    }

    /**
     * @return bool
     */
    public function isVenmoEnabled()
    {
        return (bool) \Configuration::get(
            PaypalAccount::PS_CHECKOUT_FUNDING_SOURCE_VENMO_ENABLED,
            null,
            null,
            (int) \Context::getContext()->shop->id,
            true
        );
    }

    /**
     * @return bool
     */
    public function isSepaLastschriftEnabled()
    {
        return (bool) \Configuration::get(
            PaypalAccount::PS_CHECKOUT_FUNDING_SOURCE_SEPA_LASTSCHRIFT_CREDIT_ENABLED,
            null,
            null,
            (int) \Context::getContext()->shop->id,
            true
        );
    }

    /**
     * @return bool
     */
    public function isBancontactEnabled()
    {
        return (bool) \Configuration::get(
            PaypalAccount::PS_CHECKOUT_FUNDING_SOURCE_BANCONTACT_ENABLED,
            null,
            null,
            (int) \Context::getContext()->shop->id,
            true
        );
    }

    /**
     * @return bool
     */
    public function isEpsEnabled()
    {
        return (bool) \Configuration::get(
            PaypalAccount::PS_CHECKOUT_FUNDING_SOURCE_EPS_ENABLED,
            null,
            null,
            (int) \Context::getContext()->shop->id,
            true
        );
    }

    /**
     * @return bool
     */
    public function isGiropayEnabled()
    {
        return (bool) \Configuration::get(
            PaypalAccount::PS_CHECKOUT_FUNDING_SOURCE_GIROPAY_ENABLED,
            null,
            null,
            (int) \Context::getContext()->shop->id,
            true
        );
    }

    /**
     * @return bool
     */
    public function isIdealEnabled()
    {
        return (bool) \Configuration::get(
            PaypalAccount::PS_CHECKOUT_FUNDING_SOURCE_IDEAL_ENABLED,
            null,
            null,
            (int) \Context::getContext()->shop->id,
            true
        );
    }

    /**
     * @return bool
     */
    public function isMyBankEnabled()
    {
        return (bool) \Configuration::get(
            PaypalAccount::PS_CHECKOUT_FUNDING_SOURCE_MYBANK_ENABLED,
            null,
            null,
            (int) \Context::getContext()->shop->id,
            true
        );
    }

    /**
     * @return bool
     */
    public function isPrzelewy24Enabled()
    {
        return (bool) \Configuration::get(
            PaypalAccount::PS_CHECKOUT_FUNDING_SOURCE_PRZELEWY24_ENABLED,
            null,
            null,
            (int) \Context::getContext()->shop->id,
            true
        );
    }

    /**
     * @return bool
     */
    public function isSofortEnabled()
    {
        return (bool) \Configuration::get(
            PaypalAccount::PS_CHECKOUT_FUNDING_SOURCE_SOFORT_ENABLED,
            null,
            null,
            (int) \Context::getContext()->shop->id,
            true
        );
    }
}
