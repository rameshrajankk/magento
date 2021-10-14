<?php
namespace Magento\Variable\Model\Source\Variables;

/**
 * Interceptor class for @see \Magento\Variable\Model\Source\Variables
 */
class Interceptor extends \Magento\Variable\Model\Source\Variables implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Config\Model\Config\Structure\SearchInterface $configStructure, array $configPaths = [])
    {
        $this->___init();
        parent::__construct($configStructure, $configPaths);
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray($withGroup = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'toOptionArray');
        if (!$pluginInfo) {
            return parent::toOptionArray($withGroup);
        } else {
            return $this->___callPlugins('toOptionArray', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getData');
        if (!$pluginInfo) {
            return parent::getData();
        } else {
            return $this->___callPlugins('getData', func_get_args(), $pluginInfo);
        }
    }
}
