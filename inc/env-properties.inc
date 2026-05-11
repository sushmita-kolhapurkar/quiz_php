<?php
// Sets general environment properties

define("MYSQL_SERVER", "remotemysql.com");
define("MYSQL_USER", "xio9BahYAI");
define("MYSQL_PASSWORD", "Q1xrkGjR7b");
define("MYSQL_DATABASE", "xio9BahYAI");

ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);
ini_set('log_errors', true);
ini_set('max_execution_time', 50000); //300 seconds = 5 minutes

$base_dir = __DIR__."/..";

extract($_POST);
extract($_GET);

//include($base_dir."db.inc.php");
?>
