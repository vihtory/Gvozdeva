<?php
class Gvozdeva_Stores_Block_Adminhtml_Stores extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /**
     * Block constructor
     */
    public function __construct()
    {
        $this->_controller = 'adminhtml_stores';
        $this->_headerText = Mage::helper('stores')->__('Manage stores');
        $this->_blockGroup = 'stores';

        parent::__construct();

        $this->_updateButton('add', 'label', Mage::helper('stores')->__('Add New Store'));
        $this->_addButton('stores_load', [
            'label'     => $this->__('Load Stores'),
            'onclick'   => 'setLocation(\'' . Mage::getSingleton('stores/api')->importStores() .'\')'
        ]);
        $this->_addButton('export_product', [
            'label'     => $this->__('Export Catalog'),
            'onclick'   => 'setLocation(\'' . Mage::getSingleton('stores/api')->exportCatalog() .'\')'
        ]);
        $this->_addButton('import_store_product', [
            'label'     => $this->__('Import store product'),
            'onclick'   => 'setLocation(\'' . Mage::getSingleton('stores/api')->importStoreProduct() .'\')'
        ]);
    }

}
