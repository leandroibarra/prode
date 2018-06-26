<?php
if (@$_SERVER['HTTP_HOST'] != '') {
	session_start();
}

// Define constants and include files functions
require_once 'constants.php';

require_once INCLUDES_DIR.'Hash_Password.php';

require_once DB_DIR.'PDO_Wrapper.php';

require_once MODELS_DIR.'Model.php';

foreach (glob(MODELS_DIR.'*.php') as $sModel)
	if (!in_array(str_replace(MODELS_DIR, '', $sModel), array('Model.php')))
		require_once $sModel;

$sCurrentFileName = end(explode('/', $_SERVER['SCRIPT_NAME']));

$sPageTitle = str_replace('_', ' ', ucwords(current(explode('.', $sCurrentFileName)), '_'));

$aPublicPages = array(
	'dashboard.php' => 'Dashboard',
	'users_ranking.php' => 'Users Ranking',
	'rules.php' => 'Rules'
);