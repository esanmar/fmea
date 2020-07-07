<?php
namespace PHPMaker2020\SupplierMapping;

// Session
if (session_status() !== PHP_SESSION_ACTIVE)
	session_start(); // Init session data
include_once "autoload.php";
$index = new index();
$index->run();
?>
<?php include_once "header.php"; ?>
<?php
$index->showMessage();
?>
<?php include_once "footer.php"; ?>