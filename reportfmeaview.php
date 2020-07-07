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
$reportfmea_view = new reportfmea_view();

// Run the page
$reportfmea_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$reportfmea_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$reportfmea_view->isExport()) { ?>
<script>
var freportfmeaview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	freportfmeaview = currentForm = new ew.Form("freportfmeaview", "view");
	loadjs.done("freportfmeaview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$reportfmea_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $reportfmea_view->ExportOptions->render("body") ?>
<?php $reportfmea_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $reportfmea_view->showPageHeader(); ?>
<?php
$reportfmea_view->showMessage();
?>
<?php if (!$reportfmea_view->IsModal) { ?>
<?php if (!$reportfmea_view->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $reportfmea_view->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="freportfmeaview" id="freportfmeaview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="reportfmea">
<input type="hidden" name="modal" value="<?php echo (int)$reportfmea_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($reportfmea_view->fmea->Visible) { // fmea ?>
	<tr id="r_fmea">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_fmea"><?php echo $reportfmea_view->fmea->caption() ?></span></td>
		<td data-name="fmea" <?php echo $reportfmea_view->fmea->cellAttributes() ?>>
<span id="el_reportfmea_fmea">
<span<?php echo $reportfmea_view->fmea->viewAttributes() ?>><?php echo $reportfmea_view->fmea->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->idFactory->Visible) { // idFactory ?>
	<tr id="r_idFactory">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_idFactory"><?php echo $reportfmea_view->idFactory->caption() ?></span></td>
		<td data-name="idFactory" <?php echo $reportfmea_view->idFactory->cellAttributes() ?>>
<span id="el_reportfmea_idFactory">
<span<?php echo $reportfmea_view->idFactory->viewAttributes() ?>><?php echo $reportfmea_view->idFactory->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->dateFmea->Visible) { // dateFmea ?>
	<tr id="r_dateFmea">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_dateFmea"><?php echo $reportfmea_view->dateFmea->caption() ?></span></td>
		<td data-name="dateFmea" <?php echo $reportfmea_view->dateFmea->cellAttributes() ?>>
<span id="el_reportfmea_dateFmea">
<span<?php echo $reportfmea_view->dateFmea->viewAttributes() ?>><?php echo $reportfmea_view->dateFmea->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->partnumbers->Visible) { // partnumbers ?>
	<tr id="r_partnumbers">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_partnumbers"><?php echo $reportfmea_view->partnumbers->caption() ?></span></td>
		<td data-name="partnumbers" <?php echo $reportfmea_view->partnumbers->cellAttributes() ?>>
<span id="el_reportfmea_partnumbers">
<span<?php echo $reportfmea_view->partnumbers->viewAttributes() ?>><?php echo $reportfmea_view->partnumbers->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->description->Visible) { // description ?>
	<tr id="r_description">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_description"><?php echo $reportfmea_view->description->caption() ?></span></td>
		<td data-name="description" <?php echo $reportfmea_view->description->cellAttributes() ?>>
<span id="el_reportfmea_description">
<span<?php echo $reportfmea_view->description->viewAttributes() ?>><?php echo $reportfmea_view->description->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->idEmployee->Visible) { // idEmployee ?>
	<tr id="r_idEmployee">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_idEmployee"><?php echo $reportfmea_view->idEmployee->caption() ?></span></td>
		<td data-name="idEmployee" <?php echo $reportfmea_view->idEmployee->cellAttributes() ?>>
<span id="el_reportfmea_idEmployee">
<span<?php echo $reportfmea_view->idEmployee->viewAttributes() ?>><?php echo $reportfmea_view->idEmployee->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->idworkcenter->Visible) { // idworkcenter ?>
	<tr id="r_idworkcenter">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_idworkcenter"><?php echo $reportfmea_view->idworkcenter->caption() ?></span></td>
		<td data-name="idworkcenter" <?php echo $reportfmea_view->idworkcenter->cellAttributes() ?>>
<span id="el_reportfmea_idworkcenter">
<span<?php echo $reportfmea_view->idworkcenter->viewAttributes() ?>><?php echo $reportfmea_view->idworkcenter->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->idProcess->Visible) { // idProcess ?>
	<tr id="r_idProcess">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_idProcess"><?php echo $reportfmea_view->idProcess->caption() ?></span></td>
		<td data-name="idProcess" <?php echo $reportfmea_view->idProcess->cellAttributes() ?>>
<span id="el_reportfmea_idProcess">
<span<?php echo $reportfmea_view->idProcess->viewAttributes() ?>><?php echo $reportfmea_view->idProcess->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->step->Visible) { // step ?>
	<tr id="r_step">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_step"><?php echo $reportfmea_view->step->caption() ?></span></td>
		<td data-name="step" <?php echo $reportfmea_view->step->cellAttributes() ?>>
<span id="el_reportfmea_step">
<span<?php echo $reportfmea_view->step->viewAttributes() ?>><?php echo $reportfmea_view->step->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->flowchartDesc->Visible) { // flowchartDesc ?>
	<tr id="r_flowchartDesc">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_flowchartDesc"><?php echo $reportfmea_view->flowchartDesc->caption() ?></span></td>
		<td data-name="flowchartDesc" <?php echo $reportfmea_view->flowchartDesc->cellAttributes() ?>>
<span id="el_reportfmea_flowchartDesc">
<span<?php echo $reportfmea_view->flowchartDesc->viewAttributes() ?>><?php echo $reportfmea_view->flowchartDesc->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->partnumber->Visible) { // partnumber ?>
	<tr id="r_partnumber">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_partnumber"><?php echo $reportfmea_view->partnumber->caption() ?></span></td>
		<td data-name="partnumber" <?php echo $reportfmea_view->partnumber->cellAttributes() ?>>
<span id="el_reportfmea_partnumber">
<span<?php echo $reportfmea_view->partnumber->viewAttributes() ?>><?php echo $reportfmea_view->partnumber->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->operation->Visible) { // operation ?>
	<tr id="r_operation">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_operation"><?php echo $reportfmea_view->operation->caption() ?></span></td>
		<td data-name="operation" <?php echo $reportfmea_view->operation->cellAttributes() ?>>
<span id="el_reportfmea_operation">
<span<?php echo $reportfmea_view->operation->viewAttributes() ?>><?php echo $reportfmea_view->operation->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->derivedFromNC->Visible) { // derivedFromNC ?>
	<tr id="r_derivedFromNC">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_derivedFromNC"><?php echo $reportfmea_view->derivedFromNC->caption() ?></span></td>
		<td data-name="derivedFromNC" <?php echo $reportfmea_view->derivedFromNC->cellAttributes() ?>>
<span id="el_reportfmea_derivedFromNC">
<span<?php echo $reportfmea_view->derivedFromNC->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_derivedFromNC" class="custom-control-input" value="<?php echo $reportfmea_view->derivedFromNC->getViewValue() ?>" disabled<?php if (ConvertToBool($reportfmea_view->derivedFromNC->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_derivedFromNC"></label></div></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->numberOfNC->Visible) { // numberOfNC ?>
	<tr id="r_numberOfNC">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_numberOfNC"><?php echo $reportfmea_view->numberOfNC->caption() ?></span></td>
		<td data-name="numberOfNC" <?php echo $reportfmea_view->numberOfNC->cellAttributes() ?>>
<span id="el_reportfmea_numberOfNC">
<span<?php echo $reportfmea_view->numberOfNC->viewAttributes() ?>><?php echo $reportfmea_view->numberOfNC->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->flowchart->Visible) { // flowchart ?>
	<tr id="r_flowchart">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_flowchart"><?php echo $reportfmea_view->flowchart->caption() ?></span></td>
		<td data-name="flowchart" <?php echo $reportfmea_view->flowchart->cellAttributes() ?>>
<span id="el_reportfmea_flowchart">
<span<?php echo $reportfmea_view->flowchart->viewAttributes() ?>><?php echo $reportfmea_view->flowchart->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->subprocess->Visible) { // subprocess ?>
	<tr id="r_subprocess">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_subprocess"><?php echo $reportfmea_view->subprocess->caption() ?></span></td>
		<td data-name="subprocess" <?php echo $reportfmea_view->subprocess->cellAttributes() ?>>
<span id="el_reportfmea_subprocess">
<span<?php echo $reportfmea_view->subprocess->viewAttributes() ?>><?php echo $reportfmea_view->subprocess->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->requirement->Visible) { // requirement ?>
	<tr id="r_requirement">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_requirement"><?php echo $reportfmea_view->requirement->caption() ?></span></td>
		<td data-name="requirement" <?php echo $reportfmea_view->requirement->cellAttributes() ?>>
<span id="el_reportfmea_requirement">
<span<?php echo $reportfmea_view->requirement->viewAttributes() ?>><?php echo $reportfmea_view->requirement->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->potencialFailureMode->Visible) { // potencialFailureMode ?>
	<tr id="r_potencialFailureMode">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_potencialFailureMode"><?php echo $reportfmea_view->potencialFailureMode->caption() ?></span></td>
		<td data-name="potencialFailureMode" <?php echo $reportfmea_view->potencialFailureMode->cellAttributes() ?>>
<span id="el_reportfmea_potencialFailureMode">
<span<?php echo $reportfmea_view->potencialFailureMode->viewAttributes() ?>><?php echo $reportfmea_view->potencialFailureMode->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->potencialFailurEffect->Visible) { // potencialFailurEffect ?>
	<tr id="r_potencialFailurEffect">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_potencialFailurEffect"><?php echo $reportfmea_view->potencialFailurEffect->caption() ?></span></td>
		<td data-name="potencialFailurEffect" <?php echo $reportfmea_view->potencialFailurEffect->cellAttributes() ?>>
<span id="el_reportfmea_potencialFailurEffect">
<span<?php echo $reportfmea_view->potencialFailurEffect->viewAttributes() ?>><?php echo $reportfmea_view->potencialFailurEffect->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->kc->Visible) { // kc ?>
	<tr id="r_kc">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_kc"><?php echo $reportfmea_view->kc->caption() ?></span></td>
		<td data-name="kc" <?php echo $reportfmea_view->kc->cellAttributes() ?>>
<span id="el_reportfmea_kc">
<span<?php echo $reportfmea_view->kc->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_kc" class="custom-control-input" value="<?php echo $reportfmea_view->kc->getViewValue() ?>" disabled<?php if (ConvertToBool($reportfmea_view->kc->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_kc"></label></div></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->severity->Visible) { // severity ?>
	<tr id="r_severity">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_severity"><?php echo $reportfmea_view->severity->caption() ?></span></td>
		<td data-name="severity" <?php echo $reportfmea_view->severity->cellAttributes() ?>>
<span id="el_reportfmea_severity">
<span<?php echo $reportfmea_view->severity->viewAttributes() ?>><?php echo $reportfmea_view->severity->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->idCause->Visible) { // idCause ?>
	<tr id="r_idCause">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_idCause"><?php echo $reportfmea_view->idCause->caption() ?></span></td>
		<td data-name="idCause" <?php echo $reportfmea_view->idCause->cellAttributes() ?>>
<span id="el_reportfmea_idCause">
<span<?php echo $reportfmea_view->idCause->viewAttributes() ?>><?php echo $reportfmea_view->idCause->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->potentialCauses->Visible) { // potentialCauses ?>
	<tr id="r_potentialCauses">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_potentialCauses"><?php echo $reportfmea_view->potentialCauses->caption() ?></span></td>
		<td data-name="potentialCauses" <?php echo $reportfmea_view->potentialCauses->cellAttributes() ?>>
<span id="el_reportfmea_potentialCauses">
<span<?php echo $reportfmea_view->potentialCauses->viewAttributes() ?>><?php echo $reportfmea_view->potentialCauses->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->currentPreventiveControlMethod->Visible) { // currentPreventiveControlMethod ?>
	<tr id="r_currentPreventiveControlMethod">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_currentPreventiveControlMethod"><?php echo $reportfmea_view->currentPreventiveControlMethod->caption() ?></span></td>
		<td data-name="currentPreventiveControlMethod" <?php echo $reportfmea_view->currentPreventiveControlMethod->cellAttributes() ?>>
<span id="el_reportfmea_currentPreventiveControlMethod">
<span<?php echo $reportfmea_view->currentPreventiveControlMethod->viewAttributes() ?>><?php echo $reportfmea_view->currentPreventiveControlMethod->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->occurrence->Visible) { // occurrence ?>
	<tr id="r_occurrence">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_occurrence"><?php echo $reportfmea_view->occurrence->caption() ?></span></td>
		<td data-name="occurrence" <?php echo $reportfmea_view->occurrence->cellAttributes() ?>>
<span id="el_reportfmea_occurrence">
<span<?php echo $reportfmea_view->occurrence->viewAttributes() ?>><?php echo $reportfmea_view->occurrence->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->currentControlMethod->Visible) { // currentControlMethod ?>
	<tr id="r_currentControlMethod">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_currentControlMethod"><?php echo $reportfmea_view->currentControlMethod->caption() ?></span></td>
		<td data-name="currentControlMethod" <?php echo $reportfmea_view->currentControlMethod->cellAttributes() ?>>
<span id="el_reportfmea_currentControlMethod">
<span<?php echo $reportfmea_view->currentControlMethod->viewAttributes() ?>><?php echo $reportfmea_view->currentControlMethod->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->detection->Visible) { // detection ?>
	<tr id="r_detection">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_detection"><?php echo $reportfmea_view->detection->caption() ?></span></td>
		<td data-name="detection" <?php echo $reportfmea_view->detection->cellAttributes() ?>>
<span id="el_reportfmea_detection">
<span<?php echo $reportfmea_view->detection->viewAttributes() ?>><?php echo $reportfmea_view->detection->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->rpn->Visible) { // rpn ?>
	<tr id="r_rpn">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_rpn"><?php echo $reportfmea_view->rpn->caption() ?></span></td>
		<td data-name="rpn" <?php echo $reportfmea_view->rpn->cellAttributes() ?>>
<span id="el_reportfmea_rpn">
<span<?php echo $reportfmea_view->rpn->viewAttributes() ?>><?php echo $reportfmea_view->rpn->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->recomendedAction->Visible) { // recomendedAction ?>
	<tr id="r_recomendedAction">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_recomendedAction"><?php echo $reportfmea_view->recomendedAction->caption() ?></span></td>
		<td data-name="recomendedAction" <?php echo $reportfmea_view->recomendedAction->cellAttributes() ?>>
<span id="el_reportfmea_recomendedAction">
<span<?php echo $reportfmea_view->recomendedAction->viewAttributes() ?>><?php echo $reportfmea_view->recomendedAction->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->idResponsible->Visible) { // idResponsible ?>
	<tr id="r_idResponsible">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_idResponsible"><?php echo $reportfmea_view->idResponsible->caption() ?></span></td>
		<td data-name="idResponsible" <?php echo $reportfmea_view->idResponsible->cellAttributes() ?>>
<span id="el_reportfmea_idResponsible">
<span<?php echo $reportfmea_view->idResponsible->viewAttributes() ?>><?php echo $reportfmea_view->idResponsible->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->targetDate->Visible) { // targetDate ?>
	<tr id="r_targetDate">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_targetDate"><?php echo $reportfmea_view->targetDate->caption() ?></span></td>
		<td data-name="targetDate" <?php echo $reportfmea_view->targetDate->cellAttributes() ?>>
<span id="el_reportfmea_targetDate">
<span<?php echo $reportfmea_view->targetDate->viewAttributes() ?>><?php echo $reportfmea_view->targetDate->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->revisedKc->Visible) { // revisedKc ?>
	<tr id="r_revisedKc">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_revisedKc"><?php echo $reportfmea_view->revisedKc->caption() ?></span></td>
		<td data-name="revisedKc" <?php echo $reportfmea_view->revisedKc->cellAttributes() ?>>
<span id="el_reportfmea_revisedKc">
<span<?php echo $reportfmea_view->revisedKc->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_revisedKc" class="custom-control-input" value="<?php echo $reportfmea_view->revisedKc->getViewValue() ?>" disabled<?php if (ConvertToBool($reportfmea_view->revisedKc->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_revisedKc"></label></div></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->expectedSeverity->Visible) { // expectedSeverity ?>
	<tr id="r_expectedSeverity">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_expectedSeverity"><?php echo $reportfmea_view->expectedSeverity->caption() ?></span></td>
		<td data-name="expectedSeverity" <?php echo $reportfmea_view->expectedSeverity->cellAttributes() ?>>
<span id="el_reportfmea_expectedSeverity">
<span<?php echo $reportfmea_view->expectedSeverity->viewAttributes() ?>><?php echo $reportfmea_view->expectedSeverity->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->expectedOccurrence->Visible) { // expectedOccurrence ?>
	<tr id="r_expectedOccurrence">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_expectedOccurrence"><?php echo $reportfmea_view->expectedOccurrence->caption() ?></span></td>
		<td data-name="expectedOccurrence" <?php echo $reportfmea_view->expectedOccurrence->cellAttributes() ?>>
<span id="el_reportfmea_expectedOccurrence">
<span<?php echo $reportfmea_view->expectedOccurrence->viewAttributes() ?>><?php echo $reportfmea_view->expectedOccurrence->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->expectedDetection->Visible) { // expectedDetection ?>
	<tr id="r_expectedDetection">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_expectedDetection"><?php echo $reportfmea_view->expectedDetection->caption() ?></span></td>
		<td data-name="expectedDetection" <?php echo $reportfmea_view->expectedDetection->cellAttributes() ?>>
<span id="el_reportfmea_expectedDetection">
<span<?php echo $reportfmea_view->expectedDetection->viewAttributes() ?>><?php echo $reportfmea_view->expectedDetection->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->expectedRpn->Visible) { // expectedRpn ?>
	<tr id="r_expectedRpn">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_expectedRpn"><?php echo $reportfmea_view->expectedRpn->caption() ?></span></td>
		<td data-name="expectedRpn" <?php echo $reportfmea_view->expectedRpn->cellAttributes() ?>>
<span id="el_reportfmea_expectedRpn">
<span<?php echo $reportfmea_view->expectedRpn->viewAttributes() ?>><?php echo $reportfmea_view->expectedRpn->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->expectedClosureDate->Visible) { // expectedClosureDate ?>
	<tr id="r_expectedClosureDate">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_expectedClosureDate"><?php echo $reportfmea_view->expectedClosureDate->caption() ?></span></td>
		<td data-name="expectedClosureDate" <?php echo $reportfmea_view->expectedClosureDate->cellAttributes() ?>>
<span id="el_reportfmea_expectedClosureDate">
<span<?php echo $reportfmea_view->expectedClosureDate->viewAttributes() ?>><?php echo $reportfmea_view->expectedClosureDate->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->recomendedActiondet->Visible) { // recomendedActiondet ?>
	<tr id="r_recomendedActiondet">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_recomendedActiondet"><?php echo $reportfmea_view->recomendedActiondet->caption() ?></span></td>
		<td data-name="recomendedActiondet" <?php echo $reportfmea_view->recomendedActiondet->cellAttributes() ?>>
<span id="el_reportfmea_recomendedActiondet">
<span<?php echo $reportfmea_view->recomendedActiondet->viewAttributes() ?>><?php echo $reportfmea_view->recomendedActiondet->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->idResponsibleDet->Visible) { // idResponsibleDet ?>
	<tr id="r_idResponsibleDet">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_idResponsibleDet"><?php echo $reportfmea_view->idResponsibleDet->caption() ?></span></td>
		<td data-name="idResponsibleDet" <?php echo $reportfmea_view->idResponsibleDet->cellAttributes() ?>>
<span id="el_reportfmea_idResponsibleDet">
<span<?php echo $reportfmea_view->idResponsibleDet->viewAttributes() ?>><?php echo $reportfmea_view->idResponsibleDet->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->targetDatedet->Visible) { // targetDatedet ?>
	<tr id="r_targetDatedet">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_targetDatedet"><?php echo $reportfmea_view->targetDatedet->caption() ?></span></td>
		<td data-name="targetDatedet" <?php echo $reportfmea_view->targetDatedet->cellAttributes() ?>>
<span id="el_reportfmea_targetDatedet">
<span<?php echo $reportfmea_view->targetDatedet->viewAttributes() ?>><?php echo $reportfmea_view->targetDatedet->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->kcdet->Visible) { // kcdet ?>
	<tr id="r_kcdet">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_kcdet"><?php echo $reportfmea_view->kcdet->caption() ?></span></td>
		<td data-name="kcdet" <?php echo $reportfmea_view->kcdet->cellAttributes() ?>>
<span id="el_reportfmea_kcdet">
<span<?php echo $reportfmea_view->kcdet->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_kcdet" class="custom-control-input" value="<?php echo $reportfmea_view->kcdet->getViewValue() ?>" disabled<?php if (ConvertToBool($reportfmea_view->kcdet->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_kcdet"></label></div></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->expectedSeveritydet->Visible) { // expectedSeveritydet ?>
	<tr id="r_expectedSeveritydet">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_expectedSeveritydet"><?php echo $reportfmea_view->expectedSeveritydet->caption() ?></span></td>
		<td data-name="expectedSeveritydet" <?php echo $reportfmea_view->expectedSeveritydet->cellAttributes() ?>>
<span id="el_reportfmea_expectedSeveritydet">
<span<?php echo $reportfmea_view->expectedSeveritydet->viewAttributes() ?>><?php echo $reportfmea_view->expectedSeveritydet->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->expectedOccurrencedet->Visible) { // expectedOccurrencedet ?>
	<tr id="r_expectedOccurrencedet">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_expectedOccurrencedet"><?php echo $reportfmea_view->expectedOccurrencedet->caption() ?></span></td>
		<td data-name="expectedOccurrencedet" <?php echo $reportfmea_view->expectedOccurrencedet->cellAttributes() ?>>
<span id="el_reportfmea_expectedOccurrencedet">
<span<?php echo $reportfmea_view->expectedOccurrencedet->viewAttributes() ?>><?php echo $reportfmea_view->expectedOccurrencedet->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->expectedDetectiondet->Visible) { // expectedDetectiondet ?>
	<tr id="r_expectedDetectiondet">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_expectedDetectiondet"><?php echo $reportfmea_view->expectedDetectiondet->caption() ?></span></td>
		<td data-name="expectedDetectiondet" <?php echo $reportfmea_view->expectedDetectiondet->cellAttributes() ?>>
<span id="el_reportfmea_expectedDetectiondet">
<span<?php echo $reportfmea_view->expectedDetectiondet->viewAttributes() ?>><?php echo $reportfmea_view->expectedDetectiondet->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->expectedRpndet->Visible) { // expectedRpndet ?>
	<tr id="r_expectedRpndet">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_expectedRpndet"><?php echo $reportfmea_view->expectedRpndet->caption() ?></span></td>
		<td data-name="expectedRpndet" <?php echo $reportfmea_view->expectedRpndet->cellAttributes() ?>>
<span id="el_reportfmea_expectedRpndet">
<span<?php echo $reportfmea_view->expectedRpndet->viewAttributes() ?>><?php echo $reportfmea_view->expectedRpndet->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->revisedClosureDatedet->Visible) { // revisedClosureDatedet ?>
	<tr id="r_revisedClosureDatedet">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_revisedClosureDatedet"><?php echo $reportfmea_view->revisedClosureDatedet->caption() ?></span></td>
		<td data-name="revisedClosureDatedet" <?php echo $reportfmea_view->revisedClosureDatedet->cellAttributes() ?>>
<span id="el_reportfmea_revisedClosureDatedet">
<span<?php echo $reportfmea_view->revisedClosureDatedet->viewAttributes() ?>><?php echo $reportfmea_view->revisedClosureDatedet->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->revisedClosureDate->Visible) { // revisedClosureDate ?>
	<tr id="r_revisedClosureDate">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_revisedClosureDate"><?php echo $reportfmea_view->revisedClosureDate->caption() ?></span></td>
		<td data-name="revisedClosureDate" <?php echo $reportfmea_view->revisedClosureDate->cellAttributes() ?>>
<span id="el_reportfmea_revisedClosureDate">
<span<?php echo $reportfmea_view->revisedClosureDate->viewAttributes() ?>><?php echo $reportfmea_view->revisedClosureDate->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->perfomedAction->Visible) { // perfomedAction ?>
	<tr id="r_perfomedAction">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_perfomedAction"><?php echo $reportfmea_view->perfomedAction->caption() ?></span></td>
		<td data-name="perfomedAction" <?php echo $reportfmea_view->perfomedAction->cellAttributes() ?>>
<span id="el_reportfmea_perfomedAction">
<span<?php echo $reportfmea_view->perfomedAction->viewAttributes() ?>><?php echo $reportfmea_view->perfomedAction->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->revisedSeverity->Visible) { // revisedSeverity ?>
	<tr id="r_revisedSeverity">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_revisedSeverity"><?php echo $reportfmea_view->revisedSeverity->caption() ?></span></td>
		<td data-name="revisedSeverity" <?php echo $reportfmea_view->revisedSeverity->cellAttributes() ?>>
<span id="el_reportfmea_revisedSeverity">
<span<?php echo $reportfmea_view->revisedSeverity->viewAttributes() ?>><?php echo $reportfmea_view->revisedSeverity->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->revisedOccurrence->Visible) { // revisedOccurrence ?>
	<tr id="r_revisedOccurrence">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_revisedOccurrence"><?php echo $reportfmea_view->revisedOccurrence->caption() ?></span></td>
		<td data-name="revisedOccurrence" <?php echo $reportfmea_view->revisedOccurrence->cellAttributes() ?>>
<span id="el_reportfmea_revisedOccurrence">
<span<?php echo $reportfmea_view->revisedOccurrence->viewAttributes() ?>><?php echo $reportfmea_view->revisedOccurrence->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->revisedDetection->Visible) { // revisedDetection ?>
	<tr id="r_revisedDetection">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_revisedDetection"><?php echo $reportfmea_view->revisedDetection->caption() ?></span></td>
		<td data-name="revisedDetection" <?php echo $reportfmea_view->revisedDetection->cellAttributes() ?>>
<span id="el_reportfmea_revisedDetection">
<span<?php echo $reportfmea_view->revisedDetection->viewAttributes() ?>><?php echo $reportfmea_view->revisedDetection->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($reportfmea_view->revisedRpn->Visible) { // revisedRpn ?>
	<tr id="r_revisedRpn">
		<td class="<?php echo $reportfmea_view->TableLeftColumnClass ?>"><span id="elh_reportfmea_revisedRpn"><?php echo $reportfmea_view->revisedRpn->caption() ?></span></td>
		<td data-name="revisedRpn" <?php echo $reportfmea_view->revisedRpn->cellAttributes() ?>>
<span id="el_reportfmea_revisedRpn">
<span<?php echo $reportfmea_view->revisedRpn->viewAttributes() ?>><?php echo $reportfmea_view->revisedRpn->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$reportfmea_view->IsModal) { ?>
<?php if (!$reportfmea_view->isExport()) { ?>
<?php echo $reportfmea_view->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
</form>
<?php
$reportfmea_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$reportfmea_view->isExport()) { ?>
<script>
loadjs.ready("load", function() {

	// Startup script
	// Write your table-specific startup script here
	// console.log("page loaded");

});
</script>
<?php } ?>
<?php include_once "footer.php"; ?>
<?php
$reportfmea_view->terminate();
?>