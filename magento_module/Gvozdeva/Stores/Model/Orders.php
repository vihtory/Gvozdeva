<?php
class Gvozdeva_Stores_Model_Orders extends Mage_Core_Model_Abstract
{
    /**
     * Initialize resources
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('stores/orders');
    }
}
