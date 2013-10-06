<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   	Payment
 * @package    	Strobe_OnDelivery
 * @copyright   Copyright (c) 2010 Strobe IT Team
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Strobe Payment OnDelivery Model
 */
class Strobe_OnDelivery_Model_Payment extends Mage_Payment_Model_Method_Abstract
{

    /**
     * Payment method code
     *
     * @var string
     */
    protected $_code  = 'ondelivery';

    /**
     * Cash On Delivery payment block paths
     *
     * @var string
     */
    protected $_formBlockType = 'ondelivery/form';
    protected $_infoBlockType = 'ondelivery/info';

    /**
     * Get instructions text from config
     *
     * @return string
     */
    public function getInstructions()
    {
        return trim($this->getConfigData('instructions'));
    }
    
    /**
     * Stores custom data for payment method in the database.
     *
     * @return Mage_Payment_Model_Method_Abstract
     */
    public function assignData($data)
    {
        parent::assignData($data);
        
        if (!($data instanceof Varien_Object)) {
            $data = new Varien_Object($data);
        }
        $info = $this->getInfoInstance();
        $info->setMoneyAmount($data->getMoneyAmount());
        $info->save();
        return $this;
    }
 
    /**
     * Validates custom data for payment method.
     *
     * @return Mage_Payment_Model_Method_Abstract
     */
    public function validate()
    {
        parent::validate();
 
        $info = $this->getInfoInstance();
        $money = $info->getMoneyAmount();
        
        if(empty($money)){
            $errorCode = 'invalid_data';
            $errorMsg = $this->_getHelper()->__('Money Amount is a required field');
        }
 
        if($errorMsg){
            Mage::throwException($errorMsg);
        }
        return $this;
    }

}
