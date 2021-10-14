<?php
namespace Magento\Framework\App\MutableScopeConfig;

/**
 * Interceptor class for @see \Magento\Framework\App\MutableScopeConfig
 */
class Interceptor extends \Magento\Framework\App\MutableScopeConfig implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Config\ScopeCodeResolver $scopeCodeResolver, array $types = [])
    {
        $this->___init();
        parent::__construct($scopeCodeResolver, $types);
    }

    /**
     * {@inheritdoc}
     */
    public function isSetFlag($path, $scope = 'default', $scopeCode = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isSetFlag');
        if (!$pluginInfo) {
            return parent::isSetFlag($path, $scope, $scopeCode);
        } else {
            return $this->___callPlugins('isSetFlag', func_get_args(), $pluginInfo);
        }
    }
}
