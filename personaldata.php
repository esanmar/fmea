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
$personaldata = new personaldata();

// Run the page
$personaldata->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();
?>
<?php include_once "header.php"; ?>
<?php
$personaldata->showMessage();
?>
<?php if (SameText(Get("cmd"), "Delete")) { ?>
	<div class="alert alert-danger d-inline-block">
		<i class="icon fas fa-ban"></i><?php echo $Language->phrase("PersonalDataWarning") ?>
	</div>
	<?php if (!EmptyString($personaldata->getFailureMessage())) { ?>
	<div class="text-danger">
		<ul>
			<li><?php echo $personaldata->getFailureMessage() ?></li>
		</ul>
	</div>
	<?php } ?>
	<div>
		<form id="delete-user" method="post" class="form-group">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
			<div class="text-danger"></div>
			<div class="form-group">
				<label id="label" class="control-label ew-label"><?php echo $Language->phrase("Password") ?></label>
				<div class="input-group"><input type="password" name="password" id="password" autocomplete="current-password" class="form-control ew-control" placeholder="<?php echo $Language->phrase("Password") ?>"><div class="input-group-append"><button type="button" class="btn btn-default ew-toggle-password" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button></div></div>
			</div>
			<button class="btn btn-primary" type="submit"><?php echo $Language->phrase("CloseAccountBtn") ?></button>
		</form>
	</div>
<?php } else { ?>
	<div class="row">
		<div class="col">
			<p><?php echo $Language->phrase("PersonalDataContent") ?></p>
			<div class="alert alert-danger d-inline-block">
				<i class="icon fas fa-ban"></i><?php echo $Language->phrase("PersonalDataWarning") ?>
			</div>
			<p>
				<a id="download" href="<?php echo CurrentPageName() . "?cmd=download" ?>" class="btn btn-default"><?php echo $Language->phrase("DownloadBtn") ?></a>
				<a id="delete" href="<?php echo CurrentPageName() . "?cmd=delete" ?>" class="btn btn-default"><?php echo $Language->phrase("DeleteBtn") ?></a>
			</p>
		</div>
	</div>
<?php } ?>
<?php $personaldata->clearFailureMessage(); ?>
<?php include_once "footer.php"; ?>
<?php
$personaldata->terminate();
?>