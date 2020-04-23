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

class PrestaShopOrderState
{
    /**
     * @var string
     */
    private $configurationKey;

    /**
     * @var array
     */
    private $name;

    /**
     * @var string Display state in the specified color
     */
    private $color;

    /**
     * @var bool
     */
    private $logable;

    /**
     * @var bool
     */
    private $hidden;

    /**
     * @var bool
     */
    private $paid;

    /**
     * @var bool
     */
    private $invoice;

    /**
     * @var bool
     */
    private $pdf_invoice;

    /**
     * @var bool
     */
    private $shipped;

    /**
     * @var bool
     */
    private $delivery;

    /**
     * @var bool
     */
    private $pdf_delivery;

    /**
     * @var bool
     */
    private $unremovable;

    /**
     * @var bool Send an e-mail to customer ?
     */
    private $send_email;

    /**
     * @var string
     */
    private $template;

    /**
     * @var bool
     */
    private $deleted;

    /**
     * @param string $configurationKey
     * @param array $name
     * @param string $color
     * @param bool $logable
     * @param bool $hidden
     * @param bool $paid
     * @param bool $invoice
     * @param bool $pdf_invoice
     * @param bool $shipped
     * @param bool $delivery
     * @param bool $pdf_delivery
     * @param bool $unremovable
     * @param bool $send_email
     * @param string $template
     * @param bool $deleted
     */
    public function __construct(
        $configurationKey,
        array $name,
        $color,
        $logable,
        $hidden,
        $paid,
        $invoice,
        $pdf_invoice,
        $shipped,
        $delivery,
        $pdf_delivery,
        $unremovable,
        $send_email = false,
        $template = '',
        $deleted = false
    ) {
        $this->configurationKey = $configurationKey;
        $this->name = $name;
        $this->color = $color;
        $this->logable = $logable;
        $this->hidden = $hidden;
        $this->paid = $paid;
        $this->invoice = $invoice;
        $this->pdf_invoice = $pdf_invoice;
        $this->shipped = $shipped;
        $this->delivery = $delivery;
        $this->pdf_delivery = $pdf_delivery;
        $this->unremovable = $unremovable;
        $this->send_email = $send_email;
        $this->template = $template;
        $this->deleted = $deleted;
    }

    /**
     * @return string
     */
    public function getConfigurationKey()
    {
        return $this->configurationKey;
    }

    /**
     * @return array
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @return bool
     */
    public function isSendEmail()
    {
        return $this->send_email;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @return bool
     */
    public function isLogable()
    {
        return $this->logable;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return $this->hidden;
    }

    /**
     * @return bool
     */
    public function isPaid()
    {
        return $this->paid;
    }

    /**
     * @return bool
     */
    public function isInvoice()
    {
        return $this->invoice;
    }

    /**
     * @return bool
     */
    public function isPdfInvoice()
    {
        return $this->pdf_invoice;
    }

    /**
     * @return bool
     */
    public function isShipped()
    {
        return $this->shipped;
    }

    /**
     * @return bool
     */
    public function isDelivery()
    {
        return $this->delivery;
    }

    /**
     * @return bool
     */
    public function isPdfDelivery()
    {
        return $this->pdf_delivery;
    }

    /**
     * @return bool
     */
    public function isUnremovable()
    {
        return $this->unremovable;
    }

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return $this->deleted;
    }
}
