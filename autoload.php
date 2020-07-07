<?php
namespace PHPMaker2020\SupplierMapping;

// Relative path
if (!isset($RELATIVE_PATH))
	$RELATIVE_PATH = "";

// Composer autoloader
if (file_exists($RELATIVE_PATH . "vendor/autoload.php"))
	require_once $RELATIVE_PATH . "vendor/autoload.php";
else
	die("Composer generated autoload.php does not exist. Make sure you have run \"composer update\" at the destionation folder on your development computer and uploaded the \"vendor\" subfolder.");

// Include files
include_once $RELATIVE_PATH . "ewcfg.php";
if (USE_ADODB)
	include_once $RELATIVE_PATH . "adodb5/adodb.inc.php";
include_once $RELATIVE_PATH . "phpfn.php";

// Autoloader
spl_autoload_register(PROJECT_NAMESPACE . "Autoloader");

// Global code
include_once $RELATIVE_PATH . "userfn.php";
?>