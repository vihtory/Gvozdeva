<?php

class Gvozdeva_Stores_Adminhtml_StoresController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Show stores grid action
     *
     * @return void
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Create new store action
     *
     * @return void
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * Edit store action
     *
     * @throws Mage_Core_Exception
     * @return void
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        Mage::register('stores', Mage::getModel('stores/stores')->load($id));
        $storeObject = (array)Mage::getSingleton('adminhtml/session')->getStoreObject(true);
        if (count($storeObject)) {
            Mage::registry('stores')->setData($storeObject);
        }
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Save new store action
     *
     * @return void
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $id = $this->getRequest()->getParam('id');
            $store = Mage::getModel('stores/stores')->load($id);

            if (!$store->getId() && $id) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('stores')
                    ->__('This store no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
            if (isset($data['id'])) {
                unset($data['id']);
            }
            $store->addData($data)
                ->setImage(Mage::getModel('stores/source_image')->processImage($store->getImage()));
            try {
                $store->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('stores')
                    ->__('The store has been saved.'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * Delete store action
     *
     * @return void
     */
    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            $store = Mage::getModel('stores/stores')->load($id);
            try {
                $store->delete();
                $this->_getSession()->addSuccess($this->__('The store has been deleted.'));
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->getResponse()
            ->setRedirect($this->getUrl('*/*/', []));
    }

    /**
     * Delete select stores
     *
     * @return Mage_Core_Controller_Varien_Action|Gvozdeva_Stores_Adminhtml_StoresController
     */
    public function massDeleteAction()
    {
        $stores = $this->getRequest()->getParams();
        try {
            $stores = Mage::getModel('stores/stores')
                ->getCollection()
                ->addFieldToFilter('id', ['in' => $stores['massaction']]);
            foreach ($stores as $store) {
                $store->delete();
            }
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            return $this->_redirect('*/*/');
        }
        Mage::getSingleton('adminhtml/session')->addSuccess('Stores select were deleted!');

        return $this->_redirect('*/*/');

    }

    /**
     * Change status select stores
     *
     * @return Mage_Core_Controller_Varien_Action|Gvozdeva_Stores_Adminhtml_StoresController
     */
    public function massStatusAction()
    {
        $status = $this->getRequest()->getParam('store_status');
        $idSelectStores = $this->getRequest()->getParam('massaction');
        try {
            $stores = Mage::getModel('stores/stores')
                ->getCollection()
                ->addFieldToFilter('id', ['in' => $idSelectStores]);
            foreach ($stores as $store) {
                $store->setStatus($status)->save();
            }
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            return $this->_redirect('*/*/');
        }
        Mage::getSingleton('adminhtml/session')->addSuccess('Stores were updated!');

        return $this->_redirect('*/*/');
    }

    /**
     * Show store products grid action
     *
     * @return void
     */
    public function offersAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Show store order grid action
     *
     * @return void
     */
    public function ordersAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Tab store products grid action
     *
     * @return void
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    /**
     * Tab store order grid action
     *
     * @return void
     */
    public function ordergridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}
