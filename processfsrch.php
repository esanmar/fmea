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
$processf_search = new processf_search();

// Run the page
$processf_search->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$processf_search->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fprocessfsearch, currentPageID;
loadjs.ready("head", function() {

	// Form object for search
	<?php if ($processf_search->IsModal) { ?>
	fprocessfsearch = currentAdvancedSearchForm = new ew.Form("fprocessfsearch", "search");
	<?php } else { ?>
	fprocessfsearch = currentForm = new ew.Form("fprocessfsearch", "search");
	<?php } ?>
	currentPageID = ew.PAGE_ID = "search";

	// Validate function for search
	fprocessfsearch.validate = function(fobj) {
		if (!this.validateRequired)
			return true; // Ignore validation
		fobj = fobj || this._form;
		var infix = "";
		elm = this.getElements("x" + infix + "_step");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($processf_search->step->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_severity");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($processf_search->severity->errorMessage()) ?>");

		// Call Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
		return true;
	}

	// Form_CustomValidate
	fprocessfsearch.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fprocessfsearch.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fprocessfsearch.lists["x_fmea"] = <?php echo $processf_search->fmea->Lookup->toClientList($processf_search) ?>;
	fprocessfsearch.lists["x_fmea"].options = <?php echo JsonEncode($processf_search->fmea->lookupOptions()) ?>;
	fprocessfsearch.lists["x_derivedFromNC[]"] = <?php echo $processf_search->derivedFromNC->Lookup->toClientList($processf_search) ?>;
	fprocessfsearch.lists["x_derivedFromNC[]"].options = <?php echo JsonEncode($processf_search->derivedFromNC->options(FALSE, TRUE)) ?>;
	fprocessfsearch.lists["x_kc[]"] = <?php echo $processf_search->kc->Lookup->toClientList($processf_search) ?>;
	fprocessfsearch.lists["x_kc[]"].options = <?php echo JsonEncode($processf_search->kc->options(FALSE, TRUE)) ?>;
	loadjs.done("fprocessfsearch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $processf_search->showPageHeader(); ?>
<?php
$processf_search->showMessage();
?>
<form name="fprocessfsearch" id="fprocessfsearch" class="<?php echo $processf_search->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="processf">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?php echo (int)$processf_search->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($processf_search->fmea->Visible) { // fmea ?>
	<div id="r_fmea" class="form-group row">
		<label for="x_fmea" class="<?php echo $processf_search->LeftColumnClass ?>"><span id="elh_processf_fmea"><?php echo $processf_search->fmea->caption() ?></span>
		</label>
		<div class="<?php echo $processf_search->RightColumnClass ?>"><div <?php echo $processf_search->fmea->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_fmea" id="z_fmea" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_processf_fmea" class="ew-search-field">
<input type="text" data-table="processf" data-field="x_fmea" name="x_fmea" id="x_fmea" size="30" placeholder="<?php echo HtmlEncode($processf_search->fmea->getPlaceHolder()) ?>" value="<?php echo $processf_search->fmea->EditValue ?>"<?php echo $processf_search->fmea->editAttributes() ?>>
<?php echo $processf_search->fmea->Lookup->getParamTag($processf_search, "p_x_fmea") ?>
</span>
			<span class="ew-search-cond">
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_fmea_1" name="v_fmea" value="AND"<?php if ($processf_search->fmea->AdvancedSearch->SearchCondition != "OR") echo " checked" ?>><label class="custom-control-label" for="v_fmea_1"><?php echo $Language->phrase("AND") ?></label></div>
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_fmea_2" name="v_fmea" value="OR"<?php if ($processf_search->fmea->AdvancedSearch->SearchCondition == "OR") echo " checked" ?>><label class="custom-control-label" for="v_fmea_2"><?php echo $Language->phrase("OR") ?></label></div></span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span class="ew-search-operator2">
<select name="w_fmea" id="w_fmea" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator2 == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator2 == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator2 == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator2 == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator2 == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator2 == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator2 == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator2 == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator2 == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator2 == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator2 == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $processf_search->fmea->AdvancedSearch->SearchOperator2 == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
</select>
</span>
			<span id="el2_processf_fmea" class="ew-search-field2">
<input type="text" data-table="processf" data-field="x_fmea" name="y_fmea" id="y_fmea" size="30" placeholder="<?php echo HtmlEncode($processf_search->fmea->getPlaceHolder()) ?>" value="<?php echo $processf_search->fmea->EditValue2 ?>"<?php echo $processf_search->fmea->editAttributes() ?>>
<?php echo $processf_search->fmea->Lookup->getParamTag($processf_search, "p_y_fmea") ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($processf_search->step->Visible) { // step ?>
	<div id="r_step" class="form-group row">
		<label for="x_step" class="<?php echo $processf_search->LeftColumnClass ?>"><span id="elh_processf_step"><?php echo $processf_search->step->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("=") ?>
<input type="hidden" name="z_step" id="z_step" value="=">
</span>
		</label>
		<div class="<?php echo $processf_search->RightColumnClass ?>"><div <?php echo $processf_search->step->cellAttributes() ?>>
			<span id="el_processf_step" class="ew-search-field">
<input type="text" data-table="processf" data-field="x_step" name="x_step" id="x_step" size="30" maxlength="6" placeholder="<?php echo HtmlEncode($processf_search->step->getPlaceHolder()) ?>" value="<?php echo $processf_search->step->EditValue ?>"<?php echo $processf_search->step->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($processf_search->flowchartDesc->Visible) { // flowchartDesc ?>
	<div id="r_flowchartDesc" class="form-group row">
		<label for="x_flowchartDesc" class="<?php echo $processf_search->LeftColumnClass ?>"><span id="elh_processf_flowchartDesc"><?php echo $processf_search->flowchartDesc->caption() ?></span>
		</label>
		<div class="<?php echo $processf_search->RightColumnClass ?>"><div <?php echo $processf_search->flowchartDesc->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_flowchartDesc" id="z_flowchartDesc" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $processf_search->flowchartDesc->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $processf_search->flowchartDesc->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $processf_search->flowchartDesc->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $processf_search->flowchartDesc->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $processf_search->flowchartDesc->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $processf_search->flowchartDesc->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $processf_search->flowchartDesc->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $processf_search->flowchartDesc->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $processf_search->flowchartDesc->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $processf_search->flowchartDesc->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $processf_search->flowchartDesc->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $processf_search->flowchartDesc->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $processf_search->flowchartDesc->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_processf_flowchartDesc" class="ew-search-field">
<input type="text" data-table="processf" data-field="x_flowchartDesc" name="x_flowchartDesc" id="x_flowchartDesc" size="35" placeholder="<?php echo HtmlEncode($processf_search->flowchartDesc->getPlaceHolder()) ?>" value="<?php echo $processf_search->flowchartDesc->EditValue ?>"<?php echo $processf_search->flowchartDesc->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_processf_flowchartDesc" class="ew-search-field2 d-none">
<input type="text" data-table="processf" data-field="x_flowchartDesc" name="y_flowchartDesc" id="y_flowchartDesc" size="35" placeholder="<?php echo HtmlEncode($processf_search->flowchartDesc->getPlaceHolder()) ?>" value="<?php echo $processf_search->flowchartDesc->EditValue2 ?>"<?php echo $processf_search->flowchartDesc->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($processf_search->partnumber->Visible) { // partnumber ?>
	<div id="r_partnumber" class="form-group row">
		<label for="x_partnumber" class="<?php echo $processf_search->LeftColumnClass ?>"><span id="elh_processf_partnumber"><?php echo $processf_search->partnumber->caption() ?></span>
		</label>
		<div class="<?php echo $processf_search->RightColumnClass ?>"><div <?php echo $processf_search->partnumber->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_partnumber" id="z_partnumber" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $processf_search->partnumber->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $processf_search->partnumber->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $processf_search->partnumber->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $processf_search->partnumber->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $processf_search->partnumber->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $processf_search->partnumber->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $processf_search->partnumber->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $processf_search->partnumber->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $processf_search->partnumber->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $processf_search->partnumber->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $processf_search->partnumber->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $processf_search->partnumber->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $processf_search->partnumber->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_processf_partnumber" class="ew-search-field">
<input type="text" data-table="processf" data-field="x_partnumber" name="x_partnumber" id="x_partnumber" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_search->partnumber->getPlaceHolder()) ?>" value="<?php echo $processf_search->partnumber->EditValue ?>"<?php echo $processf_search->partnumber->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_processf_partnumber" class="ew-search-field2 d-none">
<input type="text" data-table="processf" data-field="x_partnumber" name="y_partnumber" id="y_partnumber" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_search->partnumber->getPlaceHolder()) ?>" value="<?php echo $processf_search->partnumber->EditValue2 ?>"<?php echo $processf_search->partnumber->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($processf_search->operation->Visible) { // operation ?>
	<div id="r_operation" class="form-group row">
		<label for="x_operation" class="<?php echo $processf_search->LeftColumnClass ?>"><span id="elh_processf_operation"><?php echo $processf_search->operation->caption() ?></span>
		</label>
		<div class="<?php echo $processf_search->RightColumnClass ?>"><div <?php echo $processf_search->operation->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_operation" id="z_operation" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $processf_search->operation->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $processf_search->operation->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $processf_search->operation->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $processf_search->operation->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $processf_search->operation->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $processf_search->operation->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $processf_search->operation->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $processf_search->operation->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $processf_search->operation->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $processf_search->operation->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $processf_search->operation->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $processf_search->operation->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $processf_search->operation->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_processf_operation" class="ew-search-field">
<input type="text" data-table="processf" data-field="x_operation" name="x_operation" id="x_operation" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_search->operation->getPlaceHolder()) ?>" value="<?php echo $processf_search->operation->EditValue ?>"<?php echo $processf_search->operation->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_processf_operation" class="ew-search-field2 d-none">
<input type="text" data-table="processf" data-field="x_operation" name="y_operation" id="y_operation" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_search->operation->getPlaceHolder()) ?>" value="<?php echo $processf_search->operation->EditValue2 ?>"<?php echo $processf_search->operation->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($processf_search->derivedFromNC->Visible) { // derivedFromNC ?>
	<div id="r_derivedFromNC" class="form-group row">
		<label class="<?php echo $processf_search->LeftColumnClass ?>"><span id="elh_processf_derivedFromNC"><?php echo $processf_search->derivedFromNC->caption() ?></span>
		</label>
		<div class="<?php echo $processf_search->RightColumnClass ?>"><div <?php echo $processf_search->derivedFromNC->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_derivedFromNC" id="z_derivedFromNC" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $processf_search->derivedFromNC->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $processf_search->derivedFromNC->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $processf_search->derivedFromNC->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $processf_search->derivedFromNC->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $processf_search->derivedFromNC->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $processf_search->derivedFromNC->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $processf_search->derivedFromNC->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $processf_search->derivedFromNC->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $processf_search->derivedFromNC->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $processf_search->derivedFromNC->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $processf_search->derivedFromNC->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $processf_search->derivedFromNC->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $processf_search->derivedFromNC->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_processf_derivedFromNC" class="ew-search-field">
<?php
$selwrk = ConvertToBool($processf_search->derivedFromNC->AdvancedSearch->SearchValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="processf" data-field="x_derivedFromNC" name="x_derivedFromNC[]" id="x_derivedFromNC[]" value="1"<?php echo $selwrk ?><?php echo $processf_search->derivedFromNC->editAttributes() ?>>
	<label class="custom-control-label" for="x_derivedFromNC[]"></label>
</div>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_processf_derivedFromNC" class="ew-search-field2 d-none">
<?php
$selwrk = ConvertToBool($processf_search->derivedFromNC->AdvancedSearch->SearchValue2) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="processf" data-field="x_derivedFromNC" name="y_derivedFromNC[]" id="y_derivedFromNC[]" value="1"<?php echo $selwrk ?><?php echo $processf_search->derivedFromNC->editAttributes() ?>>
	<label class="custom-control-label" for="y_derivedFromNC[]"></label>
</div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($processf_search->numberOfNC->Visible) { // numberOfNC ?>
	<div id="r_numberOfNC" class="form-group row">
		<label for="x_numberOfNC" class="<?php echo $processf_search->LeftColumnClass ?>"><span id="elh_processf_numberOfNC"><?php echo $processf_search->numberOfNC->caption() ?></span>
		</label>
		<div class="<?php echo $processf_search->RightColumnClass ?>"><div <?php echo $processf_search->numberOfNC->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_numberOfNC" id="z_numberOfNC" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $processf_search->numberOfNC->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $processf_search->numberOfNC->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $processf_search->numberOfNC->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $processf_search->numberOfNC->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $processf_search->numberOfNC->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $processf_search->numberOfNC->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $processf_search->numberOfNC->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $processf_search->numberOfNC->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $processf_search->numberOfNC->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $processf_search->numberOfNC->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $processf_search->numberOfNC->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $processf_search->numberOfNC->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $processf_search->numberOfNC->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_processf_numberOfNC" class="ew-search-field">
<input type="text" data-table="processf" data-field="x_numberOfNC" name="x_numberOfNC" id="x_numberOfNC" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_search->numberOfNC->getPlaceHolder()) ?>" value="<?php echo $processf_search->numberOfNC->EditValue ?>"<?php echo $processf_search->numberOfNC->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_processf_numberOfNC" class="ew-search-field2 d-none">
<input type="text" data-table="processf" data-field="x_numberOfNC" name="y_numberOfNC" id="y_numberOfNC" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_search->numberOfNC->getPlaceHolder()) ?>" value="<?php echo $processf_search->numberOfNC->EditValue2 ?>"<?php echo $processf_search->numberOfNC->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($processf_search->flowchart->Visible) { // flowchart ?>
	<div id="r_flowchart" class="form-group row">
		<label for="x_flowchart" class="<?php echo $processf_search->LeftColumnClass ?>"><span id="elh_processf_flowchart"><?php echo $processf_search->flowchart->caption() ?></span>
		</label>
		<div class="<?php echo $processf_search->RightColumnClass ?>"><div <?php echo $processf_search->flowchart->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_flowchart" id="z_flowchart" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_processf_flowchart" class="ew-search-field">
<input type="text" data-table="processf" data-field="x_flowchart" name="x_flowchart" id="x_flowchart" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_search->flowchart->getPlaceHolder()) ?>" value="<?php echo $processf_search->flowchart->EditValue ?>"<?php echo $processf_search->flowchart->editAttributes() ?>>
</span>
			<span class="ew-search-cond">
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_flowchart_1" name="v_flowchart" value="AND"<?php if ($processf_search->flowchart->AdvancedSearch->SearchCondition != "OR") echo " checked" ?>><label class="custom-control-label" for="v_flowchart_1"><?php echo $Language->phrase("AND") ?></label></div>
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_flowchart_2" name="v_flowchart" value="OR"<?php if ($processf_search->flowchart->AdvancedSearch->SearchCondition == "OR") echo " checked" ?>><label class="custom-control-label" for="v_flowchart_2"><?php echo $Language->phrase("OR") ?></label></div></span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span class="ew-search-operator2">
<select name="w_flowchart" id="w_flowchart" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator2 == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator2 == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator2 == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator2 == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator2 == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator2 == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator2 == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator2 == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator2 == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator2 == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator2 == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $processf_search->flowchart->AdvancedSearch->SearchOperator2 == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
</select>
</span>
			<span id="el2_processf_flowchart" class="ew-search-field2">
<input type="text" data-table="processf" data-field="x_flowchart" name="y_flowchart" id="y_flowchart" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_search->flowchart->getPlaceHolder()) ?>" value="<?php echo $processf_search->flowchart->EditValue2 ?>"<?php echo $processf_search->flowchart->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($processf_search->subprocess->Visible) { // subprocess ?>
	<div id="r_subprocess" class="form-group row">
		<label for="x_subprocess" class="<?php echo $processf_search->LeftColumnClass ?>"><span id="elh_processf_subprocess"><?php echo $processf_search->subprocess->caption() ?></span>
		</label>
		<div class="<?php echo $processf_search->RightColumnClass ?>"><div <?php echo $processf_search->subprocess->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_subprocess" id="z_subprocess" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $processf_search->subprocess->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $processf_search->subprocess->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $processf_search->subprocess->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $processf_search->subprocess->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $processf_search->subprocess->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $processf_search->subprocess->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $processf_search->subprocess->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $processf_search->subprocess->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $processf_search->subprocess->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $processf_search->subprocess->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $processf_search->subprocess->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $processf_search->subprocess->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $processf_search->subprocess->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_processf_subprocess" class="ew-search-field">
