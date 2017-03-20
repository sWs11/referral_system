<?php

//1.
ini_set('display_errors', 1);
error_reporting(E_ALL);

//2.
define('ROOT', dirname(__FILE__));
require_once (ROOT.'/components/Router.php');
require_once (ROOT.'/components/Db.php');
require_once (ROOT.'/components/Common.php');
session_start();
//3.
$router = new Router();
$router->run();