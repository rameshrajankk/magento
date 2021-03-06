<?php
/**
 * @category   Ziffity
 * @package    Ziffity_Preorder
 * @author     ramesh.rajan@ziffity.com
 * @copyright  This file was generated by using Module Creator(http://code.vky.co.in/magento-2-module-creator/) provided by VKY <viky.031290@gmail.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Ziffity\Preorder\Observer;

use Magento\Framework\Event\ObserverInterface;


class ProductViewLayout implements ObserverInterface
{
    protected $_resultPageFactory;

    public function __construct(\Magento\Framework\View\Result\PageFactory $resultPageFactory) {
        $this->_resultPageFactory = $resultPageFactory;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $_product = $objectManager->create('Magento\Catalog\Model\Product')->load($observer->getProduct()->getId());
        $attributeValue = $_product->getResource()->getAttribute('preorder_attr')->getFrontend()->getValue($_product);
        
        if($attributeValue == "Yes"){
            $page = $this->_resultPageFactory->create();
            $page->addHandle('catalog_product_custom_layout');
        }     
        return $this;
    }
}