<?php
namespace DEG\CustomReports\Controller\Adminhtml\AutomatedExport\Save;

/**
 * Interceptor class for @see \DEG\CustomReports\Controller\Adminhtml\AutomatedExport\Save
 */
class Interceptor extends \DEG\CustomReports\Controller\Adminhtml\AutomatedExport\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor, \DEG\CustomReports\Api\AutomatedExportRepositoryInterface $automatedExportRepository, \DEG\CustomReports\Api\Data\AutomatedExportInterfaceFactory $automatedExportFactory)
    {
        $this->___init();
        parent::__construct($context, $dataPersistor, $automatedExportRepository, $automatedExportFactory);
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
