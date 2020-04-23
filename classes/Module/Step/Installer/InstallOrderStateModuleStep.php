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

namespace PrestaShop\Module\PrestashopCheckout\Module\Step\Installer;

use PrestaShop\Module\PrestashopCheckout\Module\Step\AbstractModuleStep;
use PrestaShop\Module\PrestashopCheckout\Module\Step\ModuleStepException;
use PrestaShop\Module\PrestashopCheckout\Module\ValueObject\PrestaShopOrderState;

class InstallOrderStateModuleStep extends AbstractModuleStep
{
    /**
     * @var PrestaShopOrderState[]
     */
    private $prestaShopOrderStates;

    /**
     * @param PrestaShopOrderState[] $prestaShopOrderStates
     */
    public function __construct(array $prestaShopOrderStates)
    {
        $this->prestaShopOrderStates = $prestaShopOrderStates;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $result = true;

        foreach ($this->prestaShopOrderStates as $prestaShopOrderState) {
            $orderState = new \OrderState();
            $orderState->module_name = $this->module->name;
            $orderState->send_email = $prestaShopOrderState->isSendEmail();
            $orderState->color = $prestaShopOrderState->getColor();
            $orderState->logable = $prestaShopOrderState->isLogable();
            $orderState->invoice = $prestaShopOrderState->isInvoice();
            $orderState->template = $prestaShopOrderState->getTemplate();
            $orderState->hidden = $prestaShopOrderState->isHidden();
            $orderState->shipped = $prestaShopOrderState->isShipped();
            $orderState->paid = $prestaShopOrderState->isPaid();
            $orderState->delivery = $prestaShopOrderState->isDelivery();
            $orderState->unremovable = $prestaShopOrderState->isUnremovable();
            $orderState->pdf_delivery = $prestaShopOrderState->isPdfDelivery();
            $orderState->pdf_invoice = $prestaShopOrderState->isPdfInvoice();
            $orderState->deleted = $prestaShopOrderState->isDeleted();
            $orderState->name = $prestaShopOrderState->getName();
            $result = $result && (bool) $orderState->add();

            if (false === $result) {
                throw new ModuleStepException($this->module->l('Failed to install order state', 'translations') . ' ' . $prestaShopOrderState->getConfigurationKey());
            }

            \Configuration::updateGlobalValue($prestaShopOrderState->getConfigurationKey(), (int) $orderState->id);

            $orderStateImgPath = $this->module->getLocalPath() . 'views/img/state/' . $prestaShopOrderState->getConfigurationKey() . '.gif';

            if (file_exists($orderStateImgPath)) {
                \Tools::copy(
                    $orderStateImgPath,
                    _PS_ORDER_STATE_IMG_DIR_ . $orderState->id . '.gif'
                );
            }
        }

        return $result;
    }
}
