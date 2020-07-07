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
$workcenters_delete = new workcenters_delete();

// Run the page
$workcenters_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$workcenters_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fworkcentersdelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	fworkcentersdelete = currentForm = new ew.Form("fworkcentersdelete", "delete");
	loadjs.done("fworkcentersdelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $workcenters_delete->showPageHeader(); ?>
<?php
$workcenters_delete->showMessage();
?>
<form name="fworkcentersdelete" id="fworkcentersdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="workcenters">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($workcenters_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($workcenters_delete->workcenter->Visible) { // workcenter ?>
		<th class="<?php echo $workcenters_delete->workcenter->headerCellClass() ?>"><span id="elh_workcenters_workcenter" class="workcenters_workcenter"><?php echo $workcenters_delete->workcenter->caption() ?></span></th>
<?php } ?>
<?php if ($workcenters_delete->description->Visible) { // description ?>
		<th class="<?php echo $workcenters_delete->description->headerCellClass() ?>"><span id="elh_workcenters_description" class="workcenters_description"><?php echo $workcenters_delete->description->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$workcenters_delete->RecordCount = 0;
$i = 0;
while (!$workcenters_delete->Recordset->EOF) {
	$workcenters_delete->RecordCount++;
	$workcenters_delete->RowCount++;

	// Set row properties
	$workcenters->resetAttributes();
	$workcenters->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$workcenters_delete->loadRowValues($workcenters_delete->Recordset);

	// Render row
	$workcenters_delete->renderRow();
?>
	<tr <?php echo $workcenters->rowAttributes() ?>>
<?php if ($workcenters_delete->workcenter->Visible) { // workcenter ?>
		<td <?php echo $workcenters_delete->workcenter->cellAttributes() ?>>
<span id="el<?php echo $workcenters_delete->RowCount ?>_workcenters_workcenter" class="workcenters_workcenter">
<span<?php echo $workcenters_delete->workcenter->viewAttributes() ?>><?php echo $workcenters_delete->workcenter->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($workcenters_delete->description->Visible) { // description ?>
		<td <?php echo $workcenters_delete->description->cellAttributes() ?>>
<span id="el<?php echo $workcenters_delete->RowCount ?>_workcenters_description" class="workcenters_description">
<span<?php echo $workcenters_delete->description->viewAttributes() ?>><?php echo $workcenters_delete->description->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$workcenters_delete->Recordset->moveNext();
}
$workcenters_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $workcenters_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$workcenters_delete->showPageFooter();
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
$workcenters_delete->terminate();
?>