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



class ProductTable extends Model\ModelTable
{
    public function getStoreProductList($storeId = null)
    {
        $sqlSelect = $this->_tableGateway->getSql()->select();
        $sqlSelect
            ->join(
            'store_product',
            'store_product.product_id = products.id',
            ['store_id', 'price', 'qty']
        );
//        $sqlSelect->where(['store_product.qty > ?' => 0]);
        if (!is_null($storeId)) {
            $sqlSelect->where(['store_product.store_id = ?' => $storeId]);
        }
        $resultSet = $this->_tableGateway->selectWith($sqlSelect);
        $resultSet->buffer();
        return $resultSet;
    }
    public function getAllProductList()
    {
        $sqlSelect = $this->_tableGateway->getSql()->select();
        $sqlSelect
            ->join(
                'store_product',
                'store_product.product_id = products.id',
                ['store_id', 'price', 'qty']
            );
        $resultSet = $this->_tableGateway->selectWith($sqlSelect);
        return $resultSet;
    }

    public function loadBySku($id)
    {
        try {
            $rowSet = $this->_tableGateway->select(['sku' => $id]);
            $row = $rowSet->current();
            if (!$row) {
                return null;
            }

            return $row;
        } catch (Exception $e) {
        }
    }

}
