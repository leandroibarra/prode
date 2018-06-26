<?php
require_once '../lib/init.php';

unset($_SESSION['prode_'.session_id()]);
session_destroy('prode_'.session_id());

header('Location: /public/login/email/');
?>
