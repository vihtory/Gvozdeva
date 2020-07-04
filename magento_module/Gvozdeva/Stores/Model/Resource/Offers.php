<?php
class Gvozdeva_Stores_Model_Resource_Offers extends Mage_Core_Model_Resource_Db_Abstract
{
    const SEPARATOR = '&';
    private $_tableOffers;
    /**
     * Initialize resources
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('stores/offers', 'id');
        $this->_tableOffers = $this->getTable('stores/offers');
    }

    /**
     * Products left join stores
     *
     * @param array  $collection
     * @param string $storeId
     * @return void
     */
    public function leftJoinStores($collection, $storeId)
    {
        $collection
            ->joinField('position',
                'stores/offers',
                'store_id',
                'product_id=entity_id',
                'store_id=' . (int) $storeId,
                'left');
    }

    /**
     * Products join stores
     *
     * @param array  $collection
     * @param string $storeId
     * @return void
     */
    public function innerJoinStores($collection, $storeId)
    {
        $collection->joinField('position',
                'stores/offers',
                'store_id',
                'product_id=entity_id',
                'store_id=' . (int) $storeId,
                'inner');

    }

    /**
     * Get products collection
     *
     * @return mixed
     */
    public function getCollectionProducts()
    {
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect(['name', 'sku', 'price']);
        return $collection;
    }

    /**
     * Add attribute image to products collection
     *
     * @param array $collection
     * @return mixed
     */
    public function addImageToCollection($collection)
    {
        $collection->addAttributeToSelect('image');
    }

    /**
     * Get selected products id
     *
     * @param string $storeId
     * @return array
     */
    public function getSelectedProducts($storeId)
    {
        $adapter = $this->_getReadAdapter();
        $select = $adapter->select()
            ->from(
                $this->_tableOffers,
                'product_id'
            )
            ->where('store_id = ?', $storeId);
        return $adapter->fetchCol($select);
    }

    /**
     * Delete all store's products from database
     *
     * @param string $storeId
     * @return void
     */
    protected function _deleteStoreProducts($storeId)
    {
        $adapter = $this->_getWriteAdapter();
        $where = $adapter->quoteInto('store_id = ?', $storeId);
        $adapter->delete($this->_tableOffers, $where);
    }

    /**
     * Insert selected products
     *
     * @param string $storeId
     * @param string $productsId
     * @return void
     */
    public function insertSelectedProducts($storeId, $productsId)
    {
        $adapter = $this->_getWriteAdapter();
        $this->_deleteStoreProducts($storeId);
        if ($productsId != '') {
            $products = explode(self::SEPARATOR, $productsId);
            $resultMass = [];
            foreach ($products as $product) {
                $resultMass[] = [
                    'store_id'   => (int)$storeId,
                    'product_id' => $product
                ];
            }
            $adapter->insertMultiple($this->_tableOffers, $resultMass);
        }
    }

    /**
     * get product qty in stores
     *
     * @param $productId
     * @return mixed
     */
    public function getStoresQtyForProduct($productId)
    {
        $collection = Mage::getModel('stores/offers')
            ->getCollection()->addFieldToFilter('product_id', $productId);
        $collection->getSelect()
            ->join([ $this->getTable('stores/stores') => 'stores'],
                'main_table.store_id = stores.id',['stores.title', 'stores.id']);
        return $collection;

    }
}
