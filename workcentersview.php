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
$workcenters_view = new workcenters_view();

// Run the page
$workcenters_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$workcenters_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$workcenters_view->isExport()) { ?>
<script>
var fworkcentersview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	fworkcentersview = currentForm = new ew.Form("fworkcentersview", "view");
	loadjs.done("fworkcentersview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$workcenters_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $workcenters_view->ExportOptions->render("body") ?>
<?php $workcenters_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $workcenters_view->showPageHeader(); ?>
<?php
$workcenters_view->showMessage();
?>
<?php if (!$workcenters_view->IsModal) { ?>
<?php if (!$workcenters_view->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $workcenters_view->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="fworkcentersview" id="fworkcentersview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="workcenters">
<input type="hidden" name="modal" value="<?php echo (int)$workcenters_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($workcenters_view->workcenter->Visible) { // workcenter ?>
	<tr id="r_workcenter">
		<td class="<?php echo $workcenters_view->TableLeftColumnClass ?>"><span id="elh_workcenters_workcenter"><?php echo $workcenters_view->workcenter->caption() ?></span></td>
		<td data-name="workcenter" <?php echo $workcenters_view->workcenter->cellAttributes() ?>>
<span id="el_workcenters_workcenter">
<span<?php echo $workcenters_view->workcenter->viewAttributes() ?>><?php echo $workcenters_view->workcenter->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($workcenters_view->description->Visible) { // description ?>
	<tr id="r_description">
		<td class="<?php echo $workcenters_view->TableLeftColumnClass ?>"><span id="elh_workcenters_description"><?php echo $workcenters_view->description->caption() ?></span></td>
		<td data-name="description" <?php echo $workcenters_view->description->cellAttributes() ?>>
<span id="el_workcenters_description">
<span<?php echo $workcenters_view->description->viewAttributes() ?>><?php echo $workcenters_view->description->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$workcenters_view->IsModal) { ?>
<?php if (!$workcenters_view->isExport()) { ?>
<?php echo $workcenters_view->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
</form>
<?php
$workcenters_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$workcenters_view->isExport()) { ?>
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
$workcenters_view->terminate();
?>