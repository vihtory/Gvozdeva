<?php

class Gvozdeva_Stores_Block_Adminhtml_Stores_Edit_Tab_Meta
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Form for meta information
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('stores');
        $form = new Varien_Data_Form();
        $form->setMethod('post');
        // $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setAction($this->getUrl('*/*/save'));
        $form->setEnctype('multipart/form-data');

        $fieldset = $form->addFieldset('meta_fieldset', [
            'legend' => $this->__('Meta Information'),
            'class' => 'fieldset-wide']);

        $fieldset->addField('meta_title', 'text', [
            'name' => 'meta_title',
            'index' => 'meta_title',
            'label' => $this->__('Meta Title'),
            'title' => $this->__('Meta Title')
        ]);

        $fieldset->addField('meta_keywords', 'textarea', [
            'name' => 'meta_keywords',
            'index' => 'meta_keywords',
            'label' => $this->__('Meta Keywords'),
            'title' => $this->__('Meta Keywords')
        ]);

        $fieldset->addField('meta_description', 'textarea', [
            'name' => 'meta_description',
            'index' => 'meta_description',
            'label' => $this->__('Meta Description'),
            'title' => $this->__('Meta Description')
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
        return $this->__('Meta Data');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Meta Data');
    }

    /**
     * Returns status flag about this tab can be showen or not
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
