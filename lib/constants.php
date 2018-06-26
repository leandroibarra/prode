<?php
function getBaseURL() {
	$sProtocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='off') ? 'https' : 'http';

	if (php_sapi_name() == 'cli')
		$sUrl = $sProtocol.'://'.getenv('ENV_HOST');
	else
		$sUrl = $sProtocol.'://'.$_SERVER['HTTP_HOST'].(($_SERVER['HTTP_HOST']=='localhost')?'/prode':'');

	define('PROTOCOL', $sProtocol);

	return $sUrl;
}

define('DATABASE_DRIVER', 'mysql');
define('DATABASE_SERVER', 'localhost');
define('DATABASE_NAME', 'prode_db');
define('DATABASE_USERNAME', '');
define('DATABASE_PASSWORD', '');
define('DATABASE_PORT', '3306');

// Constants for libraries and paths (use in local file)
define('APP_DIR', dirname(dirname(__FILE__))); // application root directory

// lib/
define('LIB_DIR', APP_DIR.'/lib/'); // library directory
define('DB_DIR', LIB_DIR.'db/');
define('MODELS_DIR', LIB_DIR.'models/');
define('INCLUDES_DIR', LIB_DIR.'includes/');

// html/
define('HTML_DIR', APP_DIR.'/html/');
define('CSS_DIR', HTML_DIR.'css/');
define('IMAGES_DIR', HTML_DIR.'images/');
define('JS_DIR', HTML_DIR.'js/');

// Log
define('LOG_DIR', APP_DIR.'/var/log/');

// Constants for include files (use in site)
// application URL
define('APP_BASE_URL', getBaseURL());

define('HTML_URL', APP_BASE_URL.'/html');
define('CSS_URL', HTML_URL.'/css');
define('IMAGES_URL', HTML_URL.'/images');
define('JS_URL', HTML_URL.'/js');

// Handler error
error_reporting(E_ALL);
error_reporting(E_ERROR);
ini_set('display_errors', 1);
ini_set('max_execution_time', 120);
ini_set('memory_limit', '128M');
