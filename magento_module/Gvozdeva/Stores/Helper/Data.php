<?php
class Gvozdeva_Stores_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Get setting "Qty stores on page"
     *
     * @return string
     */
    public function getStoresLimit()
    {
        return Mage::getStoreConfig('general/store_setting/qty_stores');
    }

    /**
     * Get store application url
     *
     * @return string
     */
    public function getStoreApplicationUrl()
    {
        return Mage::getStoreConfig('general/store_setting/store_url');
    }

    /**
     * get stores qty
     *
     * @param string $productId
     * @return mixed
     */
    public function getStoresQty($productId)
    {
        return Mage::getResourceModel('stores/offers')
            ->getStoresQtyForProduct($productId);

    }
}
