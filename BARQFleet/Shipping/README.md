# Mage2 Module BARQFleet Delivery

    ``BARQFleet/module-shipping``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities


## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/BARQFleet`
 - Enable the module by running `php bin/magento module:enable BARQFleet_Shipping`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Make the module available in a composer repository for barq:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require BARQFleet/module-shipping`
 - enable the module by running `php bin/magento module:enable BARQFleet_Shipping`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration

 - enable_disable (module_enable_disable/general/enable_disable)

 - authorization_key (module_enable_disable/general/authorization_key)


## Specifications




## Attributes



