<?php
namespace PHPMaker2020\SupplierMapping;

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
$regulations_edit = new regulations_edit();

// Run the page
$regulations_edit->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$regulations_edit->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fregulationsedit, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "edit";
	fregulationsedit = currentForm = new ew.Form("fregulationsedit", "edit");

	// Validate form
	fregulationsedit.validate = function() {
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
			<?php if ($regulations_edit->regulation->Required) { ?>
				elm = this.getElements("x" + infix + "_regulation");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $regulations_edit->regulation->caption(), $regulations_edit->regulation->RequiredErrorMessage)) ?>");
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
	fregulationsedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fregulationsedit.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fregulationsedit");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $regulations_edit->showPageHeader(); ?>
<?php
$regulations_edit->showMessage();
?>
<?php if (!$regulations_edit->IsModal) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $regulations_edit->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fregulationsedit" id="fregulationsedit" class="<?php echo $regulations_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="regulations">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$regulations_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($regulations_edit->regulation->Visible) { // regulation ?>
	<div id="r_regulation" class="form-group row">
		<label id="elh_regulations_regulation" for="x_regulation" class="<?php echo $regulations_edit->LeftColumnClass ?>"><?php echo $regulations_edit->regulation->caption() ?><?php echo $regulations_edit->regulation->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $regulations_edit->RightColumnClass ?>"><div <?php echo $regulations_edit->regulation->cellAttributes() ?>>
<input type="text" data-table="regulations" data-field="x_regulation" name="x_regulation" id="x_regulation" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($regulations_edit->regulation->getPlaceHolder()) ?>" value="<?php echo $regulations_edit->regulation->EditValue ?>"<?php echo $regulations_edit->regulation->editAttributes() ?>>
<input type="hidden" data-table="regulations" data-field="x_regulation" name="o_regulation" id="o_regulation" value="<?php echo HtmlEncode($regulations_edit->regulation->OldValue != null ? $regulations_edit->regulation->OldValue : $regulations_edit->regulation->CurrentValue) ?>">
<?php echo $regulations_edit->regulation->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$regulations_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $regulations_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $regulations_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$regulations_edit->IsModal) { ?>
<?php echo $regulations_edit->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<?php
$regulations_edit->showPageFooter();
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
$regulations_edit->terminate();
?>