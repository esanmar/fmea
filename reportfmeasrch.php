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
$reportfmea_search = new reportfmea_search();

// Run the page
$reportfmea_search->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$reportfmea_search->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var freportfmeasearch, currentPageID;
loadjs.ready("head", function() {

	// Form object for search
	<?php if ($reportfmea_search->IsModal) { ?>
	freportfmeasearch = currentAdvancedSearchForm = new ew.Form("freportfmeasearch", "search");
	<?php } else { ?>
	freportfmeasearch = currentForm = new ew.Form("freportfmeasearch", "search");
	<?php } ?>
	currentPageID = ew.PAGE_ID = "search";

	// Validate function for search
	freportfmeasearch.validate = function(fobj) {
		if (!this.validateRequired)
			return true; // Ignore validation
		fobj = fobj || this._form;
		var infix = "";
		elm = this.getElements("x" + infix + "_dateFmea");
		if (elm && !ew.checkDateDef(elm.value))
			return this.onError(elm, "<?php echo JsEncode($reportfmea_search->dateFmea->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_idProcess");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($reportfmea_search->idProcess->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_step");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($reportfmea_search->step->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_severity");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($reportfmea_search->severity->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_occurrence");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($reportfmea_search->occurrence->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_detection");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($reportfmea_search->detection->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_rpn");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($reportfmea_search->rpn->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_targetDate");
		if (elm && !ew.checkDateDef(elm.value))
			return this.onError(elm, "<?php echo JsEncode($reportfmea_search->targetDate->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_expectedSeverity");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($reportfmea_search->expectedSeverity->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_expectedOccurrence");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($reportfmea_search->expectedOccurrence->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_expectedDetection");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($reportfmea_search->expectedDetection->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_expectedRpn");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($reportfmea_search->expectedRpn->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_expectedClosureDate");
		if (elm && !ew.checkDateDef(elm.value))
			return this.onError(elm, "<?php echo JsEncode($reportfmea_search->expectedClosureDate->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_targetDatedet");
		if (elm && !ew.checkDateDef(elm.value))
			return this.onError(elm, "<?php echo JsEncode($reportfmea_search->targetDatedet->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_expectedSeveritydet");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($reportfmea_search->expectedSeveritydet->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_expectedOccurrencedet");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($reportfmea_search->expectedOccurrencedet->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_expectedDetectiondet");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($reportfmea_search->expectedDetectiondet->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_expectedRpndet");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($reportfmea_search->expectedRpndet->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_revisedClosureDatedet");
		if (elm && !ew.checkDateDef(elm.value))
			return this.onError(elm, "<?php echo JsEncode($reportfmea_search->revisedClosureDatedet->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_revisedClosureDate");
		if (elm && !ew.checkDateDef(elm.value))
			return this.onError(elm, "<?php echo JsEncode($reportfmea_search->revisedClosureDate->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_revisedSeverity");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($reportfmea_search->revisedSeverity->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_revisedOccurrence");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($reportfmea_search->revisedOccurrence->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_revisedDetection");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($reportfmea_search->revisedDetection->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_revisedRpn");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($reportfmea_search->revisedRpn->errorMessage()) ?>");

		// Call Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
		return true;
	}

	// Form_CustomValidate
	freportfmeasearch.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	freportfmeasearch.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	freportfmeasearch.lists["x_fmea"] = <?php echo $reportfmea_search->fmea->Lookup->toClientList($reportfmea_search) ?>;
	freportfmeasearch.lists["x_fmea"].options = <?php echo JsonEncode($reportfmea_search->fmea->lookupOptions()) ?>;
	freportfmeasearch.lists["x_idFactory"] = <?php echo $reportfmea_search->idFactory->Lookup->toClientList($reportfmea_search) ?>;
	freportfmeasearch.lists["x_idFactory"].options = <?php echo JsonEncode($reportfmea_search->idFactory->lookupOptions()) ?>;
	freportfmeasearch.lists["x_idEmployee"] = <?php echo $reportfmea_search->idEmployee->Lookup->toClientList($reportfmea_search) ?>;
	freportfmeasearch.lists["x_idEmployee"].options = <?php echo JsonEncode($reportfmea_search->idEmployee->lookupOptions()) ?>;
	freportfmeasearch.lists["x_idworkcenter"] = <?php echo $reportfmea_search->idworkcenter->Lookup->toClientList($reportfmea_search) ?>;
	freportfmeasearch.lists["x_idworkcenter"].options = <?php echo JsonEncode($reportfmea_search->idworkcenter->lookupOptions()) ?>;
	freportfmeasearch.lists["x_derivedFromNC[]"] = <?php echo $reportfmea_search->derivedFromNC->Lookup->toClientList($reportfmea_search) ?>;
	freportfmeasearch.lists["x_derivedFromNC[]"].options = <?php echo JsonEncode($reportfmea_search->derivedFromNC->options(FALSE, TRUE)) ?>;
	freportfmeasearch.lists["x_kc[]"] = <?php echo $reportfmea_search->kc->Lookup->toClientList($reportfmea_search) ?>;
	freportfmeasearch.lists["x_kc[]"].options = <?php echo JsonEncode($reportfmea_search->kc->options(FALSE, TRUE)) ?>;
	freportfmeasearch.lists["x_idCause"] = <?php echo $reportfmea_search->idCause->Lookup->toClientList($reportfmea_search) ?>;
	freportfmeasearch.lists["x_idCause"].options = <?php echo JsonEncode($reportfmea_search->idCause->lookupOptions()) ?>;
	freportfmeasearch.lists["x_revisedKc[]"] = <?php echo $reportfmea_search->revisedKc->Lookup->toClientList($reportfmea_search) ?>;
	freportfmeasearch.lists["x_revisedKc[]"].options = <?php echo JsonEncode($reportfmea_search->revisedKc->options(FALSE, TRUE)) ?>;
	freportfmeasearch.lists["x_kcdet[]"] = <?php echo $reportfmea_search->kcdet->Lookup->toClientList($reportfmea_search) ?>;
	freportfmeasearch.lists["x_kcdet[]"].options = <?php echo JsonEncode($reportfmea_search->kcdet->options(FALSE, TRUE)) ?>;
	loadjs.done("freportfmeasearch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $reportfmea_search->showPageHeader(); ?>
<?php
$reportfmea_search->showMessage();
?>
<form name="freportfmeasearch" id="freportfmeasearch" class="<?php echo $reportfmea_search->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="reportfmea">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?php echo (int)$reportfmea_search->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($reportfmea_search->fmea->Visible) { // fmea ?>
	<div id="r_fmea" class="form-group row">
		<label for="x_fmea" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_fmea"><?php echo $reportfmea_search->fmea->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->fmea->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_fmea" id="z_fmea" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->fmea->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->fmea->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->fmea->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->fmea->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->fmea->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->fmea->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->fmea->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->fmea->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->fmea->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->fmea->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->fmea->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_fmea" class="ew-search-field">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="reportfmea" data-field="x_fmea" data-value-separator="<?php echo $reportfmea_search->fmea->displayValueSeparatorAttribute() ?>" id="x_fmea" name="x_fmea"<?php echo $reportfmea_search->fmea->editAttributes() ?>>
			<?php echo $reportfmea_search->fmea->selectOptionListHtml("x_fmea") ?>
		</select>
</div>
<?php echo $reportfmea_search->fmea->Lookup->getParamTag($reportfmea_search, "p_x_fmea") ?>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_fmea" class="ew-search-field2 d-none">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="reportfmea" data-field="x_fmea" data-value-separator="<?php echo $reportfmea_search->fmea->displayValueSeparatorAttribute() ?>" id="y_fmea" name="y_fmea"<?php echo $reportfmea_search->fmea->editAttributes() ?>>
			<?php echo $reportfmea_search->fmea->selectOptionListHtml("y_fmea") ?>
		</select>
</div>
<?php echo $reportfmea_search->fmea->Lookup->getParamTag($reportfmea_search, "p_y_fmea") ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->idFactory->Visible) { // idFactory ?>
	<div id="r_idFactory" class="form-group row">
		<label for="x_idFactory" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_idFactory"><?php echo $reportfmea_search->idFactory->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->idFactory->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_idFactory" id="z_idFactory" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->idFactory->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->idFactory->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->idFactory->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->idFactory->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->idFactory->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->idFactory->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->idFactory->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->idFactory->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->idFactory->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->idFactory->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->idFactory->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->idFactory->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->idFactory->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_idFactory" class="ew-search-field">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="reportfmea" data-field="x_idFactory" data-value-separator="<?php echo $reportfmea_search->idFactory->displayValueSeparatorAttribute() ?>" id="x_idFactory" name="x_idFactory"<?php echo $reportfmea_search->idFactory->editAttributes() ?>>
			<?php echo $reportfmea_search->idFactory->selectOptionListHtml("x_idFactory") ?>
		</select>
</div>
<?php echo $reportfmea_search->idFactory->Lookup->getParamTag($reportfmea_search, "p_x_idFactory") ?>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_idFactory" class="ew-search-field2 d-none">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="reportfmea" data-field="x_idFactory" data-value-separator="<?php echo $reportfmea_search->idFactory->displayValueSeparatorAttribute() ?>" id="y_idFactory" name="y_idFactory"<?php echo $reportfmea_search->idFactory->editAttributes() ?>>
			<?php echo $reportfmea_search->idFactory->selectOptionListHtml("y_idFactory") ?>
		</select>
</div>
<?php echo $reportfmea_search->idFactory->Lookup->getParamTag($reportfmea_search, "p_y_idFactory") ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->dateFmea->Visible) { // dateFmea ?>
	<div id="r_dateFmea" class="form-group row">
		<label for="x_dateFmea" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_dateFmea"><?php echo $reportfmea_search->dateFmea->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->dateFmea->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_dateFmea" id="z_dateFmea" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->dateFmea->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->dateFmea->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->dateFmea->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->dateFmea->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->dateFmea->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->dateFmea->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->dateFmea->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->dateFmea->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->dateFmea->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_dateFmea" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_dateFmea" name="x_dateFmea" id="x_dateFmea" maxlength="19" placeholder="<?php echo HtmlEncode($reportfmea_search->dateFmea->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->dateFmea->EditValue ?>"<?php echo $reportfmea_search->dateFmea->editAttributes() ?>>
<?php if (!$reportfmea_search->dateFmea->ReadOnly && !$reportfmea_search->dateFmea->Disabled && !isset($reportfmea_search->dateFmea->EditAttrs["readonly"]) && !isset($reportfmea_search->dateFmea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["freportfmeasearch", "datetimepicker"], function() {
	ew.createDateTimePicker("freportfmeasearch", "x_dateFmea", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
			<span class="ew-search-cond">
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_dateFmea_1" name="v_dateFmea" value="AND"<?php if ($reportfmea_search->dateFmea->AdvancedSearch->SearchCondition != "OR") echo " checked" ?>><label class="custom-control-label" for="v_dateFmea_1"><?php echo $Language->phrase("AND") ?></label></div>
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_dateFmea_2" name="v_dateFmea" value="OR"<?php if ($reportfmea_search->dateFmea->AdvancedSearch->SearchCondition == "OR") echo " checked" ?>><label class="custom-control-label" for="v_dateFmea_2"><?php echo $Language->phrase("OR") ?></label></div></span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span class="ew-search-operator2">
<select name="w_dateFmea" id="w_dateFmea" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->dateFmea->AdvancedSearch->SearchOperator2 == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->dateFmea->AdvancedSearch->SearchOperator2 == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->dateFmea->AdvancedSearch->SearchOperator2 == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->dateFmea->AdvancedSearch->SearchOperator2 == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->dateFmea->AdvancedSearch->SearchOperator2 == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->dateFmea->AdvancedSearch->SearchOperator2 == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->dateFmea->AdvancedSearch->SearchOperator2 == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->dateFmea->AdvancedSearch->SearchOperator2 == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
</select>
</span>
			<span id="el2_reportfmea_dateFmea" class="ew-search-field2">
<input type="text" data-table="reportfmea" data-field="x_dateFmea" name="y_dateFmea" id="y_dateFmea" maxlength="19" placeholder="<?php echo HtmlEncode($reportfmea_search->dateFmea->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->dateFmea->EditValue2 ?>"<?php echo $reportfmea_search->dateFmea->editAttributes() ?>>
<?php if (!$reportfmea_search->dateFmea->ReadOnly && !$reportfmea_search->dateFmea->Disabled && !isset($reportfmea_search->dateFmea->EditAttrs["readonly"]) && !isset($reportfmea_search->dateFmea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["freportfmeasearch", "datetimepicker"], function() {
	ew.createDateTimePicker("freportfmeasearch", "y_dateFmea", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->partnumbers->Visible) { // partnumbers ?>
	<div id="r_partnumbers" class="form-group row">
		<label for="x_partnumbers" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_partnumbers"><?php echo $reportfmea_search->partnumbers->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->partnumbers->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_partnumbers" id="z_partnumbers" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_partnumbers" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_partnumbers" name="x_partnumbers" id="x_partnumbers" size="35" placeholder="<?php echo HtmlEncode($reportfmea_search->partnumbers->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->partnumbers->EditValue ?>"<?php echo $reportfmea_search->partnumbers->editAttributes() ?>>
</span>
			<span class="ew-search-cond">
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_partnumbers_1" name="v_partnumbers" value="AND"<?php if ($reportfmea_search->partnumbers->AdvancedSearch->SearchCondition != "OR") echo " checked" ?>><label class="custom-control-label" for="v_partnumbers_1"><?php echo $Language->phrase("AND") ?></label></div>
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_partnumbers_2" name="v_partnumbers" value="OR"<?php if ($reportfmea_search->partnumbers->AdvancedSearch->SearchCondition == "OR") echo " checked" ?>><label class="custom-control-label" for="v_partnumbers_2"><?php echo $Language->phrase("OR") ?></label></div></span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span class="ew-search-operator2">
<select name="w_partnumbers" id="w_partnumbers" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator2 == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator2 == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator2 == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator2 == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator2 == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator2 == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator2 == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator2 == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator2 == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator2 == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator2 == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->partnumbers->AdvancedSearch->SearchOperator2 == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
</select>
</span>
			<span id="el2_reportfmea_partnumbers" class="ew-search-field2">
<input type="text" data-table="reportfmea" data-field="x_partnumbers" name="y_partnumbers" id="y_partnumbers" size="35" placeholder="<?php echo HtmlEncode($reportfmea_search->partnumbers->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->partnumbers->EditValue2 ?>"<?php echo $reportfmea_search->partnumbers->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->description->Visible) { // description ?>
	<div id="r_description" class="form-group row">
		<label for="x_description" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_description"><?php echo $reportfmea_search->description->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->description->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_description" id="z_description" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->description->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->description->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->description->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->description->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->description->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->description->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->description->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->description->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->description->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->description->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->description->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->description->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->description->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_description" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_description" name="x_description" id="x_description" size="35" placeholder="<?php echo HtmlEncode($reportfmea_search->description->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->description->EditValue ?>"<?php echo $reportfmea_search->description->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_description" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_description" name="y_description" id="y_description" size="35" placeholder="<?php echo HtmlEncode($reportfmea_search->description->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->description->EditValue2 ?>"<?php echo $reportfmea_search->description->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->idEmployee->Visible) { // idEmployee ?>
	<div id="r_idEmployee" class="form-group row">
		<label for="x_idEmployee" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_idEmployee"><?php echo $reportfmea_search->idEmployee->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->idEmployee->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_idEmployee" id="z_idEmployee" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->idEmployee->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->idEmployee->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->idEmployee->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->idEmployee->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->idEmployee->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->idEmployee->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->idEmployee->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->idEmployee->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->idEmployee->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->idEmployee->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->idEmployee->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->idEmployee->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->idEmployee->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_idEmployee" class="ew-search-field">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="reportfmea" data-field="x_idEmployee" data-value-separator="<?php echo $reportfmea_search->idEmployee->displayValueSeparatorAttribute() ?>" id="x_idEmployee" name="x_idEmployee"<?php echo $reportfmea_search->idEmployee->editAttributes() ?>>
			<?php echo $reportfmea_search->idEmployee->selectOptionListHtml("x_idEmployee") ?>
		</select>
</div>
<?php echo $reportfmea_search->idEmployee->Lookup->getParamTag($reportfmea_search, "p_x_idEmployee") ?>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_idEmployee" class="ew-search-field2 d-none">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="reportfmea" data-field="x_idEmployee" data-value-separator="<?php echo $reportfmea_search->idEmployee->displayValueSeparatorAttribute() ?>" id="y_idEmployee" name="y_idEmployee"<?php echo $reportfmea_search->idEmployee->editAttributes() ?>>
			<?php echo $reportfmea_search->idEmployee->selectOptionListHtml("y_idEmployee") ?>
		</select>
</div>
<?php echo $reportfmea_search->idEmployee->Lookup->getParamTag($reportfmea_search, "p_y_idEmployee") ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->idworkcenter->Visible) { // idworkcenter ?>
	<div id="r_idworkcenter" class="form-group row">
		<label for="x_idworkcenter" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_idworkcenter"><?php echo $reportfmea_search->idworkcenter->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->idworkcenter->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_idworkcenter" id="z_idworkcenter" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->idworkcenter->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->idworkcenter->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->idworkcenter->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->idworkcenter->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->idworkcenter->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->idworkcenter->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->idworkcenter->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->idworkcenter->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->idworkcenter->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->idworkcenter->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->idworkcenter->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->idworkcenter->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->idworkcenter->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_idworkcenter" class="ew-search-field">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="reportfmea" data-field="x_idworkcenter" data-value-separator="<?php echo $reportfmea_search->idworkcenter->displayValueSeparatorAttribute() ?>" id="x_idworkcenter" name="x_idworkcenter"<?php echo $reportfmea_search->idworkcenter->editAttributes() ?>>
			<?php echo $reportfmea_search->idworkcenter->selectOptionListHtml("x_idworkcenter") ?>
		</select>
</div>
<?php echo $reportfmea_search->idworkcenter->Lookup->getParamTag($reportfmea_search, "p_x_idworkcenter") ?>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_idworkcenter" class="ew-search-field2 d-none">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="reportfmea" data-field="x_idworkcenter" data-value-separator="<?php echo $reportfmea_search->idworkcenter->displayValueSeparatorAttribute() ?>" id="y_idworkcenter" name="y_idworkcenter"<?php echo $reportfmea_search->idworkcenter->editAttributes() ?>>
			<?php echo $reportfmea_search->idworkcenter->selectOptionListHtml("y_idworkcenter") ?>
		</select>
</div>
<?php echo $reportfmea_search->idworkcenter->Lookup->getParamTag($reportfmea_search, "p_y_idworkcenter") ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->idProcess->Visible) { // idProcess ?>
	<div id="r_idProcess" class="form-group row">
		<label for="x_idProcess" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_idProcess"><?php echo $reportfmea_search->idProcess->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->idProcess->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_idProcess" id="z_idProcess" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->idProcess->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->idProcess->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->idProcess->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->idProcess->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->idProcess->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->idProcess->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->idProcess->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_idProcess" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_idProcess" name="x_idProcess" id="x_idProcess" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->idProcess->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->idProcess->EditValue ?>"<?php echo $reportfmea_search->idProcess->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_idProcess" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_idProcess" name="y_idProcess" id="y_idProcess" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->idProcess->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->idProcess->EditValue2 ?>"<?php echo $reportfmea_search->idProcess->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->step->Visible) { // step ?>
	<div id="r_step" class="form-group row">
		<label for="x_step" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_step"><?php echo $reportfmea_search->step->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->step->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_step" id="z_step" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->step->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->step->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->step->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->step->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->step->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->step->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->step->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->step->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->step->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_step" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_step" name="x_step" id="x_step" size="30" maxlength="6" placeholder="<?php echo HtmlEncode($reportfmea_search->step->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->step->EditValue ?>"<?php echo $reportfmea_search->step->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_step" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_step" name="y_step" id="y_step" size="30" maxlength="6" placeholder="<?php echo HtmlEncode($reportfmea_search->step->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->step->EditValue2 ?>"<?php echo $reportfmea_search->step->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->flowchartDesc->Visible) { // flowchartDesc ?>
	<div id="r_flowchartDesc" class="form-group row">
		<label for="x_flowchartDesc" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_flowchartDesc"><?php echo $reportfmea_search->flowchartDesc->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->flowchartDesc->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_flowchartDesc" id="z_flowchartDesc" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->flowchartDesc->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->flowchartDesc->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->flowchartDesc->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->flowchartDesc->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->flowchartDesc->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->flowchartDesc->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->flowchartDesc->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->flowchartDesc->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->flowchartDesc->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->flowchartDesc->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->flowchartDesc->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->flowchartDesc->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->flowchartDesc->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_flowchartDesc" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_flowchartDesc" name="x_flowchartDesc" id="x_flowchartDesc" size="35" placeholder="<?php echo HtmlEncode($reportfmea_search->flowchartDesc->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->flowchartDesc->EditValue ?>"<?php echo $reportfmea_search->flowchartDesc->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_flowchartDesc" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_flowchartDesc" name="y_flowchartDesc" id="y_flowchartDesc" size="35" placeholder="<?php echo HtmlEncode($reportfmea_search->flowchartDesc->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->flowchartDesc->EditValue2 ?>"<?php echo $reportfmea_search->flowchartDesc->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->partnumber->Visible) { // partnumber ?>
	<div id="r_partnumber" class="form-group row">
		<label for="x_partnumber" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_partnumber"><?php echo $reportfmea_search->partnumber->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->partnumber->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_partnumber" id="z_partnumber" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->partnumber->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->partnumber->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->partnumber->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->partnumber->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->partnumber->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->partnumber->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->partnumber->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->partnumber->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->partnumber->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->partnumber->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->partnumber->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->partnumber->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->partnumber->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_partnumber" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_partnumber" name="x_partnumber" id="x_partnumber" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($reportfmea_search->partnumber->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->partnumber->EditValue ?>"<?php echo $reportfmea_search->partnumber->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_partnumber" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_partnumber" name="y_partnumber" id="y_partnumber" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($reportfmea_search->partnumber->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->partnumber->EditValue2 ?>"<?php echo $reportfmea_search->partnumber->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->operation->Visible) { // operation ?>
	<div id="r_operation" class="form-group row">
		<label for="x_operation" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_operation"><?php echo $reportfmea_search->operation->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->operation->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_operation" id="z_operation" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->operation->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->operation->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->operation->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->operation->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->operation->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->operation->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->operation->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->operation->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->operation->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->operation->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->operation->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->operation->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->operation->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_operation" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_operation" name="x_operation" id="x_operation" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($reportfmea_search->operation->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->operation->EditValue ?>"<?php echo $reportfmea_search->operation->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_operation" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_operation" name="y_operation" id="y_operation" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($reportfmea_search->operation->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->operation->EditValue2 ?>"<?php echo $reportfmea_search->operation->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->derivedFromNC->Visible) { // derivedFromNC ?>
	<div id="r_derivedFromNC" class="form-group row">
		<label class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_derivedFromNC"><?php echo $reportfmea_search->derivedFromNC->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->derivedFromNC->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_derivedFromNC" id="z_derivedFromNC" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->derivedFromNC->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->derivedFromNC->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->derivedFromNC->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->derivedFromNC->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->derivedFromNC->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->derivedFromNC->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->derivedFromNC->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->derivedFromNC->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->derivedFromNC->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->derivedFromNC->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->derivedFromNC->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->derivedFromNC->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->derivedFromNC->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_derivedFromNC" class="ew-search-field">
<?php
$selwrk = ConvertToBool($reportfmea_search->derivedFromNC->AdvancedSearch->SearchValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="reportfmea" data-field="x_derivedFromNC" name="x_derivedFromNC[]" id="x_derivedFromNC[]" value="1"<?php echo $selwrk ?><?php echo $reportfmea_search->derivedFromNC->editAttributes() ?>>
	<label class="custom-control-label" for="x_derivedFromNC[]"></label>
</div>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_derivedFromNC" class="ew-search-field2 d-none">
<?php
$selwrk = ConvertToBool($reportfmea_search->derivedFromNC->AdvancedSearch->SearchValue2) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="reportfmea" data-field="x_derivedFromNC" name="y_derivedFromNC[]" id="y_derivedFromNC[]" value="1"<?php echo $selwrk ?><?php echo $reportfmea_search->derivedFromNC->editAttributes() ?>>
	<label class="custom-control-label" for="y_derivedFromNC[]"></label>
</div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->numberOfNC->Visible) { // numberOfNC ?>
	<div id="r_numberOfNC" class="form-group row">
		<label for="x_numberOfNC" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_numberOfNC"><?php echo $reportfmea_search->numberOfNC->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->numberOfNC->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_numberOfNC" id="z_numberOfNC" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->numberOfNC->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->numberOfNC->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->numberOfNC->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->numberOfNC->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->numberOfNC->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->numberOfNC->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->numberOfNC->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->numberOfNC->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->numberOfNC->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->numberOfNC->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->numberOfNC->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->numberOfNC->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->numberOfNC->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_numberOfNC" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_numberOfNC" name="x_numberOfNC" id="x_numberOfNC" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($reportfmea_search->numberOfNC->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->numberOfNC->EditValue ?>"<?php echo $reportfmea_search->numberOfNC->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_numberOfNC" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_numberOfNC" name="y_numberOfNC" id="y_numberOfNC" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($reportfmea_search->numberOfNC->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->numberOfNC->EditValue2 ?>"<?php echo $reportfmea_search->numberOfNC->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->flowchart->Visible) { // flowchart ?>
	<div id="r_flowchart" class="form-group row">
		<label for="x_flowchart" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_flowchart"><?php echo $reportfmea_search->flowchart->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->flowchart->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_flowchart" id="z_flowchart" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->flowchart->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->flowchart->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->flowchart->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->flowchart->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->flowchart->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->flowchart->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->flowchart->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->flowchart->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->flowchart->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->flowchart->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->flowchart->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->flowchart->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->flowchart->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_flowchart" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_flowchart" name="x_flowchart" id="x_flowchart" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($reportfmea_search->flowchart->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->flowchart->EditValue ?>"<?php echo $reportfmea_search->flowchart->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_flowchart" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_flowchart" name="y_flowchart" id="y_flowchart" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($reportfmea_search->flowchart->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->flowchart->EditValue2 ?>"<?php echo $reportfmea_search->flowchart->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->subprocess->Visible) { // subprocess ?>
	<div id="r_subprocess" class="form-group row">
		<label for="x_subprocess" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_subprocess"><?php echo $reportfmea_search->subprocess->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->subprocess->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_subprocess" id="z_subprocess" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->subprocess->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->subprocess->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->subprocess->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->subprocess->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->subprocess->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->subprocess->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->subprocess->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->subprocess->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->subprocess->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->subprocess->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->subprocess->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->subprocess->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->subprocess->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_subprocess" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_subprocess" name="x_subprocess" id="x_subprocess" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($reportfmea_search->subprocess->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->subprocess->EditValue ?>"<?php echo $reportfmea_search->subprocess->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_subprocess" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_subprocess" name="y_subprocess" id="y_subprocess" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($reportfmea_search->subprocess->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->subprocess->EditValue2 ?>"<?php echo $reportfmea_search->subprocess->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->requirement->Visible) { // requirement ?>
	<div id="r_requirement" class="form-group row">
		<label for="x_requirement" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_requirement"><?php echo $reportfmea_search->requirement->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->requirement->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_requirement" id="z_requirement" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->requirement->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->requirement->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->requirement->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->requirement->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->requirement->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->requirement->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->requirement->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->requirement->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->requirement->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->requirement->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->requirement->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->requirement->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->requirement->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_requirement" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_requirement" name="x_requirement" id="x_requirement" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($reportfmea_search->requirement->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->requirement->EditValue ?>"<?php echo $reportfmea_search->requirement->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_requirement" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_requirement" name="y_requirement" id="y_requirement" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($reportfmea_search->requirement->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->requirement->EditValue2 ?>"<?php echo $reportfmea_search->requirement->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->potencialFailureMode->Visible) { // potencialFailureMode ?>
	<div id="r_potencialFailureMode" class="form-group row">
		<label for="x_potencialFailureMode" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_potencialFailureMode"><?php echo $reportfmea_search->potencialFailureMode->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->potencialFailureMode->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_potencialFailureMode" id="z_potencialFailureMode" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->potencialFailureMode->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->potencialFailureMode->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->potencialFailureMode->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->potencialFailureMode->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->potencialFailureMode->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->potencialFailureMode->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->potencialFailureMode->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->potencialFailureMode->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->potencialFailureMode->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->potencialFailureMode->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->potencialFailureMode->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->potencialFailureMode->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->potencialFailureMode->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_potencialFailureMode" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_potencialFailureMode" name="x_potencialFailureMode" id="x_potencialFailureMode" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($reportfmea_search->potencialFailureMode->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->potencialFailureMode->EditValue ?>"<?php echo $reportfmea_search->potencialFailureMode->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_potencialFailureMode" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_potencialFailureMode" name="y_potencialFailureMode" id="y_potencialFailureMode" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($reportfmea_search->potencialFailureMode->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->potencialFailureMode->EditValue2 ?>"<?php echo $reportfmea_search->potencialFailureMode->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->potencialFailurEffect->Visible) { // potencialFailurEffect ?>
	<div id="r_potencialFailurEffect" class="form-group row">
		<label for="x_potencialFailurEffect" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_potencialFailurEffect"><?php echo $reportfmea_search->potencialFailurEffect->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->potencialFailurEffect->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_potencialFailurEffect" id="z_potencialFailurEffect" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->potencialFailurEffect->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->potencialFailurEffect->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->potencialFailurEffect->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->potencialFailurEffect->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->potencialFailurEffect->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->potencialFailurEffect->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->potencialFailurEffect->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->potencialFailurEffect->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->potencialFailurEffect->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->potencialFailurEffect->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->potencialFailurEffect->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->potencialFailurEffect->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->potencialFailurEffect->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_potencialFailurEffect" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_potencialFailurEffect" name="x_potencialFailurEffect" id="x_potencialFailurEffect" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($reportfmea_search->potencialFailurEffect->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->potencialFailurEffect->EditValue ?>"<?php echo $reportfmea_search->potencialFailurEffect->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_potencialFailurEffect" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_potencialFailurEffect" name="y_potencialFailurEffect" id="y_potencialFailurEffect" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($reportfmea_search->potencialFailurEffect->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->potencialFailurEffect->EditValue2 ?>"<?php echo $reportfmea_search->potencialFailurEffect->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->kc->Visible) { // kc ?>
	<div id="r_kc" class="form-group row">
		<label class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_kc"><?php echo $reportfmea_search->kc->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->kc->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_kc" id="z_kc" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->kc->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->kc->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->kc->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->kc->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->kc->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->kc->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->kc->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->kc->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->kc->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->kc->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->kc->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->kc->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->kc->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_kc" class="ew-search-field">
<?php
$selwrk = ConvertToBool($reportfmea_search->kc->AdvancedSearch->SearchValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="reportfmea" data-field="x_kc" name="x_kc[]" id="x_kc[]" value="1"<?php echo $selwrk ?><?php echo $reportfmea_search->kc->editAttributes() ?>>
	<label class="custom-control-label" for="x_kc[]"></label>
</div>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_kc" class="ew-search-field2 d-none">
<?php
$selwrk = ConvertToBool($reportfmea_search->kc->AdvancedSearch->SearchValue2) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="reportfmea" data-field="x_kc" name="y_kc[]" id="y_kc[]" value="1"<?php echo $selwrk ?><?php echo $reportfmea_search->kc->editAttributes() ?>>
	<label class="custom-control-label" for="y_kc[]"></label>
</div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->severity->Visible) { // severity ?>
	<div id="r_severity" class="form-group row">
		<label for="x_severity" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_severity"><?php echo $reportfmea_search->severity->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->severity->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_severity" id="z_severity" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->severity->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->severity->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->severity->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->severity->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->severity->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->severity->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->severity->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->severity->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->severity->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_severity" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_severity" name="x_severity" id="x_severity" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->severity->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->severity->EditValue ?>"<?php echo $reportfmea_search->severity->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_severity" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_severity" name="y_severity" id="y_severity" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->severity->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->severity->EditValue2 ?>"<?php echo $reportfmea_search->severity->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->idCause->Visible) { // idCause ?>
	<div id="r_idCause" class="form-group row">
		<label for="x_idCause" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_idCause"><?php echo $reportfmea_search->idCause->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->idCause->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_idCause" id="z_idCause" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->idCause->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->idCause->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->idCause->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->idCause->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->idCause->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->idCause->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->idCause->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->idCause->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->idCause->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->idCause->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->idCause->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_idCause" class="ew-search-field">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="reportfmea" data-field="x_idCause" data-value-separator="<?php echo $reportfmea_search->idCause->displayValueSeparatorAttribute() ?>" id="x_idCause" name="x_idCause"<?php echo $reportfmea_search->idCause->editAttributes() ?>>
			<?php echo $reportfmea_search->idCause->selectOptionListHtml("x_idCause") ?>
		</select>
</div>
<?php echo $reportfmea_search->idCause->Lookup->getParamTag($reportfmea_search, "p_x_idCause") ?>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_idCause" class="ew-search-field2 d-none">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="reportfmea" data-field="x_idCause" data-value-separator="<?php echo $reportfmea_search->idCause->displayValueSeparatorAttribute() ?>" id="y_idCause" name="y_idCause"<?php echo $reportfmea_search->idCause->editAttributes() ?>>
			<?php echo $reportfmea_search->idCause->selectOptionListHtml("y_idCause") ?>
		</select>
</div>
<?php echo $reportfmea_search->idCause->Lookup->getParamTag($reportfmea_search, "p_y_idCause") ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->potentialCauses->Visible) { // potentialCauses ?>
	<div id="r_potentialCauses" class="form-group row">
		<label for="x_potentialCauses" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_potentialCauses"><?php echo $reportfmea_search->potentialCauses->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->potentialCauses->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_potentialCauses" id="z_potentialCauses" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->potentialCauses->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->potentialCauses->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->potentialCauses->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->potentialCauses->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->potentialCauses->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->potentialCauses->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->potentialCauses->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->potentialCauses->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->potentialCauses->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->potentialCauses->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->potentialCauses->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->potentialCauses->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->potentialCauses->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_potentialCauses" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_potentialCauses" name="x_potentialCauses" id="x_potentialCauses" size="35" placeholder="<?php echo HtmlEncode($reportfmea_search->potentialCauses->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->potentialCauses->EditValue ?>"<?php echo $reportfmea_search->potentialCauses->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_potentialCauses" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_potentialCauses" name="y_potentialCauses" id="y_potentialCauses" size="35" placeholder="<?php echo HtmlEncode($reportfmea_search->potentialCauses->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->potentialCauses->EditValue2 ?>"<?php echo $reportfmea_search->potentialCauses->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->currentPreventiveControlMethod->Visible) { // currentPreventiveControlMethod ?>
	<div id="r_currentPreventiveControlMethod" class="form-group row">
		<label for="x_currentPreventiveControlMethod" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_currentPreventiveControlMethod"><?php echo $reportfmea_search->currentPreventiveControlMethod->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->currentPreventiveControlMethod->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_currentPreventiveControlMethod" id="z_currentPreventiveControlMethod" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_currentPreventiveControlMethod" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_currentPreventiveControlMethod" name="x_currentPreventiveControlMethod" id="x_currentPreventiveControlMethod" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($reportfmea_search->currentPreventiveControlMethod->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->currentPreventiveControlMethod->EditValue ?>"<?php echo $reportfmea_search->currentPreventiveControlMethod->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_currentPreventiveControlMethod" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_currentPreventiveControlMethod" name="y_currentPreventiveControlMethod" id="y_currentPreventiveControlMethod" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($reportfmea_search->currentPreventiveControlMethod->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->currentPreventiveControlMethod->EditValue2 ?>"<?php echo $reportfmea_search->currentPreventiveControlMethod->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->occurrence->Visible) { // occurrence ?>
	<div id="r_occurrence" class="form-group row">
		<label for="x_occurrence" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_occurrence"><?php echo $reportfmea_search->occurrence->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->occurrence->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_occurrence" id="z_occurrence" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->occurrence->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->occurrence->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->occurrence->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->occurrence->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->occurrence->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->occurrence->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->occurrence->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->occurrence->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->occurrence->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_occurrence" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_occurrence" name="x_occurrence" id="x_occurrence" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->occurrence->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->occurrence->EditValue ?>"<?php echo $reportfmea_search->occurrence->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_occurrence" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_occurrence" name="y_occurrence" id="y_occurrence" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->occurrence->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->occurrence->EditValue2 ?>"<?php echo $reportfmea_search->occurrence->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->currentControlMethod->Visible) { // currentControlMethod ?>
	<div id="r_currentControlMethod" class="form-group row">
		<label for="x_currentControlMethod" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_currentControlMethod"><?php echo $reportfmea_search->currentControlMethod->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->currentControlMethod->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_currentControlMethod" id="z_currentControlMethod" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->currentControlMethod->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->currentControlMethod->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->currentControlMethod->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->currentControlMethod->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->currentControlMethod->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->currentControlMethod->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->currentControlMethod->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->currentControlMethod->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->currentControlMethod->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->currentControlMethod->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->currentControlMethod->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->currentControlMethod->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->currentControlMethod->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_currentControlMethod" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_currentControlMethod" name="x_currentControlMethod" id="x_currentControlMethod" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($reportfmea_search->currentControlMethod->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->currentControlMethod->EditValue ?>"<?php echo $reportfmea_search->currentControlMethod->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_currentControlMethod" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_currentControlMethod" name="y_currentControlMethod" id="y_currentControlMethod" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($reportfmea_search->currentControlMethod->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->currentControlMethod->EditValue2 ?>"<?php echo $reportfmea_search->currentControlMethod->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->detection->Visible) { // detection ?>
	<div id="r_detection" class="form-group row">
		<label for="x_detection" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_detection"><?php echo $reportfmea_search->detection->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->detection->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_detection" id="z_detection" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->detection->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->detection->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->detection->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->detection->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->detection->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->detection->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->detection->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->detection->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->detection->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_detection" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_detection" name="x_detection" id="x_detection" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->detection->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->detection->EditValue ?>"<?php echo $reportfmea_search->detection->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_detection" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_detection" name="y_detection" id="y_detection" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->detection->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->detection->EditValue2 ?>"<?php echo $reportfmea_search->detection->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->rpn->Visible) { // rpn ?>
	<div id="r_rpn" class="form-group row">
		<label for="x_rpn" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_rpn"><?php echo $reportfmea_search->rpn->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->rpn->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_rpn" id="z_rpn" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->rpn->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->rpn->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->rpn->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->rpn->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->rpn->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->rpn->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->rpn->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->rpn->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->rpn->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_rpn" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_rpn" name="x_rpn" id="x_rpn" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->rpn->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->rpn->EditValue ?>"<?php echo $reportfmea_search->rpn->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_rpn" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_rpn" name="y_rpn" id="y_rpn" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->rpn->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->rpn->EditValue2 ?>"<?php echo $reportfmea_search->rpn->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->recomendedAction->Visible) { // recomendedAction ?>
	<div id="r_recomendedAction" class="form-group row">
		<label for="x_recomendedAction" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_recomendedAction"><?php echo $reportfmea_search->recomendedAction->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->recomendedAction->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_recomendedAction" id="z_recomendedAction" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->recomendedAction->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->recomendedAction->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->recomendedAction->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->recomendedAction->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->recomendedAction->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->recomendedAction->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->recomendedAction->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->recomendedAction->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->recomendedAction->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->recomendedAction->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->recomendedAction->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->recomendedAction->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->recomendedAction->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_recomendedAction" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_recomendedAction" name="x_recomendedAction" id="x_recomendedAction" size="35" placeholder="<?php echo HtmlEncode($reportfmea_search->recomendedAction->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->recomendedAction->EditValue ?>"<?php echo $reportfmea_search->recomendedAction->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_recomendedAction" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_recomendedAction" name="y_recomendedAction" id="y_recomendedAction" size="35" placeholder="<?php echo HtmlEncode($reportfmea_search->recomendedAction->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->recomendedAction->EditValue2 ?>"<?php echo $reportfmea_search->recomendedAction->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->idResponsible->Visible) { // idResponsible ?>
	<div id="r_idResponsible" class="form-group row">
		<label for="x_idResponsible" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_idResponsible"><?php echo $reportfmea_search->idResponsible->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->idResponsible->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_idResponsible" id="z_idResponsible" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->idResponsible->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->idResponsible->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->idResponsible->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->idResponsible->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->idResponsible->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->idResponsible->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->idResponsible->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->idResponsible->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->idResponsible->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->idResponsible->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->idResponsible->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->idResponsible->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->idResponsible->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_idResponsible" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_idResponsible" name="x_idResponsible" id="x_idResponsible" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($reportfmea_search->idResponsible->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->idResponsible->EditValue ?>"<?php echo $reportfmea_search->idResponsible->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_idResponsible" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_idResponsible" name="y_idResponsible" id="y_idResponsible" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($reportfmea_search->idResponsible->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->idResponsible->EditValue2 ?>"<?php echo $reportfmea_search->idResponsible->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->targetDate->Visible) { // targetDate ?>
	<div id="r_targetDate" class="form-group row">
		<label for="x_targetDate" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_targetDate"><?php echo $reportfmea_search->targetDate->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->targetDate->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_targetDate" id="z_targetDate" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->targetDate->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->targetDate->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->targetDate->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->targetDate->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->targetDate->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->targetDate->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->targetDate->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->targetDate->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->targetDate->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_targetDate" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_targetDate" name="x_targetDate" id="x_targetDate" maxlength="19" placeholder="<?php echo HtmlEncode($reportfmea_search->targetDate->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->targetDate->EditValue ?>"<?php echo $reportfmea_search->targetDate->editAttributes() ?>>
<?php if (!$reportfmea_search->targetDate->ReadOnly && !$reportfmea_search->targetDate->Disabled && !isset($reportfmea_search->targetDate->EditAttrs["readonly"]) && !isset($reportfmea_search->targetDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["freportfmeasearch", "datetimepicker"], function() {
	ew.createDateTimePicker("freportfmeasearch", "x_targetDate", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_targetDate" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_targetDate" name="y_targetDate" id="y_targetDate" maxlength="19" placeholder="<?php echo HtmlEncode($reportfmea_search->targetDate->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->targetDate->EditValue2 ?>"<?php echo $reportfmea_search->targetDate->editAttributes() ?>>
<?php if (!$reportfmea_search->targetDate->ReadOnly && !$reportfmea_search->targetDate->Disabled && !isset($reportfmea_search->targetDate->EditAttrs["readonly"]) && !isset($reportfmea_search->targetDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["freportfmeasearch", "datetimepicker"], function() {
	ew.createDateTimePicker("freportfmeasearch", "y_targetDate", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->revisedKc->Visible) { // revisedKc ?>
	<div id="r_revisedKc" class="form-group row">
		<label class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_revisedKc"><?php echo $reportfmea_search->revisedKc->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->revisedKc->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_revisedKc" id="z_revisedKc" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->revisedKc->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->revisedKc->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->revisedKc->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->revisedKc->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->revisedKc->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->revisedKc->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->revisedKc->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->revisedKc->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->revisedKc->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->revisedKc->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->revisedKc->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->revisedKc->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->revisedKc->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_revisedKc" class="ew-search-field">
<?php
$selwrk = ConvertToBool($reportfmea_search->revisedKc->AdvancedSearch->SearchValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="reportfmea" data-field="x_revisedKc" name="x_revisedKc[]" id="x_revisedKc[]" value="1"<?php echo $selwrk ?><?php echo $reportfmea_search->revisedKc->editAttributes() ?>>
	<label class="custom-control-label" for="x_revisedKc[]"></label>
</div>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_revisedKc" class="ew-search-field2 d-none">
<?php
$selwrk = ConvertToBool($reportfmea_search->revisedKc->AdvancedSearch->SearchValue2) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="reportfmea" data-field="x_revisedKc" name="y_revisedKc[]" id="y_revisedKc[]" value="1"<?php echo $selwrk ?><?php echo $reportfmea_search->revisedKc->editAttributes() ?>>
	<label class="custom-control-label" for="y_revisedKc[]"></label>
</div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->expectedSeverity->Visible) { // expectedSeverity ?>
	<div id="r_expectedSeverity" class="form-group row">
		<label for="x_expectedSeverity" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_expectedSeverity"><?php echo $reportfmea_search->expectedSeverity->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->expectedSeverity->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_expectedSeverity" id="z_expectedSeverity" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->expectedSeverity->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->expectedSeverity->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->expectedSeverity->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->expectedSeverity->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->expectedSeverity->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->expectedSeverity->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->expectedSeverity->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->expectedSeverity->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->expectedSeverity->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_expectedSeverity" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_expectedSeverity" name="x_expectedSeverity" id="x_expectedSeverity" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->expectedSeverity->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->expectedSeverity->EditValue ?>"<?php echo $reportfmea_search->expectedSeverity->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_expectedSeverity" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_expectedSeverity" name="y_expectedSeverity" id="y_expectedSeverity" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->expectedSeverity->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->expectedSeverity->EditValue2 ?>"<?php echo $reportfmea_search->expectedSeverity->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->expectedOccurrence->Visible) { // expectedOccurrence ?>
	<div id="r_expectedOccurrence" class="form-group row">
		<label for="x_expectedOccurrence" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_expectedOccurrence"><?php echo $reportfmea_search->expectedOccurrence->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->expectedOccurrence->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_expectedOccurrence" id="z_expectedOccurrence" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->expectedOccurrence->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->expectedOccurrence->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->expectedOccurrence->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->expectedOccurrence->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->expectedOccurrence->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->expectedOccurrence->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->expectedOccurrence->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->expectedOccurrence->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->expectedOccurrence->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_expectedOccurrence" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_expectedOccurrence" name="x_expectedOccurrence" id="x_expectedOccurrence" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->expectedOccurrence->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->expectedOccurrence->EditValue ?>"<?php echo $reportfmea_search->expectedOccurrence->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_expectedOccurrence" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_expectedOccurrence" name="y_expectedOccurrence" id="y_expectedOccurrence" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->expectedOccurrence->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->expectedOccurrence->EditValue2 ?>"<?php echo $reportfmea_search->expectedOccurrence->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->expectedDetection->Visible) { // expectedDetection ?>
	<div id="r_expectedDetection" class="form-group row">
		<label for="x_expectedDetection" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_expectedDetection"><?php echo $reportfmea_search->expectedDetection->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->expectedDetection->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_expectedDetection" id="z_expectedDetection" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->expectedDetection->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->expectedDetection->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->expectedDetection->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->expectedDetection->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->expectedDetection->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->expectedDetection->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->expectedDetection->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->expectedDetection->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->expectedDetection->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_expectedDetection" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_expectedDetection" name="x_expectedDetection" id="x_expectedDetection" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->expectedDetection->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->expectedDetection->EditValue ?>"<?php echo $reportfmea_search->expectedDetection->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_expectedDetection" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_expectedDetection" name="y_expectedDetection" id="y_expectedDetection" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->expectedDetection->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->expectedDetection->EditValue2 ?>"<?php echo $reportfmea_search->expectedDetection->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->expectedRpn->Visible) { // expectedRpn ?>
	<div id="r_expectedRpn" class="form-group row">
		<label for="x_expectedRpn" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_expectedRpn"><?php echo $reportfmea_search->expectedRpn->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->expectedRpn->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_expectedRpn" id="z_expectedRpn" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->expectedRpn->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->expectedRpn->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->expectedRpn->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->expectedRpn->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->expectedRpn->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->expectedRpn->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->expectedRpn->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->expectedRpn->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->expectedRpn->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_expectedRpn" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_expectedRpn" name="x_expectedRpn" id="x_expectedRpn" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->expectedRpn->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->expectedRpn->EditValue ?>"<?php echo $reportfmea_search->expectedRpn->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_expectedRpn" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_expectedRpn" name="y_expectedRpn" id="y_expectedRpn" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->expectedRpn->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->expectedRpn->EditValue2 ?>"<?php echo $reportfmea_search->expectedRpn->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->expectedClosureDate->Visible) { // expectedClosureDate ?>
	<div id="r_expectedClosureDate" class="form-group row">
		<label for="x_expectedClosureDate" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_expectedClosureDate"><?php echo $reportfmea_search->expectedClosureDate->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->expectedClosureDate->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_expectedClosureDate" id="z_expectedClosureDate" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->expectedClosureDate->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->expectedClosureDate->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->expectedClosureDate->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->expectedClosureDate->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->expectedClosureDate->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->expectedClosureDate->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->expectedClosureDate->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->expectedClosureDate->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->expectedClosureDate->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_expectedClosureDate" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_expectedClosureDate" name="x_expectedClosureDate" id="x_expectedClosureDate" maxlength="19" placeholder="<?php echo HtmlEncode($reportfmea_search->expectedClosureDate->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->expectedClosureDate->EditValue ?>"<?php echo $reportfmea_search->expectedClosureDate->editAttributes() ?>>
<?php if (!$reportfmea_search->expectedClosureDate->ReadOnly && !$reportfmea_search->expectedClosureDate->Disabled && !isset($reportfmea_search->expectedClosureDate->EditAttrs["readonly"]) && !isset($reportfmea_search->expectedClosureDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["freportfmeasearch", "datetimepicker"], function() {
	ew.createDateTimePicker("freportfmeasearch", "x_expectedClosureDate", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_expectedClosureDate" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_expectedClosureDate" name="y_expectedClosureDate" id="y_expectedClosureDate" maxlength="19" placeholder="<?php echo HtmlEncode($reportfmea_search->expectedClosureDate->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->expectedClosureDate->EditValue2 ?>"<?php echo $reportfmea_search->expectedClosureDate->editAttributes() ?>>
<?php if (!$reportfmea_search->expectedClosureDate->ReadOnly && !$reportfmea_search->expectedClosureDate->Disabled && !isset($reportfmea_search->expectedClosureDate->EditAttrs["readonly"]) && !isset($reportfmea_search->expectedClosureDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["freportfmeasearch", "datetimepicker"], function() {
	ew.createDateTimePicker("freportfmeasearch", "y_expectedClosureDate", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->recomendedActiondet->Visible) { // recomendedActiondet ?>
	<div id="r_recomendedActiondet" class="form-group row">
		<label for="x_recomendedActiondet" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_recomendedActiondet"><?php echo $reportfmea_search->recomendedActiondet->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->recomendedActiondet->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_recomendedActiondet" id="z_recomendedActiondet" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->recomendedActiondet->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->recomendedActiondet->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->recomendedActiondet->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->recomendedActiondet->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->recomendedActiondet->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->recomendedActiondet->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->recomendedActiondet->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->recomendedActiondet->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->recomendedActiondet->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->recomendedActiondet->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->recomendedActiondet->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->recomendedActiondet->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->recomendedActiondet->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_recomendedActiondet" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_recomendedActiondet" name="x_recomendedActiondet" id="x_recomendedActiondet" size="35" placeholder="<?php echo HtmlEncode($reportfmea_search->recomendedActiondet->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->recomendedActiondet->EditValue ?>"<?php echo $reportfmea_search->recomendedActiondet->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_recomendedActiondet" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_recomendedActiondet" name="y_recomendedActiondet" id="y_recomendedActiondet" size="35" placeholder="<?php echo HtmlEncode($reportfmea_search->recomendedActiondet->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->recomendedActiondet->EditValue2 ?>"<?php echo $reportfmea_search->recomendedActiondet->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->idResponsibleDet->Visible) { // idResponsibleDet ?>
	<div id="r_idResponsibleDet" class="form-group row">
		<label for="x_idResponsibleDet" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_idResponsibleDet"><?php echo $reportfmea_search->idResponsibleDet->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->idResponsibleDet->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_idResponsibleDet" id="z_idResponsibleDet" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->idResponsibleDet->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->idResponsibleDet->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->idResponsibleDet->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->idResponsibleDet->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->idResponsibleDet->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->idResponsibleDet->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->idResponsibleDet->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->idResponsibleDet->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->idResponsibleDet->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->idResponsibleDet->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->idResponsibleDet->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->idResponsibleDet->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->idResponsibleDet->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_idResponsibleDet" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_idResponsibleDet" name="x_idResponsibleDet" id="x_idResponsibleDet" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($reportfmea_search->idResponsibleDet->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->idResponsibleDet->EditValue ?>"<?php echo $reportfmea_search->idResponsibleDet->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_idResponsibleDet" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_idResponsibleDet" name="y_idResponsibleDet" id="y_idResponsibleDet" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($reportfmea_search->idResponsibleDet->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->idResponsibleDet->EditValue2 ?>"<?php echo $reportfmea_search->idResponsibleDet->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->targetDatedet->Visible) { // targetDatedet ?>
	<div id="r_targetDatedet" class="form-group row">
		<label for="x_targetDatedet" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_targetDatedet"><?php echo $reportfmea_search->targetDatedet->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->targetDatedet->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_targetDatedet" id="z_targetDatedet" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->targetDatedet->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->targetDatedet->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->targetDatedet->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->targetDatedet->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->targetDatedet->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->targetDatedet->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->targetDatedet->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->targetDatedet->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->targetDatedet->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_targetDatedet" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_targetDatedet" name="x_targetDatedet" id="x_targetDatedet" maxlength="19" placeholder="<?php echo HtmlEncode($reportfmea_search->targetDatedet->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->targetDatedet->EditValue ?>"<?php echo $reportfmea_search->targetDatedet->editAttributes() ?>>
<?php if (!$reportfmea_search->targetDatedet->ReadOnly && !$reportfmea_search->targetDatedet->Disabled && !isset($reportfmea_search->targetDatedet->EditAttrs["readonly"]) && !isset($reportfmea_search->targetDatedet->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["freportfmeasearch", "datetimepicker"], function() {
	ew.createDateTimePicker("freportfmeasearch", "x_targetDatedet", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_targetDatedet" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_targetDatedet" name="y_targetDatedet" id="y_targetDatedet" maxlength="19" placeholder="<?php echo HtmlEncode($reportfmea_search->targetDatedet->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->targetDatedet->EditValue2 ?>"<?php echo $reportfmea_search->targetDatedet->editAttributes() ?>>
<?php if (!$reportfmea_search->targetDatedet->ReadOnly && !$reportfmea_search->targetDatedet->Disabled && !isset($reportfmea_search->targetDatedet->EditAttrs["readonly"]) && !isset($reportfmea_search->targetDatedet->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["freportfmeasearch", "datetimepicker"], function() {
	ew.createDateTimePicker("freportfmeasearch", "y_targetDatedet", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->kcdet->Visible) { // kcdet ?>
	<div id="r_kcdet" class="form-group row">
		<label class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_kcdet"><?php echo $reportfmea_search->kcdet->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->kcdet->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_kcdet" id="z_kcdet" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->kcdet->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->kcdet->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->kcdet->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->kcdet->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->kcdet->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->kcdet->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->kcdet->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->kcdet->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->kcdet->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->kcdet->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->kcdet->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->kcdet->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->kcdet->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_kcdet" class="ew-search-field">
<?php
$selwrk = ConvertToBool($reportfmea_search->kcdet->AdvancedSearch->SearchValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="reportfmea" data-field="x_kcdet" name="x_kcdet[]" id="x_kcdet[]" value="1"<?php echo $selwrk ?><?php echo $reportfmea_search->kcdet->editAttributes() ?>>
	<label class="custom-control-label" for="x_kcdet[]"></label>
</div>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_kcdet" class="ew-search-field2 d-none">
<?php
$selwrk = ConvertToBool($reportfmea_search->kcdet->AdvancedSearch->SearchValue2) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="reportfmea" data-field="x_kcdet" name="y_kcdet[]" id="y_kcdet[]" value="1"<?php echo $selwrk ?><?php echo $reportfmea_search->kcdet->editAttributes() ?>>
	<label class="custom-control-label" for="y_kcdet[]"></label>
</div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->expectedSeveritydet->Visible) { // expectedSeveritydet ?>
	<div id="r_expectedSeveritydet" class="form-group row">
		<label for="x_expectedSeveritydet" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_expectedSeveritydet"><?php echo $reportfmea_search->expectedSeveritydet->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->expectedSeveritydet->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_expectedSeveritydet" id="z_expectedSeveritydet" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->expectedSeveritydet->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->expectedSeveritydet->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->expectedSeveritydet->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->expectedSeveritydet->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->expectedSeveritydet->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->expectedSeveritydet->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->expectedSeveritydet->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->expectedSeveritydet->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->expectedSeveritydet->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_expectedSeveritydet" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_expectedSeveritydet" name="x_expectedSeveritydet" id="x_expectedSeveritydet" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->expectedSeveritydet->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->expectedSeveritydet->EditValue ?>"<?php echo $reportfmea_search->expectedSeveritydet->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_expectedSeveritydet" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_expectedSeveritydet" name="y_expectedSeveritydet" id="y_expectedSeveritydet" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->expectedSeveritydet->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->expectedSeveritydet->EditValue2 ?>"<?php echo $reportfmea_search->expectedSeveritydet->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->expectedOccurrencedet->Visible) { // expectedOccurrencedet ?>
	<div id="r_expectedOccurrencedet" class="form-group row">
		<label for="x_expectedOccurrencedet" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_expectedOccurrencedet"><?php echo $reportfmea_search->expectedOccurrencedet->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->expectedOccurrencedet->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_expectedOccurrencedet" id="z_expectedOccurrencedet" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->expectedOccurrencedet->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->expectedOccurrencedet->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->expectedOccurrencedet->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->expectedOccurrencedet->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->expectedOccurrencedet->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->expectedOccurrencedet->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->expectedOccurrencedet->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->expectedOccurrencedet->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->expectedOccurrencedet->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_expectedOccurrencedet" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_expectedOccurrencedet" name="x_expectedOccurrencedet" id="x_expectedOccurrencedet" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->expectedOccurrencedet->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->expectedOccurrencedet->EditValue ?>"<?php echo $reportfmea_search->expectedOccurrencedet->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_expectedOccurrencedet" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_expectedOccurrencedet" name="y_expectedOccurrencedet" id="y_expectedOccurrencedet" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->expectedOccurrencedet->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->expectedOccurrencedet->EditValue2 ?>"<?php echo $reportfmea_search->expectedOccurrencedet->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->expectedDetectiondet->Visible) { // expectedDetectiondet ?>
	<div id="r_expectedDetectiondet" class="form-group row">
		<label for="x_expectedDetectiondet" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_expectedDetectiondet"><?php echo $reportfmea_search->expectedDetectiondet->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->expectedDetectiondet->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_expectedDetectiondet" id="z_expectedDetectiondet" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->expectedDetectiondet->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->expectedDetectiondet->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->expectedDetectiondet->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->expectedDetectiondet->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->expectedDetectiondet->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->expectedDetectiondet->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->expectedDetectiondet->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->expectedDetectiondet->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->expectedDetectiondet->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_expectedDetectiondet" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_expectedDetectiondet" name="x_expectedDetectiondet" id="x_expectedDetectiondet" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->expectedDetectiondet->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->expectedDetectiondet->EditValue ?>"<?php echo $reportfmea_search->expectedDetectiondet->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_expectedDetectiondet" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_expectedDetectiondet" name="y_expectedDetectiondet" id="y_expectedDetectiondet" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->expectedDetectiondet->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->expectedDetectiondet->EditValue2 ?>"<?php echo $reportfmea_search->expectedDetectiondet->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->expectedRpndet->Visible) { // expectedRpndet ?>
	<div id="r_expectedRpndet" class="form-group row">
		<label for="x_expectedRpndet" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_expectedRpndet"><?php echo $reportfmea_search->expectedRpndet->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->expectedRpndet->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_expectedRpndet" id="z_expectedRpndet" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->expectedRpndet->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->expectedRpndet->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->expectedRpndet->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->expectedRpndet->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->expectedRpndet->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->expectedRpndet->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->expectedRpndet->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->expectedRpndet->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->expectedRpndet->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_expectedRpndet" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_expectedRpndet" name="x_expectedRpndet" id="x_expectedRpndet" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->expectedRpndet->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->expectedRpndet->EditValue ?>"<?php echo $reportfmea_search->expectedRpndet->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_expectedRpndet" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_expectedRpndet" name="y_expectedRpndet" id="y_expectedRpndet" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->expectedRpndet->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->expectedRpndet->EditValue2 ?>"<?php echo $reportfmea_search->expectedRpndet->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->revisedClosureDatedet->Visible) { // revisedClosureDatedet ?>
	<div id="r_revisedClosureDatedet" class="form-group row">
		<label for="x_revisedClosureDatedet" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_revisedClosureDatedet"><?php echo $reportfmea_search->revisedClosureDatedet->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->revisedClosureDatedet->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_revisedClosureDatedet" id="z_revisedClosureDatedet" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->revisedClosureDatedet->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->revisedClosureDatedet->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->revisedClosureDatedet->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->revisedClosureDatedet->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->revisedClosureDatedet->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->revisedClosureDatedet->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->revisedClosureDatedet->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->revisedClosureDatedet->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->revisedClosureDatedet->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_revisedClosureDatedet" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_revisedClosureDatedet" name="x_revisedClosureDatedet" id="x_revisedClosureDatedet" maxlength="19" placeholder="<?php echo HtmlEncode($reportfmea_search->revisedClosureDatedet->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->revisedClosureDatedet->EditValue ?>"<?php echo $reportfmea_search->revisedClosureDatedet->editAttributes() ?>>
<?php if (!$reportfmea_search->revisedClosureDatedet->ReadOnly && !$reportfmea_search->revisedClosureDatedet->Disabled && !isset($reportfmea_search->revisedClosureDatedet->EditAttrs["readonly"]) && !isset($reportfmea_search->revisedClosureDatedet->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["freportfmeasearch", "datetimepicker"], function() {
	ew.createDateTimePicker("freportfmeasearch", "x_revisedClosureDatedet", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_revisedClosureDatedet" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_revisedClosureDatedet" name="y_revisedClosureDatedet" id="y_revisedClosureDatedet" maxlength="19" placeholder="<?php echo HtmlEncode($reportfmea_search->revisedClosureDatedet->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->revisedClosureDatedet->EditValue2 ?>"<?php echo $reportfmea_search->revisedClosureDatedet->editAttributes() ?>>
<?php if (!$reportfmea_search->revisedClosureDatedet->ReadOnly && !$reportfmea_search->revisedClosureDatedet->Disabled && !isset($reportfmea_search->revisedClosureDatedet->EditAttrs["readonly"]) && !isset($reportfmea_search->revisedClosureDatedet->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["freportfmeasearch", "datetimepicker"], function() {
	ew.createDateTimePicker("freportfmeasearch", "y_revisedClosureDatedet", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->revisedClosureDate->Visible) { // revisedClosureDate ?>
	<div id="r_revisedClosureDate" class="form-group row">
		<label for="x_revisedClosureDate" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_revisedClosureDate"><?php echo $reportfmea_search->revisedClosureDate->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->revisedClosureDate->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_revisedClosureDate" id="z_revisedClosureDate" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->revisedClosureDate->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->revisedClosureDate->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->revisedClosureDate->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->revisedClosureDate->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->revisedClosureDate->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->revisedClosureDate->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->revisedClosureDate->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->revisedClosureDate->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->revisedClosureDate->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_revisedClosureDate" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_revisedClosureDate" name="x_revisedClosureDate" id="x_revisedClosureDate" maxlength="19" placeholder="<?php echo HtmlEncode($reportfmea_search->revisedClosureDate->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->revisedClosureDate->EditValue ?>"<?php echo $reportfmea_search->revisedClosureDate->editAttributes() ?>>
<?php if (!$reportfmea_search->revisedClosureDate->ReadOnly && !$reportfmea_search->revisedClosureDate->Disabled && !isset($reportfmea_search->revisedClosureDate->EditAttrs["readonly"]) && !isset($reportfmea_search->revisedClosureDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["freportfmeasearch", "datetimepicker"], function() {
	ew.createDateTimePicker("freportfmeasearch", "x_revisedClosureDate", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_revisedClosureDate" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_revisedClosureDate" name="y_revisedClosureDate" id="y_revisedClosureDate" maxlength="19" placeholder="<?php echo HtmlEncode($reportfmea_search->revisedClosureDate->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->revisedClosureDate->EditValue2 ?>"<?php echo $reportfmea_search->revisedClosureDate->editAttributes() ?>>
<?php if (!$reportfmea_search->revisedClosureDate->ReadOnly && !$reportfmea_search->revisedClosureDate->Disabled && !isset($reportfmea_search->revisedClosureDate->EditAttrs["readonly"]) && !isset($reportfmea_search->revisedClosureDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["freportfmeasearch", "datetimepicker"], function() {
	ew.createDateTimePicker("freportfmeasearch", "y_revisedClosureDate", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->perfomedAction->Visible) { // perfomedAction ?>
	<div id="r_perfomedAction" class="form-group row">
		<label for="x_perfomedAction" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_perfomedAction"><?php echo $reportfmea_search->perfomedAction->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->perfomedAction->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_perfomedAction" id="z_perfomedAction" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->perfomedAction->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->perfomedAction->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->perfomedAction->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->perfomedAction->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->perfomedAction->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->perfomedAction->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $reportfmea_search->perfomedAction->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $reportfmea_search->perfomedAction->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $reportfmea_search->perfomedAction->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $reportfmea_search->perfomedAction->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->perfomedAction->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->perfomedAction->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->perfomedAction->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_perfomedAction" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_perfomedAction" name="x_perfomedAction" id="x_perfomedAction" size="35" placeholder="<?php echo HtmlEncode($reportfmea_search->perfomedAction->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->perfomedAction->EditValue ?>"<?php echo $reportfmea_search->perfomedAction->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_perfomedAction" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_perfomedAction" name="y_perfomedAction" id="y_perfomedAction" size="35" placeholder="<?php echo HtmlEncode($reportfmea_search->perfomedAction->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->perfomedAction->EditValue2 ?>"<?php echo $reportfmea_search->perfomedAction->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->revisedSeverity->Visible) { // revisedSeverity ?>
	<div id="r_revisedSeverity" class="form-group row">
		<label for="x_revisedSeverity" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_revisedSeverity"><?php echo $reportfmea_search->revisedSeverity->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->revisedSeverity->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_revisedSeverity" id="z_revisedSeverity" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->revisedSeverity->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->revisedSeverity->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->revisedSeverity->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->revisedSeverity->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->revisedSeverity->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->revisedSeverity->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->revisedSeverity->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->revisedSeverity->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->revisedSeverity->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_revisedSeverity" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_revisedSeverity" name="x_revisedSeverity" id="x_revisedSeverity" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->revisedSeverity->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->revisedSeverity->EditValue ?>"<?php echo $reportfmea_search->revisedSeverity->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_revisedSeverity" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_revisedSeverity" name="y_revisedSeverity" id="y_revisedSeverity" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->revisedSeverity->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->revisedSeverity->EditValue2 ?>"<?php echo $reportfmea_search->revisedSeverity->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->revisedOccurrence->Visible) { // revisedOccurrence ?>
	<div id="r_revisedOccurrence" class="form-group row">
		<label for="x_revisedOccurrence" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_revisedOccurrence"><?php echo $reportfmea_search->revisedOccurrence->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->revisedOccurrence->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_revisedOccurrence" id="z_revisedOccurrence" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->revisedOccurrence->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->revisedOccurrence->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->revisedOccurrence->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->revisedOccurrence->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->revisedOccurrence->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->revisedOccurrence->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->revisedOccurrence->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->revisedOccurrence->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->revisedOccurrence->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_revisedOccurrence" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_revisedOccurrence" name="x_revisedOccurrence" id="x_revisedOccurrence" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->revisedOccurrence->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->revisedOccurrence->EditValue ?>"<?php echo $reportfmea_search->revisedOccurrence->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_revisedOccurrence" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_revisedOccurrence" name="y_revisedOccurrence" id="y_revisedOccurrence" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->revisedOccurrence->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->revisedOccurrence->EditValue2 ?>"<?php echo $reportfmea_search->revisedOccurrence->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->revisedDetection->Visible) { // revisedDetection ?>
	<div id="r_revisedDetection" class="form-group row">
		<label for="x_revisedDetection" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_revisedDetection"><?php echo $reportfmea_search->revisedDetection->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->revisedDetection->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_revisedDetection" id="z_revisedDetection" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->revisedDetection->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->revisedDetection->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->revisedDetection->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->revisedDetection->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->revisedDetection->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->revisedDetection->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->revisedDetection->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->revisedDetection->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->revisedDetection->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_revisedDetection" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_revisedDetection" name="x_revisedDetection" id="x_revisedDetection" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->revisedDetection->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->revisedDetection->EditValue ?>"<?php echo $reportfmea_search->revisedDetection->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_revisedDetection" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_revisedDetection" name="y_revisedDetection" id="y_revisedDetection" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->revisedDetection->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->revisedDetection->EditValue2 ?>"<?php echo $reportfmea_search->revisedDetection->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($reportfmea_search->revisedRpn->Visible) { // revisedRpn ?>
	<div id="r_revisedRpn" class="form-group row">
		<label for="x_revisedRpn" class="<?php echo $reportfmea_search->LeftColumnClass ?>"><span id="elh_reportfmea_revisedRpn"><?php echo $reportfmea_search->revisedRpn->caption() ?></span>
		</label>
		<div class="<?php echo $reportfmea_search->RightColumnClass ?>"><div <?php echo $reportfmea_search->revisedRpn->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_revisedRpn" id="z_revisedRpn" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $reportfmea_search->revisedRpn->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $reportfmea_search->revisedRpn->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $reportfmea_search->revisedRpn->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $reportfmea_search->revisedRpn->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $reportfmea_search->revisedRpn->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $reportfmea_search->revisedRpn->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $reportfmea_search->revisedRpn->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $reportfmea_search->revisedRpn->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $reportfmea_search->revisedRpn->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_reportfmea_revisedRpn" class="ew-search-field">
<input type="text" data-table="reportfmea" data-field="x_revisedRpn" name="x_revisedRpn" id="x_revisedRpn" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->revisedRpn->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->revisedRpn->EditValue ?>"<?php echo $reportfmea_search->revisedRpn->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_reportfmea_revisedRpn" class="ew-search-field2 d-none">
<input type="text" data-table="reportfmea" data-field="x_revisedRpn" name="y_revisedRpn" id="y_revisedRpn" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($reportfmea_search->revisedRpn->getPlaceHolder()) ?>" value="<?php echo $reportfmea_search->revisedRpn->EditValue2 ?>"<?php echo $reportfmea_search->revisedRpn->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$reportfmea_search->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $reportfmea_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("Search") ?></button>
<button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" onclick="ew.clearForm(this.form);"><?php echo $Language->phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$reportfmea_search->showPageFooter();
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
$reportfmea_search->terminate();
?>