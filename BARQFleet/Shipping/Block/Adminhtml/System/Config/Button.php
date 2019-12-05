<?php
namespace BARQFleet\Shipping\Block\Adminhtml\System\Config;

class Button extends \Magento\Config\Block\System\Config\Form\Field
{


    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate('system/config/button.phtml');
        }

        return $this;
    }

    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return $this->_toHtml();
    }
}
