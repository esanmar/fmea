<?php
namespace PHPMaker2020\fmeaPRD;

// Session
if (session_status() !== PHP_SESSION_ACTIVE)
	session_start(); // Init session data

// Output buffering
ob_start();

// Autoload
include_once "autoload.php";
?>
<?php

// Write header
WriteHeader(FALSE);

// Create page object
$logout = new logout();

// Run the page
$logout->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());
?>
<?php
$logout->terminate();
?>