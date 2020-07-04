<?php

namespace Application\Model;
use Core\Model;

class Order extends Model\Model
{
    private $_id;
    private $_phone;
    private $_name;
    private $_createdAt;
    private $_storeId;
    private $_salerId;
    private $_total;
    private $_email;

    public function exchangeArray($data)
    {
        $this->setId((!empty($data['id'])) ? $data['id'] : null)
            ->setName((!empty($data['name'])) ? $data['name'] : null);
    }
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }
    public function setSalerId($salerId)
    {
        $this->_salerId = $salerId;
        return $this;
    }

    public function getSalerId()
    {
        return $this->_salerId;
    }

    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->_name;
    }
    public function setPhone($phone)
    {
        $this->_phone = $phone;
        return $this;
    }

    public function getPhone()
    {
        return $this->_phone;
    }

    public function setEmail($email)
    {
        $this->_email = $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->_email;
    }
    public function setStoreId($storeId)
    {
        $this->_storeId = $storeId;
        return $this;
    }

    public function getStoreId()
    {
        return $this->_storeId;
    }

    public function setCreatedAt($createdAt)
    {
        $this->_createdAt = $createdAt;
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->_createdAt;
    }

}
