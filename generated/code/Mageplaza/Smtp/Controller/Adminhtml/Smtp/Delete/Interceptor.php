<?php
namespace Mageplaza\Smtp\Controller\Adminhtml\Smtp\Delete;

/**
 * Interceptor class for @see \Mageplaza\Smtp\Controller\Adminhtml\Smtp\Delete
 */
class Interceptor extends \Mageplaza\Smtp\Controller\Adminhtml\Smtp\Delete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mageplaza\Smtp\Model\LogFactory $logFactory, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($logFactory, $context);
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
