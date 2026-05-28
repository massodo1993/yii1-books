<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name'     => 'Book Catalog Console',

    'import' => array(
        'application.models.*',
        'application.components.*',
    ),

    'components' => array(
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
        ),
    ),
);
