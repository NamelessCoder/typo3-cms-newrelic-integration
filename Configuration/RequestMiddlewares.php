<?php

return [
    'frontend' => [
         'namelessCoder/newrelicIntegration/new-relic' => [
            'target' => \NamelessCoder\NewrelicIntegration\Middleware\NewRelicInstrumentation::class,
            'after' => [
                'typo3/cms-frontend/content-length-headers',
            ],
        ],
        'namelessCoder/newrelicIntegration/frontend-user-authenticator' => [
            'target' => \NamelessCoder\NewrelicIntegration\Middleware\FrontendUserAuthenticator::class,
            'after' => [
                'typo3/cms-frontend/authentication',
            ],
        ],
    ]
];
