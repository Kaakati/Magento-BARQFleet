<?php
namespace BARQFleet\Shipping\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Sales\Setup\SalesSetupFactory;
use Magento\Quote\Setup\QuoteSetupFactory;

class InstallData implements InstallDataInterface
{
    /**
     * @var Magento\Sales\Setup\SalesSetupFactory
     */
    protected $_salesSetupFactory;

    /**
     * @var Magento\Quote\Setup\QuoteSetupFactory
     */
    protected $_quoteSetupFactory;

    /**
     * @param SalesSetupFactory $salesSetupFactory
     * @param QuoteSetupFactory $quoteSetupFactory
     */
    public function __construct(
        SalesSetupFactory $salesSetupFactory,
        QuoteSetupFactory $quoteSetupFactory
    ) {
        $this->_salesSetupFactory = $salesSetupFactory;
        $this->_quoteSetupFactory = $quoteSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context) {

        /* @var \Magento\Sales\Setup\SalesSetup $salesInstaller */
        $salesInstaller = $this->_salesSetupFactory
                        ->create(
                            [
                                'resourceName' => 'sales_setup',
                                'setup' => $setup
                            ]
                        );
        /* @var \Magento\Quote\Setup\QuoteSetup $quoteInstaller */
        $quoteInstaller = $this->_quoteSetupFactory
                        ->create(
                            [
                                'resourceName' => 'quote_setup',
                                'setup' => $setup
                            ]
                        );

        $this->addQuoteAttributes($quoteInstaller);
        $this->addOrderAttributes($salesInstaller);
    }

    /**
     * add attribute in quote address
     * @param object $installer
     */
    public function addQuoteAttributes($installer) {
        $installer->addAttribute('quote_address', 'barq_id', ['type' => 'text']);
        $installer->addAttribute('quote_address', 'barq_tracking', ['type' => 'text']);
    }

    /**
     * add attribute in sales_order
     * @param object $installer
     */
    public function addOrderAttributes($installer) {
        $installer->addAttribute('order', 'barq_id', ['type' => 'text']);
        $installer->addAttribute('order', 'barq_tracking', ['type' => 'text']);
    }
}