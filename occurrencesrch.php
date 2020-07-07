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
$occurrence_search = new occurrence_search();

// Run the page
$occurrence_search->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$occurrence_search->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var foccurrencesearch, currentPageID;
loadjs.ready("head", function() {

	// Form object for search
	<?php if ($occurrence_search->IsModal) { ?>
	foccurrencesearch = currentAdvancedSearchForm = new ew.Form("foccurrencesearch", "search");
	<?php } else { ?>
	foccurrencesearch = currentForm = new ew.Form("foccurrencesearch", "search");
	<?php } ?>
	currentPageID = ew.PAGE_ID = "search";

	// Validate function for search
	foccurrencesearch.validate = function(fobj) {
		if (!this.validateRequired)
			return true; // Ignore validation
		fobj = fobj || this._form;
		var infix = "";
		elm = this.getElements("x" + infix + "_idOccurrence");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($occurrence_search->idOccurrence->errorMessage()) ?>");

		// Call Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
		return true;
	}

	// Form_CustomValidate
	foccurrencesearch.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	foccurrencesearch.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("foccurrencesearch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $occurrence_search->showPageHeader(); ?>
<?php
$occurrence_search->showMessage();
?>
<form name="foccurrencesearch" id="foccurrencesearch" class="<?php echo $occurrence_search->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="occurrence">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?php echo (int)$occurrence_search->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($occurrence_search->idOccurrence->Visible) { // idOccurrence ?>
	<div id="r_idOccurrence" class="form-group row">
		<label for="x_idOccurrence" class="<?php echo $occurrence_search->LeftColumnClass ?>"><span id="elh_occurrence_idOccurrence"><?php echo $occurrence_search->idOccurrence->caption() ?></span>
		</label>
		<div class="<?php echo $occurrence_search->RightColumnClass ?>"><div <?php echo $occurrence_search->idOccurrence->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_idOccurrence" id="z_idOccurrence" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $occurrence_search->idOccurrence->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $occurrence_search->idOccurrence->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $occurrence_search->idOccurrence->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $occurrence_search->idOccurrence->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $occurrence_search->idOccurrence->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $occurrence_search->idOccurrence->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $occurrence_search->idOccurrence->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $occurrence_search->idOccurrence->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $occurrence_search->idOccurrence->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_occurrence_idOccurrence" class="ew-search-field">
<input type="text" data-table="occurrence" data-field="x_idOccurrence" name="x_idOccurrence" id="x_idOccurrence" placeholder="<?php echo HtmlEncode($occurrence_search->idOccurrence->getPlaceHolder()) ?>" value="<?php echo $occurrence_search->idOccurrence->EditValue ?>"<?php echo $occurrence_search->idOccurrence->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_occurrence_idOccurrence" class="ew-search-field2 d-none">
<input type="text" data-table="occurrence" data-field="x_idOccurrence" name="y_idOccurrence" id="y_idOccurrence" placeholder="<?php echo HtmlEncode($occurrence_search->idOccurrence->getPlaceHolder()) ?>" value="<?php echo $occurrence_search->idOccurrence->EditValue2 ?>"<?php echo $occurrence_search->idOccurrence->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($occurrence_search->probability->Visible) { // probability ?>
	<div id="r_probability" class="form-group row">
		<label for="x_probability" class="<?php echo $occurrence_search->LeftColumnClass ?>"><span id="elh_occurrence_probability"><?php echo $occurrence_search->probability->caption() ?></span>
		</label>
		<div class="<?php echo $occurrence_search->RightColumnClass ?>"><div <?php echo $occurrence_search->probability->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_probability" id="z_probability" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $occurrence_search->probability->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $occurrence_search->probability->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $occurrence_search->probability->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $occurrence_search->probability->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $occurrence_search->probability->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $occurrence_search->probability->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $occurrence_search->probability->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $occurrence_search->probability->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $occurrence_search->probability->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $occurrence_search->probability->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="BETWEEN"<?php echo $occurrence_search->probability->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_occurrence_probability" class="ew-search-field">
<input type="text" data-table="occurrence" data-field="x_probability" name="x_probability" id="x_probability" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($occurrence_search->probability->getPlaceHolder()) ?>" value="<?php echo $occurrence_search->probability->EditValue ?>"<?php echo $occurrence_search->probability->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_occurrence_probability" class="ew-search-field2 d-none">
<input type="text" data-table="occurrence" data-field="x_probability" name="y_probability" id="y_probability" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($occurrence_search->probability->getPlaceHolder()) ?>" value="<?php echo $occurrence_search->probability->EditValue2 ?>"<?php echo $occurrence_search->probability->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($occurrence_search->description->Visible) { // description ?>
	<div id="r_description" class="form-group row">
		<label for="x_description" class="<?php echo $occurrence_search->LeftColumnClass ?>"><span id="elh_occurrence_description"><?php echo $occurrence_search->description->caption() ?></span>
		</label>
		<div class="<?php echo $occurrence_search->RightColumnClass ?>"><div <?php echo $occurrence_search->description->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_description" id="z_description" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $occurrence_search->description->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $occurrence_search->description->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $occurrence_search->description->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $occurrence_search->description->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $occurrence_search->description->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $occurrence_search->description->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $occurrence_search->description->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $occurrence_search->description->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $occurrence_search->description->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $occurrence_search->description->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $occurrence_search->description->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $occurrence_search->description->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $occurrence_search->description->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_occurrence_description" class="ew-search-field">
<input type="text" data-table="occurrence" data-field="x_description" name="x_description" id="x_description" size="35" placeholder="<?php echo HtmlEncode($occurrence_search->description->getPlaceHolder()) ?>" value="<?php echo $occurrence_search->description->EditValue ?>"<?php echo $occurrence_search->description->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_occurrence_description" class="ew-search-field2 d-none">
<input type="text" data-table="occurrence" data-field="x_description" name="y_description" id="y_description" size="35" placeholder="<?php echo HtmlEncode($occurrence_search->description->getPlaceHolder()) ?>" value="<?php echo $occurrence_search->description->EditValue2 ?>"<?php echo $occurrence_search->description->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($occurrence_search->likelihood->Visible) { // likelihood ?>
	<div id="r_likelihood" class="form-group row">
		<label for="x_likelihood" class="<?php echo $occurrence_search->LeftColumnClass ?>"><span id="elh_occurrence_likelihood"><?php echo $occurrence_search->likelihood->caption() ?></span>
		</label>
		<div class="<?php echo $occurrence_search->RightColumnClass ?>"><div <?php echo $occurrence_search->likelihood->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_likelihood" id="z_likelihood" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $occurrence_search->likelihood->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $occurrence_search->likelihood->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $occurrence_search->likelihood->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $occurrence_search->likelihood->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $occurrence_search->likelihood->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $occurrence_search->likelihood->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $occurrence_search->likelihood->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $occurrence_search->likelihood->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $occurrence_search->likelihood->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $occurrence_search->likelihood->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $occurrence_search->likelihood->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $occurrence_search->likelihood->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $occurrence_search->likelihood->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_occurrence_likelihood" class="ew-search-field">
<input type="text" data-table="occurrence" data-field="x_likelihood" name="x_likelihood" id="x_likelihood" size="35" placeholder="<?php echo HtmlEncode($occurrence_search->likelihood->getPlaceHolder()) ?>" value="<?php echo $occurrence_search->likelihood->EditValue ?>"<?php echo $occurrence_search->likelihood->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_occurrence_likelihood" class="ew-search-field2 d-none">
<input type="text" data-table="occurrence" data-field="x_likelihood" name="y_likelihood" id="y_likelihood" size="35" placeholder="<?php echo HtmlEncode($occurrence_search->likelihood->getPlaceHolder()) ?>" value="<?php echo $occurrence_search->likelihood->EditValue2 ?>"<?php echo $occurrence_search->likelihood->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($occurrence_search->timebased->Visible) { // timebased ?>
	<div id="r_timebased" class="form-group row">
		<label for="x_timebased" class="<?php echo $occurrence_search->LeftColumnClass ?>"><span id="elh_occurrence_timebased"><?php echo $occurrence_search->timebased->caption() ?></span>
		</label>
		<div class="<?php echo $occurrence_search->RightColumnClass ?>"><div <?php echo $occurrence_search->timebased->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_timebased" id="z_timebased" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $occurrence_search->timebased->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $occurrence_search->timebased->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $occurrence_search->timebased->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $occurrence_search->timebased->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $occurrence_search->timebased->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $occurrence_search->timebased->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $occurrence_search->timebased->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $occurrence_search->timebased->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $occurrence_search->timebased->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $occurrence_search->timebased->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $occurrence_search->timebased->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $occurrence_search->timebased->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $occurrence_search->timebased->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_occurrence_timebased" class="ew-search-field">
<input type="text" data-table="occurrence" data-field="x_timebased" name="x_timebased" id="x_timebased" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($occurrence_search->timebased->getPlaceHolder()) ?>" value="<?php echo $occurrence_search->timebased->EditValue ?>"<?php echo $occurrence_search->timebased->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_occurrence_timebased" class="ew-search-field2 d-none">
<input type="text" data-table="occurrence" data-field="x_timebased" name="y_timebased" id="y_timebased" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($occurrence_search->timebased->getPlaceHolder()) ?>" value="<?php echo $occurrence_search->timebased->EditValue2 ?>"<?php echo $occurrence_search->timebased->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($occurrence_search->color->Visible) { // color ?>
	<div id="r_color" class="form-group row">
		<label for="x_color" class="<?php echo $occurrence_search->LeftColumnClass ?>"><span id="elh_occurrence_color"><?php echo $occurrence_search->color->caption() ?></span>
		</label>
		<div class="<?php echo $occurrence_search->RightColumnClass ?>"><div <?php echo $occurrence_search->color->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_color" id="z_color" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $occurrence_search->color->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $occurrence_search->color->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $occurrence_search->color->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $occurrence_search->color->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $occurrence_search->color->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $occurrence_search->color->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $occurrence_search->color->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $occurrence_search->color->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $occurrence_search->color->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $occurrence_search->color->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $occurrence_search->color->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $occurrence_search->color->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $occurrence_search->color->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_occurrence_color" class="ew-search-field">
<input type="text" data-table="occurrence" data-field="x_color" name="x_color" id="x_color" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($occurrence_search->color->getPlaceHolder()) ?>" value="<?php echo $occurrence_search->color->EditValue ?>"<?php echo $occurrence_search->color->editAttributes() ?>>

<script>
loadjs.ready("head", function() {
	jQuery("[id='x_color']:not([id*='$rowindex$'])").colorpicker({ format: "hex" });
});
</script>

</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_occurrence_color" class="ew-search-field2 d-none">
<input type="text" data-table="occurrence" data-field="x_color" name="y_color" id="y_color" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($occurrence_search->color->getPlaceHolder()) ?>" value="<?php echo $occurrence_search->color->EditValue2 ?>"<?php echo $occurrence_search->color->editAttributes() ?>>

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
<?php if (!$occurrence_search->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $occurrence_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("Search") ?></button>
<button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" onclick="ew.clearForm(this.form);"><?php echo $Language->phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$occurrence_search->showPageFooter();
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
$occurrence_search->terminate();
?>