<?php

class Gvozdeva_Stores_Model_Resource_Stores_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
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
     * Add status filter
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function addActiveFilter()
    {
        return $this->addFieldToFilter('status', ['eq' => Gvozdeva_Stores_Model_Source_Status::ENABLED]);
    }

    /**
     * Add city filter
     *
     * @param string $city
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function addCityFilter($city)
    {
        return $this->addFieldToFilter('city', [$city]);
    }
}
