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
$severity_edit = new severity_edit();

// Run the page
$severity_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$severity_edit->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fseverityedit, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "edit";
	fseverityedit = currentForm = new ew.Form("fseverityedit", "edit");

	// Validate form
	fseverityedit.validate = function() {
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
			<?php if ($severity_edit->idSeverity->Required) { ?>
				elm = this.getElements("x" + infix + "_idSeverity");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $severity_edit->idSeverity->caption(), $severity_edit->idSeverity->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($severity_edit->effect->Required) { ?>
				elm = this.getElements("x" + infix + "_effect");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $severity_edit->effect->caption(), $severity_edit->effect->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($severity_edit->severityonclient->Required) { ?>
				elm = this.getElements("x" + infix + "_severityonclient");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $severity_edit->severityonclient->caption(), $severity_edit->severityonclient->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($severity_edit->internalseverity->Required) { ?>
				elm = this.getElements("x" + infix + "_internalseverity");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $severity_edit->internalseverity->caption(), $severity_edit->internalseverity->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($severity_edit->color->Required) { ?>
				elm = this.getElements("x" + infix + "_color");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $severity_edit->color->caption(), $severity_edit->color->RequiredErrorMessage)) ?>");
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
	fseverityedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fseverityedit.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fseverityedit");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $severity_edit->showPageHeader(); ?>
<?php
$severity_edit->showMessage();
?>
<?php if (!$severity_edit->IsModal) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $severity_edit->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fseverityedit" id="fseverityedit" class="<?php echo $severity_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="severity">
<input type="hidden" name="k_hash" id="k_hash" value="<?php echo $severity_edit->HashValue ?>">
<?php if ($severity->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="conflict" id="conflict" value="1">
<?php } ?>
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$severity_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($severity_edit->idSeverity->Visible) { // idSeverity ?>
	<div id="r_idSeverity" class="form-group row">
		<label id="elh_severity_idSeverity" class="<?php echo $severity_edit->LeftColumnClass ?>"><?php echo $severity_edit->idSeverity->caption() ?><?php echo $severity_edit->idSeverity->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $severity_edit->RightColumnClass ?>"><div <?php echo $severity_edit->idSeverity->cellAttributes() ?>>
<span id="el_severity_idSeverity">
<span<?php echo $severity_edit->idSeverity->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($severity_edit->idSeverity->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="severity" data-field="x_idSeverity" name="x_idSeverity" id="x_idSeverity" value="<?php echo HtmlEncode($severity_edit->idSeverity->CurrentValue) ?>">
<?php echo $severity_edit->idSeverity->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($severity_edit->effect->Visible) { // effect ?>
	<div id="r_effect" class="form-group row">
		<label id="elh_severity_effect" for="x_effect" class="<?php echo $severity_edit->LeftColumnClass ?>"><?php echo $severity_edit->effect->caption() ?><?php echo $severity_edit->effect->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $severity_edit->RightColumnClass ?>"><div <?php echo $severity_edit->effect->cellAttributes() ?>>
<span id="el_severity_effect">
<input type="text" data-table="severity" data-field="x_effect" name="x_effect" id="x_effect" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($severity_edit->effect->getPlaceHolder()) ?>" value="<?php echo $severity_edit->effect->EditValue ?>"<?php echo $severity_edit->effect->editAttributes() ?>>
</span>
<?php echo $severity_edit->effect->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($severity_edit->severityonclient->Visible) { // severityonclient ?>
	<div id="r_severityonclient" class="form-group row">
		<label id="elh_severity_severityonclient" for="x_severityonclient" class="<?php echo $severity_edit->LeftColumnClass ?>"><?php echo $severity_edit->severityonclient->caption() ?><?php echo $severity_edit->severityonclient->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $severity_edit->RightColumnClass ?>"><div <?php echo $severity_edit->severityonclient->cellAttributes() ?>>
<span id="el_severity_severityonclient">
<textarea data-table="severity" data-field="x_severityonclient" name="x_severityonclient" id="x_severityonclient" cols="35" rows="4" placeholder="<?php echo HtmlEncode($severity_edit->severityonclient->getPlaceHolder()) ?>"<?php echo $severity_edit->severityonclient->editAttributes() ?>><?php echo $severity_edit->severityonclient->EditValue ?></textarea>
</span>
<?php echo $severity_edit->severityonclient->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($severity_edit->internalseverity->Visible) { // internalseverity ?>
	<div id="r_internalseverity" class="form-group row">
		<label id="elh_severity_internalseverity" for="x_internalseverity" class="<?php echo $severity_edit->LeftColumnClass ?>"><?php echo $severity_edit->internalseverity->caption() ?><?php echo $severity_edit->internalseverity->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $severity_edit->RightColumnClass ?>"><div <?php echo $severity_edit->internalseverity->cellAttributes() ?>>
<span id="el_severity_internalseverity">
<textarea data-table="severity" data-field="x_internalseverity" name="x_internalseverity" id="x_internalseverity" cols="35" rows="4" placeholder="<?php echo HtmlEncode($severity_edit->internalseverity->getPlaceHolder()) ?>"<?php echo $severity_edit->internalseverity->editAttributes() ?>><?php echo $severity_edit->internalseverity->EditValue ?></textarea>
</span>
<?php echo $severity_edit->internalseverity->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($severity_edit->color->Visible) { // color ?>
	<div id="r_color" class="form-group row">
		<label id="elh_severity_color" for="x_color" class="<?php echo $severity_edit->LeftColumnClass ?>"><?php echo $severity_edit->color->caption() ?><?php echo $severity_edit->color->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $severity_edit->RightColumnClass ?>"><div <?php echo $severity_edit->color->cellAttributes() ?>>
<span id="el_severity_color">
<input type="text" data-table="severity" data-field="x_color" name="x_color" id="x_color" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($severity_edit->color->getPlaceHolder()) ?>" value="<?php echo $severity_edit->color->EditValue ?>"<?php echo $severity_edit->color->editAttributes() ?>>

<script>
loadjs.ready("head", function() {
	jQuery("[id='x_color']:not([id*='$rowindex$'])").colorpicker({ format: "hex" });
});
</script>

</span>
<?php echo $severity_edit->color->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$severity_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $severity_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($severity->UpdateConflict == "U") { // Record already updated by other user ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" onclick="this.form.action.value='overwrite';"><?php echo $Language->phrase("OverwriteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-reload" id="btn-reload" type="submit" onclick="this.form.action.value='show';"><?php echo $Language->phrase("ReloadBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $severity_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
<?php } ?>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$severity_edit->IsModal) { ?>
<?php echo $severity_edit->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<?php
$severity_edit->showPageFooter();
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
$severity_edit->terminate();
?>