<?php

class Gvozdeva_Stores_Model_Offers extends Mage_Core_Model_Abstract
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

    /**
     * Get collection product to front
     *
     * @param string $storeId
     * @return mixed
     */
    public function getListStoreProducts($storeId)
    {
        $collection = $this->getResource()->getCollectionProducts();
        $this->getResource()->addImageToCollection($collection);
        $this->getResource()->innerJoinStores($collection, $storeId);
        return $collection;
    }

    /**
     * Get collection product to admin panel
     *
     * @param string $storeId
     * @return mixed
     */
    public function getGridStoreProducts($storeId)
    {
        $collection = $this->getResource()
            ->getCollectionProducts();
        $this->getResource()
            ->leftJoinStores($collection, $storeId);
        return $collection;
    }

    /**
     * load by params
     *
     * @param string $storeId
     * @param string $productId
     * @return mixed
     */
    public function loadByParams($storeId, $productId)
    {
        return $this->getCollection()
            ->addParamFilter($storeId, $productId)
            ->getFirstItem();
    }
}
