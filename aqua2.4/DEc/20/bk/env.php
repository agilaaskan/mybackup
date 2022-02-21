<?php
return [
    'backend' => [
        'frontName' => 'acfe8da92a_admin'
    ],
    'crypt' => [
        'key' => 'lmhOLg0kJymu4W9xDGZNYDpaX5XB5t20'
    ],
    'db' => [
        'table_prefix' => '',
        'connection' => [
            'default' => [
                'host' => 'localhost',
                'dbname' => 'af6d0d5d_m2newlive',
                'username' => 'af6d0d5d_m2newl',
                'password' => 'UnrulyTeachSneersPudgy',
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
        'save' => 'redis',
        'redis' => [
            'host' => '/var/run/redis-multi-af6d0d5d.redis/redis.sock',
            'port' => '0',
            'database' => '2',
            'compression_library' => 'gzip'
        ]
    ],
    'cache' => [
        'frontend' => [
            'default' => [
                'id_prefix' => '7b5_',
                'backend' => 'files',
                'backend_options' => [
                    'server' => '/var/run/redis-multi-af6d0d5d.redis/redis.sock',
                    'database' => '1',
                    'port' => '0'
                ]
            ],
            'page_cache' => [
                'id_prefix' => '7b5_',
                'backend' => 'Cm_Cache_Backend_Redis',
                'backend_options' => [
                    'server' => '/var/run/redis-multi-af6d0d5d.redis/redis.sock',
                    'port' => '0',
                    'database' => '0',
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
        'date' => 'Thu, 26 Aug 2021 07:17:25 -0400'
    ]
];
