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
$employees_delete = new employees_delete();

// Run the page
$employees_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$employees_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var femployeesdelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	femployeesdelete = currentForm = new ew.Form("femployeesdelete", "delete");
	loadjs.done("femployeesdelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $employees_delete->showPageHeader(); ?>
<?php
$employees_delete->showMessage();
?>
<form name="femployeesdelete" id="femployeesdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="employees">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($employees_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($employees_delete->idEmployee->Visible) { // idEmployee ?>
		<th class="<?php echo $employees_delete->idEmployee->headerCellClass() ?>"><span id="elh_employees_idEmployee" class="employees_idEmployee"><?php echo $employees_delete->idEmployee->caption() ?></span></th>
<?php } ?>
<?php if ($employees_delete->name->Visible) { // name ?>
		<th class="<?php echo $employees_delete->name->headerCellClass() ?>"><span id="elh_employees_name" class="employees_name"><?php echo $employees_delete->name->caption() ?></span></th>
<?php } ?>
<?php if ($employees_delete->surname->Visible) { // surname ?>
		<th class="<?php echo $employees_delete->surname->headerCellClass() ?>"><span id="elh_employees_surname" class="employees_surname"><?php echo $employees_delete->surname->caption() ?></span></th>
<?php } ?>
<?php if ($employees_delete->idFactory->Visible) { // idFactory ?>
		<th class="<?php echo $employees_delete->idFactory->headerCellClass() ?>"><span id="elh_employees_idFactory" class="employees_idFactory"><?php echo $employees_delete->idFactory->caption() ?></span></th>
<?php } ?>
<?php if ($employees_delete->userlevel->Visible) { // userlevel ?>
		<th class="<?php echo $employees_delete->userlevel->headerCellClass() ?>"><span id="elh_employees_userlevel" class="employees_userlevel"><?php echo $employees_delete->userlevel->caption() ?></span></th>
<?php } ?>
<?php if ($employees_delete->password->Visible) { // password ?>
		<th class="<?php echo $employees_delete->password->headerCellClass() ?>"><span id="elh_employees_password" class="employees_password"><?php echo $employees_delete->password->caption() ?></span></th>
<?php } ?>
<?php if ($employees_delete->workcenter->Visible) { // workcenter ?>
		<th class="<?php echo $employees_delete->workcenter->headerCellClass() ?>"><span id="elh_employees_workcenter" class="employees_workcenter"><?php echo $employees_delete->workcenter->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$employees_delete->RecordCount = 0;
$i = 0;
while (!$employees_delete->Recordset->EOF) {
	$employees_delete->RecordCount++;
	$employees_delete->RowCount++;

	// Set row properties
	$employees->resetAttributes();
	$employees->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$employees_delete->loadRowValues($employees_delete->Recordset);

	// Render row
	$employees_delete->renderRow();
?>
	<tr <?php echo $employees->rowAttributes() ?>>
<?php if ($employees_delete->idEmployee->Visible) { // idEmployee ?>
		<td <?php echo $employees_delete->idEmployee->cellAttributes() ?>>
<span id="el<?php echo $employees_delete->RowCount ?>_employees_idEmployee" class="employees_idEmployee">
<span<?php echo $employees_delete->idEmployee->viewAttributes() ?>><?php echo $employees_delete->idEmployee->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($employees_delete->name->Visible) { // name ?>
		<td <?php echo $employees_delete->name->cellAttributes() ?>>
<span id="el<?php echo $employees_delete->RowCount ?>_employees_name" class="employees_name">
<span<?php echo $employees_delete->name->viewAttributes() ?>><?php echo $employees_delete->name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($employees_delete->surname->Visible) { // surname ?>
		<td <?php echo $employees_delete->surname->cellAttributes() ?>>
<span id="el<?php echo $employees_delete->RowCount ?>_employees_surname" class="employees_surname">
<span<?php echo $employees_delete->surname->viewAttributes() ?>><?php echo $employees_delete->surname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($employees_delete->idFactory->Visible) { // idFactory ?>
		<td <?php echo $employees_delete->idFactory->cellAttributes() ?>>
<span id="el<?php echo $employees_delete->RowCount ?>_employees_idFactory" class="employees_idFactory">
<span<?php echo $employees_delete->idFactory->viewAttributes() ?>><?php echo $employees_delete->idFactory->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($employees_delete->userlevel->Visible) { // userlevel ?>
		<td <?php echo $employees_delete->userlevel->cellAttributes() ?>>
<span id="el<?php echo $employees_delete->RowCount ?>_employees_userlevel" class="employees_userlevel">
<span<?php echo $employees_delete->userlevel->viewAttributes() ?>><?php echo $employees_delete->userlevel->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($employees_delete->password->Visible) { // password ?>
		<td <?php echo $employees_delete->password->cellAttributes() ?>>
<span id="el<?php echo $employees_delete->RowCount ?>_employees_password" class="employees_password">
<span<?php echo $employees_delete->password->viewAttributes() ?>><?php echo $employees_delete->password->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($employees_delete->workcenter->Visible) { // workcenter ?>
		<td <?php echo $employees_delete->workcenter->cellAttributes() ?>>
<span id="el<?php echo $employees_delete->RowCount ?>_employees_workcenter" class="employees_workcenter">
<span<?php echo $employees_delete->workcenter->viewAttributes() ?>><?php echo $employees_delete->workcenter->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$employees_delete->Recordset->moveNext();
}
$employees_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $employees_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$employees_delete->showPageFooter();
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
$employees_delete->terminate();
?>