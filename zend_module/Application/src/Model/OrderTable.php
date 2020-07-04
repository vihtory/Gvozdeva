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



class OrderTable extends Model\ModelTable
{
    public function setTotal($orderId, $total)
    {
        $this->_tableGateway->update(['total' => $total],['id = ?' => $orderId]);
    }

}
