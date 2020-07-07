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
$processf_delete = new processf_delete();

// Run the page
$processf_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$processf_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fprocessfdelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	fprocessfdelete = currentForm = new ew.Form("fprocessfdelete", "delete");
	loadjs.done("fprocessfdelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $processf_delete->showPageHeader(); ?>
<?php
$processf_delete->showMessage();
?>
<form name="fprocessfdelete" id="fprocessfdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="processf">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($processf_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($processf_delete->fmea->Visible) { // fmea ?>
		<th class="<?php echo $processf_delete->fmea->headerCellClass() ?>"><span id="elh_processf_fmea" class="processf_fmea"><?php echo $processf_delete->fmea->caption() ?></span></th>
<?php } ?>
<?php if ($processf_delete->step->Visible) { // step ?>
		<th class="<?php echo $processf_delete->step->headerCellClass() ?>"><span id="elh_processf_step" class="processf_step"><?php echo $processf_delete->step->caption() ?></span></th>
<?php } ?>
<?php if ($processf_delete->flowchartDesc->Visible) { // flowchartDesc ?>
		<th class="<?php echo $processf_delete->flowchartDesc->headerCellClass() ?>"><span id="elh_processf_flowchartDesc" class="processf_flowchartDesc"><?php echo $processf_delete->flowchartDesc->caption() ?></span></th>
<?php } ?>
<?php if ($processf_delete->partnumber->Visible) { // partnumber ?>
		<th class="<?php echo $processf_delete->partnumber->headerCellClass() ?>"><span id="elh_processf_partnumber" class="processf_partnumber"><?php echo $processf_delete->partnumber->caption() ?></span></th>
<?php } ?>
<?php if ($processf_delete->operation->Visible) { // operation ?>
		<th class="<?php echo $processf_delete->operation->headerCellClass() ?>"><span id="elh_processf_operation" class="processf_operation"><?php echo $processf_delete->operation->caption() ?></span></th>
<?php } ?>
<?php if ($processf_delete->derivedFromNC->Visible) { // derivedFromNC ?>
		<th class="<?php echo $processf_delete->derivedFromNC->headerCellClass() ?>"><span id="elh_processf_derivedFromNC" class="processf_derivedFromNC"><?php echo $processf_delete->derivedFromNC->caption() ?></span></th>
<?php } ?>
<?php if ($processf_delete->numberOfNC->Visible) { // numberOfNC ?>
		<th class="<?php echo $processf_delete->numberOfNC->headerCellClass() ?>"><span id="elh_processf_numberOfNC" class="processf_numberOfNC"><?php echo $processf_delete->numberOfNC->caption() ?></span></th>
<?php } ?>
<?php if ($processf_delete->flowchart->Visible) { // flowchart ?>
		<th class="<?php echo $processf_delete->flowchart->headerCellClass() ?>"><span id="elh_processf_flowchart" class="processf_flowchart"><?php echo $processf_delete->flowchart->caption() ?></span></th>
<?php } ?>
<?php if ($processf_delete->subprocess->Visible) { // subprocess ?>
		<th class="<?php echo $processf_delete->subprocess->headerCellClass() ?>"><span id="elh_processf_subprocess" class="processf_subprocess"><?php echo $processf_delete->subprocess->caption() ?></span></th>
<?php } ?>
<?php if ($processf_delete->requirement->Visible) { // requirement ?>
		<th class="<?php echo $processf_delete->requirement->headerCellClass() ?>"><span id="elh_processf_requirement" class="processf_requirement"><?php echo $processf_delete->requirement->caption() ?></span></th>
<?php } ?>
<?php if ($processf_delete->potencialFailureMode->Visible) { // potencialFailureMode ?>
		<th class="<?php echo $processf_delete->potencialFailureMode->headerCellClass() ?>"><span id="elh_processf_potencialFailureMode" class="processf_potencialFailureMode"><?php echo $processf_delete->potencialFailureMode->caption() ?></span></th>
<?php } ?>
<?php if ($processf_delete->potencialFailurEffect->Visible) { // potencialFailurEffect ?>
		<th class="<?php echo $processf_delete->potencialFailurEffect->headerCellClass() ?>"><span id="elh_processf_potencialFailurEffect" class="processf_potencialFailurEffect"><?php echo $processf_delete->potencialFailurEffect->caption() ?></span></th>
<?php } ?>
<?php if ($processf_delete->kc->Visible) { // kc ?>
		<th class="<?php echo $processf_delete->kc->headerCellClass() ?>"><span id="elh_processf_kc" class="processf_kc"><?php echo $processf_delete->kc->caption() ?></span></th>
<?php } ?>
<?php if ($processf_delete->severity->Visible) { // severity ?>
		<th class="<?php echo $processf_delete->severity->headerCellClass() ?>"><span id="elh_processf_severity" class="processf_severity"><?php echo $processf_delete->severity->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$processf_delete->RecordCount = 0;
$i = 0;
while (!$processf_delete->Recordset->EOF) {
	$processf_delete->RecordCount++;
	$processf_delete->RowCount++;

	// Set row properties
	$processf->resetAttributes();
	$processf->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$processf_delete->loadRowValues($processf_delete->Recordset);

	// Render row
	$processf_delete->renderRow();
?>
	<tr <?php echo $processf->rowAttributes() ?>>
<?php if ($processf_delete->fmea->Visible) { // fmea ?>
		<td <?php echo $processf_delete->fmea->cellAttributes() ?>>
<span id="el<?php echo $processf_delete->RowCount ?>_processf_fmea" class="processf_fmea">
<span<?php echo $processf_delete->fmea->viewAttributes() ?>><?php echo $processf_delete->fmea->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($processf_delete->step->Visible) { // step ?>
		<td <?php echo $processf_delete->step->cellAttributes() ?>>
<span id="el<?php echo $processf_delete->RowCount ?>_processf_step" class="processf_step">
<span<?php echo $processf_delete->step->viewAttributes() ?>><?php echo $processf_delete->step->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($processf_delete->flowchartDesc->Visible) { // flowchartDesc ?>
		<td <?php echo $processf_delete->flowchartDesc->cellAttributes() ?>>
<span id="el<?php echo $processf_delete->RowCount ?>_processf_flowchartDesc" class="processf_flowchartDesc">
<span<?php echo $processf_delete->flowchartDesc->viewAttributes() ?>><?php echo $processf_delete->flowchartDesc->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($processf_delete->partnumber->Visible) { // partnumber ?>
		<td <?php echo $processf_delete->partnumber->cellAttributes() ?>>
<span id="el<?php echo $processf_delete->RowCount ?>_processf_partnumber" class="processf_partnumber">
<span<?php echo $processf_delete->partnumber->viewAttributes() ?>><?php echo $processf_delete->partnumber->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($processf_delete->operation->Visible) { // operation ?>
		<td <?php echo $processf_delete->operation->cellAttributes() ?>>
<span id="el<?php echo $processf_delete->RowCount ?>_processf_operation" class="processf_operation">
<span<?php echo $processf_delete->operation->viewAttributes() ?>><?php echo $processf_delete->operation->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($processf_delete->derivedFromNC->Visible) { // derivedFromNC ?>
		<td <?php echo $processf_delete->derivedFromNC->cellAttributes() ?>>
<span id="el<?php echo $processf_delete->RowCount ?>_processf_derivedFromNC" class="processf_derivedFromNC">
<span<?php echo $processf_delete->derivedFromNC->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_derivedFromNC" class="custom-control-input" value="<?php echo $processf_delete->derivedFromNC->getViewValue() ?>" disabled<?php if (ConvertToBool($processf_delete->derivedFromNC->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_derivedFromNC"></label></div></span>
</span>
</td>
<?php } ?>
<?php if ($processf_delete->numberOfNC->Visible) { // numberOfNC ?>
		<td <?php echo $processf_delete->numberOfNC->cellAttributes() ?>>
<span id="el<?php echo $processf_delete->RowCount ?>_processf_numberOfNC" class="processf_numberOfNC">
<span<?php echo $processf_delete->numberOfNC->viewAttributes() ?>><?php echo $processf_delete->numberOfNC->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($processf_delete->flowchart->Visible) { // flowchart ?>
		<td <?php echo $processf_delete->flowchart->cellAttributes() ?>>
<span id="el<?php echo $processf_delete->RowCount ?>_processf_flowchart" class="processf_flowchart">
<span<?php echo $processf_delete->flowchart->viewAttributes() ?>><?php echo $processf_delete->flowchart->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($processf_delete->subprocess->Visible) { // subprocess ?>
		<td <?php echo $processf_delete->subprocess->cellAttributes() ?>>
<span id="el<?php echo $processf_delete->RowCount ?>_processf_subprocess" class="processf_subprocess">
<span<?php echo $processf_delete->subprocess->viewAttributes() ?>><?php echo $processf_delete->subprocess->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($processf_delete->requirement->Visible) { // requirement ?>
		<td <?php echo $processf_delete->requirement->cellAttributes() ?>>
<span id="el<?php echo $processf_delete->RowCount ?>_processf_requirement" class="processf_requirement">
<span<?php echo $processf_delete->requirement->viewAttributes() ?>><?php echo $processf_delete->requirement->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($processf_delete->potencialFailureMode->Visible) { // potencialFailureMode ?>
		<td <?php echo $processf_delete->potencialFailureMode->cellAttributes() ?>>
<span id="el<?php echo $processf_delete->RowCount ?>_processf_potencialFailureMode" class="processf_potencialFailureMode">
<span<?php echo $processf_delete->potencialFailureMode->viewAttributes() ?>><?php echo $processf_delete->potencialFailureMode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($processf_delete->potencialFailurEffect->Visible) { // potencialFailurEffect ?>
		<td <?php echo $processf_delete->potencialFailurEffect->cellAttributes() ?>>
<span id="el<?php echo $processf_delete->RowCount ?>_processf_potencialFailurEffect" class="processf_potencialFailurEffect">
<span<?php echo $processf_delete->potencialFailurEffect->viewAttributes() ?>><?php echo $processf_delete->potencialFailurEffect->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($processf_delete->kc->Visible) { // kc ?>
		<td <?php echo $processf_delete->kc->cellAttributes() ?>>
<span id="el<?php echo $processf_delete->RowCount ?>_processf_kc" class="processf_kc">
<span<?php echo $processf_delete->kc->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_kc" class="custom-control-input" value="<?php echo $processf_delete->kc->getViewValue() ?>" disabled<?php if (ConvertToBool($processf_delete->kc->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_kc"></label></div></span>
</span>
</td>
<?php } ?>
<?php if ($processf_delete->severity->Visible) { // severity ?>
		<td <?php echo $processf_delete->severity->cellAttributes() ?>>
<span id="el<?php echo $processf_delete->RowCount ?>_processf_severity" class="processf_severity">
<span<?php echo $processf_delete->severity->viewAttributes() ?>><?php echo $processf_delete->severity->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$processf_delete->Recordset->moveNext();
}
$processf_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $processf_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$processf_delete->showPageFooter();
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
$processf_delete->terminate();
?>