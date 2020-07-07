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
$severity_add = new severity_add();

// Run the page
$severity_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$severity_add->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fseverityadd, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "add";
	fseverityadd = currentForm = new ew.Form("fseverityadd", "add");

	// Validate form
	fseverityadd.validate = function() {
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
			<?php if ($severity_add->effect->Required) { ?>
				elm = this.getElements("x" + infix + "_effect");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $severity_add->effect->caption(), $severity_add->effect->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($severity_add->severityonclient->Required) { ?>
				elm = this.getElements("x" + infix + "_severityonclient");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $severity_add->severityonclient->caption(), $severity_add->severityonclient->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($severity_add->internalseverity->Required) { ?>
				elm = this.getElements("x" + infix + "_internalseverity");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $severity_add->internalseverity->caption(), $severity_add->internalseverity->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($severity_add->color->Required) { ?>
				elm = this.getElements("x" + infix + "_color");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $severity_add->color->caption(), $severity_add->color->RequiredErrorMessage)) ?>");
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
	fseverityadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fseverityadd.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fseverityadd");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $severity_add->showPageHeader(); ?>
<?php
$severity_add->showMessage();
?>
<form name="fseverityadd" id="fseverityadd" class="<?php echo $severity_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="severity">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$severity_add->IsModal ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($severity_add->effect->Visible) { // effect ?>
	<div id="r_effect" class="form-group row">
		<label id="elh_severity_effect" for="x_effect" class="<?php echo $severity_add->LeftColumnClass ?>"><?php echo $severity_add->effect->caption() ?><?php echo $severity_add->effect->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $severity_add->RightColumnClass ?>"><div <?php echo $severity_add->effect->cellAttributes() ?>>
<span id="el_severity_effect">
<input type="text" data-table="severity" data-field="x_effect" name="x_effect" id="x_effect" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($severity_add->effect->getPlaceHolder()) ?>" value="<?php echo $severity_add->effect->EditValue ?>"<?php echo $severity_add->effect->editAttributes() ?>>
</span>
<?php echo $severity_add->effect->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($severity_add->severityonclient->Visible) { // severityonclient ?>
	<div id="r_severityonclient" class="form-group row">
		<label id="elh_severity_severityonclient" for="x_severityonclient" class="<?php echo $severity_add->LeftColumnClass ?>"><?php echo $severity_add->severityonclient->caption() ?><?php echo $severity_add->severityonclient->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $severity_add->RightColumnClass ?>"><div <?php echo $severity_add->severityonclient->cellAttributes() ?>>
<span id="el_severity_severityonclient">
<textarea data-table="severity" data-field="x_severityonclient" name="x_severityonclient" id="x_severityonclient" cols="35" rows="4" placeholder="<?php echo HtmlEncode($severity_add->severityonclient->getPlaceHolder()) ?>"<?php echo $severity_add->severityonclient->editAttributes() ?>><?php echo $severity_add->severityonclient->EditValue ?></textarea>
</span>
<?php echo $severity_add->severityonclient->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($severity_add->internalseverity->Visible) { // internalseverity ?>
	<div id="r_internalseverity" class="form-group row">
		<label id="elh_severity_internalseverity" for="x_internalseverity" class="<?php echo $severity_add->LeftColumnClass ?>"><?php echo $severity_add->internalseverity->caption() ?><?php echo $severity_add->internalseverity->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $severity_add->RightColumnClass ?>"><div <?php echo $severity_add->internalseverity->cellAttributes() ?>>
<span id="el_severity_internalseverity">
<textarea data-table="severity" data-field="x_internalseverity" name="x_internalseverity" id="x_internalseverity" cols="35" rows="4" placeholder="<?php echo HtmlEncode($severity_add->internalseverity->getPlaceHolder()) ?>"<?php echo $severity_add->internalseverity->editAttributes() ?>><?php echo $severity_add->internalseverity->EditValue ?></textarea>
</span>
<?php echo $severity_add->internalseverity->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($severity_add->color->Visible) { // color ?>
	<div id="r_color" class="form-group row">
		<label id="elh_severity_color" for="x_color" class="<?php echo $severity_add->LeftColumnClass ?>"><?php echo $severity_add->color->caption() ?><?php echo $severity_add->color->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $severity_add->RightColumnClass ?>"><div <?php echo $severity_add->color->cellAttributes() ?>>
<span id="el_severity_color">
<input type="text" data-table="severity" data-field="x_color" name="x_color" id="x_color" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($severity_add->color->getPlaceHolder()) ?>" value="<?php echo $severity_add->color->EditValue ?>"<?php echo $severity_add->color->editAttributes() ?>>

<script>
loadjs.ready("head", function() {
	jQuery("[id='x_color']:not([id*='$rowindex$'])").colorpicker({ format: "hex" });
});
</script>

</span>
<?php echo $severity_add->color->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$severity_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $severity_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $severity_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$severity_add->showPageFooter();
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
$severity_add->terminate();
?>