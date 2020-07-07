<?php
namespace PHPMaker2020\SupplierMapping;

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
$mapping_delete = new mapping_delete();

// Run the page
$mapping_delete->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$mapping_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fmappingdelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	fmappingdelete = currentForm = new ew.Form("fmappingdelete", "delete");
	loadjs.done("fmappingdelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $mapping_delete->showPageHeader(); ?>
<?php
$mapping_delete->showMessage();
?>
<form name="fmappingdelete" id="fmappingdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="mapping">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($mapping_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($mapping_delete->idProcess->Visible) { // idProcess ?>
		<th class="<?php echo $mapping_delete->idProcess->headerCellClass() ?>"><span id="elh_mapping_idProcess" class="mapping_idProcess"><?php echo $mapping_delete->idProcess->caption() ?></span></th>
<?php } ?>
<?php if ($mapping_delete->process->Visible) { // process ?>
		<th class="<?php echo $mapping_delete->process->headerCellClass() ?>"><span id="elh_mapping_process" class="mapping_process"><?php echo $mapping_delete->process->caption() ?></span></th>
<?php } ?>
<?php if ($mapping_delete->regulation->Visible) { // regulation ?>
		<th class="<?php echo $mapping_delete->regulation->headerCellClass() ?>"><span id="elh_mapping_regulation" class="mapping_regulation"><?php echo $mapping_delete->regulation->caption() ?></span></th>
<?php } ?>
<?php if ($mapping_delete->qualification->Visible) { // qualification ?>
		<th class="<?php echo $mapping_delete->qualification->headerCellClass() ?>"><span id="elh_mapping_qualification" class="mapping_qualification"><?php echo $mapping_delete->qualification->caption() ?></span></th>
<?php } ?>
<?php if ($mapping_delete->supplierLevel2->Visible) { // supplierLevel2 ?>
		<th class="<?php echo $mapping_delete->supplierLevel2->headerCellClass() ?>"><span id="elh_mapping_supplierLevel2" class="mapping_supplierLevel2"><?php echo $mapping_delete->supplierLevel2->caption() ?></span></th>
<?php } ?>
<?php if ($mapping_delete->supplierLevel3->Visible) { // supplierLevel3 ?>
		<th class="<?php echo $mapping_delete->supplierLevel3->headerCellClass() ?>"><span id="elh_mapping_supplierLevel3" class="mapping_supplierLevel3"><?php echo $mapping_delete->supplierLevel3->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$mapping_delete->RecordCount = 0;
$i = 0;
while (!$mapping_delete->Recordset->EOF) {
	$mapping_delete->RecordCount++;
	$mapping_delete->RowCount++;

	// Set row properties
	$mapping->resetAttributes();
	$mapping->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$mapping_delete->loadRowValues($mapping_delete->Recordset);

	// Render row
	$mapping_delete->renderRow();
?>
	<tr <?php echo $mapping->rowAttributes() ?>>
<?php if ($mapping_delete->idProcess->Visible) { // idProcess ?>
		<td <?php echo $mapping_delete->idProcess->cellAttributes() ?>>
<span id="el<?php echo $mapping_delete->RowCount ?>_mapping_idProcess" class="mapping_idProcess">
<span<?php echo $mapping_delete->idProcess->viewAttributes() ?>><?php echo $mapping_delete->idProcess->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($mapping_delete->process->Visible) { // process ?>
		<td <?php echo $mapping_delete->process->cellAttributes() ?>>
<span id="el<?php echo $mapping_delete->RowCount ?>_mapping_process" class="mapping_process">
<span<?php echo $mapping_delete->process->viewAttributes() ?>><?php echo $mapping_delete->process->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($mapping_delete->regulation->Visible) { // regulation ?>
		<td <?php echo $mapping_delete->regulation->cellAttributes() ?>>
<span id="el<?php echo $mapping_delete->RowCount ?>_mapping_regulation" class="mapping_regulation">
<span<?php echo $mapping_delete->regulation->viewAttributes() ?>><?php echo $mapping_delete->regulation->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($mapping_delete->qualification->Visible) { // qualification ?>
		<td <?php echo $mapping_delete->qualification->cellAttributes() ?>>
<span id="el<?php echo $mapping_delete->RowCount ?>_mapping_qualification" class="mapping_qualification">
<span<?php echo $mapping_delete->qualification->viewAttributes() ?>><?php echo $mapping_delete->qualification->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($mapping_delete->supplierLevel2->Visible) { // supplierLevel2 ?>
		<td <?php echo $mapping_delete->supplierLevel2->cellAttributes() ?>>
<span id="el<?php echo $mapping_delete->RowCount ?>_mapping_supplierLevel2" class="mapping_supplierLevel2">
<span<?php echo $mapping_delete->supplierLevel2->viewAttributes() ?>><?php echo $mapping_delete->supplierLevel2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($mapping_delete->supplierLevel3->Visible) { // supplierLevel3 ?>
		<td <?php echo $mapping_delete->supplierLevel3->cellAttributes() ?>>
<span id="el<?php echo $mapping_delete->RowCount ?>_mapping_supplierLevel3" class="mapping_supplierLevel3">
<span<?php echo $mapping_delete->supplierLevel3->viewAttributes() ?>><?php echo $mapping_delete->supplierLevel3->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$mapping_delete->Recordset->moveNext();
}
$mapping_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $mapping_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$mapping_delete->showPageFooter();
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
$mapping_delete->terminate();
?>