<input type="text" data-table="processf" data-field="x_subprocess" name="x_subprocess" id="x_subprocess" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_search->subprocess->getPlaceHolder()) ?>" value="<?php echo $processf_search->subprocess->EditValue ?>"<?php echo $processf_search->subprocess->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_processf_subprocess" class="ew-search-field2 d-none">
<input type="text" data-table="processf" data-field="x_subprocess" name="y_subprocess" id="y_subprocess" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_search->subprocess->getPlaceHolder()) ?>" value="<?php echo $processf_search->subprocess->EditValue2 ?>"<?php echo $processf_search->subprocess->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($processf_search->requirement->Visible) { // requirement ?>
	<div id="r_requirement" class="form-group row">
		<label for="x_requirement" class="<?php echo $processf_search->LeftColumnClass ?>"><span id="elh_processf_requirement"><?php echo $processf_search->requirement->caption() ?></span>
		</label>
		<div class="<?php echo $processf_search->RightColumnClass ?>"><div <?php echo $processf_search->requirement->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_requirement" id="z_requirement" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $processf_search->requirement->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $processf_search->requirement->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $processf_search->requirement->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $processf_search->requirement->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $processf_search->requirement->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $processf_search->requirement->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $processf_search->requirement->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $processf_search->requirement->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $processf_search->requirement->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $processf_search->requirement->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $processf_search->requirement->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $processf_search->requirement->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $processf_search->requirement->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_processf_requirement" class="ew-search-field">
