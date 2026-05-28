<?php

return array(
    'basePath'          => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name'              => 'Book Catalog',
    'defaultController' => 'book',

    'preload' => array('log'),

    'import' => array(
        'application.models.*',
        'application.components.*',
    ),

    'components' => array(

        'user' => array(
            'class'    => 'CWebUser',
            'loginUrl' => array('/site/login'),
        ),

        'db' => array(
            'connectionString' => sprintf(
                'mysql:host=%s;dbname=%s;charset=utf8mb4',
                getenv('DB_HOST') ?: 'localhost',
                getenv('DB_NAME') ?: 'book_catalog'
            ),
            'emulatePrepare' => true,
            'username'       => getenv('DB_USER')     ?: 'root',
            'password'       => getenv('DB_PASSWORD') ?: '',
            'charset'        => 'utf8mb4',
            'tablePrefix'    => '',
        ),

        // RBAC через файлы (phpManager)
        'authManager' => array(
            'class'        => 'CPhpAuthManager',
            'defaultRoles' => array('guest'),
        ),

        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                ''                                          => 'book/index',
                'login'                                     => 'site/login',
                'logout'                                    => 'site/logout',
                'register'                                  => 'site/register',
                'report'                                    => 'report/index',
                'subscribe/<authorId:\d+>'                  => 'subscription/create',
                '<controller:\w+>/<action:\w+>/<id:\d+>'   => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>'             => '<controller>/<action>',
                '<controller:\w+>'                          => '<controller>/index',
            ),
        ),

        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),

        'log' => array(
            'class'  => 'CLogRouter',
            'routes' => array(
                array(
                    'class'  => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
    ),

    'params' => array(
        'smsPilotApiKey' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
        'smsPilotSender' => 'SMSPILOT',
    ),
);
