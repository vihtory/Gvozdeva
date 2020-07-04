<?php

namespace Application\Model;
use Core\Model;

class Product extends StoreProduct
{
    private $_id;
    private $_sku;
    private $_name;

    public function exchangeArray($data)
    {
        $this->setId((!empty($data['id'])) ? $data['id'] : null)
            ->setName((!empty($data['name'])) ? $data['name'] : null)
            ->setSku(!empty($data['sku']) ? $data['sku'] : null);

        parent::exchangeArray($data);
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

    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setSku($sku)
    {
        $this->_sku = $sku;
        return $this;
    }

    public function getSku()
    {
        return $this->_sku;
    }

}
