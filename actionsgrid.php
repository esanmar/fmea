<?php
namespace PHPMaker2020\fmeaPRD;

// Write header
WriteHeader(FALSE);

// Create page object
if (!isset($actions_grid))
	$actions_grid = new actions_grid();

// Run the page
$actions_grid->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$actions_grid->Page_Render();
?>
<?php if (!$actions_grid->isExport()) { ?>
<script>
var factionsgrid, currentPageID;
loadjs.ready("head", function() {

	// Form object
	factionsgrid = new ew.Form("factionsgrid", "grid");
	factionsgrid.formKeyCountName = '<?php echo $actions_grid->FormKeyCountName ?>';

	// Validate form
	factionsgrid.validate = function() {
		if (!this.validateRequired)
			return true; // Ignore validation
		var $ = jQuery, fobj = this.getForm(), $fobj = $(fobj);
		if ($fobj.find("#confirm").val() == "F")
			return true;
		var elm, felm, uelm, addcnt = 0;
		var $k = $fobj.find("#" + this.formKeyCountName); // Get key_count
		var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
		var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
		var gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
		for (var i = startcnt; i <= rowcnt; i++) {
			var infix = ($k[0]) ? String(i) : "";
			$fobj.data("rowindex", infix);
			var checkrow = (gridinsert) ? !this.emptyRow(infix) : true;
			if (checkrow) {
				addcnt++;
			<?php if ($actions_grid->idProcess->Required) { ?>
				elm = this.getElements("x" + infix + "_idProcess");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->idProcess->caption(), $actions_grid->idProcess->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_idProcess");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_grid->idProcess->errorMessage()) ?>");
			<?php if ($actions_grid->idCause->Required) { ?>
				elm = this.getElements("x" + infix + "_idCause");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->idCause->caption(), $actions_grid->idCause->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_grid->potentialCauses->Required) { ?>
				elm = this.getElements("x" + infix + "_potentialCauses");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->potentialCauses->caption(), $actions_grid->potentialCauses->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_grid->currentPreventiveControlMethod->Required) { ?>
				elm = this.getElements("x" + infix + "_currentPreventiveControlMethod");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->currentPreventiveControlMethod->caption(), $actions_grid->currentPreventiveControlMethod->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_grid->severity->Required) { ?>
				elm = this.getElements("x" + infix + "_severity");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->severity->caption(), $actions_grid->severity->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_grid->occurrence->Required) { ?>
				elm = this.getElements("x" + infix + "_occurrence");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->occurrence->caption(), $actions_grid->occurrence->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_occurrence");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_grid->occurrence->errorMessage()) ?>");
			<?php if ($actions_grid->currentControlMethod->Required) { ?>
				elm = this.getElements("x" + infix + "_currentControlMethod");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->currentControlMethod->caption(), $actions_grid->currentControlMethod->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_grid->detection->Required) { ?>
				elm = this.getElements("x" + infix + "_detection");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->detection->caption(), $actions_grid->detection->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_detection");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_grid->detection->errorMessage()) ?>");
			<?php if ($actions_grid->RPNCalc->Required) { ?>
				elm = this.getElements("x" + infix + "_RPNCalc");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->RPNCalc->caption(), $actions_grid->RPNCalc->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_grid->recomendedAction->Required) { ?>
				elm = this.getElements("x" + infix + "_recomendedAction");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->recomendedAction->caption(), $actions_grid->recomendedAction->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_grid->idResponsible->Required) { ?>
				elm = this.getElements("x" + infix + "_idResponsible[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->idResponsible->caption(), $actions_grid->idResponsible->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_grid->targetDate->Required) { ?>
				elm = this.getElements("x" + infix + "_targetDate");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->targetDate->caption(), $actions_grid->targetDate->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_targetDate");
				if (elm && !ew.checkShortEuroDate(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_grid->targetDate->errorMessage()) ?>");
			<?php if ($actions_grid->revisedKc->Required) { ?>
				elm = this.getElements("x" + infix + "_revisedKc[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->revisedKc->caption(), $actions_grid->revisedKc->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_grid->expectedSeverity->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedSeverity");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->expectedSeverity->caption(), $actions_grid->expectedSeverity->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_expectedSeverity");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_grid->expectedSeverity->errorMessage()) ?>");
			<?php if ($actions_grid->expectedOccurrence->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedOccurrence");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->expectedOccurrence->caption(), $actions_grid->expectedOccurrence->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_expectedOccurrence");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_grid->expectedOccurrence->errorMessage()) ?>");
			<?php if ($actions_grid->expectedDetection->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedDetection");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->expectedDetection->caption(), $actions_grid->expectedDetection->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_expectedDetection");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_grid->expectedDetection->errorMessage()) ?>");
			<?php if ($actions_grid->expectedRPNPAO->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedRPNPAO");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->expectedRPNPAO->caption(), $actions_grid->expectedRPNPAO->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_grid->expectedClosureDate->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedClosureDate");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->expectedClosureDate->caption(), $actions_grid->expectedClosureDate->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_grid->recomendedActiondet->Required) { ?>
				elm = this.getElements("x" + infix + "_recomendedActiondet");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->recomendedActiondet->caption(), $actions_grid->recomendedActiondet->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_grid->idResponsibleDet->Required) { ?>
				elm = this.getElements("x" + infix + "_idResponsibleDet[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->idResponsibleDet->caption(), $actions_grid->idResponsibleDet->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_grid->targetDatedet->Required) { ?>
				elm = this.getElements("x" + infix + "_targetDatedet");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->targetDatedet->caption(), $actions_grid->targetDatedet->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_targetDatedet");
				if (elm && !ew.checkShortEuroDate(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_grid->targetDatedet->errorMessage()) ?>");
			<?php if ($actions_grid->kcdet->Required) { ?>
				elm = this.getElements("x" + infix + "_kcdet[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->kcdet->caption(), $actions_grid->kcdet->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_grid->expectedSeveritydet->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedSeveritydet");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->expectedSeveritydet->caption(), $actions_grid->expectedSeveritydet->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_expectedSeveritydet");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_grid->expectedSeveritydet->errorMessage()) ?>");
			<?php if ($actions_grid->expectedOccurrencedet->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedOccurrencedet");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->expectedOccurrencedet->caption(), $actions_grid->expectedOccurrencedet->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_expectedOccurrencedet");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_grid->expectedOccurrencedet->errorMessage()) ?>");
			<?php if ($actions_grid->expectedDetectiondet->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedDetectiondet");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->expectedDetectiondet->caption(), $actions_grid->expectedDetectiondet->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_expectedDetectiondet");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_grid->expectedDetectiondet->errorMessage()) ?>");
			<?php if ($actions_grid->expectedRPNPAD->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedRPNPAD");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->expectedRPNPAD->caption(), $actions_grid->expectedRPNPAD->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_grid->revisedClosureDatedet->Required) { ?>
				elm = this.getElements("x" + infix + "_revisedClosureDatedet");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->revisedClosureDatedet->caption(), $actions_grid->revisedClosureDatedet->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_revisedClosureDatedet");
				if (elm && !ew.checkShortEuroDate(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_grid->revisedClosureDatedet->errorMessage()) ?>");
			<?php if ($actions_grid->revisedSeverity->Required) { ?>
				elm = this.getElements("x" + infix + "_revisedSeverity");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->revisedSeverity->caption(), $actions_grid->revisedSeverity->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_revisedSeverity");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_grid->revisedSeverity->errorMessage()) ?>");
			<?php if ($actions_grid->revisedOccurrence->Required) { ?>
				elm = this.getElements("x" + infix + "_revisedOccurrence");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->revisedOccurrence->caption(), $actions_grid->revisedOccurrence->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_revisedOccurrence");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_grid->revisedOccurrence->errorMessage()) ?>");
			<?php if ($actions_grid->revisedDetection->Required) { ?>
				elm = this.getElements("x" + infix + "_revisedDetection");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->revisedDetection->caption(), $actions_grid->revisedDetection->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_revisedDetection");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_grid->revisedDetection->errorMessage()) ?>");
			<?php if ($actions_grid->revisedRPNCalc->Required) { ?>
				elm = this.getElements("x" + infix + "_revisedRPNCalc");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_grid->revisedRPNCalc->caption(), $actions_grid->revisedRPNCalc->RequiredErrorMessage)) ?>");
			<?php } ?>

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
			} // End Grid Add checking
		}
		return true;
	}

	// Check empty row
	factionsgrid.emptyRow = function(infix) {
		var fobj = this._form;
		if (ew.valueChanged(fobj, infix, "idProcess", false)) return false;
		if (ew.valueChanged(fobj, infix, "idCause", false)) return false;
		if (ew.valueChanged(fobj, infix, "potentialCauses", false)) return false;
		if (ew.valueChanged(fobj, infix, "currentPreventiveControlMethod", false)) return false;
		if (ew.valueChanged(fobj, infix, "severity", false)) return false;
		if (ew.valueChanged(fobj, infix, "occurrence", false)) return false;
		if (ew.valueChanged(fobj, infix, "currentControlMethod", false)) return false;
		if (ew.valueChanged(fobj, infix, "detection", false)) return false;
		if (ew.valueChanged(fobj, infix, "RPNCalc", false)) return false;
		if (ew.valueChanged(fobj, infix, "recomendedAction", false)) return false;
		if (ew.valueChanged(fobj, infix, "idResponsible[]", false)) return false;
		if (ew.valueChanged(fobj, infix, "targetDate", false)) return false;
		if (ew.valueChanged(fobj, infix, "revisedKc[]", true)) return false;
		if (ew.valueChanged(fobj, infix, "expectedSeverity", false)) return false;
		if (ew.valueChanged(fobj, infix, "expectedOccurrence", false)) return false;
		if (ew.valueChanged(fobj, infix, "expectedDetection", false)) return false;
		if (ew.valueChanged(fobj, infix, "expectedRPNPAO", false)) return false;
		if (ew.valueChanged(fobj, infix, "expectedClosureDate", false)) return false;
		if (ew.valueChanged(fobj, infix, "recomendedActiondet", false)) return false;
		if (ew.valueChanged(fobj, infix, "idResponsibleDet[]", false)) return false;
		if (ew.valueChanged(fobj, infix, "targetDatedet", false)) return false;
		if (ew.valueChanged(fobj, infix, "kcdet[]", true)) return false;
		if (ew.valueChanged(fobj, infix, "expectedSeveritydet", false)) return false;
		if (ew.valueChanged(fobj, infix, "expectedOccurrencedet", false)) return false;
		if (ew.valueChanged(fobj, infix, "expectedDetectiondet", false)) return false;
		if (ew.valueChanged(fobj, infix, "expectedRPNPAD", false)) return false;
		if (ew.valueChanged(fobj, infix, "revisedClosureDatedet", false)) return false;
		if (ew.valueChanged(fobj, infix, "revisedSeverity", false)) return false;
		if (ew.valueChanged(fobj, infix, "revisedOccurrence", false)) return false;
		if (ew.valueChanged(fobj, infix, "revisedDetection", false)) return false;
		if (ew.valueChanged(fobj, infix, "revisedRPNCalc", false)) return false;
		return true;
	}

	// Form_CustomValidate
	factionsgrid.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	factionsgrid.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	factionsgrid.lists["x_idCause"] = <?php echo $actions_grid->idCause->Lookup->toClientList($actions_grid) ?>;
	factionsgrid.lists["x_idCause"].options = <?php echo JsonEncode($actions_grid->idCause->lookupOptions()) ?>;
	factionsgrid.lists["x_idResponsible[]"] = <?php echo $actions_grid->idResponsible->Lookup->toClientList($actions_grid) ?>;
	factionsgrid.lists["x_idResponsible[]"].options = <?php echo JsonEncode($actions_grid->idResponsible->lookupOptions()) ?>;
	factionsgrid.lists["x_revisedKc[]"] = <?php echo $actions_grid->revisedKc->Lookup->toClientList($actions_grid) ?>;
	factionsgrid.lists["x_revisedKc[]"].options = <?php echo JsonEncode($actions_grid->revisedKc->options(FALSE, TRUE)) ?>;
	factionsgrid.lists["x_idResponsibleDet[]"] = <?php echo $actions_grid->idResponsibleDet->Lookup->toClientList($actions_grid) ?>;
	factionsgrid.lists["x_idResponsibleDet[]"].options = <?php echo JsonEncode($actions_grid->idResponsibleDet->lookupOptions()) ?>;
	factionsgrid.lists["x_kcdet[]"] = <?php echo $actions_grid->kcdet->Lookup->toClientList($actions_grid) ?>;
	factionsgrid.lists["x_kcdet[]"].options = <?php echo JsonEncode($actions_grid->kcdet->options(FALSE, TRUE)) ?>;
	loadjs.done("factionsgrid");
});
</script>
<?php } ?>
<?php
$actions_grid->renderOtherOptions();
?>
<?php if ($actions_grid->TotalRecords > 0 || $actions->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($actions_grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> actions">
<?php if ($actions_grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $actions_grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="factionsgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_actions" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_actionsgrid" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$actions->RowType = ROWTYPE_HEADER;

// Render list options
$actions_grid->renderListOptions();

// Render list options (header, left)
$actions_grid->ListOptions->render("header", "left");
?>
<?php if ($actions_grid->idProcess->Visible) { // idProcess ?>
	<?php if ($actions_grid->SortUrl($actions_grid->idProcess) == "") { ?>
		<th data-name="idProcess" class="<?php echo $actions_grid->idProcess->headerCellClass() ?>"><div id="elh_actions_idProcess" class="actions_idProcess"><div class="ew-table-header-caption"><?php echo $actions_grid->idProcess->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idProcess" class="<?php echo $actions_grid->idProcess->headerCellClass() ?>"><div><div id="elh_actions_idProcess" class="actions_idProcess">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->idProcess->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->idProcess->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->idProcess->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->idCause->Visible) { // idCause ?>
	<?php if ($actions_grid->SortUrl($actions_grid->idCause) == "") { ?>
		<th data-name="idCause" class="<?php echo $actions_grid->idCause->headerCellClass() ?>"><div id="elh_actions_idCause" class="actions_idCause"><div class="ew-table-header-caption"><?php echo $actions_grid->idCause->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idCause" class="<?php echo $actions_grid->idCause->headerCellClass() ?>"><div><div id="elh_actions_idCause" class="actions_idCause">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->idCause->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->idCause->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->idCause->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->potentialCauses->Visible) { // potentialCauses ?>
	<?php if ($actions_grid->SortUrl($actions_grid->potentialCauses) == "") { ?>
		<th data-name="potentialCauses" class="<?php echo $actions_grid->potentialCauses->headerCellClass() ?>"><div id="elh_actions_potentialCauses" class="actions_potentialCauses"><div class="ew-table-header-caption"><?php echo $actions_grid->potentialCauses->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="potentialCauses" class="<?php echo $actions_grid->potentialCauses->headerCellClass() ?>"><div><div id="elh_actions_potentialCauses" class="actions_potentialCauses">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->potentialCauses->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->potentialCauses->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->potentialCauses->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->currentPreventiveControlMethod->Visible) { // currentPreventiveControlMethod ?>
	<?php if ($actions_grid->SortUrl($actions_grid->currentPreventiveControlMethod) == "") { ?>
		<th data-name="currentPreventiveControlMethod" class="<?php echo $actions_grid->currentPreventiveControlMethod->headerCellClass() ?>"><div id="elh_actions_currentPreventiveControlMethod" class="actions_currentPreventiveControlMethod"><div class="ew-table-header-caption"><?php echo $actions_grid->currentPreventiveControlMethod->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="currentPreventiveControlMethod" class="<?php echo $actions_grid->currentPreventiveControlMethod->headerCellClass() ?>"><div><div id="elh_actions_currentPreventiveControlMethod" class="actions_currentPreventiveControlMethod">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->currentPreventiveControlMethod->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->currentPreventiveControlMethod->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->currentPreventiveControlMethod->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->severity->Visible) { // severity ?>
	<?php if ($actions_grid->SortUrl($actions_grid->severity) == "") { ?>
		<th data-name="severity" class="<?php echo $actions_grid->severity->headerCellClass() ?>"><div id="elh_actions_severity" class="actions_severity"><div class="ew-table-header-caption"><?php echo $actions_grid->severity->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="severity" class="<?php echo $actions_grid->severity->headerCellClass() ?>"><div><div id="elh_actions_severity" class="actions_severity">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->severity->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->severity->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->severity->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->occurrence->Visible) { // occurrence ?>
	<?php if ($actions_grid->SortUrl($actions_grid->occurrence) == "") { ?>
		<th data-name="occurrence" class="<?php echo $actions_grid->occurrence->headerCellClass() ?>"><div id="elh_actions_occurrence" class="actions_occurrence"><div class="ew-table-header-caption"><?php echo $actions_grid->occurrence->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="occurrence" class="<?php echo $actions_grid->occurrence->headerCellClass() ?>"><div><div id="elh_actions_occurrence" class="actions_occurrence">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->occurrence->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->occurrence->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->occurrence->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->currentControlMethod->Visible) { // currentControlMethod ?>
	<?php if ($actions_grid->SortUrl($actions_grid->currentControlMethod) == "") { ?>
		<th data-name="currentControlMethod" class="<?php echo $actions_grid->currentControlMethod->headerCellClass() ?>"><div id="elh_actions_currentControlMethod" class="actions_currentControlMethod"><div class="ew-table-header-caption"><?php echo $actions_grid->currentControlMethod->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="currentControlMethod" class="<?php echo $actions_grid->currentControlMethod->headerCellClass() ?>"><div><div id="elh_actions_currentControlMethod" class="actions_currentControlMethod">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->currentControlMethod->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->currentControlMethod->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->currentControlMethod->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->detection->Visible) { // detection ?>
	<?php if ($actions_grid->SortUrl($actions_grid->detection) == "") { ?>
		<th data-name="detection" class="<?php echo $actions_grid->detection->headerCellClass() ?>"><div id="elh_actions_detection" class="actions_detection"><div class="ew-table-header-caption"><?php echo $actions_grid->detection->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="detection" class="<?php echo $actions_grid->detection->headerCellClass() ?>"><div><div id="elh_actions_detection" class="actions_detection">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->detection->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->detection->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->detection->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->RPNCalc->Visible) { // RPNCalc ?>
	<?php if ($actions_grid->SortUrl($actions_grid->RPNCalc) == "") { ?>
		<th data-name="RPNCalc" class="<?php echo $actions_grid->RPNCalc->headerCellClass() ?>"><div id="elh_actions_RPNCalc" class="actions_RPNCalc"><div class="ew-table-header-caption"><?php echo $actions_grid->RPNCalc->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="RPNCalc" class="<?php echo $actions_grid->RPNCalc->headerCellClass() ?>"><div><div id="elh_actions_RPNCalc" class="actions_RPNCalc">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->RPNCalc->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->RPNCalc->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->RPNCalc->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->recomendedAction->Visible) { // recomendedAction ?>
	<?php if ($actions_grid->SortUrl($actions_grid->recomendedAction) == "") { ?>
		<th data-name="recomendedAction" class="<?php echo $actions_grid->recomendedAction->headerCellClass() ?>"><div id="elh_actions_recomendedAction" class="actions_recomendedAction"><div class="ew-table-header-caption"><?php echo $actions_grid->recomendedAction->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="recomendedAction" class="<?php echo $actions_grid->recomendedAction->headerCellClass() ?>"><div><div id="elh_actions_recomendedAction" class="actions_recomendedAction">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->recomendedAction->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->recomendedAction->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->recomendedAction->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->idResponsible->Visible) { // idResponsible ?>
	<?php if ($actions_grid->SortUrl($actions_grid->idResponsible) == "") { ?>
		<th data-name="idResponsible" class="<?php echo $actions_grid->idResponsible->headerCellClass() ?>"><div id="elh_actions_idResponsible" class="actions_idResponsible"><div class="ew-table-header-caption"><?php echo $actions_grid->idResponsible->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idResponsible" class="<?php echo $actions_grid->idResponsible->headerCellClass() ?>"><div><div id="elh_actions_idResponsible" class="actions_idResponsible">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->idResponsible->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->idResponsible->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->idResponsible->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->targetDate->Visible) { // targetDate ?>
	<?php if ($actions_grid->SortUrl($actions_grid->targetDate) == "") { ?>
		<th data-name="targetDate" class="<?php echo $actions_grid->targetDate->headerCellClass() ?>"><div id="elh_actions_targetDate" class="actions_targetDate"><div class="ew-table-header-caption"><?php echo $actions_grid->targetDate->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="targetDate" class="<?php echo $actions_grid->targetDate->headerCellClass() ?>"><div><div id="elh_actions_targetDate" class="actions_targetDate">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->targetDate->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->targetDate->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->targetDate->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->revisedKc->Visible) { // revisedKc ?>
	<?php if ($actions_grid->SortUrl($actions_grid->revisedKc) == "") { ?>
		<th data-name="revisedKc" class="<?php echo $actions_grid->revisedKc->headerCellClass() ?>"><div id="elh_actions_revisedKc" class="actions_revisedKc"><div class="ew-table-header-caption"><?php echo $actions_grid->revisedKc->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="revisedKc" class="<?php echo $actions_grid->revisedKc->headerCellClass() ?>"><div><div id="elh_actions_revisedKc" class="actions_revisedKc">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->revisedKc->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->revisedKc->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->revisedKc->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->expectedSeverity->Visible) { // expectedSeverity ?>
	<?php if ($actions_grid->SortUrl($actions_grid->expectedSeverity) == "") { ?>
		<th data-name="expectedSeverity" class="<?php echo $actions_grid->expectedSeverity->headerCellClass() ?>"><div id="elh_actions_expectedSeverity" class="actions_expectedSeverity"><div class="ew-table-header-caption"><?php echo $actions_grid->expectedSeverity->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="expectedSeverity" class="<?php echo $actions_grid->expectedSeverity->headerCellClass() ?>"><div><div id="elh_actions_expectedSeverity" class="actions_expectedSeverity">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->expectedSeverity->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->expectedSeverity->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->expectedSeverity->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->expectedOccurrence->Visible) { // expectedOccurrence ?>
	<?php if ($actions_grid->SortUrl($actions_grid->expectedOccurrence) == "") { ?>
		<th data-name="expectedOccurrence" class="<?php echo $actions_grid->expectedOccurrence->headerCellClass() ?>"><div id="elh_actions_expectedOccurrence" class="actions_expectedOccurrence"><div class="ew-table-header-caption"><?php echo $actions_grid->expectedOccurrence->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="expectedOccurrence" class="<?php echo $actions_grid->expectedOccurrence->headerCellClass() ?>"><div><div id="elh_actions_expectedOccurrence" class="actions_expectedOccurrence">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->expectedOccurrence->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->expectedOccurrence->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->expectedOccurrence->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->expectedDetection->Visible) { // expectedDetection ?>
	<?php if ($actions_grid->SortUrl($actions_grid->expectedDetection) == "") { ?>
		<th data-name="expectedDetection" class="<?php echo $actions_grid->expectedDetection->headerCellClass() ?>"><div id="elh_actions_expectedDetection" class="actions_expectedDetection"><div class="ew-table-header-caption"><?php echo $actions_grid->expectedDetection->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="expectedDetection" class="<?php echo $actions_grid->expectedDetection->headerCellClass() ?>"><div><div id="elh_actions_expectedDetection" class="actions_expectedDetection">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->expectedDetection->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->expectedDetection->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->expectedDetection->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->expectedRPNPAO->Visible) { // expectedRPNPAO ?>
	<?php if ($actions_grid->SortUrl($actions_grid->expectedRPNPAO) == "") { ?>
		<th data-name="expectedRPNPAO" class="<?php echo $actions_grid->expectedRPNPAO->headerCellClass() ?>"><div id="elh_actions_expectedRPNPAO" class="actions_expectedRPNPAO"><div class="ew-table-header-caption"><?php echo $actions_grid->expectedRPNPAO->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="expectedRPNPAO" class="<?php echo $actions_grid->expectedRPNPAO->headerCellClass() ?>"><div><div id="elh_actions_expectedRPNPAO" class="actions_expectedRPNPAO">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->expectedRPNPAO->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->expectedRPNPAO->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->expectedRPNPAO->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->expectedClosureDate->Visible) { // expectedClosureDate ?>
	<?php if ($actions_grid->SortUrl($actions_grid->expectedClosureDate) == "") { ?>
		<th data-name="expectedClosureDate" class="<?php echo $actions_grid->expectedClosureDate->headerCellClass() ?>"><div id="elh_actions_expectedClosureDate" class="actions_expectedClosureDate"><div class="ew-table-header-caption"><?php echo $actions_grid->expectedClosureDate->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="expectedClosureDate" class="<?php echo $actions_grid->expectedClosureDate->headerCellClass() ?>"><div><div id="elh_actions_expectedClosureDate" class="actions_expectedClosureDate">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->expectedClosureDate->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->expectedClosureDate->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->expectedClosureDate->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->recomendedActiondet->Visible) { // recomendedActiondet ?>
	<?php if ($actions_grid->SortUrl($actions_grid->recomendedActiondet) == "") { ?>
		<th data-name="recomendedActiondet" class="<?php echo $actions_grid->recomendedActiondet->headerCellClass() ?>"><div id="elh_actions_recomendedActiondet" class="actions_recomendedActiondet"><div class="ew-table-header-caption"><?php echo $actions_grid->recomendedActiondet->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="recomendedActiondet" class="<?php echo $actions_grid->recomendedActiondet->headerCellClass() ?>"><div><div id="elh_actions_recomendedActiondet" class="actions_recomendedActiondet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->recomendedActiondet->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->recomendedActiondet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->recomendedActiondet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->idResponsibleDet->Visible) { // idResponsibleDet ?>
	<?php if ($actions_grid->SortUrl($actions_grid->idResponsibleDet) == "") { ?>
		<th data-name="idResponsibleDet" class="<?php echo $actions_grid->idResponsibleDet->headerCellClass() ?>"><div id="elh_actions_idResponsibleDet" class="actions_idResponsibleDet"><div class="ew-table-header-caption"><?php echo $actions_grid->idResponsibleDet->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idResponsibleDet" class="<?php echo $actions_grid->idResponsibleDet->headerCellClass() ?>"><div><div id="elh_actions_idResponsibleDet" class="actions_idResponsibleDet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->idResponsibleDet->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->idResponsibleDet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->idResponsibleDet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->targetDatedet->Visible) { // targetDatedet ?>
	<?php if ($actions_grid->SortUrl($actions_grid->targetDatedet) == "") { ?>
		<th data-name="targetDatedet" class="<?php echo $actions_grid->targetDatedet->headerCellClass() ?>"><div id="elh_actions_targetDatedet" class="actions_targetDatedet"><div class="ew-table-header-caption"><?php echo $actions_grid->targetDatedet->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="targetDatedet" class="<?php echo $actions_grid->targetDatedet->headerCellClass() ?>"><div><div id="elh_actions_targetDatedet" class="actions_targetDatedet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->targetDatedet->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->targetDatedet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->targetDatedet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->kcdet->Visible) { // kcdet ?>
	<?php if ($actions_grid->SortUrl($actions_grid->kcdet) == "") { ?>
		<th data-name="kcdet" class="<?php echo $actions_grid->kcdet->headerCellClass() ?>"><div id="elh_actions_kcdet" class="actions_kcdet"><div class="ew-table-header-caption"><?php echo $actions_grid->kcdet->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kcdet" class="<?php echo $actions_grid->kcdet->headerCellClass() ?>"><div><div id="elh_actions_kcdet" class="actions_kcdet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->kcdet->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->kcdet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->kcdet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->expectedSeveritydet->Visible) { // expectedSeveritydet ?>
	<?php if ($actions_grid->SortUrl($actions_grid->expectedSeveritydet) == "") { ?>
		<th data-name="expectedSeveritydet" class="<?php echo $actions_grid->expectedSeveritydet->headerCellClass() ?>"><div id="elh_actions_expectedSeveritydet" class="actions_expectedSeveritydet"><div class="ew-table-header-caption"><?php echo $actions_grid->expectedSeveritydet->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="expectedSeveritydet" class="<?php echo $actions_grid->expectedSeveritydet->headerCellClass() ?>"><div><div id="elh_actions_expectedSeveritydet" class="actions_expectedSeveritydet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->expectedSeveritydet->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->expectedSeveritydet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->expectedSeveritydet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->expectedOccurrencedet->Visible) { // expectedOccurrencedet ?>
	<?php if ($actions_grid->SortUrl($actions_grid->expectedOccurrencedet) == "") { ?>
		<th data-name="expectedOccurrencedet" class="<?php echo $actions_grid->expectedOccurrencedet->headerCellClass() ?>"><div id="elh_actions_expectedOccurrencedet" class="actions_expectedOccurrencedet"><div class="ew-table-header-caption"><?php echo $actions_grid->expectedOccurrencedet->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="expectedOccurrencedet" class="<?php echo $actions_grid->expectedOccurrencedet->headerCellClass() ?>"><div><div id="elh_actions_expectedOccurrencedet" class="actions_expectedOccurrencedet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->expectedOccurrencedet->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->expectedOccurrencedet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->expectedOccurrencedet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->expectedDetectiondet->Visible) { // expectedDetectiondet ?>
	<?php if ($actions_grid->SortUrl($actions_grid->expectedDetectiondet) == "") { ?>
		<th data-name="expectedDetectiondet" class="<?php echo $actions_grid->expectedDetectiondet->headerCellClass() ?>"><div id="elh_actions_expectedDetectiondet" class="actions_expectedDetectiondet"><div class="ew-table-header-caption"><?php echo $actions_grid->expectedDetectiondet->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="expectedDetectiondet" class="<?php echo $actions_grid->expectedDetectiondet->headerCellClass() ?>"><div><div id="elh_actions_expectedDetectiondet" class="actions_expectedDetectiondet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->expectedDetectiondet->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->expectedDetectiondet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->expectedDetectiondet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->expectedRPNPAD->Visible) { // expectedRPNPAD ?>
	<?php if ($actions_grid->SortUrl($actions_grid->expectedRPNPAD) == "") { ?>
		<th data-name="expectedRPNPAD" class="<?php echo $actions_grid->expectedRPNPAD->headerCellClass() ?>"><div id="elh_actions_expectedRPNPAD" class="actions_expectedRPNPAD"><div class="ew-table-header-caption"><?php echo $actions_grid->expectedRPNPAD->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="expectedRPNPAD" class="<?php echo $actions_grid->expectedRPNPAD->headerCellClass() ?>"><div><div id="elh_actions_expectedRPNPAD" class="actions_expectedRPNPAD">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->expectedRPNPAD->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->expectedRPNPAD->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->expectedRPNPAD->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->revisedClosureDatedet->Visible) { // revisedClosureDatedet ?>
	<?php if ($actions_grid->SortUrl($actions_grid->revisedClosureDatedet) == "") { ?>
		<th data-name="revisedClosureDatedet" class="<?php echo $actions_grid->revisedClosureDatedet->headerCellClass() ?>"><div id="elh_actions_revisedClosureDatedet" class="actions_revisedClosureDatedet"><div class="ew-table-header-caption"><?php echo $actions_grid->revisedClosureDatedet->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="revisedClosureDatedet" class="<?php echo $actions_grid->revisedClosureDatedet->headerCellClass() ?>"><div><div id="elh_actions_revisedClosureDatedet" class="actions_revisedClosureDatedet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->revisedClosureDatedet->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->revisedClosureDatedet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->revisedClosureDatedet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->revisedSeverity->Visible) { // revisedSeverity ?>
	<?php if ($actions_grid->SortUrl($actions_grid->revisedSeverity) == "") { ?>
		<th data-name="revisedSeverity" class="<?php echo $actions_grid->revisedSeverity->headerCellClass() ?>"><div id="elh_actions_revisedSeverity" class="actions_revisedSeverity"><div class="ew-table-header-caption"><?php echo $actions_grid->revisedSeverity->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="revisedSeverity" class="<?php echo $actions_grid->revisedSeverity->headerCellClass() ?>"><div><div id="elh_actions_revisedSeverity" class="actions_revisedSeverity">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->revisedSeverity->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->revisedSeverity->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->revisedSeverity->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->revisedOccurrence->Visible) { // revisedOccurrence ?>
	<?php if ($actions_grid->SortUrl($actions_grid->revisedOccurrence) == "") { ?>
		<th data-name="revisedOccurrence" class="<?php echo $actions_grid->revisedOccurrence->headerCellClass() ?>"><div id="elh_actions_revisedOccurrence" class="actions_revisedOccurrence"><div class="ew-table-header-caption"><?php echo $actions_grid->revisedOccurrence->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="revisedOccurrence" class="<?php echo $actions_grid->revisedOccurrence->headerCellClass() ?>"><div><div id="elh_actions_revisedOccurrence" class="actions_revisedOccurrence">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->revisedOccurrence->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->revisedOccurrence->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->revisedOccurrence->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->revisedDetection->Visible) { // revisedDetection ?>
	<?php if ($actions_grid->SortUrl($actions_grid->revisedDetection) == "") { ?>
		<th data-name="revisedDetection" class="<?php echo $actions_grid->revisedDetection->headerCellClass() ?>"><div id="elh_actions_revisedDetection" class="actions_revisedDetection"><div class="ew-table-header-caption"><?php echo $actions_grid->revisedDetection->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="revisedDetection" class="<?php echo $actions_grid->revisedDetection->headerCellClass() ?>"><div><div id="elh_actions_revisedDetection" class="actions_revisedDetection">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->revisedDetection->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->revisedDetection->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->revisedDetection->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_grid->revisedRPNCalc->Visible) { // revisedRPNCalc ?>
	<?php if ($actions_grid->SortUrl($actions_grid->revisedRPNCalc) == "") { ?>
		<th data-name="revisedRPNCalc" class="<?php echo $actions_grid->revisedRPNCalc->headerCellClass() ?>"><div id="elh_actions_revisedRPNCalc" class="actions_revisedRPNCalc"><div class="ew-table-header-caption"><?php echo $actions_grid->revisedRPNCalc->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="revisedRPNCalc" class="<?php echo $actions_grid->revisedRPNCalc->headerCellClass() ?>"><div><div id="elh_actions_revisedRPNCalc" class="actions_revisedRPNCalc">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_grid->revisedRPNCalc->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_grid->revisedRPNCalc->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_grid->revisedRPNCalc->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$actions_grid->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$actions_grid->StartRecord = 1;
$actions_grid->StopRecord = $actions_grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($actions->isConfirm() || $actions_grid->EventCancelled)) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($actions_grid->FormKeyCountName) && ($actions_grid->isGridAdd() || $actions_grid->isGridEdit() || $actions->isConfirm())) {
		$actions_grid->KeyCount = $CurrentForm->getValue($actions_grid->FormKeyCountName);
		$actions_grid->StopRecord = $actions_grid->StartRecord + $actions_grid->KeyCount - 1;
	}
}
$actions_grid->RecordCount = $actions_grid->StartRecord - 1;
if ($actions_grid->Recordset && !$actions_grid->Recordset->EOF) {
	$actions_grid->Recordset->moveFirst();
	$selectLimit = $actions_grid->UseSelectLimit;
	if (!$selectLimit && $actions_grid->StartRecord > 1)
		$actions_grid->Recordset->move($actions_grid->StartRecord - 1);
} elseif (!$actions->AllowAddDeleteRow && $actions_grid->StopRecord == 0) {
	$actions_grid->StopRecord = $actions->GridAddRowCount;
}

// Initialize aggregate
$actions->RowType = ROWTYPE_AGGREGATEINIT;
$actions->resetAttributes();
$actions_grid->renderRow();
if ($actions_grid->isGridAdd())
	$actions_grid->RowIndex = 0;
if ($actions_grid->isGridEdit())
	$actions_grid->RowIndex = 0;
while ($actions_grid->RecordCount < $actions_grid->StopRecord) {
	$actions_grid->RecordCount++;
	if ($actions_grid->RecordCount >= $actions_grid->StartRecord) {
		$actions_grid->RowCount++;
		if ($actions_grid->isGridAdd() || $actions_grid->isGridEdit() || $actions->isConfirm()) {
			$actions_grid->RowIndex++;
			$CurrentForm->Index = $actions_grid->RowIndex;
			if ($CurrentForm->hasValue($actions_grid->FormActionName) && ($actions->isConfirm() || $actions_grid->EventCancelled))
				$actions_grid->RowAction = strval($CurrentForm->getValue($actions_grid->FormActionName));
			elseif ($actions_grid->isGridAdd())
				$actions_grid->RowAction = "insert";
			else
				$actions_grid->RowAction = "";
		}

		// Set up key count
		$actions_grid->KeyCount = $actions_grid->RowIndex;

		// Init row class and style
		$actions->resetAttributes();
		$actions->CssClass = "";
		if ($actions_grid->isGridAdd()) {
			if ($actions->CurrentMode == "copy") {
				$actions_grid->loadRowValues($actions_grid->Recordset); // Load row values
				$actions_grid->setRecordKey($actions_grid->RowOldKey, $actions_grid->Recordset); // Set old record key
			} else {
				$actions_grid->loadRowValues(); // Load default values
				$actions_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$actions_grid->loadRowValues($actions_grid->Recordset); // Load row values
		}
		$actions->RowType = ROWTYPE_VIEW; // Render view
		if ($actions_grid->isGridAdd()) // Grid add
			$actions->RowType = ROWTYPE_ADD; // Render add
		if ($actions_grid->isGridAdd() && $actions->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$actions_grid->restoreCurrentRowFormValues($actions_grid->RowIndex); // Restore form values
		if ($actions_grid->isGridEdit()) { // Grid edit
			if ($actions->EventCancelled)
				$actions_grid->restoreCurrentRowFormValues($actions_grid->RowIndex); // Restore form values
			if ($actions_grid->RowAction == "insert")
				$actions->RowType = ROWTYPE_ADD; // Render add
			else
				$actions->RowType = ROWTYPE_EDIT; // Render edit
			if (!$actions->EventCancelled)
				$actions_grid->HashValue = $actions_grid->getRowHash($actions_grid->Recordset); // Get hash value for record
		}
		if ($actions_grid->isGridEdit() && ($actions->RowType == ROWTYPE_EDIT || $actions->RowType == ROWTYPE_ADD) && $actions->EventCancelled) // Update failed
			$actions_grid->restoreCurrentRowFormValues($actions_grid->RowIndex); // Restore form values
		if ($actions->RowType == ROWTYPE_EDIT) // Edit row
			$actions_grid->EditRowCount++;
		if ($actions->isConfirm()) // Confirm row
			$actions_grid->restoreCurrentRowFormValues($actions_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$actions->RowAttrs->merge(["data-rowindex" => $actions_grid->RowCount, "id" => "r" . $actions_grid->RowCount . "_actions", "data-rowtype" => $actions->RowType]);

		// Render row
		$actions_grid->renderRow();

		// Render list options
		$actions_grid->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($actions_grid->RowAction != "delete" && $actions_grid->RowAction != "insertdelete" && !($actions_grid->RowAction == "insert" && $actions->isConfirm() && $actions_grid->emptyRow())) {
?>
	<tr <?php echo $actions->rowAttributes() ?>>
<?php

// Render list options (body, left)
$actions_grid->ListOptions->render("body", "left", $actions_grid->RowCount);
?>
	<?php if ($actions_grid->idProcess->Visible) { // idProcess ?>
		<td data-name="idProcess" <?php echo $actions_grid->idProcess->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($actions_grid->idProcess->getSessionValue() != "") { ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_idProcess" class="form-group">
<span<?php echo $actions_grid->idProcess->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->idProcess->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $actions_grid->RowIndex ?>_idProcess" name="x<?php echo $actions_grid->RowIndex ?>_idProcess" value="<?php echo HtmlEncode($actions_grid->idProcess->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_idProcess" class="form-group">
<input type="text" data-table="actions" data-field="x_idProcess" name="x<?php echo $actions_grid->RowIndex ?>_idProcess" id="x<?php echo $actions_grid->RowIndex ?>_idProcess" size="30" placeholder="<?php echo HtmlEncode($actions_grid->idProcess->getPlaceHolder()) ?>" value="<?php echo $actions_grid->idProcess->EditValue ?>"<?php echo $actions_grid->idProcess->editAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_idProcess" name="o<?php echo $actions_grid->RowIndex ?>_idProcess" id="o<?php echo $actions_grid->RowIndex ?>_idProcess" value="<?php echo HtmlEncode($actions_grid->idProcess->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($actions_grid->idProcess->getSessionValue() != "") { ?>

<span id="el<?php echo $actions_grid->RowCount ?>_actions_idProcess" class="form-group">
<span<?php echo $actions_grid->idProcess->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->idProcess->EditValue)) ?>"></span>
</span>

<input type="hidden" id="x<?php echo $actions_grid->RowIndex ?>_idProcess" name="x<?php echo $actions_grid->RowIndex ?>_idProcess" value="<?php echo HtmlEncode($actions_grid->idProcess->CurrentValue) ?>">
<?php } else { ?>

<input type="text" data-table="actions" data-field="x_idProcess" name="x<?php echo $actions_grid->RowIndex ?>_idProcess" id="x<?php echo $actions_grid->RowIndex ?>_idProcess" size="30" placeholder="<?php echo HtmlEncode($actions_grid->idProcess->getPlaceHolder()) ?>" value="<?php echo $actions_grid->idProcess->EditValue ?>"<?php echo $actions_grid->idProcess->editAttributes() ?>>

<?php } ?>

<input type="hidden" data-table="actions" data-field="x_idProcess" name="o<?php echo $actions_grid->RowIndex ?>_idProcess" id="o<?php echo $actions_grid->RowIndex ?>_idProcess" value="<?php echo HtmlEncode($actions_grid->idProcess->OldValue != null ? $actions_grid->idProcess->OldValue : $actions_grid->idProcess->CurrentValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_idProcess">
<span<?php echo $actions_grid->idProcess->viewAttributes() ?>><?php echo $actions_grid->idProcess->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_idProcess" name="x<?php echo $actions_grid->RowIndex ?>_idProcess" id="x<?php echo $actions_grid->RowIndex ?>_idProcess" value="<?php echo HtmlEncode($actions_grid->idProcess->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_idProcess" name="o<?php echo $actions_grid->RowIndex ?>_idProcess" id="o<?php echo $actions_grid->RowIndex ?>_idProcess" value="<?php echo HtmlEncode($actions_grid->idProcess->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_idProcess" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_idProcess" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_idProcess" value="<?php echo HtmlEncode($actions_grid->idProcess->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_idProcess" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_idProcess" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_idProcess" value="<?php echo HtmlEncode($actions_grid->idProcess->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->idCause->Visible) { // idCause ?>
		<td data-name="idCause" <?php echo $actions_grid->idCause->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_idCause" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="actions" data-field="x_idCause" data-value-separator="<?php echo $actions_grid->idCause->displayValueSeparatorAttribute() ?>" id="x<?php echo $actions_grid->RowIndex ?>_idCause" name="x<?php echo $actions_grid->RowIndex ?>_idCause"<?php echo $actions_grid->idCause->editAttributes() ?>>
			<?php echo $actions_grid->idCause->selectOptionListHtml("x{$actions_grid->RowIndex}_idCause") ?>
		</select>
</div>
<?php echo $actions_grid->idCause->Lookup->getParamTag($actions_grid, "p_x" . $actions_grid->RowIndex . "_idCause") ?>
</span>
<input type="hidden" data-table="actions" data-field="x_idCause" name="o<?php echo $actions_grid->RowIndex ?>_idCause" id="o<?php echo $actions_grid->RowIndex ?>_idCause" value="<?php echo HtmlEncode($actions_grid->idCause->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="actions" data-field="x_idCause" data-value-separator="<?php echo $actions_grid->idCause->displayValueSeparatorAttribute() ?>" id="x<?php echo $actions_grid->RowIndex ?>_idCause" name="x<?php echo $actions_grid->RowIndex ?>_idCause"<?php echo $actions_grid->idCause->editAttributes() ?>>
			<?php echo $actions_grid->idCause->selectOptionListHtml("x{$actions_grid->RowIndex}_idCause") ?>
		</select>
</div>
<?php echo $actions_grid->idCause->Lookup->getParamTag($actions_grid, "p_x" . $actions_grid->RowIndex . "_idCause") ?>
<input type="hidden" data-table="actions" data-field="x_idCause" name="o<?php echo $actions_grid->RowIndex ?>_idCause" id="o<?php echo $actions_grid->RowIndex ?>_idCause" value="<?php echo HtmlEncode($actions_grid->idCause->OldValue != null ? $actions_grid->idCause->OldValue : $actions_grid->idCause->CurrentValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_idCause">
<span<?php echo $actions_grid->idCause->viewAttributes() ?>><?php echo $actions_grid->idCause->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_idCause" name="x<?php echo $actions_grid->RowIndex ?>_idCause" id="x<?php echo $actions_grid->RowIndex ?>_idCause" value="<?php echo HtmlEncode($actions_grid->idCause->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_idCause" name="o<?php echo $actions_grid->RowIndex ?>_idCause" id="o<?php echo $actions_grid->RowIndex ?>_idCause" value="<?php echo HtmlEncode($actions_grid->idCause->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_idCause" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_idCause" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_idCause" value="<?php echo HtmlEncode($actions_grid->idCause->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_idCause" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_idCause" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_idCause" value="<?php echo HtmlEncode($actions_grid->idCause->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->potentialCauses->Visible) { // potentialCauses ?>
		<td data-name="potentialCauses" <?php echo $actions_grid->potentialCauses->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_potentialCauses" class="form-group">
<textarea data-table="actions" data-field="x_potentialCauses" name="x<?php echo $actions_grid->RowIndex ?>_potentialCauses" id="x<?php echo $actions_grid->RowIndex ?>_potentialCauses" cols="35" rows="4" placeholder="<?php echo HtmlEncode($actions_grid->potentialCauses->getPlaceHolder()) ?>"<?php echo $actions_grid->potentialCauses->editAttributes() ?>><?php echo $actions_grid->potentialCauses->EditValue ?></textarea>
</span>
<input type="hidden" data-table="actions" data-field="x_potentialCauses" name="o<?php echo $actions_grid->RowIndex ?>_potentialCauses" id="o<?php echo $actions_grid->RowIndex ?>_potentialCauses" value="<?php echo HtmlEncode($actions_grid->potentialCauses->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_potentialCauses" class="form-group">
<textarea data-table="actions" data-field="x_potentialCauses" name="x<?php echo $actions_grid->RowIndex ?>_potentialCauses" id="x<?php echo $actions_grid->RowIndex ?>_potentialCauses" cols="35" rows="4" placeholder="<?php echo HtmlEncode($actions_grid->potentialCauses->getPlaceHolder()) ?>"<?php echo $actions_grid->potentialCauses->editAttributes() ?>><?php echo $actions_grid->potentialCauses->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_potentialCauses">
<span<?php echo $actions_grid->potentialCauses->viewAttributes() ?>><?php echo $actions_grid->potentialCauses->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_potentialCauses" name="x<?php echo $actions_grid->RowIndex ?>_potentialCauses" id="x<?php echo $actions_grid->RowIndex ?>_potentialCauses" value="<?php echo HtmlEncode($actions_grid->potentialCauses->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_potentialCauses" name="o<?php echo $actions_grid->RowIndex ?>_potentialCauses" id="o<?php echo $actions_grid->RowIndex ?>_potentialCauses" value="<?php echo HtmlEncode($actions_grid->potentialCauses->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_potentialCauses" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_potentialCauses" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_potentialCauses" value="<?php echo HtmlEncode($actions_grid->potentialCauses->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_potentialCauses" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_potentialCauses" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_potentialCauses" value="<?php echo HtmlEncode($actions_grid->potentialCauses->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->currentPreventiveControlMethod->Visible) { // currentPreventiveControlMethod ?>
		<td data-name="currentPreventiveControlMethod" <?php echo $actions_grid->currentPreventiveControlMethod->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_currentPreventiveControlMethod" class="form-group">
<input type="text" data-table="actions" data-field="x_currentPreventiveControlMethod" name="x<?php echo $actions_grid->RowIndex ?>_currentPreventiveControlMethod" id="x<?php echo $actions_grid->RowIndex ?>_currentPreventiveControlMethod" size="7" maxlength="255" placeholder="<?php echo HtmlEncode($actions_grid->currentPreventiveControlMethod->getPlaceHolder()) ?>" value="<?php echo $actions_grid->currentPreventiveControlMethod->EditValue ?>"<?php echo $actions_grid->currentPreventiveControlMethod->editAttributes() ?>>
</span>
<input type="hidden" data-table="actions" data-field="x_currentPreventiveControlMethod" name="o<?php echo $actions_grid->RowIndex ?>_currentPreventiveControlMethod" id="o<?php echo $actions_grid->RowIndex ?>_currentPreventiveControlMethod" value="<?php echo HtmlEncode($actions_grid->currentPreventiveControlMethod->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_currentPreventiveControlMethod" class="form-group">
<input type="text" data-table="actions" data-field="x_currentPreventiveControlMethod" name="x<?php echo $actions_grid->RowIndex ?>_currentPreventiveControlMethod" id="x<?php echo $actions_grid->RowIndex ?>_currentPreventiveControlMethod" size="7" maxlength="255" placeholder="<?php echo HtmlEncode($actions_grid->currentPreventiveControlMethod->getPlaceHolder()) ?>" value="<?php echo $actions_grid->currentPreventiveControlMethod->EditValue ?>"<?php echo $actions_grid->currentPreventiveControlMethod->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_currentPreventiveControlMethod">
<span<?php echo $actions_grid->currentPreventiveControlMethod->viewAttributes() ?>><?php echo $actions_grid->currentPreventiveControlMethod->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_currentPreventiveControlMethod" name="x<?php echo $actions_grid->RowIndex ?>_currentPreventiveControlMethod" id="x<?php echo $actions_grid->RowIndex ?>_currentPreventiveControlMethod" value="<?php echo HtmlEncode($actions_grid->currentPreventiveControlMethod->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_currentPreventiveControlMethod" name="o<?php echo $actions_grid->RowIndex ?>_currentPreventiveControlMethod" id="o<?php echo $actions_grid->RowIndex ?>_currentPreventiveControlMethod" value="<?php echo HtmlEncode($actions_grid->currentPreventiveControlMethod->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_currentPreventiveControlMethod" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_currentPreventiveControlMethod" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_currentPreventiveControlMethod" value="<?php echo HtmlEncode($actions_grid->currentPreventiveControlMethod->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_currentPreventiveControlMethod" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_currentPreventiveControlMethod" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_currentPreventiveControlMethod" value="<?php echo HtmlEncode($actions_grid->currentPreventiveControlMethod->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->severity->Visible) { // severity ?>
		<td data-name="severity" <?php echo $actions_grid->severity->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_severity" class="form-group">
<input type="text" data-table="actions" data-field="x_severity" name="x<?php echo $actions_grid->RowIndex ?>_severity" id="x<?php echo $actions_grid->RowIndex ?>_severity" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($actions_grid->severity->getPlaceHolder()) ?>" value="<?php echo $actions_grid->severity->EditValue ?>"<?php echo $actions_grid->severity->editAttributes() ?>>
</span>
<input type="hidden" data-table="actions" data-field="x_severity" name="o<?php echo $actions_grid->RowIndex ?>_severity" id="o<?php echo $actions_grid->RowIndex ?>_severity" value="<?php echo HtmlEncode($actions_grid->severity->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_severity" class="form-group">
<input type="hidden" data-table="actions" data-field="x_severity" name="x<?php echo $actions_grid->RowIndex ?>_severity" id="x<?php echo $actions_grid->RowIndex ?>_severity" value="<?php echo HtmlEncode($actions_grid->severity->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_severity">
<span<?php echo $actions_grid->severity->viewAttributes() ?>><?php echo $actions_grid->severity->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_severity" name="x<?php echo $actions_grid->RowIndex ?>_severity" id="x<?php echo $actions_grid->RowIndex ?>_severity" value="<?php echo HtmlEncode($actions_grid->severity->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_severity" name="o<?php echo $actions_grid->RowIndex ?>_severity" id="o<?php echo $actions_grid->RowIndex ?>_severity" value="<?php echo HtmlEncode($actions_grid->severity->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_severity" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_severity" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_severity" value="<?php echo HtmlEncode($actions_grid->severity->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_severity" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_severity" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_severity" value="<?php echo HtmlEncode($actions_grid->severity->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->occurrence->Visible) { // occurrence ?>
		<td data-name="occurrence" <?php echo $actions_grid->occurrence->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_occurrence" class="form-group">
<input type="text" data-table="actions" data-field="x_occurrence" name="x<?php echo $actions_grid->RowIndex ?>_occurrence" id="x<?php echo $actions_grid->RowIndex ?>_occurrence" size="3" placeholder="<?php echo HtmlEncode($actions_grid->occurrence->getPlaceHolder()) ?>" value="<?php echo $actions_grid->occurrence->EditValue ?>"<?php echo $actions_grid->occurrence->editAttributes() ?>>
</span>
<input type="hidden" data-table="actions" data-field="x_occurrence" name="o<?php echo $actions_grid->RowIndex ?>_occurrence" id="o<?php echo $actions_grid->RowIndex ?>_occurrence" value="<?php echo HtmlEncode($actions_grid->occurrence->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_occurrence" class="form-group">
<input type="text" data-table="actions" data-field="x_occurrence" name="x<?php echo $actions_grid->RowIndex ?>_occurrence" id="x<?php echo $actions_grid->RowIndex ?>_occurrence" size="3" placeholder="<?php echo HtmlEncode($actions_grid->occurrence->getPlaceHolder()) ?>" value="<?php echo $actions_grid->occurrence->EditValue ?>"<?php echo $actions_grid->occurrence->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_occurrence">
<span<?php echo $actions_grid->occurrence->viewAttributes() ?>><?php echo $actions_grid->occurrence->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_occurrence" name="x<?php echo $actions_grid->RowIndex ?>_occurrence" id="x<?php echo $actions_grid->RowIndex ?>_occurrence" value="<?php echo HtmlEncode($actions_grid->occurrence->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_occurrence" name="o<?php echo $actions_grid->RowIndex ?>_occurrence" id="o<?php echo $actions_grid->RowIndex ?>_occurrence" value="<?php echo HtmlEncode($actions_grid->occurrence->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_occurrence" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_occurrence" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_occurrence" value="<?php echo HtmlEncode($actions_grid->occurrence->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_occurrence" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_occurrence" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_occurrence" value="<?php echo HtmlEncode($actions_grid->occurrence->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->currentControlMethod->Visible) { // currentControlMethod ?>
		<td data-name="currentControlMethod" <?php echo $actions_grid->currentControlMethod->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_currentControlMethod" class="form-group">
<input type="text" data-table="actions" data-field="x_currentControlMethod" name="x<?php echo $actions_grid->RowIndex ?>_currentControlMethod" id="x<?php echo $actions_grid->RowIndex ?>_currentControlMethod" size="10" maxlength="255" placeholder="<?php echo HtmlEncode($actions_grid->currentControlMethod->getPlaceHolder()) ?>" value="<?php echo $actions_grid->currentControlMethod->EditValue ?>"<?php echo $actions_grid->currentControlMethod->editAttributes() ?>>
</span>
<input type="hidden" data-table="actions" data-field="x_currentControlMethod" name="o<?php echo $actions_grid->RowIndex ?>_currentControlMethod" id="o<?php echo $actions_grid->RowIndex ?>_currentControlMethod" value="<?php echo HtmlEncode($actions_grid->currentControlMethod->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_currentControlMethod" class="form-group">
<input type="text" data-table="actions" data-field="x_currentControlMethod" name="x<?php echo $actions_grid->RowIndex ?>_currentControlMethod" id="x<?php echo $actions_grid->RowIndex ?>_currentControlMethod" size="10" maxlength="255" placeholder="<?php echo HtmlEncode($actions_grid->currentControlMethod->getPlaceHolder()) ?>" value="<?php echo $actions_grid->currentControlMethod->EditValue ?>"<?php echo $actions_grid->currentControlMethod->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_currentControlMethod">
<span<?php echo $actions_grid->currentControlMethod->viewAttributes() ?>><?php echo $actions_grid->currentControlMethod->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_currentControlMethod" name="x<?php echo $actions_grid->RowIndex ?>_currentControlMethod" id="x<?php echo $actions_grid->RowIndex ?>_currentControlMethod" value="<?php echo HtmlEncode($actions_grid->currentControlMethod->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_currentControlMethod" name="o<?php echo $actions_grid->RowIndex ?>_currentControlMethod" id="o<?php echo $actions_grid->RowIndex ?>_currentControlMethod" value="<?php echo HtmlEncode($actions_grid->currentControlMethod->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_currentControlMethod" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_currentControlMethod" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_currentControlMethod" value="<?php echo HtmlEncode($actions_grid->currentControlMethod->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_currentControlMethod" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_currentControlMethod" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_currentControlMethod" value="<?php echo HtmlEncode($actions_grid->currentControlMethod->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->detection->Visible) { // detection ?>
		<td data-name="detection" <?php echo $actions_grid->detection->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_detection" class="form-group">
<input type="text" data-table="actions" data-field="x_detection" name="x<?php echo $actions_grid->RowIndex ?>_detection" id="x<?php echo $actions_grid->RowIndex ?>_detection" size="3" placeholder="<?php echo HtmlEncode($actions_grid->detection->getPlaceHolder()) ?>" value="<?php echo $actions_grid->detection->EditValue ?>"<?php echo $actions_grid->detection->editAttributes() ?>>
</span>
<input type="hidden" data-table="actions" data-field="x_detection" name="o<?php echo $actions_grid->RowIndex ?>_detection" id="o<?php echo $actions_grid->RowIndex ?>_detection" value="<?php echo HtmlEncode($actions_grid->detection->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_detection" class="form-group">
<input type="text" data-table="actions" data-field="x_detection" name="x<?php echo $actions_grid->RowIndex ?>_detection" id="x<?php echo $actions_grid->RowIndex ?>_detection" size="3" placeholder="<?php echo HtmlEncode($actions_grid->detection->getPlaceHolder()) ?>" value="<?php echo $actions_grid->detection->EditValue ?>"<?php echo $actions_grid->detection->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_detection">
<span<?php echo $actions_grid->detection->viewAttributes() ?>><?php echo $actions_grid->detection->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_detection" name="x<?php echo $actions_grid->RowIndex ?>_detection" id="x<?php echo $actions_grid->RowIndex ?>_detection" value="<?php echo HtmlEncode($actions_grid->detection->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_detection" name="o<?php echo $actions_grid->RowIndex ?>_detection" id="o<?php echo $actions_grid->RowIndex ?>_detection" value="<?php echo HtmlEncode($actions_grid->detection->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_detection" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_detection" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_detection" value="<?php echo HtmlEncode($actions_grid->detection->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_detection" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_detection" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_detection" value="<?php echo HtmlEncode($actions_grid->detection->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->RPNCalc->Visible) { // RPNCalc ?>
		<td data-name="RPNCalc" <?php echo $actions_grid->RPNCalc->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_RPNCalc" class="form-group">
<input type="text" data-table="actions" data-field="x_RPNCalc" name="x<?php echo $actions_grid->RowIndex ?>_RPNCalc" id="x<?php echo $actions_grid->RowIndex ?>_RPNCalc" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_grid->RPNCalc->getPlaceHolder()) ?>" value="<?php echo $actions_grid->RPNCalc->EditValue ?>"<?php echo $actions_grid->RPNCalc->editAttributes() ?>>
</span>
<input type="hidden" data-table="actions" data-field="x_RPNCalc" name="o<?php echo $actions_grid->RowIndex ?>_RPNCalc" id="o<?php echo $actions_grid->RowIndex ?>_RPNCalc" value="<?php echo HtmlEncode($actions_grid->RPNCalc->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_RPNCalc" class="form-group">
<span<?php echo $actions_grid->RPNCalc->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->RPNCalc->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_RPNCalc" name="x<?php echo $actions_grid->RowIndex ?>_RPNCalc" id="x<?php echo $actions_grid->RowIndex ?>_RPNCalc" value="<?php echo HtmlEncode($actions_grid->RPNCalc->CurrentValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_RPNCalc">
<span<?php echo $actions_grid->RPNCalc->viewAttributes() ?>><?php echo $actions_grid->RPNCalc->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_RPNCalc" name="x<?php echo $actions_grid->RowIndex ?>_RPNCalc" id="x<?php echo $actions_grid->RowIndex ?>_RPNCalc" value="<?php echo HtmlEncode($actions_grid->RPNCalc->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_RPNCalc" name="o<?php echo $actions_grid->RowIndex ?>_RPNCalc" id="o<?php echo $actions_grid->RowIndex ?>_RPNCalc" value="<?php echo HtmlEncode($actions_grid->RPNCalc->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_RPNCalc" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_RPNCalc" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_RPNCalc" value="<?php echo HtmlEncode($actions_grid->RPNCalc->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_RPNCalc" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_RPNCalc" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_RPNCalc" value="<?php echo HtmlEncode($actions_grid->RPNCalc->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->recomendedAction->Visible) { // recomendedAction ?>
		<td data-name="recomendedAction" <?php echo $actions_grid->recomendedAction->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_recomendedAction" class="form-group">
<textarea data-table="actions" data-field="x_recomendedAction" name="x<?php echo $actions_grid->RowIndex ?>_recomendedAction" id="x<?php echo $actions_grid->RowIndex ?>_recomendedAction" cols="10" rows="4" placeholder="<?php echo HtmlEncode($actions_grid->recomendedAction->getPlaceHolder()) ?>"<?php echo $actions_grid->recomendedAction->editAttributes() ?>><?php echo $actions_grid->recomendedAction->EditValue ?></textarea>
</span>
<input type="hidden" data-table="actions" data-field="x_recomendedAction" name="o<?php echo $actions_grid->RowIndex ?>_recomendedAction" id="o<?php echo $actions_grid->RowIndex ?>_recomendedAction" value="<?php echo HtmlEncode($actions_grid->recomendedAction->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_recomendedAction" class="form-group">
<textarea data-table="actions" data-field="x_recomendedAction" name="x<?php echo $actions_grid->RowIndex ?>_recomendedAction" id="x<?php echo $actions_grid->RowIndex ?>_recomendedAction" cols="10" rows="4" placeholder="<?php echo HtmlEncode($actions_grid->recomendedAction->getPlaceHolder()) ?>"<?php echo $actions_grid->recomendedAction->editAttributes() ?>><?php echo $actions_grid->recomendedAction->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_recomendedAction">
<span<?php echo $actions_grid->recomendedAction->viewAttributes() ?>><?php echo $actions_grid->recomendedAction->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_recomendedAction" name="x<?php echo $actions_grid->RowIndex ?>_recomendedAction" id="x<?php echo $actions_grid->RowIndex ?>_recomendedAction" value="<?php echo HtmlEncode($actions_grid->recomendedAction->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_recomendedAction" name="o<?php echo $actions_grid->RowIndex ?>_recomendedAction" id="o<?php echo $actions_grid->RowIndex ?>_recomendedAction" value="<?php echo HtmlEncode($actions_grid->recomendedAction->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_recomendedAction" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_recomendedAction" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_recomendedAction" value="<?php echo HtmlEncode($actions_grid->recomendedAction->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_recomendedAction" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_recomendedAction" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_recomendedAction" value="<?php echo HtmlEncode($actions_grid->recomendedAction->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->idResponsible->Visible) { // idResponsible ?>
		<td data-name="idResponsible" <?php echo $actions_grid->idResponsible->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_idResponsible" class="form-group">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $actions_grid->RowIndex ?>_idResponsible"><?php echo EmptyValue(strval($actions_grid->idResponsible->ViewValue)) ? $Language->phrase("PleaseSelect") : $actions_grid->idResponsible->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($actions_grid->idResponsible->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($actions_grid->idResponsible->ReadOnly || $actions_grid->idResponsible->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $actions_grid->RowIndex ?>_idResponsible[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $actions_grid->idResponsible->Lookup->getParamTag($actions_grid, "p_x" . $actions_grid->RowIndex . "_idResponsible") ?>
<input type="hidden" data-table="actions" data-field="x_idResponsible" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $actions_grid->idResponsible->displayValueSeparatorAttribute() ?>" name="x<?php echo $actions_grid->RowIndex ?>_idResponsible[]" id="x<?php echo $actions_grid->RowIndex ?>_idResponsible[]" value="<?php echo $actions_grid->idResponsible->CurrentValue ?>"<?php echo $actions_grid->idResponsible->editAttributes() ?>>
</span>
<input type="hidden" data-table="actions" data-field="x_idResponsible" name="o<?php echo $actions_grid->RowIndex ?>_idResponsible[]" id="o<?php echo $actions_grid->RowIndex ?>_idResponsible[]" value="<?php echo HtmlEncode($actions_grid->idResponsible->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_idResponsible" class="form-group">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $actions_grid->RowIndex ?>_idResponsible"><?php echo EmptyValue(strval($actions_grid->idResponsible->ViewValue)) ? $Language->phrase("PleaseSelect") : $actions_grid->idResponsible->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($actions_grid->idResponsible->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($actions_grid->idResponsible->ReadOnly || $actions_grid->idResponsible->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $actions_grid->RowIndex ?>_idResponsible[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $actions_grid->idResponsible->Lookup->getParamTag($actions_grid, "p_x" . $actions_grid->RowIndex . "_idResponsible") ?>
<input type="hidden" data-table="actions" data-field="x_idResponsible" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $actions_grid->idResponsible->displayValueSeparatorAttribute() ?>" name="x<?php echo $actions_grid->RowIndex ?>_idResponsible[]" id="x<?php echo $actions_grid->RowIndex ?>_idResponsible[]" value="<?php echo $actions_grid->idResponsible->CurrentValue ?>"<?php echo $actions_grid->idResponsible->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_idResponsible">
<span<?php echo $actions_grid->idResponsible->viewAttributes() ?>><?php echo $actions_grid->idResponsible->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_idResponsible" name="x<?php echo $actions_grid->RowIndex ?>_idResponsible" id="x<?php echo $actions_grid->RowIndex ?>_idResponsible" value="<?php echo HtmlEncode($actions_grid->idResponsible->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_idResponsible" name="o<?php echo $actions_grid->RowIndex ?>_idResponsible[]" id="o<?php echo $actions_grid->RowIndex ?>_idResponsible[]" value="<?php echo HtmlEncode($actions_grid->idResponsible->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_idResponsible" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_idResponsible" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_idResponsible" value="<?php echo HtmlEncode($actions_grid->idResponsible->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_idResponsible" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_idResponsible[]" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_idResponsible[]" value="<?php echo HtmlEncode($actions_grid->idResponsible->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->targetDate->Visible) { // targetDate ?>
		<td data-name="targetDate" <?php echo $actions_grid->targetDate->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_targetDate" class="form-group">
<input type="text" data-table="actions" data-field="x_targetDate" data-format="14" name="x<?php echo $actions_grid->RowIndex ?>_targetDate" id="x<?php echo $actions_grid->RowIndex ?>_targetDate" size="7" placeholder="<?php echo HtmlEncode($actions_grid->targetDate->getPlaceHolder()) ?>" value="<?php echo $actions_grid->targetDate->EditValue ?>"<?php echo $actions_grid->targetDate->editAttributes() ?>>
<?php if (!$actions_grid->targetDate->ReadOnly && !$actions_grid->targetDate->Disabled && !isset($actions_grid->targetDate->EditAttrs["readonly"]) && !isset($actions_grid->targetDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["factionsgrid", "datetimepicker"], function() {
	ew.createDateTimePicker("factionsgrid", "x<?php echo $actions_grid->RowIndex ?>_targetDate", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="actions" data-field="x_targetDate" name="o<?php echo $actions_grid->RowIndex ?>_targetDate" id="o<?php echo $actions_grid->RowIndex ?>_targetDate" value="<?php echo HtmlEncode($actions_grid->targetDate->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_targetDate" class="form-group">
<input type="text" data-table="actions" data-field="x_targetDate" data-format="14" name="x<?php echo $actions_grid->RowIndex ?>_targetDate" id="x<?php echo $actions_grid->RowIndex ?>_targetDate" size="7" placeholder="<?php echo HtmlEncode($actions_grid->targetDate->getPlaceHolder()) ?>" value="<?php echo $actions_grid->targetDate->EditValue ?>"<?php echo $actions_grid->targetDate->editAttributes() ?>>
<?php if (!$actions_grid->targetDate->ReadOnly && !$actions_grid->targetDate->Disabled && !isset($actions_grid->targetDate->EditAttrs["readonly"]) && !isset($actions_grid->targetDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["factionsgrid", "datetimepicker"], function() {
	ew.createDateTimePicker("factionsgrid", "x<?php echo $actions_grid->RowIndex ?>_targetDate", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_targetDate">
<span<?php echo $actions_grid->targetDate->viewAttributes() ?>><?php echo $actions_grid->targetDate->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_targetDate" name="x<?php echo $actions_grid->RowIndex ?>_targetDate" id="x<?php echo $actions_grid->RowIndex ?>_targetDate" value="<?php echo HtmlEncode($actions_grid->targetDate->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_targetDate" name="o<?php echo $actions_grid->RowIndex ?>_targetDate" id="o<?php echo $actions_grid->RowIndex ?>_targetDate" value="<?php echo HtmlEncode($actions_grid->targetDate->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_targetDate" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_targetDate" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_targetDate" value="<?php echo HtmlEncode($actions_grid->targetDate->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_targetDate" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_targetDate" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_targetDate" value="<?php echo HtmlEncode($actions_grid->targetDate->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->revisedKc->Visible) { // revisedKc ?>
		<td data-name="revisedKc" <?php echo $actions_grid->revisedKc->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_revisedKc" class="form-group">
<?php
$selwrk = ConvertToBool($actions_grid->revisedKc->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="actions" data-field="x_revisedKc" name="x<?php echo $actions_grid->RowIndex ?>_revisedKc[]" id="x<?php echo $actions_grid->RowIndex ?>_revisedKc[]" value="1"<?php echo $selwrk ?><?php echo $actions_grid->revisedKc->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $actions_grid->RowIndex ?>_revisedKc[]"></label>
</div>
</span>
<input type="hidden" data-table="actions" data-field="x_revisedKc" name="o<?php echo $actions_grid->RowIndex ?>_revisedKc[]" id="o<?php echo $actions_grid->RowIndex ?>_revisedKc[]" value="<?php echo HtmlEncode($actions_grid->revisedKc->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_revisedKc" class="form-group">
<?php
$selwrk = ConvertToBool($actions_grid->revisedKc->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="actions" data-field="x_revisedKc" name="x<?php echo $actions_grid->RowIndex ?>_revisedKc[]" id="x<?php echo $actions_grid->RowIndex ?>_revisedKc[]" value="1"<?php echo $selwrk ?><?php echo $actions_grid->revisedKc->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $actions_grid->RowIndex ?>_revisedKc[]"></label>
</div>
</span>
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_revisedKc">
<span<?php echo $actions_grid->revisedKc->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_revisedKc" class="custom-control-input" value="<?php echo $actions_grid->revisedKc->getViewValue() ?>" disabled<?php if (ConvertToBool($actions_grid->revisedKc->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_revisedKc"></label></div></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_revisedKc" name="x<?php echo $actions_grid->RowIndex ?>_revisedKc" id="x<?php echo $actions_grid->RowIndex ?>_revisedKc" value="<?php echo HtmlEncode($actions_grid->revisedKc->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_revisedKc" name="o<?php echo $actions_grid->RowIndex ?>_revisedKc[]" id="o<?php echo $actions_grid->RowIndex ?>_revisedKc[]" value="<?php echo HtmlEncode($actions_grid->revisedKc->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_revisedKc" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_revisedKc" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_revisedKc" value="<?php echo HtmlEncode($actions_grid->revisedKc->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_revisedKc" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_revisedKc[]" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_revisedKc[]" value="<?php echo HtmlEncode($actions_grid->revisedKc->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->expectedSeverity->Visible) { // expectedSeverity ?>
		<td data-name="expectedSeverity" <?php echo $actions_grid->expectedSeverity->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedSeverity" class="form-group">
<input type="text" data-table="actions" data-field="x_expectedSeverity" name="x<?php echo $actions_grid->RowIndex ?>_expectedSeverity" id="x<?php echo $actions_grid->RowIndex ?>_expectedSeverity" size="3" placeholder="<?php echo HtmlEncode($actions_grid->expectedSeverity->getPlaceHolder()) ?>" value="<?php echo $actions_grid->expectedSeverity->EditValue ?>"<?php echo $actions_grid->expectedSeverity->editAttributes() ?>>
</span>
<input type="hidden" data-table="actions" data-field="x_expectedSeverity" name="o<?php echo $actions_grid->RowIndex ?>_expectedSeverity" id="o<?php echo $actions_grid->RowIndex ?>_expectedSeverity" value="<?php echo HtmlEncode($actions_grid->expectedSeverity->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedSeverity" class="form-group">
<input type="text" data-table="actions" data-field="x_expectedSeverity" name="x<?php echo $actions_grid->RowIndex ?>_expectedSeverity" id="x<?php echo $actions_grid->RowIndex ?>_expectedSeverity" size="3" placeholder="<?php echo HtmlEncode($actions_grid->expectedSeverity->getPlaceHolder()) ?>" value="<?php echo $actions_grid->expectedSeverity->EditValue ?>"<?php echo $actions_grid->expectedSeverity->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedSeverity">
<span<?php echo $actions_grid->expectedSeverity->viewAttributes() ?>><?php echo $actions_grid->expectedSeverity->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_expectedSeverity" name="x<?php echo $actions_grid->RowIndex ?>_expectedSeverity" id="x<?php echo $actions_grid->RowIndex ?>_expectedSeverity" value="<?php echo HtmlEncode($actions_grid->expectedSeverity->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_expectedSeverity" name="o<?php echo $actions_grid->RowIndex ?>_expectedSeverity" id="o<?php echo $actions_grid->RowIndex ?>_expectedSeverity" value="<?php echo HtmlEncode($actions_grid->expectedSeverity->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_expectedSeverity" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_expectedSeverity" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_expectedSeverity" value="<?php echo HtmlEncode($actions_grid->expectedSeverity->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_expectedSeverity" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_expectedSeverity" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_expectedSeverity" value="<?php echo HtmlEncode($actions_grid->expectedSeverity->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->expectedOccurrence->Visible) { // expectedOccurrence ?>
		<td data-name="expectedOccurrence" <?php echo $actions_grid->expectedOccurrence->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedOccurrence" class="form-group">
<input type="text" data-table="actions" data-field="x_expectedOccurrence" name="x<?php echo $actions_grid->RowIndex ?>_expectedOccurrence" id="x<?php echo $actions_grid->RowIndex ?>_expectedOccurrence" size="3" placeholder="<?php echo HtmlEncode($actions_grid->expectedOccurrence->getPlaceHolder()) ?>" value="<?php echo $actions_grid->expectedOccurrence->EditValue ?>"<?php echo $actions_grid->expectedOccurrence->editAttributes() ?>>
</span>
<input type="hidden" data-table="actions" data-field="x_expectedOccurrence" name="o<?php echo $actions_grid->RowIndex ?>_expectedOccurrence" id="o<?php echo $actions_grid->RowIndex ?>_expectedOccurrence" value="<?php echo HtmlEncode($actions_grid->expectedOccurrence->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedOccurrence" class="form-group">
<input type="text" data-table="actions" data-field="x_expectedOccurrence" name="x<?php echo $actions_grid->RowIndex ?>_expectedOccurrence" id="x<?php echo $actions_grid->RowIndex ?>_expectedOccurrence" size="3" placeholder="<?php echo HtmlEncode($actions_grid->expectedOccurrence->getPlaceHolder()) ?>" value="<?php echo $actions_grid->expectedOccurrence->EditValue ?>"<?php echo $actions_grid->expectedOccurrence->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedOccurrence">
<span<?php echo $actions_grid->expectedOccurrence->viewAttributes() ?>><?php echo $actions_grid->expectedOccurrence->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_expectedOccurrence" name="x<?php echo $actions_grid->RowIndex ?>_expectedOccurrence" id="x<?php echo $actions_grid->RowIndex ?>_expectedOccurrence" value="<?php echo HtmlEncode($actions_grid->expectedOccurrence->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_expectedOccurrence" name="o<?php echo $actions_grid->RowIndex ?>_expectedOccurrence" id="o<?php echo $actions_grid->RowIndex ?>_expectedOccurrence" value="<?php echo HtmlEncode($actions_grid->expectedOccurrence->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_expectedOccurrence" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_expectedOccurrence" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_expectedOccurrence" value="<?php echo HtmlEncode($actions_grid->expectedOccurrence->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_expectedOccurrence" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_expectedOccurrence" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_expectedOccurrence" value="<?php echo HtmlEncode($actions_grid->expectedOccurrence->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->expectedDetection->Visible) { // expectedDetection ?>
		<td data-name="expectedDetection" <?php echo $actions_grid->expectedDetection->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedDetection" class="form-group">
<input type="text" data-table="actions" data-field="x_expectedDetection" name="x<?php echo $actions_grid->RowIndex ?>_expectedDetection" id="x<?php echo $actions_grid->RowIndex ?>_expectedDetection" size="3" placeholder="<?php echo HtmlEncode($actions_grid->expectedDetection->getPlaceHolder()) ?>" value="<?php echo $actions_grid->expectedDetection->EditValue ?>"<?php echo $actions_grid->expectedDetection->editAttributes() ?>>
</span>
<input type="hidden" data-table="actions" data-field="x_expectedDetection" name="o<?php echo $actions_grid->RowIndex ?>_expectedDetection" id="o<?php echo $actions_grid->RowIndex ?>_expectedDetection" value="<?php echo HtmlEncode($actions_grid->expectedDetection->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedDetection" class="form-group">
<input type="text" data-table="actions" data-field="x_expectedDetection" name="x<?php echo $actions_grid->RowIndex ?>_expectedDetection" id="x<?php echo $actions_grid->RowIndex ?>_expectedDetection" size="3" placeholder="<?php echo HtmlEncode($actions_grid->expectedDetection->getPlaceHolder()) ?>" value="<?php echo $actions_grid->expectedDetection->EditValue ?>"<?php echo $actions_grid->expectedDetection->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedDetection">
<span<?php echo $actions_grid->expectedDetection->viewAttributes() ?>><?php echo $actions_grid->expectedDetection->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_expectedDetection" name="x<?php echo $actions_grid->RowIndex ?>_expectedDetection" id="x<?php echo $actions_grid->RowIndex ?>_expectedDetection" value="<?php echo HtmlEncode($actions_grid->expectedDetection->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_expectedDetection" name="o<?php echo $actions_grid->RowIndex ?>_expectedDetection" id="o<?php echo $actions_grid->RowIndex ?>_expectedDetection" value="<?php echo HtmlEncode($actions_grid->expectedDetection->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_expectedDetection" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_expectedDetection" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_expectedDetection" value="<?php echo HtmlEncode($actions_grid->expectedDetection->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_expectedDetection" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_expectedDetection" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_expectedDetection" value="<?php echo HtmlEncode($actions_grid->expectedDetection->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->expectedRPNPAO->Visible) { // expectedRPNPAO ?>
		<td data-name="expectedRPNPAO" <?php echo $actions_grid->expectedRPNPAO->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedRPNPAO" class="form-group">
<input type="text" data-table="actions" data-field="x_expectedRPNPAO" name="x<?php echo $actions_grid->RowIndex ?>_expectedRPNPAO" id="x<?php echo $actions_grid->RowIndex ?>_expectedRPNPAO" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_grid->expectedRPNPAO->getPlaceHolder()) ?>" value="<?php echo $actions_grid->expectedRPNPAO->EditValue ?>"<?php echo $actions_grid->expectedRPNPAO->editAttributes() ?>>
</span>
<input type="hidden" data-table="actions" data-field="x_expectedRPNPAO" name="o<?php echo $actions_grid->RowIndex ?>_expectedRPNPAO" id="o<?php echo $actions_grid->RowIndex ?>_expectedRPNPAO" value="<?php echo HtmlEncode($actions_grid->expectedRPNPAO->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedRPNPAO" class="form-group">
<span<?php echo $actions_grid->expectedRPNPAO->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->expectedRPNPAO->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_expectedRPNPAO" name="x<?php echo $actions_grid->RowIndex ?>_expectedRPNPAO" id="x<?php echo $actions_grid->RowIndex ?>_expectedRPNPAO" value="<?php echo HtmlEncode($actions_grid->expectedRPNPAO->CurrentValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedRPNPAO">
<span<?php echo $actions_grid->expectedRPNPAO->viewAttributes() ?>><?php echo $actions_grid->expectedRPNPAO->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_expectedRPNPAO" name="x<?php echo $actions_grid->RowIndex ?>_expectedRPNPAO" id="x<?php echo $actions_grid->RowIndex ?>_expectedRPNPAO" value="<?php echo HtmlEncode($actions_grid->expectedRPNPAO->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_expectedRPNPAO" name="o<?php echo $actions_grid->RowIndex ?>_expectedRPNPAO" id="o<?php echo $actions_grid->RowIndex ?>_expectedRPNPAO" value="<?php echo HtmlEncode($actions_grid->expectedRPNPAO->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_expectedRPNPAO" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_expectedRPNPAO" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_expectedRPNPAO" value="<?php echo HtmlEncode($actions_grid->expectedRPNPAO->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_expectedRPNPAO" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_expectedRPNPAO" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_expectedRPNPAO" value="<?php echo HtmlEncode($actions_grid->expectedRPNPAO->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->expectedClosureDate->Visible) { // expectedClosureDate ?>
		<td data-name="expectedClosureDate" <?php echo $actions_grid->expectedClosureDate->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedClosureDate" class="form-group">
<input type="text" data-table="actions" data-field="x_expectedClosureDate" data-format="12" name="x<?php echo $actions_grid->RowIndex ?>_expectedClosureDate" id="x<?php echo $actions_grid->RowIndex ?>_expectedClosureDate" size="7" placeholder="<?php echo HtmlEncode($actions_grid->expectedClosureDate->getPlaceHolder()) ?>" value="<?php echo $actions_grid->expectedClosureDate->EditValue ?>"<?php echo $actions_grid->expectedClosureDate->editAttributes() ?>>
<?php if (!$actions_grid->expectedClosureDate->ReadOnly && !$actions_grid->expectedClosureDate->Disabled && !isset($actions_grid->expectedClosureDate->EditAttrs["readonly"]) && !isset($actions_grid->expectedClosureDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["factionsgrid", "datetimepicker"], function() {
	ew.createDateTimePicker("factionsgrid", "x<?php echo $actions_grid->RowIndex ?>_expectedClosureDate", {"ignoreReadonly":true,"useCurrent":false,"format":12});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="actions" data-field="x_expectedClosureDate" name="o<?php echo $actions_grid->RowIndex ?>_expectedClosureDate" id="o<?php echo $actions_grid->RowIndex ?>_expectedClosureDate" value="<?php echo HtmlEncode($actions_grid->expectedClosureDate->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedClosureDate" class="form-group">
<span<?php echo $actions_grid->expectedClosureDate->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->expectedClosureDate->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_expectedClosureDate" name="x<?php echo $actions_grid->RowIndex ?>_expectedClosureDate" id="x<?php echo $actions_grid->RowIndex ?>_expectedClosureDate" value="<?php echo HtmlEncode($actions_grid->expectedClosureDate->CurrentValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedClosureDate">
<span<?php echo $actions_grid->expectedClosureDate->viewAttributes() ?>><?php echo $actions_grid->expectedClosureDate->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_expectedClosureDate" name="x<?php echo $actions_grid->RowIndex ?>_expectedClosureDate" id="x<?php echo $actions_grid->RowIndex ?>_expectedClosureDate" value="<?php echo HtmlEncode($actions_grid->expectedClosureDate->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_expectedClosureDate" name="o<?php echo $actions_grid->RowIndex ?>_expectedClosureDate" id="o<?php echo $actions_grid->RowIndex ?>_expectedClosureDate" value="<?php echo HtmlEncode($actions_grid->expectedClosureDate->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_expectedClosureDate" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_expectedClosureDate" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_expectedClosureDate" value="<?php echo HtmlEncode($actions_grid->expectedClosureDate->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_expectedClosureDate" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_expectedClosureDate" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_expectedClosureDate" value="<?php echo HtmlEncode($actions_grid->expectedClosureDate->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->recomendedActiondet->Visible) { // recomendedActiondet ?>
		<td data-name="recomendedActiondet" <?php echo $actions_grid->recomendedActiondet->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_recomendedActiondet" class="form-group">
<input type="text" data-table="actions" data-field="x_recomendedActiondet" name="x<?php echo $actions_grid->RowIndex ?>_recomendedActiondet" id="x<?php echo $actions_grid->RowIndex ?>_recomendedActiondet" size="10" placeholder="<?php echo HtmlEncode($actions_grid->recomendedActiondet->getPlaceHolder()) ?>" value="<?php echo $actions_grid->recomendedActiondet->EditValue ?>"<?php echo $actions_grid->recomendedActiondet->editAttributes() ?>>
</span>
<input type="hidden" data-table="actions" data-field="x_recomendedActiondet" name="o<?php echo $actions_grid->RowIndex ?>_recomendedActiondet" id="o<?php echo $actions_grid->RowIndex ?>_recomendedActiondet" value="<?php echo HtmlEncode($actions_grid->recomendedActiondet->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_recomendedActiondet" class="form-group">
<input type="text" data-table="actions" data-field="x_recomendedActiondet" name="x<?php echo $actions_grid->RowIndex ?>_recomendedActiondet" id="x<?php echo $actions_grid->RowIndex ?>_recomendedActiondet" size="10" placeholder="<?php echo HtmlEncode($actions_grid->recomendedActiondet->getPlaceHolder()) ?>" value="<?php echo $actions_grid->recomendedActiondet->EditValue ?>"<?php echo $actions_grid->recomendedActiondet->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_recomendedActiondet">
<span<?php echo $actions_grid->recomendedActiondet->viewAttributes() ?>><?php echo $actions_grid->recomendedActiondet->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_recomendedActiondet" name="x<?php echo $actions_grid->RowIndex ?>_recomendedActiondet" id="x<?php echo $actions_grid->RowIndex ?>_recomendedActiondet" value="<?php echo HtmlEncode($actions_grid->recomendedActiondet->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_recomendedActiondet" name="o<?php echo $actions_grid->RowIndex ?>_recomendedActiondet" id="o<?php echo $actions_grid->RowIndex ?>_recomendedActiondet" value="<?php echo HtmlEncode($actions_grid->recomendedActiondet->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_recomendedActiondet" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_recomendedActiondet" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_recomendedActiondet" value="<?php echo HtmlEncode($actions_grid->recomendedActiondet->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_recomendedActiondet" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_recomendedActiondet" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_recomendedActiondet" value="<?php echo HtmlEncode($actions_grid->recomendedActiondet->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->idResponsibleDet->Visible) { // idResponsibleDet ?>
		<td data-name="idResponsibleDet" <?php echo $actions_grid->idResponsibleDet->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_idResponsibleDet" class="form-group">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $actions_grid->RowIndex ?>_idResponsibleDet"><?php echo EmptyValue(strval($actions_grid->idResponsibleDet->ViewValue)) ? $Language->phrase("PleaseSelect") : $actions_grid->idResponsibleDet->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($actions_grid->idResponsibleDet->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($actions_grid->idResponsibleDet->ReadOnly || $actions_grid->idResponsibleDet->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $actions_grid->RowIndex ?>_idResponsibleDet[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $actions_grid->idResponsibleDet->Lookup->getParamTag($actions_grid, "p_x" . $actions_grid->RowIndex . "_idResponsibleDet") ?>
<input type="hidden" data-table="actions" data-field="x_idResponsibleDet" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $actions_grid->idResponsibleDet->displayValueSeparatorAttribute() ?>" name="x<?php echo $actions_grid->RowIndex ?>_idResponsibleDet[]" id="x<?php echo $actions_grid->RowIndex ?>_idResponsibleDet[]" value="<?php echo $actions_grid->idResponsibleDet->CurrentValue ?>"<?php echo $actions_grid->idResponsibleDet->editAttributes() ?>>
</span>
<input type="hidden" data-table="actions" data-field="x_idResponsibleDet" name="o<?php echo $actions_grid->RowIndex ?>_idResponsibleDet[]" id="o<?php echo $actions_grid->RowIndex ?>_idResponsibleDet[]" value="<?php echo HtmlEncode($actions_grid->idResponsibleDet->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_idResponsibleDet" class="form-group">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $actions_grid->RowIndex ?>_idResponsibleDet"><?php echo EmptyValue(strval($actions_grid->idResponsibleDet->ViewValue)) ? $Language->phrase("PleaseSelect") : $actions_grid->idResponsibleDet->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($actions_grid->idResponsibleDet->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($actions_grid->idResponsibleDet->ReadOnly || $actions_grid->idResponsibleDet->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $actions_grid->RowIndex ?>_idResponsibleDet[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $actions_grid->idResponsibleDet->Lookup->getParamTag($actions_grid, "p_x" . $actions_grid->RowIndex . "_idResponsibleDet") ?>
<input type="hidden" data-table="actions" data-field="x_idResponsibleDet" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $actions_grid->idResponsibleDet->displayValueSeparatorAttribute() ?>" name="x<?php echo $actions_grid->RowIndex ?>_idResponsibleDet[]" id="x<?php echo $actions_grid->RowIndex ?>_idResponsibleDet[]" value="<?php echo $actions_grid->idResponsibleDet->CurrentValue ?>"<?php echo $actions_grid->idResponsibleDet->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_idResponsibleDet">
<span<?php echo $actions_grid->idResponsibleDet->viewAttributes() ?>><?php echo $actions_grid->idResponsibleDet->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_idResponsibleDet" name="x<?php echo $actions_grid->RowIndex ?>_idResponsibleDet" id="x<?php echo $actions_grid->RowIndex ?>_idResponsibleDet" value="<?php echo HtmlEncode($actions_grid->idResponsibleDet->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_idResponsibleDet" name="o<?php echo $actions_grid->RowIndex ?>_idResponsibleDet[]" id="o<?php echo $actions_grid->RowIndex ?>_idResponsibleDet[]" value="<?php echo HtmlEncode($actions_grid->idResponsibleDet->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_idResponsibleDet" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_idResponsibleDet" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_idResponsibleDet" value="<?php echo HtmlEncode($actions_grid->idResponsibleDet->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_idResponsibleDet" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_idResponsibleDet[]" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_idResponsibleDet[]" value="<?php echo HtmlEncode($actions_grid->idResponsibleDet->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->targetDatedet->Visible) { // targetDatedet ?>
		<td data-name="targetDatedet" <?php echo $actions_grid->targetDatedet->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_targetDatedet" class="form-group">
<input type="text" data-table="actions" data-field="x_targetDatedet" data-format="14" name="x<?php echo $actions_grid->RowIndex ?>_targetDatedet" id="x<?php echo $actions_grid->RowIndex ?>_targetDatedet" size="7" placeholder="<?php echo HtmlEncode($actions_grid->targetDatedet->getPlaceHolder()) ?>" value="<?php echo $actions_grid->targetDatedet->EditValue ?>"<?php echo $actions_grid->targetDatedet->editAttributes() ?>>
<?php if (!$actions_grid->targetDatedet->ReadOnly && !$actions_grid->targetDatedet->Disabled && !isset($actions_grid->targetDatedet->EditAttrs["readonly"]) && !isset($actions_grid->targetDatedet->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["factionsgrid", "datetimepicker"], function() {
	ew.createDateTimePicker("factionsgrid", "x<?php echo $actions_grid->RowIndex ?>_targetDatedet", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="actions" data-field="x_targetDatedet" name="o<?php echo $actions_grid->RowIndex ?>_targetDatedet" id="o<?php echo $actions_grid->RowIndex ?>_targetDatedet" value="<?php echo HtmlEncode($actions_grid->targetDatedet->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_targetDatedet" class="form-group">
<input type="text" data-table="actions" data-field="x_targetDatedet" data-format="14" name="x<?php echo $actions_grid->RowIndex ?>_targetDatedet" id="x<?php echo $actions_grid->RowIndex ?>_targetDatedet" size="7" placeholder="<?php echo HtmlEncode($actions_grid->targetDatedet->getPlaceHolder()) ?>" value="<?php echo $actions_grid->targetDatedet->EditValue ?>"<?php echo $actions_grid->targetDatedet->editAttributes() ?>>
<?php if (!$actions_grid->targetDatedet->ReadOnly && !$actions_grid->targetDatedet->Disabled && !isset($actions_grid->targetDatedet->EditAttrs["readonly"]) && !isset($actions_grid->targetDatedet->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["factionsgrid", "datetimepicker"], function() {
	ew.createDateTimePicker("factionsgrid", "x<?php echo $actions_grid->RowIndex ?>_targetDatedet", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_targetDatedet">
<span<?php echo $actions_grid->targetDatedet->viewAttributes() ?>><?php echo $actions_grid->targetDatedet->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_targetDatedet" name="x<?php echo $actions_grid->RowIndex ?>_targetDatedet" id="x<?php echo $actions_grid->RowIndex ?>_targetDatedet" value="<?php echo HtmlEncode($actions_grid->targetDatedet->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_targetDatedet" name="o<?php echo $actions_grid->RowIndex ?>_targetDatedet" id="o<?php echo $actions_grid->RowIndex ?>_targetDatedet" value="<?php echo HtmlEncode($actions_grid->targetDatedet->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_targetDatedet" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_targetDatedet" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_targetDatedet" value="<?php echo HtmlEncode($actions_grid->targetDatedet->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_targetDatedet" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_targetDatedet" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_targetDatedet" value="<?php echo HtmlEncode($actions_grid->targetDatedet->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->kcdet->Visible) { // kcdet ?>
		<td data-name="kcdet" <?php echo $actions_grid->kcdet->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_kcdet" class="form-group">
<?php
$selwrk = ConvertToBool($actions_grid->kcdet->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="actions" data-field="x_kcdet" name="x<?php echo $actions_grid->RowIndex ?>_kcdet[]" id="x<?php echo $actions_grid->RowIndex ?>_kcdet[]" value="1"<?php echo $selwrk ?><?php echo $actions_grid->kcdet->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $actions_grid->RowIndex ?>_kcdet[]"></label>
</div>
</span>
<input type="hidden" data-table="actions" data-field="x_kcdet" name="o<?php echo $actions_grid->RowIndex ?>_kcdet[]" id="o<?php echo $actions_grid->RowIndex ?>_kcdet[]" value="<?php echo HtmlEncode($actions_grid->kcdet->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_kcdet" class="form-group">
<?php
$selwrk = ConvertToBool($actions_grid->kcdet->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="actions" data-field="x_kcdet" name="x<?php echo $actions_grid->RowIndex ?>_kcdet[]" id="x<?php echo $actions_grid->RowIndex ?>_kcdet[]" value="1"<?php echo $selwrk ?><?php echo $actions_grid->kcdet->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $actions_grid->RowIndex ?>_kcdet[]"></label>
</div>
</span>
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_kcdet">
<span<?php echo $actions_grid->kcdet->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_kcdet" class="custom-control-input" value="<?php echo $actions_grid->kcdet->getViewValue() ?>" disabled<?php if (ConvertToBool($actions_grid->kcdet->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_kcdet"></label></div></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_kcdet" name="x<?php echo $actions_grid->RowIndex ?>_kcdet" id="x<?php echo $actions_grid->RowIndex ?>_kcdet" value="<?php echo HtmlEncode($actions_grid->kcdet->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_kcdet" name="o<?php echo $actions_grid->RowIndex ?>_kcdet[]" id="o<?php echo $actions_grid->RowIndex ?>_kcdet[]" value="<?php echo HtmlEncode($actions_grid->kcdet->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_kcdet" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_kcdet" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_kcdet" value="<?php echo HtmlEncode($actions_grid->kcdet->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_kcdet" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_kcdet[]" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_kcdet[]" value="<?php echo HtmlEncode($actions_grid->kcdet->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->expectedSeveritydet->Visible) { // expectedSeveritydet ?>
		<td data-name="expectedSeveritydet" <?php echo $actions_grid->expectedSeveritydet->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedSeveritydet" class="form-group">
<input type="text" data-table="actions" data-field="x_expectedSeveritydet" name="x<?php echo $actions_grid->RowIndex ?>_expectedSeveritydet" id="x<?php echo $actions_grid->RowIndex ?>_expectedSeveritydet" size="3" placeholder="<?php echo HtmlEncode($actions_grid->expectedSeveritydet->getPlaceHolder()) ?>" value="<?php echo $actions_grid->expectedSeveritydet->EditValue ?>"<?php echo $actions_grid->expectedSeveritydet->editAttributes() ?>>
</span>
<input type="hidden" data-table="actions" data-field="x_expectedSeveritydet" name="o<?php echo $actions_grid->RowIndex ?>_expectedSeveritydet" id="o<?php echo $actions_grid->RowIndex ?>_expectedSeveritydet" value="<?php echo HtmlEncode($actions_grid->expectedSeveritydet->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedSeveritydet" class="form-group">
<input type="text" data-table="actions" data-field="x_expectedSeveritydet" name="x<?php echo $actions_grid->RowIndex ?>_expectedSeveritydet" id="x<?php echo $actions_grid->RowIndex ?>_expectedSeveritydet" size="3" placeholder="<?php echo HtmlEncode($actions_grid->expectedSeveritydet->getPlaceHolder()) ?>" value="<?php echo $actions_grid->expectedSeveritydet->EditValue ?>"<?php echo $actions_grid->expectedSeveritydet->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedSeveritydet">
<span<?php echo $actions_grid->expectedSeveritydet->viewAttributes() ?>><?php echo $actions_grid->expectedSeveritydet->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_expectedSeveritydet" name="x<?php echo $actions_grid->RowIndex ?>_expectedSeveritydet" id="x<?php echo $actions_grid->RowIndex ?>_expectedSeveritydet" value="<?php echo HtmlEncode($actions_grid->expectedSeveritydet->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_expectedSeveritydet" name="o<?php echo $actions_grid->RowIndex ?>_expectedSeveritydet" id="o<?php echo $actions_grid->RowIndex ?>_expectedSeveritydet" value="<?php echo HtmlEncode($actions_grid->expectedSeveritydet->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_expectedSeveritydet" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_expectedSeveritydet" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_expectedSeveritydet" value="<?php echo HtmlEncode($actions_grid->expectedSeveritydet->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_expectedSeveritydet" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_expectedSeveritydet" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_expectedSeveritydet" value="<?php echo HtmlEncode($actions_grid->expectedSeveritydet->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->expectedOccurrencedet->Visible) { // expectedOccurrencedet ?>
		<td data-name="expectedOccurrencedet" <?php echo $actions_grid->expectedOccurrencedet->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedOccurrencedet" class="form-group">
<input type="text" data-table="actions" data-field="x_expectedOccurrencedet" name="x<?php echo $actions_grid->RowIndex ?>_expectedOccurrencedet" id="x<?php echo $actions_grid->RowIndex ?>_expectedOccurrencedet" size="3" placeholder="<?php echo HtmlEncode($actions_grid->expectedOccurrencedet->getPlaceHolder()) ?>" value="<?php echo $actions_grid->expectedOccurrencedet->EditValue ?>"<?php echo $actions_grid->expectedOccurrencedet->editAttributes() ?>>
</span>
<input type="hidden" data-table="actions" data-field="x_expectedOccurrencedet" name="o<?php echo $actions_grid->RowIndex ?>_expectedOccurrencedet" id="o<?php echo $actions_grid->RowIndex ?>_expectedOccurrencedet" value="<?php echo HtmlEncode($actions_grid->expectedOccurrencedet->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedOccurrencedet" class="form-group">
<input type="text" data-table="actions" data-field="x_expectedOccurrencedet" name="x<?php echo $actions_grid->RowIndex ?>_expectedOccurrencedet" id="x<?php echo $actions_grid->RowIndex ?>_expectedOccurrencedet" size="3" placeholder="<?php echo HtmlEncode($actions_grid->expectedOccurrencedet->getPlaceHolder()) ?>" value="<?php echo $actions_grid->expectedOccurrencedet->EditValue ?>"<?php echo $actions_grid->expectedOccurrencedet->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedOccurrencedet">
<span<?php echo $actions_grid->expectedOccurrencedet->viewAttributes() ?>><?php echo $actions_grid->expectedOccurrencedet->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_expectedOccurrencedet" name="x<?php echo $actions_grid->RowIndex ?>_expectedOccurrencedet" id="x<?php echo $actions_grid->RowIndex ?>_expectedOccurrencedet" value="<?php echo HtmlEncode($actions_grid->expectedOccurrencedet->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_expectedOccurrencedet" name="o<?php echo $actions_grid->RowIndex ?>_expectedOccurrencedet" id="o<?php echo $actions_grid->RowIndex ?>_expectedOccurrencedet" value="<?php echo HtmlEncode($actions_grid->expectedOccurrencedet->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_expectedOccurrencedet" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_expectedOccurrencedet" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_expectedOccurrencedet" value="<?php echo HtmlEncode($actions_grid->expectedOccurrencedet->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_expectedOccurrencedet" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_expectedOccurrencedet" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_expectedOccurrencedet" value="<?php echo HtmlEncode($actions_grid->expectedOccurrencedet->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->expectedDetectiondet->Visible) { // expectedDetectiondet ?>
		<td data-name="expectedDetectiondet" <?php echo $actions_grid->expectedDetectiondet->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedDetectiondet" class="form-group">
<input type="text" data-table="actions" data-field="x_expectedDetectiondet" name="x<?php echo $actions_grid->RowIndex ?>_expectedDetectiondet" id="x<?php echo $actions_grid->RowIndex ?>_expectedDetectiondet" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($actions_grid->expectedDetectiondet->getPlaceHolder()) ?>" value="<?php echo $actions_grid->expectedDetectiondet->EditValue ?>"<?php echo $actions_grid->expectedDetectiondet->editAttributes() ?>>
</span>
<input type="hidden" data-table="actions" data-field="x_expectedDetectiondet" name="o<?php echo $actions_grid->RowIndex ?>_expectedDetectiondet" id="o<?php echo $actions_grid->RowIndex ?>_expectedDetectiondet" value="<?php echo HtmlEncode($actions_grid->expectedDetectiondet->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedDetectiondet" class="form-group">
<input type="text" data-table="actions" data-field="x_expectedDetectiondet" name="x<?php echo $actions_grid->RowIndex ?>_expectedDetectiondet" id="x<?php echo $actions_grid->RowIndex ?>_expectedDetectiondet" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($actions_grid->expectedDetectiondet->getPlaceHolder()) ?>" value="<?php echo $actions_grid->expectedDetectiondet->EditValue ?>"<?php echo $actions_grid->expectedDetectiondet->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedDetectiondet">
<span<?php echo $actions_grid->expectedDetectiondet->viewAttributes() ?>><?php echo $actions_grid->expectedDetectiondet->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_expectedDetectiondet" name="x<?php echo $actions_grid->RowIndex ?>_expectedDetectiondet" id="x<?php echo $actions_grid->RowIndex ?>_expectedDetectiondet" value="<?php echo HtmlEncode($actions_grid->expectedDetectiondet->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_expectedDetectiondet" name="o<?php echo $actions_grid->RowIndex ?>_expectedDetectiondet" id="o<?php echo $actions_grid->RowIndex ?>_expectedDetectiondet" value="<?php echo HtmlEncode($actions_grid->expectedDetectiondet->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_expectedDetectiondet" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_expectedDetectiondet" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_expectedDetectiondet" value="<?php echo HtmlEncode($actions_grid->expectedDetectiondet->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_expectedDetectiondet" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_expectedDetectiondet" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_expectedDetectiondet" value="<?php echo HtmlEncode($actions_grid->expectedDetectiondet->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->expectedRPNPAD->Visible) { // expectedRPNPAD ?>
		<td data-name="expectedRPNPAD" <?php echo $actions_grid->expectedRPNPAD->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedRPNPAD" class="form-group">
<input type="text" data-table="actions" data-field="x_expectedRPNPAD" name="x<?php echo $actions_grid->RowIndex ?>_expectedRPNPAD" id="x<?php echo $actions_grid->RowIndex ?>_expectedRPNPAD" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_grid->expectedRPNPAD->getPlaceHolder()) ?>" value="<?php echo $actions_grid->expectedRPNPAD->EditValue ?>"<?php echo $actions_grid->expectedRPNPAD->editAttributes() ?>>
</span>
<input type="hidden" data-table="actions" data-field="x_expectedRPNPAD" name="o<?php echo $actions_grid->RowIndex ?>_expectedRPNPAD" id="o<?php echo $actions_grid->RowIndex ?>_expectedRPNPAD" value="<?php echo HtmlEncode($actions_grid->expectedRPNPAD->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedRPNPAD" class="form-group">
<span<?php echo $actions_grid->expectedRPNPAD->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->expectedRPNPAD->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_expectedRPNPAD" name="x<?php echo $actions_grid->RowIndex ?>_expectedRPNPAD" id="x<?php echo $actions_grid->RowIndex ?>_expectedRPNPAD" value="<?php echo HtmlEncode($actions_grid->expectedRPNPAD->CurrentValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_expectedRPNPAD">
<span<?php echo $actions_grid->expectedRPNPAD->viewAttributes() ?>><?php echo $actions_grid->expectedRPNPAD->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_expectedRPNPAD" name="x<?php echo $actions_grid->RowIndex ?>_expectedRPNPAD" id="x<?php echo $actions_grid->RowIndex ?>_expectedRPNPAD" value="<?php echo HtmlEncode($actions_grid->expectedRPNPAD->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_expectedRPNPAD" name="o<?php echo $actions_grid->RowIndex ?>_expectedRPNPAD" id="o<?php echo $actions_grid->RowIndex ?>_expectedRPNPAD" value="<?php echo HtmlEncode($actions_grid->expectedRPNPAD->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_expectedRPNPAD" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_expectedRPNPAD" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_expectedRPNPAD" value="<?php echo HtmlEncode($actions_grid->expectedRPNPAD->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_expectedRPNPAD" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_expectedRPNPAD" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_expectedRPNPAD" value="<?php echo HtmlEncode($actions_grid->expectedRPNPAD->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->revisedClosureDatedet->Visible) { // revisedClosureDatedet ?>
		<td data-name="revisedClosureDatedet" <?php echo $actions_grid->revisedClosureDatedet->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_revisedClosureDatedet" class="form-group">
<input type="text" data-table="actions" data-field="x_revisedClosureDatedet" data-format="14" name="x<?php echo $actions_grid->RowIndex ?>_revisedClosureDatedet" id="x<?php echo $actions_grid->RowIndex ?>_revisedClosureDatedet" size="7" placeholder="<?php echo HtmlEncode($actions_grid->revisedClosureDatedet->getPlaceHolder()) ?>" value="<?php echo $actions_grid->revisedClosureDatedet->EditValue ?>"<?php echo $actions_grid->revisedClosureDatedet->editAttributes() ?>>
<?php if (!$actions_grid->revisedClosureDatedet->ReadOnly && !$actions_grid->revisedClosureDatedet->Disabled && !isset($actions_grid->revisedClosureDatedet->EditAttrs["readonly"]) && !isset($actions_grid->revisedClosureDatedet->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["factionsgrid", "datetimepicker"], function() {
	ew.createDateTimePicker("factionsgrid", "x<?php echo $actions_grid->RowIndex ?>_revisedClosureDatedet", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="actions" data-field="x_revisedClosureDatedet" name="o<?php echo $actions_grid->RowIndex ?>_revisedClosureDatedet" id="o<?php echo $actions_grid->RowIndex ?>_revisedClosureDatedet" value="<?php echo HtmlEncode($actions_grid->revisedClosureDatedet->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_revisedClosureDatedet" class="form-group">
<input type="text" data-table="actions" data-field="x_revisedClosureDatedet" data-format="14" name="x<?php echo $actions_grid->RowIndex ?>_revisedClosureDatedet" id="x<?php echo $actions_grid->RowIndex ?>_revisedClosureDatedet" size="7" placeholder="<?php echo HtmlEncode($actions_grid->revisedClosureDatedet->getPlaceHolder()) ?>" value="<?php echo $actions_grid->revisedClosureDatedet->EditValue ?>"<?php echo $actions_grid->revisedClosureDatedet->editAttributes() ?>>
<?php if (!$actions_grid->revisedClosureDatedet->ReadOnly && !$actions_grid->revisedClosureDatedet->Disabled && !isset($actions_grid->revisedClosureDatedet->EditAttrs["readonly"]) && !isset($actions_grid->revisedClosureDatedet->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["factionsgrid", "datetimepicker"], function() {
	ew.createDateTimePicker("factionsgrid", "x<?php echo $actions_grid->RowIndex ?>_revisedClosureDatedet", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_revisedClosureDatedet">
<span<?php echo $actions_grid->revisedClosureDatedet->viewAttributes() ?>><?php echo $actions_grid->revisedClosureDatedet->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_revisedClosureDatedet" name="x<?php echo $actions_grid->RowIndex ?>_revisedClosureDatedet" id="x<?php echo $actions_grid->RowIndex ?>_revisedClosureDatedet" value="<?php echo HtmlEncode($actions_grid->revisedClosureDatedet->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_revisedClosureDatedet" name="o<?php echo $actions_grid->RowIndex ?>_revisedClosureDatedet" id="o<?php echo $actions_grid->RowIndex ?>_revisedClosureDatedet" value="<?php echo HtmlEncode($actions_grid->revisedClosureDatedet->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_revisedClosureDatedet" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_revisedClosureDatedet" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_revisedClosureDatedet" value="<?php echo HtmlEncode($actions_grid->revisedClosureDatedet->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_revisedClosureDatedet" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_revisedClosureDatedet" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_revisedClosureDatedet" value="<?php echo HtmlEncode($actions_grid->revisedClosureDatedet->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->revisedSeverity->Visible) { // revisedSeverity ?>
		<td data-name="revisedSeverity" <?php echo $actions_grid->revisedSeverity->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_revisedSeverity" class="form-group">
<input type="text" data-table="actions" data-field="x_revisedSeverity" name="x<?php echo $actions_grid->RowIndex ?>_revisedSeverity" id="x<?php echo $actions_grid->RowIndex ?>_revisedSeverity" size="3" placeholder="<?php echo HtmlEncode($actions_grid->revisedSeverity->getPlaceHolder()) ?>" value="<?php echo $actions_grid->revisedSeverity->EditValue ?>"<?php echo $actions_grid->revisedSeverity->editAttributes() ?>>
</span>
<input type="hidden" data-table="actions" data-field="x_revisedSeverity" name="o<?php echo $actions_grid->RowIndex ?>_revisedSeverity" id="o<?php echo $actions_grid->RowIndex ?>_revisedSeverity" value="<?php echo HtmlEncode($actions_grid->revisedSeverity->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_revisedSeverity" class="form-group">
<input type="text" data-table="actions" data-field="x_revisedSeverity" name="x<?php echo $actions_grid->RowIndex ?>_revisedSeverity" id="x<?php echo $actions_grid->RowIndex ?>_revisedSeverity" size="3" placeholder="<?php echo HtmlEncode($actions_grid->revisedSeverity->getPlaceHolder()) ?>" value="<?php echo $actions_grid->revisedSeverity->EditValue ?>"<?php echo $actions_grid->revisedSeverity->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_revisedSeverity">
<span<?php echo $actions_grid->revisedSeverity->viewAttributes() ?>><?php echo $actions_grid->revisedSeverity->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_revisedSeverity" name="x<?php echo $actions_grid->RowIndex ?>_revisedSeverity" id="x<?php echo $actions_grid->RowIndex ?>_revisedSeverity" value="<?php echo HtmlEncode($actions_grid->revisedSeverity->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_revisedSeverity" name="o<?php echo $actions_grid->RowIndex ?>_revisedSeverity" id="o<?php echo $actions_grid->RowIndex ?>_revisedSeverity" value="<?php echo HtmlEncode($actions_grid->revisedSeverity->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_revisedSeverity" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_revisedSeverity" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_revisedSeverity" value="<?php echo HtmlEncode($actions_grid->revisedSeverity->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_revisedSeverity" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_revisedSeverity" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_revisedSeverity" value="<?php echo HtmlEncode($actions_grid->revisedSeverity->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->revisedOccurrence->Visible) { // revisedOccurrence ?>
		<td data-name="revisedOccurrence" <?php echo $actions_grid->revisedOccurrence->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_revisedOccurrence" class="form-group">
<input type="text" data-table="actions" data-field="x_revisedOccurrence" name="x<?php echo $actions_grid->RowIndex ?>_revisedOccurrence" id="x<?php echo $actions_grid->RowIndex ?>_revisedOccurrence" size="3" placeholder="<?php echo HtmlEncode($actions_grid->revisedOccurrence->getPlaceHolder()) ?>" value="<?php echo $actions_grid->revisedOccurrence->EditValue ?>"<?php echo $actions_grid->revisedOccurrence->editAttributes() ?>>
</span>
<input type="hidden" data-table="actions" data-field="x_revisedOccurrence" name="o<?php echo $actions_grid->RowIndex ?>_revisedOccurrence" id="o<?php echo $actions_grid->RowIndex ?>_revisedOccurrence" value="<?php echo HtmlEncode($actions_grid->revisedOccurrence->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_revisedOccurrence" class="form-group">
<input type="text" data-table="actions" data-field="x_revisedOccurrence" name="x<?php echo $actions_grid->RowIndex ?>_revisedOccurrence" id="x<?php echo $actions_grid->RowIndex ?>_revisedOccurrence" size="3" placeholder="<?php echo HtmlEncode($actions_grid->revisedOccurrence->getPlaceHolder()) ?>" value="<?php echo $actions_grid->revisedOccurrence->EditValue ?>"<?php echo $actions_grid->revisedOccurrence->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_revisedOccurrence">
<span<?php echo $actions_grid->revisedOccurrence->viewAttributes() ?>><?php echo $actions_grid->revisedOccurrence->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_revisedOccurrence" name="x<?php echo $actions_grid->RowIndex ?>_revisedOccurrence" id="x<?php echo $actions_grid->RowIndex ?>_revisedOccurrence" value="<?php echo HtmlEncode($actions_grid->revisedOccurrence->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_revisedOccurrence" name="o<?php echo $actions_grid->RowIndex ?>_revisedOccurrence" id="o<?php echo $actions_grid->RowIndex ?>_revisedOccurrence" value="<?php echo HtmlEncode($actions_grid->revisedOccurrence->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_revisedOccurrence" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_revisedOccurrence" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_revisedOccurrence" value="<?php echo HtmlEncode($actions_grid->revisedOccurrence->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_revisedOccurrence" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_revisedOccurrence" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_revisedOccurrence" value="<?php echo HtmlEncode($actions_grid->revisedOccurrence->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->revisedDetection->Visible) { // revisedDetection ?>
		<td data-name="revisedDetection" <?php echo $actions_grid->revisedDetection->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_revisedDetection" class="form-group">
<input type="text" data-table="actions" data-field="x_revisedDetection" name="x<?php echo $actions_grid->RowIndex ?>_revisedDetection" id="x<?php echo $actions_grid->RowIndex ?>_revisedDetection" size="3" placeholder="<?php echo HtmlEncode($actions_grid->revisedDetection->getPlaceHolder()) ?>" value="<?php echo $actions_grid->revisedDetection->EditValue ?>"<?php echo $actions_grid->revisedDetection->editAttributes() ?>>
</span>
<input type="hidden" data-table="actions" data-field="x_revisedDetection" name="o<?php echo $actions_grid->RowIndex ?>_revisedDetection" id="o<?php echo $actions_grid->RowIndex ?>_revisedDetection" value="<?php echo HtmlEncode($actions_grid->revisedDetection->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_revisedDetection" class="form-group">
<input type="text" data-table="actions" data-field="x_revisedDetection" name="x<?php echo $actions_grid->RowIndex ?>_revisedDetection" id="x<?php echo $actions_grid->RowIndex ?>_revisedDetection" size="3" placeholder="<?php echo HtmlEncode($actions_grid->revisedDetection->getPlaceHolder()) ?>" value="<?php echo $actions_grid->revisedDetection->EditValue ?>"<?php echo $actions_grid->revisedDetection->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_revisedDetection">
<span<?php echo $actions_grid->revisedDetection->viewAttributes() ?>><?php echo $actions_grid->revisedDetection->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_revisedDetection" name="x<?php echo $actions_grid->RowIndex ?>_revisedDetection" id="x<?php echo $actions_grid->RowIndex ?>_revisedDetection" value="<?php echo HtmlEncode($actions_grid->revisedDetection->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_revisedDetection" name="o<?php echo $actions_grid->RowIndex ?>_revisedDetection" id="o<?php echo $actions_grid->RowIndex ?>_revisedDetection" value="<?php echo HtmlEncode($actions_grid->revisedDetection->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_revisedDetection" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_revisedDetection" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_revisedDetection" value="<?php echo HtmlEncode($actions_grid->revisedDetection->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_revisedDetection" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_revisedDetection" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_revisedDetection" value="<?php echo HtmlEncode($actions_grid->revisedDetection->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_grid->revisedRPNCalc->Visible) { // revisedRPNCalc ?>
		<td data-name="revisedRPNCalc" <?php echo $actions_grid->revisedRPNCalc->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_revisedRPNCalc" class="form-group">
<input type="text" data-table="actions" data-field="x_revisedRPNCalc" name="x<?php echo $actions_grid->RowIndex ?>_revisedRPNCalc" id="x<?php echo $actions_grid->RowIndex ?>_revisedRPNCalc" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_grid->revisedRPNCalc->getPlaceHolder()) ?>" value="<?php echo $actions_grid->revisedRPNCalc->EditValue ?>"<?php echo $actions_grid->revisedRPNCalc->editAttributes() ?>>
</span>
<input type="hidden" data-table="actions" data-field="x_revisedRPNCalc" name="o<?php echo $actions_grid->RowIndex ?>_revisedRPNCalc" id="o<?php echo $actions_grid->RowIndex ?>_revisedRPNCalc" value="<?php echo HtmlEncode($actions_grid->revisedRPNCalc->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_revisedRPNCalc" class="form-group">
<span<?php echo $actions_grid->revisedRPNCalc->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->revisedRPNCalc->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_revisedRPNCalc" name="x<?php echo $actions_grid->RowIndex ?>_revisedRPNCalc" id="x<?php echo $actions_grid->RowIndex ?>_revisedRPNCalc" value="<?php echo HtmlEncode($actions_grid->revisedRPNCalc->CurrentValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $actions_grid->RowCount ?>_actions_revisedRPNCalc">
<span<?php echo $actions_grid->revisedRPNCalc->viewAttributes() ?>><?php echo $actions_grid->revisedRPNCalc->getViewValue() ?></span>
</span>
<?php if (!$actions->isConfirm()) { ?>
<input type="hidden" data-table="actions" data-field="x_revisedRPNCalc" name="x<?php echo $actions_grid->RowIndex ?>_revisedRPNCalc" id="x<?php echo $actions_grid->RowIndex ?>_revisedRPNCalc" value="<?php echo HtmlEncode($actions_grid->revisedRPNCalc->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_revisedRPNCalc" name="o<?php echo $actions_grid->RowIndex ?>_revisedRPNCalc" id="o<?php echo $actions_grid->RowIndex ?>_revisedRPNCalc" value="<?php echo HtmlEncode($actions_grid->revisedRPNCalc->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_revisedRPNCalc" name="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_revisedRPNCalc" id="factionsgrid$x<?php echo $actions_grid->RowIndex ?>_revisedRPNCalc" value="<?php echo HtmlEncode($actions_grid->revisedRPNCalc->FormValue) ?>">
<input type="hidden" data-table="actions" data-field="x_revisedRPNCalc" name="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_revisedRPNCalc" id="factionsgrid$o<?php echo $actions_grid->RowIndex ?>_revisedRPNCalc" value="<?php echo HtmlEncode($actions_grid->revisedRPNCalc->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$actions_grid->ListOptions->render("body", "right", $actions_grid->RowCount);
?>
	</tr>
<?php if ($actions->RowType == ROWTYPE_ADD || $actions->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["factionsgrid", "load"], function() {
	factionsgrid.updateLists(<?php echo $actions_grid->RowIndex ?>);
});
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$actions_grid->isGridAdd() || $actions->CurrentMode == "copy")
		if (!$actions_grid->Recordset->EOF)
			$actions_grid->Recordset->moveNext();
}
?>
<?php
	if ($actions->CurrentMode == "add" || $actions->CurrentMode == "copy" || $actions->CurrentMode == "edit") {
		$actions_grid->RowIndex = '$rowindex$';
		$actions_grid->loadRowValues();

		// Set row properties
		$actions->resetAttributes();
		$actions->RowAttrs->merge(["data-rowindex" => $actions_grid->RowIndex, "id" => "r0_actions", "data-rowtype" => ROWTYPE_ADD]);
		$actions->RowAttrs->appendClass("ew-template");
		$actions->RowType = ROWTYPE_ADD;

		// Render row
		$actions_grid->renderRow();

		// Render list options
		$actions_grid->renderListOptions();
		$actions_grid->StartRowCount = 0;
?>
	<tr <?php echo $actions->rowAttributes() ?>>
<?php

// Render list options (body, left)
$actions_grid->ListOptions->render("body", "left", $actions_grid->RowIndex);
?>
	<?php if ($actions_grid->idProcess->Visible) { // idProcess ?>
		<td data-name="idProcess">
<?php if (!$actions->isConfirm()) { ?>
<?php if ($actions_grid->idProcess->getSessionValue() != "") { ?>
<span id="el$rowindex$_actions_idProcess" class="form-group actions_idProcess">
<span<?php echo $actions_grid->idProcess->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->idProcess->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $actions_grid->RowIndex ?>_idProcess" name="x<?php echo $actions_grid->RowIndex ?>_idProcess" value="<?php echo HtmlEncode($actions_grid->idProcess->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_actions_idProcess" class="form-group actions_idProcess">
<input type="text" data-table="actions" data-field="x_idProcess" name="x<?php echo $actions_grid->RowIndex ?>_idProcess" id="x<?php echo $actions_grid->RowIndex ?>_idProcess" size="30" placeholder="<?php echo HtmlEncode($actions_grid->idProcess->getPlaceHolder()) ?>" value="<?php echo $actions_grid->idProcess->EditValue ?>"<?php echo $actions_grid->idProcess->editAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_actions_idProcess" class="form-group actions_idProcess">
<span<?php echo $actions_grid->idProcess->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->idProcess->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_idProcess" name="x<?php echo $actions_grid->RowIndex ?>_idProcess" id="x<?php echo $actions_grid->RowIndex ?>_idProcess" value="<?php echo HtmlEncode($actions_grid->idProcess->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_idProcess" name="o<?php echo $actions_grid->RowIndex ?>_idProcess" id="o<?php echo $actions_grid->RowIndex ?>_idProcess" value="<?php echo HtmlEncode($actions_grid->idProcess->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->idCause->Visible) { // idCause ?>
		<td data-name="idCause">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_idCause" class="form-group actions_idCause">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="actions" data-field="x_idCause" data-value-separator="<?php echo $actions_grid->idCause->displayValueSeparatorAttribute() ?>" id="x<?php echo $actions_grid->RowIndex ?>_idCause" name="x<?php echo $actions_grid->RowIndex ?>_idCause"<?php echo $actions_grid->idCause->editAttributes() ?>>
			<?php echo $actions_grid->idCause->selectOptionListHtml("x{$actions_grid->RowIndex}_idCause") ?>
		</select>
</div>
<?php echo $actions_grid->idCause->Lookup->getParamTag($actions_grid, "p_x" . $actions_grid->RowIndex . "_idCause") ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_idCause" class="form-group actions_idCause">
<span<?php echo $actions_grid->idCause->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->idCause->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_idCause" name="x<?php echo $actions_grid->RowIndex ?>_idCause" id="x<?php echo $actions_grid->RowIndex ?>_idCause" value="<?php echo HtmlEncode($actions_grid->idCause->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_idCause" name="o<?php echo $actions_grid->RowIndex ?>_idCause" id="o<?php echo $actions_grid->RowIndex ?>_idCause" value="<?php echo HtmlEncode($actions_grid->idCause->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->potentialCauses->Visible) { // potentialCauses ?>
		<td data-name="potentialCauses">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_potentialCauses" class="form-group actions_potentialCauses">
<textarea data-table="actions" data-field="x_potentialCauses" name="x<?php echo $actions_grid->RowIndex ?>_potentialCauses" id="x<?php echo $actions_grid->RowIndex ?>_potentialCauses" cols="35" rows="4" placeholder="<?php echo HtmlEncode($actions_grid->potentialCauses->getPlaceHolder()) ?>"<?php echo $actions_grid->potentialCauses->editAttributes() ?>><?php echo $actions_grid->potentialCauses->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_potentialCauses" class="form-group actions_potentialCauses">
<span<?php echo $actions_grid->potentialCauses->viewAttributes() ?>><?php echo $actions_grid->potentialCauses->ViewValue ?></span>
</span>
<input type="hidden" data-table="actions" data-field="x_potentialCauses" name="x<?php echo $actions_grid->RowIndex ?>_potentialCauses" id="x<?php echo $actions_grid->RowIndex ?>_potentialCauses" value="<?php echo HtmlEncode($actions_grid->potentialCauses->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_potentialCauses" name="o<?php echo $actions_grid->RowIndex ?>_potentialCauses" id="o<?php echo $actions_grid->RowIndex ?>_potentialCauses" value="<?php echo HtmlEncode($actions_grid->potentialCauses->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->currentPreventiveControlMethod->Visible) { // currentPreventiveControlMethod ?>
		<td data-name="currentPreventiveControlMethod">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_currentPreventiveControlMethod" class="form-group actions_currentPreventiveControlMethod">
<input type="text" data-table="actions" data-field="x_currentPreventiveControlMethod" name="x<?php echo $actions_grid->RowIndex ?>_currentPreventiveControlMethod" id="x<?php echo $actions_grid->RowIndex ?>_currentPreventiveControlMethod" size="7" maxlength="255" placeholder="<?php echo HtmlEncode($actions_grid->currentPreventiveControlMethod->getPlaceHolder()) ?>" value="<?php echo $actions_grid->currentPreventiveControlMethod->EditValue ?>"<?php echo $actions_grid->currentPreventiveControlMethod->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_currentPreventiveControlMethod" class="form-group actions_currentPreventiveControlMethod">
<span<?php echo $actions_grid->currentPreventiveControlMethod->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->currentPreventiveControlMethod->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_currentPreventiveControlMethod" name="x<?php echo $actions_grid->RowIndex ?>_currentPreventiveControlMethod" id="x<?php echo $actions_grid->RowIndex ?>_currentPreventiveControlMethod" value="<?php echo HtmlEncode($actions_grid->currentPreventiveControlMethod->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_currentPreventiveControlMethod" name="o<?php echo $actions_grid->RowIndex ?>_currentPreventiveControlMethod" id="o<?php echo $actions_grid->RowIndex ?>_currentPreventiveControlMethod" value="<?php echo HtmlEncode($actions_grid->currentPreventiveControlMethod->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->severity->Visible) { // severity ?>
		<td data-name="severity">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_severity" class="form-group actions_severity">
<input type="text" data-table="actions" data-field="x_severity" name="x<?php echo $actions_grid->RowIndex ?>_severity" id="x<?php echo $actions_grid->RowIndex ?>_severity" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($actions_grid->severity->getPlaceHolder()) ?>" value="<?php echo $actions_grid->severity->EditValue ?>"<?php echo $actions_grid->severity->editAttributes() ?>>
</span>
<?php } else { ?>
<input type="hidden" data-table="actions" data-field="x_severity" name="x<?php echo $actions_grid->RowIndex ?>_severity" id="x<?php echo $actions_grid->RowIndex ?>_severity" value="<?php echo HtmlEncode($actions_grid->severity->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_severity" name="o<?php echo $actions_grid->RowIndex ?>_severity" id="o<?php echo $actions_grid->RowIndex ?>_severity" value="<?php echo HtmlEncode($actions_grid->severity->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->occurrence->Visible) { // occurrence ?>
		<td data-name="occurrence">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_occurrence" class="form-group actions_occurrence">
<input type="text" data-table="actions" data-field="x_occurrence" name="x<?php echo $actions_grid->RowIndex ?>_occurrence" id="x<?php echo $actions_grid->RowIndex ?>_occurrence" size="3" placeholder="<?php echo HtmlEncode($actions_grid->occurrence->getPlaceHolder()) ?>" value="<?php echo $actions_grid->occurrence->EditValue ?>"<?php echo $actions_grid->occurrence->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_occurrence" class="form-group actions_occurrence">
<span<?php echo $actions_grid->occurrence->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->occurrence->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_occurrence" name="x<?php echo $actions_grid->RowIndex ?>_occurrence" id="x<?php echo $actions_grid->RowIndex ?>_occurrence" value="<?php echo HtmlEncode($actions_grid->occurrence->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_occurrence" name="o<?php echo $actions_grid->RowIndex ?>_occurrence" id="o<?php echo $actions_grid->RowIndex ?>_occurrence" value="<?php echo HtmlEncode($actions_grid->occurrence->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->currentControlMethod->Visible) { // currentControlMethod ?>
		<td data-name="currentControlMethod">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_currentControlMethod" class="form-group actions_currentControlMethod">
<input type="text" data-table="actions" data-field="x_currentControlMethod" name="x<?php echo $actions_grid->RowIndex ?>_currentControlMethod" id="x<?php echo $actions_grid->RowIndex ?>_currentControlMethod" size="10" maxlength="255" placeholder="<?php echo HtmlEncode($actions_grid->currentControlMethod->getPlaceHolder()) ?>" value="<?php echo $actions_grid->currentControlMethod->EditValue ?>"<?php echo $actions_grid->currentControlMethod->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_currentControlMethod" class="form-group actions_currentControlMethod">
<span<?php echo $actions_grid->currentControlMethod->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->currentControlMethod->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_currentControlMethod" name="x<?php echo $actions_grid->RowIndex ?>_currentControlMethod" id="x<?php echo $actions_grid->RowIndex ?>_currentControlMethod" value="<?php echo HtmlEncode($actions_grid->currentControlMethod->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_currentControlMethod" name="o<?php echo $actions_grid->RowIndex ?>_currentControlMethod" id="o<?php echo $actions_grid->RowIndex ?>_currentControlMethod" value="<?php echo HtmlEncode($actions_grid->currentControlMethod->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->detection->Visible) { // detection ?>
		<td data-name="detection">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_detection" class="form-group actions_detection">
<input type="text" data-table="actions" data-field="x_detection" name="x<?php echo $actions_grid->RowIndex ?>_detection" id="x<?php echo $actions_grid->RowIndex ?>_detection" size="3" placeholder="<?php echo HtmlEncode($actions_grid->detection->getPlaceHolder()) ?>" value="<?php echo $actions_grid->detection->EditValue ?>"<?php echo $actions_grid->detection->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_detection" class="form-group actions_detection">
<span<?php echo $actions_grid->detection->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->detection->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_detection" name="x<?php echo $actions_grid->RowIndex ?>_detection" id="x<?php echo $actions_grid->RowIndex ?>_detection" value="<?php echo HtmlEncode($actions_grid->detection->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_detection" name="o<?php echo $actions_grid->RowIndex ?>_detection" id="o<?php echo $actions_grid->RowIndex ?>_detection" value="<?php echo HtmlEncode($actions_grid->detection->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->RPNCalc->Visible) { // RPNCalc ?>
		<td data-name="RPNCalc">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_RPNCalc" class="form-group actions_RPNCalc">
<input type="text" data-table="actions" data-field="x_RPNCalc" name="x<?php echo $actions_grid->RowIndex ?>_RPNCalc" id="x<?php echo $actions_grid->RowIndex ?>_RPNCalc" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_grid->RPNCalc->getPlaceHolder()) ?>" value="<?php echo $actions_grid->RPNCalc->EditValue ?>"<?php echo $actions_grid->RPNCalc->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_RPNCalc" class="form-group actions_RPNCalc">
<span<?php echo $actions_grid->RPNCalc->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->RPNCalc->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_RPNCalc" name="x<?php echo $actions_grid->RowIndex ?>_RPNCalc" id="x<?php echo $actions_grid->RowIndex ?>_RPNCalc" value="<?php echo HtmlEncode($actions_grid->RPNCalc->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_RPNCalc" name="o<?php echo $actions_grid->RowIndex ?>_RPNCalc" id="o<?php echo $actions_grid->RowIndex ?>_RPNCalc" value="<?php echo HtmlEncode($actions_grid->RPNCalc->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->recomendedAction->Visible) { // recomendedAction ?>
		<td data-name="recomendedAction">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_recomendedAction" class="form-group actions_recomendedAction">
<textarea data-table="actions" data-field="x_recomendedAction" name="x<?php echo $actions_grid->RowIndex ?>_recomendedAction" id="x<?php echo $actions_grid->RowIndex ?>_recomendedAction" cols="10" rows="4" placeholder="<?php echo HtmlEncode($actions_grid->recomendedAction->getPlaceHolder()) ?>"<?php echo $actions_grid->recomendedAction->editAttributes() ?>><?php echo $actions_grid->recomendedAction->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_recomendedAction" class="form-group actions_recomendedAction">
<span<?php echo $actions_grid->recomendedAction->viewAttributes() ?>><?php echo $actions_grid->recomendedAction->ViewValue ?></span>
</span>
<input type="hidden" data-table="actions" data-field="x_recomendedAction" name="x<?php echo $actions_grid->RowIndex ?>_recomendedAction" id="x<?php echo $actions_grid->RowIndex ?>_recomendedAction" value="<?php echo HtmlEncode($actions_grid->recomendedAction->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_recomendedAction" name="o<?php echo $actions_grid->RowIndex ?>_recomendedAction" id="o<?php echo $actions_grid->RowIndex ?>_recomendedAction" value="<?php echo HtmlEncode($actions_grid->recomendedAction->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->idResponsible->Visible) { // idResponsible ?>
		<td data-name="idResponsible">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_idResponsible" class="form-group actions_idResponsible">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $actions_grid->RowIndex ?>_idResponsible"><?php echo EmptyValue(strval($actions_grid->idResponsible->ViewValue)) ? $Language->phrase("PleaseSelect") : $actions_grid->idResponsible->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($actions_grid->idResponsible->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($actions_grid->idResponsible->ReadOnly || $actions_grid->idResponsible->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $actions_grid->RowIndex ?>_idResponsible[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $actions_grid->idResponsible->Lookup->getParamTag($actions_grid, "p_x" . $actions_grid->RowIndex . "_idResponsible") ?>
<input type="hidden" data-table="actions" data-field="x_idResponsible" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $actions_grid->idResponsible->displayValueSeparatorAttribute() ?>" name="x<?php echo $actions_grid->RowIndex ?>_idResponsible[]" id="x<?php echo $actions_grid->RowIndex ?>_idResponsible[]" value="<?php echo $actions_grid->idResponsible->CurrentValue ?>"<?php echo $actions_grid->idResponsible->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_idResponsible" class="form-group actions_idResponsible">
<span<?php echo $actions_grid->idResponsible->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->idResponsible->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_idResponsible" name="x<?php echo $actions_grid->RowIndex ?>_idResponsible" id="x<?php echo $actions_grid->RowIndex ?>_idResponsible" value="<?php echo HtmlEncode($actions_grid->idResponsible->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_idResponsible" name="o<?php echo $actions_grid->RowIndex ?>_idResponsible[]" id="o<?php echo $actions_grid->RowIndex ?>_idResponsible[]" value="<?php echo HtmlEncode($actions_grid->idResponsible->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->targetDate->Visible) { // targetDate ?>
		<td data-name="targetDate">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_targetDate" class="form-group actions_targetDate">
<input type="text" data-table="actions" data-field="x_targetDate" data-format="14" name="x<?php echo $actions_grid->RowIndex ?>_targetDate" id="x<?php echo $actions_grid->RowIndex ?>_targetDate" size="7" placeholder="<?php echo HtmlEncode($actions_grid->targetDate->getPlaceHolder()) ?>" value="<?php echo $actions_grid->targetDate->EditValue ?>"<?php echo $actions_grid->targetDate->editAttributes() ?>>
<?php if (!$actions_grid->targetDate->ReadOnly && !$actions_grid->targetDate->Disabled && !isset($actions_grid->targetDate->EditAttrs["readonly"]) && !isset($actions_grid->targetDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["factionsgrid", "datetimepicker"], function() {
	ew.createDateTimePicker("factionsgrid", "x<?php echo $actions_grid->RowIndex ?>_targetDate", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_targetDate" class="form-group actions_targetDate">
<span<?php echo $actions_grid->targetDate->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->targetDate->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_targetDate" name="x<?php echo $actions_grid->RowIndex ?>_targetDate" id="x<?php echo $actions_grid->RowIndex ?>_targetDate" value="<?php echo HtmlEncode($actions_grid->targetDate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_targetDate" name="o<?php echo $actions_grid->RowIndex ?>_targetDate" id="o<?php echo $actions_grid->RowIndex ?>_targetDate" value="<?php echo HtmlEncode($actions_grid->targetDate->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->revisedKc->Visible) { // revisedKc ?>
		<td data-name="revisedKc">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_revisedKc" class="form-group actions_revisedKc">
<?php
$selwrk = ConvertToBool($actions_grid->revisedKc->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="actions" data-field="x_revisedKc" name="x<?php echo $actions_grid->RowIndex ?>_revisedKc[]" id="x<?php echo $actions_grid->RowIndex ?>_revisedKc[]" value="1"<?php echo $selwrk ?><?php echo $actions_grid->revisedKc->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $actions_grid->RowIndex ?>_revisedKc[]"></label>
</div>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_revisedKc" class="form-group actions_revisedKc">
<span<?php echo $actions_grid->revisedKc->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_revisedKc" class="custom-control-input" value="<?php echo $actions_grid->revisedKc->ViewValue ?>" disabled<?php if (ConvertToBool($actions_grid->revisedKc->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_revisedKc"></label></div></span>
</span>
<input type="hidden" data-table="actions" data-field="x_revisedKc" name="x<?php echo $actions_grid->RowIndex ?>_revisedKc" id="x<?php echo $actions_grid->RowIndex ?>_revisedKc" value="<?php echo HtmlEncode($actions_grid->revisedKc->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_revisedKc" name="o<?php echo $actions_grid->RowIndex ?>_revisedKc[]" id="o<?php echo $actions_grid->RowIndex ?>_revisedKc[]" value="<?php echo HtmlEncode($actions_grid->revisedKc->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->expectedSeverity->Visible) { // expectedSeverity ?>
		<td data-name="expectedSeverity">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_expectedSeverity" class="form-group actions_expectedSeverity">
<input type="text" data-table="actions" data-field="x_expectedSeverity" name="x<?php echo $actions_grid->RowIndex ?>_expectedSeverity" id="x<?php echo $actions_grid->RowIndex ?>_expectedSeverity" size="3" placeholder="<?php echo HtmlEncode($actions_grid->expectedSeverity->getPlaceHolder()) ?>" value="<?php echo $actions_grid->expectedSeverity->EditValue ?>"<?php echo $actions_grid->expectedSeverity->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_expectedSeverity" class="form-group actions_expectedSeverity">
<span<?php echo $actions_grid->expectedSeverity->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->expectedSeverity->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_expectedSeverity" name="x<?php echo $actions_grid->RowIndex ?>_expectedSeverity" id="x<?php echo $actions_grid->RowIndex ?>_expectedSeverity" value="<?php echo HtmlEncode($actions_grid->expectedSeverity->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_expectedSeverity" name="o<?php echo $actions_grid->RowIndex ?>_expectedSeverity" id="o<?php echo $actions_grid->RowIndex ?>_expectedSeverity" value="<?php echo HtmlEncode($actions_grid->expectedSeverity->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->expectedOccurrence->Visible) { // expectedOccurrence ?>
		<td data-name="expectedOccurrence">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_expectedOccurrence" class="form-group actions_expectedOccurrence">
<input type="text" data-table="actions" data-field="x_expectedOccurrence" name="x<?php echo $actions_grid->RowIndex ?>_expectedOccurrence" id="x<?php echo $actions_grid->RowIndex ?>_expectedOccurrence" size="3" placeholder="<?php echo HtmlEncode($actions_grid->expectedOccurrence->getPlaceHolder()) ?>" value="<?php echo $actions_grid->expectedOccurrence->EditValue ?>"<?php echo $actions_grid->expectedOccurrence->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_expectedOccurrence" class="form-group actions_expectedOccurrence">
<span<?php echo $actions_grid->expectedOccurrence->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->expectedOccurrence->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_expectedOccurrence" name="x<?php echo $actions_grid->RowIndex ?>_expectedOccurrence" id="x<?php echo $actions_grid->RowIndex ?>_expectedOccurrence" value="<?php echo HtmlEncode($actions_grid->expectedOccurrence->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_expectedOccurrence" name="o<?php echo $actions_grid->RowIndex ?>_expectedOccurrence" id="o<?php echo $actions_grid->RowIndex ?>_expectedOccurrence" value="<?php echo HtmlEncode($actions_grid->expectedOccurrence->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->expectedDetection->Visible) { // expectedDetection ?>
		<td data-name="expectedDetection">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_expectedDetection" class="form-group actions_expectedDetection">
<input type="text" data-table="actions" data-field="x_expectedDetection" name="x<?php echo $actions_grid->RowIndex ?>_expectedDetection" id="x<?php echo $actions_grid->RowIndex ?>_expectedDetection" size="3" placeholder="<?php echo HtmlEncode($actions_grid->expectedDetection->getPlaceHolder()) ?>" value="<?php echo $actions_grid->expectedDetection->EditValue ?>"<?php echo $actions_grid->expectedDetection->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_expectedDetection" class="form-group actions_expectedDetection">
<span<?php echo $actions_grid->expectedDetection->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->expectedDetection->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_expectedDetection" name="x<?php echo $actions_grid->RowIndex ?>_expectedDetection" id="x<?php echo $actions_grid->RowIndex ?>_expectedDetection" value="<?php echo HtmlEncode($actions_grid->expectedDetection->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_expectedDetection" name="o<?php echo $actions_grid->RowIndex ?>_expectedDetection" id="o<?php echo $actions_grid->RowIndex ?>_expectedDetection" value="<?php echo HtmlEncode($actions_grid->expectedDetection->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->expectedRPNPAO->Visible) { // expectedRPNPAO ?>
		<td data-name="expectedRPNPAO">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_expectedRPNPAO" class="form-group actions_expectedRPNPAO">
<input type="text" data-table="actions" data-field="x_expectedRPNPAO" name="x<?php echo $actions_grid->RowIndex ?>_expectedRPNPAO" id="x<?php echo $actions_grid->RowIndex ?>_expectedRPNPAO" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_grid->expectedRPNPAO->getPlaceHolder()) ?>" value="<?php echo $actions_grid->expectedRPNPAO->EditValue ?>"<?php echo $actions_grid->expectedRPNPAO->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_expectedRPNPAO" class="form-group actions_expectedRPNPAO">
<span<?php echo $actions_grid->expectedRPNPAO->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->expectedRPNPAO->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_expectedRPNPAO" name="x<?php echo $actions_grid->RowIndex ?>_expectedRPNPAO" id="x<?php echo $actions_grid->RowIndex ?>_expectedRPNPAO" value="<?php echo HtmlEncode($actions_grid->expectedRPNPAO->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_expectedRPNPAO" name="o<?php echo $actions_grid->RowIndex ?>_expectedRPNPAO" id="o<?php echo $actions_grid->RowIndex ?>_expectedRPNPAO" value="<?php echo HtmlEncode($actions_grid->expectedRPNPAO->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->expectedClosureDate->Visible) { // expectedClosureDate ?>
		<td data-name="expectedClosureDate">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_expectedClosureDate" class="form-group actions_expectedClosureDate">
<input type="text" data-table="actions" data-field="x_expectedClosureDate" data-format="12" name="x<?php echo $actions_grid->RowIndex ?>_expectedClosureDate" id="x<?php echo $actions_grid->RowIndex ?>_expectedClosureDate" size="7" placeholder="<?php echo HtmlEncode($actions_grid->expectedClosureDate->getPlaceHolder()) ?>" value="<?php echo $actions_grid->expectedClosureDate->EditValue ?>"<?php echo $actions_grid->expectedClosureDate->editAttributes() ?>>
<?php if (!$actions_grid->expectedClosureDate->ReadOnly && !$actions_grid->expectedClosureDate->Disabled && !isset($actions_grid->expectedClosureDate->EditAttrs["readonly"]) && !isset($actions_grid->expectedClosureDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["factionsgrid", "datetimepicker"], function() {
	ew.createDateTimePicker("factionsgrid", "x<?php echo $actions_grid->RowIndex ?>_expectedClosureDate", {"ignoreReadonly":true,"useCurrent":false,"format":12});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_expectedClosureDate" class="form-group actions_expectedClosureDate">
<span<?php echo $actions_grid->expectedClosureDate->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->expectedClosureDate->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_expectedClosureDate" name="x<?php echo $actions_grid->RowIndex ?>_expectedClosureDate" id="x<?php echo $actions_grid->RowIndex ?>_expectedClosureDate" value="<?php echo HtmlEncode($actions_grid->expectedClosureDate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_expectedClosureDate" name="o<?php echo $actions_grid->RowIndex ?>_expectedClosureDate" id="o<?php echo $actions_grid->RowIndex ?>_expectedClosureDate" value="<?php echo HtmlEncode($actions_grid->expectedClosureDate->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->recomendedActiondet->Visible) { // recomendedActiondet ?>
		<td data-name="recomendedActiondet">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_recomendedActiondet" class="form-group actions_recomendedActiondet">
<input type="text" data-table="actions" data-field="x_recomendedActiondet" name="x<?php echo $actions_grid->RowIndex ?>_recomendedActiondet" id="x<?php echo $actions_grid->RowIndex ?>_recomendedActiondet" size="10" placeholder="<?php echo HtmlEncode($actions_grid->recomendedActiondet->getPlaceHolder()) ?>" value="<?php echo $actions_grid->recomendedActiondet->EditValue ?>"<?php echo $actions_grid->recomendedActiondet->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_recomendedActiondet" class="form-group actions_recomendedActiondet">
<span<?php echo $actions_grid->recomendedActiondet->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->recomendedActiondet->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_recomendedActiondet" name="x<?php echo $actions_grid->RowIndex ?>_recomendedActiondet" id="x<?php echo $actions_grid->RowIndex ?>_recomendedActiondet" value="<?php echo HtmlEncode($actions_grid->recomendedActiondet->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_recomendedActiondet" name="o<?php echo $actions_grid->RowIndex ?>_recomendedActiondet" id="o<?php echo $actions_grid->RowIndex ?>_recomendedActiondet" value="<?php echo HtmlEncode($actions_grid->recomendedActiondet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->idResponsibleDet->Visible) { // idResponsibleDet ?>
		<td data-name="idResponsibleDet">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_idResponsibleDet" class="form-group actions_idResponsibleDet">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $actions_grid->RowIndex ?>_idResponsibleDet"><?php echo EmptyValue(strval($actions_grid->idResponsibleDet->ViewValue)) ? $Language->phrase("PleaseSelect") : $actions_grid->idResponsibleDet->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($actions_grid->idResponsibleDet->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($actions_grid->idResponsibleDet->ReadOnly || $actions_grid->idResponsibleDet->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $actions_grid->RowIndex ?>_idResponsibleDet[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $actions_grid->idResponsibleDet->Lookup->getParamTag($actions_grid, "p_x" . $actions_grid->RowIndex . "_idResponsibleDet") ?>
<input type="hidden" data-table="actions" data-field="x_idResponsibleDet" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $actions_grid->idResponsibleDet->displayValueSeparatorAttribute() ?>" name="x<?php echo $actions_grid->RowIndex ?>_idResponsibleDet[]" id="x<?php echo $actions_grid->RowIndex ?>_idResponsibleDet[]" value="<?php echo $actions_grid->idResponsibleDet->CurrentValue ?>"<?php echo $actions_grid->idResponsibleDet->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_idResponsibleDet" class="form-group actions_idResponsibleDet">
<span<?php echo $actions_grid->idResponsibleDet->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->idResponsibleDet->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_idResponsibleDet" name="x<?php echo $actions_grid->RowIndex ?>_idResponsibleDet" id="x<?php echo $actions_grid->RowIndex ?>_idResponsibleDet" value="<?php echo HtmlEncode($actions_grid->idResponsibleDet->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_idResponsibleDet" name="o<?php echo $actions_grid->RowIndex ?>_idResponsibleDet[]" id="o<?php echo $actions_grid->RowIndex ?>_idResponsibleDet[]" value="<?php echo HtmlEncode($actions_grid->idResponsibleDet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->targetDatedet->Visible) { // targetDatedet ?>
		<td data-name="targetDatedet">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_targetDatedet" class="form-group actions_targetDatedet">
<input type="text" data-table="actions" data-field="x_targetDatedet" data-format="14" name="x<?php echo $actions_grid->RowIndex ?>_targetDatedet" id="x<?php echo $actions_grid->RowIndex ?>_targetDatedet" size="7" placeholder="<?php echo HtmlEncode($actions_grid->targetDatedet->getPlaceHolder()) ?>" value="<?php echo $actions_grid->targetDatedet->EditValue ?>"<?php echo $actions_grid->targetDatedet->editAttributes() ?>>
<?php if (!$actions_grid->targetDatedet->ReadOnly && !$actions_grid->targetDatedet->Disabled && !isset($actions_grid->targetDatedet->EditAttrs["readonly"]) && !isset($actions_grid->targetDatedet->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["factionsgrid", "datetimepicker"], function() {
	ew.createDateTimePicker("factionsgrid", "x<?php echo $actions_grid->RowIndex ?>_targetDatedet", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_targetDatedet" class="form-group actions_targetDatedet">
<span<?php echo $actions_grid->targetDatedet->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->targetDatedet->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_targetDatedet" name="x<?php echo $actions_grid->RowIndex ?>_targetDatedet" id="x<?php echo $actions_grid->RowIndex ?>_targetDatedet" value="<?php echo HtmlEncode($actions_grid->targetDatedet->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_targetDatedet" name="o<?php echo $actions_grid->RowIndex ?>_targetDatedet" id="o<?php echo $actions_grid->RowIndex ?>_targetDatedet" value="<?php echo HtmlEncode($actions_grid->targetDatedet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->kcdet->Visible) { // kcdet ?>
		<td data-name="kcdet">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_kcdet" class="form-group actions_kcdet">
<?php
$selwrk = ConvertToBool($actions_grid->kcdet->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="actions" data-field="x_kcdet" name="x<?php echo $actions_grid->RowIndex ?>_kcdet[]" id="x<?php echo $actions_grid->RowIndex ?>_kcdet[]" value="1"<?php echo $selwrk ?><?php echo $actions_grid->kcdet->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $actions_grid->RowIndex ?>_kcdet[]"></label>
</div>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_kcdet" class="form-group actions_kcdet">
<span<?php echo $actions_grid->kcdet->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_kcdet" class="custom-control-input" value="<?php echo $actions_grid->kcdet->ViewValue ?>" disabled<?php if (ConvertToBool($actions_grid->kcdet->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_kcdet"></label></div></span>
</span>
<input type="hidden" data-table="actions" data-field="x_kcdet" name="x<?php echo $actions_grid->RowIndex ?>_kcdet" id="x<?php echo $actions_grid->RowIndex ?>_kcdet" value="<?php echo HtmlEncode($actions_grid->kcdet->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_kcdet" name="o<?php echo $actions_grid->RowIndex ?>_kcdet[]" id="o<?php echo $actions_grid->RowIndex ?>_kcdet[]" value="<?php echo HtmlEncode($actions_grid->kcdet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->expectedSeveritydet->Visible) { // expectedSeveritydet ?>
		<td data-name="expectedSeveritydet">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_expectedSeveritydet" class="form-group actions_expectedSeveritydet">
<input type="text" data-table="actions" data-field="x_expectedSeveritydet" name="x<?php echo $actions_grid->RowIndex ?>_expectedSeveritydet" id="x<?php echo $actions_grid->RowIndex ?>_expectedSeveritydet" size="3" placeholder="<?php echo HtmlEncode($actions_grid->expectedSeveritydet->getPlaceHolder()) ?>" value="<?php echo $actions_grid->expectedSeveritydet->EditValue ?>"<?php echo $actions_grid->expectedSeveritydet->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_expectedSeveritydet" class="form-group actions_expectedSeveritydet">
<span<?php echo $actions_grid->expectedSeveritydet->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->expectedSeveritydet->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_expectedSeveritydet" name="x<?php echo $actions_grid->RowIndex ?>_expectedSeveritydet" id="x<?php echo $actions_grid->RowIndex ?>_expectedSeveritydet" value="<?php echo HtmlEncode($actions_grid->expectedSeveritydet->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_expectedSeveritydet" name="o<?php echo $actions_grid->RowIndex ?>_expectedSeveritydet" id="o<?php echo $actions_grid->RowIndex ?>_expectedSeveritydet" value="<?php echo HtmlEncode($actions_grid->expectedSeveritydet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->expectedOccurrencedet->Visible) { // expectedOccurrencedet ?>
		<td data-name="expectedOccurrencedet">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_expectedOccurrencedet" class="form-group actions_expectedOccurrencedet">
<input type="text" data-table="actions" data-field="x_expectedOccurrencedet" name="x<?php echo $actions_grid->RowIndex ?>_expectedOccurrencedet" id="x<?php echo $actions_grid->RowIndex ?>_expectedOccurrencedet" size="3" placeholder="<?php echo HtmlEncode($actions_grid->expectedOccurrencedet->getPlaceHolder()) ?>" value="<?php echo $actions_grid->expectedOccurrencedet->EditValue ?>"<?php echo $actions_grid->expectedOccurrencedet->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_expectedOccurrencedet" class="form-group actions_expectedOccurrencedet">
<span<?php echo $actions_grid->expectedOccurrencedet->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->expectedOccurrencedet->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_expectedOccurrencedet" name="x<?php echo $actions_grid->RowIndex ?>_expectedOccurrencedet" id="x<?php echo $actions_grid->RowIndex ?>_expectedOccurrencedet" value="<?php echo HtmlEncode($actions_grid->expectedOccurrencedet->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_expectedOccurrencedet" name="o<?php echo $actions_grid->RowIndex ?>_expectedOccurrencedet" id="o<?php echo $actions_grid->RowIndex ?>_expectedOccurrencedet" value="<?php echo HtmlEncode($actions_grid->expectedOccurrencedet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->expectedDetectiondet->Visible) { // expectedDetectiondet ?>
		<td data-name="expectedDetectiondet">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_expectedDetectiondet" class="form-group actions_expectedDetectiondet">
<input type="text" data-table="actions" data-field="x_expectedDetectiondet" name="x<?php echo $actions_grid->RowIndex ?>_expectedDetectiondet" id="x<?php echo $actions_grid->RowIndex ?>_expectedDetectiondet" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($actions_grid->expectedDetectiondet->getPlaceHolder()) ?>" value="<?php echo $actions_grid->expectedDetectiondet->EditValue ?>"<?php echo $actions_grid->expectedDetectiondet->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_expectedDetectiondet" class="form-group actions_expectedDetectiondet">
<span<?php echo $actions_grid->expectedDetectiondet->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->expectedDetectiondet->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_expectedDetectiondet" name="x<?php echo $actions_grid->RowIndex ?>_expectedDetectiondet" id="x<?php echo $actions_grid->RowIndex ?>_expectedDetectiondet" value="<?php echo HtmlEncode($actions_grid->expectedDetectiondet->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_expectedDetectiondet" name="o<?php echo $actions_grid->RowIndex ?>_expectedDetectiondet" id="o<?php echo $actions_grid->RowIndex ?>_expectedDetectiondet" value="<?php echo HtmlEncode($actions_grid->expectedDetectiondet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->expectedRPNPAD->Visible) { // expectedRPNPAD ?>
		<td data-name="expectedRPNPAD">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_expectedRPNPAD" class="form-group actions_expectedRPNPAD">
<input type="text" data-table="actions" data-field="x_expectedRPNPAD" name="x<?php echo $actions_grid->RowIndex ?>_expectedRPNPAD" id="x<?php echo $actions_grid->RowIndex ?>_expectedRPNPAD" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_grid->expectedRPNPAD->getPlaceHolder()) ?>" value="<?php echo $actions_grid->expectedRPNPAD->EditValue ?>"<?php echo $actions_grid->expectedRPNPAD->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_expectedRPNPAD" class="form-group actions_expectedRPNPAD">
<span<?php echo $actions_grid->expectedRPNPAD->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->expectedRPNPAD->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_expectedRPNPAD" name="x<?php echo $actions_grid->RowIndex ?>_expectedRPNPAD" id="x<?php echo $actions_grid->RowIndex ?>_expectedRPNPAD" value="<?php echo HtmlEncode($actions_grid->expectedRPNPAD->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_expectedRPNPAD" name="o<?php echo $actions_grid->RowIndex ?>_expectedRPNPAD" id="o<?php echo $actions_grid->RowIndex ?>_expectedRPNPAD" value="<?php echo HtmlEncode($actions_grid->expectedRPNPAD->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->revisedClosureDatedet->Visible) { // revisedClosureDatedet ?>
		<td data-name="revisedClosureDatedet">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_revisedClosureDatedet" class="form-group actions_revisedClosureDatedet">
<input type="text" data-table="actions" data-field="x_revisedClosureDatedet" data-format="14" name="x<?php echo $actions_grid->RowIndex ?>_revisedClosureDatedet" id="x<?php echo $actions_grid->RowIndex ?>_revisedClosureDatedet" size="7" placeholder="<?php echo HtmlEncode($actions_grid->revisedClosureDatedet->getPlaceHolder()) ?>" value="<?php echo $actions_grid->revisedClosureDatedet->EditValue ?>"<?php echo $actions_grid->revisedClosureDatedet->editAttributes() ?>>
<?php if (!$actions_grid->revisedClosureDatedet->ReadOnly && !$actions_grid->revisedClosureDatedet->Disabled && !isset($actions_grid->revisedClosureDatedet->EditAttrs["readonly"]) && !isset($actions_grid->revisedClosureDatedet->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["factionsgrid", "datetimepicker"], function() {
	ew.createDateTimePicker("factionsgrid", "x<?php echo $actions_grid->RowIndex ?>_revisedClosureDatedet", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_revisedClosureDatedet" class="form-group actions_revisedClosureDatedet">
<span<?php echo $actions_grid->revisedClosureDatedet->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->revisedClosureDatedet->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_revisedClosureDatedet" name="x<?php echo $actions_grid->RowIndex ?>_revisedClosureDatedet" id="x<?php echo $actions_grid->RowIndex ?>_revisedClosureDatedet" value="<?php echo HtmlEncode($actions_grid->revisedClosureDatedet->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_revisedClosureDatedet" name="o<?php echo $actions_grid->RowIndex ?>_revisedClosureDatedet" id="o<?php echo $actions_grid->RowIndex ?>_revisedClosureDatedet" value="<?php echo HtmlEncode($actions_grid->revisedClosureDatedet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->revisedSeverity->Visible) { // revisedSeverity ?>
		<td data-name="revisedSeverity">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_revisedSeverity" class="form-group actions_revisedSeverity">
<input type="text" data-table="actions" data-field="x_revisedSeverity" name="x<?php echo $actions_grid->RowIndex ?>_revisedSeverity" id="x<?php echo $actions_grid->RowIndex ?>_revisedSeverity" size="3" placeholder="<?php echo HtmlEncode($actions_grid->revisedSeverity->getPlaceHolder()) ?>" value="<?php echo $actions_grid->revisedSeverity->EditValue ?>"<?php echo $actions_grid->revisedSeverity->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_revisedSeverity" class="form-group actions_revisedSeverity">
<span<?php echo $actions_grid->revisedSeverity->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->revisedSeverity->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_revisedSeverity" name="x<?php echo $actions_grid->RowIndex ?>_revisedSeverity" id="x<?php echo $actions_grid->RowIndex ?>_revisedSeverity" value="<?php echo HtmlEncode($actions_grid->revisedSeverity->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_revisedSeverity" name="o<?php echo $actions_grid->RowIndex ?>_revisedSeverity" id="o<?php echo $actions_grid->RowIndex ?>_revisedSeverity" value="<?php echo HtmlEncode($actions_grid->revisedSeverity->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->revisedOccurrence->Visible) { // revisedOccurrence ?>
		<td data-name="revisedOccurrence">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_revisedOccurrence" class="form-group actions_revisedOccurrence">
<input type="text" data-table="actions" data-field="x_revisedOccurrence" name="x<?php echo $actions_grid->RowIndex ?>_revisedOccurrence" id="x<?php echo $actions_grid->RowIndex ?>_revisedOccurrence" size="3" placeholder="<?php echo HtmlEncode($actions_grid->revisedOccurrence->getPlaceHolder()) ?>" value="<?php echo $actions_grid->revisedOccurrence->EditValue ?>"<?php echo $actions_grid->revisedOccurrence->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_revisedOccurrence" class="form-group actions_revisedOccurrence">
<span<?php echo $actions_grid->revisedOccurrence->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->revisedOccurrence->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_revisedOccurrence" name="x<?php echo $actions_grid->RowIndex ?>_revisedOccurrence" id="x<?php echo $actions_grid->RowIndex ?>_revisedOccurrence" value="<?php echo HtmlEncode($actions_grid->revisedOccurrence->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_revisedOccurrence" name="o<?php echo $actions_grid->RowIndex ?>_revisedOccurrence" id="o<?php echo $actions_grid->RowIndex ?>_revisedOccurrence" value="<?php echo HtmlEncode($actions_grid->revisedOccurrence->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->revisedDetection->Visible) { // revisedDetection ?>
		<td data-name="revisedDetection">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_revisedDetection" class="form-group actions_revisedDetection">
<input type="text" data-table="actions" data-field="x_revisedDetection" name="x<?php echo $actions_grid->RowIndex ?>_revisedDetection" id="x<?php echo $actions_grid->RowIndex ?>_revisedDetection" size="3" placeholder="<?php echo HtmlEncode($actions_grid->revisedDetection->getPlaceHolder()) ?>" value="<?php echo $actions_grid->revisedDetection->EditValue ?>"<?php echo $actions_grid->revisedDetection->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_revisedDetection" class="form-group actions_revisedDetection">
<span<?php echo $actions_grid->revisedDetection->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->revisedDetection->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_revisedDetection" name="x<?php echo $actions_grid->RowIndex ?>_revisedDetection" id="x<?php echo $actions_grid->RowIndex ?>_revisedDetection" value="<?php echo HtmlEncode($actions_grid->revisedDetection->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_revisedDetection" name="o<?php echo $actions_grid->RowIndex ?>_revisedDetection" id="o<?php echo $actions_grid->RowIndex ?>_revisedDetection" value="<?php echo HtmlEncode($actions_grid->revisedDetection->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_grid->revisedRPNCalc->Visible) { // revisedRPNCalc ?>
		<td data-name="revisedRPNCalc">
<?php if (!$actions->isConfirm()) { ?>
<span id="el$rowindex$_actions_revisedRPNCalc" class="form-group actions_revisedRPNCalc">
<input type="text" data-table="actions" data-field="x_revisedRPNCalc" name="x<?php echo $actions_grid->RowIndex ?>_revisedRPNCalc" id="x<?php echo $actions_grid->RowIndex ?>_revisedRPNCalc" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_grid->revisedRPNCalc->getPlaceHolder()) ?>" value="<?php echo $actions_grid->revisedRPNCalc->EditValue ?>"<?php echo $actions_grid->revisedRPNCalc->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_actions_revisedRPNCalc" class="form-group actions_revisedRPNCalc">
<span<?php echo $actions_grid->revisedRPNCalc->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_grid->revisedRPNCalc->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="actions" data-field="x_revisedRPNCalc" name="x<?php echo $actions_grid->RowIndex ?>_revisedRPNCalc" id="x<?php echo $actions_grid->RowIndex ?>_revisedRPNCalc" value="<?php echo HtmlEncode($actions_grid->revisedRPNCalc->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_revisedRPNCalc" name="o<?php echo $actions_grid->RowIndex ?>_revisedRPNCalc" id="o<?php echo $actions_grid->RowIndex ?>_revisedRPNCalc" value="<?php echo HtmlEncode($actions_grid->revisedRPNCalc->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$actions_grid->ListOptions->render("body", "right", $actions_grid->RowIndex);
?>
<script>
loadjs.ready(["factionsgrid", "load"], function() {
	factionsgrid.updateLists(<?php echo $actions_grid->RowIndex ?>);
});
</script>
	</tr>
<?php
	}
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($actions->CurrentMode == "add" || $actions->CurrentMode == "copy") { ?>
<input type="hidden" name="<?php echo $actions_grid->FormKeyCountName ?>" id="<?php echo $actions_grid->FormKeyCountName ?>" value="<?php echo $actions_grid->KeyCount ?>">
<?php echo $actions_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($actions->CurrentMode == "edit") { ?>
<input type="hidden" name="<?php echo $actions_grid->FormKeyCountName ?>" id="<?php echo $actions_grid->FormKeyCountName ?>" value="<?php echo $actions_grid->KeyCount ?>">
<?php echo $actions_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($actions->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="factionsgrid">
</div><!-- /.ew-list-form -->
<?php

// Close recordset
if ($actions_grid->Recordset)
	$actions_grid->Recordset->Close();
?>
<?php if ($actions_grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $actions_grid->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($actions_grid->TotalRecords == 0 && !$actions->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $actions_grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if (!$actions_grid->isExport()) { ?>
<script>
loadjs.ready("load", function() {

	// Startup script
	// Write your table-specific startup script here
	// console.log("page loaded");

});
</script>
<?php } ?>
<?php
$actions_grid->terminate();
?>