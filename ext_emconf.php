<?php
$EM_CONF[$_EXTKEY] = array (	
  'title' => 'Newrelic Integration',	$EM_CONF[$_EXTKEY] = [
  'description' => 'A collection of integrations for Newrelic monitoring',	    'title' => 'Newrelic Integration',
  'category' => 'misc',	    'description' => 'A collection of integrations for Newrelic monitoring',
  'author' => 'Claus Due / NamelessCoder',	    'category' => 'misc',
  'author_email' => 'claus@namelesscoder.net',	    'author' => 'Claus Due / NamelessCoder',
  'author_company' => '',	    'author_email' => 'claus@namelesscoder.net',
  'shy' => '',	    'author_company' => '',
  'dependencies' => '',	    'shy' => '',
  'conflicts' => '',	    'dependencies' => '',
  'priority' => '',	    'conflicts' => '',
  'module' => '',	    'priority' => '',
  'state' => 'beta',	    'module' => '',
  'internal' => '',	    'state' => 'beta',
  'uploadfolder' => 0,	    'internal' => '',
  'createDirs' => '',	    'uploadfolder' => 0,
  'modify_tables' => '',	    'createDirs' => '',
  'clearCacheOnLoad' => 0,	    'modify_tables' => '',
  'lockType' => '',	    'clearCacheOnLoad' => 0,
  'version' => '1.2.0',	    'lockType' => '',
  'constraints' =>	    'version' => '1.2.1',
  array (	    'constraints' =>
    'depends' =>	        [
    array (	            'depends' =>
      'php' => '7.0.0-7.3.99',	                [
      'typo3' => '8.5.99-9.99.99',	                    'php' => '7.0.0-7.3.99',
    ),	                    'typo3' => '8.5.99-9.99.99',
    'conflicts' =>	                ],
    array (	            'conflicts' => [],
    ),	            'suggests' => [],
    'suggests' =>	        ],
    array (	    'suggests' => [],
    ),	    '_md5_values_when_last_written' => '',
  ),	];
  'suggests' =>	
  array (	
  ),	
  '_md5_values_when_last_written' => '',	
);
