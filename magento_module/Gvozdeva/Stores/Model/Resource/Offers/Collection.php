<?php

class Gvozdeva_Stores_Model_Resource_Offers_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Initialize resources
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('stores/offers');
    }

    public function addParamFilter($storeId, $productId)
    {
        return $this
            ->addFieldToFilter('product_id', $productId)
            ->addFieldToFilter('store_id', $storeId);
    }
}
