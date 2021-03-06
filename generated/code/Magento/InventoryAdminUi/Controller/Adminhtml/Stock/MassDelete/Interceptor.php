<?php
namespace Magento\InventoryAdminUi\Controller\Adminhtml\Stock\MassDelete;

/**
 * Interceptor class for @see \Magento\InventoryAdminUi\Controller\Adminhtml\Stock\MassDelete
 */
class Interceptor extends \Magento\InventoryAdminUi\Controller\Adminhtml\Stock\MassDelete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\InventoryApi\Api\StockRepositoryInterface $stockRepository, \Magento\InventoryAdminUi\Ui\Component\MassAction\Filter $massActionFilter)
    {
        $this->___init();
        parent::__construct($context, $stockRepository, $massActionFilter);
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
