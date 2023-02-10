<?php

return [
    [
        'type' => 'get',
        'uri' => '',
        'controller' => '@index',
        'permission' => 'all'
    ],
    [
        'type' => 'get',
        'uri' => '/create',
        'controller' => '@create',
        'permission' => 'create'
    ],
    [
        'type' => 'post',
        'uri' => '/',
        'controller' => '@store',
        'permission' => 'create'
    ],
    [
        'type' => 'get',
        'uri' => '/{id}/edit',
        'controller' => '@edit',
        'permission' => 'edit'
    ],
    [
        'type' => 'put',
        'uri' => '/{id}',
        'controller' => '@update',
        'permission' => 'edit'
    ],

    [
        'type' => 'get',
        'uri' => '/get-rows',
        'controller' => '@getRows',
        'permission' => 'all'
    ],
    [
        'type' => 'get',
        'uri' => '/toggle/{id}/{column}/{value}',
        'controller' => '@toggle',
        'permission' => 'toggle',
    ],
    [
        'type' => 'get',
        'uri' => '/{id}/delete',
        'controller' => '@delete',
        'permission' => 'delete'
    ],
    [
        'type' => 'get',
        'uri' => '/{id}/delete-permanently',
        'controller' => '@deletePermanently',
        'permission' => 'delete'
    ],

    [
        'type' => 'get',
        'uri' => '/{id}/restore',
        'controller' => '@restore',
        'permission' => 'restore'
    ],
    [
        'type' => 'post',
        'uri' => '/delete-selected',
        'controller' => '@deleteSelected',
        'permission' => 'delete'
    ],
    [
        'type' => 'post',
        'uri' => '/restore-selected',
        'controller' => '@restoreSelected',
        'permission' => 'restore'
    ],
    [
        'type' => 'post',
        'uri' => '/delete-permanently-selected',
        'controller' => '@deleteSelectedPermanently',
        'permission' => 'delete'
    ],
    [
        'type' => 'get',
        'uri' => '/export',
        'controller' => '@export',
        'permission' => 'all'
    ],
];
