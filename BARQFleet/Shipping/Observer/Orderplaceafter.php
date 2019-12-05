<?php 

namespace BARQFleet\Shipping\Observer;

use Magento\Framework\Event\ObserverInterface;
use BARQFleet\Shipping\Helper\Data;


class Orderplaceafter implements ObserverInterface
{

 private $helper;
 protected $logger;
 protected $trackFactory;


 
 public function __construct(\BARQFleet\Shipping\Helper\Data $helper,
  \Psr\Log\LoggerInterface $logger) {
  $this->helper = $helper;
  $this->logger = $logger;
  // $this->trackFactory = $trackFactory;

}

public function execute(\Magento\Framework\Event\Observer $observer){
 try {  

  $api_url = $this->helper->getApiURL();
  $auth_key = $this->helper->getAuthroziationKey();



  $objectManager = (\Magento\Framework\App\ObjectManager::getInstance());
  // $moduleInfo =  $this->objectManager->get('\Magento\Framework\Module\ModuleList')->getOne('BARQFleet_Shipping')[setup_version]; 
  // print_r($moduleInfo);
  

  $version = $this->helper->getExtensionVersion();


  $cart = $objectManager->get('\Magento\Checkout\Model\Cart');
  $items = $cart->getQuote()->getAllVisibleItems();

  

  $delivery_fee = $this->helper->cartWeight();
  $order = $observer->getEvent()->getOrder();

  $order_id = $order->getEntityId();
  $payment = $order->getPayment();
  $GrandTotal = $order->getGrandTotal();
  $method = $payment->getMethodInstance();
  $payment_type = $payment->getMethod();

  $shippingAddress = $order->getShippingAddress();
  $shippment_type = $order->getShippingMethod();
  $merchant_order_id = $order->getIncrementId();
  $city = $shippingAddress->getCity();
  $first_name = $shippingAddress->getFirstname();
  $last_name = $shippingAddress->getLastname();
  $email = $shippingAddress->getEmail();
  $phone = $shippingAddress->getTelephone();
  $country_code = $shippingAddress->getCountryId();   




  $customerInfo = array('first_name' => $first_name,
    'last_name' => $last_name,
    'country' => $country_code,
    'city' => $city,
    'mobile' => $phone);



  $product = [];
  $weight = 0;
  // $orderItems = $order->getAllItems();
  // $orderItems = $order->getAllVisibleItems();

  foreach ($items as $item) {
    $sku = $item->getSku();
    $serial_id = $item->getProductId();
    $product_name = $item->getName();
    $product_price = $item->getPrice();
    $quantity = $item->getQty();



    $weight += ($item->getWeight() * $item->getQty()) ;
    $weight = $weight/2.205;

    $items = array('sku'=>$sku, 
      'serial_no'=>$serial_id, 
      'name'=>$product_name, 
      'color'=>'',
      'price'=>$product_price,
      'weight_kg'=>$weight, 
      'brand'=>'',
      'qty'=> 1);

    for($count=0 ; $count < $quantity ;$count++ ){
    array_push($product, $items);}
    
  }
 


  // $origin = array(
  //   'latitude' => 24.3647,
  //   'longitude'=> 42.8372151
  // );  

  // $destination = array('latitude' => 24.3647,
  //   'longitude'=> 42.8372151
  // );  


  if ($shippment_type =='barq_barq')  {
   
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => $api_url."/api/v1/merchants/hubs/",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => false,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Authorization:".$auth_key,
      "Content-Type: application/json",
      "Language: ar",
      "Version:".$version
    ),
  ));
   $response_city = curl_exec($curl);
   $response = json_decode($response_city);
   $err = curl_error($curl);
   curl_close($curl);
   if ($err) {
                  // echo "cURL Error #:" . $err;
   } else {
    foreach ($response as $values) {
     if ($city == $values->city->name) {
      $var = $values->city->name;
      $hub_id = $values->id;

      $post = array('grand_total' => $GrandTotal,
        'delivery_fee' => $delivery_fee,
        'payment_type' => 0,
        'shipment_type' => 0,
        'hub_id' => $hub_id,
        'merchant_order_id' => $merchant_order_id,
        'merchant_tracking_no' => '',
        'customer_details' => $customerInfo,
        'products' => $product
        // 'origin' => $origin,
        // 'destination' => $destination
      );
      $post = json_encode($post);

      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => $api_url."/api/v1/merchants/orders",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST"  ,
        CURLOPT_POSTFIELDS => $post,


        CURLOPT_HTTPHEADER => array(
          "Content-Type: application/json",
          "Authorization:".$auth_key
        ),
      ));

      $response = curl_exec($curl);
      $response = json_decode($response);

      $err = curl_error($curl);
      curl_close($curl);

      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
          $this->logger->debug($response->id);

       $order ->setBarqId($response->id);   
       $order ->setBarqTracking($response->tracking_no);       
       $order->save();

       $order_ids = $order->getBarqId();
       $order_tracking = $order->getBarqTracking();
               // print_r("--");
               // print_r("--");
       // $this ->logger ->debug($order_ids);
               // print_r($order_ids);
               // print_r("--");
               // print_r("--");
               // print_r($order_tracking);


     }
   }
 }
} }


}
catch (Exception $e) {
    // $this->logger->debug($e->getMessage());
}
}
}