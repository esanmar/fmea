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
$suppliers_delete = new suppliers_delete();

// Run the page
$suppliers_delete->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$suppliers_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fsuppliersdelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	fsuppliersdelete = currentForm = new ew.Form("fsuppliersdelete", "delete");
	loadjs.done("fsuppliersdelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $suppliers_delete->showPageHeader(); ?>
<?php
$suppliers_delete->showMessage();
?>
<form name="fsuppliersdelete" id="fsuppliersdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="suppliers">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($suppliers_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($suppliers_delete->supplier->Visible) { // supplier ?>
		<th class="<?php echo $suppliers_delete->supplier->headerCellClass() ?>"><span id="elh_suppliers_supplier" class="suppliers_supplier"><?php echo $suppliers_delete->supplier->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$suppliers_delete->RecordCount = 0;
$i = 0;
while (!$suppliers_delete->Recordset->EOF) {
	$suppliers_delete->RecordCount++;
	$suppliers_delete->RowCount++;

	// Set row properties
	$suppliers->resetAttributes();
	$suppliers->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$suppliers_delete->loadRowValues($suppliers_delete->Recordset);

	// Render row
	$suppliers_delete->renderRow();
?>
	<tr <?php echo $suppliers->rowAttributes() ?>>
<?php if ($suppliers_delete->supplier->Visible) { // supplier ?>
		<td <?php echo $suppliers_delete->supplier->cellAttributes() ?>>
<span id="el<?php echo $suppliers_delete->RowCount ?>_suppliers_supplier" class="suppliers_supplier">
<span<?php echo $suppliers_delete->supplier->viewAttributes() ?>><?php echo $suppliers_delete->supplier->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$suppliers_delete->Recordset->moveNext();
}
$suppliers_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $suppliers_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$suppliers_delete->showPageFooter();
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
$suppliers_delete->terminate();
?>