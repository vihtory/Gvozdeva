<?php

try {
    $installer = $this;
    $installer->startSetup();

    $installer->getConnection()->addColumn($installer->getTable('stores/stores'), 'code', [
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'    => 4,
        'comment'   => 'Store code',
        'nullable'  => false
    ]);

    $installer->endSetup();
} catch (Exception $ex) {
}
