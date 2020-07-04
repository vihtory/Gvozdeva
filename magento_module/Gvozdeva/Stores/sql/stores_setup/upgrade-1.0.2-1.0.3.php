<?php
try {
    $installer = $this;
    $installer->startSetup();


    $table = $installer->getConnection()
        ->newTable($this->getTable('stores/offers'))
        ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ], 'Id')
        ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, [
            'unsigned'  => true,
            'nullable'  => false,
            'references'  => true
        ], 'Store Id')
        ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, [
            'unsigned'  => true,
            'nullable'  => false,
            'references'  => true
        ], 'Product Id')
        ->addColumn('qty', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, [
            'unsigned'  => true,
            'nullable'  => false
        ], 'Product Id')
        ->addForeignKey($installer->getFkName('stores/stores', 'id',
            'stores/offers', 'store_id'),
            'store_id', $installer->getTable('stores/stores'),
            'id', Varien_Db_Ddl_Table::ACTION_CASCADE,
            Varien_Db_Ddl_Table::ACTION_CASCADE
        )

        ->addForeignKey($installer->getFkName('catalog/product', 'entity_id',
            'stores/offers', 'product_id'),
            'product_id', $installer->getTable('catalog/product'),
            'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE,
            Varien_Db_Ddl_Table::ACTION_CASCADE
        );

    $installer->getConnection()->createTable($table);

    $installer->endSetup();
} catch (Exception $ex) {
}
