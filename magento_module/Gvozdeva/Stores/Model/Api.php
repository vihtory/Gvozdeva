<?php
class Gvozdeva_Stores_Model_Api
{
    /**
     * import stores list
     *
     * @return void
     */
    public function importStores()
    {
        $client = new Varien_Http_Client();
        $client->setUri(Mage::helper('stores')->getStoreApplicationUrl() . 'store')
            ->setMethod(Zend_Http_Client::POST);
        ;
        $response = $client->request();
        $stores = unserialize($response->getBody());
        foreach ($stores as $store)
        {
            $model = Mage::getModel('stores/stores')->loadByCode($store['code']);
            if ($model->getId()) {
                continue;
            }
            $model->setData($store);
            try {
                $model->save();
            } catch (Exception $e) {
                Mage::logException($e);
            }
        }
    }

    /**
     * export catalog
     *
     * @throws Zend_Http_Client_Exception
     * @return void
     */
    public function exportCatalog()
    {
        $products = [];
        $collection = Mage::getModel('catalog/product')->getCollection()->AddAttributeToSelect(['name', 'sku']);
        foreach ($collection as $product)
        {
            if ($product->getTypeId() != 'simple') {
                continue;
            }
            $products[] = [
                'name' => $product->getName(),
                'sku'  => $product->getSku()
            ];
        }
        $client = new Varien_Http_Client();
        $client->setUri(Mage::helper('stores')->getStoreApplicationUrl() . 'catalog')
            ->setParameterPost('products', serialize($products))
            ->setMethod(Zend_Http_Client::POST);
        ;
        $response = $client->request();
    }

    /**
     * import stores
     *
     * @throws Zend_Http_Client_Exception
     * @return void
     */
    public function importStoreProduct()
    {
        $client = new Varien_Http_Client();
        $client->setUri(Mage::helper('stores')->getStoreApplicationUrl() . 'product')
            ->setMethod(Zend_Http_Client::POST);
        $response = $client->request();
        $products = unserialize($response->getBody());
        foreach ($products as $product) {
            $modelProduct = Mage::getModel('catalog/product')
                ->loadByAttribute('sku', $product['sku']);
            $storeModel   = Mage::getModel('stores/stores')->loadByCode($product['code']);
            if (!$modelProduct->getId() || !$storeModel->getId()) {
                continue;
            }
            $offer = Mage::getModel('stores/offers')
                ->loadByParams($storeModel->getId(), $modelProduct->getId());
            try {
                if ($offer->getId()) {
                    $offer->setQty($product['qty'] ?? 0)->save();
                    continue;
                }
                $offer->setStoreId($storeModel->getId())
                    ->setProductId($modelProduct->getId())
                    ->setQty($product['qty'])->save();
            } catch (Exception $e) {
                Mage::logException($e);
            }
        }
    }

}
