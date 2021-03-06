<?php
namespace Magento\EavGraphQl\Model\Resolver\CustomAttributeMetadata;

/**
 * Interceptor class for @see \Magento\EavGraphQl\Model\Resolver\CustomAttributeMetadata
 */
class Interceptor extends \Magento\EavGraphQl\Model\Resolver\CustomAttributeMetadata implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\EavGraphQl\Model\Resolver\Query\Type $type)
    {
        $this->___init();
        parent::__construct($type);
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(\Magento\Framework\GraphQl\Config\Element\Field $field, $context, \Magento\Framework\GraphQl\Schema\Type\ResolveInfo $info, ?array $value = null, ?array $args = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'resolve');
        if (!$pluginInfo) {
            return parent::resolve($field, $context, $info, $value, $args);
        } else {
            return $this->___callPlugins('resolve', func_get_args(), $pluginInfo);
        }
    }
}
