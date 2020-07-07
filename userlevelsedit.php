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
$userlevels_edit = new userlevels_edit();

// Run the page
$userlevels_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$userlevels_edit->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fuserlevelsedit, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "edit";
	fuserlevelsedit = currentForm = new ew.Form("fuserlevelsedit", "edit");

	// Validate form
	fuserlevelsedit.validate = function() {
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
			<?php if ($userlevels_edit->userlevelid->Required) { ?>
				elm = this.getElements("x" + infix + "_userlevelid");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userlevels_edit->userlevelid->caption(), $userlevels_edit->userlevelid->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_userlevelid");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($userlevels_edit->userlevelid->errorMessage()) ?>");
			<?php if ($userlevels_edit->userlevelname->Required) { ?>
				elm = this.getElements("x" + infix + "_userlevelname");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userlevels_edit->userlevelname->caption(), $userlevels_edit->userlevelname->RequiredErrorMessage)) ?>");
			<?php } ?>

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
	fuserlevelsedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fuserlevelsedit.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fuserlevelsedit");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $userlevels_edit->showPageHeader(); ?>
<?php
$userlevels_edit->showMessage();
?>
<?php if (!$userlevels_edit->IsModal) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $userlevels_edit->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fuserlevelsedit" id="fuserlevelsedit" class="<?php echo $userlevels_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="userlevels">
<input type="hidden" name="k_hash" id="k_hash" value="<?php echo $userlevels_edit->HashValue ?>">
<?php if ($userlevels->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="conflict" id="conflict" value="1">
<?php } ?>
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$userlevels_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($userlevels_edit->userlevelid->Visible) { // userlevelid ?>
	<div id="r_userlevelid" class="form-group row">
		<label id="elh_userlevels_userlevelid" for="x_userlevelid" class="<?php echo $userlevels_edit->LeftColumnClass ?>"><?php echo $userlevels_edit->userlevelid->caption() ?><?php echo $userlevels_edit->userlevelid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $userlevels_edit->RightColumnClass ?>"><div <?php echo $userlevels_edit->userlevelid->cellAttributes() ?>>
<input type="text" data-table="userlevels" data-field="x_userlevelid" name="x_userlevelid" id="x_userlevelid" size="30" placeholder="<?php echo HtmlEncode($userlevels_edit->userlevelid->getPlaceHolder()) ?>" value="<?php echo $userlevels_edit->userlevelid->EditValue ?>"<?php echo $userlevels_edit->userlevelid->editAttributes() ?>>
<input type="hidden" data-table="userlevels" data-field="x_userlevelid" name="o_userlevelid" id="o_userlevelid" value="<?php echo HtmlEncode($userlevels_edit->userlevelid->OldValue != null ? $userlevels_edit->userlevelid->OldValue : $userlevels_edit->userlevelid->CurrentValue) ?>">
<?php echo $userlevels_edit->userlevelid->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($userlevels_edit->userlevelname->Visible) { // userlevelname ?>
	<div id="r_userlevelname" class="form-group row">
		<label id="elh_userlevels_userlevelname" for="x_userlevelname" class="<?php echo $userlevels_edit->LeftColumnClass ?>"><?php echo $userlevels_edit->userlevelname->caption() ?><?php echo $userlevels_edit->userlevelname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $userlevels_edit->RightColumnClass ?>"><div <?php echo $userlevels_edit->userlevelname->cellAttributes() ?>>
<span id="el_userlevels_userlevelname">
<input type="text" data-table="userlevels" data-field="x_userlevelname" name="x_userlevelname" id="x_userlevelname" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($userlevels_edit->userlevelname->getPlaceHolder()) ?>" value="<?php echo $userlevels_edit->userlevelname->EditValue ?>"<?php echo $userlevels_edit->userlevelname->editAttributes() ?>>
</span>
<?php echo $userlevels_edit->userlevelname->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$userlevels_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $userlevels_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($userlevels->UpdateConflict == "U") { // Record already updated by other user ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" onclick="this.form.action.value='overwrite';"><?php echo $Language->phrase("OverwriteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-reload" id="btn-reload" type="submit" onclick="this.form.action.value='show';"><?php echo $Language->phrase("ReloadBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $userlevels_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
<?php } ?>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$userlevels_edit->IsModal) { ?>
<?php echo $userlevels_edit->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<?php
$userlevels_edit->showPageFooter();
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
$userlevels_edit->terminate();
?>