<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Model;

use Exception;
use Magento\Framework\DataObject;
use Magento\Framework\Escaper;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Model\Order as SalesOrder;
use Magento\Sales\Model\Order\Item;
use Magento\Sales\Model\Order\Payment;
use Magento\Sales\Model\ResourceModel\Order\Collection;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactoryInterface;
use Magento\Store\Model\StoreManagerInterface;
use MagePal\GoogleTagManager\DataLayer\OrderData\OrderItemProvider;
use MagePal\GoogleTagManager\DataLayer\OrderData\OrderProvider;
use MagePal\GoogleTagManager\Helper\Data as GtmHelper;
use MagePal\GoogleTagManager\Helper\DataLayerItem;

/**
 * @method $this setOrderIds($orderIds)
 * @method Array getOrderIds()
 */
class Order extends DataObject
{

    /**
     * @var gtmHelper
     */
    protected $gtmHelper;

    /**
     * @var CollectionFactoryInterface
     */
    protected $_salesOrderCollection;

    /**
     * @var null
     */
    protected $_orderCollection = null;

    /** @var StoreManagerInterface */
    protected $_storeManager;

    /**
     * Escaper
     *
     * @var Escaper
     */
    protected $_escaper;

    /**
     * @var OrderProvider
     */
    protected $orderProvider;

    /**
     * @var OrderItemProvider
     */
    protected $orderItemProvider;

    protected $dataLayerItemHelper;

    /**
     * Order constructor.
     * @param CollectionFactoryInterface $salesOrderCollection
     * @param GtmHelper $gtmHelper
     * @param StoreManagerInterface $storeManager
     * @param Escaper $escaper
     * @param OrderProvider $orderProvider
     * @param OrderItemProvider $orderItemProvider
     * @param DataLayerItem $dataLayerItemHelper
     * @param array $data
     */
    public function __construct(
        CollectionFactoryInterface $salesOrderCollection,
        GtmHelper $gtmHelper,
        StoreManagerInterface $storeManager,
        Escaper $escaper,
        OrderProvider $orderProvider,
        OrderItemProvider $orderItemProvider,
        DataLayerItem  $dataLayerItemHelper,
        array $data = []
    ) {
        parent::__construct($data);
        $this->gtmHelper = $gtmHelper;
        $this->_salesOrderCollection = $salesOrderCollection;
        $this->_storeManager = $storeManager;
        $this->_escaper = $escaper;
        $this->orderProvider = $orderProvider;
        $this->orderItemProvider = $orderItemProvider;
        $this->dataLayerItemHelper = $dataLayerItemHelper;
    }

    /**
     * Render information about specified orders and their items
     *
     * @return array|bool
     * @throws NoSuchEntityException
     */
    public function getOrderLayer()
    {
        $collection = $this->getOrderCollection();

        if (!$collection) {
            return false;
        }

        $result = [];

        /* @var SalesOrder $order */

        foreach ($collection as $order) {
            $transaction = $this->getTransactionDetail($order);
            $result[] = $this->orderProvider->setOrder($order)->setTransactionData($transaction)->getData();

            // retain backward comparability with gtm.orderComplete event
            $result[] = $transaction = [
                'event' => DataLayerEvent::PURCHASE_EVENT
            ];
        }

        return $result;
    }

    public function getTransactionDetail($order)
    {
        return [
            'event' => DataLayerEvent::GTM_ORDER_COMPLETE_EVENT,
            'transactionId' => $order->getIncrementId(),
            'transactionAffiliation' => $this->_storeManager->getStore()->getFrontendName(),
            'transactionTotal' => $this->gtmHelper->formatPrice($order->getBaseGrandTotal()),
            'transactionSubTotal' => $this->gtmHelper->formatPrice($order->getBaseSubtotal()),
            'transactionShipping' => $this->gtmHelper->formatPrice($order->getBaseShippingAmount()),
            'transactionTax' => $this->gtmHelper->formatPrice($order->getTaxAmount()),
            'transactionCouponCode' => $order->getCouponCode() ? $order->getCouponCode() : '',
            'transactionDiscount' => $this->gtmHelper->formatPrice($order->getDiscountAmount()),
            'transactionProducts' => $this->getItemTransactionDetail($order),
            'order' => $this->getOrderDataLayer($order)
        ];
    }

    public function getItemTransactionDetail($order)
    {
        $products = [];
        /* @var Item $item */
        foreach ($order->getAllVisibleItems() as $item) {
            $product = [
                'sku' => $item->getSku(),
                'name' => $item->getName(),
                'price' => $this->gtmHelper->formatPrice($item->getBasePrice()),
                'quantity' => $item->getQtyOrdered() * 1
            ];

            if ($category = $this->dataLayerItemHelper->getFirstCategory($item)) {
                $product['category'] = $category;
            }

            $products[] = $this->orderItemProvider
                ->setItem($item)
                ->setItemData($product)
                ->setListType(OrderItemProvider::LIST_TYPE_GOOGLE)
                ->getData();
        }

        return $products;
    }

