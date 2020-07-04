<?php

namespace Application\Model;
use Core\Model;

class StoreProduct extends Model\Model
{
    private $_id;
    private $_price;
    private $_qty;
    private $_productId;
    private $_storeId;

    public function exchangeArray($data)
    {
        $this->setId((!empty($data['id'])) ? $data['id'] : null)
            ->setPrice((!empty($data['price'])) ? $data['price'] : null)
            ->setStoreId(!empty($data['store_id']) ? $data['store_id'] : null)
            ->setProductId(!empty($data['product_id']) ? $data['product_id'] : null)
            ->setQty(!empty($data['qty']) ? $data['qty'] : null);
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

    public function setPrice($price)
    {
        $this->_price = $price;
        return $this;
    }

    public function getPrice()
    {
        return $this->_price;
    }

    public function setQty($qty)
    {
        $this->_qty = $qty;
        return $this;
    }

    public function getQty()
    {
        return $this->_qty;
    }
    public function setProductId($productId)
    {
        $this->_productId = $productId;
        return $this;
    }

    public function getProductId()
    {
        return $this->_productId;
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
