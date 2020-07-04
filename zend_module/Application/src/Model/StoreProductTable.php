<?php

namespace Application\Model;

use RuntimeException;
use Core\Model;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Session\SessionManager;
use Zend\Authentication\Storage\Session;
use Zend\Authentication\Storage\StorageInterface;



class StoreProductTable extends Model\ModelTable
{
    public function updateQty($productId, $storeId, $qty)
    {
        $where = [
          'product_id = ?' => $productId,
          'store_id = ?'   => $storeId
        ];
        $select = $this->_tableGateway->getSql()->select()
            ->where(['product_id = ?' => $productId])
            ->where(['store_id = ?'   => $storeId]);
        $oldQty = $this->_tableGateway->selectWith($select)->current()->getQty();
        $this->_tableGateway->update(['qty' => $oldQty + $qty], $where);
    }

    public function getStoreProduct($productId, $storeId)
    {
        $select = $this->_tableGateway->getSql()->select()
            ->where(['product_id = ?' => $productId])
            ->where(['store_id = ?'   => $storeId]);
        return $this->_tableGateway->selectWith($select)->current();
    }

}
