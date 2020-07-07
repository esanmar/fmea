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
$severity_view = new severity_view();

// Run the page
$severity_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$severity_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$severity_view->isExport()) { ?>
<script>
var fseverityview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	fseverityview = currentForm = new ew.Form("fseverityview", "view");
	loadjs.done("fseverityview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$severity_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $severity_view->ExportOptions->render("body") ?>
<?php $severity_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $severity_view->showPageHeader(); ?>
<?php
$severity_view->showMessage();
?>
<?php if (!$severity_view->IsModal) { ?>
<?php if (!$severity_view->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $severity_view->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="fseverityview" id="fseverityview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="severity">
<input type="hidden" name="modal" value="<?php echo (int)$severity_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($severity_view->idSeverity->Visible) { // idSeverity ?>
	<tr id="r_idSeverity">
		<td class="<?php echo $severity_view->TableLeftColumnClass ?>"><span id="elh_severity_idSeverity"><?php echo $severity_view->idSeverity->caption() ?></span></td>
		<td data-name="idSeverity" <?php echo $severity_view->idSeverity->cellAttributes() ?>>
<span id="el_severity_idSeverity">
<span<?php echo $severity_view->idSeverity->viewAttributes() ?>><?php echo $severity_view->idSeverity->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($severity_view->effect->Visible) { // effect ?>
	<tr id="r_effect">
		<td class="<?php echo $severity_view->TableLeftColumnClass ?>"><span id="elh_severity_effect"><?php echo $severity_view->effect->caption() ?></span></td>
		<td data-name="effect" <?php echo $severity_view->effect->cellAttributes() ?>>
<span id="el_severity_effect">
<span<?php echo $severity_view->effect->viewAttributes() ?>><?php echo $severity_view->effect->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($severity_view->severityonclient->Visible) { // severityonclient ?>
	<tr id="r_severityonclient">
		<td class="<?php echo $severity_view->TableLeftColumnClass ?>"><span id="elh_severity_severityonclient"><?php echo $severity_view->severityonclient->caption() ?></span></td>
		<td data-name="severityonclient" <?php echo $severity_view->severityonclient->cellAttributes() ?>>
<span id="el_severity_severityonclient">
<span<?php echo $severity_view->severityonclient->viewAttributes() ?>><?php echo $severity_view->severityonclient->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($severity_view->internalseverity->Visible) { // internalseverity ?>
	<tr id="r_internalseverity">
		<td class="<?php echo $severity_view->TableLeftColumnClass ?>"><span id="elh_severity_internalseverity"><?php echo $severity_view->internalseverity->caption() ?></span></td>
		<td data-name="internalseverity" <?php echo $severity_view->internalseverity->cellAttributes() ?>>
<span id="el_severity_internalseverity">
<span<?php echo $severity_view->internalseverity->viewAttributes() ?>><?php echo $severity_view->internalseverity->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($severity_view->color->Visible) { // color ?>
	<tr id="r_color">
		<td class="<?php echo $severity_view->TableLeftColumnClass ?>"><span id="elh_severity_color"><?php echo $severity_view->color->caption() ?></span></td>
		<td data-name="color" <?php echo $severity_view->color->cellAttributes() ?>>
<span id="el_severity_color">
<span<?php echo $severity_view->color->viewAttributes() ?>><?php echo $severity_view->color->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$severity_view->IsModal) { ?>
<?php if (!$severity_view->isExport()) { ?>
<?php echo $severity_view->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
</form>
<?php
$severity_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$severity_view->isExport()) { ?>
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
$severity_view->terminate();
?>