<?php
namespace Magento\Checkout\Api\Data;

/**
 * ExtensionInterface class for @see \Magento\Checkout\Api\Data\ShippingInformationInterface
 */
interface ShippingInformationExtensionInterface extends \Magento\Framework\Api\ExtensionAttributesInterface
{
    /**
     * @return string|null
     */
    public function getSelectedDeliveryTimestamp();

    /**
     * @param string $selectedDeliveryTimestamp
     * @return $this
     */
    public function setSelectedDeliveryTimestamp($selectedDeliveryTimestamp);
}
