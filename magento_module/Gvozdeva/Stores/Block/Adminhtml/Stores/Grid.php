<?php

class Gvozdeva_Stores_Block_Adminhtml_Stores_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    /**
     * Gvozdeva_Stores_Block_Adminhtml_Stores_Grid constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('cmsStoreGrid');
        $this->setDefaultSort('store_identifier');
        $this->setDefaultDir('ASC');
    }

    /**
     * Prepare get collection
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('stores/stores')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Prepare grid's columns
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     * @throws Exception
     */
    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('id', [
            'header'    => Mage::helper('stores')->__('Id'),
            'align'     => 'left',
            'index'     => 'id'
        ]);

        $this->addColumn('title', [
            'header'    => Mage::helper('stores')->__('Title'),
            'align'     => 'left',
            'index'     => 'title'
        ]);

        $this->addColumn('address', [
            'header'    => Mage::helper('stores')->__('Address'),
            'align'     => 'left',
            'index'     => 'address'
        ]);
        $this->addColumn('working_hours', [
            'header'    => Mage::helper('stores')->__('Working Hours'),
            'align'     => 'left',
            'index'     => 'working_hours'

        ]);
        $this->addColumn('city', [
            'header'    => Mage::helper('stores')->__('City'),
            'align'     => 'left',
            'index'     => 'city'
        ]);
        $this->addColumn('status', [
            'header'    => Mage::helper('stores')->__('Active'),
            'align'     => 'left',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => Mage::getModel('stores/source_status')->toArray()
        ]);

        return parent::_prepareColumns();
    }

    /**
     * Grid's filter stores
     *
     * @param string $column
     * @return void
     */
    protected function _filterStoreCondition($column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $this->getCollection()->addStoreFilter($value);
    }

    /**
     * Prepare grid's massaction
     *
     * @return $this|Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setIdFieldName('id');
        $this->getMassactionBlock()
            ->addItem('delete',
                [
                    'label'   => Mage::helper('stores')->__('Delete'),
                    'url'     => $this->getUrl('*/*/massDelete'),
                    'confirm' => Mage::helper('stores')->__('Are you sure?')
                ]
            )
            ->addItem('status',
                array(
                    'label'      => Mage::helper('stores')->__('Update Status'),
                    'url'        => $this->getUrl('*/*/massStatus'),
                    'additional' =>
                        ['store_status' =>
                            [
                                'name'   => 'store_status',
                                'type'   => 'select',
                                'class'  => 'required-entry',
                                'label'  => Mage::helper('stores')->__('Status'),
                                'values' => Mage::getModel('stores/source_status')->toOptionArray()
                            ]
                        ]
                )
            );

        return $this;
    }

    /**
     * Row click url
     *
     * @param array $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', ['id' => $row->getId()]);
    }

}
