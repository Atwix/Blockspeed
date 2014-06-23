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


class Atwix_Blockspeed_Model_Rendertime extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        $this->_init('atwix_blockspeed/rendertime');
    }

    /**
     * Update block rendering statistics
     */
    public function updateStatistics()
    {
        $blocks = Mage::helper('atwix_blockspeed')->_blocks;
        $collection = $this->getCollection();

        //updating existing values
        if( $collection->count() > 0 ) {
            $items = $collection->getItems();
            foreach($items as $item) {
                $name = $item->getBlock() . '---' . $item->getTemplate();
                if(array_key_exists($name, $blocks)) {
                    $hits = $item->getHits() + count( $blocks[$name] );
                    $totalTime = $item->getTime() * $item->getHits();
                    foreach($blocks[$name] as $value) {
                        if( isset($value['end']) && isset($value['start']) ){
                            $totalTime += $value['end'] - $value['start'];
                        }else{
                            $hits += -1;
                        }
                    }
                    $avgTime = $totalTime / $hits;
                    $item->setTime($avgTime)
                        ->setHits($hits)
                        ->save()
                    ;
                    unset($blocks[$name]);
                }
            }
        }

        //adding new values
        foreach( $blocks as $title => $values ) {
            $hits = count( $values );
            $totalTime = 0;
            foreach($values as $value) {
                if( isset($value['end']) && isset($value['start']) ){
                    $totalTime += $value['end'] - $value['start'];
                }else{
                    $hits += -1;
                }

            }
            if($hits > 0){
                $titles = explode('---',$title);
                $avgTime = $totalTime / $hits;
                $data = array(
                    'block'     => $titles[0],
                    'template'  => $titles[1],
                    'time'      => $avgTime,
                    'hits'      => $hits,
                );
                $this->setData($data)->save();
            }
        }
    }
}