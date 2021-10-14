<?php
namespace Mageplaza\ImageOptimizer\Console\Command\Scan;

/**
 * Interceptor class for @see \Mageplaza\ImageOptimizer\Console\Command\Scan
 */
class Interceptor extends \Mageplaza\ImageOptimizer\Console\Command\Scan implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mageplaza\ImageOptimizer\Helper\Data $helperData, \Mageplaza\ImageOptimizer\Model\ResourceModel\Image $resourceModel, \Psr\Log\LoggerInterface $logger, ?string $name = null)
    {
        $this->___init();
        parent::__construct($helperData, $resourceModel, $logger, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function run(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'run');
        if (!$pluginInfo) {
            return parent::run($input, $output);
        } else {
            return $this->___callPlugins('run', func_get_args(), $pluginInfo);
        }
    }
}
