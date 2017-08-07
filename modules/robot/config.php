<?php
/**
 * robot config file
 * @package robot
 * @version 0.0.1
 * @upgrade true
 */

return [
    '__name' => 'robot',
    '__version' => '0.0.1',
    '__git' => 'https://github.com/getphun/robot',
    '__files' => [
        'modules/robot'                 => [ 'install', 'remove', 'update' ],
        'theme/robot/feed.phtml'        => [ 'install', 'remove', 'update' ],
        'theme/robot/sitemap.phtml'     => [ 'install', 'remove', 'update' ],
        'theme/robot/static/logo.png'   => [ 'install', 'remove' ]
    ],
    '__dependencies' => [
        'site'
    ],
    '_services' => [
        'robot' => 'Robot\\Service\\Robot'
    ],
    '_autoload' => [
        'classes' => [
            'Robot\\Service\\Robot' => 'modules/robot/service/Robot.php',
            'Robot\\Controller\\MainController' => 'modules/robot/controller/MainController.php'
        ],
        'files' => []
    ],
    '_routes' => [
        'site' => [
            'robotSitemap' => [
                'rule' => '/sitemap.xml',
                'handler' => 'Robot\\Controller\\Main::sitemap'
            ],
            'robotFeed' => [
                'rule' => '/feed.xml',
                'handler' => 'Robot\\Controller\\Main::feed'
            ]
        ]
    ],
    
    'robot' => [
        'json' => false
    ]
];