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

namespace PrestaShop\Module\PrestashopCheckout\Database;

class TableManager
{
    const TABLE_ORDER_MATRICE = 'pscheckout_order_matrice';

    /**
     * Create table TABLE_ORDER_MATRICE
     *
     * @return bool
     */
    public function createTable()
    {
        $query = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . self::TABLE_ORDER_MATRICE . '` (
            `id_order_matrice` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `id_order_prestashop` int(10) unsigned NOT NULL,
            `id_order_paypal` varchar(20) NOT NULL,
            PRIMARY KEY (`id_order_matrice`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;';

        if (\Db::getInstance()->execute($query) == false) {
            return false;
        }

        return \Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'pscheckout_cart` (
              `id_pscheckout_cart` int unsigned NOT NULL AUTO_INCREMENT,
              `id_cart` int unsigned NOT NULL,
              `paypal_intent` varchar(20) DEFAULT "CAPTURE",
              `paypal_order` varchar(20) NULL,
              `paypal_status` varchar(20) NULL,
              `paypal_funding` varchar(20) NULL,
              `paypal_token` varchar(1024) NULL,
              `paypal_token_expire` datetime NULL,
              `paypal_authorization_expire` datetime NULL,
              `date_add` datetime NOT NULL,
              `date_upd` datetime NOT NULL,
              PRIMARY KEY (`id_pscheckout_cart`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;
        ');
    }

    /**
     * Drop table TABLE_ORDER_MATRICE
     *
     * @return bool
     */
    public function dropTable()
    {
        $query = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . self::TABLE_ORDER_MATRICE . '`';

        if (\Db::getInstance()->execute($query) == false) {
            return false;
        }

        return true;
    }
}
