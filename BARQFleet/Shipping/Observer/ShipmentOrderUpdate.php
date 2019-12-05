<?php
namespace BARQFleet\Shipping\Observer;


use Magento\Framework\Event\ObserverInterface;

class ShipmentOrderUpdate implements ObserverInterface
{


    private $helper;
    protected $logger;
    private $trackFactory;
    

    public function __construct(\BARQFleet\Shipping\Helper\Data $helper,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Sales\Model\Order\Shipment\TrackFactory $trackFactory) {
        $this->helper = $helper;
        $this->logger = $logger;
        $this->trackFactory = $trackFactory;
     }



    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $shipment = $observer->getEvent()->getShipment();
        $order = $shipment->getOrder();

        // $order = $observer->getEvent()->getOrder();
        $order_ids = $order->getBarqId();
        $barq_track =$order->getBarqTracking();
        $shippment_type = $order->getShippingMethod();

        // print_r($barq_track);
        // print_r("-----");
        // print_r($shippment_type);
        // die("afdsdsf");
        // $track = $this->_trackFactory->create();
        // $track->setCarrierCode($payment);
        // $track->setDescription($payment);
        // $track->setTrackNumber($barq_track);
        // $shipment->addTrack($track);
        // $this->_shipmentRepository->save($shipment);

        if ($shippment_type == 'barq_barq'){
        $data = array(
                'carrier_code' => 'BARQ Delivery',
                'title' => 'Instant Delivery',
                'number' => $barq_track, // Replace with your tracking number
              );

        $track = $this->trackFactory->create()->addData($data);
        print_r($data);
         
      
        $shipment->addTrack($track);
        $shipment->save();

        

         $api_url  = $this->helper->getApiURL();
         $auth_key = $this->helper->getAuthroziationKey();

          $curl = curl_init();

          curl_setopt_array($curl, array(
          CURLOPT_URL => $api_url."/api/v1/merchants/orders/".$order_ids,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => false,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS =>"{\n\t\"order_status\" : 2\n}",
          CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization:".$auth_key
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          // echo "cURL Error #:" . $err;
        } else {
          // echo $response;
            $this->logger->debug("Invoice genereted adf");

        }
        }
       
    }
}