<?php
// Aside menu
return [

    'items' => [
        // Dashboard
        [
            'title' => 'Dashboard',
            'root' => true,
            'icon' => 'media/svg/icons/Design/Layers.svg', // or can be 'flaticon-home' or any flaticon-*
            'page' => '/dashboard/home',
        ],
        [
            'title' => 'website',
            'root' => true,
            'icon' => 'media/svg/icons/Design/Color-profile.svg', // or can be 'flaticon-home' or any flaticon-*
            'page' => '/',
            'new-tab' => true,
        ],
        [
            'title' => 'Users',
            'root' => true,
            'icon' => 'media/svg/icons/General/User.svg',
            'page' => '/dashboard/users',
        ],
        [
            'title' => 'Groups',
            'root' => true,
            'icon' => 'media/svg/icons/Communication/Group.svg',
            'page' => '/dashboard/groups',
        ],
        [
            'title' => 'Tweets',
            'root' => true,
            'icon' => 'media/svg/icons/Communication/Write.svg',
            'page' => '/dashboard/tweets',
        ],
    ]

];
