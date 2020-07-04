<?php

namespace Core\Model;

use Core\Model\ModelTable;

class Model
{
    public function load($id)
    {
        $modelTable = new ModelTable();

        return $modelTable->load($id);
    }

    protected function _getDbAdapter()
    {
        return Zend_Db_Table::getDefaultAdapter();
    }
}
