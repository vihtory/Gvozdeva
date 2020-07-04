<?php

try {
    $installer = $this;
    $installer->startSetup();

    $installer->getConnection()->addColumn($installer->getTable('stores/stores'), 'meta_title', [
        'type'    => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'  => 127,
        'comment' => 'Meta title'
    ]);
    $installer->getConnection()->addColumn($installer->getTable('stores/stores'), 'meta_keywords', [
        'type'    => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'  => 255,
        'comment' => 'Meta Keywords'
    ]);
    $installer->getConnection()->addColumn($installer->getTable('stores/stores'), 'meta_description', [
        'type'    => Varien_Db_Ddl_Table::TYPE_TEXT,
        'comment' => 'Meta Description'
    ]);

    $installer->endSetup();
} catch (Exception $ex) {
}
