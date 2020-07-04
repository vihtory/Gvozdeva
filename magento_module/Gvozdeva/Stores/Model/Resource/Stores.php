<?php

class Gvozdeva_Stores_Model_Resource_Stores extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize resources
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('stores/stores', 'id');
    }

    /**
     * Get city array
     *
     * @return array
     */
    public function getCityList()
    {
        $adapter = $this->_getReadAdapter();
        $tableName = $this->getTable('stores/stores');
        $selectCity = $adapter->select()
            ->from(
                $tableName,
                'city'
            )
            ->distinct();
        return $adapter->fetchCol($selectCity);
    }
}
