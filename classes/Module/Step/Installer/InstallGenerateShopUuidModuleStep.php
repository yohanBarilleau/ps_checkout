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
use PrestaShop\Module\PrestashopCheckout\ShopUuidManager;

class InstallGenerateShopUuidModuleStep extends AbstractModuleStep
{
    /**
     * @var ShopUuidManager
     */
    private $shopUuidManager;

    /**
     * @param ShopUuidManager $shopUuidManager
     */
    public function __construct(ShopUuidManager $shopUuidManager)
    {
        $this->shopUuidManager = $shopUuidManager;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $result = $this->shopUuidManager->generateForAllShops();

        if (false === $result) {
            throw new ModuleStepException($this->module->l('Failed to generate ShopUuid', 'translations'));
        }

        return $result;
    }
}
