<?php
class Gvozdeva_Stores_Block_Adminhtml_Stores_Edit_Tab_Orders
    extends Mage_Adminhtml_Block_Widget_Grid
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    private $_storeId;

    /**
     * Gvozdeva_Stores_Block_Adminhtml_Stores_Edit_Tab_Orders constructor.
     *
     * @throws Exception
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('adminhtml_stores_edit_tab_orders');
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
        return $this->getUrl('*/*/ordergrid', ['_current' => true]);
    }

    /**
     * Get Grid Url
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/orders', ['_current' => true]);
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
        $collection = Mage::getModel('stores/orders')
            ->getCollection()
            ->addFieldToFilter('store_id', $this->_storeId);
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }


    /**
     * Columns grid products
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     * @throws Exception
     */
    protected function _prepareColumns()
    {

        $this->addColumn('id', [
            'header'    => $this->__('ID'),
            'sortable'  => true,
            'width'     => '60',
            'index'     => 'id'
        ]);
        $this->addColumn('customer_name', [
            'header'    => $this->__('Name'),
            'index'     => 'customer_name'
        ]);

        $this->addColumn('customer_email', [
            'header'    => $this->__('Email'),
            'index'     => 'customer_email'
        ]);
        $this->addColumn('customer_phone', [
            'header'    => $this->__('Total'),
            'index'     => 'customer_phone'
        ]);
        $this->addColumn('total', [
            'header'    => $this->__('Total'),
            'index'     => 'total'
        ]);
        return parent::_prepareColumns();
    }


    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('Orders');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Orders');
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
