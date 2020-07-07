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
$mapping_edit = new mapping_edit();

// Run the page
$mapping_edit->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$mapping_edit->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fmappingedit, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "edit";
	fmappingedit = currentForm = new ew.Form("fmappingedit", "edit");

	// Validate form
	fmappingedit.validate = function() {
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
			<?php if ($mapping_edit->idProcess->Required) { ?>
				elm = this.getElements("x" + infix + "_idProcess");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $mapping_edit->idProcess->caption(), $mapping_edit->idProcess->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($mapping_edit->process->Required) { ?>
				elm = this.getElements("x" + infix + "_process");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $mapping_edit->process->caption(), $mapping_edit->process->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($mapping_edit->regulation->Required) { ?>
				elm = this.getElements("x" + infix + "_regulation[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $mapping_edit->regulation->caption(), $mapping_edit->regulation->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($mapping_edit->qualification->Required) { ?>
				elm = this.getElements("x" + infix + "_qualification");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $mapping_edit->qualification->caption(), $mapping_edit->qualification->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($mapping_edit->supplierLevel2->Required) { ?>
				elm = this.getElements("x" + infix + "_supplierLevel2[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $mapping_edit->supplierLevel2->caption(), $mapping_edit->supplierLevel2->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($mapping_edit->supplierLevel3->Required) { ?>
				elm = this.getElements("x" + infix + "_supplierLevel3[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $mapping_edit->supplierLevel3->caption(), $mapping_edit->supplierLevel3->RequiredErrorMessage)) ?>");
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
	fmappingedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fmappingedit.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fmappingedit.lists["x_regulation[]"] = <?php echo $mapping_edit->regulation->Lookup->toClientList($mapping_edit) ?>;
	fmappingedit.lists["x_regulation[]"].options = <?php echo JsonEncode($mapping_edit->regulation->lookupOptions()) ?>;
	fmappingedit.lists["x_qualification"] = <?php echo $mapping_edit->qualification->Lookup->toClientList($mapping_edit) ?>;
	fmappingedit.lists["x_qualification"].options = <?php echo JsonEncode($mapping_edit->qualification->options(FALSE, TRUE)) ?>;
	fmappingedit.lists["x_supplierLevel2[]"] = <?php echo $mapping_edit->supplierLevel2->Lookup->toClientList($mapping_edit) ?>;
	fmappingedit.lists["x_supplierLevel2[]"].options = <?php echo JsonEncode($mapping_edit->supplierLevel2->lookupOptions()) ?>;
	fmappingedit.lists["x_supplierLevel3[]"] = <?php echo $mapping_edit->supplierLevel3->Lookup->toClientList($mapping_edit) ?>;
	fmappingedit.lists["x_supplierLevel3[]"].options = <?php echo JsonEncode($mapping_edit->supplierLevel3->lookupOptions()) ?>;
	loadjs.done("fmappingedit");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $mapping_edit->showPageHeader(); ?>
<?php
$mapping_edit->showMessage();
?>
<?php if (!$mapping_edit->IsModal) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $mapping_edit->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fmappingedit" id="fmappingedit" class="<?php echo $mapping_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="mapping">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$mapping_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($mapping_edit->idProcess->Visible) { // idProcess ?>
	<div id="r_idProcess" class="form-group row">
		<label id="elh_mapping_idProcess" class="<?php echo $mapping_edit->LeftColumnClass ?>"><?php echo $mapping_edit->idProcess->caption() ?><?php echo $mapping_edit->idProcess->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $mapping_edit->RightColumnClass ?>"><div <?php echo $mapping_edit->idProcess->cellAttributes() ?>>
<span id="el_mapping_idProcess">
<span<?php echo $mapping_edit->idProcess->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($mapping_edit->idProcess->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="mapping" data-field="x_idProcess" name="x_idProcess" id="x_idProcess" value="<?php echo HtmlEncode($mapping_edit->idProcess->CurrentValue) ?>">
<?php echo $mapping_edit->idProcess->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($mapping_edit->process->Visible) { // process ?>
	<div id="r_process" class="form-group row">
		<label id="elh_mapping_process" for="x_process" class="<?php echo $mapping_edit->LeftColumnClass ?>"><?php echo $mapping_edit->process->caption() ?><?php echo $mapping_edit->process->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $mapping_edit->RightColumnClass ?>"><div <?php echo $mapping_edit->process->cellAttributes() ?>>
<span id="el_mapping_process">
<input type="text" data-table="mapping" data-field="x_process" name="x_process" id="x_process" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($mapping_edit->process->getPlaceHolder()) ?>" value="<?php echo $mapping_edit->process->EditValue ?>"<?php echo $mapping_edit->process->editAttributes() ?>>
</span>
<?php echo $mapping_edit->process->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($mapping_edit->regulation->Visible) { // regulation ?>
	<div id="r_regulation" class="form-group row">
		<label id="elh_mapping_regulation" for="x_regulation" class="<?php echo $mapping_edit->LeftColumnClass ?>"><?php echo $mapping_edit->regulation->caption() ?><?php echo $mapping_edit->regulation->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $mapping_edit->RightColumnClass ?>"><div <?php echo $mapping_edit->regulation->cellAttributes() ?>>
<span id="el_mapping_regulation">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="mapping" data-field="x_regulation" data-value-separator="<?php echo $mapping_edit->regulation->displayValueSeparatorAttribute() ?>" id="x_regulation[]" name="x_regulation[]" multiple="multiple"<?php echo $mapping_edit->regulation->editAttributes() ?>>
			<?php echo $mapping_edit->regulation->selectOptionListHtml("x_regulation[]") ?>
		</select>
</div>
<?php echo $mapping_edit->regulation->Lookup->getParamTag($mapping_edit, "p_x_regulation") ?>
</span>
<?php echo $mapping_edit->regulation->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($mapping_edit->qualification->Visible) { // qualification ?>
	<div id="r_qualification" class="form-group row">
		<label id="elh_mapping_qualification" class="<?php echo $mapping_edit->LeftColumnClass ?>"><?php echo $mapping_edit->qualification->caption() ?><?php echo $mapping_edit->qualification->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $mapping_edit->RightColumnClass ?>"><div <?php echo $mapping_edit->qualification->cellAttributes() ?>>
<span id="el_mapping_qualification">
<div id="tp_x_qualification" class="ew-template"><input type="radio" class="custom-control-input" data-table="mapping" data-field="x_qualification" data-value-separator="<?php echo $mapping_edit->qualification->displayValueSeparatorAttribute() ?>" name="x_qualification" id="x_qualification" value="{value}"<?php echo $mapping_edit->qualification->editAttributes() ?>></div>
<div id="dsl_x_qualification" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $mapping_edit->qualification->radioButtonListHtml(FALSE, "x_qualification") ?>
</div></div>
</span>
<?php echo $mapping_edit->qualification->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($mapping_edit->supplierLevel2->Visible) { // supplierLevel2 ?>
	<div id="r_supplierLevel2" class="form-group row">
		<label id="elh_mapping_supplierLevel2" for="x_supplierLevel2" class="<?php echo $mapping_edit->LeftColumnClass ?>"><?php echo $mapping_edit->supplierLevel2->caption() ?><?php echo $mapping_edit->supplierLevel2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $mapping_edit->RightColumnClass ?>"><div <?php echo $mapping_edit->supplierLevel2->cellAttributes() ?>>
<span id="el_mapping_supplierLevel2">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="mapping" data-field="x_supplierLevel2" data-value-separator="<?php echo $mapping_edit->supplierLevel2->displayValueSeparatorAttribute() ?>" id="x_supplierLevel2[]" name="x_supplierLevel2[]" multiple="multiple"<?php echo $mapping_edit->supplierLevel2->editAttributes() ?>>
			<?php echo $mapping_edit->supplierLevel2->selectOptionListHtml("x_supplierLevel2[]") ?>
		</select>
</div>
<?php echo $mapping_edit->supplierLevel2->Lookup->getParamTag($mapping_edit, "p_x_supplierLevel2") ?>
</span>
<?php echo $mapping_edit->supplierLevel2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($mapping_edit->supplierLevel3->Visible) { // supplierLevel3 ?>
	<div id="r_supplierLevel3" class="form-group row">
		<label id="elh_mapping_supplierLevel3" for="x_supplierLevel3" class="<?php echo $mapping_edit->LeftColumnClass ?>"><?php echo $mapping_edit->supplierLevel3->caption() ?><?php echo $mapping_edit->supplierLevel3->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $mapping_edit->RightColumnClass ?>"><div <?php echo $mapping_edit->supplierLevel3->cellAttributes() ?>>
<span id="el_mapping_supplierLevel3">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="mapping" data-field="x_supplierLevel3" data-value-separator="<?php echo $mapping_edit->supplierLevel3->displayValueSeparatorAttribute() ?>" id="x_supplierLevel3[]" name="x_supplierLevel3[]" multiple="multiple"<?php echo $mapping_edit->supplierLevel3->editAttributes() ?>>
			<?php echo $mapping_edit->supplierLevel3->selectOptionListHtml("x_supplierLevel3[]") ?>
		</select>
</div>
<?php echo $mapping_edit->supplierLevel3->Lookup->getParamTag($mapping_edit, "p_x_supplierLevel3") ?>
</span>
<?php echo $mapping_edit->supplierLevel3->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$mapping_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $mapping_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $mapping_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$mapping_edit->IsModal) { ?>
<?php echo $mapping_edit->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<?php
$mapping_edit->showPageFooter();
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
$mapping_edit->terminate();
?>