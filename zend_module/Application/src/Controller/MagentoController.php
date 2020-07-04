<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mvc\MvcEvent;
use Application\Model\SalerTable;
use Application\Model\StoreTable;
use Application\Model\ProductTable;
use Application\Model\OrderTable;
use Application\Model\OrderProductTable;
use Application\Model\StoreProductTable;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;

class MagentoController extends AbstractActionController
{

    private $_salerTable;
    private $_storeTable;
    private $_productTable;
    private $_orderTable;
    private $_orderProductTable;
    private $_storeProductTable;

    public function __construct(SalerTable $salerTable,
                                StoreTable $storeTable,
                                ProductTable $productTable,
                                StoreProductTable $storeProductTable,
                                OrderTable $orderTable,
                                OrderProductTable $orderProductTable)
    {
        $this->_salerTable        = $salerTable;
        $this->_storeTable        = $storeTable;
        $this->_productTable      = $productTable;
        $this->_storeProductTable = $storeProductTable;
        $this->_orderTable        = $orderTable;
        $this->_orderProductTable = $orderProductTable;
    }

    public function storeAction()
    {
        $stores = [];
        foreach ($this->_storeTable->fetchAll() as $store) {
            $stores[$store->getCode()] = [
              'code'    => $store->getCode(),
              'title'   => $store->getTitle(),
              'address' => $store->getAddress()
            ];
        }
        return $this->getResponse()->setContent(serialize($stores));
    }

    public function catalogAction()
    {
        $products = unserialize($this->params()->fromPost('products'));
        foreach ($products as $product) {
            if ($this->_productTable->loadBySku($product['sku'])) {
                continue;
            }
            $this->_productTable->save($product);
        }
        return $this->getResponse()->isSuccess();
    }

    public function productAction()
    {
        $products = $this->_productTable->getAllProductList();
        $responseArray = [];
        foreach ($products as $product) {
            $responseArray[] = [
                'code' => $this->_storeTable->load($product->getStoreId())->getCode(),
                'sku'  => $product->getSku(),
                'qty'  => $product->getQty() 
            ];
        }
        return $this->getResponse()->setContent(serialize($responseArray));
    }
}
