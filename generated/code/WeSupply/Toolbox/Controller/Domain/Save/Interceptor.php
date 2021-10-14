<?php
namespace WeSupply\Toolbox\Controller\Domain\Save;

/**
 * Interceptor class for @see \WeSupply\Toolbox\Controller\Domain\Save
 */
class Interceptor extends \WeSupply\Toolbox\Controller\Domain\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Magento\Framework\App\Config\Storage\WriterInterface $configWriter, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList, \WeSupply\Toolbox\Helper\Data $wsHelper)
    {
        $this->___init();
        parent::__construct($context, $resultJsonFactory, $configWriter, $storeManager, $cacheTypeList, $wsHelper);
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
