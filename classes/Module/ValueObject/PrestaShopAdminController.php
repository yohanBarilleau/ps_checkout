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

class PrestaShopAdminController
{
    /**
     * @var string[]
     */
    private $name;

    /**
     * @var string
     */
    private $class_name;

    /**
     * @var int
     */
    private $id_parent;

    /**
     * @var bool
     */
    private $active;

    /**
     * @var int
     */
    private $position;

    /**
     * @var bool
     */
    private $hide_host_mode;

    /**
     * @var string
     *
     * @since PrestaShop 1.7.1.0
     */
    private $icon;

    /**
     * @var bool
     *
     * @since PrestaShop 1.7.7.0
     */
    private $enabled;

    /**
     * @var string Route name for Symfony
     *
     * @since PrestaShop 1.7.7.0
     */
    private $route_name;

    /**
     * @param string[] $name
     * @param string $class_name
     * @param int $id_parent
     * @param bool $active
     * @param int $position
     * @param bool $hide_host_mode
     * @param string $icon
     * @param bool $enabled
     * @param string $route_name
     */
    public function __construct(
        array $name,
        $class_name,
        $id_parent,
        $active,
        $position,
        $hide_host_mode = false,
        $icon = '',
        $enabled = true,
        $route_name = ''
    ) {
        $this->name = $name;
        $this->class_name = $class_name;
        $this->id_parent = $id_parent;
        $this->active = $active;
        $this->position = $position;
        $this->hide_host_mode = $hide_host_mode;
        $this->icon = $icon;
        $this->enabled = $enabled;
        $this->route_name = $route_name;
    }

    /**
     * @return string[]
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->class_name;
    }

    /**
     * @return int
     */
    public function getIdParent()
    {
        return $this->id_parent;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return bool
     */
    public function isHideHostMode()
    {
        return $this->hide_host_mode;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @return string
     */
    public function getRouteName()
    {
        return $this->route_name;
    }
}
