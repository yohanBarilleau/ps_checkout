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

namespace PrestaShop\Module\PrestashopCheckout\Module\ValueObject;

class PrestaShopConfiguration
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string|string[]
     */
    private $value;

    /**
     * @var bool
     */
    private $isHtmlAllowed;

    /**
     * @var int|null
     */
    private $id_shop;

    /**
     * @var int|null
     */
    private $id_shop_group;

    /**
     * @param string $name
     * @param string|string[] $value
     * @param bool $isHtmlAllowed
     * @param int|null $id_shop
     * @param int|null $id_shop_group
     */
    public function __construct(
        $name,
        $value,
        $isHtmlAllowed = false,
        $id_shop = null,
        $id_shop_group = null
    ) {
        $this->name = $name;
        $this->value = $value;
        $this->isHtmlAllowed = $isHtmlAllowed;
        $this->id_shop = $id_shop;
        $this->id_shop_group = $id_shop_group;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string|string[]
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isHtmlAllowed()
    {
        return $this->isHtmlAllowed;
    }

    /**
     * @return int|null
     */
    public function getIdShop()
    {
        return $this->id_shop;
    }

    /**
     * @return int|null
     */
    public function getIdShopGroup()
    {
        return $this->id_shop_group;
    }
}
