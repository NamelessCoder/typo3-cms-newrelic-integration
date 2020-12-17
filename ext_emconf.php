<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Newrelic Integration',
    'description' => 'A collection of integrations for Newrelic monitoring',
    'category' => 'misc',
    'author' => 'Claus Due / NamelessCoder',
    'author_email' => 'claus@namelesscoder.net',
    'author_company' => '',
    'state' => 'beta',
    'clearCacheOnLoad' => 0,
    'version' => '1.2.0',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-10.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ]
];
