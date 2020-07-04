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
use Zend\Http\Client;
use Zend\Http\Request;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;

class IndexController extends AbstractActionController
{
    private $_salerTable;
    private $_storeTable;
    private $_productTable;
    private $_orderTable;
    private $_orderProductTable;
    private $_storeProductTable;
    private $_storeName = null;

    public function onDispatch(MvcEvent $e)
    {
        $response = parent::onDispatch($e);
        $route =  $this->params()->fromRoute();
        $isLoggedIn = $this->_salerTable->checkAuthorization();
        if ($route['controller'] == self::class && $route['action'] == 'index') {
            if ($isLoggedIn) {
                $this->redirect()->toRoute('application', ['action' => 'menu']);
            }
            return $response;
        }
        if (!$isLoggedIn) {
            $this->redirect()->toRoute('application');
        }
        return $response;
    }
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

    public function indexAction()
    {
        return new ViewModel();
    }

    public function loginAction()
    {
        $data = $this->params()->fromPost();
        if ($this->_salerTable->authenticate($data['email'], $data['password'])) {
            $this->redirect()->toRoute('application', ['action' => 'menu']);
            return;
        }
        $this->redirect()->toRoute('application', ['action' => 'index']);
    }

    public function menuAction()
    {
        if (!$this->_storeName) {
            $store = $this->_storeTable->load($this->_salerTable->getStoreId());
            if (!$store) {
                $this->redirect()->toRoute('application');
                return;
            }
            $this->_storeName = $store->getTitle();
        }
        return new ViewModel([
            'name'     => $this->_salerTable->getName(),
            'store'    => $this->_storeName,
            'products' => $this->_productTable->getStoreProductList($this->_salerTable->getStoreId())
            ]);
    }

    public function addAction()
    {
        $data = $this->params()->fromPost();
        $this->_storeProductTable->updateQty($data["id"],$this->_salerTable->getStoreId() ,$data['qty']);
        $this->_sendUpdateQtyToMagento($data["id"], $data['qty'], $this->_salerTable->getStoreId() );
        return $this->getResponse()->isSuccess();
    }

    public function orderAction()
    {
        $data = $this->params()->fromPost();
        $order = [
            'name'       => $data['name'],
            'email'      => $data['email'],
            'phone'      => $data['phone'],
            'store_id'   => $this->_salerTable->getStoreId(),
            'saler_id'   => $this->_salerTable->getId(),
            'created_at' => date("Y-m-d H:i:s")
        ];
        $id = $this->_orderTable->save($order);
        $total = 0;
        $products = [];
        for ($i = 0; $i < count($data['sku_ordered']); $i++) {
            $productId = $this->_productTable->loadBySku($data['sku_ordered'][$i])->getId();
            $storeProduct  = $this->_storeProductTable
                ->getStoreProduct(
                    $productId,
                    $this->_salerTable->getStoreId()
                );
            $price = $storeProduct->getPrice();
            if (!$storeProduct->getQty()) {
                continue;
            }
            if ($storeProduct->getQty() < $data['qty_ordered'][$i]) {
                $data['qty_ordered'][$i] = $storeProduct->getQty();
            }
            $this->_storeProductTable
                ->updateQty($productId ,$this->_salerTable->getStoreId() ,(-1) * $data['qty_ordered'][$i]);
            $total += $price;
            $products[$i] = [
                'sku'      => $data['sku_ordered'][$i],
                'qty'      => $data['qty_ordered'][$i],
                'order_id' => $id,
                'price'    => $price
            ];
            $this->_orderProductTable->save($products[$i]);
            $this->_sendUpdateQtyToMagento($productId, (-1) * $data['qty_ordered'][$i] ,$this->_salerTable->getStoreId());
        }
        $this->_orderTable->setTotal($id, $total);
        $order['total'] = $total;
        $order['products'] = $products;
        $order['store_code'] = $this->_storeTable->load($this->_salerTable->getStoreId())->getCode();
        $this->_sendOrdersToMagento($order);
        return $this->getResponse()->isSuccess();
    }

    private function _sendUpdateQtyToMagento($id, $qty, $storeId) {
        $request = new Request();
        $request->setUri('http://magento.loc/stores/data/importUpdateQty');
        $request->setMethod(Request::METHOD_POST);
        $data = serialize([
            'qty'  => $qty,
            'code' => $this->_storeTable->load($storeId)->getCode(),
            'sku'  => $this->_productTable->load($id)->getSku()
        ]);
        $request->setContent('data = ' . $data);
        $client = new Client();
        $client->setOptions(['strictredirects' => true]);

        $response = $client->send($request);
    }


    private function _sendOrdersToMagento($data)
    {
        $request = new Request();
        $request->setUri('http://magento.loc/stores/data/importOrders');
        $request->setMethod(Request::METHOD_POST);

        $request->setContent('data = ' . serialize($data));
        $client = new Client();
        $client->setOptions(['strictredirects' => true]);

        $response = $client->send($request);
    }
}
