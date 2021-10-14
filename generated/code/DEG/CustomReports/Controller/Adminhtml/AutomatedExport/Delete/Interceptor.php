<?php
namespace DEG\CustomReports\Controller\Adminhtml\AutomatedExport\Delete;

/**
 * Interceptor class for @see \DEG\CustomReports\Controller\Adminhtml\AutomatedExport\Delete
 */
class Interceptor extends \DEG\CustomReports\Controller\Adminhtml\AutomatedExport\Delete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \DEG\CustomReports\Api\CustomReportRepositoryInterface $customReportRepository)
    {
        $this->___init();
        parent::__construct($context, $customReportRepository);
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
