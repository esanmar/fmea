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
$detection_view = new detection_view();

// Run the page
$detection_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$detection_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$detection_view->isExport()) { ?>
<script>
var fdetectionview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	fdetectionview = currentForm = new ew.Form("fdetectionview", "view");
	loadjs.done("fdetectionview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$detection_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $detection_view->ExportOptions->render("body") ?>
<?php $detection_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $detection_view->showPageHeader(); ?>
<?php
$detection_view->showMessage();
?>
<?php if (!$detection_view->IsModal) { ?>
<?php if (!$detection_view->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $detection_view->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="fdetectionview" id="fdetectionview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="detection">
<input type="hidden" name="modal" value="<?php echo (int)$detection_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($detection_view->idDetection->Visible) { // idDetection ?>
	<tr id="r_idDetection">
		<td class="<?php echo $detection_view->TableLeftColumnClass ?>"><span id="elh_detection_idDetection"><?php echo $detection_view->idDetection->caption() ?></span></td>
		<td data-name="idDetection" <?php echo $detection_view->idDetection->cellAttributes() ?>>
<span id="el_detection_idDetection">
<span<?php echo $detection_view->idDetection->viewAttributes() ?>><?php echo $detection_view->idDetection->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detection_view->detection->Visible) { // detection ?>
	<tr id="r_detection">
		<td class="<?php echo $detection_view->TableLeftColumnClass ?>"><span id="elh_detection_detection"><?php echo $detection_view->detection->caption() ?></span></td>
		<td data-name="detection" <?php echo $detection_view->detection->cellAttributes() ?>>
<span id="el_detection_detection">
<span<?php echo $detection_view->detection->viewAttributes() ?>><?php echo $detection_view->detection->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detection_view->description->Visible) { // description ?>
	<tr id="r_description">
		<td class="<?php echo $detection_view->TableLeftColumnClass ?>"><span id="elh_detection_description"><?php echo $detection_view->description->caption() ?></span></td>
		<td data-name="description" <?php echo $detection_view->description->cellAttributes() ?>>
<span id="el_detection_description">
<span<?php echo $detection_view->description->viewAttributes() ?>><?php echo $detection_view->description->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detection_view->methods->Visible) { // methods ?>
	<tr id="r_methods">
		<td class="<?php echo $detection_view->TableLeftColumnClass ?>"><span id="elh_detection_methods"><?php echo $detection_view->methods->caption() ?></span></td>
		<td data-name="methods" <?php echo $detection_view->methods->cellAttributes() ?>>
<span id="el_detection_methods">
<span<?php echo $detection_view->methods->viewAttributes() ?>><?php echo $detection_view->methods->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detection_view->errorProofed->Visible) { // errorProofed ?>
	<tr id="r_errorProofed">
		<td class="<?php echo $detection_view->TableLeftColumnClass ?>"><span id="elh_detection_errorProofed"><?php echo $detection_view->errorProofed->caption() ?></span></td>
		<td data-name="errorProofed" <?php echo $detection_view->errorProofed->cellAttributes() ?>>
<span id="el_detection_errorProofed">
<span<?php echo $detection_view->errorProofed->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_errorProofed" class="custom-control-input" value="<?php echo $detection_view->errorProofed->getViewValue() ?>" disabled<?php if (ConvertToBool($detection_view->errorProofed->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_errorProofed"></label></div></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detection_view->gonogo->Visible) { // gonogo ?>
	<tr id="r_gonogo">
		<td class="<?php echo $detection_view->TableLeftColumnClass ?>"><span id="elh_detection_gonogo"><?php echo $detection_view->gonogo->caption() ?></span></td>
		<td data-name="gonogo" <?php echo $detection_view->gonogo->cellAttributes() ?>>
<span id="el_detection_gonogo">
<span<?php echo $detection_view->gonogo->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_gonogo" class="custom-control-input" value="<?php echo $detection_view->gonogo->getViewValue() ?>" disabled<?php if (ConvertToBool($detection_view->gonogo->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_gonogo"></label></div></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detection_view->visualInspection->Visible) { // visualInspection ?>
	<tr id="r_visualInspection">
		<td class="<?php echo $detection_view->TableLeftColumnClass ?>"><span id="elh_detection_visualInspection"><?php echo $detection_view->visualInspection->caption() ?></span></td>
		<td data-name="visualInspection" <?php echo $detection_view->visualInspection->cellAttributes() ?>>
<span id="el_detection_visualInspection">
<span<?php echo $detection_view->visualInspection->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_visualInspection" class="custom-control-input" value="<?php echo $detection_view->visualInspection->getViewValue() ?>" disabled<?php if (ConvertToBool($detection_view->visualInspection->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_visualInspection"></label></div></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detection_view->color->Visible) { // color ?>
	<tr id="r_color">
		<td class="<?php echo $detection_view->TableLeftColumnClass ?>"><span id="elh_detection_color"><?php echo $detection_view->color->caption() ?></span></td>
		<td data-name="color" <?php echo $detection_view->color->cellAttributes() ?>>
<span id="el_detection_color">
<span<?php echo $detection_view->color->viewAttributes() ?>><?php echo $detection_view->color->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$detection_view->IsModal) { ?>
<?php if (!$detection_view->isExport()) { ?>
<?php echo $detection_view->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
</form>
<?php
$detection_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$detection_view->isExport()) { ?>
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
$detection_view->terminate();
?>