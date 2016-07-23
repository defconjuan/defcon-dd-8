<?php
$config['system.file']['path']['temporary'] = '../tmp';
$settings['file_public_path'] = 'sites/default/files';
$settings['file_private_path'] = 'sites/default/files/private';

$databases['default']['default'] = array (
  'database' => 'drupal',
  'username' => 'container',
  'password' => 'container',
  'prefix' => '',
  'host' => 'mysql',
  'port' => '',
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
  'driver' => 'mysql',
);

$settings['trusted_host_patterns'] = array(
    '^.+\.dev$',
    '^.+\.com$',
    '^.+\.localhost$',
    '^localhost$',
);