<input type="text" data-table="processf" data-field="x_requirement" name="x_requirement" id="x_requirement" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_search->requirement->getPlaceHolder()) ?>" value="<?php echo $processf_search->requirement->EditValue ?>"<?php echo $processf_search->requirement->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_processf_requirement" class="ew-search-field2 d-none">
<input type="text" data-table="processf" data-field="x_requirement" name="y_requirement" id="y_requirement" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_search->requirement->getPlaceHolder()) ?>" value="<?php echo $processf_search->requirement->EditValue2 ?>"<?php echo $processf_search->requirement->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($processf_search->potencialFailureMode->Visible) { // potencialFailureMode ?>
	<div id="r_potencialFailureMode" class="form-group row">
		<label for="x_potencialFailureMode" class="<?php echo $processf_search->LeftColumnClass ?>"><span id="elh_processf_potencialFailureMode"><?php echo $processf_search->potencialFailureMode->caption() ?></span>
		</label>
		<div class="<?php echo $processf_search->RightColumnClass ?>"><div <?php echo $processf_search->potencialFailureMode->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_potencialFailureMode" id="z_potencialFailureMode" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $processf_search->potencialFailureMode->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $processf_search->potencialFailureMode->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $processf_search->potencialFailureMode->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $processf_search->potencialFailureMode->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $processf_search->potencialFailureMode->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $processf_search->potencialFailureMode->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $processf_search->potencialFailureMode->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $processf_search->potencialFailureMode->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $processf_search->potencialFailureMode->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $processf_search->potencialFailureMode->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $processf_search->potencialFailureMode->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $processf_search->potencialFailureMode->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $processf_search->potencialFailureMode->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_processf_potencialFailureMode" class="ew-search-field">
