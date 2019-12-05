<?php


namespace BARQFleet\Shipping\Controller\Index;

class Cashondelivery extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;
    protected $jsonHelper;
    protected $dataHelper;
    protected $checklogger;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \BARQFleet\Shipping\Helper\Data $dataHelper,
        \Psr\Log\LoggerInterface $checklogger,
        \Magento\Framework\Json\Helper\Data $jsonHelper
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->jsonHelper = $jsonHelper;
        $this->dataHelper = $dataHelper;
        $this->checklogger = $checklogger;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
      //   try {
      
        $check = $this->dataHelper->ServiceCheck();
        $this->checklogger->debug($check);
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart');
        $quote = $cart->getQuote();
        $items = $cart->getQuote()->getAllItems();
        $weight = 0;
        foreach ($items as $item) {
            $weight += ($item->getWeight() * $item->getQty()) ;
        }
        $weight = $weight/2.205;

        $shippingMethod = $quote->getShippingAddress()->getShippingMethod();
        
        if ($shippingMethod=="barq_barq" && $check == "false") {
            $result = 1;
            $response = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON)->setData([
                'state' => $result,
                'weight' => $weight
                    ]);
        } elseif ($shippingMethod=="barq_barq" && $check == "true") {
            $result = 0;
            $response = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON)->setData([
                'state' => $result,
                'weight' => $weight
                    ]);
        } else {
            $result = 0;
            $response = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON)->setData([
                'state' => $result,
                'weight' => $weight
                    ]);
        }
        return $response;
    }
}
