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
$fmea_delete = new fmea_delete();

// Run the page
$fmea_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$fmea_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var ffmeadelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	ffmeadelete = currentForm = new ew.Form("ffmeadelete", "delete");
	loadjs.done("ffmeadelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $fmea_delete->showPageHeader(); ?>
<?php
$fmea_delete->showMessage();
?>
<form name="ffmeadelete" id="ffmeadelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="fmea">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($fmea_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($fmea_delete->fmea->Visible) { // fmea ?>
		<th class="<?php echo $fmea_delete->fmea->headerCellClass() ?>"><span id="elh_fmea_fmea" class="fmea_fmea"><?php echo $fmea_delete->fmea->caption() ?></span></th>
<?php } ?>
<?php if ($fmea_delete->idFactory->Visible) { // idFactory ?>
		<th class="<?php echo $fmea_delete->idFactory->headerCellClass() ?>"><span id="elh_fmea_idFactory" class="fmea_idFactory"><?php echo $fmea_delete->idFactory->caption() ?></span></th>
<?php } ?>
<?php if ($fmea_delete->dateFmea->Visible) { // dateFmea ?>
		<th class="<?php echo $fmea_delete->dateFmea->headerCellClass() ?>"><span id="elh_fmea_dateFmea" class="fmea_dateFmea"><?php echo $fmea_delete->dateFmea->caption() ?></span></th>
<?php } ?>
<?php if ($fmea_delete->partnumbers->Visible) { // partnumbers ?>
		<th class="<?php echo $fmea_delete->partnumbers->headerCellClass() ?>"><span id="elh_fmea_partnumbers" class="fmea_partnumbers"><?php echo $fmea_delete->partnumbers->caption() ?></span></th>
<?php } ?>
<?php if ($fmea_delete->description->Visible) { // description ?>
		<th class="<?php echo $fmea_delete->description->headerCellClass() ?>"><span id="elh_fmea_description" class="fmea_description"><?php echo $fmea_delete->description->caption() ?></span></th>
<?php } ?>
<?php if ($fmea_delete->idEmployee->Visible) { // idEmployee ?>
		<th class="<?php echo $fmea_delete->idEmployee->headerCellClass() ?>"><span id="elh_fmea_idEmployee" class="fmea_idEmployee"><?php echo $fmea_delete->idEmployee->caption() ?></span></th>
<?php } ?>
<?php if ($fmea_delete->idworkcenter->Visible) { // idworkcenter ?>
		<th class="<?php echo $fmea_delete->idworkcenter->headerCellClass() ?>"><span id="elh_fmea_idworkcenter" class="fmea_idworkcenter"><?php echo $fmea_delete->idworkcenter->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$fmea_delete->RecordCount = 0;
$i = 0;
while (!$fmea_delete->Recordset->EOF) {
	$fmea_delete->RecordCount++;
	$fmea_delete->RowCount++;

	// Set row properties
	$fmea->resetAttributes();
	$fmea->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$fmea_delete->loadRowValues($fmea_delete->Recordset);

	// Render row
	$fmea_delete->renderRow();
?>
	<tr <?php echo $fmea->rowAttributes() ?>>
<?php if ($fmea_delete->fmea->Visible) { // fmea ?>
		<td <?php echo $fmea_delete->fmea->cellAttributes() ?>>
<span id="el<?php echo $fmea_delete->RowCount ?>_fmea_fmea" class="fmea_fmea">
<span<?php echo $fmea_delete->fmea->viewAttributes() ?>><?php echo $fmea_delete->fmea->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($fmea_delete->idFactory->Visible) { // idFactory ?>
		<td <?php echo $fmea_delete->idFactory->cellAttributes() ?>>
<span id="el<?php echo $fmea_delete->RowCount ?>_fmea_idFactory" class="fmea_idFactory">
<span<?php echo $fmea_delete->idFactory->viewAttributes() ?>><?php echo $fmea_delete->idFactory->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($fmea_delete->dateFmea->Visible) { // dateFmea ?>
		<td <?php echo $fmea_delete->dateFmea->cellAttributes() ?>>
<span id="el<?php echo $fmea_delete->RowCount ?>_fmea_dateFmea" class="fmea_dateFmea">
<span<?php echo $fmea_delete->dateFmea->viewAttributes() ?>><?php echo $fmea_delete->dateFmea->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($fmea_delete->partnumbers->Visible) { // partnumbers ?>
		<td <?php echo $fmea_delete->partnumbers->cellAttributes() ?>>
<span id="el<?php echo $fmea_delete->RowCount ?>_fmea_partnumbers" class="fmea_partnumbers">
<span<?php echo $fmea_delete->partnumbers->viewAttributes() ?>><?php echo $fmea_delete->partnumbers->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($fmea_delete->description->Visible) { // description ?>
		<td <?php echo $fmea_delete->description->cellAttributes() ?>>
<span id="el<?php echo $fmea_delete->RowCount ?>_fmea_description" class="fmea_description">
<span<?php echo $fmea_delete->description->viewAttributes() ?>><?php echo $fmea_delete->description->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($fmea_delete->idEmployee->Visible) { // idEmployee ?>
		<td <?php echo $fmea_delete->idEmployee->cellAttributes() ?>>
<span id="el<?php echo $fmea_delete->RowCount ?>_fmea_idEmployee" class="fmea_idEmployee">
<span<?php echo $fmea_delete->idEmployee->viewAttributes() ?>><?php echo $fmea_delete->idEmployee->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($fmea_delete->idworkcenter->Visible) { // idworkcenter ?>
		<td <?php echo $fmea_delete->idworkcenter->cellAttributes() ?>>
<span id="el<?php echo $fmea_delete->RowCount ?>_fmea_idworkcenter" class="fmea_idworkcenter">
<span<?php echo $fmea_delete->idworkcenter->viewAttributes() ?>><?php echo $fmea_delete->idworkcenter->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$fmea_delete->Recordset->moveNext();
}
$fmea_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $fmea_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$fmea_delete->showPageFooter();
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
$fmea_delete->terminate();
?>