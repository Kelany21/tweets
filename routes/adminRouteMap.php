<?php

return [
    'Home' => [
        'controller' => 'Home',
        'uri' => 'home',
        'importDefaultRoute' => false,
        'routes' => [
            [
                'type' => 'get',
                'uri' => '/home',
                'controller' => 'Home@index',
                'permission' => 'all'
            ],
            [
                'type' => 'get',
                'uri' => '/file-manager',
                'controller' => 'Home@FileManager',
                'permission' => 'all'
            ],
        ]
    ],
    'Users' => [
        'controller' => 'Users',
        'uri' => 'users',
        'importDefaultRoute' => true,
        'routes' => [
            [
                'type' => 'get',
                'uri' => 'users/{id}/status-toggle',
                'controller' => 'Users@statusToggle',
                'permission' => 'toggle'
            ],
        ]
    ],
    'Groups' => [
        'controller' => 'Groups',
        'uri' => 'groups',
        'importDefaultRoute' => true,
        'routes' => [],
    ],
    'Tweets' => [
        'controller' => 'Tweets',
        'uri' => 'tweets',
        'importDefaultRoute' => true,
        'routes' => [
            [
                'type' => 'get',
                'uri' => 'tweets/{id}/status-toggle',
                'controller' => 'Tweets@statusToggle',
                'permission' => 'toggle'
            ],
        ]
    ],
];
