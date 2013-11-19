<?php

defined('YII_ENABLE_EXCEPTION_HANDLER') or define('YII_ENABLE_EXCEPTION_HANDLER',false);
defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER',false);
defined('YII_DEBUG') or define('YII_DEBUG',true);
$_SERVER['SCRIPT_NAME']='/'.basename(__FILE__);
$_SERVER['SCRIPT_FILENAME']=__FILE__;

$yii_path = dirname(__FILE__).'/../../../yiisoft/yii/framework/yii.php';
if (file_exists($yii_path)) {
	require_once($yii_path);
} else {
	$yii_path = dirname(__FILE__).'/../vendor/yiisoft/yii/framework/yii.php';
	if (file_exists($yii_path)) {
		require_once($yii_path);
	} else {
		die("Not found Yii core file.\n");
	}
}

require_once(dirname(__FILE__).'/TestApplication.php');
//require_once('PHPUnit/Framework/TestCase.php');

// make sure non existing PHPUnit classes do not break with Yii autoloader
Yii::$enableIncludePath = false;
Yii::setPathOfAlias('tests', dirname(__FILE__));
Yii::setPathOfAlias('yex', dirname(__FILE__) . '/../extension');
Yii::import('tests.*');

class YexTestCase extends PHPUnit_Framework_TestCase
{
}


class YexActiveRecordTestCase extends YexTestCase
{
}

new TestApplication();
