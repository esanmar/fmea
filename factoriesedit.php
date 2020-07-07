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
$factories_edit = new factories_edit();

// Run the page
$factories_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$factories_edit->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var ffactoriesedit, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "edit";
	ffactoriesedit = currentForm = new ew.Form("ffactoriesedit", "edit");

	// Validate form
	ffactoriesedit.validate = function() {
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
			<?php if ($factories_edit->idFactory->Required) { ?>
				elm = this.getElements("x" + infix + "_idFactory");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $factories_edit->idFactory->caption(), $factories_edit->idFactory->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_idFactory");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($factories_edit->idFactory->errorMessage()) ?>");
			<?php if ($factories_edit->factory->Required) { ?>
				elm = this.getElements("x" + infix + "_factory");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $factories_edit->factory->caption(), $factories_edit->factory->RequiredErrorMessage)) ?>");
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
	ffactoriesedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	ffactoriesedit.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("ffactoriesedit");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $factories_edit->showPageHeader(); ?>
<?php
$factories_edit->showMessage();
?>
<?php if (!$factories_edit->IsModal) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $factories_edit->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="ffactoriesedit" id="ffactoriesedit" class="<?php echo $factories_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="factories">
<input type="hidden" name="k_hash" id="k_hash" value="<?php echo $factories_edit->HashValue ?>">
<?php if ($factories->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="conflict" id="conflict" value="1">
<?php } ?>
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$factories_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($factories_edit->idFactory->Visible) { // idFactory ?>
	<div id="r_idFactory" class="form-group row">
		<label id="elh_factories_idFactory" for="x_idFactory" class="<?php echo $factories_edit->LeftColumnClass ?>"><?php echo $factories_edit->idFactory->caption() ?><?php echo $factories_edit->idFactory->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $factories_edit->RightColumnClass ?>"><div <?php echo $factories_edit->idFactory->cellAttributes() ?>>
<input type="text" data-table="factories" data-field="x_idFactory" name="x_idFactory" id="x_idFactory" placeholder="<?php echo HtmlEncode($factories_edit->idFactory->getPlaceHolder()) ?>" value="<?php echo $factories_edit->idFactory->EditValue ?>"<?php echo $factories_edit->idFactory->editAttributes() ?>>
<input type="hidden" data-table="factories" data-field="x_idFactory" name="o_idFactory" id="o_idFactory" value="<?php echo HtmlEncode($factories_edit->idFactory->OldValue != null ? $factories_edit->idFactory->OldValue : $factories_edit->idFactory->CurrentValue) ?>">
<?php echo $factories_edit->idFactory->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($factories_edit->factory->Visible) { // factory ?>
	<div id="r_factory" class="form-group row">
		<label id="elh_factories_factory" for="x_factory" class="<?php echo $factories_edit->LeftColumnClass ?>"><?php echo $factories_edit->factory->caption() ?><?php echo $factories_edit->factory->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $factories_edit->RightColumnClass ?>"><div <?php echo $factories_edit->factory->cellAttributes() ?>>
<span id="el_factories_factory">
<input type="text" data-table="factories" data-field="x_factory" name="x_factory" id="x_factory" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($factories_edit->factory->getPlaceHolder()) ?>" value="<?php echo $factories_edit->factory->EditValue ?>"<?php echo $factories_edit->factory->editAttributes() ?>>
</span>
<?php echo $factories_edit->factory->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$factories_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $factories_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($factories->UpdateConflict == "U") { // Record already updated by other user ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" onclick="this.form.action.value='overwrite';"><?php echo $Language->phrase("OverwriteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-reload" id="btn-reload" type="submit" onclick="this.form.action.value='show';"><?php echo $Language->phrase("ReloadBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $factories_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
<?php } ?>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$factories_edit->IsModal) { ?>
<?php echo $factories_edit->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<?php
$factories_edit->showPageFooter();
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
$factories_edit->terminate();
?>