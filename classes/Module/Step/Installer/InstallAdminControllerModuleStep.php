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
use PrestaShop\Module\PrestashopCheckout\Module\ValueObject\PrestaShopAdminController;

class InstallAdminControllerModuleStep extends AbstractModuleStep
{
    /**
     * @var PrestaShopAdminController[]
     */
    private $adminControllers;

    /**
     * @param PrestaShopAdminController[] $adminControllers
     */
    public function __construct(array $adminControllers)
    {
        $this->adminControllers = $adminControllers;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $result = true;

        foreach ($this->adminControllers as $adminController) {
            if (\Tab::getIdFromClassName($adminController->getClassName())) {
                continue;
            }

            $tab = new \Tab();
            $tab->module = $this->module->name;
            $tab->name = $adminController->getName();
            $tab->class_name = $adminController->getClassName();
            $tab->id_parent = $adminController->getIdParent();
            $tab->position = $adminController->getPosition();
            $tab->active = $adminController->isActive();
            $tab->hide_host_mode = $adminController->isHideHostMode();

            if (property_exists('Tab', 'enabled')) {
                $tab->enabled = $adminController->isEnabled();
            }

            if (property_exists('Tab', 'route_name')) {
                $tab->route_name = $adminController->getRouteName();
            }

            if (property_exists('Tab', 'icon')) {
                $tab->icon = $adminController->getIcon();
            }

            $result = $result && (bool) $tab->add();

            if (false === $result) {
                throw new ModuleStepException($this->module->l('Failed to install admin controller', 'translations') . ' ' . $adminController['class']);
            }
        }

        return $result;
    }
}
