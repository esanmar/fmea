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
$detection_edit = new detection_edit();

// Run the page
$detection_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$detection_edit->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fdetectionedit, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "edit";
	fdetectionedit = currentForm = new ew.Form("fdetectionedit", "edit");

	// Validate form
	fdetectionedit.validate = function() {
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
			<?php if ($detection_edit->idDetection->Required) { ?>
				elm = this.getElements("x" + infix + "_idDetection");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $detection_edit->idDetection->caption(), $detection_edit->idDetection->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($detection_edit->detection->Required) { ?>
				elm = this.getElements("x" + infix + "_detection");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $detection_edit->detection->caption(), $detection_edit->detection->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($detection_edit->description->Required) { ?>
				elm = this.getElements("x" + infix + "_description");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $detection_edit->description->caption(), $detection_edit->description->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($detection_edit->methods->Required) { ?>
				elm = this.getElements("x" + infix + "_methods");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $detection_edit->methods->caption(), $detection_edit->methods->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($detection_edit->errorProofed->Required) { ?>
				elm = this.getElements("x" + infix + "_errorProofed[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $detection_edit->errorProofed->caption(), $detection_edit->errorProofed->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($detection_edit->gonogo->Required) { ?>
				elm = this.getElements("x" + infix + "_gonogo[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $detection_edit->gonogo->caption(), $detection_edit->gonogo->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($detection_edit->visualInspection->Required) { ?>
				elm = this.getElements("x" + infix + "_visualInspection[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $detection_edit->visualInspection->caption(), $detection_edit->visualInspection->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($detection_edit->color->Required) { ?>
				elm = this.getElements("x" + infix + "_color");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $detection_edit->color->caption(), $detection_edit->color->RequiredErrorMessage)) ?>");
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
	fdetectionedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fdetectionedit.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fdetectionedit.lists["x_errorProofed[]"] = <?php echo $detection_edit->errorProofed->Lookup->toClientList($detection_edit) ?>;
	fdetectionedit.lists["x_errorProofed[]"].options = <?php echo JsonEncode($detection_edit->errorProofed->options(FALSE, TRUE)) ?>;
	fdetectionedit.lists["x_gonogo[]"] = <?php echo $detection_edit->gonogo->Lookup->toClientList($detection_edit) ?>;
	fdetectionedit.lists["x_gonogo[]"].options = <?php echo JsonEncode($detection_edit->gonogo->options(FALSE, TRUE)) ?>;
	fdetectionedit.lists["x_visualInspection[]"] = <?php echo $detection_edit->visualInspection->Lookup->toClientList($detection_edit) ?>;
	fdetectionedit.lists["x_visualInspection[]"].options = <?php echo JsonEncode($detection_edit->visualInspection->options(FALSE, TRUE)) ?>;
	loadjs.done("fdetectionedit");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $detection_edit->showPageHeader(); ?>
<?php
$detection_edit->showMessage();
?>
<?php if (!$detection_edit->IsModal) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $detection_edit->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fdetectionedit" id="fdetectionedit" class="<?php echo $detection_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="detection">
<input type="hidden" name="k_hash" id="k_hash" value="<?php echo $detection_edit->HashValue ?>">
<?php if ($detection->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="conflict" id="conflict" value="1">
<?php } ?>
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$detection_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($detection_edit->idDetection->Visible) { // idDetection ?>
	<div id="r_idDetection" class="form-group row">
		<label id="elh_detection_idDetection" class="<?php echo $detection_edit->LeftColumnClass ?>"><?php echo $detection_edit->idDetection->caption() ?><?php echo $detection_edit->idDetection->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $detection_edit->RightColumnClass ?>"><div <?php echo $detection_edit->idDetection->cellAttributes() ?>>
<span id="el_detection_idDetection">
<span<?php echo $detection_edit->idDetection->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($detection_edit->idDetection->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="detection" data-field="x_idDetection" name="x_idDetection" id="x_idDetection" value="<?php echo HtmlEncode($detection_edit->idDetection->CurrentValue) ?>">
<?php echo $detection_edit->idDetection->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detection_edit->detection->Visible) { // detection ?>
	<div id="r_detection" class="form-group row">
		<label id="elh_detection_detection" for="x_detection" class="<?php echo $detection_edit->LeftColumnClass ?>"><?php echo $detection_edit->detection->caption() ?><?php echo $detection_edit->detection->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $detection_edit->RightColumnClass ?>"><div <?php echo $detection_edit->detection->cellAttributes() ?>>
<span id="el_detection_detection">
<input type="text" data-table="detection" data-field="x_detection" name="x_detection" id="x_detection" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($detection_edit->detection->getPlaceHolder()) ?>" value="<?php echo $detection_edit->detection->EditValue ?>"<?php echo $detection_edit->detection->editAttributes() ?>>
</span>
<?php echo $detection_edit->detection->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detection_edit->description->Visible) { // description ?>
	<div id="r_description" class="form-group row">
		<label id="elh_detection_description" for="x_description" class="<?php echo $detection_edit->LeftColumnClass ?>"><?php echo $detection_edit->description->caption() ?><?php echo $detection_edit->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $detection_edit->RightColumnClass ?>"><div <?php echo $detection_edit->description->cellAttributes() ?>>
<span id="el_detection_description">
<textarea data-table="detection" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?php echo HtmlEncode($detection_edit->description->getPlaceHolder()) ?>"<?php echo $detection_edit->description->editAttributes() ?>><?php echo $detection_edit->description->EditValue ?></textarea>
</span>
<?php echo $detection_edit->description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detection_edit->methods->Visible) { // methods ?>
	<div id="r_methods" class="form-group row">
		<label id="elh_detection_methods" for="x_methods" class="<?php echo $detection_edit->LeftColumnClass ?>"><?php echo $detection_edit->methods->caption() ?><?php echo $detection_edit->methods->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $detection_edit->RightColumnClass ?>"><div <?php echo $detection_edit->methods->cellAttributes() ?>>
<span id="el_detection_methods">
<textarea data-table="detection" data-field="x_methods" name="x_methods" id="x_methods" cols="35" rows="4" placeholder="<?php echo HtmlEncode($detection_edit->methods->getPlaceHolder()) ?>"<?php echo $detection_edit->methods->editAttributes() ?>><?php echo $detection_edit->methods->EditValue ?></textarea>
</span>
<?php echo $detection_edit->methods->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detection_edit->errorProofed->Visible) { // errorProofed ?>
	<div id="r_errorProofed" class="form-group row">
		<label id="elh_detection_errorProofed" class="<?php echo $detection_edit->LeftColumnClass ?>"><?php echo $detection_edit->errorProofed->caption() ?><?php echo $detection_edit->errorProofed->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $detection_edit->RightColumnClass ?>"><div <?php echo $detection_edit->errorProofed->cellAttributes() ?>>
<span id="el_detection_errorProofed">
<?php
$selwrk = ConvertToBool($detection_edit->errorProofed->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="detection" data-field="x_errorProofed" name="x_errorProofed[]" id="x_errorProofed[]" value="1"<?php echo $selwrk ?><?php echo $detection_edit->errorProofed->editAttributes() ?>>
	<label class="custom-control-label" for="x_errorProofed[]"></label>
</div>
</span>
<?php echo $detection_edit->errorProofed->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detection_edit->gonogo->Visible) { // gonogo ?>
	<div id="r_gonogo" class="form-group row">
		<label id="elh_detection_gonogo" class="<?php echo $detection_edit->LeftColumnClass ?>"><?php echo $detection_edit->gonogo->caption() ?><?php echo $detection_edit->gonogo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $detection_edit->RightColumnClass ?>"><div <?php echo $detection_edit->gonogo->cellAttributes() ?>>
<span id="el_detection_gonogo">
<?php
$selwrk = ConvertToBool($detection_edit->gonogo->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="detection" data-field="x_gonogo" name="x_gonogo[]" id="x_gonogo[]" value="1"<?php echo $selwrk ?><?php echo $detection_edit->gonogo->editAttributes() ?>>
	<label class="custom-control-label" for="x_gonogo[]"></label>
</div>
</span>
<?php echo $detection_edit->gonogo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detection_edit->visualInspection->Visible) { // visualInspection ?>
	<div id="r_visualInspection" class="form-group row">
		<label id="elh_detection_visualInspection" class="<?php echo $detection_edit->LeftColumnClass ?>"><?php echo $detection_edit->visualInspection->caption() ?><?php echo $detection_edit->visualInspection->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $detection_edit->RightColumnClass ?>"><div <?php echo $detection_edit->visualInspection->cellAttributes() ?>>
<span id="el_detection_visualInspection">
<?php
$selwrk = ConvertToBool($detection_edit->visualInspection->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="detection" data-field="x_visualInspection" name="x_visualInspection[]" id="x_visualInspection[]" value="1"<?php echo $selwrk ?><?php echo $detection_edit->visualInspection->editAttributes() ?>>
	<label class="custom-control-label" for="x_visualInspection[]"></label>
</div>
</span>
<?php echo $detection_edit->visualInspection->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detection_edit->color->Visible) { // color ?>
	<div id="r_color" class="form-group row">
		<label id="elh_detection_color" for="x_color" class="<?php echo $detection_edit->LeftColumnClass ?>"><?php echo $detection_edit->color->caption() ?><?php echo $detection_edit->color->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $detection_edit->RightColumnClass ?>"><div <?php echo $detection_edit->color->cellAttributes() ?>>
<span id="el_detection_color">
<input type="text" data-table="detection" data-field="x_color" name="x_color" id="x_color" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($detection_edit->color->getPlaceHolder()) ?>" value="<?php echo $detection_edit->color->EditValue ?>"<?php echo $detection_edit->color->editAttributes() ?>>

<script>
loadjs.ready("head", function() {
	jQuery("[id='x_color']:not([id*='$rowindex$'])").colorpicker({ format: "hex" });
});
</script>

</span>
<?php echo $detection_edit->color->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$detection_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $detection_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($detection->UpdateConflict == "U") { // Record already updated by other user ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" onclick="this.form.action.value='overwrite';"><?php echo $Language->phrase("OverwriteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-reload" id="btn-reload" type="submit" onclick="this.form.action.value='show';"><?php echo $Language->phrase("ReloadBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $detection_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
<?php } ?>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$detection_edit->IsModal) { ?>
<?php echo $detection_edit->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<?php
$detection_edit->showPageFooter();
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
$detection_edit->terminate();
?>