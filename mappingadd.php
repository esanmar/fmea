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
$mapping_add = new mapping_add();

// Run the page
$mapping_add->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$mapping_add->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fmappingadd, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "add";
	fmappingadd = currentForm = new ew.Form("fmappingadd", "add");

	// Validate form
	fmappingadd.validate = function() {
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
			<?php if ($mapping_add->process->Required) { ?>
				elm = this.getElements("x" + infix + "_process");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $mapping_add->process->caption(), $mapping_add->process->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($mapping_add->regulation->Required) { ?>
				elm = this.getElements("x" + infix + "_regulation[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $mapping_add->regulation->caption(), $mapping_add->regulation->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($mapping_add->qualification->Required) { ?>
				elm = this.getElements("x" + infix + "_qualification");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $mapping_add->qualification->caption(), $mapping_add->qualification->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($mapping_add->supplierLevel2->Required) { ?>
				elm = this.getElements("x" + infix + "_supplierLevel2[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $mapping_add->supplierLevel2->caption(), $mapping_add->supplierLevel2->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($mapping_add->supplierLevel3->Required) { ?>
				elm = this.getElements("x" + infix + "_supplierLevel3[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $mapping_add->supplierLevel3->caption(), $mapping_add->supplierLevel3->RequiredErrorMessage)) ?>");
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
	fmappingadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fmappingadd.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fmappingadd.lists["x_regulation[]"] = <?php echo $mapping_add->regulation->Lookup->toClientList($mapping_add) ?>;
	fmappingadd.lists["x_regulation[]"].options = <?php echo JsonEncode($mapping_add->regulation->lookupOptions()) ?>;
	fmappingadd.lists["x_qualification"] = <?php echo $mapping_add->qualification->Lookup->toClientList($mapping_add) ?>;
	fmappingadd.lists["x_qualification"].options = <?php echo JsonEncode($mapping_add->qualification->options(FALSE, TRUE)) ?>;
	fmappingadd.lists["x_supplierLevel2[]"] = <?php echo $mapping_add->supplierLevel2->Lookup->toClientList($mapping_add) ?>;
	fmappingadd.lists["x_supplierLevel2[]"].options = <?php echo JsonEncode($mapping_add->supplierLevel2->lookupOptions()) ?>;
	fmappingadd.lists["x_supplierLevel3[]"] = <?php echo $mapping_add->supplierLevel3->Lookup->toClientList($mapping_add) ?>;
	fmappingadd.lists["x_supplierLevel3[]"].options = <?php echo JsonEncode($mapping_add->supplierLevel3->lookupOptions()) ?>;
	loadjs.done("fmappingadd");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $mapping_add->showPageHeader(); ?>
<?php
$mapping_add->showMessage();
?>
<form name="fmappingadd" id="fmappingadd" class="<?php echo $mapping_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="mapping">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$mapping_add->IsModal ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($mapping_add->process->Visible) { // process ?>
	<div id="r_process" class="form-group row">
		<label id="elh_mapping_process" for="x_process" class="<?php echo $mapping_add->LeftColumnClass ?>"><?php echo $mapping_add->process->caption() ?><?php echo $mapping_add->process->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $mapping_add->RightColumnClass ?>"><div <?php echo $mapping_add->process->cellAttributes() ?>>
<span id="el_mapping_process">
<input type="text" data-table="mapping" data-field="x_process" name="x_process" id="x_process" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($mapping_add->process->getPlaceHolder()) ?>" value="<?php echo $mapping_add->process->EditValue ?>"<?php echo $mapping_add->process->editAttributes() ?>>
</span>
<?php echo $mapping_add->process->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($mapping_add->regulation->Visible) { // regulation ?>
	<div id="r_regulation" class="form-group row">
		<label id="elh_mapping_regulation" for="x_regulation" class="<?php echo $mapping_add->LeftColumnClass ?>"><?php echo $mapping_add->regulation->caption() ?><?php echo $mapping_add->regulation->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $mapping_add->RightColumnClass ?>"><div <?php echo $mapping_add->regulation->cellAttributes() ?>>
<span id="el_mapping_regulation">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="mapping" data-field="x_regulation" data-value-separator="<?php echo $mapping_add->regulation->displayValueSeparatorAttribute() ?>" id="x_regulation[]" name="x_regulation[]" multiple="multiple"<?php echo $mapping_add->regulation->editAttributes() ?>>
			<?php echo $mapping_add->regulation->selectOptionListHtml("x_regulation[]") ?>
		</select>
</div>
<?php echo $mapping_add->regulation->Lookup->getParamTag($mapping_add, "p_x_regulation") ?>
</span>
<?php echo $mapping_add->regulation->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($mapping_add->qualification->Visible) { // qualification ?>
	<div id="r_qualification" class="form-group row">
		<label id="elh_mapping_qualification" class="<?php echo $mapping_add->LeftColumnClass ?>"><?php echo $mapping_add->qualification->caption() ?><?php echo $mapping_add->qualification->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $mapping_add->RightColumnClass ?>"><div <?php echo $mapping_add->qualification->cellAttributes() ?>>
<span id="el_mapping_qualification">
<div id="tp_x_qualification" class="ew-template"><input type="radio" class="custom-control-input" data-table="mapping" data-field="x_qualification" data-value-separator="<?php echo $mapping_add->qualification->displayValueSeparatorAttribute() ?>" name="x_qualification" id="x_qualification" value="{value}"<?php echo $mapping_add->qualification->editAttributes() ?>></div>
<div id="dsl_x_qualification" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $mapping_add->qualification->radioButtonListHtml(FALSE, "x_qualification") ?>
</div></div>
</span>
<?php echo $mapping_add->qualification->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($mapping_add->supplierLevel2->Visible) { // supplierLevel2 ?>
	<div id="r_supplierLevel2" class="form-group row">
		<label id="elh_mapping_supplierLevel2" for="x_supplierLevel2" class="<?php echo $mapping_add->LeftColumnClass ?>"><?php echo $mapping_add->supplierLevel2->caption() ?><?php echo $mapping_add->supplierLevel2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $mapping_add->RightColumnClass ?>"><div <?php echo $mapping_add->supplierLevel2->cellAttributes() ?>>
<span id="el_mapping_supplierLevel2">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="mapping" data-field="x_supplierLevel2" data-value-separator="<?php echo $mapping_add->supplierLevel2->displayValueSeparatorAttribute() ?>" id="x_supplierLevel2[]" name="x_supplierLevel2[]" multiple="multiple"<?php echo $mapping_add->supplierLevel2->editAttributes() ?>>
			<?php echo $mapping_add->supplierLevel2->selectOptionListHtml("x_supplierLevel2[]") ?>
		</select>
</div>
<?php echo $mapping_add->supplierLevel2->Lookup->getParamTag($mapping_add, "p_x_supplierLevel2") ?>
</span>
<?php echo $mapping_add->supplierLevel2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($mapping_add->supplierLevel3->Visible) { // supplierLevel3 ?>
	<div id="r_supplierLevel3" class="form-group row">
		<label id="elh_mapping_supplierLevel3" for="x_supplierLevel3" class="<?php echo $mapping_add->LeftColumnClass ?>"><?php echo $mapping_add->supplierLevel3->caption() ?><?php echo $mapping_add->supplierLevel3->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $mapping_add->RightColumnClass ?>"><div <?php echo $mapping_add->supplierLevel3->cellAttributes() ?>>
<span id="el_mapping_supplierLevel3">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="mapping" data-field="x_supplierLevel3" data-value-separator="<?php echo $mapping_add->supplierLevel3->displayValueSeparatorAttribute() ?>" id="x_supplierLevel3[]" name="x_supplierLevel3[]" multiple="multiple"<?php echo $mapping_add->supplierLevel3->editAttributes() ?>>
			<?php echo $mapping_add->supplierLevel3->selectOptionListHtml("x_supplierLevel3[]") ?>
		</select>
</div>
<?php echo $mapping_add->supplierLevel3->Lookup->getParamTag($mapping_add, "p_x_supplierLevel3") ?>
</span>
<?php echo $mapping_add->supplierLevel3->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$mapping_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $mapping_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $mapping_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$mapping_add->showPageFooter();
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
$mapping_add->terminate();
?>