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
$factories_delete = new factories_delete();

// Run the page
$factories_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$factories_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var ffactoriesdelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	ffactoriesdelete = currentForm = new ew.Form("ffactoriesdelete", "delete");
	loadjs.done("ffactoriesdelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $factories_delete->showPageHeader(); ?>
<?php
$factories_delete->showMessage();
?>
<form name="ffactoriesdelete" id="ffactoriesdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="factories">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($factories_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($factories_delete->idFactory->Visible) { // idFactory ?>
		<th class="<?php echo $factories_delete->idFactory->headerCellClass() ?>"><span id="elh_factories_idFactory" class="factories_idFactory"><?php echo $factories_delete->idFactory->caption() ?></span></th>
<?php } ?>
<?php if ($factories_delete->factory->Visible) { // factory ?>
		<th class="<?php echo $factories_delete->factory->headerCellClass() ?>"><span id="elh_factories_factory" class="factories_factory"><?php echo $factories_delete->factory->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$factories_delete->RecordCount = 0;
$i = 0;
while (!$factories_delete->Recordset->EOF) {
	$factories_delete->RecordCount++;
	$factories_delete->RowCount++;

	// Set row properties
	$factories->resetAttributes();
	$factories->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$factories_delete->loadRowValues($factories_delete->Recordset);

	// Render row
	$factories_delete->renderRow();
?>
	<tr <?php echo $factories->rowAttributes() ?>>
<?php if ($factories_delete->idFactory->Visible) { // idFactory ?>
		<td <?php echo $factories_delete->idFactory->cellAttributes() ?>>
<span id="el<?php echo $factories_delete->RowCount ?>_factories_idFactory" class="factories_idFactory">
<span<?php echo $factories_delete->idFactory->viewAttributes() ?>><?php echo $factories_delete->idFactory->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($factories_delete->factory->Visible) { // factory ?>
		<td <?php echo $factories_delete->factory->cellAttributes() ?>>
<span id="el<?php echo $factories_delete->RowCount ?>_factories_factory" class="factories_factory">
<span<?php echo $factories_delete->factory->viewAttributes() ?>><?php echo $factories_delete->factory->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$factories_delete->Recordset->moveNext();
}
$factories_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $factories_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$factories_delete->showPageFooter();
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
$factories_delete->terminate();
?>