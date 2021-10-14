<?php
namespace Magento\Checkout\Api\Data;

/**
 * Extension class for @see \Magento\Checkout\Api\Data\ShippingInformationInterface
 */
class ShippingInformationExtension extends \Magento\Framework\Api\AbstractSimpleObject implements ShippingInformationExtensionInterface
{
    /**
     * @return string|null
     */
    public function getSelectedDeliveryTimestamp()
    {
        return $this->_get('selected_delivery_timestamp');
    }

    /**
     * @param string $selectedDeliveryTimestamp
     * @return $this
     */
    public function setSelectedDeliveryTimestamp($selectedDeliveryTimestamp)
    {
        $this->setData('selected_delivery_timestamp', $selectedDeliveryTimestamp);
        return $this;
    }
}
