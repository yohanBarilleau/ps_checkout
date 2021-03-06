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

namespace PrestaShop\Module\PrestashopCheckout\PsxData;

class PsxDataPrepare
{
    private $dataForm;

    public function __construct(array $dataForm)
    {
        $this->setDataForm($dataForm);
    }

    /**
     * Prepare the Data to send to the PSL
     *
     * @return array $data
     */
    public function prepareData()
    {
        $data = $this->getDataForm();

        $data['business_phone'] = str_replace(' ', '', $data['business_phone']);
        $data['business_phone_country'] = (string) $data['business_phone_country'];
        $data['business_address_state'] = (string) $data['business_address_state'];

        return $data;
    }

    /**
     * setDataForm
     *
     * @param array $dataForm
     */
    public function setDataForm(array $dataForm)
    {
        $this->dataForm = $dataForm;
    }

    /**
     * getDataForm
     *
     * @return array
     */
    public function getDataForm()
    {
        return $this->dataForm;
    }
}
