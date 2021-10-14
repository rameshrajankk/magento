<?php
namespace Ziffity\Preorder\Controller\Adminhtml\Items\MassStatus;

/**
 * Interceptor class for @see \Ziffity\Preorder\Controller\Adminhtml\Items\MassStatus
 */
class Interceptor extends \Ziffity\Preorder\Controller\Adminhtml\Items\MassStatus implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Ui\Component\MassAction\Filter $filter, \Ziffity\Preorder\Model\ResourceModel\Preorder\CollectionFactory $collectionFactory, \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation, \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Psr\Log\LoggerInterface $loggerInterface, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $filter, $collectionFactory, $inlineTranslation, $transportBuilder, $scopeConfig, $loggerInterface, $data);
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
