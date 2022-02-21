<?php
return array (
  'MAGE_MODE' => 'production',
  'cache_types' => 
  array (
    'compiled_config' => 1,
    'config' => 0,
    'layout' => 0,
    'block_html' => 0,
    'collections' => 0,
    'reflection' => 0,
    'db_ddl' => 0,
    'eav' => 0,
    'customer_notification' => 0,
    'full_page' => 0,
    'config_integration' => 0,
    'config_integration_api' => 0,
    'target_rule' => 0,
    'translate' => 0,
    'config_webservice' => 0,
    'vertex' => 0,
  ),
  'backend' => 
  array (
    'frontName' => 'cou1403112c1admin',
  ),
  'db' => 
  array (
    'connection' => 
    array (
      'default' => 
      array (
        'username' => 'user',
        'host' => 'database.internal',
        'dbname' => 'main',
        'password' => '',
      ),
      'indexer' => 
      array (
        'username' => 'user',
        'host' => 'database.internal',
        'dbname' => 'main',
        'password' => '',
      ),
    ),
  ),
  'crypt' => 
  array (
    'key' => '520c6a5cfeda3763402308dd17b87d75',
  ),
  'resource' => 
  array (
    'default_setup' => 
    array (
      'connection' => 'default',
    ),
  ),
  'x-frame-options' => 'SAMEORIGIN',
  'session' => 
  array (
    'save' => 'redis',
    'redis' => 
    array (
      'host' => 'redis.internal',
      'port' => 6379,
      'database' => 0,
      'disable_locking' => 1,
    ),
  ),
  'install' => 
  array (
    'date' => 'Fri, 15 Jun 2018 20:09:37 +0000',
  ),
  'static_content_on_demand_in_production' => 0,
  'force_html_minification' => 1,
  'cron_consumers_runner' => 
  array (
    'cron_run' => true,
    'max_messages' => 10000,
    'consumers' => 
    array (
    ),
  ),
  'cache' => 
  array (
    'frontend' => 
    array (
      'default' => 
      array (
        'backend' => 'Cm_Cache_Backend_Redis',
        'backend_options' => 
        array (
          'server' => 'redis.internal',
          'port' => 6379,
          'database' => 1,
        ),
      ),
      'page_cache' => 
      array (
        'backend' => 'Cm_Cache_Backend_Redis',
        'backend_options' => 
        array (
          'server' => 'redis.internal',
          'port' => 6379,
          'database' => 2,
        ),
      ),
    ),
  ),
  'system' => 
  array (
    'default' => 
    array (
      'catalog' => 
      array (
        'search' => 
        array (
          'engine' => 'elasticsearch6',
          'elasticsearch6_server_hostname' => 'elasticsearch.internal',
          'elasticsearch6_server_port' => 9200,
        ),
      ),
    ),
  ),
  'directories' => 
  array (
    'document_root_is_pub' => true,
  ),
  'cron' => 
  array (
  ),
  'lock' => 
  array (
    'provider' => 'db',
    'config' => 
    array (
      'prefix' => NULL,
    ),
  ),
  'queue' => 
  array (
    'consumers_wait_for_messages' => 0,
  ),
  'downloadable_domains' => 
  array (
    0 => 'www.curricanes.com',
  ),
);