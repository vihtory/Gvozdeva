<?php
class Gvozdeva_Stores_Model_Source_Status
{
    const ENABLED = 1;
    const DISABLED = 0;

    /**
     * Status option for select
     *
     * @return array
     */
    public  function toOptionArray()
    {
        return [
            ['value' => self::ENABLED, 'label' => Mage::helper('stores')->__('Enabled')],
            ['value' => self::DISABLED, 'label' => Mage::helper('stores')->__('Disabled')],
        ];
    }

    /**
     * Status option array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            self::ENABLED => Mage::helper('stores')->__('Enabled'),
            self::DISABLED => Mage::helper('stores')->__('Disabled'),
        ];
    }
}
