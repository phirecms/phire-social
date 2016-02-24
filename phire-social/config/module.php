<?php
/**
 * Module Name: phire-social
 * Author: Nick Sagona
 * Description: This is the social media module for Phire CMS 2
 * Version: 1.0
 */
return [
    'phire-social' => [
        'prefix'     => 'Phire\Social\\',
        'src'        => __DIR__ . '/../src',
        'routes'     => include 'routes.php',
        'resources'  => include 'resources.php',
        'nav.module' => [
            'name' => 'Social Media',
            'href' => '/social',
            'acl' => [
                'resource'   => 'social',
                'permission' => 'index'
            ]
        ],
        'events' => [
            [
                'name'     => 'app.send.pre',
                'action'   => 'Phire\Social\Event\Social::init',
                'priority' => 1000
            ],
            [
                'name'     => 'app.send.post',
                'action'   => 'Phire\Social\Event\Social::parse',
                'priority' => 1000
            ]
        ],
        'install' => function() {
            $config = new \Phire\Table\Config([
                'setting' => 'social_config',
                'value'   => null
            ]);
            $config->save();
        },
        'uninstall' => function() {
            $config = \Phire\Table\Config::findById('social_config');
            if (isset($config->setting)) {
                $config->delete();
            }
        }
    ]
];
