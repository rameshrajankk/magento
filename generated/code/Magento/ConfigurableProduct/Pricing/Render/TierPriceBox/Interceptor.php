<?php
namespace Magento\ConfigurableProduct\Pricing\Render\TierPriceBox;

/**
 * Interceptor class for @see \Magento\ConfigurableProduct\Pricing\Render\TierPriceBox
 */
class Interceptor extends \Magento\ConfigurableProduct\Pricing\Render\TierPriceBox implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Framework\Pricing\SaleableInterface $saleableItem, \Magento\Framework\Pricing\Price\PriceInterface $price, \Magento\Framework\Pricing\Render\RendererPool $rendererPool, \Magento\ConfigurableProduct\Pricing\Price\ConfigurableOptionsProviderInterface $configurableOptionsProvider, array $data = [], ?\Magento\ConfigurableProduct\Pricing\Price\LowestPriceOptionsProviderInterface $lowestPriceOptionsProvider = null, ?\Magento\Catalog\Model\Product\Pricing\Renderer\SalableResolverInterface $salableResolver = null, ?\Magento\Catalog\Pricing\Price\MinimalPriceCalculatorInterface $minimalPriceCalculator = null)
    {
        $this->___init();
        parent::__construct($context, $saleableItem, $price, $rendererPool, $configurableOptionsProvider, $data, $lowestPriceOptionsProvider, $salableResolver, $minimalPriceCalculator);
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheKey()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCacheKey');
        if (!$pluginInfo) {
            return parent::getCacheKey();
        } else {
            return $this->___callPlugins('getCacheKey', func_get_args(), $pluginInfo);
        }
    }
}
