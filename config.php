<?php
session_start();
define('__KEY__', '"sdknfsdjk4jk34jb34jb34j34#$K#$K#$KN#$KNKLn34k4jk34jkb43kb4kb34kb344bk34j');
define('DBNAME', 'chat');
define('HOSTNAME', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
require_once('inc\db.php');
require_once('inc\core.php');
require_once('inc\Hash.php');
require_once('app\App.php');
require_once('app\users.php');
require_once('app\messages.php');
require_once('app\middlewares/xxs.php');
$db = new db(HOSTNAME, DBNAME, USERNAME, PASSWORD);
$url = $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'];
xxs::clean($_POST);