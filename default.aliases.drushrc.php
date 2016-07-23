<?php

  $aliases['REPLACEME.dev'] = array(
  );
  $aliases['REPLACEME.test'] = array(
  );
  $aliases['REPLACEME.live'] = array(
  );
  $aliases['REPLACEME.loc'] = array(
    'uri' => 'REPLACEME.dev',
    'db-url' => 'mysql://container:container@localhost/drupal',
    'db-allows-remote' => TRUE,
    'root' => '/apache/data',
    'path-aliases' => array(
      '%files' => '/apache/files',
      '%drush-script' => 'drush',
     ),
  );
