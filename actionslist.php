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
$actions_list = new actions_list();

// Run the page
$actions_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$actions_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$actions_list->isExport()) { ?>
<script>
var factionslist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	factionslist = currentForm = new ew.Form("factionslist", "list");
	factionslist.formKeyCountName = '<?php echo $actions_list->FormKeyCountName ?>';

	// Validate form
	factionslist.validate = function() {
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
			<?php if ($actions_list->idProcess->Required) { ?>
				elm = this.getElements("x" + infix + "_idProcess");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->idProcess->caption(), $actions_list->idProcess->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_idProcess");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_list->idProcess->errorMessage()) ?>");
			<?php if ($actions_list->idCause->Required) { ?>
				elm = this.getElements("x" + infix + "_idCause");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->idCause->caption(), $actions_list->idCause->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_list->potentialCauses->Required) { ?>
				elm = this.getElements("x" + infix + "_potentialCauses");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->potentialCauses->caption(), $actions_list->potentialCauses->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_list->currentPreventiveControlMethod->Required) { ?>
				elm = this.getElements("x" + infix + "_currentPreventiveControlMethod");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->currentPreventiveControlMethod->caption(), $actions_list->currentPreventiveControlMethod->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_list->severity->Required) { ?>
				elm = this.getElements("x" + infix + "_severity");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->severity->caption(), $actions_list->severity->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_list->occurrence->Required) { ?>
				elm = this.getElements("x" + infix + "_occurrence");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->occurrence->caption(), $actions_list->occurrence->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_occurrence");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_list->occurrence->errorMessage()) ?>");
			<?php if ($actions_list->currentControlMethod->Required) { ?>
				elm = this.getElements("x" + infix + "_currentControlMethod");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->currentControlMethod->caption(), $actions_list->currentControlMethod->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_list->detection->Required) { ?>
				elm = this.getElements("x" + infix + "_detection");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->detection->caption(), $actions_list->detection->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_detection");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_list->detection->errorMessage()) ?>");
			<?php if ($actions_list->RPNCalc->Required) { ?>
				elm = this.getElements("x" + infix + "_RPNCalc");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->RPNCalc->caption(), $actions_list->RPNCalc->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_list->recomendedAction->Required) { ?>
				elm = this.getElements("x" + infix + "_recomendedAction");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->recomendedAction->caption(), $actions_list->recomendedAction->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_list->idResponsible->Required) { ?>
				elm = this.getElements("x" + infix + "_idResponsible[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->idResponsible->caption(), $actions_list->idResponsible->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_list->targetDate->Required) { ?>
				elm = this.getElements("x" + infix + "_targetDate");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->targetDate->caption(), $actions_list->targetDate->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_targetDate");
				if (elm && !ew.checkShortEuroDate(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_list->targetDate->errorMessage()) ?>");
			<?php if ($actions_list->revisedKc->Required) { ?>
				elm = this.getElements("x" + infix + "_revisedKc[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->revisedKc->caption(), $actions_list->revisedKc->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_list->expectedSeverity->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedSeverity");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->expectedSeverity->caption(), $actions_list->expectedSeverity->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_expectedSeverity");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_list->expectedSeverity->errorMessage()) ?>");
			<?php if ($actions_list->expectedOccurrence->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedOccurrence");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->expectedOccurrence->caption(), $actions_list->expectedOccurrence->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_expectedOccurrence");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_list->expectedOccurrence->errorMessage()) ?>");
			<?php if ($actions_list->expectedDetection->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedDetection");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->expectedDetection->caption(), $actions_list->expectedDetection->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_expectedDetection");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_list->expectedDetection->errorMessage()) ?>");
			<?php if ($actions_list->expectedRPNPAO->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedRPNPAO");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->expectedRPNPAO->caption(), $actions_list->expectedRPNPAO->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_list->expectedClosureDate->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedClosureDate");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->expectedClosureDate->caption(), $actions_list->expectedClosureDate->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_list->recomendedActiondet->Required) { ?>
				elm = this.getElements("x" + infix + "_recomendedActiondet");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->recomendedActiondet->caption(), $actions_list->recomendedActiondet->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_list->idResponsibleDet->Required) { ?>
				elm = this.getElements("x" + infix + "_idResponsibleDet[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->idResponsibleDet->caption(), $actions_list->idResponsibleDet->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_list->targetDatedet->Required) { ?>
				elm = this.getElements("x" + infix + "_targetDatedet");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->targetDatedet->caption(), $actions_list->targetDatedet->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_targetDatedet");
				if (elm && !ew.checkShortEuroDate(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_list->targetDatedet->errorMessage()) ?>");
			<?php if ($actions_list->kcdet->Required) { ?>
				elm = this.getElements("x" + infix + "_kcdet[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->kcdet->caption(), $actions_list->kcdet->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_list->expectedSeveritydet->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedSeveritydet");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->expectedSeveritydet->caption(), $actions_list->expectedSeveritydet->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_expectedSeveritydet");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_list->expectedSeveritydet->errorMessage()) ?>");
			<?php if ($actions_list->expectedOccurrencedet->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedOccurrencedet");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->expectedOccurrencedet->caption(), $actions_list->expectedOccurrencedet->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_expectedOccurrencedet");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_list->expectedOccurrencedet->errorMessage()) ?>");
			<?php if ($actions_list->expectedDetectiondet->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedDetectiondet");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->expectedDetectiondet->caption(), $actions_list->expectedDetectiondet->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_expectedDetectiondet");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_list->expectedDetectiondet->errorMessage()) ?>");
			<?php if ($actions_list->expectedRPNPAD->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedRPNPAD");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->expectedRPNPAD->caption(), $actions_list->expectedRPNPAD->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_list->revisedClosureDatedet->Required) { ?>
				elm = this.getElements("x" + infix + "_revisedClosureDatedet");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->revisedClosureDatedet->caption(), $actions_list->revisedClosureDatedet->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_revisedClosureDatedet");
				if (elm && !ew.checkShortEuroDate(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_list->revisedClosureDatedet->errorMessage()) ?>");
			<?php if ($actions_list->revisedSeverity->Required) { ?>
				elm = this.getElements("x" + infix + "_revisedSeverity");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->revisedSeverity->caption(), $actions_list->revisedSeverity->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_revisedSeverity");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_list->revisedSeverity->errorMessage()) ?>");
			<?php if ($actions_list->revisedOccurrence->Required) { ?>
				elm = this.getElements("x" + infix + "_revisedOccurrence");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->revisedOccurrence->caption(), $actions_list->revisedOccurrence->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_revisedOccurrence");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_list->revisedOccurrence->errorMessage()) ?>");
			<?php if ($actions_list->revisedDetection->Required) { ?>
				elm = this.getElements("x" + infix + "_revisedDetection");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->revisedDetection->caption(), $actions_list->revisedDetection->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_revisedDetection");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_list->revisedDetection->errorMessage()) ?>");
			<?php if ($actions_list->revisedRPNCalc->Required) { ?>
				elm = this.getElements("x" + infix + "_revisedRPNCalc");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_list->revisedRPNCalc->caption(), $actions_list->revisedRPNCalc->RequiredErrorMessage)) ?>");
			<?php } ?>

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
			} // End Grid Add checking
		}
		if (gridinsert && addcnt == 0) { // No row added
			ew.alert(ew.language.phrase("NoAddRecord"));
			return false;
		}
		return true;
	}

	// Check empty row
	factionslist.emptyRow = function(infix) {
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
	factionslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	factionslist.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	factionslist.lists["x_idCause"] = <?php echo $actions_list->idCause->Lookup->toClientList($actions_list) ?>;
	factionslist.lists["x_idCause"].options = <?php echo JsonEncode($actions_list->idCause->lookupOptions()) ?>;
	factionslist.lists["x_idResponsible[]"] = <?php echo $actions_list->idResponsible->Lookup->toClientList($actions_list) ?>;
	factionslist.lists["x_idResponsible[]"].options = <?php echo JsonEncode($actions_list->idResponsible->lookupOptions()) ?>;
	factionslist.lists["x_revisedKc[]"] = <?php echo $actions_list->revisedKc->Lookup->toClientList($actions_list) ?>;
	factionslist.lists["x_revisedKc[]"].options = <?php echo JsonEncode($actions_list->revisedKc->options(FALSE, TRUE)) ?>;
	factionslist.lists["x_idResponsibleDet[]"] = <?php echo $actions_list->idResponsibleDet->Lookup->toClientList($actions_list) ?>;
	factionslist.lists["x_idResponsibleDet[]"].options = <?php echo JsonEncode($actions_list->idResponsibleDet->lookupOptions()) ?>;
	factionslist.lists["x_kcdet[]"] = <?php echo $actions_list->kcdet->Lookup->toClientList($actions_list) ?>;
	factionslist.lists["x_kcdet[]"].options = <?php echo JsonEncode($actions_list->kcdet->options(FALSE, TRUE)) ?>;
	loadjs.done("factionslist");
});
var factionslistsrch;
loadjs.ready("head", function() {

	// Form object for search
	factionslistsrch = currentSearchForm = new ew.Form("factionslistsrch");

	// Dynamic selection lists
	// Filters

	factionslistsrch.filterList = <?php echo $actions_list->getFilterList() ?>;
	loadjs.done("factionslistsrch");
});
</script>
<style type="text/css">
.ew-table-preview-row { /* main table preview row color */
	background-color: #FFFFFF; /* preview row color */
}
.ew-table-preview-row .ew-grid {
	display: table;
}
</style>
<div id="ew-preview" class="d-none"><!-- preview -->
	<div class="ew-nav-tabs"><!-- .ew-nav-tabs -->
		<ul class="nav nav-tabs"></ul>
		<div class="tab-content"><!-- .tab-content -->
			<div class="tab-pane fade active show"></div>
		</div><!-- /.tab-content -->
	</div><!-- /.ew-nav-tabs -->
