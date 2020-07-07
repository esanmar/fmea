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
$userlevels_view = new userlevels_view();

// Run the page
$userlevels_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$userlevels_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$userlevels_view->isExport()) { ?>
<script>
var fuserlevelsview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	fuserlevelsview = currentForm = new ew.Form("fuserlevelsview", "view");
	loadjs.done("fuserlevelsview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$userlevels_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $userlevels_view->ExportOptions->render("body") ?>
<?php $userlevels_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $userlevels_view->showPageHeader(); ?>
<?php
$userlevels_view->showMessage();
?>
<?php if (!$userlevels_view->IsModal) { ?>
<?php if (!$userlevels_view->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $userlevels_view->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="fuserlevelsview" id="fuserlevelsview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="userlevels">
<input type="hidden" name="modal" value="<?php echo (int)$userlevels_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($userlevels_view->userlevelid->Visible) { // userlevelid ?>
	<tr id="r_userlevelid">
		<td class="<?php echo $userlevels_view->TableLeftColumnClass ?>"><span id="elh_userlevels_userlevelid"><?php echo $userlevels_view->userlevelid->caption() ?></span></td>
		<td data-name="userlevelid" <?php echo $userlevels_view->userlevelid->cellAttributes() ?>>
<span id="el_userlevels_userlevelid">
<span<?php echo $userlevels_view->userlevelid->viewAttributes() ?>><?php echo $userlevels_view->userlevelid->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($userlevels_view->userlevelname->Visible) { // userlevelname ?>
	<tr id="r_userlevelname">
		<td class="<?php echo $userlevels_view->TableLeftColumnClass ?>"><span id="elh_userlevels_userlevelname"><?php echo $userlevels_view->userlevelname->caption() ?></span></td>
		<td data-name="userlevelname" <?php echo $userlevels_view->userlevelname->cellAttributes() ?>>
<span id="el_userlevels_userlevelname">
<span<?php echo $userlevels_view->userlevelname->viewAttributes() ?>><?php echo $userlevels_view->userlevelname->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$userlevels_view->IsModal) { ?>
<?php if (!$userlevels_view->isExport()) { ?>
<?php echo $userlevels_view->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
</form>
<?php
$userlevels_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$userlevels_view->isExport()) { ?>
<script>
loadjs.ready("load", function() {

	// Startup script
	// Write your table-specific startup script here
	// console.log("page loaded");

});
</script>
<?php } ?>
<?php include_once "footer.php"; ?>
<?php
$userlevels_view->terminate();
?>