#!/usr/bin/env php
<?php

defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));

$yii    = dirname(__FILE__) . '/vendor/yiisoft/yii/framework/yiic.php';
$config = dirname(__FILE__) . '/protected/config/console.php';

// Добавляем папку с миграциями в include_path чтобы Yii мог их подключить
set_include_path(
    get_include_path()
    . PATH_SEPARATOR . dirname(__FILE__) . '/protected/migrations'
);

require_once $yii;