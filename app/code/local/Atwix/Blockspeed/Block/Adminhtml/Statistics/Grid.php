<?php
/**
 * Atwix
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.

 * @category    Atwix Mod
 * @package     Atwix_Blockspeed
 * @author      Atwix Core Team
 * @copyright   Copyright (c) 2014 Atwix (http://www.atwix.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Atwix_Blockspeed_Block_Adminhtml_Statistics_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('blockspeedStatisticsGrid');
        $this->setDefaultSort('block');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('atwix_blockspeed/rendertime')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $helper =  Mage::helper('atwix_blockspeed');
        $this->addColumn('entity_id', array(
            'header'    => $helper->__('ID'),
            'align'     => 'right',
            'width'     => '50px',
            'type'      => 'number',
            'index'     => 'entity_id',
        ));

        $this->addColumn('block', array(
            'header'    => $helper->__('Block class name'),
            'index'     => 'block',
        ));

        $this->addColumn('template', array(
            'header'    => $helper->__('Block template name'),
            'index'     => 'template',
        ));

        $this->addColumn('time', array(
            'header'    => $helper->__('Average rendering time'),
            'index'     => 'time',
            'align'     => 'right',
            'type'      => 'number',
            'width'     => '50px',
            'renderer'  => 'Atwix_Blockspeed_Block_Adminhtml_Statistics_Renderer_Seconds',
        ));

        $this->addColumn('hits', array(
            'header'    => $helper->__('Number of hits'),
            'index'     => 'hits',
            'align'     => 'right',
            'type'      => 'number',
            'width'     => '50px',
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('atwix_blockspeed')->__('CSV'));

        return parent::_prepareColumns();
    }

}