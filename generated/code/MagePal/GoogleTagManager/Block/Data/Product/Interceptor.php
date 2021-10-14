<?php
namespace MagePal\GoogleTagManager\Block\Data\Product;

/**
 * Interceptor class for @see \MagePal\GoogleTagManager\Block\Data\Product
 */
class Interceptor extends \MagePal\GoogleTagManager\Block\Data\Product implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Block\Product\Context $context, \MagePal\GoogleTagManager\Helper\Product $productHelper, \MagePal\GoogleTagManager\DataLayer\ProductData\ProductProvider $productProvider, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $productHelper, $productProvider, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getImage($product, $imageId, $attributes = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getImage');
        if (!$pluginInfo) {
            return parent::getImage($product, $imageId, $attributes);
        } else {
            return $this->___callPlugins('getImage', func_get_args(), $pluginInfo);
        }
    }
}
