<?php

class Gvozdeva_Stores_Block_View extends Mage_Core_Block_Template
{
    /**
     * Return view store
     *
     * @return object
     * @throws Exception
     */
    public function getStore()
    {
        return Mage::getModel('stores/stores')->load($this->getRequest()->getParam('id'));
    }

    /**
     * Get meta data to front
     *
     * @return Mage_Core_Block_Abstract
     * @throws Exception
     */
    protected function _prepareLayout()
    {
        $head = $this->getLayout()->getBlock('head');
        $store = $this->getStore();
        if ($title = $store->getMetaTitle()) {
            $head->setTitle($title);
        }
        if ($keywords = $store->getMetaKeywords()) {
            $head->setKeywords($keywords);
        }
        if ($description = $store->getMetaDescription()) {
            $head->setDescription($description);
        }
        return parent::_prepareLayout();
    }
}
