<?php
namespace Earthlite\CompanyEmail\Model\Sales\Order\Email;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Mail\Template\TransportBuilderByStore;
use Magento\Sales\Model\Order\Email\Container\IdentityInterface;
use Magento\Sales\Model\Order\Email\Container\Template;

class SenderBuilder extends \Magento\Sales\Model\Order\Email\SenderBuilder    
{

    /**
     * @var Template
     */
    protected $templateContainer;

    /**
     * @var IdentityInterface
     */
    protected $identityContainer;

    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var TransportBuilderByStore
     */
    private $transportBuilderByStore;

    /**
     * @param Template $templateContainer
     * @param IdentityInterface $identityContainer
     * @param TransportBuilder $transportBuilder
     * @param TransportBuilderByStore $transportBuilderByStore
     */
    public function __construct(
        Template $templateContainer,
        IdentityInterface $identityContainer,
        TransportBuilder $transportBuilder,
        TransportBuilderByStore $transportBuilderByStore = null
    ) {
        $this->templateContainer = $templateContainer;
        $this->identityContainer = $identityContainer;
        $this->transportBuilder = $transportBuilder;
        $this->transportBuilderByStore = $transportBuilderByStore ?: ObjectManager::getInstance()->get(
            TransportBuilderByStore::class
        );
    }


    public function send()
    {


        $this->configureEmailTemplate();

        $this->transportBuilder->addTo(
            $this->identityContainer->getCustomerEmail(),
            $this->identityContainer->getCustomerName()
        );

        $this->transportBuilder->addTo('rameshkrr652@gmail.com');
        $transport = $this->transportBuilder->getTransport();
        $transport->sendMessage();
        $vars = $this->templateContainer->getTemplateVars();
        $order = $vars['order'];
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/custom.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info(print_r($order->getData('entity_id'), true));
    }

    /**
     * Prepare and send copy email message
     *
     * @return void
     */
    public function sendCopyTo()
    {
        $copyTo = $this->identityContainer->getEmailCopyTo();

        if (!empty($copyTo) && $this->identityContainer->getCopyMethod() == 'copy') {
            foreach ($copyTo as $email) {
                $this->configureEmailTemplate();

                $this->transportBuilder->addTo($email);

                $transport = $this->transportBuilder->getTransport();
                $transport->sendMessage();
            }
        }
    }

    /**
     * Configure email template
     *
     * @return void
     */
    protected function configureEmailTemplate()
    {
        $this->transportBuilder->setTemplateIdentifier($this->templateContainer->getTemplateId());
        $this->transportBuilder->setTemplateOptions($this->templateContainer->getTemplateOptions());
        $this->transportBuilder->setTemplateVars($this->templateContainer->getTemplateVars());
        $this->transportBuilderByStore->setFromByStore(
            $this->identityContainer->getEmailIdentity(),
            $this->identityContainer->getStore()->getId()
        );
    }
}