<input type="text" data-table="processf" data-field="x_potencialFailureMode" name="x_potencialFailureMode" id="x_potencialFailureMode" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_search->potencialFailureMode->getPlaceHolder()) ?>" value="<?php echo $processf_search->potencialFailureMode->EditValue ?>"<?php echo $processf_search->potencialFailureMode->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_processf_potencialFailureMode" class="ew-search-field2 d-none">
<input type="text" data-table="processf" data-field="x_potencialFailureMode" name="y_potencialFailureMode" id="y_potencialFailureMode" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_search->potencialFailureMode->getPlaceHolder()) ?>" value="<?php echo $processf_search->potencialFailureMode->EditValue2 ?>"<?php echo $processf_search->potencialFailureMode->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($processf_search->potencialFailurEffect->Visible) { // potencialFailurEffect ?>
	<div id="r_potencialFailurEffect" class="form-group row">
		<label for="x_potencialFailurEffect" class="<?php echo $processf_search->LeftColumnClass ?>"><span id="elh_processf_potencialFailurEffect"><?php echo $processf_search->potencialFailurEffect->caption() ?></span>
		</label>
		<div class="<?php echo $processf_search->RightColumnClass ?>"><div <?php echo $processf_search->potencialFailurEffect->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_potencialFailurEffect" id="z_potencialFailurEffect" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $processf_search->potencialFailurEffect->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $processf_search->potencialFailurEffect->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $processf_search->potencialFailurEffect->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $processf_search->potencialFailurEffect->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $processf_search->potencialFailurEffect->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $processf_search->potencialFailurEffect->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $processf_search->potencialFailurEffect->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $processf_search->potencialFailurEffect->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $processf_search->potencialFailurEffect->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $processf_search->potencialFailurEffect->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $processf_search->potencialFailurEffect->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $processf_search->potencialFailurEffect->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $processf_search->potencialFailurEffect->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_processf_potencialFailurEffect" class="ew-search-field">