</div><!-- /preview -->
<script>
loadjs.ready("head", function() {
	ew.PREVIEW_PLACEMENT = ew.CSS_FLIP ? "left" : "right";
	ew.PREVIEW_SINGLE_ROW = false;
	ew.PREVIEW_OVERLAY = true;
	loadjs("js/ewpreview.js", "preview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$actions_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($actions_list->TotalRecords > 0 && $actions_list->ExportOptions->visible()) { ?>
<?php $actions_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($actions_list->ImportOptions->visible()) { ?>
<?php $actions_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($actions_list->SearchOptions->visible()) { ?>
<?php $actions_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($actions_list->FilterOptions->visible()) { ?>
<?php $actions_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (!$actions_list->isExport() || Config("EXPORT_MASTER_RECORD") && $actions_list->isExport("print")) { ?>
<?php
if ($actions_list->DbMasterFilter != "" && $actions->getCurrentMasterTable() == "processf") {
	if ($actions_list->MasterRecordExists) {
		include_once "processfmaster.php";
	}
}
?>
<?php } ?>
<?php
$actions_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$actions_list->isExport() && !$actions->CurrentAction) { ?>
<form name="factionslistsrch" id="factionslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="factionslistsrch-search-panel" class="<?php echo $actions_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="actions">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $actions_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($actions_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($actions_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $actions_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($actions_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($actions_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($actions_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($actions_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $actions_list->showPageHeader(); ?>
<?php
$actions_list->showMessage();
?>
<?php if ($actions_list->TotalRecords > 0 || $actions->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($actions_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> actions">
<?php if (!$actions_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$actions_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $actions_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $actions_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="factionslist" id="factionslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="actions">
<?php if ($actions->getCurrentMasterTable() == "processf" && $actions->CurrentAction) { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="processf">
<input type="hidden" name="fk_idProcess" value="<?php echo $actions_list->idProcess->getSessionValue() ?>">
<?php } ?>
<div id="gmp_actions" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($actions_list->TotalRecords > 0 || $actions_list->isAdd() || $actions_list->isCopy() || $actions_list->isGridEdit()) { ?>
<table id="tbl_actionslist" class="table ew-table d-none"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$actions->RowType = ROWTYPE_HEADER;

// Render list options
$actions_list->renderListOptions();

// Render list options (header, left)
$actions_list->ListOptions->render("header", "left", "", "block", $actions->TableVar, "actionslist");
?>
<?php if ($actions_list->idProcess->Visible) { // idProcess ?>
	<?php if ($actions_list->SortUrl($actions_list->idProcess) == "") { ?>
		<th data-name="idProcess" class="<?php echo $actions_list->idProcess->headerCellClass() ?>"><div id="elh_actions_idProcess" class="actions_idProcess"><div class="ew-table-header-caption"><script id="tpc_actions_idProcess" type="text/html"><?php echo $actions_list->idProcess->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="idProcess" class="<?php echo $actions_list->idProcess->headerCellClass() ?>"><script id="tpc_actions_idProcess" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->idProcess) ?>', 2);"><div id="elh_actions_idProcess" class="actions_idProcess">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->idProcess->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->idProcess->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->idProcess->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->idCause->Visible) { // idCause ?>
	<?php if ($actions_list->SortUrl($actions_list->idCause) == "") { ?>
		<th data-name="idCause" class="<?php echo $actions_list->idCause->headerCellClass() ?>"><div id="elh_actions_idCause" class="actions_idCause"><div class="ew-table-header-caption"><script id="tpc_actions_idCause" type="text/html"><?php echo $actions_list->idCause->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="idCause" class="<?php echo $actions_list->idCause->headerCellClass() ?>"><script id="tpc_actions_idCause" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->idCause) ?>', 2);"><div id="elh_actions_idCause" class="actions_idCause">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->idCause->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_list->idCause->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->idCause->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->potentialCauses->Visible) { // potentialCauses ?>
	<?php if ($actions_list->SortUrl($actions_list->potentialCauses) == "") { ?>
		<th data-name="potentialCauses" class="<?php echo $actions_list->potentialCauses->headerCellClass() ?>"><div id="elh_actions_potentialCauses" class="actions_potentialCauses"><div class="ew-table-header-caption"><script id="tpc_actions_potentialCauses" type="text/html"><?php echo $actions_list->potentialCauses->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="potentialCauses" class="<?php echo $actions_list->potentialCauses->headerCellClass() ?>"><script id="tpc_actions_potentialCauses" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->potentialCauses) ?>', 2);"><div id="elh_actions_potentialCauses" class="actions_potentialCauses">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->potentialCauses->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->potentialCauses->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->potentialCauses->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->currentPreventiveControlMethod->Visible) { // currentPreventiveControlMethod ?>
	<?php if ($actions_list->SortUrl($actions_list->currentPreventiveControlMethod) == "") { ?>
		<th data-name="currentPreventiveControlMethod" class="<?php echo $actions_list->currentPreventiveControlMethod->headerCellClass() ?>"><div id="elh_actions_currentPreventiveControlMethod" class="actions_currentPreventiveControlMethod"><div class="ew-table-header-caption"><script id="tpc_actions_currentPreventiveControlMethod" type="text/html"><?php echo $actions_list->currentPreventiveControlMethod->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="currentPreventiveControlMethod" class="<?php echo $actions_list->currentPreventiveControlMethod->headerCellClass() ?>"><script id="tpc_actions_currentPreventiveControlMethod" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->currentPreventiveControlMethod) ?>', 2);"><div id="elh_actions_currentPreventiveControlMethod" class="actions_currentPreventiveControlMethod">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->currentPreventiveControlMethod->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->currentPreventiveControlMethod->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->currentPreventiveControlMethod->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->severity->Visible) { // severity ?>
	<?php if ($actions_list->SortUrl($actions_list->severity) == "") { ?>
		<th data-name="severity" class="<?php echo $actions_list->severity->headerCellClass() ?>"><div id="elh_actions_severity" class="actions_severity"><div class="ew-table-header-caption"><script id="tpc_actions_severity" type="text/html"><?php echo $actions_list->severity->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="severity" class="<?php echo $actions_list->severity->headerCellClass() ?>"><script id="tpc_actions_severity" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->severity) ?>', 2);"><div id="elh_actions_severity" class="actions_severity">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->severity->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_list->severity->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->severity->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->occurrence->Visible) { // occurrence ?>
	<?php if ($actions_list->SortUrl($actions_list->occurrence) == "") { ?>
		<th data-name="occurrence" class="<?php echo $actions_list->occurrence->headerCellClass() ?>"><div id="elh_actions_occurrence" class="actions_occurrence"><div class="ew-table-header-caption"><script id="tpc_actions_occurrence" type="text/html"><?php echo $actions_list->occurrence->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="occurrence" class="<?php echo $actions_list->occurrence->headerCellClass() ?>"><script id="tpc_actions_occurrence" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->occurrence) ?>', 2);"><div id="elh_actions_occurrence" class="actions_occurrence">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->occurrence->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->occurrence->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->occurrence->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->currentControlMethod->Visible) { // currentControlMethod ?>
	<?php if ($actions_list->SortUrl($actions_list->currentControlMethod) == "") { ?>
		<th data-name="currentControlMethod" class="<?php echo $actions_list->currentControlMethod->headerCellClass() ?>"><div id="elh_actions_currentControlMethod" class="actions_currentControlMethod"><div class="ew-table-header-caption"><script id="tpc_actions_currentControlMethod" type="text/html"><?php echo $actions_list->currentControlMethod->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="currentControlMethod" class="<?php echo $actions_list->currentControlMethod->headerCellClass() ?>"><script id="tpc_actions_currentControlMethod" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->currentControlMethod) ?>', 2);"><div id="elh_actions_currentControlMethod" class="actions_currentControlMethod">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->currentControlMethod->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->currentControlMethod->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->currentControlMethod->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->detection->Visible) { // detection ?>
	<?php if ($actions_list->SortUrl($actions_list->detection) == "") { ?>
		<th data-name="detection" class="<?php echo $actions_list->detection->headerCellClass() ?>"><div id="elh_actions_detection" class="actions_detection"><div class="ew-table-header-caption"><script id="tpc_actions_detection" type="text/html"><?php echo $actions_list->detection->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="detection" class="<?php echo $actions_list->detection->headerCellClass() ?>"><script id="tpc_actions_detection" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->detection) ?>', 2);"><div id="elh_actions_detection" class="actions_detection">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->detection->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->detection->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->detection->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->RPNCalc->Visible) { // RPNCalc ?>
	<?php if ($actions_list->SortUrl($actions_list->RPNCalc) == "") { ?>
		<th data-name="RPNCalc" class="<?php echo $actions_list->RPNCalc->headerCellClass() ?>"><div id="elh_actions_RPNCalc" class="actions_RPNCalc"><div class="ew-table-header-caption"><script id="tpc_actions_RPNCalc" type="text/html"><?php echo $actions_list->RPNCalc->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="RPNCalc" class="<?php echo $actions_list->RPNCalc->headerCellClass() ?>"><script id="tpc_actions_RPNCalc" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->RPNCalc) ?>', 2);"><div id="elh_actions_RPNCalc" class="actions_RPNCalc">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->RPNCalc->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->RPNCalc->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->RPNCalc->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->recomendedAction->Visible) { // recomendedAction ?>
	<?php if ($actions_list->SortUrl($actions_list->recomendedAction) == "") { ?>
		<th data-name="recomendedAction" class="<?php echo $actions_list->recomendedAction->headerCellClass() ?>"><div id="elh_actions_recomendedAction" class="actions_recomendedAction"><div class="ew-table-header-caption"><script id="tpc_actions_recomendedAction" type="text/html"><?php echo $actions_list->recomendedAction->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="recomendedAction" class="<?php echo $actions_list->recomendedAction->headerCellClass() ?>"><script id="tpc_actions_recomendedAction" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->recomendedAction) ?>', 2);"><div id="elh_actions_recomendedAction" class="actions_recomendedAction">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->recomendedAction->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->recomendedAction->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->recomendedAction->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->idResponsible->Visible) { // idResponsible ?>
	<?php if ($actions_list->SortUrl($actions_list->idResponsible) == "") { ?>
		<th data-name="idResponsible" class="<?php echo $actions_list->idResponsible->headerCellClass() ?>"><div id="elh_actions_idResponsible" class="actions_idResponsible"><div class="ew-table-header-caption"><script id="tpc_actions_idResponsible" type="text/html"><?php echo $actions_list->idResponsible->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="idResponsible" class="<?php echo $actions_list->idResponsible->headerCellClass() ?>"><script id="tpc_actions_idResponsible" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->idResponsible) ?>', 2);"><div id="elh_actions_idResponsible" class="actions_idResponsible">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->idResponsible->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_list->idResponsible->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->idResponsible->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->targetDate->Visible) { // targetDate ?>
	<?php if ($actions_list->SortUrl($actions_list->targetDate) == "") { ?>
		<th data-name="targetDate" class="<?php echo $actions_list->targetDate->headerCellClass() ?>"><div id="elh_actions_targetDate" class="actions_targetDate"><div class="ew-table-header-caption"><script id="tpc_actions_targetDate" type="text/html"><?php echo $actions_list->targetDate->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="targetDate" class="<?php echo $actions_list->targetDate->headerCellClass() ?>"><script id="tpc_actions_targetDate" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->targetDate) ?>', 2);"><div id="elh_actions_targetDate" class="actions_targetDate">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->targetDate->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->targetDate->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->targetDate->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->revisedKc->Visible) { // revisedKc ?>
	<?php if ($actions_list->SortUrl($actions_list->revisedKc) == "") { ?>
		<th data-name="revisedKc" class="<?php echo $actions_list->revisedKc->headerCellClass() ?>"><div id="elh_actions_revisedKc" class="actions_revisedKc"><div class="ew-table-header-caption"><script id="tpc_actions_revisedKc" type="text/html"><?php echo $actions_list->revisedKc->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="revisedKc" class="<?php echo $actions_list->revisedKc->headerCellClass() ?>"><script id="tpc_actions_revisedKc" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->revisedKc) ?>', 2);"><div id="elh_actions_revisedKc" class="actions_revisedKc">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->revisedKc->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->revisedKc->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->revisedKc->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->expectedSeverity->Visible) { // expectedSeverity ?>
	<?php if ($actions_list->SortUrl($actions_list->expectedSeverity) == "") { ?>
		<th data-name="expectedSeverity" class="<?php echo $actions_list->expectedSeverity->headerCellClass() ?>"><div id="elh_actions_expectedSeverity" class="actions_expectedSeverity"><div class="ew-table-header-caption"><script id="tpc_actions_expectedSeverity" type="text/html"><?php echo $actions_list->expectedSeverity->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="expectedSeverity" class="<?php echo $actions_list->expectedSeverity->headerCellClass() ?>"><script id="tpc_actions_expectedSeverity" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->expectedSeverity) ?>', 2);"><div id="elh_actions_expectedSeverity" class="actions_expectedSeverity">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->expectedSeverity->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->expectedSeverity->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->expectedSeverity->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->expectedOccurrence->Visible) { // expectedOccurrence ?>
	<?php if ($actions_list->SortUrl($actions_list->expectedOccurrence) == "") { ?>
		<th data-name="expectedOccurrence" class="<?php echo $actions_list->expectedOccurrence->headerCellClass() ?>"><div id="elh_actions_expectedOccurrence" class="actions_expectedOccurrence"><div class="ew-table-header-caption"><script id="tpc_actions_expectedOccurrence" type="text/html"><?php echo $actions_list->expectedOccurrence->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="expectedOccurrence" class="<?php echo $actions_list->expectedOccurrence->headerCellClass() ?>"><script id="tpc_actions_expectedOccurrence" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->expectedOccurrence) ?>', 2);"><div id="elh_actions_expectedOccurrence" class="actions_expectedOccurrence">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->expectedOccurrence->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->expectedOccurrence->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->expectedOccurrence->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->expectedDetection->Visible) { // expectedDetection ?>
	<?php if ($actions_list->SortUrl($actions_list->expectedDetection) == "") { ?>
		<th data-name="expectedDetection" class="<?php echo $actions_list->expectedDetection->headerCellClass() ?>"><div id="elh_actions_expectedDetection" class="actions_expectedDetection"><div class="ew-table-header-caption"><script id="tpc_actions_expectedDetection" type="text/html"><?php echo $actions_list->expectedDetection->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="expectedDetection" class="<?php echo $actions_list->expectedDetection->headerCellClass() ?>"><script id="tpc_actions_expectedDetection" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->expectedDetection) ?>', 2);"><div id="elh_actions_expectedDetection" class="actions_expectedDetection">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->expectedDetection->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->expectedDetection->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->expectedDetection->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->expectedRPNPAO->Visible) { // expectedRPNPAO ?>
	<?php if ($actions_list->SortUrl($actions_list->expectedRPNPAO) == "") { ?>
		<th data-name="expectedRPNPAO" class="<?php echo $actions_list->expectedRPNPAO->headerCellClass() ?>"><div id="elh_actions_expectedRPNPAO" class="actions_expectedRPNPAO"><div class="ew-table-header-caption"><script id="tpc_actions_expectedRPNPAO" type="text/html"><?php echo $actions_list->expectedRPNPAO->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="expectedRPNPAO" class="<?php echo $actions_list->expectedRPNPAO->headerCellClass() ?>"><script id="tpc_actions_expectedRPNPAO" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->expectedRPNPAO) ?>', 2);"><div id="elh_actions_expectedRPNPAO" class="actions_expectedRPNPAO">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->expectedRPNPAO->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->expectedRPNPAO->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->expectedRPNPAO->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->expectedClosureDate->Visible) { // expectedClosureDate ?>
	<?php if ($actions_list->SortUrl($actions_list->expectedClosureDate) == "") { ?>
		<th data-name="expectedClosureDate" class="<?php echo $actions_list->expectedClosureDate->headerCellClass() ?>"><div id="elh_actions_expectedClosureDate" class="actions_expectedClosureDate"><div class="ew-table-header-caption"><script id="tpc_actions_expectedClosureDate" type="text/html"><?php echo $actions_list->expectedClosureDate->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="expectedClosureDate" class="<?php echo $actions_list->expectedClosureDate->headerCellClass() ?>"><script id="tpc_actions_expectedClosureDate" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->expectedClosureDate) ?>', 2);"><div id="elh_actions_expectedClosureDate" class="actions_expectedClosureDate">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->expectedClosureDate->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->expectedClosureDate->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->expectedClosureDate->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->recomendedActiondet->Visible) { // recomendedActiondet ?>
	<?php if ($actions_list->SortUrl($actions_list->recomendedActiondet) == "") { ?>
		<th data-name="recomendedActiondet" class="<?php echo $actions_list->recomendedActiondet->headerCellClass() ?>"><div id="elh_actions_recomendedActiondet" class="actions_recomendedActiondet"><div class="ew-table-header-caption"><script id="tpc_actions_recomendedActiondet" type="text/html"><?php echo $actions_list->recomendedActiondet->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="recomendedActiondet" class="<?php echo $actions_list->recomendedActiondet->headerCellClass() ?>"><script id="tpc_actions_recomendedActiondet" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->recomendedActiondet) ?>', 2);"><div id="elh_actions_recomendedActiondet" class="actions_recomendedActiondet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->recomendedActiondet->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->recomendedActiondet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->recomendedActiondet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->idResponsibleDet->Visible) { // idResponsibleDet ?>
	<?php if ($actions_list->SortUrl($actions_list->idResponsibleDet) == "") { ?>
		<th data-name="idResponsibleDet" class="<?php echo $actions_list->idResponsibleDet->headerCellClass() ?>"><div id="elh_actions_idResponsibleDet" class="actions_idResponsibleDet"><div class="ew-table-header-caption"><script id="tpc_actions_idResponsibleDet" type="text/html"><?php echo $actions_list->idResponsibleDet->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="idResponsibleDet" class="<?php echo $actions_list->idResponsibleDet->headerCellClass() ?>"><script id="tpc_actions_idResponsibleDet" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->idResponsibleDet) ?>', 2);"><div id="elh_actions_idResponsibleDet" class="actions_idResponsibleDet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->idResponsibleDet->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_list->idResponsibleDet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->idResponsibleDet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->targetDatedet->Visible) { // targetDatedet ?>
	<?php if ($actions_list->SortUrl($actions_list->targetDatedet) == "") { ?>
		<th data-name="targetDatedet" class="<?php echo $actions_list->targetDatedet->headerCellClass() ?>"><div id="elh_actions_targetDatedet" class="actions_targetDatedet"><div class="ew-table-header-caption"><script id="tpc_actions_targetDatedet" type="text/html"><?php echo $actions_list->targetDatedet->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="targetDatedet" class="<?php echo $actions_list->targetDatedet->headerCellClass() ?>"><script id="tpc_actions_targetDatedet" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->targetDatedet) ?>', 2);"><div id="elh_actions_targetDatedet" class="actions_targetDatedet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->targetDatedet->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->targetDatedet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->targetDatedet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->kcdet->Visible) { // kcdet ?>
	<?php if ($actions_list->SortUrl($actions_list->kcdet) == "") { ?>
		<th data-name="kcdet" class="<?php echo $actions_list->kcdet->headerCellClass() ?>"><div id="elh_actions_kcdet" class="actions_kcdet"><div class="ew-table-header-caption"><script id="tpc_actions_kcdet" type="text/html"><?php echo $actions_list->kcdet->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="kcdet" class="<?php echo $actions_list->kcdet->headerCellClass() ?>"><script id="tpc_actions_kcdet" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->kcdet) ?>', 2);"><div id="elh_actions_kcdet" class="actions_kcdet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->kcdet->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->kcdet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->kcdet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->expectedSeveritydet->Visible) { // expectedSeveritydet ?>
	<?php if ($actions_list->SortUrl($actions_list->expectedSeveritydet) == "") { ?>
		<th data-name="expectedSeveritydet" class="<?php echo $actions_list->expectedSeveritydet->headerCellClass() ?>"><div id="elh_actions_expectedSeveritydet" class="actions_expectedSeveritydet"><div class="ew-table-header-caption"><script id="tpc_actions_expectedSeveritydet" type="text/html"><?php echo $actions_list->expectedSeveritydet->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="expectedSeveritydet" class="<?php echo $actions_list->expectedSeveritydet->headerCellClass() ?>"><script id="tpc_actions_expectedSeveritydet" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->expectedSeveritydet) ?>', 2);"><div id="elh_actions_expectedSeveritydet" class="actions_expectedSeveritydet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->expectedSeveritydet->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->expectedSeveritydet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->expectedSeveritydet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->expectedOccurrencedet->Visible) { // expectedOccurrencedet ?>
	<?php if ($actions_list->SortUrl($actions_list->expectedOccurrencedet) == "") { ?>
		<th data-name="expectedOccurrencedet" class="<?php echo $actions_list->expectedOccurrencedet->headerCellClass() ?>"><div id="elh_actions_expectedOccurrencedet" class="actions_expectedOccurrencedet"><div class="ew-table-header-caption"><script id="tpc_actions_expectedOccurrencedet" type="text/html"><?php echo $actions_list->expectedOccurrencedet->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="expectedOccurrencedet" class="<?php echo $actions_list->expectedOccurrencedet->headerCellClass() ?>"><script id="tpc_actions_expectedOccurrencedet" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->expectedOccurrencedet) ?>', 2);"><div id="elh_actions_expectedOccurrencedet" class="actions_expectedOccurrencedet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->expectedOccurrencedet->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->expectedOccurrencedet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->expectedOccurrencedet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->expectedDetectiondet->Visible) { // expectedDetectiondet ?>
	<?php if ($actions_list->SortUrl($actions_list->expectedDetectiondet) == "") { ?>
		<th data-name="expectedDetectiondet" class="<?php echo $actions_list->expectedDetectiondet->headerCellClass() ?>"><div id="elh_actions_expectedDetectiondet" class="actions_expectedDetectiondet"><div class="ew-table-header-caption"><script id="tpc_actions_expectedDetectiondet" type="text/html"><?php echo $actions_list->expectedDetectiondet->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="expectedDetectiondet" class="<?php echo $actions_list->expectedDetectiondet->headerCellClass() ?>"><script id="tpc_actions_expectedDetectiondet" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->expectedDetectiondet) ?>', 2);"><div id="elh_actions_expectedDetectiondet" class="actions_expectedDetectiondet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->expectedDetectiondet->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->expectedDetectiondet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->expectedDetectiondet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->expectedRPNPAD->Visible) { // expectedRPNPAD ?>
	<?php if ($actions_list->SortUrl($actions_list->expectedRPNPAD) == "") { ?>
		<th data-name="expectedRPNPAD" class="<?php echo $actions_list->expectedRPNPAD->headerCellClass() ?>"><div id="elh_actions_expectedRPNPAD" class="actions_expectedRPNPAD"><div class="ew-table-header-caption"><script id="tpc_actions_expectedRPNPAD" type="text/html"><?php echo $actions_list->expectedRPNPAD->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="expectedRPNPAD" class="<?php echo $actions_list->expectedRPNPAD->headerCellClass() ?>"><script id="tpc_actions_expectedRPNPAD" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->expectedRPNPAD) ?>', 2);"><div id="elh_actions_expectedRPNPAD" class="actions_expectedRPNPAD">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->expectedRPNPAD->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->expectedRPNPAD->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->expectedRPNPAD->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->revisedClosureDatedet->Visible) { // revisedClosureDatedet ?>
	<?php if ($actions_list->SortUrl($actions_list->revisedClosureDatedet) == "") { ?>
		<th data-name="revisedClosureDatedet" class="<?php echo $actions_list->revisedClosureDatedet->headerCellClass() ?>"><div id="elh_actions_revisedClosureDatedet" class="actions_revisedClosureDatedet"><div class="ew-table-header-caption"><script id="tpc_actions_revisedClosureDatedet" type="text/html"><?php echo $actions_list->revisedClosureDatedet->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="revisedClosureDatedet" class="<?php echo $actions_list->revisedClosureDatedet->headerCellClass() ?>"><script id="tpc_actions_revisedClosureDatedet" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->revisedClosureDatedet) ?>', 2);"><div id="elh_actions_revisedClosureDatedet" class="actions_revisedClosureDatedet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->revisedClosureDatedet->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->revisedClosureDatedet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->revisedClosureDatedet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->revisedSeverity->Visible) { // revisedSeverity ?>
	<?php if ($actions_list->SortUrl($actions_list->revisedSeverity) == "") { ?>
		<th data-name="revisedSeverity" class="<?php echo $actions_list->revisedSeverity->headerCellClass() ?>"><div id="elh_actions_revisedSeverity" class="actions_revisedSeverity"><div class="ew-table-header-caption"><script id="tpc_actions_revisedSeverity" type="text/html"><?php echo $actions_list->revisedSeverity->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="revisedSeverity" class="<?php echo $actions_list->revisedSeverity->headerCellClass() ?>"><script id="tpc_actions_revisedSeverity" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->revisedSeverity) ?>', 2);"><div id="elh_actions_revisedSeverity" class="actions_revisedSeverity">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->revisedSeverity->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->revisedSeverity->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->revisedSeverity->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->revisedOccurrence->Visible) { // revisedOccurrence ?>
	<?php if ($actions_list->SortUrl($actions_list->revisedOccurrence) == "") { ?>
		<th data-name="revisedOccurrence" class="<?php echo $actions_list->revisedOccurrence->headerCellClass() ?>"><div id="elh_actions_revisedOccurrence" class="actions_revisedOccurrence"><div class="ew-table-header-caption"><script id="tpc_actions_revisedOccurrence" type="text/html"><?php echo $actions_list->revisedOccurrence->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="revisedOccurrence" class="<?php echo $actions_list->revisedOccurrence->headerCellClass() ?>"><script id="tpc_actions_revisedOccurrence" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->revisedOccurrence) ?>', 2);"><div id="elh_actions_revisedOccurrence" class="actions_revisedOccurrence">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->revisedOccurrence->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->revisedOccurrence->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->revisedOccurrence->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->revisedDetection->Visible) { // revisedDetection ?>
	<?php if ($actions_list->SortUrl($actions_list->revisedDetection) == "") { ?>
		<th data-name="revisedDetection" class="<?php echo $actions_list->revisedDetection->headerCellClass() ?>"><div id="elh_actions_revisedDetection" class="actions_revisedDetection"><div class="ew-table-header-caption"><script id="tpc_actions_revisedDetection" type="text/html"><?php echo $actions_list->revisedDetection->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="revisedDetection" class="<?php echo $actions_list->revisedDetection->headerCellClass() ?>"><script id="tpc_actions_revisedDetection" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->revisedDetection) ?>', 2);"><div id="elh_actions_revisedDetection" class="actions_revisedDetection">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->revisedDetection->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->revisedDetection->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->revisedDetection->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_list->revisedRPNCalc->Visible) { // revisedRPNCalc ?>
	<?php if ($actions_list->SortUrl($actions_list->revisedRPNCalc) == "") { ?>
		<th data-name="revisedRPNCalc" class="<?php echo $actions_list->revisedRPNCalc->headerCellClass() ?>"><div id="elh_actions_revisedRPNCalc" class="actions_revisedRPNCalc"><div class="ew-table-header-caption"><script id="tpc_actions_revisedRPNCalc" type="text/html"><?php echo $actions_list->revisedRPNCalc->caption() ?></script></div></div></th>
	<?php } else { ?>
		<th data-name="revisedRPNCalc" class="<?php echo $actions_list->revisedRPNCalc->headerCellClass() ?>"><script id="tpc_actions_revisedRPNCalc" type="text/html"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $actions_list->SortUrl($actions_list->revisedRPNCalc) ?>', 2);"><div id="elh_actions_revisedRPNCalc" class="actions_revisedRPNCalc">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_list->revisedRPNCalc->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($actions_list->revisedRPNCalc->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_list->revisedRPNCalc->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></script></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$actions_list->ListOptions->render("header", "right", "", "block", $actions->TableVar, "actionslist");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($actions_list->isAdd() || $actions_list->isCopy()) {
		$actions_list->RowIndex = 0;
		$actions_list->KeyCount = $actions_list->RowIndex;
		if ($actions_list->isAdd())
			$actions_list->loadRowValues();
		if ($actions->EventCancelled) // Insert failed
			$actions_list->restoreFormValues(); // Restore form values

		// Set row properties
		$actions->resetAttributes();
		$actions->RowAttrs->merge(["data-rowindex" => 0, "id" => "r0_actions", "data-rowtype" => ROWTYPE_ADD]);
		$actions->RowType = ROWTYPE_ADD;

		// Render row
		$actions_list->renderRow();

		// Render list options
		$actions_list->renderListOptions();
		$actions_list->StartRowCount = 0;
?>
	<tr <?php echo $actions->rowAttributes() ?>>
<?php

// Render list options (body, left)
$actions_list->ListOptions->render("body", "left", $actions_list->RowCount, "block", $actions->TableVar, "actionslist");
?>
	<?php if ($actions_list->idProcess->Visible) { // idProcess ?>
		<td data-name="idProcess">
<?php if ($actions_list->idProcess->getSessionValue() != "") { ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_idProcess" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_idProcess" class="form-group actions_idProcess">
<span<?php echo $actions_list->idProcess->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_list->idProcess->ViewValue)) ?>"></span>
</span></script>
<input type="hidden" id="x<?php echo $actions_list->RowIndex ?>_idProcess" name="x<?php echo $actions_list->RowIndex ?>_idProcess" value="<?php echo HtmlEncode($actions_list->idProcess->CurrentValue) ?>">
<?php } else { ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_idProcess" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_idProcess" class="form-group actions_idProcess">
<input type="text" data-table="actions" data-field="x_idProcess" name="x<?php echo $actions_list->RowIndex ?>_idProcess" id="x<?php echo $actions_list->RowIndex ?>_idProcess" size="30" placeholder="<?php echo HtmlEncode($actions_list->idProcess->getPlaceHolder()) ?>" value="<?php echo $actions_list->idProcess->EditValue ?>"<?php echo $actions_list->idProcess->editAttributes() ?>>
</span></script>
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_idProcess" name="o<?php echo $actions_list->RowIndex ?>_idProcess" id="o<?php echo $actions_list->RowIndex ?>_idProcess" value="<?php echo HtmlEncode($actions_list->idProcess->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->idCause->Visible) { // idCause ?>
		<td data-name="idCause">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_idCause" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_idCause" class="form-group actions_idCause">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="actions" data-field="x_idCause" data-value-separator="<?php echo $actions_list->idCause->displayValueSeparatorAttribute() ?>" id="x<?php echo $actions_list->RowIndex ?>_idCause" name="x<?php echo $actions_list->RowIndex ?>_idCause"<?php echo $actions_list->idCause->editAttributes() ?>>
			<?php echo $actions_list->idCause->selectOptionListHtml("x{$actions_list->RowIndex}_idCause") ?>
		</select>
</div>
<?php echo $actions_list->idCause->Lookup->getParamTag($actions_list, "p_x" . $actions_list->RowIndex . "_idCause") ?>
</span></script>
<input type="hidden" data-table="actions" data-field="x_idCause" name="o<?php echo $actions_list->RowIndex ?>_idCause" id="o<?php echo $actions_list->RowIndex ?>_idCause" value="<?php echo HtmlEncode($actions_list->idCause->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->potentialCauses->Visible) { // potentialCauses ?>
		<td data-name="potentialCauses">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_potentialCauses" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_potentialCauses" class="form-group actions_potentialCauses">
<textarea data-table="actions" data-field="x_potentialCauses" name="x<?php echo $actions_list->RowIndex ?>_potentialCauses" id="x<?php echo $actions_list->RowIndex ?>_potentialCauses" cols="35" rows="4" placeholder="<?php echo HtmlEncode($actions_list->potentialCauses->getPlaceHolder()) ?>"<?php echo $actions_list->potentialCauses->editAttributes() ?>><?php echo $actions_list->potentialCauses->EditValue ?></textarea>
</span></script>
<input type="hidden" data-table="actions" data-field="x_potentialCauses" name="o<?php echo $actions_list->RowIndex ?>_potentialCauses" id="o<?php echo $actions_list->RowIndex ?>_potentialCauses" value="<?php echo HtmlEncode($actions_list->potentialCauses->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->currentPreventiveControlMethod->Visible) { // currentPreventiveControlMethod ?>
		<td data-name="currentPreventiveControlMethod">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_currentPreventiveControlMethod" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_currentPreventiveControlMethod" class="form-group actions_currentPreventiveControlMethod">
<input type="text" data-table="actions" data-field="x_currentPreventiveControlMethod" name="x<?php echo $actions_list->RowIndex ?>_currentPreventiveControlMethod" id="x<?php echo $actions_list->RowIndex ?>_currentPreventiveControlMethod" size="7" maxlength="255" placeholder="<?php echo HtmlEncode($actions_list->currentPreventiveControlMethod->getPlaceHolder()) ?>" value="<?php echo $actions_list->currentPreventiveControlMethod->EditValue ?>"<?php echo $actions_list->currentPreventiveControlMethod->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_currentPreventiveControlMethod" name="o<?php echo $actions_list->RowIndex ?>_currentPreventiveControlMethod" id="o<?php echo $actions_list->RowIndex ?>_currentPreventiveControlMethod" value="<?php echo HtmlEncode($actions_list->currentPreventiveControlMethod->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->severity->Visible) { // severity ?>
		<td data-name="severity">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_severity" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_severity" class="form-group actions_severity">
<input type="text" data-table="actions" data-field="x_severity" name="x<?php echo $actions_list->RowIndex ?>_severity" id="x<?php echo $actions_list->RowIndex ?>_severity" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($actions_list->severity->getPlaceHolder()) ?>" value="<?php echo $actions_list->severity->EditValue ?>"<?php echo $actions_list->severity->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_severity" name="o<?php echo $actions_list->RowIndex ?>_severity" id="o<?php echo $actions_list->RowIndex ?>_severity" value="<?php echo HtmlEncode($actions_list->severity->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->occurrence->Visible) { // occurrence ?>
		<td data-name="occurrence">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_occurrence" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_occurrence" class="form-group actions_occurrence">
<input type="text" data-table="actions" data-field="x_occurrence" name="x<?php echo $actions_list->RowIndex ?>_occurrence" id="x<?php echo $actions_list->RowIndex ?>_occurrence" size="3" placeholder="<?php echo HtmlEncode($actions_list->occurrence->getPlaceHolder()) ?>" value="<?php echo $actions_list->occurrence->EditValue ?>"<?php echo $actions_list->occurrence->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_occurrence" name="o<?php echo $actions_list->RowIndex ?>_occurrence" id="o<?php echo $actions_list->RowIndex ?>_occurrence" value="<?php echo HtmlEncode($actions_list->occurrence->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->currentControlMethod->Visible) { // currentControlMethod ?>
		<td data-name="currentControlMethod">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_currentControlMethod" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_currentControlMethod" class="form-group actions_currentControlMethod">
<input type="text" data-table="actions" data-field="x_currentControlMethod" name="x<?php echo $actions_list->RowIndex ?>_currentControlMethod" id="x<?php echo $actions_list->RowIndex ?>_currentControlMethod" size="10" maxlength="255" placeholder="<?php echo HtmlEncode($actions_list->currentControlMethod->getPlaceHolder()) ?>" value="<?php echo $actions_list->currentControlMethod->EditValue ?>"<?php echo $actions_list->currentControlMethod->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_currentControlMethod" name="o<?php echo $actions_list->RowIndex ?>_currentControlMethod" id="o<?php echo $actions_list->RowIndex ?>_currentControlMethod" value="<?php echo HtmlEncode($actions_list->currentControlMethod->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->detection->Visible) { // detection ?>
		<td data-name="detection">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_detection" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_detection" class="form-group actions_detection">
<input type="text" data-table="actions" data-field="x_detection" name="x<?php echo $actions_list->RowIndex ?>_detection" id="x<?php echo $actions_list->RowIndex ?>_detection" size="3" placeholder="<?php echo HtmlEncode($actions_list->detection->getPlaceHolder()) ?>" value="<?php echo $actions_list->detection->EditValue ?>"<?php echo $actions_list->detection->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_detection" name="o<?php echo $actions_list->RowIndex ?>_detection" id="o<?php echo $actions_list->RowIndex ?>_detection" value="<?php echo HtmlEncode($actions_list->detection->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->RPNCalc->Visible) { // RPNCalc ?>
		<td data-name="RPNCalc">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_RPNCalc" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_RPNCalc" class="form-group actions_RPNCalc">
<input type="text" data-table="actions" data-field="x_RPNCalc" name="x<?php echo $actions_list->RowIndex ?>_RPNCalc" id="x<?php echo $actions_list->RowIndex ?>_RPNCalc" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_list->RPNCalc->getPlaceHolder()) ?>" value="<?php echo $actions_list->RPNCalc->EditValue ?>"<?php echo $actions_list->RPNCalc->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_RPNCalc" name="o<?php echo $actions_list->RowIndex ?>_RPNCalc" id="o<?php echo $actions_list->RowIndex ?>_RPNCalc" value="<?php echo HtmlEncode($actions_list->RPNCalc->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->recomendedAction->Visible) { // recomendedAction ?>
		<td data-name="recomendedAction">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_recomendedAction" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_recomendedAction" class="form-group actions_recomendedAction">
<textarea data-table="actions" data-field="x_recomendedAction" name="x<?php echo $actions_list->RowIndex ?>_recomendedAction" id="x<?php echo $actions_list->RowIndex ?>_recomendedAction" cols="10" rows="4" placeholder="<?php echo HtmlEncode($actions_list->recomendedAction->getPlaceHolder()) ?>"<?php echo $actions_list->recomendedAction->editAttributes() ?>><?php echo $actions_list->recomendedAction->EditValue ?></textarea>
</span></script>
<input type="hidden" data-table="actions" data-field="x_recomendedAction" name="o<?php echo $actions_list->RowIndex ?>_recomendedAction" id="o<?php echo $actions_list->RowIndex ?>_recomendedAction" value="<?php echo HtmlEncode($actions_list->recomendedAction->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->idResponsible->Visible) { // idResponsible ?>
		<td data-name="idResponsible">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_idResponsible" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_idResponsible" class="form-group actions_idResponsible">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $actions_list->RowIndex ?>_idResponsible"><?php echo EmptyValue(strval($actions_list->idResponsible->ViewValue)) ? $Language->phrase("PleaseSelect") : $actions_list->idResponsible->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($actions_list->idResponsible->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($actions_list->idResponsible->ReadOnly || $actions_list->idResponsible->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $actions_list->RowIndex ?>_idResponsible[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $actions_list->idResponsible->Lookup->getParamTag($actions_list, "p_x" . $actions_list->RowIndex . "_idResponsible") ?>
<input type="hidden" data-table="actions" data-field="x_idResponsible" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $actions_list->idResponsible->displayValueSeparatorAttribute() ?>" name="x<?php echo $actions_list->RowIndex ?>_idResponsible[]" id="x<?php echo $actions_list->RowIndex ?>_idResponsible[]" value="<?php echo $actions_list->idResponsible->CurrentValue ?>"<?php echo $actions_list->idResponsible->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_idResponsible" name="o<?php echo $actions_list->RowIndex ?>_idResponsible[]" id="o<?php echo $actions_list->RowIndex ?>_idResponsible[]" value="<?php echo HtmlEncode($actions_list->idResponsible->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->targetDate->Visible) { // targetDate ?>
		<td data-name="targetDate">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_targetDate" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_targetDate" class="form-group actions_targetDate">
<input type="text" data-table="actions" data-field="x_targetDate" data-format="14" name="x<?php echo $actions_list->RowIndex ?>_targetDate" id="x<?php echo $actions_list->RowIndex ?>_targetDate" size="7" placeholder="<?php echo HtmlEncode($actions_list->targetDate->getPlaceHolder()) ?>" value="<?php echo $actions_list->targetDate->EditValue ?>"<?php echo $actions_list->targetDate->editAttributes() ?>>
<?php if (!$actions_list->targetDate->ReadOnly && !$actions_list->targetDate->Disabled && !isset($actions_list->targetDate->EditAttrs["readonly"]) && !isset($actions_list->targetDate->EditAttrs["disabled"])) { ?>
<?php } ?>
</span></script>
<script type="text/html" class="actionslist_js">
loadjs.ready(["factionslist", "datetimepicker"], function() {
	ew.createDateTimePicker("factionslist", "x<?php echo $actions_list->RowIndex ?>_targetDate", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<input type="hidden" data-table="actions" data-field="x_targetDate" name="o<?php echo $actions_list->RowIndex ?>_targetDate" id="o<?php echo $actions_list->RowIndex ?>_targetDate" value="<?php echo HtmlEncode($actions_list->targetDate->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->revisedKc->Visible) { // revisedKc ?>
		<td data-name="revisedKc">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_revisedKc" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_revisedKc" class="form-group actions_revisedKc">
<?php
$selwrk = ConvertToBool($actions_list->revisedKc->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="actions" data-field="x_revisedKc" name="x<?php echo $actions_list->RowIndex ?>_revisedKc[]" id="x<?php echo $actions_list->RowIndex ?>_revisedKc[]" value="1"<?php echo $selwrk ?><?php echo $actions_list->revisedKc->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $actions_list->RowIndex ?>_revisedKc[]"></label>
</div>
</span></script>
<input type="hidden" data-table="actions" data-field="x_revisedKc" name="o<?php echo $actions_list->RowIndex ?>_revisedKc[]" id="o<?php echo $actions_list->RowIndex ?>_revisedKc[]" value="<?php echo HtmlEncode($actions_list->revisedKc->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->expectedSeverity->Visible) { // expectedSeverity ?>
		<td data-name="expectedSeverity">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedSeverity" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedSeverity" class="form-group actions_expectedSeverity">
<input type="text" data-table="actions" data-field="x_expectedSeverity" name="x<?php echo $actions_list->RowIndex ?>_expectedSeverity" id="x<?php echo $actions_list->RowIndex ?>_expectedSeverity" size="3" placeholder="<?php echo HtmlEncode($actions_list->expectedSeverity->getPlaceHolder()) ?>" value="<?php echo $actions_list->expectedSeverity->EditValue ?>"<?php echo $actions_list->expectedSeverity->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_expectedSeverity" name="o<?php echo $actions_list->RowIndex ?>_expectedSeverity" id="o<?php echo $actions_list->RowIndex ?>_expectedSeverity" value="<?php echo HtmlEncode($actions_list->expectedSeverity->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->expectedOccurrence->Visible) { // expectedOccurrence ?>
		<td data-name="expectedOccurrence">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedOccurrence" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedOccurrence" class="form-group actions_expectedOccurrence">
<input type="text" data-table="actions" data-field="x_expectedOccurrence" name="x<?php echo $actions_list->RowIndex ?>_expectedOccurrence" id="x<?php echo $actions_list->RowIndex ?>_expectedOccurrence" size="3" placeholder="<?php echo HtmlEncode($actions_list->expectedOccurrence->getPlaceHolder()) ?>" value="<?php echo $actions_list->expectedOccurrence->EditValue ?>"<?php echo $actions_list->expectedOccurrence->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_expectedOccurrence" name="o<?php echo $actions_list->RowIndex ?>_expectedOccurrence" id="o<?php echo $actions_list->RowIndex ?>_expectedOccurrence" value="<?php echo HtmlEncode($actions_list->expectedOccurrence->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->expectedDetection->Visible) { // expectedDetection ?>
		<td data-name="expectedDetection">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedDetection" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedDetection" class="form-group actions_expectedDetection">
<input type="text" data-table="actions" data-field="x_expectedDetection" name="x<?php echo $actions_list->RowIndex ?>_expectedDetection" id="x<?php echo $actions_list->RowIndex ?>_expectedDetection" size="3" placeholder="<?php echo HtmlEncode($actions_list->expectedDetection->getPlaceHolder()) ?>" value="<?php echo $actions_list->expectedDetection->EditValue ?>"<?php echo $actions_list->expectedDetection->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_expectedDetection" name="o<?php echo $actions_list->RowIndex ?>_expectedDetection" id="o<?php echo $actions_list->RowIndex ?>_expectedDetection" value="<?php echo HtmlEncode($actions_list->expectedDetection->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->expectedRPNPAO->Visible) { // expectedRPNPAO ?>
		<td data-name="expectedRPNPAO">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedRPNPAO" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedRPNPAO" class="form-group actions_expectedRPNPAO">
<input type="text" data-table="actions" data-field="x_expectedRPNPAO" name="x<?php echo $actions_list->RowIndex ?>_expectedRPNPAO" id="x<?php echo $actions_list->RowIndex ?>_expectedRPNPAO" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_list->expectedRPNPAO->getPlaceHolder()) ?>" value="<?php echo $actions_list->expectedRPNPAO->EditValue ?>"<?php echo $actions_list->expectedRPNPAO->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_expectedRPNPAO" name="o<?php echo $actions_list->RowIndex ?>_expectedRPNPAO" id="o<?php echo $actions_list->RowIndex ?>_expectedRPNPAO" value="<?php echo HtmlEncode($actions_list->expectedRPNPAO->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->expectedClosureDate->Visible) { // expectedClosureDate ?>
		<td data-name="expectedClosureDate">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedClosureDate" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedClosureDate" class="form-group actions_expectedClosureDate">
<input type="text" data-table="actions" data-field="x_expectedClosureDate" data-format="12" name="x<?php echo $actions_list->RowIndex ?>_expectedClosureDate" id="x<?php echo $actions_list->RowIndex ?>_expectedClosureDate" size="7" placeholder="<?php echo HtmlEncode($actions_list->expectedClosureDate->getPlaceHolder()) ?>" value="<?php echo $actions_list->expectedClosureDate->EditValue ?>"<?php echo $actions_list->expectedClosureDate->editAttributes() ?>>
<?php if (!$actions_list->expectedClosureDate->ReadOnly && !$actions_list->expectedClosureDate->Disabled && !isset($actions_list->expectedClosureDate->EditAttrs["readonly"]) && !isset($actions_list->expectedClosureDate->EditAttrs["disabled"])) { ?>
<?php } ?>
</span></script>
<script type="text/html" class="actionslist_js">
loadjs.ready(["factionslist", "datetimepicker"], function() {
	ew.createDateTimePicker("factionslist", "x<?php echo $actions_list->RowIndex ?>_expectedClosureDate", {"ignoreReadonly":true,"useCurrent":false,"format":12});
});
</script>
<input type="hidden" data-table="actions" data-field="x_expectedClosureDate" name="o<?php echo $actions_list->RowIndex ?>_expectedClosureDate" id="o<?php echo $actions_list->RowIndex ?>_expectedClosureDate" value="<?php echo HtmlEncode($actions_list->expectedClosureDate->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->recomendedActiondet->Visible) { // recomendedActiondet ?>
		<td data-name="recomendedActiondet">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_recomendedActiondet" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_recomendedActiondet" class="form-group actions_recomendedActiondet">
<input type="text" data-table="actions" data-field="x_recomendedActiondet" name="x<?php echo $actions_list->RowIndex ?>_recomendedActiondet" id="x<?php echo $actions_list->RowIndex ?>_recomendedActiondet" size="10" placeholder="<?php echo HtmlEncode($actions_list->recomendedActiondet->getPlaceHolder()) ?>" value="<?php echo $actions_list->recomendedActiondet->EditValue ?>"<?php echo $actions_list->recomendedActiondet->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_recomendedActiondet" name="o<?php echo $actions_list->RowIndex ?>_recomendedActiondet" id="o<?php echo $actions_list->RowIndex ?>_recomendedActiondet" value="<?php echo HtmlEncode($actions_list->recomendedActiondet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->idResponsibleDet->Visible) { // idResponsibleDet ?>
		<td data-name="idResponsibleDet">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_idResponsibleDet" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_idResponsibleDet" class="form-group actions_idResponsibleDet">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $actions_list->RowIndex ?>_idResponsibleDet"><?php echo EmptyValue(strval($actions_list->idResponsibleDet->ViewValue)) ? $Language->phrase("PleaseSelect") : $actions_list->idResponsibleDet->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($actions_list->idResponsibleDet->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($actions_list->idResponsibleDet->ReadOnly || $actions_list->idResponsibleDet->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $actions_list->RowIndex ?>_idResponsibleDet[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $actions_list->idResponsibleDet->Lookup->getParamTag($actions_list, "p_x" . $actions_list->RowIndex . "_idResponsibleDet") ?>
<input type="hidden" data-table="actions" data-field="x_idResponsibleDet" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $actions_list->idResponsibleDet->displayValueSeparatorAttribute() ?>" name="x<?php echo $actions_list->RowIndex ?>_idResponsibleDet[]" id="x<?php echo $actions_list->RowIndex ?>_idResponsibleDet[]" value="<?php echo $actions_list->idResponsibleDet->CurrentValue ?>"<?php echo $actions_list->idResponsibleDet->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_idResponsibleDet" name="o<?php echo $actions_list->RowIndex ?>_idResponsibleDet[]" id="o<?php echo $actions_list->RowIndex ?>_idResponsibleDet[]" value="<?php echo HtmlEncode($actions_list->idResponsibleDet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->targetDatedet->Visible) { // targetDatedet ?>
		<td data-name="targetDatedet">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_targetDatedet" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_targetDatedet" class="form-group actions_targetDatedet">
<input type="text" data-table="actions" data-field="x_targetDatedet" data-format="14" name="x<?php echo $actions_list->RowIndex ?>_targetDatedet" id="x<?php echo $actions_list->RowIndex ?>_targetDatedet" size="7" placeholder="<?php echo HtmlEncode($actions_list->targetDatedet->getPlaceHolder()) ?>" value="<?php echo $actions_list->targetDatedet->EditValue ?>"<?php echo $actions_list->targetDatedet->editAttributes() ?>>
<?php if (!$actions_list->targetDatedet->ReadOnly && !$actions_list->targetDatedet->Disabled && !isset($actions_list->targetDatedet->EditAttrs["readonly"]) && !isset($actions_list->targetDatedet->EditAttrs["disabled"])) { ?>
<?php } ?>
</span></script>
<script type="text/html" class="actionslist_js">
loadjs.ready(["factionslist", "datetimepicker"], function() {
	ew.createDateTimePicker("factionslist", "x<?php echo $actions_list->RowIndex ?>_targetDatedet", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<input type="hidden" data-table="actions" data-field="x_targetDatedet" name="o<?php echo $actions_list->RowIndex ?>_targetDatedet" id="o<?php echo $actions_list->RowIndex ?>_targetDatedet" value="<?php echo HtmlEncode($actions_list->targetDatedet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->kcdet->Visible) { // kcdet ?>
		<td data-name="kcdet">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_kcdet" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_kcdet" class="form-group actions_kcdet">
<?php
$selwrk = ConvertToBool($actions_list->kcdet->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="actions" data-field="x_kcdet" name="x<?php echo $actions_list->RowIndex ?>_kcdet[]" id="x<?php echo $actions_list->RowIndex ?>_kcdet[]" value="1"<?php echo $selwrk ?><?php echo $actions_list->kcdet->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $actions_list->RowIndex ?>_kcdet[]"></label>
</div>
</span></script>
<input type="hidden" data-table="actions" data-field="x_kcdet" name="o<?php echo $actions_list->RowIndex ?>_kcdet[]" id="o<?php echo $actions_list->RowIndex ?>_kcdet[]" value="<?php echo HtmlEncode($actions_list->kcdet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->expectedSeveritydet->Visible) { // expectedSeveritydet ?>
		<td data-name="expectedSeveritydet">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedSeveritydet" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedSeveritydet" class="form-group actions_expectedSeveritydet">
<input type="text" data-table="actions" data-field="x_expectedSeveritydet" name="x<?php echo $actions_list->RowIndex ?>_expectedSeveritydet" id="x<?php echo $actions_list->RowIndex ?>_expectedSeveritydet" size="3" placeholder="<?php echo HtmlEncode($actions_list->expectedSeveritydet->getPlaceHolder()) ?>" value="<?php echo $actions_list->expectedSeveritydet->EditValue ?>"<?php echo $actions_list->expectedSeveritydet->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_expectedSeveritydet" name="o<?php echo $actions_list->RowIndex ?>_expectedSeveritydet" id="o<?php echo $actions_list->RowIndex ?>_expectedSeveritydet" value="<?php echo HtmlEncode($actions_list->expectedSeveritydet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->expectedOccurrencedet->Visible) { // expectedOccurrencedet ?>
		<td data-name="expectedOccurrencedet">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedOccurrencedet" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedOccurrencedet" class="form-group actions_expectedOccurrencedet">
<input type="text" data-table="actions" data-field="x_expectedOccurrencedet" name="x<?php echo $actions_list->RowIndex ?>_expectedOccurrencedet" id="x<?php echo $actions_list->RowIndex ?>_expectedOccurrencedet" size="3" placeholder="<?php echo HtmlEncode($actions_list->expectedOccurrencedet->getPlaceHolder()) ?>" value="<?php echo $actions_list->expectedOccurrencedet->EditValue ?>"<?php echo $actions_list->expectedOccurrencedet->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_expectedOccurrencedet" name="o<?php echo $actions_list->RowIndex ?>_expectedOccurrencedet" id="o<?php echo $actions_list->RowIndex ?>_expectedOccurrencedet" value="<?php echo HtmlEncode($actions_list->expectedOccurrencedet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->expectedDetectiondet->Visible) { // expectedDetectiondet ?>
		<td data-name="expectedDetectiondet">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedDetectiondet" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedDetectiondet" class="form-group actions_expectedDetectiondet">
<input type="text" data-table="actions" data-field="x_expectedDetectiondet" name="x<?php echo $actions_list->RowIndex ?>_expectedDetectiondet" id="x<?php echo $actions_list->RowIndex ?>_expectedDetectiondet" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($actions_list->expectedDetectiondet->getPlaceHolder()) ?>" value="<?php echo $actions_list->expectedDetectiondet->EditValue ?>"<?php echo $actions_list->expectedDetectiondet->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_expectedDetectiondet" name="o<?php echo $actions_list->RowIndex ?>_expectedDetectiondet" id="o<?php echo $actions_list->RowIndex ?>_expectedDetectiondet" value="<?php echo HtmlEncode($actions_list->expectedDetectiondet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->expectedRPNPAD->Visible) { // expectedRPNPAD ?>
		<td data-name="expectedRPNPAD">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedRPNPAD" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedRPNPAD" class="form-group actions_expectedRPNPAD">
<input type="text" data-table="actions" data-field="x_expectedRPNPAD" name="x<?php echo $actions_list->RowIndex ?>_expectedRPNPAD" id="x<?php echo $actions_list->RowIndex ?>_expectedRPNPAD" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_list->expectedRPNPAD->getPlaceHolder()) ?>" value="<?php echo $actions_list->expectedRPNPAD->EditValue ?>"<?php echo $actions_list->expectedRPNPAD->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_expectedRPNPAD" name="o<?php echo $actions_list->RowIndex ?>_expectedRPNPAD" id="o<?php echo $actions_list->RowIndex ?>_expectedRPNPAD" value="<?php echo HtmlEncode($actions_list->expectedRPNPAD->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->revisedClosureDatedet->Visible) { // revisedClosureDatedet ?>
		<td data-name="revisedClosureDatedet">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_revisedClosureDatedet" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_revisedClosureDatedet" class="form-group actions_revisedClosureDatedet">
<input type="text" data-table="actions" data-field="x_revisedClosureDatedet" data-format="14" name="x<?php echo $actions_list->RowIndex ?>_revisedClosureDatedet" id="x<?php echo $actions_list->RowIndex ?>_revisedClosureDatedet" size="7" placeholder="<?php echo HtmlEncode($actions_list->revisedClosureDatedet->getPlaceHolder()) ?>" value="<?php echo $actions_list->revisedClosureDatedet->EditValue ?>"<?php echo $actions_list->revisedClosureDatedet->editAttributes() ?>>
<?php if (!$actions_list->revisedClosureDatedet->ReadOnly && !$actions_list->revisedClosureDatedet->Disabled && !isset($actions_list->revisedClosureDatedet->EditAttrs["readonly"]) && !isset($actions_list->revisedClosureDatedet->EditAttrs["disabled"])) { ?>
<?php } ?>
</span></script>
<script type="text/html" class="actionslist_js">
loadjs.ready(["factionslist", "datetimepicker"], function() {
	ew.createDateTimePicker("factionslist", "x<?php echo $actions_list->RowIndex ?>_revisedClosureDatedet", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<input type="hidden" data-table="actions" data-field="x_revisedClosureDatedet" name="o<?php echo $actions_list->RowIndex ?>_revisedClosureDatedet" id="o<?php echo $actions_list->RowIndex ?>_revisedClosureDatedet" value="<?php echo HtmlEncode($actions_list->revisedClosureDatedet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->revisedSeverity->Visible) { // revisedSeverity ?>
		<td data-name="revisedSeverity">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_revisedSeverity" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_revisedSeverity" class="form-group actions_revisedSeverity">
<input type="text" data-table="actions" data-field="x_revisedSeverity" name="x<?php echo $actions_list->RowIndex ?>_revisedSeverity" id="x<?php echo $actions_list->RowIndex ?>_revisedSeverity" size="3" placeholder="<?php echo HtmlEncode($actions_list->revisedSeverity->getPlaceHolder()) ?>" value="<?php echo $actions_list->revisedSeverity->EditValue ?>"<?php echo $actions_list->revisedSeverity->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_revisedSeverity" name="o<?php echo $actions_list->RowIndex ?>_revisedSeverity" id="o<?php echo $actions_list->RowIndex ?>_revisedSeverity" value="<?php echo HtmlEncode($actions_list->revisedSeverity->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->revisedOccurrence->Visible) { // revisedOccurrence ?>
		<td data-name="revisedOccurrence">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_revisedOccurrence" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_revisedOccurrence" class="form-group actions_revisedOccurrence">
<input type="text" data-table="actions" data-field="x_revisedOccurrence" name="x<?php echo $actions_list->RowIndex ?>_revisedOccurrence" id="x<?php echo $actions_list->RowIndex ?>_revisedOccurrence" size="3" placeholder="<?php echo HtmlEncode($actions_list->revisedOccurrence->getPlaceHolder()) ?>" value="<?php echo $actions_list->revisedOccurrence->EditValue ?>"<?php echo $actions_list->revisedOccurrence->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_revisedOccurrence" name="o<?php echo $actions_list->RowIndex ?>_revisedOccurrence" id="o<?php echo $actions_list->RowIndex ?>_revisedOccurrence" value="<?php echo HtmlEncode($actions_list->revisedOccurrence->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->revisedDetection->Visible) { // revisedDetection ?>
		<td data-name="revisedDetection">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_revisedDetection" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_revisedDetection" class="form-group actions_revisedDetection">
<input type="text" data-table="actions" data-field="x_revisedDetection" name="x<?php echo $actions_list->RowIndex ?>_revisedDetection" id="x<?php echo $actions_list->RowIndex ?>_revisedDetection" size="3" placeholder="<?php echo HtmlEncode($actions_list->revisedDetection->getPlaceHolder()) ?>" value="<?php echo $actions_list->revisedDetection->EditValue ?>"<?php echo $actions_list->revisedDetection->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_revisedDetection" name="o<?php echo $actions_list->RowIndex ?>_revisedDetection" id="o<?php echo $actions_list->RowIndex ?>_revisedDetection" value="<?php echo HtmlEncode($actions_list->revisedDetection->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($actions_list->revisedRPNCalc->Visible) { // revisedRPNCalc ?>
		<td data-name="revisedRPNCalc">
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_revisedRPNCalc" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_revisedRPNCalc" class="form-group actions_revisedRPNCalc">
<input type="text" data-table="actions" data-field="x_revisedRPNCalc" name="x<?php echo $actions_list->RowIndex ?>_revisedRPNCalc" id="x<?php echo $actions_list->RowIndex ?>_revisedRPNCalc" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_list->revisedRPNCalc->getPlaceHolder()) ?>" value="<?php echo $actions_list->revisedRPNCalc->EditValue ?>"<?php echo $actions_list->revisedRPNCalc->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_revisedRPNCalc" name="o<?php echo $actions_list->RowIndex ?>_revisedRPNCalc" id="o<?php echo $actions_list->RowIndex ?>_revisedRPNCalc" value="<?php echo HtmlEncode($actions_list->revisedRPNCalc->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$actions_list->ListOptions->render("body", "right", $actions_list->RowCount, "block", $actions->TableVar, "actionslist");
?>
<script class="actionslist_js" type="text/html">
loadjs.ready(["factionslist", "load"], function() {
	factionslist.updateLists(<?php echo $actions_list->RowIndex ?>);
});
</script>
	</tr>
<?php
	}
?>
<?php
if ($actions_list->ExportAll && $actions_list->isExport()) {
	$actions_list->StopRecord = $actions_list->TotalRecords;
} else {

	// Set the last record to display
	if ($actions_list->TotalRecords > $actions_list->StartRecord + $actions_list->DisplayRecords - 1)
		$actions_list->StopRecord = $actions_list->StartRecord + $actions_list->DisplayRecords - 1;
	else
		$actions_list->StopRecord = $actions_list->TotalRecords;
}

// Restore number of post back records
if ($CurrentForm && ($actions->isConfirm() || $actions_list->EventCancelled)) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($actions_list->FormKeyCountName) && ($actions_list->isGridAdd() || $actions_list->isGridEdit() || $actions->isConfirm())) {
		$actions_list->KeyCount = $CurrentForm->getValue($actions_list->FormKeyCountName);
		$actions_list->StopRecord = $actions_list->StartRecord + $actions_list->KeyCount - 1;
	}
}
$actions_list->RecordCount = $actions_list->StartRecord - 1;
if ($actions_list->Recordset && !$actions_list->Recordset->EOF) {
	$actions_list->Recordset->moveFirst();
	$selectLimit = $actions_list->UseSelectLimit;
	if (!$selectLimit && $actions_list->StartRecord > 1)
		$actions_list->Recordset->move($actions_list->StartRecord - 1);
} elseif (!$actions->AllowAddDeleteRow && $actions_list->StopRecord == 0) {
	$actions_list->StopRecord = $actions->GridAddRowCount;
}

// Initialize aggregate
$actions->RowType = ROWTYPE_AGGREGATEINIT;
$actions->resetAttributes();
$actions_list->renderRow();
if ($actions_list->isGridAdd())
	$actions_list->RowIndex = 0;
while ($actions_list->RecordCount < $actions_list->StopRecord) {
	$actions_list->RecordCount++;
	if ($actions_list->RecordCount >= $actions_list->StartRecord) {
		$actions_list->RowCount++;
		if ($actions_list->isGridAdd() || $actions_list->isGridEdit() || $actions->isConfirm()) {
			$actions_list->RowIndex++;
			$CurrentForm->Index = $actions_list->RowIndex;
			if ($CurrentForm->hasValue($actions_list->FormActionName) && ($actions->isConfirm() || $actions_list->EventCancelled))
				$actions_list->RowAction = strval($CurrentForm->getValue($actions_list->FormActionName));
			elseif ($actions_list->isGridAdd())
				$actions_list->RowAction = "insert";
			else
				$actions_list->RowAction = "";
		}

		// Set up key count
		$actions_list->KeyCount = $actions_list->RowIndex;

		// Init row class and style
		$actions->resetAttributes();
		$actions->CssClass = "";
		if ($actions_list->isGridAdd()) {
			$actions_list->loadRowValues(); // Load default values
		} else {
			$actions_list->loadRowValues($actions_list->Recordset); // Load row values
		}
		$actions->RowType = ROWTYPE_VIEW; // Render view
		if ($actions_list->isGridAdd()) // Grid add
			$actions->RowType = ROWTYPE_ADD; // Render add
		if ($actions_list->isGridAdd() && $actions->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$actions_list->restoreCurrentRowFormValues($actions_list->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$actions->RowAttrs->merge(["data-rowindex" => $actions_list->RowCount, "id" => "r" . $actions_list->RowCount . "_actions", "data-rowtype" => $actions->RowType]);

		// Render row
		$actions_list->renderRow();

		// Render list options
		$actions_list->renderListOptions();

		// Save row and cell attributes
		$actions_list->Attrs[$actions_list->RowCount] = ["row_attrs" => $actions->rowAttributes(), "cell_attrs" => []];
		$actions_list->Attrs[$actions_list->RowCount]["cell_attrs"] = $actions->fieldCellAttributes();

		// Skip delete row / empty row for confirm page
		if ($actions_list->RowAction != "delete" && $actions_list->RowAction != "insertdelete" && !($actions_list->RowAction == "insert" && $actions->isConfirm() && $actions_list->emptyRow())) {
?>
	<tr <?php echo $actions->rowAttributes() ?>>
<?php

// Render list options (body, left)
$actions_list->ListOptions->render("body", "left", $actions_list->RowCount, "block", $actions->TableVar, "actionslist");
?>
	<?php if ($actions_list->idProcess->Visible) { // idProcess ?>
		<td data-name="idProcess" <?php echo $actions_list->idProcess->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($actions_list->idProcess->getSessionValue() != "") { ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_idProcess" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_idProcess" class="form-group">
<span<?php echo $actions_list->idProcess->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($actions_list->idProcess->ViewValue)) ?>"></span>
</span></script>
<input type="hidden" id="x<?php echo $actions_list->RowIndex ?>_idProcess" name="x<?php echo $actions_list->RowIndex ?>_idProcess" value="<?php echo HtmlEncode($actions_list->idProcess->CurrentValue) ?>">
<?php } else { ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_idProcess" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_idProcess" class="form-group">
<input type="text" data-table="actions" data-field="x_idProcess" name="x<?php echo $actions_list->RowIndex ?>_idProcess" id="x<?php echo $actions_list->RowIndex ?>_idProcess" size="30" placeholder="<?php echo HtmlEncode($actions_list->idProcess->getPlaceHolder()) ?>" value="<?php echo $actions_list->idProcess->EditValue ?>"<?php echo $actions_list->idProcess->editAttributes() ?>>
</span></script>
<?php } ?>
<input type="hidden" data-table="actions" data-field="x_idProcess" name="o<?php echo $actions_list->RowIndex ?>_idProcess" id="o<?php echo $actions_list->RowIndex ?>_idProcess" value="<?php echo HtmlEncode($actions_list->idProcess->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_idProcess" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_idProcess">
<span<?php echo $actions_list->idProcess->viewAttributes() ?>><?php echo $actions_list->idProcess->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->idCause->Visible) { // idCause ?>
		<td data-name="idCause" <?php echo $actions_list->idCause->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_idCause" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_idCause" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="actions" data-field="x_idCause" data-value-separator="<?php echo $actions_list->idCause->displayValueSeparatorAttribute() ?>" id="x<?php echo $actions_list->RowIndex ?>_idCause" name="x<?php echo $actions_list->RowIndex ?>_idCause"<?php echo $actions_list->idCause->editAttributes() ?>>
			<?php echo $actions_list->idCause->selectOptionListHtml("x{$actions_list->RowIndex}_idCause") ?>
		</select>
</div>
<?php echo $actions_list->idCause->Lookup->getParamTag($actions_list, "p_x" . $actions_list->RowIndex . "_idCause") ?>
</span></script>
<input type="hidden" data-table="actions" data-field="x_idCause" name="o<?php echo $actions_list->RowIndex ?>_idCause" id="o<?php echo $actions_list->RowIndex ?>_idCause" value="<?php echo HtmlEncode($actions_list->idCause->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_idCause" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_idCause">
<span<?php echo $actions_list->idCause->viewAttributes() ?>><?php echo $actions_list->idCause->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->potentialCauses->Visible) { // potentialCauses ?>
		<td data-name="potentialCauses" <?php echo $actions_list->potentialCauses->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_potentialCauses" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_potentialCauses" class="form-group">
<textarea data-table="actions" data-field="x_potentialCauses" name="x<?php echo $actions_list->RowIndex ?>_potentialCauses" id="x<?php echo $actions_list->RowIndex ?>_potentialCauses" cols="35" rows="4" placeholder="<?php echo HtmlEncode($actions_list->potentialCauses->getPlaceHolder()) ?>"<?php echo $actions_list->potentialCauses->editAttributes() ?>><?php echo $actions_list->potentialCauses->EditValue ?></textarea>
</span></script>
<input type="hidden" data-table="actions" data-field="x_potentialCauses" name="o<?php echo $actions_list->RowIndex ?>_potentialCauses" id="o<?php echo $actions_list->RowIndex ?>_potentialCauses" value="<?php echo HtmlEncode($actions_list->potentialCauses->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_potentialCauses" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_potentialCauses">
<span<?php echo $actions_list->potentialCauses->viewAttributes() ?>><?php echo $actions_list->potentialCauses->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->currentPreventiveControlMethod->Visible) { // currentPreventiveControlMethod ?>
		<td data-name="currentPreventiveControlMethod" <?php echo $actions_list->currentPreventiveControlMethod->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_currentPreventiveControlMethod" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_currentPreventiveControlMethod" class="form-group">
<input type="text" data-table="actions" data-field="x_currentPreventiveControlMethod" name="x<?php echo $actions_list->RowIndex ?>_currentPreventiveControlMethod" id="x<?php echo $actions_list->RowIndex ?>_currentPreventiveControlMethod" size="7" maxlength="255" placeholder="<?php echo HtmlEncode($actions_list->currentPreventiveControlMethod->getPlaceHolder()) ?>" value="<?php echo $actions_list->currentPreventiveControlMethod->EditValue ?>"<?php echo $actions_list->currentPreventiveControlMethod->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_currentPreventiveControlMethod" name="o<?php echo $actions_list->RowIndex ?>_currentPreventiveControlMethod" id="o<?php echo $actions_list->RowIndex ?>_currentPreventiveControlMethod" value="<?php echo HtmlEncode($actions_list->currentPreventiveControlMethod->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_currentPreventiveControlMethod" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_currentPreventiveControlMethod">
<span<?php echo $actions_list->currentPreventiveControlMethod->viewAttributes() ?>><?php echo $actions_list->currentPreventiveControlMethod->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->severity->Visible) { // severity ?>
		<td data-name="severity" <?php echo $actions_list->severity->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_severity" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_severity" class="form-group">
<input type="text" data-table="actions" data-field="x_severity" name="x<?php echo $actions_list->RowIndex ?>_severity" id="x<?php echo $actions_list->RowIndex ?>_severity" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($actions_list->severity->getPlaceHolder()) ?>" value="<?php echo $actions_list->severity->EditValue ?>"<?php echo $actions_list->severity->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_severity" name="o<?php echo $actions_list->RowIndex ?>_severity" id="o<?php echo $actions_list->RowIndex ?>_severity" value="<?php echo HtmlEncode($actions_list->severity->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_severity" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_severity">
<span<?php echo $actions_list->severity->viewAttributes() ?>><?php echo $actions_list->severity->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->occurrence->Visible) { // occurrence ?>
		<td data-name="occurrence" <?php echo $actions_list->occurrence->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_occurrence" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_occurrence" class="form-group">
<input type="text" data-table="actions" data-field="x_occurrence" name="x<?php echo $actions_list->RowIndex ?>_occurrence" id="x<?php echo $actions_list->RowIndex ?>_occurrence" size="3" placeholder="<?php echo HtmlEncode($actions_list->occurrence->getPlaceHolder()) ?>" value="<?php echo $actions_list->occurrence->EditValue ?>"<?php echo $actions_list->occurrence->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_occurrence" name="o<?php echo $actions_list->RowIndex ?>_occurrence" id="o<?php echo $actions_list->RowIndex ?>_occurrence" value="<?php echo HtmlEncode($actions_list->occurrence->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_occurrence" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_occurrence">
<span<?php echo $actions_list->occurrence->viewAttributes() ?>><?php echo $actions_list->occurrence->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->currentControlMethod->Visible) { // currentControlMethod ?>
		<td data-name="currentControlMethod" <?php echo $actions_list->currentControlMethod->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_currentControlMethod" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_currentControlMethod" class="form-group">
<input type="text" data-table="actions" data-field="x_currentControlMethod" name="x<?php echo $actions_list->RowIndex ?>_currentControlMethod" id="x<?php echo $actions_list->RowIndex ?>_currentControlMethod" size="10" maxlength="255" placeholder="<?php echo HtmlEncode($actions_list->currentControlMethod->getPlaceHolder()) ?>" value="<?php echo $actions_list->currentControlMethod->EditValue ?>"<?php echo $actions_list->currentControlMethod->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_currentControlMethod" name="o<?php echo $actions_list->RowIndex ?>_currentControlMethod" id="o<?php echo $actions_list->RowIndex ?>_currentControlMethod" value="<?php echo HtmlEncode($actions_list->currentControlMethod->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_currentControlMethod" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_currentControlMethod">
<span<?php echo $actions_list->currentControlMethod->viewAttributes() ?>><?php echo $actions_list->currentControlMethod->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->detection->Visible) { // detection ?>
		<td data-name="detection" <?php echo $actions_list->detection->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_detection" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_detection" class="form-group">
<input type="text" data-table="actions" data-field="x_detection" name="x<?php echo $actions_list->RowIndex ?>_detection" id="x<?php echo $actions_list->RowIndex ?>_detection" size="3" placeholder="<?php echo HtmlEncode($actions_list->detection->getPlaceHolder()) ?>" value="<?php echo $actions_list->detection->EditValue ?>"<?php echo $actions_list->detection->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_detection" name="o<?php echo $actions_list->RowIndex ?>_detection" id="o<?php echo $actions_list->RowIndex ?>_detection" value="<?php echo HtmlEncode($actions_list->detection->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_detection" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_detection">
<span<?php echo $actions_list->detection->viewAttributes() ?>><?php echo $actions_list->detection->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->RPNCalc->Visible) { // RPNCalc ?>
		<td data-name="RPNCalc" <?php echo $actions_list->RPNCalc->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_RPNCalc" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_RPNCalc" class="form-group">
<input type="text" data-table="actions" data-field="x_RPNCalc" name="x<?php echo $actions_list->RowIndex ?>_RPNCalc" id="x<?php echo $actions_list->RowIndex ?>_RPNCalc" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_list->RPNCalc->getPlaceHolder()) ?>" value="<?php echo $actions_list->RPNCalc->EditValue ?>"<?php echo $actions_list->RPNCalc->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_RPNCalc" name="o<?php echo $actions_list->RowIndex ?>_RPNCalc" id="o<?php echo $actions_list->RowIndex ?>_RPNCalc" value="<?php echo HtmlEncode($actions_list->RPNCalc->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_RPNCalc" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_RPNCalc">
<span<?php echo $actions_list->RPNCalc->viewAttributes() ?>><?php echo $actions_list->RPNCalc->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->recomendedAction->Visible) { // recomendedAction ?>
		<td data-name="recomendedAction" <?php echo $actions_list->recomendedAction->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_recomendedAction" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_recomendedAction" class="form-group">
<textarea data-table="actions" data-field="x_recomendedAction" name="x<?php echo $actions_list->RowIndex ?>_recomendedAction" id="x<?php echo $actions_list->RowIndex ?>_recomendedAction" cols="10" rows="4" placeholder="<?php echo HtmlEncode($actions_list->recomendedAction->getPlaceHolder()) ?>"<?php echo $actions_list->recomendedAction->editAttributes() ?>><?php echo $actions_list->recomendedAction->EditValue ?></textarea>
</span></script>
<input type="hidden" data-table="actions" data-field="x_recomendedAction" name="o<?php echo $actions_list->RowIndex ?>_recomendedAction" id="o<?php echo $actions_list->RowIndex ?>_recomendedAction" value="<?php echo HtmlEncode($actions_list->recomendedAction->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_recomendedAction" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_recomendedAction">
<span<?php echo $actions_list->recomendedAction->viewAttributes() ?>><?php echo $actions_list->recomendedAction->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->idResponsible->Visible) { // idResponsible ?>
		<td data-name="idResponsible" <?php echo $actions_list->idResponsible->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_idResponsible" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_idResponsible" class="form-group">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $actions_list->RowIndex ?>_idResponsible"><?php echo EmptyValue(strval($actions_list->idResponsible->ViewValue)) ? $Language->phrase("PleaseSelect") : $actions_list->idResponsible->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($actions_list->idResponsible->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($actions_list->idResponsible->ReadOnly || $actions_list->idResponsible->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $actions_list->RowIndex ?>_idResponsible[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $actions_list->idResponsible->Lookup->getParamTag($actions_list, "p_x" . $actions_list->RowIndex . "_idResponsible") ?>
<input type="hidden" data-table="actions" data-field="x_idResponsible" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $actions_list->idResponsible->displayValueSeparatorAttribute() ?>" name="x<?php echo $actions_list->RowIndex ?>_idResponsible[]" id="x<?php echo $actions_list->RowIndex ?>_idResponsible[]" value="<?php echo $actions_list->idResponsible->CurrentValue ?>"<?php echo $actions_list->idResponsible->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_idResponsible" name="o<?php echo $actions_list->RowIndex ?>_idResponsible[]" id="o<?php echo $actions_list->RowIndex ?>_idResponsible[]" value="<?php echo HtmlEncode($actions_list->idResponsible->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_idResponsible" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_idResponsible">
<span<?php echo $actions_list->idResponsible->viewAttributes() ?>><?php echo $actions_list->idResponsible->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->targetDate->Visible) { // targetDate ?>
		<td data-name="targetDate" <?php echo $actions_list->targetDate->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_targetDate" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_targetDate" class="form-group">
<input type="text" data-table="actions" data-field="x_targetDate" data-format="14" name="x<?php echo $actions_list->RowIndex ?>_targetDate" id="x<?php echo $actions_list->RowIndex ?>_targetDate" size="7" placeholder="<?php echo HtmlEncode($actions_list->targetDate->getPlaceHolder()) ?>" value="<?php echo $actions_list->targetDate->EditValue ?>"<?php echo $actions_list->targetDate->editAttributes() ?>>
<?php if (!$actions_list->targetDate->ReadOnly && !$actions_list->targetDate->Disabled && !isset($actions_list->targetDate->EditAttrs["readonly"]) && !isset($actions_list->targetDate->EditAttrs["disabled"])) { ?>
<?php } ?>
</span></script>
<script type="text/html" class="actionslist_js">
loadjs.ready(["factionslist", "datetimepicker"], function() {
	ew.createDateTimePicker("factionslist", "x<?php echo $actions_list->RowIndex ?>_targetDate", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<input type="hidden" data-table="actions" data-field="x_targetDate" name="o<?php echo $actions_list->RowIndex ?>_targetDate" id="o<?php echo $actions_list->RowIndex ?>_targetDate" value="<?php echo HtmlEncode($actions_list->targetDate->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_targetDate" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_targetDate">
<span<?php echo $actions_list->targetDate->viewAttributes() ?>><?php echo $actions_list->targetDate->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->revisedKc->Visible) { // revisedKc ?>
		<td data-name="revisedKc" <?php echo $actions_list->revisedKc->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_revisedKc" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_revisedKc" class="form-group">
<?php
$selwrk = ConvertToBool($actions_list->revisedKc->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="actions" data-field="x_revisedKc" name="x<?php echo $actions_list->RowIndex ?>_revisedKc[]" id="x<?php echo $actions_list->RowIndex ?>_revisedKc[]" value="1"<?php echo $selwrk ?><?php echo $actions_list->revisedKc->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $actions_list->RowIndex ?>_revisedKc[]"></label>
</div>
</span></script>
<input type="hidden" data-table="actions" data-field="x_revisedKc" name="o<?php echo $actions_list->RowIndex ?>_revisedKc[]" id="o<?php echo $actions_list->RowIndex ?>_revisedKc[]" value="<?php echo HtmlEncode($actions_list->revisedKc->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_revisedKc" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_revisedKc">
<span<?php echo $actions_list->revisedKc->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_revisedKc" class="custom-control-input" value="<?php echo $actions_list->revisedKc->getViewValue() ?>" disabled<?php if (ConvertToBool($actions_list->revisedKc->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_revisedKc"></label></div></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->expectedSeverity->Visible) { // expectedSeverity ?>
		<td data-name="expectedSeverity" <?php echo $actions_list->expectedSeverity->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedSeverity" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedSeverity" class="form-group">
<input type="text" data-table="actions" data-field="x_expectedSeverity" name="x<?php echo $actions_list->RowIndex ?>_expectedSeverity" id="x<?php echo $actions_list->RowIndex ?>_expectedSeverity" size="3" placeholder="<?php echo HtmlEncode($actions_list->expectedSeverity->getPlaceHolder()) ?>" value="<?php echo $actions_list->expectedSeverity->EditValue ?>"<?php echo $actions_list->expectedSeverity->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_expectedSeverity" name="o<?php echo $actions_list->RowIndex ?>_expectedSeverity" id="o<?php echo $actions_list->RowIndex ?>_expectedSeverity" value="<?php echo HtmlEncode($actions_list->expectedSeverity->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedSeverity" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedSeverity">
<span<?php echo $actions_list->expectedSeverity->viewAttributes() ?>><?php echo $actions_list->expectedSeverity->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->expectedOccurrence->Visible) { // expectedOccurrence ?>
		<td data-name="expectedOccurrence" <?php echo $actions_list->expectedOccurrence->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedOccurrence" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedOccurrence" class="form-group">
<input type="text" data-table="actions" data-field="x_expectedOccurrence" name="x<?php echo $actions_list->RowIndex ?>_expectedOccurrence" id="x<?php echo $actions_list->RowIndex ?>_expectedOccurrence" size="3" placeholder="<?php echo HtmlEncode($actions_list->expectedOccurrence->getPlaceHolder()) ?>" value="<?php echo $actions_list->expectedOccurrence->EditValue ?>"<?php echo $actions_list->expectedOccurrence->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_expectedOccurrence" name="o<?php echo $actions_list->RowIndex ?>_expectedOccurrence" id="o<?php echo $actions_list->RowIndex ?>_expectedOccurrence" value="<?php echo HtmlEncode($actions_list->expectedOccurrence->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedOccurrence" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedOccurrence">
<span<?php echo $actions_list->expectedOccurrence->viewAttributes() ?>><?php echo $actions_list->expectedOccurrence->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->expectedDetection->Visible) { // expectedDetection ?>
		<td data-name="expectedDetection" <?php echo $actions_list->expectedDetection->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedDetection" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedDetection" class="form-group">
<input type="text" data-table="actions" data-field="x_expectedDetection" name="x<?php echo $actions_list->RowIndex ?>_expectedDetection" id="x<?php echo $actions_list->RowIndex ?>_expectedDetection" size="3" placeholder="<?php echo HtmlEncode($actions_list->expectedDetection->getPlaceHolder()) ?>" value="<?php echo $actions_list->expectedDetection->EditValue ?>"<?php echo $actions_list->expectedDetection->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_expectedDetection" name="o<?php echo $actions_list->RowIndex ?>_expectedDetection" id="o<?php echo $actions_list->RowIndex ?>_expectedDetection" value="<?php echo HtmlEncode($actions_list->expectedDetection->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedDetection" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedDetection">
<span<?php echo $actions_list->expectedDetection->viewAttributes() ?>><?php echo $actions_list->expectedDetection->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->expectedRPNPAO->Visible) { // expectedRPNPAO ?>
		<td data-name="expectedRPNPAO" <?php echo $actions_list->expectedRPNPAO->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedRPNPAO" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedRPNPAO" class="form-group">
<input type="text" data-table="actions" data-field="x_expectedRPNPAO" name="x<?php echo $actions_list->RowIndex ?>_expectedRPNPAO" id="x<?php echo $actions_list->RowIndex ?>_expectedRPNPAO" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_list->expectedRPNPAO->getPlaceHolder()) ?>" value="<?php echo $actions_list->expectedRPNPAO->EditValue ?>"<?php echo $actions_list->expectedRPNPAO->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_expectedRPNPAO" name="o<?php echo $actions_list->RowIndex ?>_expectedRPNPAO" id="o<?php echo $actions_list->RowIndex ?>_expectedRPNPAO" value="<?php echo HtmlEncode($actions_list->expectedRPNPAO->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedRPNPAO" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedRPNPAO">
<span<?php echo $actions_list->expectedRPNPAO->viewAttributes() ?>><?php echo $actions_list->expectedRPNPAO->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->expectedClosureDate->Visible) { // expectedClosureDate ?>
		<td data-name="expectedClosureDate" <?php echo $actions_list->expectedClosureDate->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedClosureDate" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedClosureDate" class="form-group">
<input type="text" data-table="actions" data-field="x_expectedClosureDate" data-format="12" name="x<?php echo $actions_list->RowIndex ?>_expectedClosureDate" id="x<?php echo $actions_list->RowIndex ?>_expectedClosureDate" size="7" placeholder="<?php echo HtmlEncode($actions_list->expectedClosureDate->getPlaceHolder()) ?>" value="<?php echo $actions_list->expectedClosureDate->EditValue ?>"<?php echo $actions_list->expectedClosureDate->editAttributes() ?>>
<?php if (!$actions_list->expectedClosureDate->ReadOnly && !$actions_list->expectedClosureDate->Disabled && !isset($actions_list->expectedClosureDate->EditAttrs["readonly"]) && !isset($actions_list->expectedClosureDate->EditAttrs["disabled"])) { ?>
<?php } ?>
</span></script>
<script type="text/html" class="actionslist_js">
loadjs.ready(["factionslist", "datetimepicker"], function() {
	ew.createDateTimePicker("factionslist", "x<?php echo $actions_list->RowIndex ?>_expectedClosureDate", {"ignoreReadonly":true,"useCurrent":false,"format":12});
});
</script>
<input type="hidden" data-table="actions" data-field="x_expectedClosureDate" name="o<?php echo $actions_list->RowIndex ?>_expectedClosureDate" id="o<?php echo $actions_list->RowIndex ?>_expectedClosureDate" value="<?php echo HtmlEncode($actions_list->expectedClosureDate->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedClosureDate" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedClosureDate">
<span<?php echo $actions_list->expectedClosureDate->viewAttributes() ?>><?php echo $actions_list->expectedClosureDate->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->recomendedActiondet->Visible) { // recomendedActiondet ?>
		<td data-name="recomendedActiondet" <?php echo $actions_list->recomendedActiondet->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_recomendedActiondet" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_recomendedActiondet" class="form-group">
<input type="text" data-table="actions" data-field="x_recomendedActiondet" name="x<?php echo $actions_list->RowIndex ?>_recomendedActiondet" id="x<?php echo $actions_list->RowIndex ?>_recomendedActiondet" size="10" placeholder="<?php echo HtmlEncode($actions_list->recomendedActiondet->getPlaceHolder()) ?>" value="<?php echo $actions_list->recomendedActiondet->EditValue ?>"<?php echo $actions_list->recomendedActiondet->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_recomendedActiondet" name="o<?php echo $actions_list->RowIndex ?>_recomendedActiondet" id="o<?php echo $actions_list->RowIndex ?>_recomendedActiondet" value="<?php echo HtmlEncode($actions_list->recomendedActiondet->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_recomendedActiondet" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_recomendedActiondet">
<span<?php echo $actions_list->recomendedActiondet->viewAttributes() ?>><?php echo $actions_list->recomendedActiondet->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->idResponsibleDet->Visible) { // idResponsibleDet ?>
		<td data-name="idResponsibleDet" <?php echo $actions_list->idResponsibleDet->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_idResponsibleDet" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_idResponsibleDet" class="form-group">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $actions_list->RowIndex ?>_idResponsibleDet"><?php echo EmptyValue(strval($actions_list->idResponsibleDet->ViewValue)) ? $Language->phrase("PleaseSelect") : $actions_list->idResponsibleDet->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($actions_list->idResponsibleDet->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($actions_list->idResponsibleDet->ReadOnly || $actions_list->idResponsibleDet->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $actions_list->RowIndex ?>_idResponsibleDet[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $actions_list->idResponsibleDet->Lookup->getParamTag($actions_list, "p_x" . $actions_list->RowIndex . "_idResponsibleDet") ?>
<input type="hidden" data-table="actions" data-field="x_idResponsibleDet" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $actions_list->idResponsibleDet->displayValueSeparatorAttribute() ?>" name="x<?php echo $actions_list->RowIndex ?>_idResponsibleDet[]" id="x<?php echo $actions_list->RowIndex ?>_idResponsibleDet[]" value="<?php echo $actions_list->idResponsibleDet->CurrentValue ?>"<?php echo $actions_list->idResponsibleDet->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_idResponsibleDet" name="o<?php echo $actions_list->RowIndex ?>_idResponsibleDet[]" id="o<?php echo $actions_list->RowIndex ?>_idResponsibleDet[]" value="<?php echo HtmlEncode($actions_list->idResponsibleDet->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_idResponsibleDet" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_idResponsibleDet">
<span<?php echo $actions_list->idResponsibleDet->viewAttributes() ?>><?php echo $actions_list->idResponsibleDet->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->targetDatedet->Visible) { // targetDatedet ?>
		<td data-name="targetDatedet" <?php echo $actions_list->targetDatedet->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_targetDatedet" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_targetDatedet" class="form-group">
<input type="text" data-table="actions" data-field="x_targetDatedet" data-format="14" name="x<?php echo $actions_list->RowIndex ?>_targetDatedet" id="x<?php echo $actions_list->RowIndex ?>_targetDatedet" size="7" placeholder="<?php echo HtmlEncode($actions_list->targetDatedet->getPlaceHolder()) ?>" value="<?php echo $actions_list->targetDatedet->EditValue ?>"<?php echo $actions_list->targetDatedet->editAttributes() ?>>
<?php if (!$actions_list->targetDatedet->ReadOnly && !$actions_list->targetDatedet->Disabled && !isset($actions_list->targetDatedet->EditAttrs["readonly"]) && !isset($actions_list->targetDatedet->EditAttrs["disabled"])) { ?>
<?php } ?>
</span></script>
<script type="text/html" class="actionslist_js">
loadjs.ready(["factionslist", "datetimepicker"], function() {
	ew.createDateTimePicker("factionslist", "x<?php echo $actions_list->RowIndex ?>_targetDatedet", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<input type="hidden" data-table="actions" data-field="x_targetDatedet" name="o<?php echo $actions_list->RowIndex ?>_targetDatedet" id="o<?php echo $actions_list->RowIndex ?>_targetDatedet" value="<?php echo HtmlEncode($actions_list->targetDatedet->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_targetDatedet" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_targetDatedet">
<span<?php echo $actions_list->targetDatedet->viewAttributes() ?>><?php echo $actions_list->targetDatedet->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->kcdet->Visible) { // kcdet ?>
		<td data-name="kcdet" <?php echo $actions_list->kcdet->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_kcdet" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_kcdet" class="form-group">
<?php
$selwrk = ConvertToBool($actions_list->kcdet->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="actions" data-field="x_kcdet" name="x<?php echo $actions_list->RowIndex ?>_kcdet[]" id="x<?php echo $actions_list->RowIndex ?>_kcdet[]" value="1"<?php echo $selwrk ?><?php echo $actions_list->kcdet->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $actions_list->RowIndex ?>_kcdet[]"></label>
</div>
</span></script>
<input type="hidden" data-table="actions" data-field="x_kcdet" name="o<?php echo $actions_list->RowIndex ?>_kcdet[]" id="o<?php echo $actions_list->RowIndex ?>_kcdet[]" value="<?php echo HtmlEncode($actions_list->kcdet->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_kcdet" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_kcdet">
<span<?php echo $actions_list->kcdet->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_kcdet" class="custom-control-input" value="<?php echo $actions_list->kcdet->getViewValue() ?>" disabled<?php if (ConvertToBool($actions_list->kcdet->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_kcdet"></label></div></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->expectedSeveritydet->Visible) { // expectedSeveritydet ?>
		<td data-name="expectedSeveritydet" <?php echo $actions_list->expectedSeveritydet->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedSeveritydet" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedSeveritydet" class="form-group">
<input type="text" data-table="actions" data-field="x_expectedSeveritydet" name="x<?php echo $actions_list->RowIndex ?>_expectedSeveritydet" id="x<?php echo $actions_list->RowIndex ?>_expectedSeveritydet" size="3" placeholder="<?php echo HtmlEncode($actions_list->expectedSeveritydet->getPlaceHolder()) ?>" value="<?php echo $actions_list->expectedSeveritydet->EditValue ?>"<?php echo $actions_list->expectedSeveritydet->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_expectedSeveritydet" name="o<?php echo $actions_list->RowIndex ?>_expectedSeveritydet" id="o<?php echo $actions_list->RowIndex ?>_expectedSeveritydet" value="<?php echo HtmlEncode($actions_list->expectedSeveritydet->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedSeveritydet" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedSeveritydet">
<span<?php echo $actions_list->expectedSeveritydet->viewAttributes() ?>><?php echo $actions_list->expectedSeveritydet->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->expectedOccurrencedet->Visible) { // expectedOccurrencedet ?>
		<td data-name="expectedOccurrencedet" <?php echo $actions_list->expectedOccurrencedet->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedOccurrencedet" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedOccurrencedet" class="form-group">
<input type="text" data-table="actions" data-field="x_expectedOccurrencedet" name="x<?php echo $actions_list->RowIndex ?>_expectedOccurrencedet" id="x<?php echo $actions_list->RowIndex ?>_expectedOccurrencedet" size="3" placeholder="<?php echo HtmlEncode($actions_list->expectedOccurrencedet->getPlaceHolder()) ?>" value="<?php echo $actions_list->expectedOccurrencedet->EditValue ?>"<?php echo $actions_list->expectedOccurrencedet->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_expectedOccurrencedet" name="o<?php echo $actions_list->RowIndex ?>_expectedOccurrencedet" id="o<?php echo $actions_list->RowIndex ?>_expectedOccurrencedet" value="<?php echo HtmlEncode($actions_list->expectedOccurrencedet->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedOccurrencedet" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedOccurrencedet">
<span<?php echo $actions_list->expectedOccurrencedet->viewAttributes() ?>><?php echo $actions_list->expectedOccurrencedet->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->expectedDetectiondet->Visible) { // expectedDetectiondet ?>
		<td data-name="expectedDetectiondet" <?php echo $actions_list->expectedDetectiondet->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedDetectiondet" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedDetectiondet" class="form-group">
<input type="text" data-table="actions" data-field="x_expectedDetectiondet" name="x<?php echo $actions_list->RowIndex ?>_expectedDetectiondet" id="x<?php echo $actions_list->RowIndex ?>_expectedDetectiondet" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($actions_list->expectedDetectiondet->getPlaceHolder()) ?>" value="<?php echo $actions_list->expectedDetectiondet->EditValue ?>"<?php echo $actions_list->expectedDetectiondet->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_expectedDetectiondet" name="o<?php echo $actions_list->RowIndex ?>_expectedDetectiondet" id="o<?php echo $actions_list->RowIndex ?>_expectedDetectiondet" value="<?php echo HtmlEncode($actions_list->expectedDetectiondet->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedDetectiondet" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedDetectiondet">
<span<?php echo $actions_list->expectedDetectiondet->viewAttributes() ?>><?php echo $actions_list->expectedDetectiondet->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->expectedRPNPAD->Visible) { // expectedRPNPAD ?>
		<td data-name="expectedRPNPAD" <?php echo $actions_list->expectedRPNPAD->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedRPNPAD" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedRPNPAD" class="form-group">
<input type="text" data-table="actions" data-field="x_expectedRPNPAD" name="x<?php echo $actions_list->RowIndex ?>_expectedRPNPAD" id="x<?php echo $actions_list->RowIndex ?>_expectedRPNPAD" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_list->expectedRPNPAD->getPlaceHolder()) ?>" value="<?php echo $actions_list->expectedRPNPAD->EditValue ?>"<?php echo $actions_list->expectedRPNPAD->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_expectedRPNPAD" name="o<?php echo $actions_list->RowIndex ?>_expectedRPNPAD" id="o<?php echo $actions_list->RowIndex ?>_expectedRPNPAD" value="<?php echo HtmlEncode($actions_list->expectedRPNPAD->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_expectedRPNPAD" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_expectedRPNPAD">
<span<?php echo $actions_list->expectedRPNPAD->viewAttributes() ?>><?php echo $actions_list->expectedRPNPAD->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->revisedClosureDatedet->Visible) { // revisedClosureDatedet ?>
		<td data-name="revisedClosureDatedet" <?php echo $actions_list->revisedClosureDatedet->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_revisedClosureDatedet" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_revisedClosureDatedet" class="form-group">
<input type="text" data-table="actions" data-field="x_revisedClosureDatedet" data-format="14" name="x<?php echo $actions_list->RowIndex ?>_revisedClosureDatedet" id="x<?php echo $actions_list->RowIndex ?>_revisedClosureDatedet" size="7" placeholder="<?php echo HtmlEncode($actions_list->revisedClosureDatedet->getPlaceHolder()) ?>" value="<?php echo $actions_list->revisedClosureDatedet->EditValue ?>"<?php echo $actions_list->revisedClosureDatedet->editAttributes() ?>>
<?php if (!$actions_list->revisedClosureDatedet->ReadOnly && !$actions_list->revisedClosureDatedet->Disabled && !isset($actions_list->revisedClosureDatedet->EditAttrs["readonly"]) && !isset($actions_list->revisedClosureDatedet->EditAttrs["disabled"])) { ?>
<?php } ?>
</span></script>
<script type="text/html" class="actionslist_js">
loadjs.ready(["factionslist", "datetimepicker"], function() {
	ew.createDateTimePicker("factionslist", "x<?php echo $actions_list->RowIndex ?>_revisedClosureDatedet", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<input type="hidden" data-table="actions" data-field="x_revisedClosureDatedet" name="o<?php echo $actions_list->RowIndex ?>_revisedClosureDatedet" id="o<?php echo $actions_list->RowIndex ?>_revisedClosureDatedet" value="<?php echo HtmlEncode($actions_list->revisedClosureDatedet->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_revisedClosureDatedet" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_revisedClosureDatedet">
<span<?php echo $actions_list->revisedClosureDatedet->viewAttributes() ?>><?php echo $actions_list->revisedClosureDatedet->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->revisedSeverity->Visible) { // revisedSeverity ?>
		<td data-name="revisedSeverity" <?php echo $actions_list->revisedSeverity->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_revisedSeverity" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_revisedSeverity" class="form-group">
<input type="text" data-table="actions" data-field="x_revisedSeverity" name="x<?php echo $actions_list->RowIndex ?>_revisedSeverity" id="x<?php echo $actions_list->RowIndex ?>_revisedSeverity" size="3" placeholder="<?php echo HtmlEncode($actions_list->revisedSeverity->getPlaceHolder()) ?>" value="<?php echo $actions_list->revisedSeverity->EditValue ?>"<?php echo $actions_list->revisedSeverity->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_revisedSeverity" name="o<?php echo $actions_list->RowIndex ?>_revisedSeverity" id="o<?php echo $actions_list->RowIndex ?>_revisedSeverity" value="<?php echo HtmlEncode($actions_list->revisedSeverity->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_revisedSeverity" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_revisedSeverity">
<span<?php echo $actions_list->revisedSeverity->viewAttributes() ?>><?php echo $actions_list->revisedSeverity->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->revisedOccurrence->Visible) { // revisedOccurrence ?>
		<td data-name="revisedOccurrence" <?php echo $actions_list->revisedOccurrence->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_revisedOccurrence" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_revisedOccurrence" class="form-group">
<input type="text" data-table="actions" data-field="x_revisedOccurrence" name="x<?php echo $actions_list->RowIndex ?>_revisedOccurrence" id="x<?php echo $actions_list->RowIndex ?>_revisedOccurrence" size="3" placeholder="<?php echo HtmlEncode($actions_list->revisedOccurrence->getPlaceHolder()) ?>" value="<?php echo $actions_list->revisedOccurrence->EditValue ?>"<?php echo $actions_list->revisedOccurrence->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_revisedOccurrence" name="o<?php echo $actions_list->RowIndex ?>_revisedOccurrence" id="o<?php echo $actions_list->RowIndex ?>_revisedOccurrence" value="<?php echo HtmlEncode($actions_list->revisedOccurrence->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_revisedOccurrence" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_revisedOccurrence">
<span<?php echo $actions_list->revisedOccurrence->viewAttributes() ?>><?php echo $actions_list->revisedOccurrence->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->revisedDetection->Visible) { // revisedDetection ?>
		<td data-name="revisedDetection" <?php echo $actions_list->revisedDetection->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_revisedDetection" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_revisedDetection" class="form-group">
<input type="text" data-table="actions" data-field="x_revisedDetection" name="x<?php echo $actions_list->RowIndex ?>_revisedDetection" id="x<?php echo $actions_list->RowIndex ?>_revisedDetection" size="3" placeholder="<?php echo HtmlEncode($actions_list->revisedDetection->getPlaceHolder()) ?>" value="<?php echo $actions_list->revisedDetection->EditValue ?>"<?php echo $actions_list->revisedDetection->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_revisedDetection" name="o<?php echo $actions_list->RowIndex ?>_revisedDetection" id="o<?php echo $actions_list->RowIndex ?>_revisedDetection" value="<?php echo HtmlEncode($actions_list->revisedDetection->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_revisedDetection" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_revisedDetection">
<span<?php echo $actions_list->revisedDetection->viewAttributes() ?>><?php echo $actions_list->revisedDetection->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($actions_list->revisedRPNCalc->Visible) { // revisedRPNCalc ?>
		<td data-name="revisedRPNCalc" <?php echo $actions_list->revisedRPNCalc->cellAttributes() ?>>
<?php if ($actions->RowType == ROWTYPE_ADD) { // Add record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_revisedRPNCalc" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_revisedRPNCalc" class="form-group">
<input type="text" data-table="actions" data-field="x_revisedRPNCalc" name="x<?php echo $actions_list->RowIndex ?>_revisedRPNCalc" id="x<?php echo $actions_list->RowIndex ?>_revisedRPNCalc" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_list->revisedRPNCalc->getPlaceHolder()) ?>" value="<?php echo $actions_list->revisedRPNCalc->EditValue ?>"<?php echo $actions_list->revisedRPNCalc->editAttributes() ?>>
</span></script>
<input type="hidden" data-table="actions" data-field="x_revisedRPNCalc" name="o<?php echo $actions_list->RowIndex ?>_revisedRPNCalc" id="o<?php echo $actions_list->RowIndex ?>_revisedRPNCalc" value="<?php echo HtmlEncode($actions_list->revisedRPNCalc->OldValue) ?>">
<?php } ?>
<?php if ($actions->RowType == ROWTYPE_VIEW) { // View record ?>
<script id="tpx<?php echo $actions_list->RowCount ?>_actions_revisedRPNCalc" type="text/html"><span id="el<?php echo $actions_list->RowCount ?>_actions_revisedRPNCalc">
<span<?php echo $actions_list->revisedRPNCalc->viewAttributes() ?>><?php echo $actions_list->revisedRPNCalc->getViewValue() ?></span>
</span></script>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$actions_list->ListOptions->render("body", "right", $actions_list->RowCount, "block", $actions->TableVar, "actionslist");
?>
	</tr>
<?php if ($actions->RowType == ROWTYPE_ADD || $actions->RowType == ROWTYPE_EDIT) { ?>
<script class="actionslist_js" type="text/html">
loadjs.ready(["factionslist", "load"], function() {
	factionslist.updateLists(<?php echo $actions_list->RowIndex ?>);
});
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$actions_list->isGridAdd())
		if (!$actions_list->Recordset->EOF)
			$actions_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if ($actions_list->isAdd() || $actions_list->isCopy()) { ?>
<input type="hidden" name="<?php echo $actions_list->FormKeyCountName ?>" id="<?php echo $actions_list->FormKeyCountName ?>" value="<?php echo $actions_list->KeyCount ?>">
<?php } ?>
<?php if ($actions_list->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?php echo $actions_list->FormKeyCountName ?>" id="<?php echo $actions_list->FormKeyCountName ?>" value="<?php echo $actions_list->KeyCount ?>">
<?php echo $actions_list->MultiSelectKey ?>
<?php } ?>
<?php if (!$actions->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<div id="tpd_actionslist" class="ew-custom-template"></div>
<script id="tpm_actionslist" type="text/html">
<div id="ct_actions_list"><?php if ($actions_list->RowCount > 0) { ?>
<?php for ($i = $actions_list->StartRowCount; $i <= $actions_list->RowCount; $i++) { ?>

<table class="table">
	<thead><tr class="ew-table-header">{{include tmpl=~getTemplate("#tpob<?php echo $i ?>_actions")/}}<th>{{include tmpl=~getTemplate("#tpx_MyField1")/}}</th><th>{{include tmpl=~getTemplate("#tpx_MyField2")/}}</th></tr></thead>
	<tbody>

<?php } ?>
<?php } ?>
</div>
</script>

</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($actions_list->Recordset)
	$actions_list->Recordset->Close();
?>
<?php if (!$actions_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$actions_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $actions_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $actions_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($actions_list->TotalRecords == 0 && !$actions->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $actions_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script>
loadjs.ready(["jsrender", "makerjs"], function() {
	var $ = jQuery;
	ew.templateData = { rows: <?php echo json_encode($actions->Rows) ?> };
	ew.applyTemplate("tpd_actionslist", "tpm_actionslist", "actionslist", "<?php echo $actions->CustomExport ?>", ew.templateData);
	$("script.actionslist_js").each(function() {
		ew.addScript(this.text);
	});
});
</script>
<?php
$actions_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$actions_list->isExport()) { ?>
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
$actions_list->terminate();
?>