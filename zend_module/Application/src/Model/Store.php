<?php

namespace Application\Model;
use Core\Model;

class Store extends Model\Model
{
    private $_id;
    private $_title;
    private $_code;
    private $_address;

    public function exchangeArray($data)
    {
        $this->setId((!empty($data['id'])) ? $data['id'] : null)
            ->setTitle((!empty($data['title'])) ? $data['title'] : null)
            ->setAddress(!empty($data['address']) ? $data['address'] : null)
            ->setCode((!empty($data['code'])) ? $data['code'] : null);
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

    public function setTitle($title)
    {
        $this->_title = $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function setCode($code)
    {
        $this->_code = $code;
        return $this;
    }

    public function getCode()
    {
        return $this->_code;
    }

    public function setAddress($address)
    {
        $this->_address = $address;
        return $this;
    }

    public function getAddress()
    {
        return $this->_address;
    }
}
