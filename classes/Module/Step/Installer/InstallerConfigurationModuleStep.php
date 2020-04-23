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
use PrestaShop\Module\PrestashopCheckout\Module\ValueObject\PrestaShopConfiguration;

class InstallerConfigurationModuleStep extends AbstractModuleStep
{
    /**
     * @var PrestaShopConfiguration[]
     */
    private $prestaShopConfigurations;

    /**
     * @param PrestaShopConfiguration[] $prestaShopConfigurations
     */
    public function __construct(array $prestaShopConfigurations)
    {
        $this->prestaShopConfigurations = $prestaShopConfigurations;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $result = true;

        foreach ($this->prestaShopConfigurations as $prestaShopConfiguration) {
            if (false === $this->isConfigurationAlreadyExist($prestaShopConfiguration->getName(), $prestaShopConfiguration->getIdShop(), $prestaShopConfiguration->getIdShopGroup())) {
                $result = $result && $this->addConfiguration(
                    $prestaShopConfiguration->getName(),
                    $prestaShopConfiguration->getValue(),
                    $prestaShopConfiguration->isHtmlAllowed(),
                    $prestaShopConfiguration->getIdShop(),
                    $prestaShopConfiguration->getIdShopGroup()
                );

                if (false === $result) {
                    throw new ModuleStepException($this->module->l('Failed to install configuration', 'translations') . ' ' . $prestaShopConfiguration->getName());
                }
            }
        }

        return $result;
    }

    /**
     * @param string $name
     * @param int|null $shopIdentifier
     * @param int|null $shopGroupIdentifier
     *
     * @return bool
     */
    private function isConfigurationAlreadyExist($name, $shopIdentifier, $shopGroupIdentifier)
    {
        return (bool) \Configuration::hasKey($name, null, $shopGroupIdentifier, $shopIdentifier);
    }

    /**
     * @param string $name
     * @param string|string[] $value
     * @param bool $isHtmlAllowed
     * @param int|null $shopIdentifier
     * @param int|null $shopGroupIdentifier
     *
     * @return bool
     */
    private function addConfiguration($name, $value, $isHtmlAllowed, $shopIdentifier, $shopGroupIdentifier)
    {
        return (bool) \Configuration::updateValue(
            $name,
            $value,
            $isHtmlAllowed,
            $shopGroupIdentifier,
            $shopIdentifier
        );
    }
}
