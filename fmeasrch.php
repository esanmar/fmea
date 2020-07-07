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
$fmea_search = new fmea_search();

// Run the page
$fmea_search->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$fmea_search->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var ffmeasearch, currentPageID;
loadjs.ready("head", function() {

	// Form object for search
	<?php if ($fmea_search->IsModal) { ?>
	ffmeasearch = currentAdvancedSearchForm = new ew.Form("ffmeasearch", "search");
	<?php } else { ?>
	ffmeasearch = currentForm = new ew.Form("ffmeasearch", "search");
	<?php } ?>
	currentPageID = ew.PAGE_ID = "search";

	// Validate function for search
	ffmeasearch.validate = function(fobj) {
		if (!this.validateRequired)
			return true; // Ignore validation
		fobj = fobj || this._form;
		var infix = "";
		elm = this.getElements("x" + infix + "_dateFmea");
		if (elm && !ew.checkDateDef(elm.value))
			return this.onError(elm, "<?php echo JsEncode($fmea_search->dateFmea->errorMessage()) ?>");

		// Call Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
		return true;
	}

	// Form_CustomValidate
	ffmeasearch.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	ffmeasearch.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	ffmeasearch.lists["x_idFactory"] = <?php echo $fmea_search->idFactory->Lookup->toClientList($fmea_search) ?>;
	ffmeasearch.lists["x_idFactory"].options = <?php echo JsonEncode($fmea_search->idFactory->lookupOptions()) ?>;
	ffmeasearch.lists["x_idEmployee[]"] = <?php echo $fmea_search->idEmployee->Lookup->toClientList($fmea_search) ?>;
	ffmeasearch.lists["x_idEmployee[]"].options = <?php echo JsonEncode($fmea_search->idEmployee->lookupOptions()) ?>;
	ffmeasearch.lists["x_idworkcenter"] = <?php echo $fmea_search->idworkcenter->Lookup->toClientList($fmea_search) ?>;
	ffmeasearch.lists["x_idworkcenter"].options = <?php echo JsonEncode($fmea_search->idworkcenter->lookupOptions()) ?>;
	loadjs.done("ffmeasearch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $fmea_search->showPageHeader(); ?>
<?php
$fmea_search->showMessage();
?>
<form name="ffmeasearch" id="ffmeasearch" class="<?php echo $fmea_search->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="fmea">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?php echo (int)$fmea_search->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($fmea_search->fmea->Visible) { // fmea ?>
	<div id="r_fmea" class="form-group row">
		<label for="x_fmea" class="<?php echo $fmea_search->LeftColumnClass ?>"><span id="elh_fmea_fmea"><?php echo $fmea_search->fmea->caption() ?></span>
		</label>
		<div class="<?php echo $fmea_search->RightColumnClass ?>"><div <?php echo $fmea_search->fmea->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_fmea" id="z_fmea" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $fmea_search->fmea->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $fmea_search->fmea->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $fmea_search->fmea->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $fmea_search->fmea->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $fmea_search->fmea->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $fmea_search->fmea->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $fmea_search->fmea->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $fmea_search->fmea->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $fmea_search->fmea->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $fmea_search->fmea->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="BETWEEN"<?php echo $fmea_search->fmea->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_fmea_fmea" class="ew-search-field">
<input type="text" data-table="fmea" data-field="x_fmea" name="x_fmea" id="x_fmea" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($fmea_search->fmea->getPlaceHolder()) ?>" value="<?php echo $fmea_search->fmea->EditValue ?>"<?php echo $fmea_search->fmea->editAttributes() ?>>
</span>
			<span class="ew-search-cond">
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_fmea_1" name="v_fmea" value="AND"<?php if ($fmea_search->fmea->AdvancedSearch->SearchCondition != "OR") echo " checked" ?>><label class="custom-control-label" for="v_fmea_1"><?php echo $Language->phrase("AND") ?></label></div>
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_fmea_2" name="v_fmea" value="OR"<?php if ($fmea_search->fmea->AdvancedSearch->SearchCondition == "OR") echo " checked" ?>><label class="custom-control-label" for="v_fmea_2"><?php echo $Language->phrase("OR") ?></label></div></span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span class="ew-search-operator2">
<select name="w_fmea" id="w_fmea" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $fmea_search->fmea->AdvancedSearch->SearchOperator2 == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $fmea_search->fmea->AdvancedSearch->SearchOperator2 == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $fmea_search->fmea->AdvancedSearch->SearchOperator2 == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $fmea_search->fmea->AdvancedSearch->SearchOperator2 == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $fmea_search->fmea->AdvancedSearch->SearchOperator2 == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $fmea_search->fmea->AdvancedSearch->SearchOperator2 == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $fmea_search->fmea->AdvancedSearch->SearchOperator2 == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $fmea_search->fmea->AdvancedSearch->SearchOperator2 == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $fmea_search->fmea->AdvancedSearch->SearchOperator2 == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $fmea_search->fmea->AdvancedSearch->SearchOperator2 == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
</select>
</span>
			<span id="el2_fmea_fmea" class="ew-search-field2">
<input type="text" data-table="fmea" data-field="x_fmea" name="y_fmea" id="y_fmea" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($fmea_search->fmea->getPlaceHolder()) ?>" value="<?php echo $fmea_search->fmea->EditValue2 ?>"<?php echo $fmea_search->fmea->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($fmea_search->idFactory->Visible) { // idFactory ?>
	<div id="r_idFactory" class="form-group row">
		<label for="x_idFactory" class="<?php echo $fmea_search->LeftColumnClass ?>"><span id="elh_fmea_idFactory"><?php echo $fmea_search->idFactory->caption() ?></span>
		</label>
		<div class="<?php echo $fmea_search->RightColumnClass ?>"><div <?php echo $fmea_search->idFactory->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_idFactory" id="z_idFactory" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_fmea_idFactory" class="ew-search-field">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="fmea" data-field="x_idFactory" data-value-separator="<?php echo $fmea_search->idFactory->displayValueSeparatorAttribute() ?>" id="x_idFactory" name="x_idFactory"<?php echo $fmea_search->idFactory->editAttributes() ?>>
			<?php echo $fmea_search->idFactory->selectOptionListHtml("x_idFactory") ?>
		</select>
</div>
<?php echo $fmea_search->idFactory->Lookup->getParamTag($fmea_search, "p_x_idFactory") ?>
</span>
			<span class="ew-search-cond">
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_idFactory_1" name="v_idFactory" value="AND"<?php if ($fmea_search->idFactory->AdvancedSearch->SearchCondition != "OR") echo " checked" ?>><label class="custom-control-label" for="v_idFactory_1"><?php echo $Language->phrase("AND") ?></label></div>
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_idFactory_2" name="v_idFactory" value="OR"<?php if ($fmea_search->idFactory->AdvancedSearch->SearchCondition == "OR") echo " checked" ?>><label class="custom-control-label" for="v_idFactory_2"><?php echo $Language->phrase("OR") ?></label></div></span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span class="ew-search-operator2">
<select name="w_idFactory" id="w_idFactory" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator2 == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator2 == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator2 == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator2 == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator2 == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator2 == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator2 == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator2 == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator2 == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator2 == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator2 == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $fmea_search->idFactory->AdvancedSearch->SearchOperator2 == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
</select>
</span>
			<span id="el2_fmea_idFactory" class="ew-search-field2">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="fmea" data-field="x_idFactory" data-value-separator="<?php echo $fmea_search->idFactory->displayValueSeparatorAttribute() ?>" id="y_idFactory" name="y_idFactory"<?php echo $fmea_search->idFactory->editAttributes() ?>>
			<?php echo $fmea_search->idFactory->selectOptionListHtml("y_idFactory") ?>
		</select>
</div>
<?php echo $fmea_search->idFactory->Lookup->getParamTag($fmea_search, "p_y_idFactory") ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($fmea_search->dateFmea->Visible) { // dateFmea ?>
	<div id="r_dateFmea" class="form-group row">
		<label for="x_dateFmea" class="<?php echo $fmea_search->LeftColumnClass ?>"><span id="elh_fmea_dateFmea"><?php echo $fmea_search->dateFmea->caption() ?></span>
		</label>
		<div class="<?php echo $fmea_search->RightColumnClass ?>"><div <?php echo $fmea_search->dateFmea->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_dateFmea" id="z_dateFmea" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $fmea_search->dateFmea->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $fmea_search->dateFmea->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $fmea_search->dateFmea->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $fmea_search->dateFmea->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $fmea_search->dateFmea->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $fmea_search->dateFmea->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $fmea_search->dateFmea->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $fmea_search->dateFmea->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $fmea_search->dateFmea->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_fmea_dateFmea" class="ew-search-field">
<input type="text" data-table="fmea" data-field="x_dateFmea" name="x_dateFmea" id="x_dateFmea" placeholder="<?php echo HtmlEncode($fmea_search->dateFmea->getPlaceHolder()) ?>" value="<?php echo $fmea_search->dateFmea->EditValue ?>"<?php echo $fmea_search->dateFmea->editAttributes() ?>>
<?php if (!$fmea_search->dateFmea->ReadOnly && !$fmea_search->dateFmea->Disabled && !isset($fmea_search->dateFmea->EditAttrs["readonly"]) && !isset($fmea_search->dateFmea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffmeasearch", "datetimepicker"], function() {
	ew.createDateTimePicker("ffmeasearch", "x_dateFmea", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
			<span class="ew-search-cond">
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_dateFmea_1" name="v_dateFmea" value="AND"<?php if ($fmea_search->dateFmea->AdvancedSearch->SearchCondition != "OR") echo " checked" ?>><label class="custom-control-label" for="v_dateFmea_1"><?php echo $Language->phrase("AND") ?></label></div>
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_dateFmea_2" name="v_dateFmea" value="OR"<?php if ($fmea_search->dateFmea->AdvancedSearch->SearchCondition == "OR") echo " checked" ?>><label class="custom-control-label" for="v_dateFmea_2"><?php echo $Language->phrase("OR") ?></label></div></span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span class="ew-search-operator2">
<select name="w_dateFmea" id="w_dateFmea" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $fmea_search->dateFmea->AdvancedSearch->SearchOperator2 == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $fmea_search->dateFmea->AdvancedSearch->SearchOperator2 == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $fmea_search->dateFmea->AdvancedSearch->SearchOperator2 == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $fmea_search->dateFmea->AdvancedSearch->SearchOperator2 == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $fmea_search->dateFmea->AdvancedSearch->SearchOperator2 == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $fmea_search->dateFmea->AdvancedSearch->SearchOperator2 == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $fmea_search->dateFmea->AdvancedSearch->SearchOperator2 == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $fmea_search->dateFmea->AdvancedSearch->SearchOperator2 == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
</select>
</span>
			<span id="el2_fmea_dateFmea" class="ew-search-field2">
<input type="text" data-table="fmea" data-field="x_dateFmea" name="y_dateFmea" id="y_dateFmea" placeholder="<?php echo HtmlEncode($fmea_search->dateFmea->getPlaceHolder()) ?>" value="<?php echo $fmea_search->dateFmea->EditValue2 ?>"<?php echo $fmea_search->dateFmea->editAttributes() ?>>
<?php if (!$fmea_search->dateFmea->ReadOnly && !$fmea_search->dateFmea->Disabled && !isset($fmea_search->dateFmea->EditAttrs["readonly"]) && !isset($fmea_search->dateFmea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffmeasearch", "datetimepicker"], function() {
	ew.createDateTimePicker("ffmeasearch", "y_dateFmea", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($fmea_search->partnumbers->Visible) { // partnumbers ?>
	<div id="r_partnumbers" class="form-group row">
		<label for="x_partnumbers" class="<?php echo $fmea_search->LeftColumnClass ?>"><span id="elh_fmea_partnumbers"><?php echo $fmea_search->partnumbers->caption() ?></span>
		</label>
		<div class="<?php echo $fmea_search->RightColumnClass ?>"><div <?php echo $fmea_search->partnumbers->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_partnumbers" id="z_partnumbers" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_fmea_partnumbers" class="ew-search-field">
<input type="text" data-table="fmea" data-field="x_partnumbers" name="x_partnumbers" id="x_partnumbers" size="35" placeholder="<?php echo HtmlEncode($fmea_search->partnumbers->getPlaceHolder()) ?>" value="<?php echo $fmea_search->partnumbers->EditValue ?>"<?php echo $fmea_search->partnumbers->editAttributes() ?>>
</span>
			<span class="ew-search-cond">
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_partnumbers_1" name="v_partnumbers" value="AND"<?php if ($fmea_search->partnumbers->AdvancedSearch->SearchCondition != "OR") echo " checked" ?>><label class="custom-control-label" for="v_partnumbers_1"><?php echo $Language->phrase("AND") ?></label></div>
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_partnumbers_2" name="v_partnumbers" value="OR"<?php if ($fmea_search->partnumbers->AdvancedSearch->SearchCondition == "OR") echo " checked" ?>><label class="custom-control-label" for="v_partnumbers_2"><?php echo $Language->phrase("OR") ?></label></div></span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span class="ew-search-operator2">
<select name="w_partnumbers" id="w_partnumbers" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator2 == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator2 == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator2 == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator2 == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator2 == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator2 == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator2 == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator2 == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator2 == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator2 == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator2 == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $fmea_search->partnumbers->AdvancedSearch->SearchOperator2 == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
</select>
</span>
			<span id="el2_fmea_partnumbers" class="ew-search-field2">
<input type="text" data-table="fmea" data-field="x_partnumbers" name="y_partnumbers" id="y_partnumbers" size="35" placeholder="<?php echo HtmlEncode($fmea_search->partnumbers->getPlaceHolder()) ?>" value="<?php echo $fmea_search->partnumbers->EditValue2 ?>"<?php echo $fmea_search->partnumbers->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($fmea_search->description->Visible) { // description ?>
	<div id="r_description" class="form-group row">
		<label for="x_description" class="<?php echo $fmea_search->LeftColumnClass ?>"><span id="elh_fmea_description"><?php echo $fmea_search->description->caption() ?></span>
		</label>
		<div class="<?php echo $fmea_search->RightColumnClass ?>"><div <?php echo $fmea_search->description->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_description" id="z_description" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $fmea_search->description->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $fmea_search->description->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $fmea_search->description->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $fmea_search->description->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $fmea_search->description->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $fmea_search->description->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $fmea_search->description->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $fmea_search->description->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $fmea_search->description->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $fmea_search->description->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $fmea_search->description->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $fmea_search->description->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $fmea_search->description->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_fmea_description" class="ew-search-field">
<input type="text" data-table="fmea" data-field="x_description" name="x_description" id="x_description" size="35" placeholder="<?php echo HtmlEncode($fmea_search->description->getPlaceHolder()) ?>" value="<?php echo $fmea_search->description->EditValue ?>"<?php echo $fmea_search->description->editAttributes() ?>>
</span>
			<span class="ew-search-cond">
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_description_1" name="v_description" value="AND"<?php if ($fmea_search->description->AdvancedSearch->SearchCondition != "OR") echo " checked" ?>><label class="custom-control-label" for="v_description_1"><?php echo $Language->phrase("AND") ?></label></div>
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_description_2" name="v_description" value="OR"<?php if ($fmea_search->description->AdvancedSearch->SearchCondition == "OR") echo " checked" ?>><label class="custom-control-label" for="v_description_2"><?php echo $Language->phrase("OR") ?></label></div></span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span class="ew-search-operator2">
<select name="w_description" id="w_description" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $fmea_search->description->AdvancedSearch->SearchOperator2 == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $fmea_search->description->AdvancedSearch->SearchOperator2 == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $fmea_search->description->AdvancedSearch->SearchOperator2 == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $fmea_search->description->AdvancedSearch->SearchOperator2 == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $fmea_search->description->AdvancedSearch->SearchOperator2 == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $fmea_search->description->AdvancedSearch->SearchOperator2 == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $fmea_search->description->AdvancedSearch->SearchOperator2 == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $fmea_search->description->AdvancedSearch->SearchOperator2 == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $fmea_search->description->AdvancedSearch->SearchOperator2 == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $fmea_search->description->AdvancedSearch->SearchOperator2 == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $fmea_search->description->AdvancedSearch->SearchOperator2 == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $fmea_search->description->AdvancedSearch->SearchOperator2 == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
</select>
</span>
			<span id="el2_fmea_description" class="ew-search-field2">
<input type="text" data-table="fmea" data-field="x_description" name="y_description" id="y_description" size="35" placeholder="<?php echo HtmlEncode($fmea_search->description->getPlaceHolder()) ?>" value="<?php echo $fmea_search->description->EditValue2 ?>"<?php echo $fmea_search->description->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($fmea_search->idEmployee->Visible) { // idEmployee ?>
	<div id="r_idEmployee" class="form-group row">
		<label for="x_idEmployee" class="<?php echo $fmea_search->LeftColumnClass ?>"><span id="elh_fmea_idEmployee"><?php echo $fmea_search->idEmployee->caption() ?></span>
		</label>
		<div class="<?php echo $fmea_search->RightColumnClass ?>"><div <?php echo $fmea_search->idEmployee->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_idEmployee" id="z_idEmployee" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_fmea_idEmployee" class="ew-search-field">
<input type="text" data-table="fmea" data-field="x_idEmployee" name="x_idEmployee" id="x_idEmployee" size="30" placeholder="<?php echo HtmlEncode($fmea_search->idEmployee->getPlaceHolder()) ?>" value="<?php echo $fmea_search->idEmployee->EditValue ?>"<?php echo $fmea_search->idEmployee->editAttributes() ?>>
<?php echo $fmea_search->idEmployee->Lookup->getParamTag($fmea_search, "p_x_idEmployee") ?>
</span>
			<span class="ew-search-cond">
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_idEmployee_1" name="v_idEmployee" value="AND"<?php if ($fmea_search->idEmployee->AdvancedSearch->SearchCondition != "OR") echo " checked" ?>><label class="custom-control-label" for="v_idEmployee_1"><?php echo $Language->phrase("AND") ?></label></div>
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_idEmployee_2" name="v_idEmployee" value="OR"<?php if ($fmea_search->idEmployee->AdvancedSearch->SearchCondition == "OR") echo " checked" ?>><label class="custom-control-label" for="v_idEmployee_2"><?php echo $Language->phrase("OR") ?></label></div></span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span class="ew-search-operator2">
<select name="w_idEmployee" id="w_idEmployee" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator2 == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator2 == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator2 == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator2 == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator2 == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator2 == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator2 == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator2 == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator2 == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator2 == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator2 == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $fmea_search->idEmployee->AdvancedSearch->SearchOperator2 == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
</select>
</span>
			<span id="el2_fmea_idEmployee" class="ew-search-field2">
<input type="text" data-table="fmea" data-field="x_idEmployee" name="y_idEmployee" id="y_idEmployee" size="30" placeholder="<?php echo HtmlEncode($fmea_search->idEmployee->getPlaceHolder()) ?>" value="<?php echo $fmea_search->idEmployee->EditValue2 ?>"<?php echo $fmea_search->idEmployee->editAttributes() ?>>
<?php echo $fmea_search->idEmployee->Lookup->getParamTag($fmea_search, "p_y_idEmployee") ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($fmea_search->idworkcenter->Visible) { // idworkcenter ?>
	<div id="r_idworkcenter" class="form-group row">
		<label for="x_idworkcenter" class="<?php echo $fmea_search->LeftColumnClass ?>"><span id="elh_fmea_idworkcenter"><?php echo $fmea_search->idworkcenter->caption() ?></span>
		</label>
		<div class="<?php echo $fmea_search->RightColumnClass ?>"><div <?php echo $fmea_search->idworkcenter->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_idworkcenter" id="z_idworkcenter" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_fmea_idworkcenter" class="ew-search-field">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="fmea" data-field="x_idworkcenter" data-value-separator="<?php echo $fmea_search->idworkcenter->displayValueSeparatorAttribute() ?>" id="x_idworkcenter" name="x_idworkcenter"<?php echo $fmea_search->idworkcenter->editAttributes() ?>>
			<?php echo $fmea_search->idworkcenter->selectOptionListHtml("x_idworkcenter") ?>
		</select>
</div>
<?php echo $fmea_search->idworkcenter->Lookup->getParamTag($fmea_search, "p_x_idworkcenter") ?>
</span>
			<span class="ew-search-cond">
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_idworkcenter_1" name="v_idworkcenter" value="AND"<?php if ($fmea_search->idworkcenter->AdvancedSearch->SearchCondition != "OR") echo " checked" ?>><label class="custom-control-label" for="v_idworkcenter_1"><?php echo $Language->phrase("AND") ?></label></div>
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_idworkcenter_2" name="v_idworkcenter" value="OR"<?php if ($fmea_search->idworkcenter->AdvancedSearch->SearchCondition == "OR") echo " checked" ?>><label class="custom-control-label" for="v_idworkcenter_2"><?php echo $Language->phrase("OR") ?></label></div></span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span class="ew-search-operator2">
<select name="w_idworkcenter" id="w_idworkcenter" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator2 == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator2 == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator2 == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator2 == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator2 == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator2 == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator2 == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator2 == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator2 == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator2 == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator2 == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $fmea_search->idworkcenter->AdvancedSearch->SearchOperator2 == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
</select>
</span>
			<span id="el2_fmea_idworkcenter" class="ew-search-field2">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="fmea" data-field="x_idworkcenter" data-value-separator="<?php echo $fmea_search->idworkcenter->displayValueSeparatorAttribute() ?>" id="y_idworkcenter" name="y_idworkcenter"<?php echo $fmea_search->idworkcenter->editAttributes() ?>>
			<?php echo $fmea_search->idworkcenter->selectOptionListHtml("y_idworkcenter") ?>
		</select>
</div>
<?php echo $fmea_search->idworkcenter->Lookup->getParamTag($fmea_search, "p_y_idworkcenter") ?>
</span>
		</div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$fmea_search->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $fmea_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("Search") ?></button>
<button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" onclick="ew.clearForm(this.form);"><?php echo $Language->phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$fmea_search->showPageFooter();
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
$fmea_search->terminate();
?>