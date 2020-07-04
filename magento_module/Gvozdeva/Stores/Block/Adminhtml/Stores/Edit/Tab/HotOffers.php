<?php
class Gvozdeva_Stores_Block_Adminhtml_Stores_Edit_Tab_HotOffers
    extends Mage_Adminhtml_Block_Widget_Grid
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    private $_selectedProducts = null;
    private $_storeId;

    /**
     * Gvozdeva_Stores_Block_Adminhtml_Stores_Edit_Tab_HotOffers constructor.
     *
     * @throws Exception
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('adminhtml_stores_edit_tab_hot_offers');
        $this->setUseAjax(true);
        $this->_storeId = $this->getRequest()->getParam('id');
    }

    /**
     * Get tab Url
     *
     * @return string
     */
    public function getTabUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }

    /**
     * Get Grid Url
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/offers', ['_current' => true]);
    }

    /**
     * Get tab class
     *
     * @return string
     */
    public function getTabClass()
    {
        return 'ajax';
    }

    /**
     * Set product collection
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     * @throws Exception
     */
    protected function _prepareCollection()
    {
        if ($this->getRequest()->getParam('id')) {
            $this->setDefaultFilter(['in_store' => 1]);
        }
        $collection = Mage::getModel('stores/offers')
            ->getGridStoreProducts($this->_storeId);
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Filter collection
     *
     * @param string $column
     * @return $this|Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_store') {
            $productIds = $this->getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', ['in' => $productIds]);
            } elseif (!empty($productIds)) {
                $this->getCollection()->addFieldToFilter('entity_id', ['nin' => $productIds]);
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    /**
     * Columns grid products
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     * @throws Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn('in_store', [
            'header_css_class' => 'a-center',
            'type'      => 'checkbox',
            'name'      => 'in_store',
            'values'    => $this->getSelectedProducts(),
            'align'     => 'center',
            'index'     => 'entity_id'
        ]);
        $this->addColumn('entity_id', [
            'header'    => $this->__('ID'),
            'sortable'  => true,
            'width'     => '60',
            'index'     => 'entity_id'
        ]);
        $this->addColumn('name', [
            'header'    => $this->__('Name'),
            'index'     => 'name'
        ]);
        $this->addColumn('sku', [
            'header'    => $this->__('SKU'),
            'width'     => '80',
            'index'     => 'sku'
        ]);

        return parent::_prepareColumns();
    }

    /**
     * Get check products
     *
     * @return array|null
     * @throws Exception
     */
    public function getSelectedProducts()
    {
        $this->_selectedProducts = $this->getRequest()->getParam('selected_products', null);
        if (is_null( $this->_selectedProducts)) {
            $this->_selectedProducts = Mage::getResourceModel('stores/offers')
                ->getSelectedProducts($this->_storeId);
            return $this->_selectedProducts;
        }
        return $this->_selectedProducts;
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('Hot Offers');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Hot Offers');
    }

    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return false
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Get grid class
     *
     * @return string
     */
    public function getClass()
    {
        return 'ajax';
    }
}
