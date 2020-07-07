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
$causes_view = new causes_view();

// Run the page
$causes_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$causes_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$causes_view->isExport()) { ?>
<script>
var fcausesview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	fcausesview = currentForm = new ew.Form("fcausesview", "view");
	loadjs.done("fcausesview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$causes_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $causes_view->ExportOptions->render("body") ?>
<?php $causes_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $causes_view->showPageHeader(); ?>
<?php
$causes_view->showMessage();
?>
<?php if (!$causes_view->IsModal) { ?>
<?php if (!$causes_view->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $causes_view->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="fcausesview" id="fcausesview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="causes">
<input type="hidden" name="modal" value="<?php echo (int)$causes_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($causes_view->idCause->Visible) { // idCause ?>
	<tr id="r_idCause">
		<td class="<?php echo $causes_view->TableLeftColumnClass ?>"><span id="elh_causes_idCause"><?php echo $causes_view->idCause->caption() ?></span></td>
		<td data-name="idCause" <?php echo $causes_view->idCause->cellAttributes() ?>>
<span id="el_causes_idCause">
<span<?php echo $causes_view->idCause->viewAttributes() ?>><?php echo $causes_view->idCause->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($causes_view->cause->Visible) { // cause ?>
	<tr id="r_cause">
		<td class="<?php echo $causes_view->TableLeftColumnClass ?>"><span id="elh_causes_cause"><?php echo $causes_view->cause->caption() ?></span></td>
		<td data-name="cause" <?php echo $causes_view->cause->cellAttributes() ?>>
<span id="el_causes_cause">
<span<?php echo $causes_view->cause->viewAttributes() ?>><?php echo $causes_view->cause->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$causes_view->IsModal) { ?>
<?php if (!$causes_view->isExport()) { ?>
<?php echo $causes_view->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
</form>
<?php
$causes_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$causes_view->isExport()) { ?>
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
$causes_view->terminate();
?>