<?php
namespace BARQFleet\Shipping\Model\Config\Source;

class CountryList implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
        ['value' => 'Saudia Arabia', 'label' => __('Saudia Arabia')]
        ];
    }
}