    /**
     * Get order collection
     *
     * @return bool|Collection|null
     */
    public function getOrderCollection()
    {
        $orderIds = $this->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds)) {
            return false;
        }

        if (!$this->_orderCollection) {
            $this->_orderCollection = $this->_salesOrderCollection->create();
            $this->_orderCollection->addFieldToFilter('entity_id', ['in' => $orderIds]);
        }

        return $this->_orderCollection;
    }

    /**
     * Escape quotes in java scripts
     *
     * @param string|array $data
     * @param string $quote
     * @return string|array
     */
    public function escapeJsQuote($data, $quote = '\'')
    {
        return $this->_escaper->escapeJsQuote($this->escapeReturn($data), $quote);
    }

    /**
     * @param $data
     * @return string
     */
    public function escapeReturn($data)
    {
        return trim(str_replace(["\r\n", "\r", "\n"], ' ', $data));
    }

    /**
     * @param SalesOrder $order
     * @return array
     * @throws NoSuchEntityException
     */
    public function getOrderDataLayer(SalesOrder $order)
    {
        /* @var SalesOrder $order */
        /* @var Item $item */
        $products = [];
        foreach ($order->getAllVisibleItems() as $item) {
            $product = [
                'sku' => $item->getSku(),
                'id' => $item->getSku(),
                'parent_sku' => $item->getProduct() ? $item->getProduct()->getData('sku') : $item->getSku(),
                'name' => $item->getProductOptionByCode('simple_name') ?: $item->getName(),
                'parent_name' => $item->getName(),
                'price' => $this->gtmHelper->formatPrice($item->getBasePrice()),
                'price_incl_tax' => $this->dataLayerItemHelper->formatPrice($item->getPriceInclTax()),
                'quantity' => $item->getQtyOrdered() * 1,
                'subtotal' => $this->gtmHelper->formatPrice($item->getBaseRowTotal()),
                'product_type' => $item->getProductType(),
                'product_id' => $item->getProductId(),
                'discount_amount' => $this->gtmHelper->formatPrice($item->getDiscountAmount()),
                'discount_percent' => $this->gtmHelper->formatPrice($item->getDiscountPercent()),
                'tax_amount' => $this->gtmHelper->formatPrice($item->getTaxAmount()),
                'is_virtual' => $item->getIsVirtual() ? true : false,
            ];

            if ($variant = $this->dataLayerItemHelper->getItemVariant($item)) {
                $product['variant'] = $variant;
            }

            if ($categories = $this->dataLayerItemHelper->getCategories($item)) {
                $product['categories'] = $categories;
            }

            $products[] = $this->orderItemProvider
                                ->setItem($item)
                                ->setItemData($product)
                                ->setListType(OrderItemProvider::LIST_TYPE_GENERIC)
                                ->getData();
        }

        return [
            'order_id' => $order->getIncrementId(),
            'store_name' => $this->_storeManager->getStore()->getFrontendName(),
            'total' => $this->gtmHelper->formatPrice($order->getBaseGrandTotal()),
            'subtotal' => $this->gtmHelper->formatPrice($order->getBaseSubtotal()),
            'shipping' => $this->gtmHelper->formatPrice($order->getBaseShippingAmount()),
            'tax' => $this->gtmHelper->formatPrice($order->getTaxAmount()),
            'coupon_code' => $order->getCouponCode() ?: '' ,
            'coupon_name' => $order->getDiscountDescription() ?: '',
            'discount' => $this->gtmHelper->formatPrice($order->getDiscountAmount()),
            'payment_method' => $this->getPaymentMethod($order),
            'shipping_method' => ['title' => $order->getShippingDescription(), 'code' => $order->getShippingMethod()],
            'is_virtual' => $order->getIsVirtual() ? true : false,
            'is_guest_checkout' => $order->getCustomerIsGuest() ? true : false,
            'items' => $products
        ];
    }

    /**
     * @param $order
     * @return array
     */
    public function getPaymentMethod(SalesOrder $order)
    {
        try {
            /** @var Payment $payment */
            $payment = $order->getPayment();
            $method = $payment->getMethodInstance();

            $method = [
                'title' => $method->getTitle(),
                'code' => $method->getCode()
            ];
        } catch (Exception $e) {
            $method = [
                'title' => '',
                'code' => ''
            ];
        }

        return $method;
    }
}
