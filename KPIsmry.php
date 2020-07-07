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
$KPI_summary = new KPI_summary();

// Run the page
$KPI_summary->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$KPI_summary->Page_Render();
?>
<?php if (!$DashboardReport) { ?>
<?php include_once "header.php"; ?>
<?php } ?>
<?php if (!$KPI_summary->isExport() && !$KPI_summary->DrillDown && !$DashboardReport) { ?>
<script>
var fsummary, currentPageID;
loadjs.ready("head", function() {

	// Form object for search
	fsummary = currentForm = new ew.Form("fsummary", "summary");
	currentPageID = ew.PAGE_ID = "summary";

	// Validate function for search
	fsummary.validate = function(fobj) {
		if (!this.validateRequired)
			return true; // Ignore validation
		fobj = fobj || this._form;
		var infix = "";
		elm = this.getElements("x" + infix + "_dateFmea");
		if (elm && !ew.checkDateDef(elm.value))
			return this.onError(elm, "<?php echo JsEncode($KPI_summary->dateFmea->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_severity");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($KPI_summary->severity->errorMessage()) ?>");

		// Call Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
		return true;
	}

	// Form_CustomValidate
	fsummary.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fsummary.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fsummary.lists["x_fmea"] = <?php echo $KPI_summary->fmea->Lookup->toClientList($KPI_summary) ?>;
	fsummary.lists["x_fmea"].options = <?php echo JsonEncode($KPI_summary->fmea->lookupOptions()) ?>;
	fsummary.lists["x_idFactory"] = <?php echo $KPI_summary->idFactory->Lookup->toClientList($KPI_summary) ?>;
	fsummary.lists["x_idFactory"].options = <?php echo JsonEncode($KPI_summary->idFactory->lookupOptions()) ?>;
	fsummary.lists["x_idworkcenter"] = <?php echo $KPI_summary->idworkcenter->Lookup->toClientList($KPI_summary) ?>;
	fsummary.lists["x_idworkcenter"].options = <?php echo JsonEncode($KPI_summary->idworkcenter->lookupOptions()) ?>;

	// Filters
	fsummary.filterList = <?php echo $KPI_summary->getFilterList() ?>;
	loadjs.done("fsummary");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<a id="top"></a>
<?php if ((!$KPI_summary->isExport() || $KPI_summary->isExport("print")) && !$DashboardReport) { ?>
<!-- Content Container -->
<div id="ew-report" class="ew-report container-fluid">
<?php } ?>
<?php if ($KPI_summary->ShowCurrentFilter) { ?>
<?php $KPI_summary->showFilterList() ?>
<?php } ?>
<div class="btn-toolbar ew-toolbar">
<?php
if (!$KPI_summary->DrillDownInPanel) {
	$KPI_summary->ExportOptions->render("body");
	$KPI_summary->SearchOptions->render("body");
	$KPI_summary->FilterOptions->render("body");
}
?>
</div>
<?php $KPI_summary->showPageHeader(); ?>
<?php
$KPI_summary->showMessage();
?>
<?php if ((!$KPI_summary->isExport() || $KPI_summary->isExport("print")) && !$DashboardReport) { ?>
<div class="row">
<?php } ?>
<?php if ((!$KPI_summary->isExport() || $KPI_summary->isExport("print")) && !$DashboardReport) { ?>
<!-- Center Container -->
<div id="ew-center" class="<?php echo $KPI_summary->CenterContentClass ?>">
<?php } ?>
<!-- Summary report (begin) -->
<div id="report_summary">
<?php if (!$KPI_summary->isExport() && !$KPI_summary->DrillDown && !$DashboardReport) { ?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$KPI_summary->isExport() && !$KPI->CurrentAction) { ?>
<form name="fsummary" id="fsummary" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="fsummary-search-panel" class="<?php echo $KPI_summary->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="KPI">
	<div class="ew-extended-search">
<?php

// Render search row
$KPI->RowType = ROWTYPE_SEARCH;
$KPI->resetAttributes();
$KPI_summary->renderRow();
?>
<?php if ($KPI_summary->fmea->Visible) { // fmea ?>
	<?php
		$KPI_summary->SearchColumnCount++;
		if (($KPI_summary->SearchColumnCount - 1) % $KPI_summary->SearchFieldsPerRow == 0) {
			$KPI_summary->SearchRowCount++;
	?>
<div id="xsr_<?php echo $KPI_summary->SearchRowCount ?>" class="ew-row d-sm-flex">
	<?php
		}
	 ?>
	<div id="xsc_fmea" class="ew-cell form-group">
		<label for="x_fmea" class="ew-search-caption ew-label"><?php echo $KPI_summary->fmea->caption() ?></label>
		<span id="el_KPI_fmea" class="ew-search-field">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="KPI" data-field="x_fmea" data-value-separator="<?php echo $KPI_summary->fmea->displayValueSeparatorAttribute() ?>" id="x_fmea" name="x_fmea"<?php echo $KPI_summary->fmea->editAttributes() ?>>
			<?php echo $KPI_summary->fmea->selectOptionListHtml("x_fmea") ?>
		</select>
</div>
<?php echo $KPI_summary->fmea->Lookup->getParamTag($KPI_summary, "p_x_fmea") ?>
</span>
	</div>
	<?php if ($KPI_summary->SearchColumnCount % $KPI_summary->SearchFieldsPerRow == 0) { ?>
</div>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->idFactory->Visible) { // idFactory ?>
	<?php
		$KPI_summary->SearchColumnCount++;
		if (($KPI_summary->SearchColumnCount - 1) % $KPI_summary->SearchFieldsPerRow == 0) {
			$KPI_summary->SearchRowCount++;
	?>
<div id="xsr_<?php echo $KPI_summary->SearchRowCount ?>" class="ew-row d-sm-flex">
	<?php
		}
	 ?>
	<div id="xsc_idFactory" class="ew-cell form-group">
		<label for="x_idFactory" class="ew-search-caption ew-label"><?php echo $KPI_summary->idFactory->caption() ?></label>
		<span id="el_KPI_idFactory" class="ew-search-field">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="KPI" data-field="x_idFactory" data-value-separator="<?php echo $KPI_summary->idFactory->displayValueSeparatorAttribute() ?>" id="x_idFactory" name="x_idFactory"<?php echo $KPI_summary->idFactory->editAttributes() ?>>
			<?php echo $KPI_summary->idFactory->selectOptionListHtml("x_idFactory") ?>
		</select>
</div>
<?php echo $KPI_summary->idFactory->Lookup->getParamTag($KPI_summary, "p_x_idFactory") ?>
</span>
	</div>
	<?php if ($KPI_summary->SearchColumnCount % $KPI_summary->SearchFieldsPerRow == 0) { ?>
</div>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->dateFmea->Visible) { // dateFmea ?>
	<?php
		$KPI_summary->SearchColumnCount++;
		if (($KPI_summary->SearchColumnCount - 1) % $KPI_summary->SearchFieldsPerRow == 0) {
			$KPI_summary->SearchRowCount++;
	?>
<div id="xsr_<?php echo $KPI_summary->SearchRowCount ?>" class="ew-row d-sm-flex">
	<?php
		}
	 ?>
	<div id="xsc_dateFmea" class="ew-cell form-group">
		<label for="x_dateFmea" class="ew-search-caption ew-label"><?php echo $KPI_summary->dateFmea->caption() ?></label>
		<span class="ew-search-operator">
<select name="z_dateFmea" id="z_dateFmea" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $KPI_summary->dateFmea->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $KPI_summary->dateFmea->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $KPI_summary->dateFmea->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $KPI_summary->dateFmea->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $KPI_summary->dateFmea->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $KPI_summary->dateFmea->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $KPI_summary->dateFmea->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $KPI_summary->dateFmea->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $KPI_summary->dateFmea->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
		<span id="el_KPI_dateFmea" class="ew-search-field">
<input type="text" data-table="KPI" data-field="x_dateFmea" name="x_dateFmea" id="x_dateFmea" maxlength="19" placeholder="<?php echo HtmlEncode($KPI_summary->dateFmea->getPlaceHolder()) ?>" value="<?php echo $KPI_summary->dateFmea->EditValue ?>"<?php echo $KPI_summary->dateFmea->editAttributes() ?>>
<?php if (!$KPI_summary->dateFmea->ReadOnly && !$KPI_summary->dateFmea->Disabled && !isset($KPI_summary->dateFmea->EditAttrs["readonly"]) && !isset($KPI_summary->dateFmea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsummary", "datetimepicker"], function() {
	ew.createDateTimePicker("fsummary", "x_dateFmea", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
		<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
		<span id="el2_KPI_dateFmea" class="ew-search-field2 d-none">
<input type="text" data-table="KPI" data-field="x_dateFmea" name="y_dateFmea" id="y_dateFmea" maxlength="19" placeholder="<?php echo HtmlEncode($KPI_summary->dateFmea->getPlaceHolder()) ?>" value="<?php echo $KPI_summary->dateFmea->EditValue2 ?>"<?php echo $KPI_summary->dateFmea->editAttributes() ?>>
<?php if (!$KPI_summary->dateFmea->ReadOnly && !$KPI_summary->dateFmea->Disabled && !isset($KPI_summary->dateFmea->EditAttrs["readonly"]) && !isset($KPI_summary->dateFmea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsummary", "datetimepicker"], function() {
	ew.createDateTimePicker("fsummary", "y_dateFmea", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
	</div>
	<?php if ($KPI_summary->SearchColumnCount % $KPI_summary->SearchFieldsPerRow == 0) { ?>
</div>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->idworkcenter->Visible) { // idworkcenter ?>
	<?php
		$KPI_summary->SearchColumnCount++;
		if (($KPI_summary->SearchColumnCount - 1) % $KPI_summary->SearchFieldsPerRow == 0) {
			$KPI_summary->SearchRowCount++;
	?>
<div id="xsr_<?php echo $KPI_summary->SearchRowCount ?>" class="ew-row d-sm-flex">
	<?php
		}
	 ?>
	<div id="xsc_idworkcenter" class="ew-cell form-group">
		<label for="x_idworkcenter" class="ew-search-caption ew-label"><?php echo $KPI_summary->idworkcenter->caption() ?></label>
		<span id="el_KPI_idworkcenter" class="ew-search-field">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="KPI" data-field="x_idworkcenter" data-value-separator="<?php echo $KPI_summary->idworkcenter->displayValueSeparatorAttribute() ?>" id="x_idworkcenter" name="x_idworkcenter"<?php echo $KPI_summary->idworkcenter->editAttributes() ?>>
			<?php echo $KPI_summary->idworkcenter->selectOptionListHtml("x_idworkcenter") ?>
		</select>
</div>
<?php echo $KPI_summary->idworkcenter->Lookup->getParamTag($KPI_summary, "p_x_idworkcenter") ?>
</span>
	</div>
	<?php if ($KPI_summary->SearchColumnCount % $KPI_summary->SearchFieldsPerRow == 0) { ?>
</div>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->flowchartDesc->Visible) { // flowchartDesc ?>
	<?php
		$KPI_summary->SearchColumnCount++;
		if (($KPI_summary->SearchColumnCount - 1) % $KPI_summary->SearchFieldsPerRow == 0) {
			$KPI_summary->SearchRowCount++;
	?>
<div id="xsr_<?php echo $KPI_summary->SearchRowCount ?>" class="ew-row d-sm-flex">
	<?php
		}
	 ?>
	<div id="xsc_flowchartDesc" class="ew-cell form-group">
		<label for="x_flowchartDesc" class="ew-search-caption ew-label"><?php echo $KPI_summary->flowchartDesc->caption() ?></label>
		<span class="ew-search-operator">
<select name="z_flowchartDesc" id="z_flowchartDesc" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $KPI_summary->flowchartDesc->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $KPI_summary->flowchartDesc->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $KPI_summary->flowchartDesc->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $KPI_summary->flowchartDesc->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $KPI_summary->flowchartDesc->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $KPI_summary->flowchartDesc->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $KPI_summary->flowchartDesc->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $KPI_summary->flowchartDesc->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $KPI_summary->flowchartDesc->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $KPI_summary->flowchartDesc->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $KPI_summary->flowchartDesc->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $KPI_summary->flowchartDesc->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $KPI_summary->flowchartDesc->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
		<span id="el_KPI_flowchartDesc" class="ew-search-field">
<input type="text" data-table="KPI" data-field="x_flowchartDesc" name="x_flowchartDesc" id="x_flowchartDesc" size="35" placeholder="<?php echo HtmlEncode($KPI_summary->flowchartDesc->getPlaceHolder()) ?>" value="<?php echo $KPI_summary->flowchartDesc->EditValue ?>"<?php echo $KPI_summary->flowchartDesc->editAttributes() ?>>
</span>
		<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
		<span id="el2_KPI_flowchartDesc" class="ew-search-field2 d-none">
<input type="text" data-table="KPI" data-field="x_flowchartDesc" name="y_flowchartDesc" id="y_flowchartDesc" size="35" placeholder="<?php echo HtmlEncode($KPI_summary->flowchartDesc->getPlaceHolder()) ?>" value="<?php echo $KPI_summary->flowchartDesc->EditValue2 ?>"<?php echo $KPI_summary->flowchartDesc->editAttributes() ?>>
</span>
	</div>
	<?php if ($KPI_summary->SearchColumnCount % $KPI_summary->SearchFieldsPerRow == 0) { ?>
</div>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->partnumber->Visible) { // partnumber ?>
	<?php
		$KPI_summary->SearchColumnCount++;
		if (($KPI_summary->SearchColumnCount - 1) % $KPI_summary->SearchFieldsPerRow == 0) {
			$KPI_summary->SearchRowCount++;
	?>
<div id="xsr_<?php echo $KPI_summary->SearchRowCount ?>" class="ew-row d-sm-flex">
	<?php
		}
	 ?>
	<div id="xsc_partnumber" class="ew-cell form-group">
		<label for="x_partnumber" class="ew-search-caption ew-label"><?php echo $KPI_summary->partnumber->caption() ?></label>
		<span class="ew-search-operator">
<select name="z_partnumber" id="z_partnumber" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $KPI_summary->partnumber->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $KPI_summary->partnumber->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $KPI_summary->partnumber->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $KPI_summary->partnumber->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $KPI_summary->partnumber->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $KPI_summary->partnumber->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $KPI_summary->partnumber->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $KPI_summary->partnumber->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $KPI_summary->partnumber->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $KPI_summary->partnumber->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $KPI_summary->partnumber->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $KPI_summary->partnumber->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $KPI_summary->partnumber->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
		<span id="el_KPI_partnumber" class="ew-search-field">
<input type="text" data-table="KPI" data-field="x_partnumber" name="x_partnumber" id="x_partnumber" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($KPI_summary->partnumber->getPlaceHolder()) ?>" value="<?php echo $KPI_summary->partnumber->EditValue ?>"<?php echo $KPI_summary->partnumber->editAttributes() ?>>
</span>
		<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
		<span id="el2_KPI_partnumber" class="ew-search-field2 d-none">
<input type="text" data-table="KPI" data-field="x_partnumber" name="y_partnumber" id="y_partnumber" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($KPI_summary->partnumber->getPlaceHolder()) ?>" value="<?php echo $KPI_summary->partnumber->EditValue2 ?>"<?php echo $KPI_summary->partnumber->editAttributes() ?>>
</span>
	</div>
	<?php if ($KPI_summary->SearchColumnCount % $KPI_summary->SearchFieldsPerRow == 0) { ?>
</div>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->operation->Visible) { // operation ?>
	<?php
		$KPI_summary->SearchColumnCount++;
		if (($KPI_summary->SearchColumnCount - 1) % $KPI_summary->SearchFieldsPerRow == 0) {
			$KPI_summary->SearchRowCount++;
	?>
<div id="xsr_<?php echo $KPI_summary->SearchRowCount ?>" class="ew-row d-sm-flex">
	<?php
		}
	 ?>
	<div id="xsc_operation" class="ew-cell form-group">
		<label for="x_operation" class="ew-search-caption ew-label"><?php echo $KPI_summary->operation->caption() ?></label>
		<span class="ew-search-operator">
<select name="z_operation" id="z_operation" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $KPI_summary->operation->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $KPI_summary->operation->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $KPI_summary->operation->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $KPI_summary->operation->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $KPI_summary->operation->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $KPI_summary->operation->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $KPI_summary->operation->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $KPI_summary->operation->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $KPI_summary->operation->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $KPI_summary->operation->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $KPI_summary->operation->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $KPI_summary->operation->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $KPI_summary->operation->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
		<span id="el_KPI_operation" class="ew-search-field">
<input type="text" data-table="KPI" data-field="x_operation" name="x_operation" id="x_operation" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($KPI_summary->operation->getPlaceHolder()) ?>" value="<?php echo $KPI_summary->operation->EditValue ?>"<?php echo $KPI_summary->operation->editAttributes() ?>>
</span>
		<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
		<span id="el2_KPI_operation" class="ew-search-field2 d-none">
<input type="text" data-table="KPI" data-field="x_operation" name="y_operation" id="y_operation" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($KPI_summary->operation->getPlaceHolder()) ?>" value="<?php echo $KPI_summary->operation->EditValue2 ?>"<?php echo $KPI_summary->operation->editAttributes() ?>>
</span>
	</div>
	<?php if ($KPI_summary->SearchColumnCount % $KPI_summary->SearchFieldsPerRow == 0) { ?>
</div>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->severity->Visible) { // severity ?>
	<?php
		$KPI_summary->SearchColumnCount++;
		if (($KPI_summary->SearchColumnCount - 1) % $KPI_summary->SearchFieldsPerRow == 0) {
			$KPI_summary->SearchRowCount++;
	?>
<div id="xsr_<?php echo $KPI_summary->SearchRowCount ?>" class="ew-row d-sm-flex">
	<?php
		}
	 ?>
	<div id="xsc_severity" class="ew-cell form-group">
		<label for="x_severity" class="ew-search-caption ew-label"><?php echo $KPI_summary->severity->caption() ?></label>
		<span class="ew-search-operator">
<select name="z_severity" id="z_severity" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $KPI_summary->severity->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $KPI_summary->severity->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $KPI_summary->severity->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $KPI_summary->severity->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $KPI_summary->severity->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $KPI_summary->severity->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $KPI_summary->severity->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $KPI_summary->severity->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $KPI_summary->severity->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
		<span id="el_KPI_severity" class="ew-search-field">
<input type="text" data-table="KPI" data-field="x_severity" name="x_severity" id="x_severity" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($KPI_summary->severity->getPlaceHolder()) ?>" value="<?php echo $KPI_summary->severity->EditValue ?>"<?php echo $KPI_summary->severity->editAttributes() ?>>
</span>
		<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
		<span id="el2_KPI_severity" class="ew-search-field2 d-none">
<input type="text" data-table="KPI" data-field="x_severity" name="y_severity" id="y_severity" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($KPI_summary->severity->getPlaceHolder()) ?>" value="<?php echo $KPI_summary->severity->EditValue2 ?>"<?php echo $KPI_summary->severity->editAttributes() ?>>
</span>
	</div>
	<?php if ($KPI_summary->SearchColumnCount % $KPI_summary->SearchFieldsPerRow == 0) { ?>
</div>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->idCause->Visible) { // idCause ?>
	<?php
		$KPI_summary->SearchColumnCount++;
		if (($KPI_summary->SearchColumnCount - 1) % $KPI_summary->SearchFieldsPerRow == 0) {
			$KPI_summary->SearchRowCount++;
	?>
<div id="xsr_<?php echo $KPI_summary->SearchRowCount ?>" class="ew-row d-sm-flex">
	<?php
		}
	 ?>
	<div id="xsc_idCause" class="ew-cell form-group">
		<label for="x_idCause" class="ew-search-caption ew-label"><?php echo $KPI_summary->idCause->caption() ?></label>
		<span class="ew-search-operator">
<select name="z_idCause" id="z_idCause" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $KPI_summary->idCause->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $KPI_summary->idCause->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $KPI_summary->idCause->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $KPI_summary->idCause->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $KPI_summary->idCause->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $KPI_summary->idCause->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $KPI_summary->idCause->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $KPI_summary->idCause->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $KPI_summary->idCause->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $KPI_summary->idCause->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="BETWEEN"<?php echo $KPI_summary->idCause->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
		<span id="el_KPI_idCause" class="ew-search-field">
<input type="text" data-table="KPI" data-field="x_idCause" name="x_idCause" id="x_idCause" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($KPI_summary->idCause->getPlaceHolder()) ?>" value="<?php echo $KPI_summary->idCause->EditValue ?>"<?php echo $KPI_summary->idCause->editAttributes() ?>>
</span>
		<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
		<span id="el2_KPI_idCause" class="ew-search-field2 d-none">
<input type="text" data-table="KPI" data-field="x_idCause" name="y_idCause" id="y_idCause" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($KPI_summary->idCause->getPlaceHolder()) ?>" value="<?php echo $KPI_summary->idCause->EditValue2 ?>"<?php echo $KPI_summary->idCause->editAttributes() ?>>
</span>
	</div>
	<?php if ($KPI_summary->SearchColumnCount % $KPI_summary->SearchFieldsPerRow == 0) { ?>
</div>
	<?php } ?>
<?php } ?>
	<?php if ($KPI_summary->SearchColumnCount % $KPI_summary->SearchFieldsPerRow > 0) { ?>
</div>
	<?php } ?>
<div id="xsr_<?php echo $KPI_summary->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php } ?>
<?php
while ($KPI_summary->GroupCount <= count($KPI_summary->GroupRecords) && $KPI_summary->GroupCount <= $KPI_summary->DisplayGroups) {
?>
<?php

	// Show header
	if ($KPI_summary->ShowHeader) {
?>
<?php if ($KPI_summary->GroupCount > 1) { ?>
</tbody>
</table>
</div>
<!-- /.ew-grid-middle-panel -->
<!-- Report grid (end) -->
<?php if ($KPI_summary->TotalGroups > 0) { ?>
<?php if (!$KPI_summary->isExport() && !($KPI_summary->DrillDown && $KPI_summary->TotalGroups > 0)) { ?>
<!-- Bottom pager -->
<div class="card-footer ew-grid-lower-panel">
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $KPI_summary->Pager->render() ?>
</form>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php } ?>
</div>
<!-- /.ew-grid -->
<?php echo $KPI_summary->PageBreakContent ?>
<?php } ?>
<div class="<?php if (!$KPI_summary->isExport("word") && !$KPI_summary->isExport("excel")) { ?>card ew-card <?php } ?>ew-grid"<?php echo $KPI_summary->ReportTableStyle ?>>
<?php if (!$KPI_summary->isExport() && !($KPI_summary->DrillDown && $KPI_summary->TotalGroups > 0)) { ?>
<!-- Top pager -->
<div class="card-header ew-grid-upper-panel">
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $KPI_summary->Pager->render() ?>
</form>
<div class="clearfix"></div>
</div>
<?php } ?>
<!-- Report grid (begin) -->
<div id="gmp_KPI" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="<?php echo $KPI_summary->ReportTableClass ?>">
<thead>
	<!-- Table header -->
	<tr class="ew-table-header">
<?php if ($KPI_summary->fmea->Visible) { ?>
	<?php if ($KPI_summary->fmea->ShowGroupHeaderAsRow) { ?>
	<th data-name="fmea">&nbsp;</th>
	<?php } else { ?>
		<?php if ($KPI_summary->sortUrl($KPI_summary->fmea) == "") { ?>
	<th data-name="fmea" class="<?php echo $KPI_summary->fmea->headerCellClass() ?>"><div class="KPI_fmea"><div class="ew-table-header-caption"><?php echo $KPI_summary->fmea->caption() ?></div></div></th>
		<?php } else { ?>
	<th data-name="fmea" class="<?php echo $KPI_summary->fmea->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $KPI_summary->sortUrl($KPI_summary->fmea) ?>', 2);"><div class="KPI_fmea">
		<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $KPI_summary->fmea->caption() ?></span><span class="ew-table-header-sort"><?php if ($KPI_summary->fmea->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($KPI_summary->fmea->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
	</div></div></th>
		<?php } ?>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->idFactory->Visible) { ?>
	<?php if ($KPI_summary->sortUrl($KPI_summary->idFactory) == "") { ?>
	<th data-name="idFactory" class="<?php echo $KPI_summary->idFactory->headerCellClass() ?>"><div class="KPI_idFactory"><div class="ew-table-header-caption"><?php echo $KPI_summary->idFactory->caption() ?></div></div></th>
	<?php } else { ?>
	<th data-name="idFactory" class="<?php echo $KPI_summary->idFactory->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $KPI_summary->sortUrl($KPI_summary->idFactory) ?>', 2);"><div class="KPI_idFactory">
		<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $KPI_summary->idFactory->caption() ?></span><span class="ew-table-header-sort"><?php if ($KPI_summary->idFactory->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($KPI_summary->idFactory->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->dateFmea->Visible) { ?>
	<?php if ($KPI_summary->sortUrl($KPI_summary->dateFmea) == "") { ?>
	<th data-name="dateFmea" class="<?php echo $KPI_summary->dateFmea->headerCellClass() ?>"><div class="KPI_dateFmea"><div class="ew-table-header-caption"><?php echo $KPI_summary->dateFmea->caption() ?></div></div></th>
	<?php } else { ?>
	<th data-name="dateFmea" class="<?php echo $KPI_summary->dateFmea->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $KPI_summary->sortUrl($KPI_summary->dateFmea) ?>', 2);"><div class="KPI_dateFmea">
		<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $KPI_summary->dateFmea->caption() ?></span><span class="ew-table-header-sort"><?php if ($KPI_summary->dateFmea->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($KPI_summary->dateFmea->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->idworkcenter->Visible) { ?>
	<?php if ($KPI_summary->sortUrl($KPI_summary->idworkcenter) == "") { ?>
	<th data-name="idworkcenter" class="<?php echo $KPI_summary->idworkcenter->headerCellClass() ?>"><div class="KPI_idworkcenter"><div class="ew-table-header-caption"><?php echo $KPI_summary->idworkcenter->caption() ?></div></div></th>
	<?php } else { ?>
	<th data-name="idworkcenter" class="<?php echo $KPI_summary->idworkcenter->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $KPI_summary->sortUrl($KPI_summary->idworkcenter) ?>', 2);"><div class="KPI_idworkcenter">
		<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $KPI_summary->idworkcenter->caption() ?></span><span class="ew-table-header-sort"><?php if ($KPI_summary->idworkcenter->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($KPI_summary->idworkcenter->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->idProcess->Visible) { ?>
	<?php if ($KPI_summary->sortUrl($KPI_summary->idProcess) == "") { ?>
	<th data-name="idProcess" class="<?php echo $KPI_summary->idProcess->headerCellClass() ?>"><div class="KPI_idProcess"><div class="ew-table-header-caption"><?php echo $KPI_summary->idProcess->caption() ?></div></div></th>
	<?php } else { ?>
	<th data-name="idProcess" class="<?php echo $KPI_summary->idProcess->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $KPI_summary->sortUrl($KPI_summary->idProcess) ?>', 2);"><div class="KPI_idProcess">
		<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $KPI_summary->idProcess->caption() ?></span><span class="ew-table-header-sort"><?php if ($KPI_summary->idProcess->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($KPI_summary->idProcess->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->step->Visible) { ?>
	<?php if ($KPI_summary->sortUrl($KPI_summary->step) == "") { ?>
	<th data-name="step" class="<?php echo $KPI_summary->step->headerCellClass() ?>"><div class="KPI_step"><div class="ew-table-header-caption"><?php echo $KPI_summary->step->caption() ?></div></div></th>
	<?php } else { ?>
	<th data-name="step" class="<?php echo $KPI_summary->step->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $KPI_summary->sortUrl($KPI_summary->step) ?>', 2);"><div class="KPI_step">
		<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $KPI_summary->step->caption() ?></span><span class="ew-table-header-sort"><?php if ($KPI_summary->step->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($KPI_summary->step->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->flowchartDesc->Visible) { ?>
	<?php if ($KPI_summary->sortUrl($KPI_summary->flowchartDesc) == "") { ?>
	<th data-name="flowchartDesc" class="<?php echo $KPI_summary->flowchartDesc->headerCellClass() ?>"><div class="KPI_flowchartDesc"><div class="ew-table-header-caption"><?php echo $KPI_summary->flowchartDesc->caption() ?></div></div></th>
	<?php } else { ?>
	<th data-name="flowchartDesc" class="<?php echo $KPI_summary->flowchartDesc->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $KPI_summary->sortUrl($KPI_summary->flowchartDesc) ?>', 2);"><div class="KPI_flowchartDesc">
		<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $KPI_summary->flowchartDesc->caption() ?></span><span class="ew-table-header-sort"><?php if ($KPI_summary->flowchartDesc->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($KPI_summary->flowchartDesc->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->partnumber->Visible) { ?>
	<?php if ($KPI_summary->sortUrl($KPI_summary->partnumber) == "") { ?>
	<th data-name="partnumber" class="<?php echo $KPI_summary->partnumber->headerCellClass() ?>"><div class="KPI_partnumber"><div class="ew-table-header-caption"><?php echo $KPI_summary->partnumber->caption() ?></div></div></th>
	<?php } else { ?>
	<th data-name="partnumber" class="<?php echo $KPI_summary->partnumber->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $KPI_summary->sortUrl($KPI_summary->partnumber) ?>', 2);"><div class="KPI_partnumber">
		<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $KPI_summary->partnumber->caption() ?></span><span class="ew-table-header-sort"><?php if ($KPI_summary->partnumber->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($KPI_summary->partnumber->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->operation->Visible) { ?>
	<?php if ($KPI_summary->sortUrl($KPI_summary->operation) == "") { ?>
	<th data-name="operation" class="<?php echo $KPI_summary->operation->headerCellClass() ?>"><div class="KPI_operation"><div class="ew-table-header-caption"><?php echo $KPI_summary->operation->caption() ?></div></div></th>
	<?php } else { ?>
	<th data-name="operation" class="<?php echo $KPI_summary->operation->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $KPI_summary->sortUrl($KPI_summary->operation) ?>', 2);"><div class="KPI_operation">
		<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $KPI_summary->operation->caption() ?></span><span class="ew-table-header-sort"><?php if ($KPI_summary->operation->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($KPI_summary->operation->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->flowchart->Visible) { ?>
	<?php if ($KPI_summary->sortUrl($KPI_summary->flowchart) == "") { ?>
	<th data-name="flowchart" class="<?php echo $KPI_summary->flowchart->headerCellClass() ?>"><div class="KPI_flowchart"><div class="ew-table-header-caption"><?php echo $KPI_summary->flowchart->caption() ?></div></div></th>
	<?php } else { ?>
	<th data-name="flowchart" class="<?php echo $KPI_summary->flowchart->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $KPI_summary->sortUrl($KPI_summary->flowchart) ?>', 2);"><div class="KPI_flowchart">
		<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $KPI_summary->flowchart->caption() ?></span><span class="ew-table-header-sort"><?php if ($KPI_summary->flowchart->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($KPI_summary->flowchart->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->severity->Visible) { ?>
	<?php if ($KPI_summary->sortUrl($KPI_summary->severity) == "") { ?>
	<th data-name="severity" class="<?php echo $KPI_summary->severity->headerCellClass() ?>"><div class="KPI_severity"><div class="ew-table-header-caption"><?php echo $KPI_summary->severity->caption() ?></div></div></th>
	<?php } else { ?>
	<th data-name="severity" class="<?php echo $KPI_summary->severity->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $KPI_summary->sortUrl($KPI_summary->severity) ?>', 2);"><div class="KPI_severity">
		<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $KPI_summary->severity->caption() ?></span><span class="ew-table-header-sort"><?php if ($KPI_summary->severity->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($KPI_summary->severity->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->idCause->Visible) { ?>
	<?php if ($KPI_summary->sortUrl($KPI_summary->idCause) == "") { ?>
	<th data-name="idCause" class="<?php echo $KPI_summary->idCause->headerCellClass() ?>"><div class="KPI_idCause"><div class="ew-table-header-caption"><?php echo $KPI_summary->idCause->caption() ?></div></div></th>
	<?php } else { ?>
	<th data-name="idCause" class="<?php echo $KPI_summary->idCause->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $KPI_summary->sortUrl($KPI_summary->idCause) ?>', 2);"><div class="KPI_idCause">
		<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $KPI_summary->idCause->caption() ?></span><span class="ew-table-header-sort"><?php if ($KPI_summary->idCause->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($KPI_summary->idCause->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->potentialCauses->Visible) { ?>
	<?php if ($KPI_summary->sortUrl($KPI_summary->potentialCauses) == "") { ?>
	<th data-name="potentialCauses" class="<?php echo $KPI_summary->potentialCauses->headerCellClass() ?>"><div class="KPI_potentialCauses"><div class="ew-table-header-caption"><?php echo $KPI_summary->potentialCauses->caption() ?></div></div></th>
	<?php } else { ?>
	<th data-name="potentialCauses" class="<?php echo $KPI_summary->potentialCauses->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $KPI_summary->sortUrl($KPI_summary->potentialCauses) ?>', 2);"><div class="KPI_potentialCauses">
		<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $KPI_summary->potentialCauses->caption() ?></span><span class="ew-table-header-sort"><?php if ($KPI_summary->potentialCauses->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($KPI_summary->potentialCauses->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->occurrence->Visible) { ?>
	<?php if ($KPI_summary->sortUrl($KPI_summary->occurrence) == "") { ?>
	<th data-name="occurrence" class="<?php echo $KPI_summary->occurrence->headerCellClass() ?>"><div class="KPI_occurrence"><div class="ew-table-header-caption"><?php echo $KPI_summary->occurrence->caption() ?></div></div></th>
	<?php } else { ?>
	<th data-name="occurrence" class="<?php echo $KPI_summary->occurrence->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $KPI_summary->sortUrl($KPI_summary->occurrence) ?>', 2);"><div class="KPI_occurrence">
		<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $KPI_summary->occurrence->caption() ?></span><span class="ew-table-header-sort"><?php if ($KPI_summary->occurrence->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($KPI_summary->occurrence->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->detection->Visible) { ?>
	<?php if ($KPI_summary->sortUrl($KPI_summary->detection) == "") { ?>
	<th data-name="detection" class="<?php echo $KPI_summary->detection->headerCellClass() ?>"><div class="KPI_detection"><div class="ew-table-header-caption"><?php echo $KPI_summary->detection->caption() ?></div></div></th>
	<?php } else { ?>
	<th data-name="detection" class="<?php echo $KPI_summary->detection->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $KPI_summary->sortUrl($KPI_summary->detection) ?>', 2);"><div class="KPI_detection">
		<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $KPI_summary->detection->caption() ?></span><span class="ew-table-header-sort"><?php if ($KPI_summary->detection->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($KPI_summary->detection->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->rpn->Visible) { ?>
	<?php if ($KPI_summary->sortUrl($KPI_summary->rpn) == "") { ?>
	<th data-name="rpn" class="<?php echo $KPI_summary->rpn->headerCellClass() ?>"><div class="KPI_rpn"><div class="ew-table-header-caption"><?php echo $KPI_summary->rpn->caption() ?></div></div></th>
	<?php } else { ?>
	<th data-name="rpn" class="<?php echo $KPI_summary->rpn->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $KPI_summary->sortUrl($KPI_summary->rpn) ?>', 2);"><div class="KPI_rpn">
		<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $KPI_summary->rpn->caption() ?></span><span class="ew-table-header-sort"><?php if ($KPI_summary->rpn->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($KPI_summary->rpn->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->recomendedAction->Visible) { ?>
	<?php if ($KPI_summary->sortUrl($KPI_summary->recomendedAction) == "") { ?>
	<th data-name="recomendedAction" class="<?php echo $KPI_summary->recomendedAction->headerCellClass() ?>"><div class="KPI_recomendedAction"><div class="ew-table-header-caption"><?php echo $KPI_summary->recomendedAction->caption() ?></div></div></th>
	<?php } else { ?>
	<th data-name="recomendedAction" class="<?php echo $KPI_summary->recomendedAction->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $KPI_summary->sortUrl($KPI_summary->recomendedAction) ?>', 2);"><div class="KPI_recomendedAction">
		<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $KPI_summary->recomendedAction->caption() ?></span><span class="ew-table-header-sort"><?php if ($KPI_summary->recomendedAction->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($KPI_summary->recomendedAction->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->idResponsible->Visible) { ?>
	<?php if ($KPI_summary->sortUrl($KPI_summary->idResponsible) == "") { ?>
	<th data-name="idResponsible" class="<?php echo $KPI_summary->idResponsible->headerCellClass() ?>"><div class="KPI_idResponsible"><div class="ew-table-header-caption"><?php echo $KPI_summary->idResponsible->caption() ?></div></div></th>
	<?php } else { ?>
	<th data-name="idResponsible" class="<?php echo $KPI_summary->idResponsible->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $KPI_summary->sortUrl($KPI_summary->idResponsible) ?>', 2);"><div class="KPI_idResponsible">
		<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $KPI_summary->idResponsible->caption() ?></span><span class="ew-table-header-sort"><?php if ($KPI_summary->idResponsible->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($KPI_summary->idResponsible->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
	</div></div></th>
	<?php } ?>
<?php } ?>
	</tr>
</thead>
<tbody>
<?php
		if ($KPI_summary->TotalGroups == 0)
			break; // Show header only
		$KPI_summary->ShowHeader = FALSE;
	} // End show header
?>
<?php

	// Build detail SQL
	$where = DetailFilterSql($KPI_summary->fmea, $KPI_summary->getSqlFirstGroupField(), $KPI_summary->fmea->groupValue(), $KPI_summary->Dbid);
	if ($KPI_summary->PageFirstGroupFilter != "") $KPI_summary->PageFirstGroupFilter .= " OR ";
	$KPI_summary->PageFirstGroupFilter .= $where;
	if ($KPI_summary->Filter != "")
		$where = "($KPI_summary->Filter) AND ($where)";
	$sql = BuildReportSql($KPI_summary->getSqlSelect(), $KPI_summary->getSqlWhere(), $KPI_summary->getSqlGroupBy(), $KPI_summary->getSqlHaving(), $KPI_summary->getSqlOrderBy(), $where, $KPI_summary->Sort);
	$rs = $KPI_summary->getRecordset($sql);
	$KPI_summary->DetailRecords = $rs ? $rs->getRows() : [];
	$KPI_summary->DetailRecordCount = count($KPI_summary->DetailRecords);
	$KPI_summary->setGroupCount($KPI_summary->DetailRecordCount, $KPI_summary->GroupCount);

	// Load detail records
	$KPI_summary->fmea->Records = &$KPI_summary->DetailRecords;
	$KPI_summary->fmea->LevelBreak = TRUE; // Set field level break
		$KPI_summary->GroupCounter[1] = $KPI_summary->GroupCount;
		$KPI_summary->fmea->getCnt($KPI_summary->fmea->Records); // Get record count
		$KPI_summary->setGroupCount($KPI_summary->fmea->Count, $KPI_summary->GroupCounter[1]);
?>
<?php if ($KPI_summary->fmea->Visible && $KPI_summary->fmea->ShowGroupHeaderAsRow) { ?>
<?php

		// Render header row
		$KPI_summary->resetAttributes();
		$KPI_summary->RowType = ROWTYPE_TOTAL;
		$KPI_summary->RowTotalType = ROWTOTAL_GROUP;
		$KPI_summary->RowTotalSubType = ROWTOTAL_HEADER;
		$KPI_summary->RowGroupLevel = 1;
		$KPI_summary->renderRow();
?>
	<tr<?php echo $KPI_summary->rowAttributes(); ?>>
<?php if ($KPI_summary->fmea->Visible) { ?>
		<td data-field="fmea"<?php echo $KPI_summary->fmea->cellAttributes(); ?>><span class="ew-group-toggle icon-collapse"></span></td>
<?php } ?>
		<td data-field="fmea" colspan="<?php echo ($Page->GroupColumnCount + $Page->DetailColumnCount - 1) ?>"<?php echo $KPI_summary->fmea->cellAttributes() ?>>
<?php if ($KPI_summary->sortUrl($KPI_summary->fmea) == "") { ?>
		<span class="ew-summary-caption KPI_fmea"><span class="ew-table-header-caption"><?php echo $KPI_summary->fmea->caption() ?></span></span>
<?php } else { ?>
		<span class="ew-table-header-btn ew-pointer ew-summary-caption KPI_fmea" onclick="ew.sort(event, '<?php echo $KPI_summary->sortUrl($KPI_summary->fmea) ?>', 2);">
			<span class="ew-table-header-caption"><?php echo $KPI_summary->fmea->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($KPI_summary->fmea->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($KPI_summary->fmea->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
		</span>
<?php } ?>
		<?php echo $Language->phrase("SummaryColon") ?><span<?php echo $KPI_summary->fmea->viewAttributes() ?>><?php echo $KPI_summary->fmea->GroupViewValue ?></span>
		<span class="ew-summary-count">(<span class="ew-aggregate-caption"><?php echo $Language->phrase("RptCnt") ?></span><?php echo $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?php echo FormatNumber($KPI_summary->fmea->Count, 0); ?></span>)</span>
		</td>
	</tr>
<?php } ?>
<?php
	$KPI_summary->RecordCount = 0; // Reset record count
	foreach ($KPI_summary->fmea->Records as $record) {
		$KPI_summary->RecordCount++;
		$KPI_summary->RecordIndex++;
		$KPI_summary->loadRowValues($record);
?>
<?php

		// Render detail row
		$KPI_summary->resetAttributes();
		$KPI_summary->RowType = ROWTYPE_DETAIL;
		$KPI_summary->renderRow();
?>
	<tr<?php echo $KPI_summary->rowAttributes(); ?>>
<?php if ($KPI_summary->fmea->Visible) { ?>
	<?php if ($KPI_summary->fmea->ShowGroupHeaderAsRow) { ?>
		<td data-field="fmea"<?php echo $KPI_summary->fmea->cellAttributes(); ?>>&nbsp;</td>
	<?php } else { ?>
		<td data-field="fmea"<?php echo $KPI_summary->fmea->cellAttributes(); ?>><span<?php echo $KPI_summary->fmea->viewAttributes() ?>><?php echo $KPI_summary->fmea->GroupViewValue ?></span></td>
	<?php } ?>
<?php } ?>
<?php if ($KPI_summary->idFactory->Visible) { ?>
		<td data-field="idFactory"<?php echo $KPI_summary->idFactory->cellAttributes() ?>>
<span<?php echo $KPI_summary->idFactory->viewAttributes() ?>><?php echo $KPI_summary->idFactory->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($KPI_summary->dateFmea->Visible) { ?>
		<td data-field="dateFmea"<?php echo $KPI_summary->dateFmea->cellAttributes() ?>>
<span<?php echo $KPI_summary->dateFmea->viewAttributes() ?>><?php echo $KPI_summary->dateFmea->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($KPI_summary->idworkcenter->Visible) { ?>
		<td data-field="idworkcenter"<?php echo $KPI_summary->idworkcenter->cellAttributes() ?>>
<span<?php echo $KPI_summary->idworkcenter->viewAttributes() ?>><?php echo $KPI_summary->idworkcenter->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($KPI_summary->idProcess->Visible) { ?>
		<td data-field="idProcess"<?php echo $KPI_summary->idProcess->cellAttributes() ?>>
<span<?php echo $KPI_summary->idProcess->viewAttributes() ?>><?php echo $KPI_summary->idProcess->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($KPI_summary->step->Visible) { ?>
		<td data-field="step"<?php echo $KPI_summary->step->cellAttributes() ?>>
<span<?php echo $KPI_summary->step->viewAttributes() ?>><?php echo $KPI_summary->step->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($KPI_summary->flowchartDesc->Visible) { ?>
		<td data-field="flowchartDesc"<?php echo $KPI_summary->flowchartDesc->cellAttributes() ?>>
<span<?php echo $KPI_summary->flowchartDesc->viewAttributes() ?>><?php echo $KPI_summary->flowchartDesc->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($KPI_summary->partnumber->Visible) { ?>
		<td data-field="partnumber"<?php echo $KPI_summary->partnumber->cellAttributes() ?>>
<span<?php echo $KPI_summary->partnumber->viewAttributes() ?>><?php echo $KPI_summary->partnumber->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($KPI_summary->operation->Visible) { ?>
		<td data-field="operation"<?php echo $KPI_summary->operation->cellAttributes() ?>>
<span<?php echo $KPI_summary->operation->viewAttributes() ?>><?php echo $KPI_summary->operation->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($KPI_summary->flowchart->Visible) { ?>
		<td data-field="flowchart"<?php echo $KPI_summary->flowchart->cellAttributes() ?>>
<span<?php echo $KPI_summary->flowchart->viewAttributes() ?>><?php echo $KPI_summary->flowchart->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($KPI_summary->severity->Visible) { ?>
		<td data-field="severity"<?php echo $KPI_summary->severity->cellAttributes() ?>>
<span<?php echo $KPI_summary->severity->viewAttributes() ?>><?php echo $KPI_summary->severity->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($KPI_summary->idCause->Visible) { ?>
		<td data-field="idCause"<?php echo $KPI_summary->idCause->cellAttributes() ?>>
<span<?php echo $KPI_summary->idCause->viewAttributes() ?>><?php echo $KPI_summary->idCause->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($KPI_summary->potentialCauses->Visible) { ?>
		<td data-field="potentialCauses"<?php echo $KPI_summary->potentialCauses->cellAttributes() ?>>
<span<?php echo $KPI_summary->potentialCauses->viewAttributes() ?>><?php echo $KPI_summary->potentialCauses->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($KPI_summary->occurrence->Visible) { ?>
		<td data-field="occurrence"<?php echo $KPI_summary->occurrence->cellAttributes() ?>>
<span<?php echo $KPI_summary->occurrence->viewAttributes() ?>><?php echo $KPI_summary->occurrence->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($KPI_summary->detection->Visible) { ?>
		<td data-field="detection"<?php echo $KPI_summary->detection->cellAttributes() ?>>
<span<?php echo $KPI_summary->detection->viewAttributes() ?>><?php echo $KPI_summary->detection->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($KPI_summary->rpn->Visible) { ?>
		<td data-field="rpn"<?php echo $KPI_summary->rpn->cellAttributes() ?>>
<span<?php echo $KPI_summary->rpn->viewAttributes() ?>><?php echo $KPI_summary->rpn->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($KPI_summary->recomendedAction->Visible) { ?>
		<td data-field="recomendedAction"<?php echo $KPI_summary->recomendedAction->cellAttributes() ?>>
<span<?php echo $KPI_summary->recomendedAction->viewAttributes() ?>><?php echo $KPI_summary->recomendedAction->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($KPI_summary->idResponsible->Visible) { ?>
		<td data-field="idResponsible"<?php echo $KPI_summary->idResponsible->cellAttributes() ?>>
<span<?php echo $KPI_summary->idResponsible->viewAttributes() ?>><?php echo $KPI_summary->idResponsible->getViewValue() ?></span>
</td>
<?php } ?>
	</tr>
<?php
	}
?>
<?php

	// Next group
	$KPI_summary->loadGroupRowValues();

	// Show header if page break
	if ($KPI_summary->isExport())
		$KPI_summary->ShowHeader = ($KPI_summary->ExportPageBreakCount == 0) ? FALSE : ($KPI_summary->GroupCount % $KPI_summary->ExportPageBreakCount == 0);

	// Page_Breaking server event
	if ($KPI_summary->ShowHeader)
		$KPI_summary->Page_Breaking($KPI_summary->ShowHeader, $KPI_summary->PageBreakContent);
	$KPI_summary->GroupCount++;
} // End while
?>
<?php if ($KPI_summary->TotalGroups > 0) { ?>
</tbody>
<tfoot>
<?php
	$KPI_summary->resetAttributes();
	$KPI_summary->RowType = ROWTYPE_TOTAL;
	$KPI_summary->RowTotalType = ROWTOTAL_GRAND;
	$KPI_summary->RowTotalSubType = ROWTOTAL_FOOTER;
	$KPI_summary->RowAttrs["class"] = "ew-rpt-grand-summary";
	$KPI_summary->renderRow();
?>
<?php if ($KPI_summary->fmea->ShowCompactSummaryFooter) { ?>
	<tr<?php echo $KPI_summary->rowAttributes() ?>><td colspan="<?php echo ($KPI_summary->GroupColumnCount + $KPI_summary->DetailColumnCount) ?>"><?php echo $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?php echo $Language->phrase("RptCnt") ?></span><?php echo $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?php echo FormatNumber($KPI_summary->TotalCount, 0); ?></span>)</span></td></tr>
	<tr<?php echo $KPI_summary->rowAttributes() ?>>
<?php if ($KPI_summary->GroupColumnCount > 0) { ?>
		<td colspan="<?php echo $KPI_summary->GroupColumnCount ?>" class="ew-rpt-grp-aggregate">&nbsp;</td>
<?php } ?>
<?php if ($KPI_summary->idFactory->Visible) { ?>
		<td data-field="idFactory"<?php echo $KPI_summary->idFactory->cellAttributes() ?>></td>
<?php } ?>
<?php if ($KPI_summary->dateFmea->Visible) { ?>
		<td data-field="dateFmea"<?php echo $KPI_summary->dateFmea->cellAttributes() ?>></td>
<?php } ?>
<?php if ($KPI_summary->idworkcenter->Visible) { ?>
		<td data-field="idworkcenter"<?php echo $KPI_summary->idworkcenter->cellAttributes() ?>></td>
<?php } ?>
<?php if ($KPI_summary->idProcess->Visible) { ?>
		<td data-field="idProcess"<?php echo $KPI_summary->idProcess->cellAttributes() ?>></td>
<?php } ?>
<?php if ($KPI_summary->step->Visible) { ?>
		<td data-field="step"<?php echo $KPI_summary->step->cellAttributes() ?>></td>
<?php } ?>
<?php if ($KPI_summary->flowchartDesc->Visible) { ?>
		<td data-field="flowchartDesc"<?php echo $KPI_summary->flowchartDesc->cellAttributes() ?>></td>
<?php } ?>
<?php if ($KPI_summary->partnumber->Visible) { ?>
		<td data-field="partnumber"<?php echo $KPI_summary->partnumber->cellAttributes() ?>></td>
<?php } ?>
<?php if ($KPI_summary->operation->Visible) { ?>
		<td data-field="operation"<?php echo $KPI_summary->operation->cellAttributes() ?>></td>
<?php } ?>
<?php if ($KPI_summary->flowchart->Visible) { ?>
		<td data-field="flowchart"<?php echo $KPI_summary->flowchart->cellAttributes() ?>></td>
<?php } ?>
<?php if ($KPI_summary->severity->Visible) { ?>
		<td data-field="severity"<?php echo $KPI_summary->severity->cellAttributes() ?>></td>
<?php } ?>
<?php if ($KPI_summary->idCause->Visible) { ?>
		<td data-field="idCause"<?php echo $KPI_summary->idCause->cellAttributes() ?>><span class="ew-aggregate-caption"><?php echo $Language->phrase("RptCnt") ?></span><?php echo $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><span<?php echo $KPI_summary->idCause->viewAttributes() ?>><?php echo $KPI_summary->idCause->CntViewValue ?></span></span></td>
<?php } ?>
<?php if ($KPI_summary->potentialCauses->Visible) { ?>
		<td data-field="potentialCauses"<?php echo $KPI_summary->potentialCauses->cellAttributes() ?>></td>
<?php } ?>
<?php if ($KPI_summary->occurrence->Visible) { ?>
		<td data-field="occurrence"<?php echo $KPI_summary->occurrence->cellAttributes() ?>></td>
<?php } ?>
<?php if ($KPI_summary->detection->Visible) { ?>
		<td data-field="detection"<?php echo $KPI_summary->detection->cellAttributes() ?>></td>
<?php } ?>
<?php if ($KPI_summary->rpn->Visible) { ?>
		<td data-field="rpn"<?php echo $KPI_summary->rpn->cellAttributes() ?>></td>
<?php } ?>
<?php if ($KPI_summary->recomendedAction->Visible) { ?>
		<td data-field="recomendedAction"<?php echo $KPI_summary->recomendedAction->cellAttributes() ?>></td>
<?php } ?>
<?php if ($KPI_summary->idResponsible->Visible) { ?>
		<td data-field="idResponsible"<?php echo $KPI_summary->idResponsible->cellAttributes() ?>></td>
<?php } ?>
	</tr>
<?php } else { ?>
	<tr<?php echo $KPI_summary->rowAttributes() ?>><td colspan="<?php echo ($KPI_summary->GroupColumnCount + $KPI_summary->DetailColumnCount) ?>"><?php echo $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<?php echo FormatNumber($KPI_summary->TotalCount, 0); ?><?php echo $Language->phrase("RptDtlRec") ?>)</span></td></tr>
	<tr<?php echo $KPI_summary->rowAttributes() ?>>
<?php if ($KPI_summary->GroupColumnCount > 0) { ?>
		<td colspan="<?php echo $KPI_summary->GroupColumnCount ?>" class="ew-rpt-grp-aggregate"><?php echo $Language->phrase("RptCnt") ?></td>
<?php } ?>
<?php if ($KPI_summary->idFactory->Visible) { ?>
		<td data-field="idFactory"<?php echo $KPI_summary->idFactory->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($KPI_summary->dateFmea->Visible) { ?>
		<td data-field="dateFmea"<?php echo $KPI_summary->dateFmea->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($KPI_summary->idworkcenter->Visible) { ?>
		<td data-field="idworkcenter"<?php echo $KPI_summary->idworkcenter->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($KPI_summary->idProcess->Visible) { ?>
		<td data-field="idProcess"<?php echo $KPI_summary->idProcess->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($KPI_summary->step->Visible) { ?>
		<td data-field="step"<?php echo $KPI_summary->step->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($KPI_summary->flowchartDesc->Visible) { ?>
		<td data-field="flowchartDesc"<?php echo $KPI_summary->flowchartDesc->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($KPI_summary->partnumber->Visible) { ?>
		<td data-field="partnumber"<?php echo $KPI_summary->partnumber->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($KPI_summary->operation->Visible) { ?>
		<td data-field="operation"<?php echo $KPI_summary->operation->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($KPI_summary->flowchart->Visible) { ?>
		<td data-field="flowchart"<?php echo $KPI_summary->flowchart->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($KPI_summary->severity->Visible) { ?>
		<td data-field="severity"<?php echo $KPI_summary->severity->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($KPI_summary->idCause->Visible) { ?>
		<td data-field="idCause"<?php echo $KPI_summary->idCause->cellAttributes() ?>>
<span<?php echo $KPI_summary->idCause->viewAttributes() ?>><?php echo $KPI_summary->idCause->CntViewValue ?></span>
</td>
<?php } ?>
<?php if ($KPI_summary->potentialCauses->Visible) { ?>
		<td data-field="potentialCauses"<?php echo $KPI_summary->potentialCauses->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($KPI_summary->occurrence->Visible) { ?>
		<td data-field="occurrence"<?php echo $KPI_summary->occurrence->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($KPI_summary->detection->Visible) { ?>
		<td data-field="detection"<?php echo $KPI_summary->detection->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($KPI_summary->rpn->Visible) { ?>
		<td data-field="rpn"<?php echo $KPI_summary->rpn->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($KPI_summary->recomendedAction->Visible) { ?>
		<td data-field="recomendedAction"<?php echo $KPI_summary->recomendedAction->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($KPI_summary->idResponsible->Visible) { ?>
		<td data-field="idResponsible"<?php echo $KPI_summary->idResponsible->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
	</tr>
<?php } ?>
</tfoot>
</table>
</div>
<!-- /.ew-grid-middle-panel -->
<!-- Report grid (end) -->
<?php if ($KPI_summary->TotalGroups > 0) { ?>
<?php if (!$KPI_summary->isExport() && !($KPI_summary->DrillDown && $KPI_summary->TotalGroups > 0)) { ?>
<!-- Bottom pager -->
<div class="card-footer ew-grid-lower-panel">
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $KPI_summary->Pager->render() ?>
</form>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php } ?>
</div>
<!-- /.ew-grid -->
<?php } ?>
</div>
<!-- /#report-summary -->
<!-- Summary report (end) -->
<?php if ((!$KPI_summary->isExport() || $KPI_summary->isExport("print")) && !$DashboardReport) { ?>
</div>
<!-- /#ew-center -->
<?php } ?>
<?php if ((!$KPI_summary->isExport() || $KPI_summary->isExport("print")) && !$DashboardReport) { ?>
<!-- Right Container -->
<div id="ew-right" class="<?php echo $KPI_summary->RightContentClass ?>">
<?php } ?>
<?php
if (!$DashboardReport) {

	// Set up page break
	if (($KPI_summary->isExport("print") || $KPI_summary->isExport("pdf") || $KPI_summary->isExport("email") || $KPI_summary->isExport("excel") && Config("USE_PHPEXCEL") || $KPI_summary->isExport("word") && Config("USE_PHPWORD")) && $KPI_summary->ExportChartPageBreak) {

		// Page_Breaking server event
		$KPI_summary->Page_Breaking($KPI_summary->ExportChartPageBreak, $KPI_summary->PageBreakContent);
		$KPI->KPIFMEA->PageBreakType = "before"; // Page break type
		$KPI->KPIFMEA->PageBreak = $KPI_summary->ExportChartPageBreak;
		$KPI->KPIFMEA->PageBreakContent = $KPI_summary->PageBreakContent;
	}

	// Set up chart drilldown
	$KPI->KPIFMEA->DrillDownInPanel = $KPI_summary->DrillDownInPanel;
	$KPI->KPIFMEA->render("ew-chart-bottom");
}
?>
<?php if ((!$KPI_summary->isExport() || $KPI_summary->isExport("print")) && !$DashboardReport) { ?>
</div>
<!-- /#ew-right -->
<?php } ?>
<?php if ((!$KPI_summary->isExport() || $KPI_summary->isExport("print")) && !$DashboardReport) { ?>
</div>
<!-- /.row -->
<?php } ?>
<?php if ((!$KPI_summary->isExport() || $KPI_summary->isExport("print")) && !$DashboardReport) { ?>
</div>
<!-- /.ew-report -->
<?php } ?>
<?php
$KPI_summary->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$KPI_summary->isExport() && !$KPI_summary->DrillDown && !$DashboardReport) { ?>
<script>
loadjs.ready("load", function() {

	// Startup script
	// Write your table-specific startup script here
	// console.log("page loaded");

});
</script>
<?php } ?>
<?php if (!$DashboardReport) { ?>
<?php include_once "footer.php"; ?>
<?php } ?>
<?php
$KPI_summary->terminate();
?>