<?php
namespace WeSupply\Toolbox\Controller\Webhook\GrabToolboxDetails;

/**
 * Interceptor class for @see \WeSupply\Toolbox\Controller\Webhook\GrabToolboxDetails
 */
class Interceptor extends \WeSupply\Toolbox\Controller\Webhook\GrabToolboxDetails implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Controller\Result\JsonFactory $jsonFactory, \Magento\Framework\Serialize\Serializer\Json $jsonSerializer, \Magento\Framework\App\ProductMetadataInterface $productMetadata, \Magento\Framework\Component\ComponentRegistrarInterface $componentRegistrar, \Magento\Framework\Filesystem\Directory\ReadFactory $readFactory, \WeSupply\Toolbox\Helper\Data $helper)
    {
        $this->___init();
        parent::__construct($context, $jsonFactory, $jsonSerializer, $productMetadata, $componentRegistrar, $readFactory, $helper);
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        if (!$pluginInfo) {
            return parent::dispatch($request);
        } else {
            return $this->___callPlugins('dispatch', func_get_args(), $pluginInfo);
        }
    }
}
