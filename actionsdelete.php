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
$actions_delete = new actions_delete();

// Run the page
$actions_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$actions_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var factionsdelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	factionsdelete = currentForm = new ew.Form("factionsdelete", "delete");
	loadjs.done("factionsdelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $actions_delete->showPageHeader(); ?>
<?php
$actions_delete->showMessage();
?>
<form name="factionsdelete" id="factionsdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="actions">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($actions_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($actions_delete->idProcess->Visible) { // idProcess ?>
		<th class="<?php echo $actions_delete->idProcess->headerCellClass() ?>"><span id="elh_actions_idProcess" class="actions_idProcess"><?php echo $actions_delete->idProcess->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->idCause->Visible) { // idCause ?>
		<th class="<?php echo $actions_delete->idCause->headerCellClass() ?>"><span id="elh_actions_idCause" class="actions_idCause"><?php echo $actions_delete->idCause->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->potentialCauses->Visible) { // potentialCauses ?>
		<th class="<?php echo $actions_delete->potentialCauses->headerCellClass() ?>"><span id="elh_actions_potentialCauses" class="actions_potentialCauses"><?php echo $actions_delete->potentialCauses->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->currentPreventiveControlMethod->Visible) { // currentPreventiveControlMethod ?>
		<th class="<?php echo $actions_delete->currentPreventiveControlMethod->headerCellClass() ?>"><span id="elh_actions_currentPreventiveControlMethod" class="actions_currentPreventiveControlMethod"><?php echo $actions_delete->currentPreventiveControlMethod->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->severity->Visible) { // severity ?>
		<th class="<?php echo $actions_delete->severity->headerCellClass() ?>"><span id="elh_actions_severity" class="actions_severity"><?php echo $actions_delete->severity->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->occurrence->Visible) { // occurrence ?>
		<th class="<?php echo $actions_delete->occurrence->headerCellClass() ?>"><span id="elh_actions_occurrence" class="actions_occurrence"><?php echo $actions_delete->occurrence->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->currentControlMethod->Visible) { // currentControlMethod ?>
		<th class="<?php echo $actions_delete->currentControlMethod->headerCellClass() ?>"><span id="elh_actions_currentControlMethod" class="actions_currentControlMethod"><?php echo $actions_delete->currentControlMethod->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->detection->Visible) { // detection ?>
		<th class="<?php echo $actions_delete->detection->headerCellClass() ?>"><span id="elh_actions_detection" class="actions_detection"><?php echo $actions_delete->detection->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->RPNCalc->Visible) { // RPNCalc ?>
		<th class="<?php echo $actions_delete->RPNCalc->headerCellClass() ?>"><span id="elh_actions_RPNCalc" class="actions_RPNCalc"><?php echo $actions_delete->RPNCalc->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->recomendedAction->Visible) { // recomendedAction ?>
		<th class="<?php echo $actions_delete->recomendedAction->headerCellClass() ?>"><span id="elh_actions_recomendedAction" class="actions_recomendedAction"><?php echo $actions_delete->recomendedAction->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->idResponsible->Visible) { // idResponsible ?>
		<th class="<?php echo $actions_delete->idResponsible->headerCellClass() ?>"><span id="elh_actions_idResponsible" class="actions_idResponsible"><?php echo $actions_delete->idResponsible->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->targetDate->Visible) { // targetDate ?>
		<th class="<?php echo $actions_delete->targetDate->headerCellClass() ?>"><span id="elh_actions_targetDate" class="actions_targetDate"><?php echo $actions_delete->targetDate->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->revisedKc->Visible) { // revisedKc ?>
		<th class="<?php echo $actions_delete->revisedKc->headerCellClass() ?>"><span id="elh_actions_revisedKc" class="actions_revisedKc"><?php echo $actions_delete->revisedKc->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->expectedSeverity->Visible) { // expectedSeverity ?>
		<th class="<?php echo $actions_delete->expectedSeverity->headerCellClass() ?>"><span id="elh_actions_expectedSeverity" class="actions_expectedSeverity"><?php echo $actions_delete->expectedSeverity->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->expectedOccurrence->Visible) { // expectedOccurrence ?>
		<th class="<?php echo $actions_delete->expectedOccurrence->headerCellClass() ?>"><span id="elh_actions_expectedOccurrence" class="actions_expectedOccurrence"><?php echo $actions_delete->expectedOccurrence->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->expectedDetection->Visible) { // expectedDetection ?>
		<th class="<?php echo $actions_delete->expectedDetection->headerCellClass() ?>"><span id="elh_actions_expectedDetection" class="actions_expectedDetection"><?php echo $actions_delete->expectedDetection->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->expectedRPNPAO->Visible) { // expectedRPNPAO ?>
		<th class="<?php echo $actions_delete->expectedRPNPAO->headerCellClass() ?>"><span id="elh_actions_expectedRPNPAO" class="actions_expectedRPNPAO"><?php echo $actions_delete->expectedRPNPAO->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->expectedClosureDate->Visible) { // expectedClosureDate ?>
		<th class="<?php echo $actions_delete->expectedClosureDate->headerCellClass() ?>"><span id="elh_actions_expectedClosureDate" class="actions_expectedClosureDate"><?php echo $actions_delete->expectedClosureDate->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->recomendedActiondet->Visible) { // recomendedActiondet ?>
		<th class="<?php echo $actions_delete->recomendedActiondet->headerCellClass() ?>"><span id="elh_actions_recomendedActiondet" class="actions_recomendedActiondet"><?php echo $actions_delete->recomendedActiondet->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->idResponsibleDet->Visible) { // idResponsibleDet ?>
		<th class="<?php echo $actions_delete->idResponsibleDet->headerCellClass() ?>"><span id="elh_actions_idResponsibleDet" class="actions_idResponsibleDet"><?php echo $actions_delete->idResponsibleDet->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->targetDatedet->Visible) { // targetDatedet ?>
		<th class="<?php echo $actions_delete->targetDatedet->headerCellClass() ?>"><span id="elh_actions_targetDatedet" class="actions_targetDatedet"><?php echo $actions_delete->targetDatedet->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->kcdet->Visible) { // kcdet ?>
		<th class="<?php echo $actions_delete->kcdet->headerCellClass() ?>"><span id="elh_actions_kcdet" class="actions_kcdet"><?php echo $actions_delete->kcdet->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->expectedSeveritydet->Visible) { // expectedSeveritydet ?>
		<th class="<?php echo $actions_delete->expectedSeveritydet->headerCellClass() ?>"><span id="elh_actions_expectedSeveritydet" class="actions_expectedSeveritydet"><?php echo $actions_delete->expectedSeveritydet->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->expectedOccurrencedet->Visible) { // expectedOccurrencedet ?>
		<th class="<?php echo $actions_delete->expectedOccurrencedet->headerCellClass() ?>"><span id="elh_actions_expectedOccurrencedet" class="actions_expectedOccurrencedet"><?php echo $actions_delete->expectedOccurrencedet->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->expectedDetectiondet->Visible) { // expectedDetectiondet ?>
		<th class="<?php echo $actions_delete->expectedDetectiondet->headerCellClass() ?>"><span id="elh_actions_expectedDetectiondet" class="actions_expectedDetectiondet"><?php echo $actions_delete->expectedDetectiondet->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->expectedRPNPAD->Visible) { // expectedRPNPAD ?>
		<th class="<?php echo $actions_delete->expectedRPNPAD->headerCellClass() ?>"><span id="elh_actions_expectedRPNPAD" class="actions_expectedRPNPAD"><?php echo $actions_delete->expectedRPNPAD->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->revisedClosureDatedet->Visible) { // revisedClosureDatedet ?>
		<th class="<?php echo $actions_delete->revisedClosureDatedet->headerCellClass() ?>"><span id="elh_actions_revisedClosureDatedet" class="actions_revisedClosureDatedet"><?php echo $actions_delete->revisedClosureDatedet->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->revisedSeverity->Visible) { // revisedSeverity ?>
		<th class="<?php echo $actions_delete->revisedSeverity->headerCellClass() ?>"><span id="elh_actions_revisedSeverity" class="actions_revisedSeverity"><?php echo $actions_delete->revisedSeverity->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->revisedOccurrence->Visible) { // revisedOccurrence ?>
		<th class="<?php echo $actions_delete->revisedOccurrence->headerCellClass() ?>"><span id="elh_actions_revisedOccurrence" class="actions_revisedOccurrence"><?php echo $actions_delete->revisedOccurrence->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->revisedDetection->Visible) { // revisedDetection ?>
		<th class="<?php echo $actions_delete->revisedDetection->headerCellClass() ?>"><span id="elh_actions_revisedDetection" class="actions_revisedDetection"><?php echo $actions_delete->revisedDetection->caption() ?></span></th>
<?php } ?>
<?php if ($actions_delete->revisedRPNCalc->Visible) { // revisedRPNCalc ?>
		<th class="<?php echo $actions_delete->revisedRPNCalc->headerCellClass() ?>"><span id="elh_actions_revisedRPNCalc" class="actions_revisedRPNCalc"><?php echo $actions_delete->revisedRPNCalc->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$actions_delete->RecordCount = 0;
$i = 0;
while (!$actions_delete->Recordset->EOF) {
	$actions_delete->RecordCount++;
	$actions_delete->RowCount++;

	// Set row properties
	$actions->resetAttributes();
	$actions->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$actions_delete->loadRowValues($actions_delete->Recordset);

	// Render row
	$actions_delete->renderRow();
?>
	<tr <?php echo $actions->rowAttributes() ?>>
<?php if ($actions_delete->idProcess->Visible) { // idProcess ?>
		<td <?php echo $actions_delete->idProcess->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_idProcess" class="actions_idProcess">
<span<?php echo $actions_delete->idProcess->viewAttributes() ?>><?php echo $actions_delete->idProcess->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->idCause->Visible) { // idCause ?>
		<td <?php echo $actions_delete->idCause->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_idCause" class="actions_idCause">
<span<?php echo $actions_delete->idCause->viewAttributes() ?>><?php echo $actions_delete->idCause->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->potentialCauses->Visible) { // potentialCauses ?>
		<td <?php echo $actions_delete->potentialCauses->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_potentialCauses" class="actions_potentialCauses">
<span<?php echo $actions_delete->potentialCauses->viewAttributes() ?>><?php echo $actions_delete->potentialCauses->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->currentPreventiveControlMethod->Visible) { // currentPreventiveControlMethod ?>
		<td <?php echo $actions_delete->currentPreventiveControlMethod->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_currentPreventiveControlMethod" class="actions_currentPreventiveControlMethod">
<span<?php echo $actions_delete->currentPreventiveControlMethod->viewAttributes() ?>><?php echo $actions_delete->currentPreventiveControlMethod->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->severity->Visible) { // severity ?>
		<td <?php echo $actions_delete->severity->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_severity" class="actions_severity">
<span<?php echo $actions_delete->severity->viewAttributes() ?>><?php echo $actions_delete->severity->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->occurrence->Visible) { // occurrence ?>
		<td <?php echo $actions_delete->occurrence->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_occurrence" class="actions_occurrence">
<span<?php echo $actions_delete->occurrence->viewAttributes() ?>><?php echo $actions_delete->occurrence->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->currentControlMethod->Visible) { // currentControlMethod ?>
		<td <?php echo $actions_delete->currentControlMethod->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_currentControlMethod" class="actions_currentControlMethod">
<span<?php echo $actions_delete->currentControlMethod->viewAttributes() ?>><?php echo $actions_delete->currentControlMethod->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->detection->Visible) { // detection ?>
		<td <?php echo $actions_delete->detection->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_detection" class="actions_detection">
<span<?php echo $actions_delete->detection->viewAttributes() ?>><?php echo $actions_delete->detection->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->RPNCalc->Visible) { // RPNCalc ?>
		<td <?php echo $actions_delete->RPNCalc->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_RPNCalc" class="actions_RPNCalc">
<span<?php echo $actions_delete->RPNCalc->viewAttributes() ?>><?php echo $actions_delete->RPNCalc->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->recomendedAction->Visible) { // recomendedAction ?>
		<td <?php echo $actions_delete->recomendedAction->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_recomendedAction" class="actions_recomendedAction">
<span<?php echo $actions_delete->recomendedAction->viewAttributes() ?>><?php echo $actions_delete->recomendedAction->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->idResponsible->Visible) { // idResponsible ?>
		<td <?php echo $actions_delete->idResponsible->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_idResponsible" class="actions_idResponsible">
<span<?php echo $actions_delete->idResponsible->viewAttributes() ?>><?php echo $actions_delete->idResponsible->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->targetDate->Visible) { // targetDate ?>
		<td <?php echo $actions_delete->targetDate->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_targetDate" class="actions_targetDate">
<span<?php echo $actions_delete->targetDate->viewAttributes() ?>><?php echo $actions_delete->targetDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->revisedKc->Visible) { // revisedKc ?>
		<td <?php echo $actions_delete->revisedKc->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_revisedKc" class="actions_revisedKc">
<span<?php echo $actions_delete->revisedKc->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_revisedKc" class="custom-control-input" value="<?php echo $actions_delete->revisedKc->getViewValue() ?>" disabled<?php if (ConvertToBool($actions_delete->revisedKc->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_revisedKc"></label></div></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->expectedSeverity->Visible) { // expectedSeverity ?>
		<td <?php echo $actions_delete->expectedSeverity->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_expectedSeverity" class="actions_expectedSeverity">
<span<?php echo $actions_delete->expectedSeverity->viewAttributes() ?>><?php echo $actions_delete->expectedSeverity->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->expectedOccurrence->Visible) { // expectedOccurrence ?>
		<td <?php echo $actions_delete->expectedOccurrence->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_expectedOccurrence" class="actions_expectedOccurrence">
<span<?php echo $actions_delete->expectedOccurrence->viewAttributes() ?>><?php echo $actions_delete->expectedOccurrence->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->expectedDetection->Visible) { // expectedDetection ?>
		<td <?php echo $actions_delete->expectedDetection->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_expectedDetection" class="actions_expectedDetection">
<span<?php echo $actions_delete->expectedDetection->viewAttributes() ?>><?php echo $actions_delete->expectedDetection->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->expectedRPNPAO->Visible) { // expectedRPNPAO ?>
		<td <?php echo $actions_delete->expectedRPNPAO->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_expectedRPNPAO" class="actions_expectedRPNPAO">
<span<?php echo $actions_delete->expectedRPNPAO->viewAttributes() ?>><?php echo $actions_delete->expectedRPNPAO->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->expectedClosureDate->Visible) { // expectedClosureDate ?>
		<td <?php echo $actions_delete->expectedClosureDate->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_expectedClosureDate" class="actions_expectedClosureDate">
<span<?php echo $actions_delete->expectedClosureDate->viewAttributes() ?>><?php echo $actions_delete->expectedClosureDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->recomendedActiondet->Visible) { // recomendedActiondet ?>
		<td <?php echo $actions_delete->recomendedActiondet->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_recomendedActiondet" class="actions_recomendedActiondet">
<span<?php echo $actions_delete->recomendedActiondet->viewAttributes() ?>><?php echo $actions_delete->recomendedActiondet->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->idResponsibleDet->Visible) { // idResponsibleDet ?>
		<td <?php echo $actions_delete->idResponsibleDet->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_idResponsibleDet" class="actions_idResponsibleDet">
<span<?php echo $actions_delete->idResponsibleDet->viewAttributes() ?>><?php echo $actions_delete->idResponsibleDet->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->targetDatedet->Visible) { // targetDatedet ?>
		<td <?php echo $actions_delete->targetDatedet->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_targetDatedet" class="actions_targetDatedet">
<span<?php echo $actions_delete->targetDatedet->viewAttributes() ?>><?php echo $actions_delete->targetDatedet->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->kcdet->Visible) { // kcdet ?>
		<td <?php echo $actions_delete->kcdet->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_kcdet" class="actions_kcdet">
<span<?php echo $actions_delete->kcdet->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_kcdet" class="custom-control-input" value="<?php echo $actions_delete->kcdet->getViewValue() ?>" disabled<?php if (ConvertToBool($actions_delete->kcdet->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_kcdet"></label></div></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->expectedSeveritydet->Visible) { // expectedSeveritydet ?>
		<td <?php echo $actions_delete->expectedSeveritydet->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_expectedSeveritydet" class="actions_expectedSeveritydet">
<span<?php echo $actions_delete->expectedSeveritydet->viewAttributes() ?>><?php echo $actions_delete->expectedSeveritydet->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->expectedOccurrencedet->Visible) { // expectedOccurrencedet ?>
		<td <?php echo $actions_delete->expectedOccurrencedet->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_expectedOccurrencedet" class="actions_expectedOccurrencedet">
<span<?php echo $actions_delete->expectedOccurrencedet->viewAttributes() ?>><?php echo $actions_delete->expectedOccurrencedet->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->expectedDetectiondet->Visible) { // expectedDetectiondet ?>
		<td <?php echo $actions_delete->expectedDetectiondet->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_expectedDetectiondet" class="actions_expectedDetectiondet">
<span<?php echo $actions_delete->expectedDetectiondet->viewAttributes() ?>><?php echo $actions_delete->expectedDetectiondet->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->expectedRPNPAD->Visible) { // expectedRPNPAD ?>
		<td <?php echo $actions_delete->expectedRPNPAD->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_expectedRPNPAD" class="actions_expectedRPNPAD">
<span<?php echo $actions_delete->expectedRPNPAD->viewAttributes() ?>><?php echo $actions_delete->expectedRPNPAD->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->revisedClosureDatedet->Visible) { // revisedClosureDatedet ?>
		<td <?php echo $actions_delete->revisedClosureDatedet->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_revisedClosureDatedet" class="actions_revisedClosureDatedet">
<span<?php echo $actions_delete->revisedClosureDatedet->viewAttributes() ?>><?php echo $actions_delete->revisedClosureDatedet->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->revisedSeverity->Visible) { // revisedSeverity ?>
		<td <?php echo $actions_delete->revisedSeverity->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_revisedSeverity" class="actions_revisedSeverity">
<span<?php echo $actions_delete->revisedSeverity->viewAttributes() ?>><?php echo $actions_delete->revisedSeverity->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->revisedOccurrence->Visible) { // revisedOccurrence ?>
		<td <?php echo $actions_delete->revisedOccurrence->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_revisedOccurrence" class="actions_revisedOccurrence">
<span<?php echo $actions_delete->revisedOccurrence->viewAttributes() ?>><?php echo $actions_delete->revisedOccurrence->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->revisedDetection->Visible) { // revisedDetection ?>
		<td <?php echo $actions_delete->revisedDetection->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_revisedDetection" class="actions_revisedDetection">
<span<?php echo $actions_delete->revisedDetection->viewAttributes() ?>><?php echo $actions_delete->revisedDetection->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($actions_delete->revisedRPNCalc->Visible) { // revisedRPNCalc ?>
		<td <?php echo $actions_delete->revisedRPNCalc->cellAttributes() ?>>
<span id="el<?php echo $actions_delete->RowCount ?>_actions_revisedRPNCalc" class="actions_revisedRPNCalc">
<span<?php echo $actions_delete->revisedRPNCalc->viewAttributes() ?>><?php echo $actions_delete->revisedRPNCalc->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$actions_delete->Recordset->moveNext();
}
$actions_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $actions_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$actions_delete->showPageFooter();
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
$actions_delete->terminate();
?>