<?php

return [
    APP_URI => [
        '/social[/]' => [
            'controller' => 'Phire\Social\Controller\IndexController',
            'action'     => 'index',
            'acl'        => [
                'resource'   => 'social',
                'permission' => 'index'
            ]
        ]
    ]
];
