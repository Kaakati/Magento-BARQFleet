<?php

namespace BARQFleet\Shipping\Observer;

use Magento\Framework\Event\ObserverInterface;

class PaymentMethodAvailable implements ObserverInterface
{
    private $logger;
    private $shippingMethod;
    protected $objectManager;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Quote\Api\Data\ShippingMethodInterface $shippingMethod
    ) {
        $this->logger = $logger;
        $this->shippingMethod = $shippingMethod;
        $this->objectManager =$objectManager;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cart = $this->objectManager->get('\Magento\Checkout\Model\Cart');

        $quote = $cart->getQuote();
        $shippingMethod = $quote->getShippingAddress()->getShippingMethod();
        // you can replace "checkmo" with your required payment method code
        $payment_method=$observer->getEvent()->getMethodInstance()->getCode();
        // $this->logger->debug($ship);
         $methodTitle = $this->shippingMethod->getMethodTitle();
         $this->logger->debug($shippingMethod);
        // if($observer->getEvent()->getMethodInstance()->getCode()=="checkmo"){
        //     $checkResult = $observer->getEvent()->getResult();
        //     $checkResult->setData('is_available', false); //this is disabling the payment method at checkout page
        // }
        // if($shippingMethod=="barq_barq"){
        //         if($payment_method =="cashondelivery"){
        //         $checkResult = $observer->getEvent()->getResult();
        //         $checkResult->setData('is_available', false);
        //    }
        //    elseif($shippingMethod!="barq_barq"){

        //         $checkResult = $observer->getEvent()->getResult();
        //         $checkResult->setData('is_available', true);
        //    }
        //  }
    }
}
