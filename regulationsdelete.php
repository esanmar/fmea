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
$regulations_delete = new regulations_delete();

// Run the page
$regulations_delete->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$regulations_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fregulationsdelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	fregulationsdelete = currentForm = new ew.Form("fregulationsdelete", "delete");
	loadjs.done("fregulationsdelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $regulations_delete->showPageHeader(); ?>
<?php
$regulations_delete->showMessage();
?>
<form name="fregulationsdelete" id="fregulationsdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="regulations">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($regulations_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($regulations_delete->regulation->Visible) { // regulation ?>
		<th class="<?php echo $regulations_delete->regulation->headerCellClass() ?>"><span id="elh_regulations_regulation" class="regulations_regulation"><?php echo $regulations_delete->regulation->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$regulations_delete->RecordCount = 0;
$i = 0;
while (!$regulations_delete->Recordset->EOF) {
	$regulations_delete->RecordCount++;
	$regulations_delete->RowCount++;

	// Set row properties
	$regulations->resetAttributes();
	$regulations->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$regulations_delete->loadRowValues($regulations_delete->Recordset);

	// Render row
	$regulations_delete->renderRow();
?>
	<tr <?php echo $regulations->rowAttributes() ?>>
<?php if ($regulations_delete->regulation->Visible) { // regulation ?>
		<td <?php echo $regulations_delete->regulation->cellAttributes() ?>>
<span id="el<?php echo $regulations_delete->RowCount ?>_regulations_regulation" class="regulations_regulation">
<span<?php echo $regulations_delete->regulation->viewAttributes() ?>><?php echo $regulations_delete->regulation->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$regulations_delete->Recordset->moveNext();
}
$regulations_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $regulations_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$regulations_delete->showPageFooter();
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
$regulations_delete->terminate();
?>