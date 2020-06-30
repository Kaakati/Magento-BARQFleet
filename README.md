<img alt="BARQ Fleet, same-day delivery method for magento merchants." src="https://live.barqfleet.com/assets/public_logo-d564ac623c57cef2756f66af7db619c03d8f7aa657bd00300650bc2820d57682.svg" height="120px">

### BARQ Fleet, Magento Shipping Module
Magento 2 BARQ Shipping Module, Allows merchants to deliver their products using [BARQFleet.com](https://www.barqfleet.com) as a delivery service.

### How to Install the module in Magento 2
- Download the module into your machine.
- You will have a Folder named `BARQFleet` and contains a folder named `Shipping`
- In your magento platform, go to `app/code/` and place the `BARQFleet` folder inside it, if `code` does not exist, create one.

Using SSH Terminal in your Magento 2 platform

**Run the following commands in order**

<ol>
<li><pre>sudo php -dmemory_limit=5G bin/magento s:up</pre></li>
<li><pre>sudo php -dmemory_limit=5G bin/magento s:d:c</pre></li>
<li><pre>sudo chmod -R 777 var/ generated/ pub/</pre></li>
<li><pre>sudo php bin/magento c:c</pre></li>
<li><pre>sudo php bin/magento c:f</pre></li>
</ol>

### Configuring the module in your Magento admin:
- From Magento 2 Admin Sidebar, Go to **Stores > Settings > Configrations**
- Go to **Sales > Shipping Methods**
- Select **BARQ Delivery**
- You'll need to enable the module and set name as **Same-day Delivery** Method Name: **BARQ Delivery**
- Ship to applicable countries: **Specific Countries** then select **Saudi Arabia**
- Acquire your API URL and Authorization Key from your Account Manager.
