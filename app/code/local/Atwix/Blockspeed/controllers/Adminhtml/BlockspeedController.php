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

class Atwix_Blockspeed_Adminhtml_BlockspeedController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('system/atwix_blockspeed');
        $this->_addContent($this->getLayout()->createBlock('atwix_blockspeed/adminhtml_statistics'));
        $this->renderLayout();
    }

    public function flushAction()
    {
        Mage::getResourceModel('atwix_blockspeed/rendertime')->flush();

        $this->_redirect('adminhtml/blockspeed');
    }

    public function exportCsvAction()
    {
        $fileName = 'block_statistics.csv';
        $content = $this->getLayout()->createBlock('atwix_blockspeed/adminhtml_statistics_grid')
            ->getCsvFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }
}