<?php

class Gvozdeva_Stores_Block_Offers extends Mage_Catalog_Block_Product_Abstract
{
    /**
     * Get store products
     *
     * @return mixed
     * @throws Exception
     */
    public function getCollection()
    {
        return Mage::getModel('stores/offers')
            ->getListStoreProducts($this->getRequest()->getParam('id'));
    }

    /**
     * get Qty for store product
     *
     * @param string $productId
     * @return mixed
     * @throws Exception
     */
    public function getQty($productId)
    {
        return Mage::getModel('stores/offers')
            ->loadByParams($this->getRequest()->getParam('id'), $productId)->getQty();
    }
}
