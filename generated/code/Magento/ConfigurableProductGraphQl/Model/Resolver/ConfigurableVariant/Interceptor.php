<?php
namespace Magento\ConfigurableProductGraphQl\Model\Resolver\ConfigurableVariant;

/**
 * Interceptor class for @see \Magento\ConfigurableProductGraphQl\Model\Resolver\ConfigurableVariant
 */
class Interceptor extends \Magento\ConfigurableProductGraphQl\Model\Resolver\ConfigurableVariant implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\ConfigurableProductGraphQl\Model\Variant\Collection $variantCollection, \Magento\ConfigurableProductGraphQl\Model\Options\Collection $optionCollection, \Magento\Framework\GraphQl\Query\Resolver\ValueFactory $valueFactory, \Magento\CatalogGraphQl\Model\Resolver\Products\Attributes\Collection $attributeCollection, \Magento\Framework\EntityManager\MetadataPool $metadataPool)
    {
        $this->___init();
        parent::__construct($variantCollection, $optionCollection, $valueFactory, $attributeCollection, $metadataPool);
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
