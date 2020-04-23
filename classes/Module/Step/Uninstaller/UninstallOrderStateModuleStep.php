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

namespace PrestaShop\Module\PrestashopCheckout\Module\Step\Uninstaller;

use PrestaShop\Module\PrestashopCheckout\Module\Step\AbstractModuleStep;
use PrestaShop\Module\PrestashopCheckout\Module\Step\ModuleStepException;

class UninstallOrderStateModuleStep extends AbstractModuleStep
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $result = true;

        $orderStateCollection = new \PrestaShopCollection('OrderState');
        $orderStateCollection->where('module_name', '=', $this->module->name);

        foreach ($orderStateCollection->getAll() as $orderState) {
            /* @var \OrderState $orderState */
            $orderState->deleted = true;
            $result = $result && (bool) $orderState->save();

            if (false === $result) {
                throw new ModuleStepException($this->module->l('Failed to uninstall order state', 'translations') . ' #' . $orderState->id);
            }
        }

        return $result;
    }
}
