<?php
namespace BARQFleet\Shipping\Plugin\Checkout\Model\Checkout;

class LayoutProcessor
{
    /**
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {
    
        // $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        // ['shippingAddress']['children']['shipping-address-fieldset']['children']['city'] = [
        //     'component' => 'Magento_Ui/js/form/element/select',
        //     'config' => [
        //         'customScope' => 'shippingAddress',
        //         'template' => 'ui/form/field',
        //         'elementTmpl' => 'ui/form/element/select',
        //         'id' => 'city'
        //     ],
        //     'dataScope' => 'shippingAddress.city',
        //     'label' => 'City',
        //     'provider' => 'checkoutProvider',
        //     'visible' => true,
        //     'validation' => [ 'required-entry' => true ],
        //     'sortOrder' => 251,
        //     'id' => 'city',
            
        // ];

        // $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        // ['shippingAddress']['children']['shipping-address-fieldset']['children']['country_id']=[
        //     'component' => 'Magento_Ui/js/form/element/select',
        //     'config' => [
        //         'customScope' => 'shippingAddress',
        //         'template' => 'ui/form/field',
        //         'elementTmpl' => 'ui/form/element/select',
        //         'id' => 'country_id'
        //     ],
        //     'dataScope' => 'shippingAddress.country_id',
        //     'label' => 'Country',
        //     'provider' => 'checkoutProvider',
        //     'visible' => true,
        //     'validation' => [ 'required-entry' => true ],
        //     'sortOrder' => 250,
        //     'id' => 'country_id',
        //     'options' => [
        //         [
        //             'value' => '',
        //             'label' => 'Please Select',
        //         ],
        //         [
        //             'value' => 'US',
        //             'label' => 'United States',
        //         ],
        //         [
        //             'value' => 'CA',
        //             'label' => 'Canada',
        //         ]
        //     ]
        // ];
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
         ['shippingAddress']['children']['shipping-address-fieldset']['children']['custom_cities'] =
         [
         'component' => 'Magento_Ui/js/form/element/select',
         
         'config' => [
                'customScope' => 'shippingAddress',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
                'id' => 'custom_cities'
            ],
         'dataScope' => 'shippingAddress.custom_cities',
         'label' => 'City',
         'provider' => 'checkoutProvider',
         'visible' => true,
         'validation' => [],
         'sortOrder' => 100,
         'id' => 'custom_cities',
         'options' => [
                [
                    'value' => 'Riyadh',
                    'label' => 'Riyadh',
                ],
                [
                    'value' => 'Dammam',
                    'label' => 'Dammam',
                ],
                [
                    'value' => 'Safwa',
                    'label' => 'Safwa',
                ],
                [
                    'value' => 'Al Qatif',
                    'label' => 'Al Qatif',
                ],
                [
                    'value' => 'Dhahran',
                    'label' => 'Dhahran',
                ],
                [
                    'value' => 'Al Faruq',
                    'label' => 'Al Faruq',
                ],
                [
                    'value' => 'Khobar',
                    'label' => 'Khobar',
                ],
                [
                    'value' => 'Jubail',
                    'label' => 'Jubail',
                ],
                [
                    'value' => 'Sayhat',
                    'label' => 'Sayhat',
                ],
                [
                    'value' => 'Jeddah',
                    'label' => 'Jeddah',
                ],
                [
                    'value' => 'Taif',
                    'label' => 'Taif',
                ],
                [
                    'value' => 'Mecca',
                    'label' => 'Mecca',
                ],
                [
                    'value' => 'Al Hufuf',
                    'label' => 'Al Hufuf',
                ],
                [
                    'value' => 'Medina',
                    'label' => 'Medina',
                ],
                [
                    'value' => 'Rahimah',
                    'label' => 'Rahimah',
                ],
                [
                    'value' => 'Rabigh',
                    'label' => 'Rabigh',
                ],
                [
                    'value' => 'Yanbu',
                    'label' => 'Yanbu',
                ],
                [
                    'value' => 'al Bahr',
                    'label' => 'Al Bahr',
                ],
                [
                    'value' => 'Abqaiq',
                    'label' => 'Abqaiq',
                ],
                [
                    'value' => 'Mina',
                    'label' => 'Mina',
                ],
                [
                    'value' => 'Ramdah',
                    'label' => 'Ramdah',
                ],
                [
                    'value' => 'Linah',
                    'label' => 'Linah',
                ],
                [
                    'value' => 'Abha',
                    'label' => 'Abha',
                ],
                [
                    'value' => 'Jizan',
                    'label' => 'Jizan',
                ],
                [
                    'value' => 'Tabuk',
                    'label' => 'Tabuk',
                ],
                [
                    'value' => 'Sambah',
                    'label' => 'Sambah',
                ],
                [
                    'value' => 'Ras Tanura',
                    'label' => 'Ras Tanura',
                ],
                [
                    'value' => 'At Tuwal',
                    'label' => 'At Tuwal',
                ],
                [
                    'value' => 'Jizan',
                    'label' => 'Jizan',
                ],
                [
                    'value' => 'Al Yamamah',
                    'label' => 'Al Yamamah',
                ],
                [
                    'value' => 'Tabuk',
                    'label' => 'Tabuk',
                ],
                [
                    'value' => 'Sambah',
                    'label' => 'Sambah',
                ],
                [
                    'value' => 'Ras Tanura',
                    'label' => 'Ras Tanura',
                ],
                [
                    'value' => 'At Tuwal',
                    'label' => 'At Tuwal',
                ],
                [
                    'value' => 'Sabya',
                    'label' => 'Sabya',
                ],
                [
                    'value' => 'Buraidah',
                    'label' => 'Buraidah',
                ],
                [
                    'value' => 'Madinat Yanbu',
                    'label' => 'Madinat Yanbu',
                ],
                [
                    'value' => 'Hayil',
                    'label' => 'Hayil',
                ],
                [
                    'value' => 'Ras Tanura',
                    'label' => 'Ras Tanura',
                ],
                [
                    'value' => 'At Tuwal',
                    'label' => 'At Tuwal',
                ],
                [
                    'value' => 'Sabya',
                    'label' => 'Sabya',
                ],
                [
                    'value' => 'Buraidah',
                    'label' => 'Buraidah',
                ],
                [
                    'value' => 'Madinat Yanbu',
                    'label' => 'Madinat Yanbu',
                ],

                [
                    'value' => 'Hayil',
                    'label' => 'Hayil',
                ],
                [
                    'value' => 'Khulays',
                    'label' => 'Khulays',
                ],
                [
                    'value' => 'Khamis Mushait',
                    'label' => 'Khamis Mushait',
                ],
                [
                    'value' => 'Sabya',
                    'label' => 'Sabya',
                ],
                [
                    'value' => 'Ras al Khafji',
                    'label' => 'Ras al Khafji',
                ],
                [
                    'value' => 'Najran',
                    'label' => 'Najran',
                ],
                 [
                    'value' => 'Sakaka',
                    'label' => 'Sakaka',
                 ],
                [
                    'value' => 'Al Bahah',
                    'label' => 'Al Bahah',
                ],
                [
                    'value' => 'Rahman',
                    'label' => 'Rahman',
                ],
                [
                    'value' => 'Jazirah',
                    'label' => 'Jazirah',
                ]
            ]
         ];
        return $jsLayout;
    }
}
