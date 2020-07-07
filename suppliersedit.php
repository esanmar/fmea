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
$suppliers_edit = new suppliers_edit();

// Run the page
$suppliers_edit->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$suppliers_edit->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fsuppliersedit, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "edit";
	fsuppliersedit = currentForm = new ew.Form("fsuppliersedit", "edit");

	// Validate form
	fsuppliersedit.validate = function() {
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
			<?php if ($suppliers_edit->supplier->Required) { ?>
				elm = this.getElements("x" + infix + "_supplier");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $suppliers_edit->supplier->caption(), $suppliers_edit->supplier->RequiredErrorMessage)) ?>");
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
	fsuppliersedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fsuppliersedit.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fsuppliersedit");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $suppliers_edit->showPageHeader(); ?>
<?php
$suppliers_edit->showMessage();
?>
<?php if (!$suppliers_edit->IsModal) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $suppliers_edit->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fsuppliersedit" id="fsuppliersedit" class="<?php echo $suppliers_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="suppliers">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$suppliers_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($suppliers_edit->supplier->Visible) { // supplier ?>
	<div id="r_supplier" class="form-group row">
		<label id="elh_suppliers_supplier" for="x_supplier" class="<?php echo $suppliers_edit->LeftColumnClass ?>"><?php echo $suppliers_edit->supplier->caption() ?><?php echo $suppliers_edit->supplier->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $suppliers_edit->RightColumnClass ?>"><div <?php echo $suppliers_edit->supplier->cellAttributes() ?>>
<input type="text" data-table="suppliers" data-field="x_supplier" name="x_supplier" id="x_supplier" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($suppliers_edit->supplier->getPlaceHolder()) ?>" value="<?php echo $suppliers_edit->supplier->EditValue ?>"<?php echo $suppliers_edit->supplier->editAttributes() ?>>
<input type="hidden" data-table="suppliers" data-field="x_supplier" name="o_supplier" id="o_supplier" value="<?php echo HtmlEncode($suppliers_edit->supplier->OldValue != null ? $suppliers_edit->supplier->OldValue : $suppliers_edit->supplier->CurrentValue) ?>">
<?php echo $suppliers_edit->supplier->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$suppliers_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $suppliers_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $suppliers_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$suppliers_edit->IsModal) { ?>
<?php echo $suppliers_edit->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<?php
$suppliers_edit->showPageFooter();
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
$suppliers_edit->terminate();
?>