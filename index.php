<?php

// Указываем путь к фреймворку Yii1
$yii = dirname(__FILE__) . '/vendor/yiisoft/yii/framework/yii.php';

// Путь к конфигу
$config = dirname(__FILE__) . '/protected/config/main.php';

defined('YII_DEBUG') or define('YII_DEBUG', true);   // false на production
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require_once $yii;
Yii::createWebApplication($config)->run();
