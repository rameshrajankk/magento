<?php
/**
 * BelVG LLC.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
 *
 ********************************************************************
 * @category   BelVG
 * @package    BelVG_AdvancedComparison
 * @copyright  Copyright (c) 2010 - 2016 BelVG LLC. (http://www.belvg.com)
 * @license    http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
 */
namespace BelVG\AdvancedComparison\Model;

use Magento\Framework\Event\ObserverInterface;

class Observer implements ObserverInterface
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * Module helper data
     *
     * @var \BelVG\AdvancedComparison\Helper\Data
     */
    protected $_helper;

    /**
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \BelVG\AdvancedComparison\Helper\Data $helper
    )
    {
        $this->_coreRegistry = $registry;
        $this->_helper = $helper;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if($this->_helper->isEnabled())
        {
            $attribute = $this->getAttribute();
            $form = $observer->getForm();
            $values = $this->_helper->getCompareModeValues($attribute);
            if(count($values) > 1)
                $form->getElement('base_fieldset')
                    ->addField(
                        'compare_mode',
                        'select',
                        [
                            'name' => 'compare_mode',
                            'label' => __('Compare Mode'),
                            'title' => __('Compare Mode'),
                            'required' => true,
                            'value' => $attribute->getCompareMode(),
                            'values' => $values,
                        ]
                    );
            $observer->setForm($form);
        }
        return $this;
    }

    /**
     * Return attribute object
     *
     * @return Attribute
     */
    public function getAttribute()
    {
        return $this->_coreRegistry->registry('entity_attribute');
    }
}