<input type="text" data-table="processf" data-field="x_potencialFailurEffect" name="x_potencialFailurEffect" id="x_potencialFailurEffect" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_search->potencialFailurEffect->getPlaceHolder()) ?>" value="<?php echo $processf_search->potencialFailurEffect->EditValue ?>"<?php echo $processf_search->potencialFailurEffect->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_processf_potencialFailurEffect" class="ew-search-field2 d-none">
<input type="text" data-table="processf" data-field="x_potencialFailurEffect" name="y_potencialFailurEffect" id="y_potencialFailurEffect" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_search->potencialFailurEffect->getPlaceHolder()) ?>" value="<?php echo $processf_search->potencialFailurEffect->EditValue2 ?>"<?php echo $processf_search->potencialFailurEffect->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($processf_search->kc->Visible) { // kc ?>
	<div id="r_kc" class="form-group row">
		<label class="<?php echo $processf_search->LeftColumnClass ?>"><span id="elh_processf_kc"><?php echo $processf_search->kc->caption() ?></span>
		</label>
		<div class="<?php echo $processf_search->RightColumnClass ?>"><div <?php echo $processf_search->kc->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_kc" id="z_kc" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $processf_search->kc->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $processf_search->kc->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $processf_search->kc->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $processf_search->kc->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $processf_search->kc->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $processf_search->kc->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $processf_search->kc->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $processf_search->kc->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $processf_search->kc->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $processf_search->kc->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $processf_search->kc->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $processf_search->kc->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $processf_search->kc->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_processf_kc" class="ew-search-field">
