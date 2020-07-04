<?php

try {
    $installer = $this;

    $installer->startSetup();

    if (!$installer->getConnection()->isTableExists($installer->getTable('stores/stores'))) {
        $table = $installer->getConnection()
            ->newTable($installer->getTable('stores/stores'))
            ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
                'identity'  => true,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
            ], 'Id')
            ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, [
                'nullable'  => false
            ], 'Title')
            ->addColumn('address', Varien_Db_Ddl_Table::TYPE_TEXT, 255, [
                'nullable'  => false
            ], 'Address')
            ->addColumn('working_hours', Varien_Db_Ddl_Table::TYPE_TEXT, 255, [
                'default'   => '0'
            ], 'Working hours')
            ->addColumn('city', Varien_Db_Ddl_Table::TYPE_TEXT, 63, [], 'City')
            ->addColumn('status', Varien_Db_Ddl_Table::TYPE_SMALLINT, [], 'Status')
            ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, [], 'Description')
            ->addColumn('image', Varien_Db_Ddl_Table::TYPE_TEXT, 255, [], 'Image')
            ->setComment('Preconfigured Stores');
        $installer->getConnection()->createTable($table);
    }
    $installer->endSetup();
} catch (Exception $ex) {
    Mage::logException($ex->getMessage());
}
