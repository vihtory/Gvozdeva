<?php

class Gvozdeva_Stores_Block_Adminhtml_Stores_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Initialize cms page edit block
     *
     * @return void
     */
    public function __construct()
    {
        $this->_objectId   = 'id';
        $this->_controller = 'adminhtml_stores';
        $this->_blockGroup = 'stores';

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('stores')->__('Save Store'));

        $this->_updateButton('delete', 'label', Mage::helper('stores')->__('Delete Store'));

    }

    /**
     * Retrieve text for header element depending on loaded page
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('stores')->getId()) {
            return Mage::helper('stores')
                ->__("Edit Store '%s'", $this->escapeHtml(Mage::registry('stores')->getTitle()));
        } else {
            return Mage::helper('stores')->__('New Store');
        }
    }

    /**
     * Get url save action
     *
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save');
    }
}
