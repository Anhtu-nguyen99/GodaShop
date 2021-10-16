<?php 
include_once "../bootstrap.php";
include_once "load.php";
$c = isset($_GET["c"]) ? $_GET["c"] : "dashboard";
$a = isset($_GET["a"]) ? $_GET["a"] : "list";

// check login
if ($c !== "auth") {
	require_once "checkLogin.php";
}
// check permission 
if (!in_array($c, array("auth", "dashboard"))) {
	require_once "checkPermission.php";
}
$c = ucfirst($c)."Controller";
$controller = new $c();
$controller->$a();
?>