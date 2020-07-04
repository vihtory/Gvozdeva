<?php

class Gvozdeva_Stores_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Show stores list action
     *
     * @return void
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * View store action
     *
     * @return void
     */
    public function viewAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}
