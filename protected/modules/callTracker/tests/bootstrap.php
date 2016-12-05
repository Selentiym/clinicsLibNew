<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.11.2016
 * Time: 16:14
 */
$dir = dirname(__FILE__).'/../../../../../';
$yiit=$dir.'/yii/framework/yiit.php';
$config=dirname(__FILE__).'/../../../config/test.php';
require_once('TestCase.php');
require_once('DbTestCase.php');
require_once($yiit);
//require_once(dirname(__FILE__).'/unit/NumberTest.php');
Yii::createWebApplication($config);