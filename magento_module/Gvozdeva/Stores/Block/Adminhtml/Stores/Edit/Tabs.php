<?php

class Gvozdeva_Stores_Block_Adminhtml_Stores_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Gvozdeva_Stores_Block_Adminhtml_Stores_Edit_Tabs constructor.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('stores_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle($this->__('Stores Information'));
    }
}
