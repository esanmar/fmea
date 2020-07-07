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
$causes_edit = new causes_edit();

// Run the page
$causes_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$causes_edit->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fcausesedit, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "edit";
	fcausesedit = currentForm = new ew.Form("fcausesedit", "edit");

	// Validate form
	fcausesedit.validate = function() {
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
			<?php if ($causes_edit->idCause->Required) { ?>
				elm = this.getElements("x" + infix + "_idCause");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $causes_edit->idCause->caption(), $causes_edit->idCause->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_idCause");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($causes_edit->idCause->errorMessage()) ?>");
			<?php if ($causes_edit->cause->Required) { ?>
				elm = this.getElements("x" + infix + "_cause");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $causes_edit->cause->caption(), $causes_edit->cause->RequiredErrorMessage)) ?>");
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
	fcausesedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fcausesedit.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fcausesedit");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $causes_edit->showPageHeader(); ?>
<?php
$causes_edit->showMessage();
?>
<?php if (!$causes_edit->IsModal) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $causes_edit->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fcausesedit" id="fcausesedit" class="<?php echo $causes_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="causes">
<input type="hidden" name="k_hash" id="k_hash" value="<?php echo $causes_edit->HashValue ?>">
<?php if ($causes->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="conflict" id="conflict" value="1">
<?php } ?>
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$causes_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($causes_edit->idCause->Visible) { // idCause ?>
	<div id="r_idCause" class="form-group row">
		<label id="elh_causes_idCause" for="x_idCause" class="<?php echo $causes_edit->LeftColumnClass ?>"><?php echo $causes_edit->idCause->caption() ?><?php echo $causes_edit->idCause->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $causes_edit->RightColumnClass ?>"><div <?php echo $causes_edit->idCause->cellAttributes() ?>>
<input type="text" data-table="causes" data-field="x_idCause" name="x_idCause" id="x_idCause" placeholder="<?php echo HtmlEncode($causes_edit->idCause->getPlaceHolder()) ?>" value="<?php echo $causes_edit->idCause->EditValue ?>"<?php echo $causes_edit->idCause->editAttributes() ?>>
<input type="hidden" data-table="causes" data-field="x_idCause" name="o_idCause" id="o_idCause" value="<?php echo HtmlEncode($causes_edit->idCause->OldValue != null ? $causes_edit->idCause->OldValue : $causes_edit->idCause->CurrentValue) ?>">
<?php echo $causes_edit->idCause->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($causes_edit->cause->Visible) { // cause ?>
	<div id="r_cause" class="form-group row">
		<label id="elh_causes_cause" for="x_cause" class="<?php echo $causes_edit->LeftColumnClass ?>"><?php echo $causes_edit->cause->caption() ?><?php echo $causes_edit->cause->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $causes_edit->RightColumnClass ?>"><div <?php echo $causes_edit->cause->cellAttributes() ?>>
<span id="el_causes_cause">
<input type="text" data-table="causes" data-field="x_cause" name="x_cause" id="x_cause" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($causes_edit->cause->getPlaceHolder()) ?>" value="<?php echo $causes_edit->cause->EditValue ?>"<?php echo $causes_edit->cause->editAttributes() ?>>
</span>
<?php echo $causes_edit->cause->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$causes_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $causes_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($causes->UpdateConflict == "U") { // Record already updated by other user ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" onclick="this.form.action.value='overwrite';"><?php echo $Language->phrase("OverwriteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-reload" id="btn-reload" type="submit" onclick="this.form.action.value='show';"><?php echo $Language->phrase("ReloadBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $causes_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
<?php } ?>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$causes_edit->IsModal) { ?>
<?php echo $causes_edit->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<?php
$causes_edit->showPageFooter();
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
$causes_edit->terminate();
?>