<?php
$selwrk = ConvertToBool($processf_search->kc->AdvancedSearch->SearchValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="processf" data-field="x_kc" name="x_kc[]" id="x_kc[]" value="1"<?php echo $selwrk ?><?php echo $processf_search->kc->editAttributes() ?>>
	<label class="custom-control-label" for="x_kc[]"></label>
</div>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_processf_kc" class="ew-search-field2 d-none">
<?php
$selwrk = ConvertToBool($processf_search->kc->AdvancedSearch->SearchValue2) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="processf" data-field="x_kc" name="y_kc[]" id="y_kc[]" value="1"<?php echo $selwrk ?><?php echo $processf_search->kc->editAttributes() ?>>
	<label class="custom-control-label" for="y_kc[]"></label>
</div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($processf_search->severity->Visible) { // severity ?>
	<div id="r_severity" class="form-group row">
		<label for="x_severity" class="<?php echo $processf_search->LeftColumnClass ?>"><span id="elh_processf_severity"><?php echo $processf_search->severity->caption() ?></span>
		</label>
		<div class="<?php echo $processf_search->RightColumnClass ?>"><div <?php echo $processf_search->severity->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_severity" id="z_severity" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $processf_search->severity->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $processf_search->severity->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $processf_search->severity->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $processf_search->severity->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $processf_search->severity->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $processf_search->severity->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $processf_search->severity->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $processf_search->severity->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $processf_search->severity->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_processf_severity" class="ew-search-field">
<input type="text" data-table="processf" data-field="x_severity" name="x_severity" id="x_severity" size="3" placeholder="<?php echo HtmlEncode($processf_search->severity->getPlaceHolder()) ?>" value="<?php echo $processf_search->severity->EditValue ?>"<?php echo $processf_search->severity->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_processf_severity" class="ew-search-field2 d-none">
<input type="text" data-table="processf" data-field="x_severity" name="y_severity" id="y_severity" size="3" placeholder="<?php echo HtmlEncode($processf_search->severity->getPlaceHolder()) ?>" value="<?php echo $processf_search->severity->EditValue2 ?>"<?php echo $processf_search->severity->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$processf_search->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $processf_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("Search") ?></button>
<button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" onclick="ew.clearForm(this.form);"><?php echo $Language->phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$processf_search->showPageFooter();
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
$processf_search->terminate();
?>