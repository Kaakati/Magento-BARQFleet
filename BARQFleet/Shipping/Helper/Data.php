<?php


namespace BARQFleet\Shipping\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Shipping\Model\Config;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Module\ModuleListInterface;

class Data extends AbstractHelper
{
     /**
      * @var EncryptorInterface
      */
    protected $encryptor;
    private $api_url;
    private $auth_key;
    protected $scopeConfig;
    protected $shippingmodelconfig;
    protected $moduleList;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        EncryptorInterface $encryptor,
        Config $shippingmodelconfig,
        ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Module\ModuleListInterface $moduleList
    ) {
        parent::__construct($context);
        $this->encryptor = $encryptor;
        $this->moduleList = $moduleList;
        $this->shippingmodelconfig = $shippingmodelconfig;
        $this->scopeConfig = $scopeConfig;
       
    }

    /**
     * @return string
     */
    public function getActiveMethod()
    {
        $config = $this->scopeConfig->getValue(
            'carriers/barq/active',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
       
        return $config;
    }

    public function getAuthroziationKey()
    {
        $config = $this->scopeConfig->getValue(
            'carriers/barq/apiauthenticationkey',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return $config;
    }

    public function getExtensionVersion()
    {
        $moduleCode = 'BARQFleet_Shipping'; 
        $moduleInfo = $this->moduleList->getOne($moduleCode);
        return $moduleInfo['setup_version'];
    }

    public function getApiURL()
    {
        $config = $this->scopeConfig->getValue(
            'carriers/barq/apiurl',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        // $key = $this->encryptor->decrypt($config);
        return $config;
    }


    public function serviceCheck()
    {
        $api_url  = $this->getApiURL();
        $auth_key = $this->getAuthroziationKey();

        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => $api_url."/api/v1/merchants/info",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        ]);

        $response = curl_exec($curl);
        $decode_response = json_decode($response);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            $var = $decode_response->is_cod? 'true' : 'false';
        }
        return $var;
    }
    public function cartWeight()
    {
        $api_url  = $this->getApiURL();
        $auth_key = $this->getAuthroziationKey();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart');
        $items = $cart->getQuote()->getAllItems();

        $weight = 0;
        foreach ($items as $item) {
            $weight += ($item->getWeight() * $item->getQty()) ;
        }
        $weight = $weight/2.205;
        $curl = curl_init();

        curl_setopt_array($curl, [
          CURLOPT_URL => $api_url."/api/v1/merchants/orders/shipping/".$weight,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => false,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => [
            "Authorization:".$auth_key,
            "Content-Type: application/json"
          ],
        ]);

        $response = curl_exec($curl);
        $response_weight = curl_exec($curl);
        $response = json_decode($response_weight);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
             return "cURL Error #:" . $err;
        } else {
            $var = $response->price;
        }
        return $var;
    }
}
