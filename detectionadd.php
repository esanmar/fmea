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
$detection_add = new detection_add();

// Run the page
$detection_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$detection_add->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fdetectionadd, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "add";
	fdetectionadd = currentForm = new ew.Form("fdetectionadd", "add");

	// Validate form
	fdetectionadd.validate = function() {
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
			<?php if ($detection_add->detection->Required) { ?>
				elm = this.getElements("x" + infix + "_detection");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $detection_add->detection->caption(), $detection_add->detection->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($detection_add->description->Required) { ?>
				elm = this.getElements("x" + infix + "_description");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $detection_add->description->caption(), $detection_add->description->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($detection_add->methods->Required) { ?>
				elm = this.getElements("x" + infix + "_methods");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $detection_add->methods->caption(), $detection_add->methods->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($detection_add->errorProofed->Required) { ?>
				elm = this.getElements("x" + infix + "_errorProofed[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $detection_add->errorProofed->caption(), $detection_add->errorProofed->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($detection_add->gonogo->Required) { ?>
				elm = this.getElements("x" + infix + "_gonogo[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $detection_add->gonogo->caption(), $detection_add->gonogo->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($detection_add->visualInspection->Required) { ?>
				elm = this.getElements("x" + infix + "_visualInspection[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $detection_add->visualInspection->caption(), $detection_add->visualInspection->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($detection_add->color->Required) { ?>
				elm = this.getElements("x" + infix + "_color");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $detection_add->color->caption(), $detection_add->color->RequiredErrorMessage)) ?>");
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
	fdetectionadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fdetectionadd.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fdetectionadd.lists["x_errorProofed[]"] = <?php echo $detection_add->errorProofed->Lookup->toClientList($detection_add) ?>;
	fdetectionadd.lists["x_errorProofed[]"].options = <?php echo JsonEncode($detection_add->errorProofed->options(FALSE, TRUE)) ?>;
	fdetectionadd.lists["x_gonogo[]"] = <?php echo $detection_add->gonogo->Lookup->toClientList($detection_add) ?>;
	fdetectionadd.lists["x_gonogo[]"].options = <?php echo JsonEncode($detection_add->gonogo->options(FALSE, TRUE)) ?>;
	fdetectionadd.lists["x_visualInspection[]"] = <?php echo $detection_add->visualInspection->Lookup->toClientList($detection_add) ?>;
	fdetectionadd.lists["x_visualInspection[]"].options = <?php echo JsonEncode($detection_add->visualInspection->options(FALSE, TRUE)) ?>;
	loadjs.done("fdetectionadd");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $detection_add->showPageHeader(); ?>
<?php
$detection_add->showMessage();
?>
<form name="fdetectionadd" id="fdetectionadd" class="<?php echo $detection_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="detection">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$detection_add->IsModal ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($detection_add->detection->Visible) { // detection ?>
	<div id="r_detection" class="form-group row">
		<label id="elh_detection_detection" for="x_detection" class="<?php echo $detection_add->LeftColumnClass ?>"><?php echo $detection_add->detection->caption() ?><?php echo $detection_add->detection->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $detection_add->RightColumnClass ?>"><div <?php echo $detection_add->detection->cellAttributes() ?>>
<span id="el_detection_detection">
<input type="text" data-table="detection" data-field="x_detection" name="x_detection" id="x_detection" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($detection_add->detection->getPlaceHolder()) ?>" value="<?php echo $detection_add->detection->EditValue ?>"<?php echo $detection_add->detection->editAttributes() ?>>
</span>
<?php echo $detection_add->detection->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detection_add->description->Visible) { // description ?>
	<div id="r_description" class="form-group row">
		<label id="elh_detection_description" for="x_description" class="<?php echo $detection_add->LeftColumnClass ?>"><?php echo $detection_add->description->caption() ?><?php echo $detection_add->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $detection_add->RightColumnClass ?>"><div <?php echo $detection_add->description->cellAttributes() ?>>
<span id="el_detection_description">
<textarea data-table="detection" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?php echo HtmlEncode($detection_add->description->getPlaceHolder()) ?>"<?php echo $detection_add->description->editAttributes() ?>><?php echo $detection_add->description->EditValue ?></textarea>
</span>
<?php echo $detection_add->description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detection_add->methods->Visible) { // methods ?>
	<div id="r_methods" class="form-group row">
		<label id="elh_detection_methods" for="x_methods" class="<?php echo $detection_add->LeftColumnClass ?>"><?php echo $detection_add->methods->caption() ?><?php echo $detection_add->methods->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $detection_add->RightColumnClass ?>"><div <?php echo $detection_add->methods->cellAttributes() ?>>
<span id="el_detection_methods">
<textarea data-table="detection" data-field="x_methods" name="x_methods" id="x_methods" cols="35" rows="4" placeholder="<?php echo HtmlEncode($detection_add->methods->getPlaceHolder()) ?>"<?php echo $detection_add->methods->editAttributes() ?>><?php echo $detection_add->methods->EditValue ?></textarea>
</span>
<?php echo $detection_add->methods->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detection_add->errorProofed->Visible) { // errorProofed ?>
	<div id="r_errorProofed" class="form-group row">
		<label id="elh_detection_errorProofed" class="<?php echo $detection_add->LeftColumnClass ?>"><?php echo $detection_add->errorProofed->caption() ?><?php echo $detection_add->errorProofed->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $detection_add->RightColumnClass ?>"><div <?php echo $detection_add->errorProofed->cellAttributes() ?>>
<span id="el_detection_errorProofed">
<?php
$selwrk = ConvertToBool($detection_add->errorProofed->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="detection" data-field="x_errorProofed" name="x_errorProofed[]" id="x_errorProofed[]" value="1"<?php echo $selwrk ?><?php echo $detection_add->errorProofed->editAttributes() ?>>
	<label class="custom-control-label" for="x_errorProofed[]"></label>
</div>
</span>
<?php echo $detection_add->errorProofed->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detection_add->gonogo->Visible) { // gonogo ?>
	<div id="r_gonogo" class="form-group row">
		<label id="elh_detection_gonogo" class="<?php echo $detection_add->LeftColumnClass ?>"><?php echo $detection_add->gonogo->caption() ?><?php echo $detection_add->gonogo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $detection_add->RightColumnClass ?>"><div <?php echo $detection_add->gonogo->cellAttributes() ?>>
<span id="el_detection_gonogo">
<?php
$selwrk = ConvertToBool($detection_add->gonogo->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="detection" data-field="x_gonogo" name="x_gonogo[]" id="x_gonogo[]" value="1"<?php echo $selwrk ?><?php echo $detection_add->gonogo->editAttributes() ?>>
	<label class="custom-control-label" for="x_gonogo[]"></label>
</div>
</span>
<?php echo $detection_add->gonogo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detection_add->visualInspection->Visible) { // visualInspection ?>
	<div id="r_visualInspection" class="form-group row">
		<label id="elh_detection_visualInspection" class="<?php echo $detection_add->LeftColumnClass ?>"><?php echo $detection_add->visualInspection->caption() ?><?php echo $detection_add->visualInspection->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $detection_add->RightColumnClass ?>"><div <?php echo $detection_add->visualInspection->cellAttributes() ?>>
<span id="el_detection_visualInspection">
<?php
$selwrk = ConvertToBool($detection_add->visualInspection->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="detection" data-field="x_visualInspection" name="x_visualInspection[]" id="x_visualInspection[]" value="1"<?php echo $selwrk ?><?php echo $detection_add->visualInspection->editAttributes() ?>>
	<label class="custom-control-label" for="x_visualInspection[]"></label>
</div>
</span>
<?php echo $detection_add->visualInspection->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detection_add->color->Visible) { // color ?>
	<div id="r_color" class="form-group row">
		<label id="elh_detection_color" for="x_color" class="<?php echo $detection_add->LeftColumnClass ?>"><?php echo $detection_add->color->caption() ?><?php echo $detection_add->color->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $detection_add->RightColumnClass ?>"><div <?php echo $detection_add->color->cellAttributes() ?>>
<span id="el_detection_color">
<input type="text" data-table="detection" data-field="x_color" name="x_color" id="x_color" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($detection_add->color->getPlaceHolder()) ?>" value="<?php echo $detection_add->color->EditValue ?>"<?php echo $detection_add->color->editAttributes() ?>>

<script>
loadjs.ready("head", function() {
	jQuery("[id='x_color']:not([id*='$rowindex$'])").colorpicker({ format: "hex" });
});
</script>

</span>
<?php echo $detection_add->color->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$detection_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $detection_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $detection_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$detection_add->showPageFooter();
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
$detection_add->terminate();
?>