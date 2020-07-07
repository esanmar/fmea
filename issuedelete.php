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
$issue_delete = new issue_delete();

// Run the page
$issue_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$issue_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fissuedelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	fissuedelete = currentForm = new ew.Form("fissuedelete", "delete");
	loadjs.done("fissuedelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $issue_delete->showPageHeader(); ?>
<?php
$issue_delete->showMessage();
?>
<form name="fissuedelete" id="fissuedelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="issue">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($issue_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($issue_delete->fmea->Visible) { // fmea ?>
		<th class="<?php echo $issue_delete->fmea->headerCellClass() ?>"><span id="elh_issue_fmea" class="issue_fmea"><?php echo $issue_delete->fmea->caption() ?></span></th>
<?php } ?>
<?php if ($issue_delete->issue->Visible) { // issue ?>
		<th class="<?php echo $issue_delete->issue->headerCellClass() ?>"><span id="elh_issue_issue" class="issue_issue"><?php echo $issue_delete->issue->caption() ?></span></th>
<?php } ?>
<?php if ($issue_delete->date->Visible) { // date ?>
		<th class="<?php echo $issue_delete->date->headerCellClass() ?>"><span id="elh_issue_date" class="issue_date"><?php echo $issue_delete->date->caption() ?></span></th>
<?php } ?>
<?php if ($issue_delete->cause->Visible) { // cause ?>
		<th class="<?php echo $issue_delete->cause->headerCellClass() ?>"><span id="elh_issue_cause" class="issue_cause"><?php echo $issue_delete->cause->caption() ?></span></th>
<?php } ?>
<?php if ($issue_delete->leader->Visible) { // leader ?>
		<th class="<?php echo $issue_delete->leader->headerCellClass() ?>"><span id="elh_issue_leader" class="issue_leader"><?php echo $issue_delete->leader->caption() ?></span></th>
<?php } ?>
<?php if ($issue_delete->employee->Visible) { // employee ?>
		<th class="<?php echo $issue_delete->employee->headerCellClass() ?>"><span id="elh_issue_employee" class="issue_employee"><?php echo $issue_delete->employee->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$issue_delete->RecordCount = 0;
$i = 0;
while (!$issue_delete->Recordset->EOF) {
	$issue_delete->RecordCount++;
	$issue_delete->RowCount++;

	// Set row properties
	$issue->resetAttributes();
	$issue->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$issue_delete->loadRowValues($issue_delete->Recordset);

	// Render row
	$issue_delete->renderRow();
?>
	<tr <?php echo $issue->rowAttributes() ?>>
<?php if ($issue_delete->fmea->Visible) { // fmea ?>
		<td <?php echo $issue_delete->fmea->cellAttributes() ?>>
<span id="el<?php echo $issue_delete->RowCount ?>_issue_fmea" class="issue_fmea">
<span<?php echo $issue_delete->fmea->viewAttributes() ?>><?php echo $issue_delete->fmea->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($issue_delete->issue->Visible) { // issue ?>
		<td <?php echo $issue_delete->issue->cellAttributes() ?>>
<span id="el<?php echo $issue_delete->RowCount ?>_issue_issue" class="issue_issue">
<span<?php echo $issue_delete->issue->viewAttributes() ?>><?php echo $issue_delete->issue->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($issue_delete->date->Visible) { // date ?>
		<td <?php echo $issue_delete->date->cellAttributes() ?>>
<span id="el<?php echo $issue_delete->RowCount ?>_issue_date" class="issue_date">
<span<?php echo $issue_delete->date->viewAttributes() ?>><?php echo $issue_delete->date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($issue_delete->cause->Visible) { // cause ?>
		<td <?php echo $issue_delete->cause->cellAttributes() ?>>
<span id="el<?php echo $issue_delete->RowCount ?>_issue_cause" class="issue_cause">
<span<?php echo $issue_delete->cause->viewAttributes() ?>><?php echo $issue_delete->cause->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($issue_delete->leader->Visible) { // leader ?>
		<td <?php echo $issue_delete->leader->cellAttributes() ?>>
<span id="el<?php echo $issue_delete->RowCount ?>_issue_leader" class="issue_leader">
<span<?php echo $issue_delete->leader->viewAttributes() ?>><?php echo $issue_delete->leader->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($issue_delete->employee->Visible) { // employee ?>
		<td <?php echo $issue_delete->employee->cellAttributes() ?>>
<span id="el<?php echo $issue_delete->RowCount ?>_issue_employee" class="issue_employee">
<span<?php echo $issue_delete->employee->viewAttributes() ?>><?php echo $issue_delete->employee->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$issue_delete->Recordset->moveNext();
}
$issue_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $issue_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$issue_delete->showPageFooter();
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
$issue_delete->terminate();
?>