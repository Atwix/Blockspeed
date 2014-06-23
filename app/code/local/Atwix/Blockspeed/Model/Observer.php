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

 * @category    Atwix
 * @package     Atwix_Blockspeed
 * @author      Atwix Core Team
 * @copyright   Copyright (c) 2014 Atwix (http://www.atwix.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Atwix_Blockspeed_Model_Observer
{

    /**
     * Write block rendering starting time to helper instance
     *
     * @param Varien_Event_Observer $observer
     */
    public function blockHtmlStart(Varien_Event_Observer $observer)
    {
        if( Mage::getStoreConfig('atwix_blockspeed/atwix_blockspeed/enabled') == 1 ) {
            Mage::helper('atwix_blockspeed')->_blocks[get_class($observer->getBlock()) . '---' . $observer->getBlock()->getTemplate()][$observer->getBlock()->getNameInLayout()]['start'] = microtime(true);
        }
    }

    /**
     * Write block rendering ending time to helper instance
     *
     * @param Varien_Event_Observer $observer
     */
    public function blockHtmlEnd(Varien_Event_Observer $observer)
    {
        if( Mage::getStoreConfig('atwix_blockspeed/atwix_blockspeed/enabled') == 1 ) {
            Mage::helper('atwix_blockspeed')->_blocks[get_class($observer->getBlock()) . '---' . $observer->getBlock()->getTemplate()][$observer->getBlock()->getNameInLayout()]['end'] = microtime(true);
        }
    }

    /**
     * Refresh block rendering statistics
     *
     * @param Varien_Event_Observer $observer
     */
    public function controllerEnd(Varien_Event_Observer $observer)
    {
        if( Mage::getStoreConfig('atwix_blockspeed/atwix_blockspeed/enabled') == 1 ) {
            Mage::getModel('atwix_blockspeed/rendertime')->updateStatistics();
        }
    }
}