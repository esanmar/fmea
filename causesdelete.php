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
$causes_delete = new causes_delete();

// Run the page
$causes_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$causes_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fcausesdelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	fcausesdelete = currentForm = new ew.Form("fcausesdelete", "delete");
	loadjs.done("fcausesdelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $causes_delete->showPageHeader(); ?>
<?php
$causes_delete->showMessage();
?>
<form name="fcausesdelete" id="fcausesdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="causes">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($causes_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($causes_delete->idCause->Visible) { // idCause ?>
		<th class="<?php echo $causes_delete->idCause->headerCellClass() ?>"><span id="elh_causes_idCause" class="causes_idCause"><?php echo $causes_delete->idCause->caption() ?></span></th>
<?php } ?>
<?php if ($causes_delete->cause->Visible) { // cause ?>
		<th class="<?php echo $causes_delete->cause->headerCellClass() ?>"><span id="elh_causes_cause" class="causes_cause"><?php echo $causes_delete->cause->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$causes_delete->RecordCount = 0;
$i = 0;
while (!$causes_delete->Recordset->EOF) {
	$causes_delete->RecordCount++;
	$causes_delete->RowCount++;

	// Set row properties
	$causes->resetAttributes();
	$causes->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$causes_delete->loadRowValues($causes_delete->Recordset);

	// Render row
	$causes_delete->renderRow();
?>
	<tr <?php echo $causes->rowAttributes() ?>>
<?php if ($causes_delete->idCause->Visible) { // idCause ?>
		<td <?php echo $causes_delete->idCause->cellAttributes() ?>>
<span id="el<?php echo $causes_delete->RowCount ?>_causes_idCause" class="causes_idCause">
<span<?php echo $causes_delete->idCause->viewAttributes() ?>><?php echo $causes_delete->idCause->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($causes_delete->cause->Visible) { // cause ?>
		<td <?php echo $causes_delete->cause->cellAttributes() ?>>
<span id="el<?php echo $causes_delete->RowCount ?>_causes_cause" class="causes_cause">
<span<?php echo $causes_delete->cause->viewAttributes() ?>><?php echo $causes_delete->cause->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$causes_delete->Recordset->moveNext();
}
$causes_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $causes_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$causes_delete->showPageFooter();
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
$causes_delete->terminate();
?>