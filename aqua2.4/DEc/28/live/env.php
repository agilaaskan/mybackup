<?php
return [
    'backend' => [
        'frontName' => '5h0a7kbhs'
    ],
    'crypt' => [
        'key' => '6959e33a595846e735fafdbc0f4b3802
b70cf9c5bad1bfd6bcc8a097dbf4e369
472fca868dd5aee6fbbc96ca4f84f565
d7a883f85be672e69a50c8cced827099
d92b29d8d8492cdb7eeaee50e8c10b58
15a02b2c4c0e0f631c2e0e61f53b4cdc
681db00dd74216f50a99bbfd726dc789'
    ],
    'db' => [
        'table_prefix' => '',
        'connection' => [
            'default' => [
                'host' => 'localhost',
                'dbname' => 'a55d528a_m2newlive',
                'username' => 'a55d528a_m2newl',
                'password' => 'nRf?K#-vstN!',
                'active' => '1',
                'model' => 'mysql4',
                'engine' => 'innodb',
                'initStatements' => 'SET NAMES utf8;'
            ]
        ]
    ],
    'resource' => [
        'default_setup' => [
            'connection' => 'default'
        ]
    ],
    'x-frame-options' => 'SAMEORIGIN',
    'MAGE_MODE' => 'production',
    'session' => [
        'save' => 'db'
    ],
    'cache' => [
        'frontend' => [
            'default' => [
                'id_prefix' => '7b5_',
                'backend' => 'Magento\\Framework\\Cache\\Backend\\Redis',
                'backend_options' => [
                    'server' => '10.75.112.102',
                    'database' => '0',
                    'port' => '21666'
                ]
            ],
            'page_cache' => [
                'id_prefix' => '7b5_',
                'backend' => 'Cm_Cache_Backend_Redis',
                'backend_options' => [
                    'server' => '10.75.112.102',
                    'port' => '21666',
                    'database' => '1',
                    'compress_data' => '0',
                    'password' => '',
                    'compression_lib' => ''
                ]
            ]
        ]
    ],
    'lock' => [
        'provider' => 'db',
        'config' => [
            'prefix' => ''
        ]
    ],
    'cache_types' => [
        'config' => 1,
        'layout' => 1,
        'block_html' => 1,
        'collections' => 1,
        'reflection' => 1,
        'db_ddl' => 1,
        'compiled_config' => 1,
        'eav' => 1,
        'customer_notification' => 1,
        'config_integration' => 1,
        'config_integration_api' => 1,
        'google_product' => 1,
        'full_page' => 1,
        'config_webservice' => 1,
        'translate' => 1,
        'vertex' => 1,
        'wp_gtm_categories' => 1
    ],
    'downloadable_domains' => [
        'localhost'
    ],
    'install' => [
        'date' => 'Wed, 27 May 2020 11:29:02 +0000'
    ]
];
