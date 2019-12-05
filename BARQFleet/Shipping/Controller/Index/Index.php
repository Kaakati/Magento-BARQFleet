<?php
namespace BARQFleet\Shipping\Controller\Index;

use BARQFleet\Shipping\Helper\Data;

class Index extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;
    protected $jsonHelper;
    protected $logger;
    private $helper;
  /**
   * Constructor
   *
   * @param \Magento\Framework\App\Action\Context  $context
   * @param \Magento\Framework\Json\Helper\Data $jsonHelper
   */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Psr\Log\LoggerInterface $logger,
        \BARQFleet\Shipping\Helper\Data $helper,
        \Magento\Framework\Json\Helper\Data $jsonHelper
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->jsonHelper = $jsonHelper;
        $this->helper = $helper;
        $this->logger = $logger;
  
        parent::__construct($context);
    }

  /**
   * Execute view action
   *
   * @return \Magento\Framework\Controller\ResultInterface
   */
    public function execute()
    {
        $api_url = $this->helper->getApiURL();
        $auth_key = $this->helper->getAuthroziationKey();
        $api_check =$this->helper->getActiveMethod();
        $this->logger->debug($api_url);
        $this->logger->debug($auth_key);
        $this->logger->debug($api_check);
        $postData = $this->getRequest()->getParam('responsecity');
        if ($api_check == 1) {
            $curl = curl_init();

            curl_setopt_array($curl, [
            CURLOPT_URL => $api_url."/api/v1/merchants/hubs",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
            "Authorization:".$auth_key,
            "Content-Type: application/json",
            "Language: ar"
            ],
            ]);
            $response_city = curl_exec($curl);
            $response = json_decode($response_city);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                  // echo "cURL Error #:" . $err;
            } else {
                foreach ($response as $values) {
                    if ($postData == $values->city->name) {
                            $var = $values->city->name;
                            print_r(json_encode($var)) ;
                             // return $var;
                    }
                }
            }
        } else {
            print_r(json_encode(0));
        }
    }
}
