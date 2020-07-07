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
$detection_search = new detection_search();

// Run the page
$detection_search->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$detection_search->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fdetectionsearch, currentPageID;
loadjs.ready("head", function() {

	// Form object for search
	<?php if ($detection_search->IsModal) { ?>
	fdetectionsearch = currentAdvancedSearchForm = new ew.Form("fdetectionsearch", "search");
	<?php } else { ?>
	fdetectionsearch = currentForm = new ew.Form("fdetectionsearch", "search");
	<?php } ?>
	currentPageID = ew.PAGE_ID = "search";

	// Validate function for search
	fdetectionsearch.validate = function(fobj) {
		if (!this.validateRequired)
			return true; // Ignore validation
		fobj = fobj || this._form;
		var infix = "";
		elm = this.getElements("x" + infix + "_idDetection");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($detection_search->idDetection->errorMessage()) ?>");

		// Call Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
		return true;
	}

	// Form_CustomValidate
	fdetectionsearch.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fdetectionsearch.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fdetectionsearch.lists["x_errorProofed[]"] = <?php echo $detection_search->errorProofed->Lookup->toClientList($detection_search) ?>;
	fdetectionsearch.lists["x_errorProofed[]"].options = <?php echo JsonEncode($detection_search->errorProofed->options(FALSE, TRUE)) ?>;
	fdetectionsearch.lists["x_gonogo[]"] = <?php echo $detection_search->gonogo->Lookup->toClientList($detection_search) ?>;
	fdetectionsearch.lists["x_gonogo[]"].options = <?php echo JsonEncode($detection_search->gonogo->options(FALSE, TRUE)) ?>;
	fdetectionsearch.lists["x_visualInspection[]"] = <?php echo $detection_search->visualInspection->Lookup->toClientList($detection_search) ?>;
	fdetectionsearch.lists["x_visualInspection[]"].options = <?php echo JsonEncode($detection_search->visualInspection->options(FALSE, TRUE)) ?>;
	loadjs.done("fdetectionsearch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $detection_search->showPageHeader(); ?>
<?php
$detection_search->showMessage();
?>
<form name="fdetectionsearch" id="fdetectionsearch" class="<?php echo $detection_search->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="detection">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?php echo (int)$detection_search->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($detection_search->idDetection->Visible) { // idDetection ?>
	<div id="r_idDetection" class="form-group row">
		<label for="x_idDetection" class="<?php echo $detection_search->LeftColumnClass ?>"><span id="elh_detection_idDetection"><?php echo $detection_search->idDetection->caption() ?></span>
		</label>
		<div class="<?php echo $detection_search->RightColumnClass ?>"><div <?php echo $detection_search->idDetection->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_idDetection" id="z_idDetection" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $detection_search->idDetection->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $detection_search->idDetection->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $detection_search->idDetection->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $detection_search->idDetection->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $detection_search->idDetection->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $detection_search->idDetection->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="IS NULL"<?php echo $detection_search->idDetection->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $detection_search->idDetection->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $detection_search->idDetection->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_detection_idDetection" class="ew-search-field">
<input type="text" data-table="detection" data-field="x_idDetection" name="x_idDetection" id="x_idDetection" placeholder="<?php echo HtmlEncode($detection_search->idDetection->getPlaceHolder()) ?>" value="<?php echo $detection_search->idDetection->EditValue ?>"<?php echo $detection_search->idDetection->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_detection_idDetection" class="ew-search-field2 d-none">
<input type="text" data-table="detection" data-field="x_idDetection" name="y_idDetection" id="y_idDetection" placeholder="<?php echo HtmlEncode($detection_search->idDetection->getPlaceHolder()) ?>" value="<?php echo $detection_search->idDetection->EditValue2 ?>"<?php echo $detection_search->idDetection->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($detection_search->detection->Visible) { // detection ?>
	<div id="r_detection" class="form-group row">
		<label for="x_detection" class="<?php echo $detection_search->LeftColumnClass ?>"><span id="elh_detection_detection"><?php echo $detection_search->detection->caption() ?></span>
		</label>
		<div class="<?php echo $detection_search->RightColumnClass ?>"><div <?php echo $detection_search->detection->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_detection" id="z_detection" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $detection_search->detection->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $detection_search->detection->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $detection_search->detection->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $detection_search->detection->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $detection_search->detection->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $detection_search->detection->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $detection_search->detection->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $detection_search->detection->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $detection_search->detection->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $detection_search->detection->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="BETWEEN"<?php echo $detection_search->detection->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_detection_detection" class="ew-search-field">
<input type="text" data-table="detection" data-field="x_detection" name="x_detection" id="x_detection" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($detection_search->detection->getPlaceHolder()) ?>" value="<?php echo $detection_search->detection->EditValue ?>"<?php echo $detection_search->detection->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_detection_detection" class="ew-search-field2 d-none">
<input type="text" data-table="detection" data-field="x_detection" name="y_detection" id="y_detection" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($detection_search->detection->getPlaceHolder()) ?>" value="<?php echo $detection_search->detection->EditValue2 ?>"<?php echo $detection_search->detection->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($detection_search->description->Visible) { // description ?>
	<div id="r_description" class="form-group row">
		<label for="x_description" class="<?php echo $detection_search->LeftColumnClass ?>"><span id="elh_detection_description"><?php echo $detection_search->description->caption() ?></span>
		</label>
		<div class="<?php echo $detection_search->RightColumnClass ?>"><div <?php echo $detection_search->description->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_description" id="z_description" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $detection_search->description->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $detection_search->description->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $detection_search->description->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $detection_search->description->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $detection_search->description->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $detection_search->description->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $detection_search->description->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $detection_search->description->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $detection_search->description->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $detection_search->description->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $detection_search->description->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $detection_search->description->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $detection_search->description->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_detection_description" class="ew-search-field">
<input type="text" data-table="detection" data-field="x_description" name="x_description" id="x_description" size="35" placeholder="<?php echo HtmlEncode($detection_search->description->getPlaceHolder()) ?>" value="<?php echo $detection_search->description->EditValue ?>"<?php echo $detection_search->description->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_detection_description" class="ew-search-field2 d-none">
<input type="text" data-table="detection" data-field="x_description" name="y_description" id="y_description" size="35" placeholder="<?php echo HtmlEncode($detection_search->description->getPlaceHolder()) ?>" value="<?php echo $detection_search->description->EditValue2 ?>"<?php echo $detection_search->description->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($detection_search->methods->Visible) { // methods ?>
	<div id="r_methods" class="form-group row">
		<label for="x_methods" class="<?php echo $detection_search->LeftColumnClass ?>"><span id="elh_detection_methods"><?php echo $detection_search->methods->caption() ?></span>
		</label>
		<div class="<?php echo $detection_search->RightColumnClass ?>"><div <?php echo $detection_search->methods->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_methods" id="z_methods" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $detection_search->methods->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $detection_search->methods->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $detection_search->methods->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $detection_search->methods->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $detection_search->methods->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $detection_search->methods->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $detection_search->methods->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $detection_search->methods->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $detection_search->methods->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $detection_search->methods->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $detection_search->methods->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $detection_search->methods->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $detection_search->methods->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_detection_methods" class="ew-search-field">
<input type="text" data-table="detection" data-field="x_methods" name="x_methods" id="x_methods" size="35" placeholder="<?php echo HtmlEncode($detection_search->methods->getPlaceHolder()) ?>" value="<?php echo $detection_search->methods->EditValue ?>"<?php echo $detection_search->methods->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_detection_methods" class="ew-search-field2 d-none">
<input type="text" data-table="detection" data-field="x_methods" name="y_methods" id="y_methods" size="35" placeholder="<?php echo HtmlEncode($detection_search->methods->getPlaceHolder()) ?>" value="<?php echo $detection_search->methods->EditValue2 ?>"<?php echo $detection_search->methods->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($detection_search->errorProofed->Visible) { // errorProofed ?>
	<div id="r_errorProofed" class="form-group row">
		<label class="<?php echo $detection_search->LeftColumnClass ?>"><span id="elh_detection_errorProofed"><?php echo $detection_search->errorProofed->caption() ?></span>
		</label>
		<div class="<?php echo $detection_search->RightColumnClass ?>"><div <?php echo $detection_search->errorProofed->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_errorProofed" id="z_errorProofed" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $detection_search->errorProofed->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $detection_search->errorProofed->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $detection_search->errorProofed->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $detection_search->errorProofed->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $detection_search->errorProofed->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $detection_search->errorProofed->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $detection_search->errorProofed->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $detection_search->errorProofed->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $detection_search->errorProofed->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $detection_search->errorProofed->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $detection_search->errorProofed->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $detection_search->errorProofed->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $detection_search->errorProofed->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_detection_errorProofed" class="ew-search-field">
<?php
$selwrk = ConvertToBool($detection_search->errorProofed->AdvancedSearch->SearchValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="detection" data-field="x_errorProofed" name="x_errorProofed[]" id="x_errorProofed[]" value="1"<?php echo $selwrk ?><?php echo $detection_search->errorProofed->editAttributes() ?>>
	<label class="custom-control-label" for="x_errorProofed[]"></label>
</div>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_detection_errorProofed" class="ew-search-field2 d-none">
<?php
$selwrk = ConvertToBool($detection_search->errorProofed->AdvancedSearch->SearchValue2) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="detection" data-field="x_errorProofed" name="y_errorProofed[]" id="y_errorProofed[]" value="1"<?php echo $selwrk ?><?php echo $detection_search->errorProofed->editAttributes() ?>>
	<label class="custom-control-label" for="y_errorProofed[]"></label>
</div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($detection_search->gonogo->Visible) { // gonogo ?>
	<div id="r_gonogo" class="form-group row">
		<label class="<?php echo $detection_search->LeftColumnClass ?>"><span id="elh_detection_gonogo"><?php echo $detection_search->gonogo->caption() ?></span>
		</label>
		<div class="<?php echo $detection_search->RightColumnClass ?>"><div <?php echo $detection_search->gonogo->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_gonogo" id="z_gonogo" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $detection_search->gonogo->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $detection_search->gonogo->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $detection_search->gonogo->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $detection_search->gonogo->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $detection_search->gonogo->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $detection_search->gonogo->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $detection_search->gonogo->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $detection_search->gonogo->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $detection_search->gonogo->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $detection_search->gonogo->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $detection_search->gonogo->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $detection_search->gonogo->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $detection_search->gonogo->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_detection_gonogo" class="ew-search-field">
<?php
$selwrk = ConvertToBool($detection_search->gonogo->AdvancedSearch->SearchValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="detection" data-field="x_gonogo" name="x_gonogo[]" id="x_gonogo[]" value="1"<?php echo $selwrk ?><?php echo $detection_search->gonogo->editAttributes() ?>>
	<label class="custom-control-label" for="x_gonogo[]"></label>
</div>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_detection_gonogo" class="ew-search-field2 d-none">
<?php
$selwrk = ConvertToBool($detection_search->gonogo->AdvancedSearch->SearchValue2) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="detection" data-field="x_gonogo" name="y_gonogo[]" id="y_gonogo[]" value="1"<?php echo $selwrk ?><?php echo $detection_search->gonogo->editAttributes() ?>>
	<label class="custom-control-label" for="y_gonogo[]"></label>
</div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($detection_search->visualInspection->Visible) { // visualInspection ?>
	<div id="r_visualInspection" class="form-group row">
		<label class="<?php echo $detection_search->LeftColumnClass ?>"><span id="elh_detection_visualInspection"><?php echo $detection_search->visualInspection->caption() ?></span>
		</label>
		<div class="<?php echo $detection_search->RightColumnClass ?>"><div <?php echo $detection_search->visualInspection->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_visualInspection" id="z_visualInspection" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $detection_search->visualInspection->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $detection_search->visualInspection->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $detection_search->visualInspection->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $detection_search->visualInspection->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $detection_search->visualInspection->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $detection_search->visualInspection->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $detection_search->visualInspection->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $detection_search->visualInspection->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $detection_search->visualInspection->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $detection_search->visualInspection->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $detection_search->visualInspection->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $detection_search->visualInspection->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $detection_search->visualInspection->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_detection_visualInspection" class="ew-search-field">
<?php
$selwrk = ConvertToBool($detection_search->visualInspection->AdvancedSearch->SearchValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="detection" data-field="x_visualInspection" name="x_visualInspection[]" id="x_visualInspection[]" value="1"<?php echo $selwrk ?><?php echo $detection_search->visualInspection->editAttributes() ?>>
	<label class="custom-control-label" for="x_visualInspection[]"></label>
</div>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_detection_visualInspection" class="ew-search-field2 d-none">
<?php
$selwrk = ConvertToBool($detection_search->visualInspection->AdvancedSearch->SearchValue2) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="detection" data-field="x_visualInspection" name="y_visualInspection[]" id="y_visualInspection[]" value="1"<?php echo $selwrk ?><?php echo $detection_search->visualInspection->editAttributes() ?>>
	<label class="custom-control-label" for="y_visualInspection[]"></label>
</div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($detection_search->color->Visible) { // color ?>
	<div id="r_color" class="form-group row">
		<label for="x_color" class="<?php echo $detection_search->LeftColumnClass ?>"><span id="elh_detection_color"><?php echo $detection_search->color->caption() ?></span>
		</label>
		<div class="<?php echo $detection_search->RightColumnClass ?>"><div <?php echo $detection_search->color->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_color" id="z_color" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $detection_search->color->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $detection_search->color->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $detection_search->color->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $detection_search->color->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $detection_search->color->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $detection_search->color->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $detection_search->color->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $detection_search->color->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $detection_search->color->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $detection_search->color->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $detection_search->color->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $detection_search->color->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $detection_search->color->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_detection_color" class="ew-search-field">
<input type="text" data-table="detection" data-field="x_color" name="x_color" id="x_color" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($detection_search->color->getPlaceHolder()) ?>" value="<?php echo $detection_search->color->EditValue ?>"<?php echo $detection_search->color->editAttributes() ?>>

<script>
loadjs.ready("head", function() {
	jQuery("[id='x_color']:not([id*='$rowindex$'])").colorpicker({ format: "hex" });
});
</script>

</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_detection_color" class="ew-search-field2 d-none">
<input type="text" data-table="detection" data-field="x_color" name="y_color" id="y_color" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($detection_search->color->getPlaceHolder()) ?>" value="<?php echo $detection_search->color->EditValue2 ?>"<?php echo $detection_search->color->editAttributes() ?>>

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
<?php if (!$detection_search->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $detection_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("Search") ?></button>
<button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" onclick="ew.clearForm(this.form);"><?php echo $Language->phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$detection_search->showPageFooter();
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
$detection_search->terminate();
?>