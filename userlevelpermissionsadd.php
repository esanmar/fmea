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
$userlevelpermissions_add = new userlevelpermissions_add();

// Run the page
$userlevelpermissions_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$userlevelpermissions_add->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fuserlevelpermissionsadd, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "add";
	fuserlevelpermissionsadd = currentForm = new ew.Form("fuserlevelpermissionsadd", "add");

	// Validate form
	fuserlevelpermissionsadd.validate = function() {
		if (!this.validateRequired)
			return true; // Ignore validation
		var $ = jQuery, fobj = this.getForm(), $fobj = $(fobj);
		if ($fobj.find("#confirm").val() == "F")
			return true;
		var elm, felm, uelm, addcnt = 0;
		var $k = $fobj.find("#" + this.formKeyCountName); // Get key_count
		var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
		var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
		var gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
		for (var i = startcnt; i <= rowcnt; i++) {
			var infix = ($k[0]) ? String(i) : "";
			$fobj.data("rowindex", infix);
			<?php if ($userlevelpermissions_add->userlevelid->Required) { ?>
				elm = this.getElements("x" + infix + "_userlevelid");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userlevelpermissions_add->userlevelid->caption(), $userlevelpermissions_add->userlevelid->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_userlevelid");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($userlevelpermissions_add->userlevelid->errorMessage()) ?>");
			<?php if ($userlevelpermissions_add->_tablename->Required) { ?>
				elm = this.getElements("x" + infix + "__tablename");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userlevelpermissions_add->_tablename->caption(), $userlevelpermissions_add->_tablename->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($userlevelpermissions_add->permission->Required) { ?>
				elm = this.getElements("x" + infix + "_permission");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userlevelpermissions_add->permission->caption(), $userlevelpermissions_add->permission->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_permission");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($userlevelpermissions_add->permission->errorMessage()) ?>");

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
		}

		// Process detail forms
		var dfs = $fobj.find("input[name='detailpage']").get();
		for (var i = 0; i < dfs.length; i++) {
			var df = dfs[i], val = df.value;
			if (val && ew.forms[val])
				if (!ew.forms[val].validate())
					return false;
		}
		return true;
	}

	// Form_CustomValidate
	fuserlevelpermissionsadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fuserlevelpermissionsadd.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fuserlevelpermissionsadd");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $userlevelpermissions_add->showPageHeader(); ?>
<?php
$userlevelpermissions_add->showMessage();
?>
<form name="fuserlevelpermissionsadd" id="fuserlevelpermissionsadd" class="<?php echo $userlevelpermissions_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="userlevelpermissions">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$userlevelpermissions_add->IsModal ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($userlevelpermissions_add->userlevelid->Visible) { // userlevelid ?>
	<div id="r_userlevelid" class="form-group row">
		<label id="elh_userlevelpermissions_userlevelid" for="x_userlevelid" class="<?php echo $userlevelpermissions_add->LeftColumnClass ?>"><?php echo $userlevelpermissions_add->userlevelid->caption() ?><?php echo $userlevelpermissions_add->userlevelid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $userlevelpermissions_add->RightColumnClass ?>"><div <?php echo $userlevelpermissions_add->userlevelid->cellAttributes() ?>>
<span id="el_userlevelpermissions_userlevelid">
<input type="text" data-table="userlevelpermissions" data-field="x_userlevelid" name="x_userlevelid" id="x_userlevelid" size="30" placeholder="<?php echo HtmlEncode($userlevelpermissions_add->userlevelid->getPlaceHolder()) ?>" value="<?php echo $userlevelpermissions_add->userlevelid->EditValue ?>"<?php echo $userlevelpermissions_add->userlevelid->editAttributes() ?>>
</span>
<?php echo $userlevelpermissions_add->userlevelid->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($userlevelpermissions_add->_tablename->Visible) { // tablename ?>
	<div id="r__tablename" class="form-group row">
		<label id="elh_userlevelpermissions__tablename" for="x__tablename" class="<?php echo $userlevelpermissions_add->LeftColumnClass ?>"><?php echo $userlevelpermissions_add->_tablename->caption() ?><?php echo $userlevelpermissions_add->_tablename->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $userlevelpermissions_add->RightColumnClass ?>"><div <?php echo $userlevelpermissions_add->_tablename->cellAttributes() ?>>
<span id="el_userlevelpermissions__tablename">
<input type="text" data-table="userlevelpermissions" data-field="x__tablename" name="x__tablename" id="x__tablename" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($userlevelpermissions_add->_tablename->getPlaceHolder()) ?>" value="<?php echo $userlevelpermissions_add->_tablename->EditValue ?>"<?php echo $userlevelpermissions_add->_tablename->editAttributes() ?>>
</span>
<?php echo $userlevelpermissions_add->_tablename->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($userlevelpermissions_add->permission->Visible) { // permission ?>
	<div id="r_permission" class="form-group row">
		<label id="elh_userlevelpermissions_permission" for="x_permission" class="<?php echo $userlevelpermissions_add->LeftColumnClass ?>"><?php echo $userlevelpermissions_add->permission->caption() ?><?php echo $userlevelpermissions_add->permission->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $userlevelpermissions_add->RightColumnClass ?>"><div <?php echo $userlevelpermissions_add->permission->cellAttributes() ?>>
<span id="el_userlevelpermissions_permission">
<input type="text" data-table="userlevelpermissions" data-field="x_permission" name="x_permission" id="x_permission" size="30" placeholder="<?php echo HtmlEncode($userlevelpermissions_add->permission->getPlaceHolder()) ?>" value="<?php echo $userlevelpermissions_add->permission->EditValue ?>"<?php echo $userlevelpermissions_add->permission->editAttributes() ?>>
</span>
<?php echo $userlevelpermissions_add->permission->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$userlevelpermissions_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $userlevelpermissions_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $userlevelpermissions_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$userlevelpermissions_add->showPageFooter();
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
$userlevelpermissions_add->terminate();
?>