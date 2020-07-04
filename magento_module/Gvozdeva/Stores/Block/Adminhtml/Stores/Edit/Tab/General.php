<?php

class Gvozdeva_Stores_Block_Adminhtml_Stores_Edit_Tab_General
extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Form for general information
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('stores');
        $form = new Varien_Data_Form();
        $form->setMethod('post');
        $form->setId('edit_form');
        $form->setAction($this->getUrl('*/*/save'));
        $form->setEnctype('multipart/form-data');


        $fieldset = $form->addFieldset('general_fieldset', [
            'legend' => Mage::helper('stores')->__('General'),
            'class'  => 'fieldset-wide'
        ]);

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', [
                'name' => 'id',
            ]);
        }

        $fieldset->addField('code', 'text', [
            'label'    => Mage::helper('stores')->__('Code'),
            'required' => true,
            'index'    => 'code',
            'name'     => 'code'
        ]);

        $fieldset->addField('title', 'text', [
            'label'    => Mage::helper('stores')->__('Title'),
            'required' => true,
            'index'    => 'title',
            'name'     => 'title'
        ]);

        $fieldset->addField('address', 'text', [
            'label'    => Mage::helper('stores')->__('Address'),
            'required' => true,
            'index'    => 'address',
            'name'     => 'address'
        ]);

        $fieldset->addField('working_hours', 'text', [
            'label'    => Mage::helper('stores')->__('Working Hours'),
            'index'    => 'working_hours',
            'name'     => 'working_hours'
        ]);

        $fieldset->addField('city', 'text', [
            'label'    => Mage::helper('stores')->__('City'),
            'index'    => 'city',
            'name'     => 'city'
        ]);

        $fieldset->addField('status', 'select', [
            'label'    => Mage::helper('stores')->__('Status'),
            'index'    => 'status',
            'name'     => 'status',
            'options'  => Mage::getModel('stores/source_status')->toArray()
        ]);

        $fieldset->addField('description', 'editor', [
            'label'    => Mage::helper('stores')->__('Description'),
            'index'    => 'description',
            'wysiwyg'  => true,
            'config'   => Mage::getSingleton('cms/wysiwyg_config'),
            'name'     => 'description'
        ]);

        $fieldset->addField('image', 'image', [
            'label'    => Mage::helper('stores')->__('Image'),
            'required' => false,
            'index'    => 'image',
            'name'     => 'image',
        ]);


        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('stores')->__('General');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('stores')->__('General');
    }

    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return false
     */
    public function isHidden()
    {
        return false;
    }
}
