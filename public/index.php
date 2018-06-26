<?php
require_once '../lib/init.php';

if ($_SESSION['prode_'.session_id()]['user_logged'])
	header('Location: /public/dashboard/');
else
	header('Location: /public/login/email/');