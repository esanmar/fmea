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
$causes_search = new causes_search();

// Run the page
$causes_search->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$causes_search->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fcausessearch, currentPageID;
loadjs.ready("head", function() {

	// Form object for search
	<?php if ($causes_search->IsModal) { ?>
	fcausessearch = currentAdvancedSearchForm = new ew.Form("fcausessearch", "search");
	<?php } else { ?>
	fcausessearch = currentForm = new ew.Form("fcausessearch", "search");
	<?php } ?>
	currentPageID = ew.PAGE_ID = "search";

	// Validate function for search
	fcausessearch.validate = function(fobj) {
		if (!this.validateRequired)
			return true; // Ignore validation
		fobj = fobj || this._form;
		var infix = "";
		elm = this.getElements("x" + infix + "_idCause");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($causes_search->idCause->errorMessage()) ?>");

		// Call Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
		return true;
	}

	// Form_CustomValidate
	fcausessearch.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fcausessearch.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fcausessearch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $causes_search->showPageHeader(); ?>
<?php
$causes_search->showMessage();
?>
<form name="fcausessearch" id="fcausessearch" class="<?php echo $causes_search->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="causes">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?php echo (int)$causes_search->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($causes_search->idCause->Visible) { // idCause ?>
	<div id="r_idCause" class="form-group row">
		<label for="x_idCause" class="<?php echo $causes_search->LeftColumnClass ?>"><span id="elh_causes_idCause"><?php echo $causes_search->idCause->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("=") ?>
<input type="hidden" name="z_idCause" id="z_idCause" value="=">
</span>
		</label>
		<div class="<?php echo $causes_search->RightColumnClass ?>"><div <?php echo $causes_search->idCause->cellAttributes() ?>>
			<span id="el_causes_idCause" class="ew-search-field">
<input type="text" data-table="causes" data-field="x_idCause" name="x_idCause" id="x_idCause" placeholder="<?php echo HtmlEncode($causes_search->idCause->getPlaceHolder()) ?>" value="<?php echo $causes_search->idCause->EditValue ?>"<?php echo $causes_search->idCause->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($causes_search->cause->Visible) { // cause ?>
	<div id="r_cause" class="form-group row">
		<label for="x_cause" class="<?php echo $causes_search->LeftColumnClass ?>"><span id="elh_causes_cause"><?php echo $causes_search->cause->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("LIKE") ?>
<input type="hidden" name="z_cause" id="z_cause" value="LIKE">
</span>
		</label>
		<div class="<?php echo $causes_search->RightColumnClass ?>"><div <?php echo $causes_search->cause->cellAttributes() ?>>
			<span id="el_causes_cause" class="ew-search-field">
<input type="text" data-table="causes" data-field="x_cause" name="x_cause" id="x_cause" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($causes_search->cause->getPlaceHolder()) ?>" value="<?php echo $causes_search->cause->EditValue ?>"<?php echo $causes_search->cause->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$causes_search->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $causes_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("Search") ?></button>
<button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" onclick="ew.clearForm(this.form);"><?php echo $Language->phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$causes_search->showPageFooter();
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
$causes_search->terminate();
?>