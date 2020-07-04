<?php

class Gvozdeva_Stores_Model_Stores extends Mage_Core_Model_Abstract
{
    const DIRECTORY_IMAGE = 'stores';
    /**
     * Initialize resources
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('stores/stores');
    }

    /**
     * Get directory for save image
     *
     * @return string
     */
    public function getImageDirectory()
    {
        return Mage::getBaseDir('media') . DS  . self::DIRECTORY_IMAGE;
    }

    /**
     * load by code
     *
     * @return $this
     */
    public function loadByCode($code)
    {
        return $this->load($code, 'code');
    }

    /**
     * Get url store's image
     *
     * @param string $image
     * @return string
     */
    public function getImageUrl($image)
    {
        if ($image != "") {
            return Mage::getBaseUrl('media') . $image;
        }
    }
}
