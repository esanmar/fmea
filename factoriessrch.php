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
$factories_search = new factories_search();

// Run the page
$factories_search->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$factories_search->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var ffactoriessearch, currentPageID;
loadjs.ready("head", function() {

	// Form object for search
	<?php if ($factories_search->IsModal) { ?>
	ffactoriessearch = currentAdvancedSearchForm = new ew.Form("ffactoriessearch", "search");
	<?php } else { ?>
	ffactoriessearch = currentForm = new ew.Form("ffactoriessearch", "search");
	<?php } ?>
	currentPageID = ew.PAGE_ID = "search";

	// Validate function for search
	ffactoriessearch.validate = function(fobj) {
		if (!this.validateRequired)
			return true; // Ignore validation
		fobj = fobj || this._form;
		var infix = "";
		elm = this.getElements("x" + infix + "_idFactory");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($factories_search->idFactory->errorMessage()) ?>");

		// Call Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
		return true;
	}

	// Form_CustomValidate
	ffactoriessearch.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	ffactoriessearch.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("ffactoriessearch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $factories_search->showPageHeader(); ?>
<?php
$factories_search->showMessage();
?>
<form name="ffactoriessearch" id="ffactoriessearch" class="<?php echo $factories_search->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="factories">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?php echo (int)$factories_search->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($factories_search->idFactory->Visible) { // idFactory ?>
	<div id="r_idFactory" class="form-group row">
		<label for="x_idFactory" class="<?php echo $factories_search->LeftColumnClass ?>"><span id="elh_factories_idFactory"><?php echo $factories_search->idFactory->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("=") ?>
<input type="hidden" name="z_idFactory" id="z_idFactory" value="=">
</span>
		</label>
		<div class="<?php echo $factories_search->RightColumnClass ?>"><div <?php echo $factories_search->idFactory->cellAttributes() ?>>
			<span id="el_factories_idFactory" class="ew-search-field">
<input type="text" data-table="factories" data-field="x_idFactory" name="x_idFactory" id="x_idFactory" placeholder="<?php echo HtmlEncode($factories_search->idFactory->getPlaceHolder()) ?>" value="<?php echo $factories_search->idFactory->EditValue ?>"<?php echo $factories_search->idFactory->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($factories_search->factory->Visible) { // factory ?>
	<div id="r_factory" class="form-group row">
		<label for="x_factory" class="<?php echo $factories_search->LeftColumnClass ?>"><span id="elh_factories_factory"><?php echo $factories_search->factory->caption() ?></span>
		</label>
		<div class="<?php echo $factories_search->RightColumnClass ?>"><div <?php echo $factories_search->factory->cellAttributes() ?>>
		<span class="ew-search-operator">
<select name="z_factory" id="z_factory" class="custom-select" onchange="ew.searchOperatorChanged(this);">
<option value="="<?php echo $factories_search->factory->AdvancedSearch->SearchOperator == "=" ? " selected" : "" ?>><?php echo $Language->phrase("EQUAL") ?></option>
<option value="<>"<?php echo $factories_search->factory->AdvancedSearch->SearchOperator == "<>" ? " selected" : "" ?>><?php echo $Language->phrase("<>") ?></option>
<option value="<"<?php echo $factories_search->factory->AdvancedSearch->SearchOperator == "<" ? " selected" : "" ?>><?php echo $Language->phrase("<") ?></option>
<option value="<="<?php echo $factories_search->factory->AdvancedSearch->SearchOperator == "<=" ? " selected" : "" ?>><?php echo $Language->phrase("<=") ?></option>
<option value=">"<?php echo $factories_search->factory->AdvancedSearch->SearchOperator == ">" ? " selected" : "" ?>><?php echo $Language->phrase(">") ?></option>
<option value=">="<?php echo $factories_search->factory->AdvancedSearch->SearchOperator == ">=" ? " selected" : "" ?>><?php echo $Language->phrase(">=") ?></option>
<option value="LIKE"<?php echo $factories_search->factory->AdvancedSearch->SearchOperator == "LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("LIKE") ?></option>
<option value="NOT LIKE"<?php echo $factories_search->factory->AdvancedSearch->SearchOperator == "NOT LIKE" ? " selected" : "" ?>><?php echo $Language->phrase("NOT LIKE") ?></option>
<option value="STARTS WITH"<?php echo $factories_search->factory->AdvancedSearch->SearchOperator == "STARTS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("STARTS WITH") ?></option>
<option value="ENDS WITH"<?php echo $factories_search->factory->AdvancedSearch->SearchOperator == "ENDS WITH" ? " selected" : "" ?>><?php echo $Language->phrase("ENDS WITH") ?></option>
<option value="IS NULL"<?php echo $factories_search->factory->AdvancedSearch->SearchOperator == "IS NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NULL") ?></option>
<option value="IS NOT NULL"<?php echo $factories_search->factory->AdvancedSearch->SearchOperator == "IS NOT NULL" ? " selected" : "" ?>><?php echo $Language->phrase("IS NOT NULL") ?></option>
<option value="BETWEEN"<?php echo $factories_search->factory->AdvancedSearch->SearchOperator == "BETWEEN" ? " selected" : "" ?>><?php echo $Language->phrase("BETWEEN") ?></option>
</select>
</span>
			<span id="el_factories_factory" class="ew-search-field">
<input type="text" data-table="factories" data-field="x_factory" name="x_factory" id="x_factory" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($factories_search->factory->getPlaceHolder()) ?>" value="<?php echo $factories_search->factory->EditValue ?>"<?php echo $factories_search->factory->editAttributes() ?>>
</span>
			<span class="ew-search-and d-none"><label><?php echo $Language->phrase("AND") ?></label></span>
			<span id="el2_factories_factory" class="ew-search-field2 d-none">
<input type="text" data-table="factories" data-field="x_factory" name="y_factory" id="y_factory" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($factories_search->factory->getPlaceHolder()) ?>" value="<?php echo $factories_search->factory->EditValue2 ?>"<?php echo $factories_search->factory->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$factories_search->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $factories_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("Search") ?></button>
<button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" onclick="ew.clearForm(this.form);"><?php echo $Language->phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$factories_search->showPageFooter();
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
$factories_search->terminate();
?>