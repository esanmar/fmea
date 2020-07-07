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
$employees_search = new employees_search();

// Run the page
$employees_search->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$employees_search->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var femployeessearch, currentPageID;
loadjs.ready("head", function() {

	// Form object for search
	<?php if ($employees_search->IsModal) { ?>
	femployeessearch = currentAdvancedSearchForm = new ew.Form("femployeessearch", "search");
	<?php } else { ?>
	femployeessearch = currentForm = new ew.Form("femployeessearch", "search");
	<?php } ?>
	currentPageID = ew.PAGE_ID = "search";

	// Validate function for search
	femployeessearch.validate = function(fobj) {
		if (!this.validateRequired)
			return true; // Ignore validation
		fobj = fobj || this._form;
		var infix = "";

		// Call Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
		return true;
	}

	// Form_CustomValidate
	femployeessearch.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	femployeessearch.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	femployeessearch.lists["x_idFactory"] = <?php echo $employees_search->idFactory->Lookup->toClientList($employees_search) ?>;
	femployeessearch.lists["x_idFactory"].options = <?php echo JsonEncode($employees_search->idFactory->lookupOptions()) ?>;
	femployeessearch.autoSuggests["x_idFactory"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
	femployeessearch.lists["x_userlevel"] = <?php echo $employees_search->userlevel->Lookup->toClientList($employees_search) ?>;
	femployeessearch.lists["x_userlevel"].options = <?php echo JsonEncode($employees_search->userlevel->options(FALSE, TRUE)) ?>;
	femployeessearch.lists["x_workcenter"] = <?php echo $employees_search->workcenter->Lookup->toClientList($employees_search) ?>;
	femployeessearch.lists["x_workcenter"].options = <?php echo JsonEncode($employees_search->workcenter->lookupOptions()) ?>;
	femployeessearch.autoSuggests["x_workcenter"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
	loadjs.done("femployeessearch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $employees_search->showPageHeader(); ?>
<?php
$employees_search->showMessage();
?>
<form name="femployeessearch" id="femployeessearch" class="<?php echo $employees_search->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="employees">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?php echo (int)$employees_search->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($employees_search->idEmployee->Visible) { // idEmployee ?>
	<div id="r_idEmployee" class="form-group row">
		<label for="x_idEmployee" class="<?php echo $employees_search->LeftColumnClass ?>"><span id="elh_employees_idEmployee"><?php echo $employees_search->idEmployee->caption() ?></span>
		</label>
		<div class="<?php echo $employees_search->RightColumnClass ?>"><div <?php echo $employees_search->idEmployee->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_idEmployee" id="z_idEmployee" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $employees_search->idEmployee->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $employees_search->idEmployee->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $employees_search->idEmployee->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $employees_search->idEmployee->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $employees_search->idEmployee->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $employees_search->idEmployee->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $employees_search->idEmployee->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $employees_search->idEmployee->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $employees_search->idEmployee->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $employees_search->idEmployee->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="BETWEEN"<?php echo $employees_search->idEmployee->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_employees_idEmployee" class="ew-search-field">
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<?php if (strval($employees_search->idEmployee->AdvancedSearch->SearchValue) == "") $employees_search->idEmployee->AdvancedSearch->SearchValue = CurrentUserID() ?>
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="employees" data-field="x_idEmployee" data-value-separator="<?php echo $employees_search->idEmployee->displayValueSeparatorAttribute() ?>" id="x_idEmployee" name="x_idEmployee"<?php echo $employees_search->idEmployee->editAttributes() ?>>
			<?php echo $employees_search->idEmployee->selectOptionListHtml("x_idEmployee") ?>
		</select>
</div>
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$employees->userIDAllow("search")) { // Non system admin ?>
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="employees" data-field="x_idEmployee" data-value-separator="<?php echo $employees_search->idEmployee->displayValueSeparatorAttribute() ?>" id="x_idEmployee" name="x_idEmployee"<?php echo $employees_search->idEmployee->editAttributes() ?>>
			<?php echo $employees_search->idEmployee->selectOptionListHtml("x_idEmployee") ?>
		</select>
</div>
<?php } else { ?>
<input type="text" data-table="employees" data-field="x_idEmployee" name="x_idEmployee" id="x_idEmployee" size="30" maxlength="30" placeholder="<?php echo HtmlEncode($employees_search->idEmployee->getPlaceHolder()) ?>" value="<?php echo $employees_search->idEmployee->EditValue ?>"<?php echo $employees_search->idEmployee->editAttributes() ?>>
<?php } ?>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_employees_idEmployee" class="ew-search-field2 d-none">
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<?php if (strval($employees_search->idEmployee->AdvancedSearch->SearchValue2) == "") $employees_search->idEmployee->AdvancedSearch->SearchValue2 = CurrentUserID() ?>
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="employees" data-field="x_idEmployee" data-value-separator="<?php echo $employees_search->idEmployee->displayValueSeparatorAttribute() ?>" id="y_idEmployee" name="y_idEmployee"<?php echo $employees_search->idEmployee->editAttributes() ?>>
			<?php echo $employees_search->idEmployee->selectOptionListHtml("y_idEmployee") ?>
		</select>
</div>
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$employees->userIDAllow("search")) { // Non system admin ?>
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="employees" data-field="x_idEmployee" data-value-separator="<?php echo $employees_search->idEmployee->displayValueSeparatorAttribute() ?>" id="y_idEmployee" name="y_idEmployee"<?php echo $employees_search->idEmployee->editAttributes() ?>>
			<?php echo $employees_search->idEmployee->selectOptionListHtml("y_idEmployee") ?>
		</select>
</div>
<?php } else { ?>
<input type="text" data-table="employees" data-field="x_idEmployee" name="y_idEmployee" id="y_idEmployee" size="30" maxlength="30" placeholder="<?php echo HtmlEncode($employees_search->idEmployee->getPlaceHolder()) ?>" value="<?php echo $employees_search->idEmployee->EditValue2 ?>"<?php echo $employees_search->idEmployee->editAttributes() ?>>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($employees_search->name->Visible) { // name ?>
	<div id="r_name" class="form-group row">
		<label for="x_name" class="<?php echo $employees_search->LeftColumnClass ?>"><span id="elh_employees_name"><?php echo $employees_search->name->caption() ?></span>
		</label>
		<div class="<?php echo $employees_search->RightColumnClass ?>"><div <?php echo $employees_search->name->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_name" id="z_name" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $employees_search->name->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $employees_search->name->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $employees_search->name->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $employees_search->name->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $employees_search->name->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $employees_search->name->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $employees_search->name->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $employees_search->name->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $employees_search->name->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $employees_search->name->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="BETWEEN"<?php echo $employees_search->name->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_employees_name" class="ew-search-field">
<input type="text" data-table="employees" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($employees_search->name->getPlaceHolder()) ?>" value="<?php echo $employees_search->name->EditValue ?>"<?php echo $employees_search->name->editAttributes() ?>>
</span>
			<span class="ew-search-cond">
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_name_1" name="v_name" value="AND"<?php if ($employees_search->name->AdvancedSearch->SearchCondition != "OR") echo " checked" ?>><label class="custom-control-label" for="v_name_1"><?php echo $Language->phrase("AND") ?></label></div>
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_name_2" name="v_name" value="OR"<?php if ($employees_search->name->AdvancedSearch->SearchCondition == "OR") echo " checked" ?>><label class="custom-control-label" for="v_name_2"><?php echo $Language->phrase("OR") ?></label></div></span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span class="ew-search-operator2">
<select name="w_name" id="w_name" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $employees_search->name->AdvancedSearch->SearchOperator2 == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $employees_search->name->AdvancedSearch->SearchOperator2 == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $employees_search->name->AdvancedSearch->SearchOperator2 == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $employees_search->name->AdvancedSearch->SearchOperator2 == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $employees_search->name->AdvancedSearch->SearchOperator2 == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $employees_search->name->AdvancedSearch->SearchOperator2 == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $employees_search->name->AdvancedSearch->SearchOperator2 == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $employees_search->name->AdvancedSearch->SearchOperator2 == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $employees_search->name->AdvancedSearch->SearchOperator2 == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $employees_search->name->AdvancedSearch->SearchOperator2 == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
</select>
</span>
			<span id="el2_employees_name" class="ew-search-field2">
<input type="text" data-table="employees" data-field="x_name" name="y_name" id="y_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($employees_search->name->getPlaceHolder()) ?>" value="<?php echo $employees_search->name->EditValue2 ?>"<?php echo $employees_search->name->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($employees_search->surname->Visible) { // surname ?>
	<div id="r_surname" class="form-group row">
		<label for="x_surname" class="<?php echo $employees_search->LeftColumnClass ?>"><span id="elh_employees_surname"><?php echo $employees_search->surname->caption() ?></span>
		</label>
		<div class="<?php echo $employees_search->RightColumnClass ?>"><div <?php echo $employees_search->surname->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_surname" id="z_surname" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $employees_search->surname->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $employees_search->surname->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $employees_search->surname->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $employees_search->surname->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $employees_search->surname->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $employees_search->surname->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $employees_search->surname->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $employees_search->surname->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $employees_search->surname->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $employees_search->surname->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="BETWEEN"<?php echo $employees_search->surname->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_employees_surname" class="ew-search-field">
<input type="text" data-table="employees" data-field="x_surname" name="x_surname" id="x_surname" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($employees_search->surname->getPlaceHolder()) ?>" value="<?php echo $employees_search->surname->EditValue ?>"<?php echo $employees_search->surname->editAttributes() ?>>
</span>
			<span class="ew-search-cond">
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_surname_1" name="v_surname" value="AND"<?php if ($employees_search->surname->AdvancedSearch->SearchCondition != "OR") echo " checked" ?>><label class="custom-control-label" for="v_surname_1"><?php echo $Language->phrase("AND") ?></label></div>
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_surname_2" name="v_surname" value="OR"<?php if ($employees_search->surname->AdvancedSearch->SearchCondition == "OR") echo " checked" ?>><label class="custom-control-label" for="v_surname_2"><?php echo $Language->phrase("OR") ?></label></div></span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span class="ew-search-operator2">
<select name="w_surname" id="w_surname" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $employees_search->surname->AdvancedSearch->SearchOperator2 == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $employees_search->surname->AdvancedSearch->SearchOperator2 == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $employees_search->surname->AdvancedSearch->SearchOperator2 == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $employees_search->surname->AdvancedSearch->SearchOperator2 == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $employees_search->surname->AdvancedSearch->SearchOperator2 == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $employees_search->surname->AdvancedSearch->SearchOperator2 == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $employees_search->surname->AdvancedSearch->SearchOperator2 == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $employees_search->surname->AdvancedSearch->SearchOperator2 == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $employees_search->surname->AdvancedSearch->SearchOperator2 == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $employees_search->surname->AdvancedSearch->SearchOperator2 == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
</select>
</span>
			<span id="el2_employees_surname" class="ew-search-field2">
<input type="text" data-table="employees" data-field="x_surname" name="y_surname" id="y_surname" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($employees_search->surname->getPlaceHolder()) ?>" value="<?php echo $employees_search->surname->EditValue2 ?>"<?php echo $employees_search->surname->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($employees_search->idFactory->Visible) { // idFactory ?>
	<div id="r_idFactory" class="form-group row">
		<label class="<?php echo $employees_search->LeftColumnClass ?>"><span id="elh_employees_idFactory"><?php echo $employees_search->idFactory->caption() ?></span>
		</label>
		<div class="<?php echo $employees_search->RightColumnClass ?>"><div <?php echo $employees_search->idFactory->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_idFactory" id="z_idFactory" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_employees_idFactory" class="ew-search-field">
<?php
$onchange = $employees_search->idFactory->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$employees_search->idFactory->EditAttrs["onchange"] = "";
?>
<span id="as_x_idFactory">
	<input type="text" class="form-control" name="sv_x_idFactory" id="sv_x_idFactory" value="<?php echo RemoveHtml($employees_search->idFactory->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($employees_search->idFactory->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($employees_search->idFactory->getPlaceHolder()) ?>"<?php echo $employees_search->idFactory->editAttributes() ?>>
</span>
<input type="hidden" data-table="employees" data-field="x_idFactory" data-value-separator="<?php echo $employees_search->idFactory->displayValueSeparatorAttribute() ?>" name="x_idFactory" id="x_idFactory" value="<?php echo HtmlEncode($employees_search->idFactory->AdvancedSearch->SearchValue) ?>"<?php echo $onchange ?>>
<script>
loadjs.ready(["femployeessearch"], function() {
	femployeessearch.createAutoSuggest({"id":"x_idFactory","forceSelect":false});
});
</script>
<?php echo $employees_search->idFactory->Lookup->getParamTag($employees_search, "p_x_idFactory") ?>
</span>
			<span class="ew-search-cond">
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_idFactory_1" name="v_idFactory" value="AND"<?php if ($employees_search->idFactory->AdvancedSearch->SearchCondition != "OR") echo " checked" ?>><label class="custom-control-label" for="v_idFactory_1"><?php echo $Language->phrase("AND") ?></label></div>
<div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" type="radio" id="v_idFactory_2" name="v_idFactory" value="OR"<?php if ($employees_search->idFactory->AdvancedSearch->SearchCondition == "OR") echo " checked" ?>><label class="custom-control-label" for="v_idFactory_2"><?php echo $Language->phrase("OR") ?></label></div></span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span class="ew-search-operator2">
<select name="w_idFactory" id="w_idFactory" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator2 == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator2 == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator2 == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator2 == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator2 == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator2 == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator2 == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator2 == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator2 == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator2 == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator2 == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $employees_search->idFactory->AdvancedSearch->SearchOperator2 == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
</select>
</span>
			<span id="el2_employees_idFactory" class="ew-search-field2">
<?php
$onchange = $employees_search->idFactory->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$employees_search->idFactory->EditAttrs["onchange"] = "";
?>
<span id="as_y_idFactory">
	<input type="text" class="form-control" name="sv_y_idFactory" id="sv_y_idFactory" value="<?php echo RemoveHtml($employees_search->idFactory->EditValue2) ?>" size="30" placeholder="<?php echo HtmlEncode($employees_search->idFactory->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($employees_search->idFactory->getPlaceHolder()) ?>"<?php echo $employees_search->idFactory->editAttributes() ?>>
</span>
<input type="hidden" data-table="employees" data-field="x_idFactory" data-value-separator="<?php echo $employees_search->idFactory->displayValueSeparatorAttribute() ?>" name="y_idFactory" id="y_idFactory" value="<?php echo HtmlEncode($employees_search->idFactory->AdvancedSearch->SearchValue2) ?>"<?php echo $onchange ?>>
<script>
loadjs.ready(["femployeessearch"], function() {
	femployeessearch.createAutoSuggest({"id":"y_idFactory","forceSelect":false});
});
</script>
<?php echo $employees_search->idFactory->Lookup->getParamTag($employees_search, "p_y_idFactory") ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($employees_search->userlevel->Visible) { // userlevel ?>
	<div id="r_userlevel" class="form-group row">
		<label for="x_userlevel" class="<?php echo $employees_search->LeftColumnClass ?>"><span id="elh_employees_userlevel"><?php echo $employees_search->userlevel->caption() ?></span>
		</label>
		<div class="<?php echo $employees_search->RightColumnClass ?>"><div <?php echo $employees_search->userlevel->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_userlevel" id="z_userlevel" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $employees_search->userlevel->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $employees_search->userlevel->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $employees_search->userlevel->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $employees_search->userlevel->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $employees_search->userlevel->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $employees_search->userlevel->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $employees_search->userlevel->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $employees_search->userlevel->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $employees_search->userlevel->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_employees_userlevel" class="ew-search-field">
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($employees_search->userlevel->EditValue)) ?>">
<?php } else { ?>
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="employees" data-field="x_userlevel" data-value-separator="<?php echo $employees_search->userlevel->displayValueSeparatorAttribute() ?>" id="x_userlevel" name="x_userlevel"<?php echo $employees_search->userlevel->editAttributes() ?>>
			<?php echo $employees_search->userlevel->selectOptionListHtml("x_userlevel") ?>
		</select>
</div>
<?php } ?>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_employees_userlevel" class="ew-search-field2 d-none">
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($employees_search->userlevel->EditValue2)) ?>">
<?php } else { ?>
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="employees" data-field="x_userlevel" data-value-separator="<?php echo $employees_search->userlevel->displayValueSeparatorAttribute() ?>" id="y_userlevel" name="y_userlevel"<?php echo $employees_search->userlevel->editAttributes() ?>>
			<?php echo $employees_search->userlevel->selectOptionListHtml("y_userlevel") ?>
		</select>
</div>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($employees_search->password->Visible) { // password ?>
	<div id="r_password" class="form-group row">
		<label for="x_password" class="<?php echo $employees_search->LeftColumnClass ?>"><span id="elh_employees_password"><?php echo $employees_search->password->caption() ?></span>
		</label>
		<div class="<?php echo $employees_search->RightColumnClass ?>"><div <?php echo $employees_search->password->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_password" id="z_password" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $employees_search->password->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $employees_search->password->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $employees_search->password->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $employees_search->password->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $employees_search->password->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $employees_search->password->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $employees_search->password->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $employees_search->password->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $employees_search->password->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $employees_search->password->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $employees_search->password->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $employees_search->password->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $employees_search->password->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_employees_password" class="ew-search-field">
<input type="text" data-table="employees" data-field="x_password" name="x_password" id="x_password" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($employees_search->password->getPlaceHolder()) ?>" value="<?php echo $employees_search->password->EditValue ?>"<?php echo $employees_search->password->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_employees_password" class="ew-search-field2 d-none">
<input type="text" data-table="employees" data-field="x_password" name="y_password" id="y_password" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($employees_search->password->getPlaceHolder()) ?>" value="<?php echo $employees_search->password->EditValue2 ?>"<?php echo $employees_search->password->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($employees_search->workcenter->Visible) { // workcenter ?>
	<div id="r_workcenter" class="form-group row">
		<label class="<?php echo $employees_search->LeftColumnClass ?>"><span id="elh_employees_workcenter"><?php echo $employees_search->workcenter->caption() ?></span>
		</label>
		<div class="<?php echo $employees_search->RightColumnClass ?>"><div <?php echo $employees_search->workcenter->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_workcenter" id="z_workcenter" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $employees_search->workcenter->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $employees_search->workcenter->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $employees_search->workcenter->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $employees_search->workcenter->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $employees_search->workcenter->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $employees_search->workcenter->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $employees_search->workcenter->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $employees_search->workcenter->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $employees_search->workcenter->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $employees_search->workcenter->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $employees_search->workcenter->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $employees_search->workcenter->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $employees_search->workcenter->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_employees_workcenter" class="ew-search-field">
<?php
$onchange = $employees_search->workcenter->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$employees_search->workcenter->EditAttrs["onchange"] = "";
?>
<span id="as_x_workcenter">
	<input type="text" class="form-control" name="sv_x_workcenter" id="sv_x_workcenter" value="<?php echo RemoveHtml($employees_search->workcenter->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($employees_search->workcenter->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($employees_search->workcenter->getPlaceHolder()) ?>"<?php echo $employees_search->workcenter->editAttributes() ?>>
</span>
<input type="hidden" data-table="employees" data-field="x_workcenter" data-value-separator="<?php echo $employees_search->workcenter->displayValueSeparatorAttribute() ?>" name="x_workcenter" id="x_workcenter" value="<?php echo HtmlEncode($employees_search->workcenter->AdvancedSearch->SearchValue) ?>"<?php echo $onchange ?>>
<script>
loadjs.ready(["femployeessearch"], function() {
	femployeessearch.createAutoSuggest({"id":"x_workcenter","forceSelect":false});
});
</script>
<?php echo $employees_search->workcenter->Lookup->getParamTag($employees_search, "p_x_workcenter") ?>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_employees_workcenter" class="ew-search-field2 d-none">
<?php
$onchange = $employees_search->workcenter->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$employees_search->workcenter->EditAttrs["onchange"] = "";
?>
<span id="as_y_workcenter">
	<input type="text" class="form-control" name="sv_y_workcenter" id="sv_y_workcenter" value="<?php echo RemoveHtml($employees_search->workcenter->EditValue2) ?>" size="30" placeholder="<?php echo HtmlEncode($employees_search->workcenter->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($employees_search->workcenter->getPlaceHolder()) ?>"<?php echo $employees_search->workcenter->editAttributes() ?>>
</span>
<input type="hidden" data-table="employees" data-field="x_workcenter" data-value-separator="<?php echo $employees_search->workcenter->displayValueSeparatorAttribute() ?>" name="y_workcenter" id="y_workcenter" value="<?php echo HtmlEncode($employees_search->workcenter->AdvancedSearch->SearchValue2) ?>"<?php echo $onchange ?>>
<script>
loadjs.ready(["femployeessearch"], function() {
	femployeessearch.createAutoSuggest({"id":"y_workcenter","forceSelect":false});
});
</script>
<?php echo $employees_search->workcenter->Lookup->getParamTag($employees_search, "p_y_workcenter") ?>
</span>
		</div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$employees_search->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $employees_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("Search") ?></button>
<button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" onclick="ew.clearForm(this.form);"><?php echo $Language->phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$employees_search->showPageFooter();
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
$employees_search->terminate();
?>