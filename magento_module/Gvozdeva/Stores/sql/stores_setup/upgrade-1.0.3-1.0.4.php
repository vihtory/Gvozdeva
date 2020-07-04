
<?php

try {
    $installer = $this;

    $installer->startSetup();

    if (!$installer->getConnection()->isTableExists($installer->getTable('stores/order'))) {
        $table = $installer->getConnection()
            ->newTable($installer->getTable('stores/order'))
            ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
                'identity'  => true,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
            ], 'Id')
            ->addColumn('customer_name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, [], 'Name')
            ->addColumn('customer_email', Varien_Db_Ddl_Table::TYPE_TEXT, 255, [], 'Email')
            ->addColumn('customer_phone', Varien_Db_Ddl_Table::TYPE_TEXT, 11, [], 'Phone')
            ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, [
                'nullable'  => false
            ], 'Store Id')
            ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
                'nullable'  => false
            ], 'Created At')
            ->addColumn('total', Varien_Db_Ddl_Table::TYPE_FLOAT, null, [
                'nullable'  => false
            ], 'Total')
            ->setComment('Store Order')
            ->addForeignKey($installer->getFkName('stores/stores', 'id',
                'stores/order', 'store_id'),
                'store_id', $installer->getTable('stores/stores'),
                'id', Varien_Db_Ddl_Table::ACTION_CASCADE,
                Varien_Db_Ddl_Table::ACTION_CASCADE
            );
        $installer->getConnection()->createTable($table);
    }
    if (!$installer->getConnection()->isTableExists($installer->getTable('stores/order_item'))) {
        $table = $installer->getConnection()
            ->newTable($installer->getTable('stores/order_item'))
            ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
                'identity'  => true,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
            ], 'Id')
            ->addColumn('sku', Varien_Db_Ddl_Table::TYPE_TEXT, 31, [], 'Sku')
            ->addColumn('qty', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, [
                'nullable'  => false
            ], 'Qty')
            ->addColumn('price', Varien_Db_Ddl_Table::TYPE_FLOAT, null, [
                'nullable'  => false
            ], 'Price')
            ->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, [
                'unsigned'  => true,
                'nullable'  => false,
                'references'  => true
            ], 'Order Id')
            ->addForeignKey($installer->getFkName('stores/order', 'id',
                'stores/order', 'order_id'),
                'order_id', $installer->getTable('stores/order'),
                'id', Varien_Db_Ddl_Table::ACTION_CASCADE,
                Varien_Db_Ddl_Table::ACTION_CASCADE
            )
            ->setComment('Store Order');
        $installer->getConnection()->createTable($table);

        $installer->getConnection()->addIndex(
            $installer->getTable('stores/order_item'),
            $installer->getIdxName('stores/order_item', ['sku']),
            ['sku']
        );
    }
    $installer->endSetup();
} catch (Exception $ex) {
    Mage::logException($ex->getMessage());
}
