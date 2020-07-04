<?php

namespace Application\Model;
use Core\Model;

class Saler extends Model\Model
{
    private $_id;
    private $_email;
    private $_name;
    private $_password;
    private $_storeId;

    public function exchangeArray($data)
    {
        $this->setId((!empty($data['id'])) ? $data['id'] : null)
            ->setEmail((!empty($data['email'])) ? $data['email'] : null)
            ->setName(!empty($data['name']) ? $data['name'] : null)
            ->setPassword((!empty($data['password'])) ? $data['password'] : null)
            ->setStoreId((!empty($data['store_id'])) ? $data['store_id'] : null);
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

    public function setEmail($email)
    {
        $this->_email = $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->_email;
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

    public function setPassword($password)
    {
        $this->_password = $password;
        return $this;
    }

    public function getPassword()
    {
        return $this->_password;
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
}
