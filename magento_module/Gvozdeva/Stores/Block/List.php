<?php
class Gvozdeva_Stores_Block_List extends Mage_Core_Block_Template
{
    private $_storesCollection = null;

    /**
     * Get stores collection
     *
     * @return array
     * @throws Exception
     */
    public function getCollection()
    {
        if (is_null($this->_storesCollection)) {
            $this->_storesCollection = Mage::getModel('stores/stores')->getCollection()
                ->addActiveFilter();
        }
        if ($city = $this->getRequest()->getParam('city')) {
            $this->_storesCollection->addCityFilter($city);
        }
        return $this->_storesCollection;
    }

    /**
     * Set pager before html
     *
     * @return Mage_Core_Block_Abstract
     * @throws Exception
     */
    protected function _beforeToHtml()
    {
        $pagerBlock = $this->getChild('pager');

        $pagerBlock->setAvailableLimit([]);
        $pagerBlock->setUseContainer(false)
            ->setShowPerPage(false)
            ->setShowAmounts(false)
            ->setLimit(Mage::helper('stores')->getStoresLimit())
            ->setCollection($this->getCollection());

        return parent::_beforeToHtml();
    }

    /**
     * Get html pager
     *
     * @return string
     * @throws Exception
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    /**
     * Get html filter
     *
     * @return string
     */
    public function getFilterBlock()
    {
        return $this->getChildHtml('filter');
    }
}
