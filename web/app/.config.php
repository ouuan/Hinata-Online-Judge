<?php
return array (
  'profile' => 
  array (
    'oj-name' => 'Hinata Online Judge',
    'oj-name-short' => 'WFLSOJ',
    'administrator' => 'ouuan',
    'admin-email' => 'admin@local_uoj.ac',
    'QQ-group' => '',
    'ICP-license' => '',
  ),
  'database' => 
  array (
    'database' => 'app_uoj233',
    'username' => 'root',
    'password' => 'root',
    'host' => '127.0.0.1',
  ),
  'web' => 
  array (
    'domain' => NULL,
    'main' => 
    array (
      'protocol' => 'http',
      'host' => UOJContext::httpHost(),
      'port' => 80,
    ),
    'blog' => 
    array (
      'protocol' => 'http',
      'host' => UOJContext::httpHost(),
      'port' => 80,
    ),
  ),
  'security' => 
  array (
    'user' => 
    array (
      'client_salt' => 'KyJ7Vy5KEygajeP5oHzCKXu0iAGSeFG7',
    ),
    'cookie' => 
    array (
      'checksum_salt' => 
      array (
        0 => 'XARNR0KbLNu4xK3a',
        1 => 'HbUsULYvh0XegB4m',
        2 => 'qhYI2vXOIh8bJhbD',
      ),
    ),
  ),
  'mail' => 
  array (
    'noreply' => 
    array (
      'username' => 'noreply@local_uoj.ac',
      'password' => '_mail_noreply_password_',
      'host' => 'smtp.local_uoj.ac',
      'secure' => 'tls',
      'port' => 587,
    ),
  ),
  'judger' => 
  array (
    'socket' => 
    array (
      'port' => '2333',
      'password' => 'Lc2HkJn2gNYImPiOalMUrTv0rYmrioTd',
    ),
  ),
  'switch' => 
  array (
    'web-analytics' => false,
    'blog-domain-mode' => 3,
  ),
);
