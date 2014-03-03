<?php
session_start();
header('Content-type: text/html; charset=utf-8');
include_once (dirname( dirname( __FILE__ ) )) . '/config.path.inc.php';
$yiiFilePath = LIB_PATH . DS . 'yii/yii.php';
$config = WEB_PROTECTED_PATH . DS . 'config/main.php';
//error_reporting(0);
defined( 'YII_DEBUG' ) or define( 'YII_DEBUG' , TRUE );
require_once ($yiiFilePath);
Yii::createWebApplication( $config )->run();
Yii::setPathOfAlias( 'smallstone' , SMALLSTONE_PATH );