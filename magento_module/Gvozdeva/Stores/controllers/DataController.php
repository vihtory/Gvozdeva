<?php
class Gvozdeva_Stores_DataController extends Mage_Core_Controller_Front_Action
{
    public function importUpdateQtyAction()
    {
        $data    = $this->getRequest()->getParams();
        $product = unserialize(trim($data['data_']));

        $modelProduct = Mage::getModel('catalog/product')->loadByAttribute('sku', $product['sku']);
        $storeModel   = Mage::getModel('stores/stores')->loadByCode($product['code']);
        $offer = Mage::getModel('stores/offers')
            ->loadByParams($storeModel->getId(), $modelProduct->getId());
        try {
            if (!$offer->getId()) {
                return 0;
            }
            $offer->setStoreId($storeModel->getId())
                ->setProductId($modelProduct->getId())
                ->setQty($product['qty'] + $offer->getQty())->save();
        } catch (Exception $e) {
            Mage::logException($e);
        }
    }

    public function importOrdersAction()
    {
        $data  = $this->getRequest()->getParams();
        $order = unserialize(trim($data['data_']));
        try {
            $storeId    = Mage::getModel('stores/stores')->loadByCode($order['store_code']);
            $orderModel = Mage::getModel('stores/orders')->setCustomerName($order['name'])
                ->setCustomerEmail($order['email'])
                ->setCustomerPhone($order['phone'])
                ->setStoreId($storeId->getId())
                ->setTotal($order['total'])
                ->save();
            foreach ($order['products'] as $product) {
                Mage::getModel('stores/orderItems')
                    ->setSku($product['sku'])
                    ->setQty($product['qty'])
                    ->setPrice($product['price'])
                    ->setOrderId($orderModel->getId());
            }
            $this->getResponse()->setBody('i get data');
        } catch (Exception $e) {
            $this->getResponse()->setBody($e->getMessage());
            Mage::logException($e);
        }
    }
}