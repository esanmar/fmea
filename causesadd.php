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
$causes_add = new causes_add();

// Run the page
$causes_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$causes_add->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fcausesadd, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "add";
	fcausesadd = currentForm = new ew.Form("fcausesadd", "add");

	// Validate form
	fcausesadd.validate = function() {
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
			<?php if ($causes_add->idCause->Required) { ?>
				elm = this.getElements("x" + infix + "_idCause");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $causes_add->idCause->caption(), $causes_add->idCause->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_idCause");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($causes_add->idCause->errorMessage()) ?>");
			<?php if ($causes_add->cause->Required) { ?>
				elm = this.getElements("x" + infix + "_cause");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $causes_add->cause->caption(), $causes_add->cause->RequiredErrorMessage)) ?>");
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
	fcausesadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fcausesadd.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fcausesadd");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $causes_add->showPageHeader(); ?>
<?php
$causes_add->showMessage();
?>
<form name="fcausesadd" id="fcausesadd" class="<?php echo $causes_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="causes">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$causes_add->IsModal ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($causes_add->idCause->Visible) { // idCause ?>
	<div id="r_idCause" class="form-group row">
		<label id="elh_causes_idCause" for="x_idCause" class="<?php echo $causes_add->LeftColumnClass ?>"><?php echo $causes_add->idCause->caption() ?><?php echo $causes_add->idCause->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $causes_add->RightColumnClass ?>"><div <?php echo $causes_add->idCause->cellAttributes() ?>>
<span id="el_causes_idCause">
<input type="text" data-table="causes" data-field="x_idCause" name="x_idCause" id="x_idCause" placeholder="<?php echo HtmlEncode($causes_add->idCause->getPlaceHolder()) ?>" value="<?php echo $causes_add->idCause->EditValue ?>"<?php echo $causes_add->idCause->editAttributes() ?>>
</span>
<?php echo $causes_add->idCause->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($causes_add->cause->Visible) { // cause ?>
	<div id="r_cause" class="form-group row">
		<label id="elh_causes_cause" for="x_cause" class="<?php echo $causes_add->LeftColumnClass ?>"><?php echo $causes_add->cause->caption() ?><?php echo $causes_add->cause->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $causes_add->RightColumnClass ?>"><div <?php echo $causes_add->cause->cellAttributes() ?>>
<span id="el_causes_cause">
<input type="text" data-table="causes" data-field="x_cause" name="x_cause" id="x_cause" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($causes_add->cause->getPlaceHolder()) ?>" value="<?php echo $causes_add->cause->EditValue ?>"<?php echo $causes_add->cause->editAttributes() ?>>
</span>
<?php echo $causes_add->cause->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$causes_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $causes_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $causes_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$causes_add->showPageFooter();
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
$causes_add->terminate();
?>