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
$severity_search = new severity_search();

// Run the page
$severity_search->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$severity_search->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fseveritysearch, currentPageID;
loadjs.ready("head", function() {

	// Form object for search
	<?php if ($severity_search->IsModal) { ?>
	fseveritysearch = currentAdvancedSearchForm = new ew.Form("fseveritysearch", "search");
	<?php } else { ?>
	fseveritysearch = currentForm = new ew.Form("fseveritysearch", "search");
	<?php } ?>
	currentPageID = ew.PAGE_ID = "search";

	// Validate function for search
	fseveritysearch.validate = function(fobj) {
		if (!this.validateRequired)
			return true; // Ignore validation
		fobj = fobj || this._form;
		var infix = "";
		elm = this.getElements("x" + infix + "_idSeverity");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($severity_search->idSeverity->errorMessage()) ?>");

		// Call Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
		return true;
	}

	// Form_CustomValidate
	fseveritysearch.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fseveritysearch.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fseveritysearch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $severity_search->showPageHeader(); ?>
<?php
$severity_search->showMessage();
?>
<form name="fseveritysearch" id="fseveritysearch" class="<?php echo $severity_search->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="severity">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?php echo (int)$severity_search->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($severity_search->idSeverity->Visible) { // idSeverity ?>
	<div id="r_idSeverity" class="form-group row">
		<label for="x_idSeverity" class="<?php echo $severity_search->LeftColumnClass ?>"><span id="elh_severity_idSeverity"><?php echo $severity_search->idSeverity->caption() ?></span>
		</label>
		<div class="<?php echo $severity_search->RightColumnClass ?>"><div <?php echo $severity_search->idSeverity->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_idSeverity" id="z_idSeverity" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $severity_search->idSeverity->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $severity_search->idSeverity->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $severity_search->idSeverity->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $severity_search->idSeverity->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $severity_search->idSeverity->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $severity_search->idSeverity->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $severity_search->idSeverity->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $severity_search->idSeverity->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $severity_search->idSeverity->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_severity_idSeverity" class="ew-search-field">
<input type="text" data-table="severity" data-field="x_idSeverity" name="x_idSeverity" id="x_idSeverity" placeholder="<?php echo HtmlEncode($severity_search->idSeverity->getPlaceHolder()) ?>" value="<?php echo $severity_search->idSeverity->EditValue ?>"<?php echo $severity_search->idSeverity->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_severity_idSeverity" class="ew-search-field2 d-none">
<input type="text" data-table="severity" data-field="x_idSeverity" name="y_idSeverity" id="y_idSeverity" placeholder="<?php echo HtmlEncode($severity_search->idSeverity->getPlaceHolder()) ?>" value="<?php echo $severity_search->idSeverity->EditValue2 ?>"<?php echo $severity_search->idSeverity->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($severity_search->effect->Visible) { // effect ?>
	<div id="r_effect" class="form-group row">
		<label for="x_effect" class="<?php echo $severity_search->LeftColumnClass ?>"><span id="elh_severity_effect"><?php echo $severity_search->effect->caption() ?></span>
		</label>
		<div class="<?php echo $severity_search->RightColumnClass ?>"><div <?php echo $severity_search->effect->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_effect" id="z_effect" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $severity_search->effect->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $severity_search->effect->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $severity_search->effect->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $severity_search->effect->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $severity_search->effect->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $severity_search->effect->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $severity_search->effect->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $severity_search->effect->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $severity_search->effect->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $severity_search->effect->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="BETWEEN"<?php echo $severity_search->effect->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_severity_effect" class="ew-search-field">
<input type="text" data-table="severity" data-field="x_effect" name="x_effect" id="x_effect" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($severity_search->effect->getPlaceHolder()) ?>" value="<?php echo $severity_search->effect->EditValue ?>"<?php echo $severity_search->effect->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_severity_effect" class="ew-search-field2 d-none">
<input type="text" data-table="severity" data-field="x_effect" name="y_effect" id="y_effect" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($severity_search->effect->getPlaceHolder()) ?>" value="<?php echo $severity_search->effect->EditValue2 ?>"<?php echo $severity_search->effect->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($severity_search->severityonclient->Visible) { // severityonclient ?>
	<div id="r_severityonclient" class="form-group row">
		<label for="x_severityonclient" class="<?php echo $severity_search->LeftColumnClass ?>"><span id="elh_severity_severityonclient"><?php echo $severity_search->severityonclient->caption() ?></span>
		</label>
		<div class="<?php echo $severity_search->RightColumnClass ?>"><div <?php echo $severity_search->severityonclient->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_severityonclient" id="z_severityonclient" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $severity_search->severityonclient->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $severity_search->severityonclient->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $severity_search->severityonclient->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $severity_search->severityonclient->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $severity_search->severityonclient->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $severity_search->severityonclient->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $severity_search->severityonclient->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $severity_search->severityonclient->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $severity_search->severityonclient->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $severity_search->severityonclient->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $severity_search->severityonclient->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $severity_search->severityonclient->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $severity_search->severityonclient->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_severity_severityonclient" class="ew-search-field">
<input type="text" data-table="severity" data-field="x_severityonclient" name="x_severityonclient" id="x_severityonclient" size="35" placeholder="<?php echo HtmlEncode($severity_search->severityonclient->getPlaceHolder()) ?>" value="<?php echo $severity_search->severityonclient->EditValue ?>"<?php echo $severity_search->severityonclient->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_severity_severityonclient" class="ew-search-field2 d-none">
<input type="text" data-table="severity" data-field="x_severityonclient" name="y_severityonclient" id="y_severityonclient" size="35" placeholder="<?php echo HtmlEncode($severity_search->severityonclient->getPlaceHolder()) ?>" value="<?php echo $severity_search->severityonclient->EditValue2 ?>"<?php echo $severity_search->severityonclient->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($severity_search->internalseverity->Visible) { // internalseverity ?>
	<div id="r_internalseverity" class="form-group row">
		<label for="x_internalseverity" class="<?php echo $severity_search->LeftColumnClass ?>"><span id="elh_severity_internalseverity"><?php echo $severity_search->internalseverity->caption() ?></span>
		</label>
		<div class="<?php echo $severity_search->RightColumnClass ?>"><div <?php echo $severity_search->internalseverity->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_internalseverity" id="z_internalseverity" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $severity_search->internalseverity->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $severity_search->internalseverity->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $severity_search->internalseverity->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $severity_search->internalseverity->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $severity_search->internalseverity->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $severity_search->internalseverity->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $severity_search->internalseverity->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $severity_search->internalseverity->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $severity_search->internalseverity->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $severity_search->internalseverity->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $severity_search->internalseverity->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $severity_search->internalseverity->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $severity_search->internalseverity->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_severity_internalseverity" class="ew-search-field">
<input type="text" data-table="severity" data-field="x_internalseverity" name="x_internalseverity" id="x_internalseverity" size="35" placeholder="<?php echo HtmlEncode($severity_search->internalseverity->getPlaceHolder()) ?>" value="<?php echo $severity_search->internalseverity->EditValue ?>"<?php echo $severity_search->internalseverity->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_severity_internalseverity" class="ew-search-field2 d-none">
<input type="text" data-table="severity" data-field="x_internalseverity" name="y_internalseverity" id="y_internalseverity" size="35" placeholder="<?php echo HtmlEncode($severity_search->internalseverity->getPlaceHolder()) ?>" value="<?php echo $severity_search->internalseverity->EditValue2 ?>"<?php echo $severity_search->internalseverity->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($severity_search->color->Visible) { // color ?>
	<div id="r_color" class="form-group row">
		<label for="x_color" class="<?php echo $severity_search->LeftColumnClass ?>"><span id="elh_severity_color"><?php echo $severity_search->color->caption() ?></span>
		</label>
		<div class="<?php echo $severity_search->RightColumnClass ?>"><div <?php echo $severity_search->color->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_color" id="z_color" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $severity_search->color->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $severity_search->color->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $severity_search->color->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $severity_search->color->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $severity_search->color->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $severity_search->color->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $severity_search->color->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $severity_search->color->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $severity_search->color->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $severity_search->color->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $severity_search->color->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $severity_search->color->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $severity_search->color->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_severity_color" class="ew-search-field">
<input type="text" data-table="severity" data-field="x_color" name="x_color" id="x_color" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($severity_search->color->getPlaceHolder()) ?>" value="<?php echo $severity_search->color->EditValue ?>"<?php echo $severity_search->color->editAttributes() ?>>

<script>
loadjs.ready("head", function() {
	jQuery("[id='x_color']:not([id*='$rowindex$'])").colorpicker({ format: "hex" });
});
</script>

</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_severity_color" class="ew-search-field2 d-none">
<input type="text" data-table="severity" data-field="x_color" name="y_color" id="y_color" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($severity_search->color->getPlaceHolder()) ?>" value="<?php echo $severity_search->color->EditValue2 ?>"<?php echo $severity_search->color->editAttributes() ?>>

<script>
loadjs.ready("head", function() {
	jQuery("[id='x_color']:not([id*='$rowindex$'])").colorpicker({ format: "hex" });
});
</script>

</span>
		</div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$severity_search->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $severity_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("Search") ?></button>
<button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" onclick="ew.clearForm(this.form);"><?php echo $Language->phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$severity_search->showPageFooter();
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
$severity_search->terminate();
?>