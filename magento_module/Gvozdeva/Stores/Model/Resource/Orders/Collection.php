<?php

class Gvozdeva_Stores_Model_Resource_Orders_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract
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
