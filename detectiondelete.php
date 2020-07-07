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
$detection_delete = new detection_delete();

// Run the page
$detection_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$detection_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fdetectiondelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	fdetectiondelete = currentForm = new ew.Form("fdetectiondelete", "delete");
	loadjs.done("fdetectiondelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $detection_delete->showPageHeader(); ?>
<?php
$detection_delete->showMessage();
?>
<form name="fdetectiondelete" id="fdetectiondelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="detection">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($detection_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($detection_delete->idDetection->Visible) { // idDetection ?>
		<th class="<?php echo $detection_delete->idDetection->headerCellClass() ?>"><span id="elh_detection_idDetection" class="detection_idDetection"><?php echo $detection_delete->idDetection->caption() ?></span></th>
<?php } ?>
<?php if ($detection_delete->detection->Visible) { // detection ?>
		<th class="<?php echo $detection_delete->detection->headerCellClass() ?>"><span id="elh_detection_detection" class="detection_detection"><?php echo $detection_delete->detection->caption() ?></span></th>
<?php } ?>
<?php if ($detection_delete->description->Visible) { // description ?>
		<th class="<?php echo $detection_delete->description->headerCellClass() ?>"><span id="elh_detection_description" class="detection_description"><?php echo $detection_delete->description->caption() ?></span></th>
<?php } ?>
<?php if ($detection_delete->methods->Visible) { // methods ?>
		<th class="<?php echo $detection_delete->methods->headerCellClass() ?>"><span id="elh_detection_methods" class="detection_methods"><?php echo $detection_delete->methods->caption() ?></span></th>
<?php } ?>
<?php if ($detection_delete->errorProofed->Visible) { // errorProofed ?>
		<th class="<?php echo $detection_delete->errorProofed->headerCellClass() ?>"><span id="elh_detection_errorProofed" class="detection_errorProofed"><?php echo $detection_delete->errorProofed->caption() ?></span></th>
<?php } ?>
<?php if ($detection_delete->gonogo->Visible) { // gonogo ?>
		<th class="<?php echo $detection_delete->gonogo->headerCellClass() ?>"><span id="elh_detection_gonogo" class="detection_gonogo"><?php echo $detection_delete->gonogo->caption() ?></span></th>
<?php } ?>
<?php if ($detection_delete->visualInspection->Visible) { // visualInspection ?>
		<th class="<?php echo $detection_delete->visualInspection->headerCellClass() ?>"><span id="elh_detection_visualInspection" class="detection_visualInspection"><?php echo $detection_delete->visualInspection->caption() ?></span></th>
<?php } ?>
<?php if ($detection_delete->color->Visible) { // color ?>
		<th class="<?php echo $detection_delete->color->headerCellClass() ?>"><span id="elh_detection_color" class="detection_color"><?php echo $detection_delete->color->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$detection_delete->RecordCount = 0;
$i = 0;
while (!$detection_delete->Recordset->EOF) {
	$detection_delete->RecordCount++;
	$detection_delete->RowCount++;

	// Set row properties
	$detection->resetAttributes();
	$detection->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$detection_delete->loadRowValues($detection_delete->Recordset);

	// Render row
	$detection_delete->renderRow();
?>
	<tr <?php echo $detection->rowAttributes() ?>>
<?php if ($detection_delete->idDetection->Visible) { // idDetection ?>
		<td <?php echo $detection_delete->idDetection->cellAttributes() ?>>
<span id="el<?php echo $detection_delete->RowCount ?>_detection_idDetection" class="detection_idDetection">
<span<?php echo $detection_delete->idDetection->viewAttributes() ?>><?php echo $detection_delete->idDetection->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($detection_delete->detection->Visible) { // detection ?>
		<td <?php echo $detection_delete->detection->cellAttributes() ?>>
<span id="el<?php echo $detection_delete->RowCount ?>_detection_detection" class="detection_detection">
<span<?php echo $detection_delete->detection->viewAttributes() ?>><?php echo $detection_delete->detection->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($detection_delete->description->Visible) { // description ?>
		<td <?php echo $detection_delete->description->cellAttributes() ?>>
<span id="el<?php echo $detection_delete->RowCount ?>_detection_description" class="detection_description">
<span<?php echo $detection_delete->description->viewAttributes() ?>><?php echo $detection_delete->description->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($detection_delete->methods->Visible) { // methods ?>
		<td <?php echo $detection_delete->methods->cellAttributes() ?>>
<span id="el<?php echo $detection_delete->RowCount ?>_detection_methods" class="detection_methods">
<span<?php echo $detection_delete->methods->viewAttributes() ?>><?php echo $detection_delete->methods->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($detection_delete->errorProofed->Visible) { // errorProofed ?>
		<td <?php echo $detection_delete->errorProofed->cellAttributes() ?>>
<span id="el<?php echo $detection_delete->RowCount ?>_detection_errorProofed" class="detection_errorProofed">
<span<?php echo $detection_delete->errorProofed->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_errorProofed" class="custom-control-input" value="<?php echo $detection_delete->errorProofed->getViewValue() ?>" disabled<?php if (ConvertToBool($detection_delete->errorProofed->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_errorProofed"></label></div></span>
</span>
</td>
<?php } ?>
<?php if ($detection_delete->gonogo->Visible) { // gonogo ?>
		<td <?php echo $detection_delete->gonogo->cellAttributes() ?>>
<span id="el<?php echo $detection_delete->RowCount ?>_detection_gonogo" class="detection_gonogo">
<span<?php echo $detection_delete->gonogo->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_gonogo" class="custom-control-input" value="<?php echo $detection_delete->gonogo->getViewValue() ?>" disabled<?php if (ConvertToBool($detection_delete->gonogo->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_gonogo"></label></div></span>
</span>
</td>
<?php } ?>
<?php if ($detection_delete->visualInspection->Visible) { // visualInspection ?>
		<td <?php echo $detection_delete->visualInspection->cellAttributes() ?>>
<span id="el<?php echo $detection_delete->RowCount ?>_detection_visualInspection" class="detection_visualInspection">
<span<?php echo $detection_delete->visualInspection->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_visualInspection" class="custom-control-input" value="<?php echo $detection_delete->visualInspection->getViewValue() ?>" disabled<?php if (ConvertToBool($detection_delete->visualInspection->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_visualInspection"></label></div></span>
</span>
</td>
<?php } ?>
<?php if ($detection_delete->color->Visible) { // color ?>
		<td <?php echo $detection_delete->color->cellAttributes() ?>>
<span id="el<?php echo $detection_delete->RowCount ?>_detection_color" class="detection_color">
<span<?php echo $detection_delete->color->viewAttributes() ?>><?php echo $detection_delete->color->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$detection_delete->Recordset->moveNext();
}
$detection_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $detection_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$detection_delete->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function() {

	// Startup script
	// Write your table-specific startup script here
	// console.log("page loaded");

});
</script>
<?php include_once "footer.php"; ?>
<?php
$detection_delete->terminate();
?>