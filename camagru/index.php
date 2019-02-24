<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-01-30
 * Time: 21:08
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);


define('ROOT', dirname(__FILE__ , 1));

require_once (ROOT."/components/Autoload.php");
require_once  (ROOT."/config/db_params.php");
require_once (ROOT."/config/fb.php");
include ROOT."/config/setup.php";
create_database();
//Db::create_db();
session_start();
//require_once (ROOT."/components/Router.php");
//require_once ROOT."/components/Db.php";
//include_once ROOT. "/models/User.php";


//Db::delete_db();

$router = new Router();
$router->run();
