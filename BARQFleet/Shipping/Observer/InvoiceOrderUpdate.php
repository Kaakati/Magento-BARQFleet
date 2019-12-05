<?php

namespace BARQFleet\Shipping\Observer;

use Magento\Framework\Event\ObserverInterface;
use BARQFleet\Shipping\Helper\Data;

class InvoiceOrderUpdate implements ObserverInterface
{   

private $helper;
protected $logger;

public function __construct(\BARQFleet\Shipping\Helper\Data $helper,
	\Psr\Log\LoggerInterface $logger) {
	$this->helper = $helper;
	$this->logger = $logger;
 }
 


public function execute(\Magento\Framework\Event\Observer $observer)
{
      $invoice = $observer->getEvent()->getInvoice();
      $order = $invoice->getOrder();

	// $order = $observer->getEvent()->getOrder();
     $order_ids = $order->getBarqId();
     $shippment_type = $order->getShippingMethod();



     $this->logger->debug($order_ids);


     $api_url  = $this->helper->getApiURL();
     $auth_key = $this->helper->getAuthroziationKey();

      $curl = curl_init();

      if($shippment_type == 'barq_barq'){

      curl_setopt_array($curl, array(
	  CURLOPT_URL => $api_url."/api/v1/merchants/orders/".$order_ids,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => false,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS =>"{\n\t\"order_status\" : 1\n}",
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
		$this->logger->debug("Shipment genereted adf");
	}}

	  

     /* reset total_paid & base_total_paid of order */
     // $order->setTotalPaid($order->getTotalPaid() - $invoice->getGrandTotal());
     // $order->setBaseTotalPaid($order->getBaseTotalPaid() - $invoice->getBaseGrandTotal());
}    
}