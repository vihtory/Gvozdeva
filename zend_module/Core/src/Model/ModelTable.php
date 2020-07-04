<?php

namespace Core\Model;

use PHPUnit\Exception;
use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\ResultSet\ResultSetInterface;

class ModelTable
{
    protected $_tableGateway;
    protected $_idColumnName = 'id';

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->_tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->_tableGateway->select();
    }

    public function load($id)
    {
        try {
            $id = (int)$id;
            $rowSet = $this->_tableGateway->select([$this->_idColumnName => $id]);
            $row = $rowSet->current();
            if (!$row) {
                return null;
            }

            return $row;
        } catch (Exception $e) {
            }
    }

    public function delete($id)
    {
        $this->_tableGateway->delete([$this->_idColumnName => (int) $id]);
    }

    public function save($data)
    {
        $this->_tableGateway->insert($data);
        return $this->_tableGateway->getLastInsertValue();
    }
}
