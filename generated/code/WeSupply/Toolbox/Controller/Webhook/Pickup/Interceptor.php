<?php
namespace WeSupply\Toolbox\Controller\Webhook\Pickup;

/**
 * Interceptor class for @see \WeSupply\Toolbox\Controller\Webhook\Pickup
 */
class Interceptor extends \WeSupply\Toolbox\Controller\Webhook\Pickup implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Controller\Result\JsonFactory $jsonFactory, \Magento\Framework\Serialize\Serializer\Json $jsonSerializer, \WeSupply\Toolbox\Model\Webhook $webhook, \WeSupply\Toolbox\Logger\Logger $logger, \Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Magento\Sales\Model\Convert\Order $convertOrder, \Magento\Shipping\Model\ShipmentNotifier $shipmentNotifier)
    {
        $this->___init();
        parent::__construct($context, $jsonFactory, $jsonSerializer, $webhook, $logger, $orderRepository, $convertOrder, $shipmentNotifier);
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
