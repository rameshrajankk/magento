<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Salesfilter\Grid\Controller\Adminhtml\Index;


class Index extends \Magento\Backend\App\Action
{

    const COOKIE_NAME = 'Allorders_cookie';
    const COOKIE_DURATION = 86400; 
    const COOKIE_PATH = '/admin/sales/order/index/allorders/yes/'; 
 
    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context  $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
        \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $cookieMetadataFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_cookieManager = $cookieManager;
        $this->_cookieMetadataFactory = $cookieMetadataFactory;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $metadata = $this->_cookieMetadataFactory->createPublicCookieMetadata()->setDuration(self::COOKIE_DURATION)->setPath(self::COOKIE_PATH);
        $this->_cookieManager->setPublicCookie(self::COOKIE_NAME,'1',$metadata);  
         $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('sales/order/index/status/processing');
        return $resultRedirect;
    }
}

