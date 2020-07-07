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
$userlevels_search = new userlevels_search();

// Run the page
$userlevels_search->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$userlevels_search->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fuserlevelssearch, currentPageID;
loadjs.ready("head", function() {

	// Form object for search
	<?php if ($userlevels_search->IsModal) { ?>
	fuserlevelssearch = currentAdvancedSearchForm = new ew.Form("fuserlevelssearch", "search");
	<?php } else { ?>
	fuserlevelssearch = currentForm = new ew.Form("fuserlevelssearch", "search");
	<?php } ?>
	currentPageID = ew.PAGE_ID = "search";

	// Validate function for search
	fuserlevelssearch.validate = function(fobj) {
		if (!this.validateRequired)
			return true; // Ignore validation
		fobj = fobj || this._form;
		var infix = "";
		elm = this.getElements("x" + infix + "_userlevelid");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($userlevels_search->userlevelid->errorMessage()) ?>");

		// Call Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
		return true;
	}

	// Form_CustomValidate
	fuserlevelssearch.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fuserlevelssearch.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fuserlevelssearch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $userlevels_search->showPageHeader(); ?>
<?php
$userlevels_search->showMessage();
?>
<form name="fuserlevelssearch" id="fuserlevelssearch" class="<?php echo $userlevels_search->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="userlevels">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?php echo (int)$userlevels_search->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($userlevels_search->userlevelid->Visible) { // userlevelid ?>
	<div id="r_userlevelid" class="form-group row">
		<label for="x_userlevelid" class="<?php echo $userlevels_search->LeftColumnClass ?>"><span id="elh_userlevels_userlevelid"><?php echo $userlevels_search->userlevelid->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("=") ?>
<input type="hidden" name="z_userlevelid" id="z_userlevelid" value="=">
</span>
		</label>
		<div class="<?php echo $userlevels_search->RightColumnClass ?>"><div <?php echo $userlevels_search->userlevelid->cellAttributes() ?>>
			<span id="el_userlevels_userlevelid" class="ew-search-field">
<input type="text" data-table="userlevels" data-field="x_userlevelid" name="x_userlevelid" id="x_userlevelid" size="30" placeholder="<?php echo HtmlEncode($userlevels_search->userlevelid->getPlaceHolder()) ?>" value="<?php echo $userlevels_search->userlevelid->EditValue ?>"<?php echo $userlevels_search->userlevelid->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($userlevels_search->userlevelname->Visible) { // userlevelname ?>
	<div id="r_userlevelname" class="form-group row">
		<label for="x_userlevelname" class="<?php echo $userlevels_search->LeftColumnClass ?>"><span id="elh_userlevels_userlevelname"><?php echo $userlevels_search->userlevelname->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("LIKE") ?>
<input type="hidden" name="z_userlevelname" id="z_userlevelname" value="LIKE">
</span>
		</label>
		<div class="<?php echo $userlevels_search->RightColumnClass ?>"><div <?php echo $userlevels_search->userlevelname->cellAttributes() ?>>
			<span id="el_userlevels_userlevelname" class="ew-search-field">
<input type="text" data-table="userlevels" data-field="x_userlevelname" name="x_userlevelname" id="x_userlevelname" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($userlevels_search->userlevelname->getPlaceHolder()) ?>" value="<?php echo $userlevels_search->userlevelname->EditValue ?>"<?php echo $userlevels_search->userlevelname->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$userlevels_search->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $userlevels_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("Search") ?></button>
<button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" onclick="ew.clearForm(this.form);"><?php echo $Language->phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$userlevels_search->showPageFooter();
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
$userlevels_search->terminate();
?>