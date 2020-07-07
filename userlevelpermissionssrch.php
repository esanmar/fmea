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
$userlevelpermissions_search = new userlevelpermissions_search();

// Run the page
$userlevelpermissions_search->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$userlevelpermissions_search->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fuserlevelpermissionssearch, currentPageID;
loadjs.ready("head", function() {

	// Form object for search
	<?php if ($userlevelpermissions_search->IsModal) { ?>
	fuserlevelpermissionssearch = currentAdvancedSearchForm = new ew.Form("fuserlevelpermissionssearch", "search");
	<?php } else { ?>
	fuserlevelpermissionssearch = currentForm = new ew.Form("fuserlevelpermissionssearch", "search");
	<?php } ?>
	currentPageID = ew.PAGE_ID = "search";

	// Validate function for search
	fuserlevelpermissionssearch.validate = function(fobj) {
		if (!this.validateRequired)
			return true; // Ignore validation
		fobj = fobj || this._form;
		var infix = "";
		elm = this.getElements("x" + infix + "_userlevelid");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($userlevelpermissions_search->userlevelid->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_permission");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($userlevelpermissions_search->permission->errorMessage()) ?>");

		// Call Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
		return true;
	}

	// Form_CustomValidate
	fuserlevelpermissionssearch.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fuserlevelpermissionssearch.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fuserlevelpermissionssearch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $userlevelpermissions_search->showPageHeader(); ?>
<?php
$userlevelpermissions_search->showMessage();
?>
<form name="fuserlevelpermissionssearch" id="fuserlevelpermissionssearch" class="<?php echo $userlevelpermissions_search->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="userlevelpermissions">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?php echo (int)$userlevelpermissions_search->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($userlevelpermissions_search->userlevelid->Visible) { // userlevelid ?>
	<div id="r_userlevelid" class="form-group row">
		<label for="x_userlevelid" class="<?php echo $userlevelpermissions_search->LeftColumnClass ?>"><span id="elh_userlevelpermissions_userlevelid"><?php echo $userlevelpermissions_search->userlevelid->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("=") ?>
<input type="hidden" name="z_userlevelid" id="z_userlevelid" value="=">
</span>
		</label>
		<div class="<?php echo $userlevelpermissions_search->RightColumnClass ?>"><div <?php echo $userlevelpermissions_search->userlevelid->cellAttributes() ?>>
			<span id="el_userlevelpermissions_userlevelid" class="ew-search-field">
<input type="text" data-table="userlevelpermissions" data-field="x_userlevelid" name="x_userlevelid" id="x_userlevelid" size="30" placeholder="<?php echo HtmlEncode($userlevelpermissions_search->userlevelid->getPlaceHolder()) ?>" value="<?php echo $userlevelpermissions_search->userlevelid->EditValue ?>"<?php echo $userlevelpermissions_search->userlevelid->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($userlevelpermissions_search->_tablename->Visible) { // tablename ?>
	<div id="r__tablename" class="form-group row">
		<label for="x__tablename" class="<?php echo $userlevelpermissions_search->LeftColumnClass ?>"><span id="elh_userlevelpermissions__tablename"><?php echo $userlevelpermissions_search->_tablename->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("LIKE") ?>
<input type="hidden" name="z__tablename" id="z__tablename" value="LIKE">
</span>
		</label>
		<div class="<?php echo $userlevelpermissions_search->RightColumnClass ?>"><div <?php echo $userlevelpermissions_search->_tablename->cellAttributes() ?>>
			<span id="el_userlevelpermissions__tablename" class="ew-search-field">
<input type="text" data-table="userlevelpermissions" data-field="x__tablename" name="x__tablename" id="x__tablename" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($userlevelpermissions_search->_tablename->getPlaceHolder()) ?>" value="<?php echo $userlevelpermissions_search->_tablename->EditValue ?>"<?php echo $userlevelpermissions_search->_tablename->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($userlevelpermissions_search->permission->Visible) { // permission ?>
	<div id="r_permission" class="form-group row">
		<label for="x_permission" class="<?php echo $userlevelpermissions_search->LeftColumnClass ?>"><span id="elh_userlevelpermissions_permission"><?php echo $userlevelpermissions_search->permission->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("=") ?>
<input type="hidden" name="z_permission" id="z_permission" value="=">
</span>
		</label>
		<div class="<?php echo $userlevelpermissions_search->RightColumnClass ?>"><div <?php echo $userlevelpermissions_search->permission->cellAttributes() ?>>
			<span id="el_userlevelpermissions_permission" class="ew-search-field">
<input type="text" data-table="userlevelpermissions" data-field="x_permission" name="x_permission" id="x_permission" size="30" placeholder="<?php echo HtmlEncode($userlevelpermissions_search->permission->getPlaceHolder()) ?>" value="<?php echo $userlevelpermissions_search->permission->EditValue ?>"<?php echo $userlevelpermissions_search->permission->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$userlevelpermissions_search->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $userlevelpermissions_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("Search") ?></button>
<button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" onclick="ew.clearForm(this.form);"><?php echo $Language->phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$userlevelpermissions_search->showPageFooter();
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
$userlevelpermissions_search->terminate();
?>