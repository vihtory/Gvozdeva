<?php
class Gvozdeva_Stores_Block_Filter extends Mage_Core_Block_Template
{
    /**
     * Return city list for filter stores
     *
     * @return array
     */
    public function getCityList()
    {
        return Mage::getResourceModel('stores/stores')->getCityList();
    }
}
