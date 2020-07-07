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
$actions_search = new actions_search();

// Run the page
$actions_search->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$actions_search->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var factionssearch, currentPageID;
loadjs.ready("head", function() {

	// Form object for search
	<?php if ($actions_search->IsModal) { ?>
	factionssearch = currentAdvancedSearchForm = new ew.Form("factionssearch", "search");
	<?php } else { ?>
	factionssearch = currentForm = new ew.Form("factionssearch", "search");
	<?php } ?>
	currentPageID = ew.PAGE_ID = "search";

	// Validate function for search
	factionssearch.validate = function(fobj) {
		if (!this.validateRequired)
			return true; // Ignore validation
		fobj = fobj || this._form;
		var infix = "";
		elm = this.getElements("x" + infix + "_idProcess");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($actions_search->idProcess->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_occurrence");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($actions_search->occurrence->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_detection");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($actions_search->detection->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_RPNCalc");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($actions_search->RPNCalc->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_targetDate");
		if (elm && !ew.checkShortEuroDate(elm.value))
			return this.onError(elm, "<?php echo JsEncode($actions_search->targetDate->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_expectedSeverity");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($actions_search->expectedSeverity->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_expectedOccurrence");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($actions_search->expectedOccurrence->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_expectedDetection");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($actions_search->expectedDetection->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_expectedRpn");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($actions_search->expectedRpn->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_expectedRPNPAO");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($actions_search->expectedRPNPAO->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_expectedClosureDate");
		if (elm && !ew.checkShortDate(elm.value))
			return this.onError(elm, "<?php echo JsEncode($actions_search->expectedClosureDate->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_targetDatedet");
		if (elm && !ew.checkShortEuroDate(elm.value))
			return this.onError(elm, "<?php echo JsEncode($actions_search->targetDatedet->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_expectedSeveritydet");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($actions_search->expectedSeveritydet->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_expectedOccurrencedet");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($actions_search->expectedOccurrencedet->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_expectedDetectiondet");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($actions_search->expectedDetectiondet->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_expectedRPNPAD");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($actions_search->expectedRPNPAD->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_revisedClosureDatedet");
		if (elm && !ew.checkShortEuroDate(elm.value))
			return this.onError(elm, "<?php echo JsEncode($actions_search->revisedClosureDatedet->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_revisedSeverity");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($actions_search->revisedSeverity->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_revisedOccurrence");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($actions_search->revisedOccurrence->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_revisedDetection");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($actions_search->revisedDetection->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_revisedRpn");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($actions_search->revisedRpn->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_revisedRPNCalc");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($actions_search->revisedRPNCalc->errorMessage()) ?>");

		// Call Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
		return true;
	}

	// Form_CustomValidate
	factionssearch.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	factionssearch.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	factionssearch.lists["x_idCause"] = <?php echo $actions_search->idCause->Lookup->toClientList($actions_search) ?>;
	factionssearch.lists["x_idCause"].options = <?php echo JsonEncode($actions_search->idCause->lookupOptions()) ?>;
	factionssearch.lists["x_idResponsible[]"] = <?php echo $actions_search->idResponsible->Lookup->toClientList($actions_search) ?>;
	factionssearch.lists["x_idResponsible[]"].options = <?php echo JsonEncode($actions_search->idResponsible->lookupOptions()) ?>;
	factionssearch.lists["x_revisedKc[]"] = <?php echo $actions_search->revisedKc->Lookup->toClientList($actions_search) ?>;
	factionssearch.lists["x_revisedKc[]"].options = <?php echo JsonEncode($actions_search->revisedKc->options(FALSE, TRUE)) ?>;
	factionssearch.lists["x_idResponsibleDet[]"] = <?php echo $actions_search->idResponsibleDet->Lookup->toClientList($actions_search) ?>;
	factionssearch.lists["x_idResponsibleDet[]"].options = <?php echo JsonEncode($actions_search->idResponsibleDet->lookupOptions()) ?>;
	factionssearch.lists["x_kcdet[]"] = <?php echo $actions_search->kcdet->Lookup->toClientList($actions_search) ?>;
	factionssearch.lists["x_kcdet[]"].options = <?php echo JsonEncode($actions_search->kcdet->options(FALSE, TRUE)) ?>;
	loadjs.done("factionssearch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $actions_search->showPageHeader(); ?>
<?php
$actions_search->showMessage();
?>
<form name="factionssearch" id="factionssearch" class="<?php echo $actions_search->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="actions">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?php echo (int)$actions_search->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($actions_search->idProcess->Visible) { // idProcess ?>
	<div id="r_idProcess" class="form-group row">
		<label for="x_idProcess" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_idProcess"><?php echo $actions_search->idProcess->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("=") ?>
<input type="hidden" name="z_idProcess" id="z_idProcess" value="=">
</span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->idProcess->cellAttributes() ?>>
			<span id="el_actions_idProcess" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_idProcess" name="x_idProcess" id="x_idProcess" size="30" placeholder="<?php echo HtmlEncode($actions_search->idProcess->getPlaceHolder()) ?>" value="<?php echo $actions_search->idProcess->EditValue ?>"<?php echo $actions_search->idProcess->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->idCause->Visible) { // idCause ?>
	<div id="r_idCause" class="form-group row">
		<label for="x_idCause" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_idCause"><?php echo $actions_search->idCause->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->idCause->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_idCause" id="z_idCause" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->idCause->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->idCause->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->idCause->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->idCause->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->idCause->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->idCause->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $actions_search->idCause->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $actions_search->idCause->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $actions_search->idCause->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $actions_search->idCause->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="BETWEEN"<?php echo $actions_search->idCause->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_idCause" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_idCause" name="x_idCause" id="x_idCause" size="30" placeholder="<?php echo HtmlEncode($actions_search->idCause->getPlaceHolder()) ?>" value="<?php echo $actions_search->idCause->EditValue ?>"<?php echo $actions_search->idCause->editAttributes() ?>>
<?php echo $actions_search->idCause->Lookup->getParamTag($actions_search, "p_x_idCause") ?>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_idCause" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_idCause" name="y_idCause" id="y_idCause" size="30" placeholder="<?php echo HtmlEncode($actions_search->idCause->getPlaceHolder()) ?>" value="<?php echo $actions_search->idCause->EditValue2 ?>"<?php echo $actions_search->idCause->editAttributes() ?>>
<?php echo $actions_search->idCause->Lookup->getParamTag($actions_search, "p_y_idCause") ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->potentialCauses->Visible) { // potentialCauses ?>
	<div id="r_potentialCauses" class="form-group row">
		<label for="x_potentialCauses" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_potentialCauses"><?php echo $actions_search->potentialCauses->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("LIKE") ?>
<input type="hidden" name="z_potentialCauses" id="z_potentialCauses" value="LIKE">
</span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->potentialCauses->cellAttributes() ?>>
			<span id="el_actions_potentialCauses" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_potentialCauses" name="x_potentialCauses" id="x_potentialCauses" size="35" placeholder="<?php echo HtmlEncode($actions_search->potentialCauses->getPlaceHolder()) ?>" value="<?php echo $actions_search->potentialCauses->EditValue ?>"<?php echo $actions_search->potentialCauses->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->currentPreventiveControlMethod->Visible) { // currentPreventiveControlMethod ?>
	<div id="r_currentPreventiveControlMethod" class="form-group row">
		<label for="x_currentPreventiveControlMethod" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_currentPreventiveControlMethod"><?php echo $actions_search->currentPreventiveControlMethod->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->currentPreventiveControlMethod->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_currentPreventiveControlMethod" id="z_currentPreventiveControlMethod" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $actions_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $actions_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $actions_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $actions_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $actions_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->currentPreventiveControlMethod->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_currentPreventiveControlMethod" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_currentPreventiveControlMethod" name="x_currentPreventiveControlMethod" id="x_currentPreventiveControlMethod" size="7" maxlength="255" placeholder="<?php echo HtmlEncode($actions_search->currentPreventiveControlMethod->getPlaceHolder()) ?>" value="<?php echo $actions_search->currentPreventiveControlMethod->EditValue ?>"<?php echo $actions_search->currentPreventiveControlMethod->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_currentPreventiveControlMethod" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_currentPreventiveControlMethod" name="y_currentPreventiveControlMethod" id="y_currentPreventiveControlMethod" size="7" maxlength="255" placeholder="<?php echo HtmlEncode($actions_search->currentPreventiveControlMethod->getPlaceHolder()) ?>" value="<?php echo $actions_search->currentPreventiveControlMethod->EditValue2 ?>"<?php echo $actions_search->currentPreventiveControlMethod->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->severity->Visible) { // severity ?>
	<div id="r_severity" class="form-group row">
		<label class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_severity"><?php echo $actions_search->severity->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->severity->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_severity" id="z_severity" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->severity->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->severity->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->severity->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->severity->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->severity->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->severity->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $actions_search->severity->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->severity->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->severity->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_severity" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_severity" name="x_severity" id="x_severity" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($actions_search->severity->getPlaceHolder()) ?>" value="<?php echo $actions_search->severity->EditValue ?>"<?php echo $actions_search->severity->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_severity" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_severity" name="y_severity" id="y_severity" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($actions_search->severity->getPlaceHolder()) ?>" value="<?php echo $actions_search->severity->EditValue2 ?>"<?php echo $actions_search->severity->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->occurrence->Visible) { // occurrence ?>
	<div id="r_occurrence" class="form-group row">
		<label for="x_occurrence" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_occurrence"><?php echo $actions_search->occurrence->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->occurrence->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_occurrence" id="z_occurrence" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->occurrence->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->occurrence->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->occurrence->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->occurrence->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->occurrence->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->occurrence->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $actions_search->occurrence->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->occurrence->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->occurrence->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_occurrence" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_occurrence" name="x_occurrence" id="x_occurrence" size="3" placeholder="<?php echo HtmlEncode($actions_search->occurrence->getPlaceHolder()) ?>" value="<?php echo $actions_search->occurrence->EditValue ?>"<?php echo $actions_search->occurrence->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_occurrence" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_occurrence" name="y_occurrence" id="y_occurrence" size="3" placeholder="<?php echo HtmlEncode($actions_search->occurrence->getPlaceHolder()) ?>" value="<?php echo $actions_search->occurrence->EditValue2 ?>"<?php echo $actions_search->occurrence->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->currentControlMethod->Visible) { // currentControlMethod ?>
	<div id="r_currentControlMethod" class="form-group row">
		<label for="x_currentControlMethod" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_currentControlMethod"><?php echo $actions_search->currentControlMethod->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->currentControlMethod->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_currentControlMethod" id="z_currentControlMethod" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->currentControlMethod->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->currentControlMethod->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->currentControlMethod->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->currentControlMethod->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->currentControlMethod->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->currentControlMethod->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $actions_search->currentControlMethod->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $actions_search->currentControlMethod->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $actions_search->currentControlMethod->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $actions_search->currentControlMethod->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $actions_search->currentControlMethod->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->currentControlMethod->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->currentControlMethod->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_currentControlMethod" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_currentControlMethod" name="x_currentControlMethod" id="x_currentControlMethod" size="10" maxlength="255" placeholder="<?php echo HtmlEncode($actions_search->currentControlMethod->getPlaceHolder()) ?>" value="<?php echo $actions_search->currentControlMethod->EditValue ?>"<?php echo $actions_search->currentControlMethod->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_currentControlMethod" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_currentControlMethod" name="y_currentControlMethod" id="y_currentControlMethod" size="10" maxlength="255" placeholder="<?php echo HtmlEncode($actions_search->currentControlMethod->getPlaceHolder()) ?>" value="<?php echo $actions_search->currentControlMethod->EditValue2 ?>"<?php echo $actions_search->currentControlMethod->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->detection->Visible) { // detection ?>
	<div id="r_detection" class="form-group row">
		<label for="x_detection" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_detection"><?php echo $actions_search->detection->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->detection->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_detection" id="z_detection" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->detection->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->detection->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->detection->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->detection->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->detection->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->detection->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $actions_search->detection->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->detection->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->detection->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_detection" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_detection" name="x_detection" id="x_detection" size="3" placeholder="<?php echo HtmlEncode($actions_search->detection->getPlaceHolder()) ?>" value="<?php echo $actions_search->detection->EditValue ?>"<?php echo $actions_search->detection->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_detection" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_detection" name="y_detection" id="y_detection" size="3" placeholder="<?php echo HtmlEncode($actions_search->detection->getPlaceHolder()) ?>" value="<?php echo $actions_search->detection->EditValue2 ?>"<?php echo $actions_search->detection->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->RPNCalc->Visible) { // RPNCalc ?>
	<div id="r_RPNCalc" class="form-group row">
		<label for="x_RPNCalc" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_RPNCalc"><?php echo $actions_search->RPNCalc->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->RPNCalc->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_RPNCalc" id="z_RPNCalc" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->RPNCalc->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->RPNCalc->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->RPNCalc->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->RPNCalc->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->RPNCalc->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->RPNCalc->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $actions_search->RPNCalc->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->RPNCalc->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->RPNCalc->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_RPNCalc" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_RPNCalc" name="x_RPNCalc" id="x_RPNCalc" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_search->RPNCalc->getPlaceHolder()) ?>" value="<?php echo $actions_search->RPNCalc->EditValue ?>"<?php echo $actions_search->RPNCalc->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_RPNCalc" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_RPNCalc" name="y_RPNCalc" id="y_RPNCalc" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_search->RPNCalc->getPlaceHolder()) ?>" value="<?php echo $actions_search->RPNCalc->EditValue2 ?>"<?php echo $actions_search->RPNCalc->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->recomendedAction->Visible) { // recomendedAction ?>
	<div id="r_recomendedAction" class="form-group row">
		<label for="x_recomendedAction" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_recomendedAction"><?php echo $actions_search->recomendedAction->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->recomendedAction->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_recomendedAction" id="z_recomendedAction" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->recomendedAction->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->recomendedAction->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->recomendedAction->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->recomendedAction->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->recomendedAction->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->recomendedAction->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $actions_search->recomendedAction->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $actions_search->recomendedAction->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $actions_search->recomendedAction->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $actions_search->recomendedAction->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $actions_search->recomendedAction->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->recomendedAction->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->recomendedAction->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_recomendedAction" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_recomendedAction" name="x_recomendedAction" id="x_recomendedAction" size="10" placeholder="<?php echo HtmlEncode($actions_search->recomendedAction->getPlaceHolder()) ?>" value="<?php echo $actions_search->recomendedAction->EditValue ?>"<?php echo $actions_search->recomendedAction->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_recomendedAction" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_recomendedAction" name="y_recomendedAction" id="y_recomendedAction" size="10" placeholder="<?php echo HtmlEncode($actions_search->recomendedAction->getPlaceHolder()) ?>" value="<?php echo $actions_search->recomendedAction->EditValue2 ?>"<?php echo $actions_search->recomendedAction->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->idResponsible->Visible) { // idResponsible ?>
	<div id="r_idResponsible" class="form-group row">
		<label for="x_idResponsible" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_idResponsible"><?php echo $actions_search->idResponsible->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->idResponsible->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_idResponsible" id="z_idResponsible" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->idResponsible->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->idResponsible->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->idResponsible->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->idResponsible->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->idResponsible->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->idResponsible->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $actions_search->idResponsible->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $actions_search->idResponsible->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $actions_search->idResponsible->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $actions_search->idResponsible->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $actions_search->idResponsible->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->idResponsible->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->idResponsible->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_idResponsible" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_idResponsible" name="x_idResponsible" id="x_idResponsible" size="10" placeholder="<?php echo HtmlEncode($actions_search->idResponsible->getPlaceHolder()) ?>" value="<?php echo $actions_search->idResponsible->EditValue ?>"<?php echo $actions_search->idResponsible->editAttributes() ?>>
<?php echo $actions_search->idResponsible->Lookup->getParamTag($actions_search, "p_x_idResponsible") ?>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_idResponsible" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_idResponsible" name="y_idResponsible" id="y_idResponsible" size="10" placeholder="<?php echo HtmlEncode($actions_search->idResponsible->getPlaceHolder()) ?>" value="<?php echo $actions_search->idResponsible->EditValue2 ?>"<?php echo $actions_search->idResponsible->editAttributes() ?>>
<?php echo $actions_search->idResponsible->Lookup->getParamTag($actions_search, "p_y_idResponsible") ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->targetDate->Visible) { // targetDate ?>
	<div id="r_targetDate" class="form-group row">
		<label for="x_targetDate" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_targetDate"><?php echo $actions_search->targetDate->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->targetDate->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_targetDate" id="z_targetDate" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->targetDate->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->targetDate->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->targetDate->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->targetDate->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->targetDate->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->targetDate->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $actions_search->targetDate->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->targetDate->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->targetDate->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_targetDate" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_targetDate" data-format="14" name="x_targetDate" id="x_targetDate" size="7" placeholder="<?php echo HtmlEncode($actions_search->targetDate->getPlaceHolder()) ?>" value="<?php echo $actions_search->targetDate->EditValue ?>"<?php echo $actions_search->targetDate->editAttributes() ?>>
<?php if (!$actions_search->targetDate->ReadOnly && !$actions_search->targetDate->Disabled && !isset($actions_search->targetDate->EditAttrs["readonly"]) && !isset($actions_search->targetDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["factionssearch", "datetimepicker"], function() {
	ew.createDateTimePicker("factionssearch", "x_targetDate", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<?php } ?>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_targetDate" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_targetDate" data-format="14" name="y_targetDate" id="y_targetDate" size="7" placeholder="<?php echo HtmlEncode($actions_search->targetDate->getPlaceHolder()) ?>" value="<?php echo $actions_search->targetDate->EditValue2 ?>"<?php echo $actions_search->targetDate->editAttributes() ?>>
<?php if (!$actions_search->targetDate->ReadOnly && !$actions_search->targetDate->Disabled && !isset($actions_search->targetDate->EditAttrs["readonly"]) && !isset($actions_search->targetDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["factionssearch", "datetimepicker"], function() {
	ew.createDateTimePicker("factionssearch", "y_targetDate", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->revisedKc->Visible) { // revisedKc ?>
	<div id="r_revisedKc" class="form-group row">
		<label class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_revisedKc"><?php echo $actions_search->revisedKc->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->revisedKc->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_revisedKc" id="z_revisedKc" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->revisedKc->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->revisedKc->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->revisedKc->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->revisedKc->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->revisedKc->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->revisedKc->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $actions_search->revisedKc->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $actions_search->revisedKc->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $actions_search->revisedKc->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $actions_search->revisedKc->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $actions_search->revisedKc->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->revisedKc->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->revisedKc->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_revisedKc" class="ew-search-field">
<?php
$selwrk = ConvertToBool($actions_search->revisedKc->AdvancedSearch->SearchValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="actions" data-field="x_revisedKc" name="x_revisedKc[]" id="x_revisedKc[]" value="1"<?php echo $selwrk ?><?php echo $actions_search->revisedKc->editAttributes() ?>>
	<label class="custom-control-label" for="x_revisedKc[]"></label>
</div>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_revisedKc" class="ew-search-field2 d-none">
<?php
$selwrk = ConvertToBool($actions_search->revisedKc->AdvancedSearch->SearchValue2) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="actions" data-field="x_revisedKc" name="y_revisedKc[]" id="y_revisedKc[]" value="1"<?php echo $selwrk ?><?php echo $actions_search->revisedKc->editAttributes() ?>>
	<label class="custom-control-label" for="y_revisedKc[]"></label>
</div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->expectedSeverity->Visible) { // expectedSeverity ?>
	<div id="r_expectedSeverity" class="form-group row">
		<label for="x_expectedSeverity" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_expectedSeverity"><?php echo $actions_search->expectedSeverity->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->expectedSeverity->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_expectedSeverity" id="z_expectedSeverity" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->expectedSeverity->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->expectedSeverity->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->expectedSeverity->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->expectedSeverity->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->expectedSeverity->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->expectedSeverity->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $actions_search->expectedSeverity->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->expectedSeverity->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->expectedSeverity->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_expectedSeverity" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_expectedSeverity" name="x_expectedSeverity" id="x_expectedSeverity" size="3" placeholder="<?php echo HtmlEncode($actions_search->expectedSeverity->getPlaceHolder()) ?>" value="<?php echo $actions_search->expectedSeverity->EditValue ?>"<?php echo $actions_search->expectedSeverity->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_expectedSeverity" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_expectedSeverity" name="y_expectedSeverity" id="y_expectedSeverity" size="3" placeholder="<?php echo HtmlEncode($actions_search->expectedSeverity->getPlaceHolder()) ?>" value="<?php echo $actions_search->expectedSeverity->EditValue2 ?>"<?php echo $actions_search->expectedSeverity->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->expectedOccurrence->Visible) { // expectedOccurrence ?>
	<div id="r_expectedOccurrence" class="form-group row">
		<label for="x_expectedOccurrence" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_expectedOccurrence"><?php echo $actions_search->expectedOccurrence->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->expectedOccurrence->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_expectedOccurrence" id="z_expectedOccurrence" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->expectedOccurrence->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->expectedOccurrence->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->expectedOccurrence->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->expectedOccurrence->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->expectedOccurrence->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->expectedOccurrence->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $actions_search->expectedOccurrence->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->expectedOccurrence->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->expectedOccurrence->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_expectedOccurrence" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_expectedOccurrence" name="x_expectedOccurrence" id="x_expectedOccurrence" size="3" placeholder="<?php echo HtmlEncode($actions_search->expectedOccurrence->getPlaceHolder()) ?>" value="<?php echo $actions_search->expectedOccurrence->EditValue ?>"<?php echo $actions_search->expectedOccurrence->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_expectedOccurrence" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_expectedOccurrence" name="y_expectedOccurrence" id="y_expectedOccurrence" size="3" placeholder="<?php echo HtmlEncode($actions_search->expectedOccurrence->getPlaceHolder()) ?>" value="<?php echo $actions_search->expectedOccurrence->EditValue2 ?>"<?php echo $actions_search->expectedOccurrence->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->expectedDetection->Visible) { // expectedDetection ?>
	<div id="r_expectedDetection" class="form-group row">
		<label for="x_expectedDetection" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_expectedDetection"><?php echo $actions_search->expectedDetection->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->expectedDetection->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_expectedDetection" id="z_expectedDetection" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->expectedDetection->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->expectedDetection->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->expectedDetection->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->expectedDetection->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->expectedDetection->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->expectedDetection->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $actions_search->expectedDetection->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->expectedDetection->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->expectedDetection->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_expectedDetection" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_expectedDetection" name="x_expectedDetection" id="x_expectedDetection" size="3" placeholder="<?php echo HtmlEncode($actions_search->expectedDetection->getPlaceHolder()) ?>" value="<?php echo $actions_search->expectedDetection->EditValue ?>"<?php echo $actions_search->expectedDetection->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_expectedDetection" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_expectedDetection" name="y_expectedDetection" id="y_expectedDetection" size="3" placeholder="<?php echo HtmlEncode($actions_search->expectedDetection->getPlaceHolder()) ?>" value="<?php echo $actions_search->expectedDetection->EditValue2 ?>"<?php echo $actions_search->expectedDetection->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->expectedRpn->Visible) { // expectedRpn ?>
	<div id="r_expectedRpn" class="form-group row">
		<label for="x_expectedRpn" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_expectedRpn"><?php echo $actions_search->expectedRpn->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->expectedRpn->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_expectedRpn" id="z_expectedRpn" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->expectedRpn->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->expectedRpn->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->expectedRpn->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->expectedRpn->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->expectedRpn->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->expectedRpn->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $actions_search->expectedRpn->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->expectedRpn->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->expectedRpn->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_expectedRpn" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_expectedRpn" name="x_expectedRpn" id="x_expectedRpn" size="3" placeholder="<?php echo HtmlEncode($actions_search->expectedRpn->getPlaceHolder()) ?>" value="<?php echo $actions_search->expectedRpn->EditValue ?>"<?php echo $actions_search->expectedRpn->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_expectedRpn" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_expectedRpn" name="y_expectedRpn" id="y_expectedRpn" size="3" placeholder="<?php echo HtmlEncode($actions_search->expectedRpn->getPlaceHolder()) ?>" value="<?php echo $actions_search->expectedRpn->EditValue2 ?>"<?php echo $actions_search->expectedRpn->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->expectedRPNPAO->Visible) { // expectedRPNPAO ?>
	<div id="r_expectedRPNPAO" class="form-group row">
		<label for="x_expectedRPNPAO" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_expectedRPNPAO"><?php echo $actions_search->expectedRPNPAO->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->expectedRPNPAO->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_expectedRPNPAO" id="z_expectedRPNPAO" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->expectedRPNPAO->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->expectedRPNPAO->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->expectedRPNPAO->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->expectedRPNPAO->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->expectedRPNPAO->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->expectedRPNPAO->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $actions_search->expectedRPNPAO->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->expectedRPNPAO->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->expectedRPNPAO->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_expectedRPNPAO" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_expectedRPNPAO" name="x_expectedRPNPAO" id="x_expectedRPNPAO" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_search->expectedRPNPAO->getPlaceHolder()) ?>" value="<?php echo $actions_search->expectedRPNPAO->EditValue ?>"<?php echo $actions_search->expectedRPNPAO->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_expectedRPNPAO" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_expectedRPNPAO" name="y_expectedRPNPAO" id="y_expectedRPNPAO" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_search->expectedRPNPAO->getPlaceHolder()) ?>" value="<?php echo $actions_search->expectedRPNPAO->EditValue2 ?>"<?php echo $actions_search->expectedRPNPAO->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->expectedClosureDate->Visible) { // expectedClosureDate ?>
	<div id="r_expectedClosureDate" class="form-group row">
		<label for="x_expectedClosureDate" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_expectedClosureDate"><?php echo $actions_search->expectedClosureDate->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->expectedClosureDate->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_expectedClosureDate" id="z_expectedClosureDate" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->expectedClosureDate->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->expectedClosureDate->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->expectedClosureDate->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->expectedClosureDate->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->expectedClosureDate->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->expectedClosureDate->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $actions_search->expectedClosureDate->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->expectedClosureDate->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->expectedClosureDate->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_expectedClosureDate" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_expectedClosureDate" data-format="12" name="x_expectedClosureDate" id="x_expectedClosureDate" size="7" placeholder="<?php echo HtmlEncode($actions_search->expectedClosureDate->getPlaceHolder()) ?>" value="<?php echo $actions_search->expectedClosureDate->EditValue ?>"<?php echo $actions_search->expectedClosureDate->editAttributes() ?>>
<?php if (!$actions_search->expectedClosureDate->ReadOnly && !$actions_search->expectedClosureDate->Disabled && !isset($actions_search->expectedClosureDate->EditAttrs["readonly"]) && !isset($actions_search->expectedClosureDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["factionssearch", "datetimepicker"], function() {
	ew.createDateTimePicker("factionssearch", "x_expectedClosureDate", {"ignoreReadonly":true,"useCurrent":false,"format":12});
});
</script>
<?php } ?>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_expectedClosureDate" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_expectedClosureDate" data-format="12" name="y_expectedClosureDate" id="y_expectedClosureDate" size="7" placeholder="<?php echo HtmlEncode($actions_search->expectedClosureDate->getPlaceHolder()) ?>" value="<?php echo $actions_search->expectedClosureDate->EditValue2 ?>"<?php echo $actions_search->expectedClosureDate->editAttributes() ?>>
<?php if (!$actions_search->expectedClosureDate->ReadOnly && !$actions_search->expectedClosureDate->Disabled && !isset($actions_search->expectedClosureDate->EditAttrs["readonly"]) && !isset($actions_search->expectedClosureDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["factionssearch", "datetimepicker"], function() {
	ew.createDateTimePicker("factionssearch", "y_expectedClosureDate", {"ignoreReadonly":true,"useCurrent":false,"format":12});
});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->recomendedActiondet->Visible) { // recomendedActiondet ?>
	<div id="r_recomendedActiondet" class="form-group row">
		<label for="x_recomendedActiondet" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_recomendedActiondet"><?php echo $actions_search->recomendedActiondet->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->recomendedActiondet->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_recomendedActiondet" id="z_recomendedActiondet" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->recomendedActiondet->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->recomendedActiondet->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->recomendedActiondet->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->recomendedActiondet->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->recomendedActiondet->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->recomendedActiondet->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $actions_search->recomendedActiondet->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $actions_search->recomendedActiondet->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $actions_search->recomendedActiondet->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $actions_search->recomendedActiondet->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $actions_search->recomendedActiondet->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->recomendedActiondet->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->recomendedActiondet->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_recomendedActiondet" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_recomendedActiondet" name="x_recomendedActiondet" id="x_recomendedActiondet" size="10" placeholder="<?php echo HtmlEncode($actions_search->recomendedActiondet->getPlaceHolder()) ?>" value="<?php echo $actions_search->recomendedActiondet->EditValue ?>"<?php echo $actions_search->recomendedActiondet->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_recomendedActiondet" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_recomendedActiondet" name="y_recomendedActiondet" id="y_recomendedActiondet" size="10" placeholder="<?php echo HtmlEncode($actions_search->recomendedActiondet->getPlaceHolder()) ?>" value="<?php echo $actions_search->recomendedActiondet->EditValue2 ?>"<?php echo $actions_search->recomendedActiondet->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->idResponsibleDet->Visible) { // idResponsibleDet ?>
	<div id="r_idResponsibleDet" class="form-group row">
		<label for="x_idResponsibleDet" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_idResponsibleDet"><?php echo $actions_search->idResponsibleDet->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->idResponsibleDet->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_idResponsibleDet" id="z_idResponsibleDet" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->idResponsibleDet->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->idResponsibleDet->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->idResponsibleDet->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->idResponsibleDet->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->idResponsibleDet->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->idResponsibleDet->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $actions_search->idResponsibleDet->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $actions_search->idResponsibleDet->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $actions_search->idResponsibleDet->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $actions_search->idResponsibleDet->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $actions_search->idResponsibleDet->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->idResponsibleDet->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->idResponsibleDet->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_idResponsibleDet" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_idResponsibleDet" name="x_idResponsibleDet" id="x_idResponsibleDet" size="10" placeholder="<?php echo HtmlEncode($actions_search->idResponsibleDet->getPlaceHolder()) ?>" value="<?php echo $actions_search->idResponsibleDet->EditValue ?>"<?php echo $actions_search->idResponsibleDet->editAttributes() ?>>
<?php echo $actions_search->idResponsibleDet->Lookup->getParamTag($actions_search, "p_x_idResponsibleDet") ?>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_idResponsibleDet" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_idResponsibleDet" name="y_idResponsibleDet" id="y_idResponsibleDet" size="10" placeholder="<?php echo HtmlEncode($actions_search->idResponsibleDet->getPlaceHolder()) ?>" value="<?php echo $actions_search->idResponsibleDet->EditValue2 ?>"<?php echo $actions_search->idResponsibleDet->editAttributes() ?>>
<?php echo $actions_search->idResponsibleDet->Lookup->getParamTag($actions_search, "p_y_idResponsibleDet") ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->targetDatedet->Visible) { // targetDatedet ?>
	<div id="r_targetDatedet" class="form-group row">
		<label for="x_targetDatedet" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_targetDatedet"><?php echo $actions_search->targetDatedet->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->targetDatedet->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_targetDatedet" id="z_targetDatedet" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->targetDatedet->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->targetDatedet->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->targetDatedet->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->targetDatedet->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->targetDatedet->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->targetDatedet->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $actions_search->targetDatedet->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->targetDatedet->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->targetDatedet->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_targetDatedet" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_targetDatedet" data-format="14" name="x_targetDatedet" id="x_targetDatedet" size="7" placeholder="<?php echo HtmlEncode($actions_search->targetDatedet->getPlaceHolder()) ?>" value="<?php echo $actions_search->targetDatedet->EditValue ?>"<?php echo $actions_search->targetDatedet->editAttributes() ?>>
<?php if (!$actions_search->targetDatedet->ReadOnly && !$actions_search->targetDatedet->Disabled && !isset($actions_search->targetDatedet->EditAttrs["readonly"]) && !isset($actions_search->targetDatedet->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["factionssearch", "datetimepicker"], function() {
	ew.createDateTimePicker("factionssearch", "x_targetDatedet", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<?php } ?>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_targetDatedet" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_targetDatedet" data-format="14" name="y_targetDatedet" id="y_targetDatedet" size="7" placeholder="<?php echo HtmlEncode($actions_search->targetDatedet->getPlaceHolder()) ?>" value="<?php echo $actions_search->targetDatedet->EditValue2 ?>"<?php echo $actions_search->targetDatedet->editAttributes() ?>>
<?php if (!$actions_search->targetDatedet->ReadOnly && !$actions_search->targetDatedet->Disabled && !isset($actions_search->targetDatedet->EditAttrs["readonly"]) && !isset($actions_search->targetDatedet->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["factionssearch", "datetimepicker"], function() {
	ew.createDateTimePicker("factionssearch", "y_targetDatedet", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->kcdet->Visible) { // kcdet ?>
	<div id="r_kcdet" class="form-group row">
		<label class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_kcdet"><?php echo $actions_search->kcdet->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->kcdet->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_kcdet" id="z_kcdet" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->kcdet->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->kcdet->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->kcdet->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->kcdet->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->kcdet->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->kcdet->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $actions_search->kcdet->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $actions_search->kcdet->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $actions_search->kcdet->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $actions_search->kcdet->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $actions_search->kcdet->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->kcdet->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->kcdet->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_kcdet" class="ew-search-field">
<?php
$selwrk = ConvertToBool($actions_search->kcdet->AdvancedSearch->SearchValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="actions" data-field="x_kcdet" name="x_kcdet[]" id="x_kcdet[]" value="1"<?php echo $selwrk ?><?php echo $actions_search->kcdet->editAttributes() ?>>
	<label class="custom-control-label" for="x_kcdet[]"></label>
</div>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_kcdet" class="ew-search-field2 d-none">
<?php
$selwrk = ConvertToBool($actions_search->kcdet->AdvancedSearch->SearchValue2) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="actions" data-field="x_kcdet" name="y_kcdet[]" id="y_kcdet[]" value="1"<?php echo $selwrk ?><?php echo $actions_search->kcdet->editAttributes() ?>>
	<label class="custom-control-label" for="y_kcdet[]"></label>
</div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->expectedSeveritydet->Visible) { // expectedSeveritydet ?>
	<div id="r_expectedSeveritydet" class="form-group row">
		<label for="x_expectedSeveritydet" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_expectedSeveritydet"><?php echo $actions_search->expectedSeveritydet->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->expectedSeveritydet->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_expectedSeveritydet" id="z_expectedSeveritydet" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->expectedSeveritydet->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->expectedSeveritydet->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->expectedSeveritydet->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->expectedSeveritydet->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->expectedSeveritydet->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->expectedSeveritydet->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $actions_search->expectedSeveritydet->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->expectedSeveritydet->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->expectedSeveritydet->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_expectedSeveritydet" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_expectedSeveritydet" name="x_expectedSeveritydet" id="x_expectedSeveritydet" size="3" placeholder="<?php echo HtmlEncode($actions_search->expectedSeveritydet->getPlaceHolder()) ?>" value="<?php echo $actions_search->expectedSeveritydet->EditValue ?>"<?php echo $actions_search->expectedSeveritydet->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_expectedSeveritydet" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_expectedSeveritydet" name="y_expectedSeveritydet" id="y_expectedSeveritydet" size="3" placeholder="<?php echo HtmlEncode($actions_search->expectedSeveritydet->getPlaceHolder()) ?>" value="<?php echo $actions_search->expectedSeveritydet->EditValue2 ?>"<?php echo $actions_search->expectedSeveritydet->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->expectedOccurrencedet->Visible) { // expectedOccurrencedet ?>
	<div id="r_expectedOccurrencedet" class="form-group row">
		<label for="x_expectedOccurrencedet" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_expectedOccurrencedet"><?php echo $actions_search->expectedOccurrencedet->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->expectedOccurrencedet->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_expectedOccurrencedet" id="z_expectedOccurrencedet" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->expectedOccurrencedet->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->expectedOccurrencedet->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->expectedOccurrencedet->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->expectedOccurrencedet->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->expectedOccurrencedet->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->expectedOccurrencedet->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $actions_search->expectedOccurrencedet->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->expectedOccurrencedet->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->expectedOccurrencedet->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_expectedOccurrencedet" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_expectedOccurrencedet" name="x_expectedOccurrencedet" id="x_expectedOccurrencedet" size="3" placeholder="<?php echo HtmlEncode($actions_search->expectedOccurrencedet->getPlaceHolder()) ?>" value="<?php echo $actions_search->expectedOccurrencedet->EditValue ?>"<?php echo $actions_search->expectedOccurrencedet->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_expectedOccurrencedet" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_expectedOccurrencedet" name="y_expectedOccurrencedet" id="y_expectedOccurrencedet" size="3" placeholder="<?php echo HtmlEncode($actions_search->expectedOccurrencedet->getPlaceHolder()) ?>" value="<?php echo $actions_search->expectedOccurrencedet->EditValue2 ?>"<?php echo $actions_search->expectedOccurrencedet->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->expectedDetectiondet->Visible) { // expectedDetectiondet ?>
	<div id="r_expectedDetectiondet" class="form-group row">
		<label for="x_expectedDetectiondet" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_expectedDetectiondet"><?php echo $actions_search->expectedDetectiondet->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->expectedDetectiondet->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_expectedDetectiondet" id="z_expectedDetectiondet" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->expectedDetectiondet->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->expectedDetectiondet->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->expectedDetectiondet->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->expectedDetectiondet->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->expectedDetectiondet->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->expectedDetectiondet->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $actions_search->expectedDetectiondet->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->expectedDetectiondet->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->expectedDetectiondet->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_expectedDetectiondet" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_expectedDetectiondet" name="x_expectedDetectiondet" id="x_expectedDetectiondet" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($actions_search->expectedDetectiondet->getPlaceHolder()) ?>" value="<?php echo $actions_search->expectedDetectiondet->EditValue ?>"<?php echo $actions_search->expectedDetectiondet->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_expectedDetectiondet" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_expectedDetectiondet" name="y_expectedDetectiondet" id="y_expectedDetectiondet" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($actions_search->expectedDetectiondet->getPlaceHolder()) ?>" value="<?php echo $actions_search->expectedDetectiondet->EditValue2 ?>"<?php echo $actions_search->expectedDetectiondet->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->expectedRPNPAD->Visible) { // expectedRPNPAD ?>
	<div id="r_expectedRPNPAD" class="form-group row">
		<label for="x_expectedRPNPAD" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_expectedRPNPAD"><?php echo $actions_search->expectedRPNPAD->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->expectedRPNPAD->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_expectedRPNPAD" id="z_expectedRPNPAD" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->expectedRPNPAD->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->expectedRPNPAD->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->expectedRPNPAD->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->expectedRPNPAD->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->expectedRPNPAD->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->expectedRPNPAD->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $actions_search->expectedRPNPAD->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->expectedRPNPAD->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->expectedRPNPAD->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_expectedRPNPAD" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_expectedRPNPAD" name="x_expectedRPNPAD" id="x_expectedRPNPAD" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_search->expectedRPNPAD->getPlaceHolder()) ?>" value="<?php echo $actions_search->expectedRPNPAD->EditValue ?>"<?php echo $actions_search->expectedRPNPAD->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_expectedRPNPAD" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_expectedRPNPAD" name="y_expectedRPNPAD" id="y_expectedRPNPAD" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_search->expectedRPNPAD->getPlaceHolder()) ?>" value="<?php echo $actions_search->expectedRPNPAD->EditValue2 ?>"<?php echo $actions_search->expectedRPNPAD->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->revisedClosureDatedet->Visible) { // revisedClosureDatedet ?>
	<div id="r_revisedClosureDatedet" class="form-group row">
		<label for="x_revisedClosureDatedet" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_revisedClosureDatedet"><?php echo $actions_search->revisedClosureDatedet->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->revisedClosureDatedet->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_revisedClosureDatedet" id="z_revisedClosureDatedet" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->revisedClosureDatedet->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->revisedClosureDatedet->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->revisedClosureDatedet->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->revisedClosureDatedet->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->revisedClosureDatedet->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->revisedClosureDatedet->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $actions_search->revisedClosureDatedet->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->revisedClosureDatedet->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->revisedClosureDatedet->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_revisedClosureDatedet" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_revisedClosureDatedet" data-format="14" name="x_revisedClosureDatedet" id="x_revisedClosureDatedet" size="7" placeholder="<?php echo HtmlEncode($actions_search->revisedClosureDatedet->getPlaceHolder()) ?>" value="<?php echo $actions_search->revisedClosureDatedet->EditValue ?>"<?php echo $actions_search->revisedClosureDatedet->editAttributes() ?>>
<?php if (!$actions_search->revisedClosureDatedet->ReadOnly && !$actions_search->revisedClosureDatedet->Disabled && !isset($actions_search->revisedClosureDatedet->EditAttrs["readonly"]) && !isset($actions_search->revisedClosureDatedet->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["factionssearch", "datetimepicker"], function() {
	ew.createDateTimePicker("factionssearch", "x_revisedClosureDatedet", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<?php } ?>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_revisedClosureDatedet" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_revisedClosureDatedet" data-format="14" name="y_revisedClosureDatedet" id="y_revisedClosureDatedet" size="7" placeholder="<?php echo HtmlEncode($actions_search->revisedClosureDatedet->getPlaceHolder()) ?>" value="<?php echo $actions_search->revisedClosureDatedet->EditValue2 ?>"<?php echo $actions_search->revisedClosureDatedet->editAttributes() ?>>
<?php if (!$actions_search->revisedClosureDatedet->ReadOnly && !$actions_search->revisedClosureDatedet->Disabled && !isset($actions_search->revisedClosureDatedet->EditAttrs["readonly"]) && !isset($actions_search->revisedClosureDatedet->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["factionssearch", "datetimepicker"], function() {
	ew.createDateTimePicker("factionssearch", "y_revisedClosureDatedet", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->revisedSeverity->Visible) { // revisedSeverity ?>
	<div id="r_revisedSeverity" class="form-group row">
		<label for="x_revisedSeverity" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_revisedSeverity"><?php echo $actions_search->revisedSeverity->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->revisedSeverity->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_revisedSeverity" id="z_revisedSeverity" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->revisedSeverity->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->revisedSeverity->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->revisedSeverity->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->revisedSeverity->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->revisedSeverity->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->revisedSeverity->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $actions_search->revisedSeverity->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->revisedSeverity->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->revisedSeverity->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_revisedSeverity" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_revisedSeverity" name="x_revisedSeverity" id="x_revisedSeverity" size="3" placeholder="<?php echo HtmlEncode($actions_search->revisedSeverity->getPlaceHolder()) ?>" value="<?php echo $actions_search->revisedSeverity->EditValue ?>"<?php echo $actions_search->revisedSeverity->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_revisedSeverity" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_revisedSeverity" name="y_revisedSeverity" id="y_revisedSeverity" size="3" placeholder="<?php echo HtmlEncode($actions_search->revisedSeverity->getPlaceHolder()) ?>" value="<?php echo $actions_search->revisedSeverity->EditValue2 ?>"<?php echo $actions_search->revisedSeverity->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->revisedOccurrence->Visible) { // revisedOccurrence ?>
	<div id="r_revisedOccurrence" class="form-group row">
		<label for="x_revisedOccurrence" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_revisedOccurrence"><?php echo $actions_search->revisedOccurrence->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->revisedOccurrence->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_revisedOccurrence" id="z_revisedOccurrence" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->revisedOccurrence->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->revisedOccurrence->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->revisedOccurrence->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->revisedOccurrence->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->revisedOccurrence->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->revisedOccurrence->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $actions_search->revisedOccurrence->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->revisedOccurrence->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->revisedOccurrence->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_revisedOccurrence" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_revisedOccurrence" name="x_revisedOccurrence" id="x_revisedOccurrence" size="3" placeholder="<?php echo HtmlEncode($actions_search->revisedOccurrence->getPlaceHolder()) ?>" value="<?php echo $actions_search->revisedOccurrence->EditValue ?>"<?php echo $actions_search->revisedOccurrence->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_revisedOccurrence" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_revisedOccurrence" name="y_revisedOccurrence" id="y_revisedOccurrence" size="3" placeholder="<?php echo HtmlEncode($actions_search->revisedOccurrence->getPlaceHolder()) ?>" value="<?php echo $actions_search->revisedOccurrence->EditValue2 ?>"<?php echo $actions_search->revisedOccurrence->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->revisedDetection->Visible) { // revisedDetection ?>
	<div id="r_revisedDetection" class="form-group row">
		<label for="x_revisedDetection" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_revisedDetection"><?php echo $actions_search->revisedDetection->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->revisedDetection->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_revisedDetection" id="z_revisedDetection" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->revisedDetection->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->revisedDetection->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->revisedDetection->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->revisedDetection->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->revisedDetection->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->revisedDetection->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $actions_search->revisedDetection->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->revisedDetection->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->revisedDetection->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_revisedDetection" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_revisedDetection" name="x_revisedDetection" id="x_revisedDetection" size="3" placeholder="<?php echo HtmlEncode($actions_search->revisedDetection->getPlaceHolder()) ?>" value="<?php echo $actions_search->revisedDetection->EditValue ?>"<?php echo $actions_search->revisedDetection->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_revisedDetection" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_revisedDetection" name="y_revisedDetection" id="y_revisedDetection" size="3" placeholder="<?php echo HtmlEncode($actions_search->revisedDetection->getPlaceHolder()) ?>" value="<?php echo $actions_search->revisedDetection->EditValue2 ?>"<?php echo $actions_search->revisedDetection->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->revisedRpn->Visible) { // revisedRpn ?>
	<div id="r_revisedRpn" class="form-group row">
		<label for="x_revisedRpn" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_revisedRpn"><?php echo $actions_search->revisedRpn->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->revisedRpn->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_revisedRpn" id="z_revisedRpn" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->revisedRpn->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->revisedRpn->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->revisedRpn->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->revisedRpn->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->revisedRpn->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->revisedRpn->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $actions_search->revisedRpn->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->revisedRpn->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->revisedRpn->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_revisedRpn" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_revisedRpn" name="x_revisedRpn" id="x_revisedRpn" size="3" placeholder="<?php echo HtmlEncode($actions_search->revisedRpn->getPlaceHolder()) ?>" value="<?php echo $actions_search->revisedRpn->EditValue ?>"<?php echo $actions_search->revisedRpn->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_revisedRpn" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_revisedRpn" name="y_revisedRpn" id="y_revisedRpn" size="3" placeholder="<?php echo HtmlEncode($actions_search->revisedRpn->getPlaceHolder()) ?>" value="<?php echo $actions_search->revisedRpn->EditValue2 ?>"<?php echo $actions_search->revisedRpn->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($actions_search->revisedRPNCalc->Visible) { // revisedRPNCalc ?>
	<div id="r_revisedRPNCalc" class="form-group row">
		<label for="x_revisedRPNCalc" class="<?php echo $actions_search->LeftColumnClass ?>"><span id="elh_actions_revisedRPNCalc"><?php echo $actions_search->revisedRPNCalc->caption() ?></span>
		</label>
		<div class="<?php echo $actions_search->RightColumnClass ?>"><div <?php echo $actions_search->revisedRPNCalc->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_revisedRPNCalc" id="z_revisedRPNCalc" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $actions_search->revisedRPNCalc->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $actions_search->revisedRPNCalc->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $actions_search->revisedRPNCalc->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $actions_search->revisedRPNCalc->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $actions_search->revisedRPNCalc->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $actions_search->revisedRPNCalc->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $actions_search->revisedRPNCalc->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $actions_search->revisedRPNCalc->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $actions_search->revisedRPNCalc->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_actions_revisedRPNCalc" class="ew-search-field">
<input type="text" data-table="actions" data-field="x_revisedRPNCalc" name="x_revisedRPNCalc" id="x_revisedRPNCalc" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_search->revisedRPNCalc->getPlaceHolder()) ?>" value="<?php echo $actions_search->revisedRPNCalc->EditValue ?>"<?php echo $actions_search->revisedRPNCalc->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_actions_revisedRPNCalc" class="ew-search-field2 d-none">
<input type="text" data-table="actions" data-field="x_revisedRPNCalc" name="y_revisedRPNCalc" id="y_revisedRPNCalc" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_search->revisedRPNCalc->getPlaceHolder()) ?>" value="<?php echo $actions_search->revisedRPNCalc->EditValue2 ?>"<?php echo $actions_search->revisedRPNCalc->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$actions_search->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $actions_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("Search") ?></button>
<button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" onclick="ew.clearForm(this.form);"><?php echo $Language->phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$actions_search->showPageFooter();
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
$actions_search->terminate();
?>