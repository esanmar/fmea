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
$fmea_add = new fmea_add();

// Run the page
$fmea_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$fmea_add->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var ffmeaadd, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "add";
	ffmeaadd = currentForm = new ew.Form("ffmeaadd", "add");

	// Validate form
	ffmeaadd.validate = function() {
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
			<?php if ($fmea_add->fmea->Required) { ?>
				elm = this.getElements("x" + infix + "_fmea");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $fmea_add->fmea->caption(), $fmea_add->fmea->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($fmea_add->idFactory->Required) { ?>
				elm = this.getElements("x" + infix + "_idFactory");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $fmea_add->idFactory->caption(), $fmea_add->idFactory->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($fmea_add->dateFmea->Required) { ?>
				elm = this.getElements("x" + infix + "_dateFmea");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $fmea_add->dateFmea->caption(), $fmea_add->dateFmea->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_dateFmea");
				if (elm && !ew.checkDateDef(elm.value))
					return this.onError(elm, "<?php echo JsEncode($fmea_add->dateFmea->errorMessage()) ?>");
			<?php if ($fmea_add->partnumbers->Required) { ?>
				elm = this.getElements("x" + infix + "_partnumbers");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $fmea_add->partnumbers->caption(), $fmea_add->partnumbers->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($fmea_add->description->Required) { ?>
				elm = this.getElements("x" + infix + "_description");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $fmea_add->description->caption(), $fmea_add->description->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($fmea_add->idEmployee->Required) { ?>
				elm = this.getElements("x" + infix + "_idEmployee[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $fmea_add->idEmployee->caption(), $fmea_add->idEmployee->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($fmea_add->idworkcenter->Required) { ?>
				elm = this.getElements("x" + infix + "_idworkcenter");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $fmea_add->idworkcenter->caption(), $fmea_add->idworkcenter->RequiredErrorMessage)) ?>");
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
	ffmeaadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	ffmeaadd.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	ffmeaadd.lists["x_idFactory"] = <?php echo $fmea_add->idFactory->Lookup->toClientList($fmea_add) ?>;
	ffmeaadd.lists["x_idFactory"].options = <?php echo JsonEncode($fmea_add->idFactory->lookupOptions()) ?>;
	ffmeaadd.lists["x_idEmployee[]"] = <?php echo $fmea_add->idEmployee->Lookup->toClientList($fmea_add) ?>;
	ffmeaadd.lists["x_idEmployee[]"].options = <?php echo JsonEncode($fmea_add->idEmployee->lookupOptions()) ?>;
	ffmeaadd.lists["x_idworkcenter"] = <?php echo $fmea_add->idworkcenter->Lookup->toClientList($fmea_add) ?>;
	ffmeaadd.lists["x_idworkcenter"].options = <?php echo JsonEncode($fmea_add->idworkcenter->lookupOptions()) ?>;
	loadjs.done("ffmeaadd");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $fmea_add->showPageHeader(); ?>
<?php
$fmea_add->showMessage();
?>
<form name="ffmeaadd" id="ffmeaadd" class="<?php echo $fmea_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="fmea">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$fmea_add->IsModal ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($fmea_add->fmea->Visible) { // fmea ?>
	<div id="r_fmea" class="form-group row">
		<label id="elh_fmea_fmea" for="x_fmea" class="<?php echo $fmea_add->LeftColumnClass ?>"><?php echo $fmea_add->fmea->caption() ?><?php echo $fmea_add->fmea->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $fmea_add->RightColumnClass ?>"><div <?php echo $fmea_add->fmea->cellAttributes() ?>>
<span id="el_fmea_fmea">
<input type="text" data-table="fmea" data-field="x_fmea" name="x_fmea" id="x_fmea" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($fmea_add->fmea->getPlaceHolder()) ?>" value="<?php echo $fmea_add->fmea->EditValue ?>"<?php echo $fmea_add->fmea->editAttributes() ?>>
</span>
<?php echo $fmea_add->fmea->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($fmea_add->idFactory->Visible) { // idFactory ?>
	<div id="r_idFactory" class="form-group row">
		<label id="elh_fmea_idFactory" for="x_idFactory" class="<?php echo $fmea_add->LeftColumnClass ?>"><?php echo $fmea_add->idFactory->caption() ?><?php echo $fmea_add->idFactory->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $fmea_add->RightColumnClass ?>"><div <?php echo $fmea_add->idFactory->cellAttributes() ?>>
<span id="el_fmea_idFactory">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="fmea" data-field="x_idFactory" data-value-separator="<?php echo $fmea_add->idFactory->displayValueSeparatorAttribute() ?>" id="x_idFactory" name="x_idFactory"<?php echo $fmea_add->idFactory->editAttributes() ?>>
			<?php echo $fmea_add->idFactory->selectOptionListHtml("x_idFactory") ?>
		</select>
</div>
<?php echo $fmea_add->idFactory->Lookup->getParamTag($fmea_add, "p_x_idFactory") ?>
</span>
<?php echo $fmea_add->idFactory->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($fmea_add->dateFmea->Visible) { // dateFmea ?>
	<div id="r_dateFmea" class="form-group row">
		<label id="elh_fmea_dateFmea" for="x_dateFmea" class="<?php echo $fmea_add->LeftColumnClass ?>"><?php echo $fmea_add->dateFmea->caption() ?><?php echo $fmea_add->dateFmea->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $fmea_add->RightColumnClass ?>"><div <?php echo $fmea_add->dateFmea->cellAttributes() ?>>
<span id="el_fmea_dateFmea">
<input type="text" data-table="fmea" data-field="x_dateFmea" name="x_dateFmea" id="x_dateFmea" placeholder="<?php echo HtmlEncode($fmea_add->dateFmea->getPlaceHolder()) ?>" value="<?php echo $fmea_add->dateFmea->EditValue ?>"<?php echo $fmea_add->dateFmea->editAttributes() ?>>
<?php if (!$fmea_add->dateFmea->ReadOnly && !$fmea_add->dateFmea->Disabled && !isset($fmea_add->dateFmea->EditAttrs["readonly"]) && !isset($fmea_add->dateFmea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffmeaadd", "datetimepicker"], function() {
	ew.createDateTimePicker("ffmeaadd", "x_dateFmea", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php echo $fmea_add->dateFmea->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($fmea_add->partnumbers->Visible) { // partnumbers ?>
	<div id="r_partnumbers" class="form-group row">
		<label id="elh_fmea_partnumbers" for="x_partnumbers" class="<?php echo $fmea_add->LeftColumnClass ?>"><?php echo $fmea_add->partnumbers->caption() ?><?php echo $fmea_add->partnumbers->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $fmea_add->RightColumnClass ?>"><div <?php echo $fmea_add->partnumbers->cellAttributes() ?>>
<span id="el_fmea_partnumbers">
<textarea data-table="fmea" data-field="x_partnumbers" name="x_partnumbers" id="x_partnumbers" cols="35" rows="4" placeholder="<?php echo HtmlEncode($fmea_add->partnumbers->getPlaceHolder()) ?>"<?php echo $fmea_add->partnumbers->editAttributes() ?>><?php echo $fmea_add->partnumbers->EditValue ?></textarea>
</span>
<?php echo $fmea_add->partnumbers->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($fmea_add->description->Visible) { // description ?>
	<div id="r_description" class="form-group row">
		<label id="elh_fmea_description" for="x_description" class="<?php echo $fmea_add->LeftColumnClass ?>"><?php echo $fmea_add->description->caption() ?><?php echo $fmea_add->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $fmea_add->RightColumnClass ?>"><div <?php echo $fmea_add->description->cellAttributes() ?>>
<span id="el_fmea_description">
<textarea data-table="fmea" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?php echo HtmlEncode($fmea_add->description->getPlaceHolder()) ?>"<?php echo $fmea_add->description->editAttributes() ?>><?php echo $fmea_add->description->EditValue ?></textarea>
</span>
<?php echo $fmea_add->description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($fmea_add->idEmployee->Visible) { // idEmployee ?>
	<div id="r_idEmployee" class="form-group row">
		<label id="elh_fmea_idEmployee" for="x_idEmployee" class="<?php echo $fmea_add->LeftColumnClass ?>"><?php echo $fmea_add->idEmployee->caption() ?><?php echo $fmea_add->idEmployee->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $fmea_add->RightColumnClass ?>"><div <?php echo $fmea_add->idEmployee->cellAttributes() ?>>
<span id="el_fmea_idEmployee">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_idEmployee"><?php echo EmptyValue(strval($fmea_add->idEmployee->ViewValue)) ? $Language->phrase("PleaseSelect") : $fmea_add->idEmployee->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($fmea_add->idEmployee->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($fmea_add->idEmployee->ReadOnly || $fmea_add->idEmployee->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_idEmployee[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $fmea_add->idEmployee->Lookup->getParamTag($fmea_add, "p_x_idEmployee") ?>
<input type="hidden" data-table="fmea" data-field="x_idEmployee" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $fmea_add->idEmployee->displayValueSeparatorAttribute() ?>" name="x_idEmployee[]" id="x_idEmployee[]" value="<?php echo $fmea_add->idEmployee->CurrentValue ?>"<?php echo $fmea_add->idEmployee->editAttributes() ?>>
</span>
<?php echo $fmea_add->idEmployee->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($fmea_add->idworkcenter->Visible) { // idworkcenter ?>
	<div id="r_idworkcenter" class="form-group row">
		<label id="elh_fmea_idworkcenter" for="x_idworkcenter" class="<?php echo $fmea_add->LeftColumnClass ?>"><?php echo $fmea_add->idworkcenter->caption() ?><?php echo $fmea_add->idworkcenter->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $fmea_add->RightColumnClass ?>"><div <?php echo $fmea_add->idworkcenter->cellAttributes() ?>>
<span id="el_fmea_idworkcenter">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="fmea" data-field="x_idworkcenter" data-value-separator="<?php echo $fmea_add->idworkcenter->displayValueSeparatorAttribute() ?>" id="x_idworkcenter" name="x_idworkcenter"<?php echo $fmea_add->idworkcenter->editAttributes() ?>>
			<?php echo $fmea_add->idworkcenter->selectOptionListHtml("x_idworkcenter") ?>
		</select>
</div>
<?php echo $fmea_add->idworkcenter->Lookup->getParamTag($fmea_add, "p_x_idworkcenter") ?>
</span>
<?php echo $fmea_add->idworkcenter->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if ($fmea->getCurrentDetailTable() != "") { ?>
<?php
	$fmea_add->DetailPages->ValidKeys = explode(",", $fmea->getCurrentDetailTable());
	$firstActiveDetailTable = $fmea_add->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav-tabs" id="fmea_add_details"><!-- tabs -->
	<ul class="<?php echo $fmea_add->DetailPages->navStyle() ?>"><!-- .nav -->
<?php
	if (in_array("processf", explode(",", $fmea->getCurrentDetailTable())) && $processf->DetailAdd) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "processf") {
			$firstActiveDetailTable = "processf";
		}
?>
		<li class="nav-item"><a class="nav-link <?php echo $fmea_add->DetailPages->pageStyle("processf") ?>" href="#tab_processf" data-toggle="tab"><?php echo $Language->tablePhrase("processf", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("issue", explode(",", $fmea->getCurrentDetailTable())) && $issue->DetailAdd) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "issue") {
			$firstActiveDetailTable = "issue";
		}
?>
		<li class="nav-item"><a class="nav-link <?php echo $fmea_add->DetailPages->pageStyle("issue") ?>" href="#tab_issue" data-toggle="tab"><?php echo $Language->tablePhrase("issue", "TblCaption") ?></a></li>
<?php
	}
?>
	</ul><!-- /.nav -->
	<div class="tab-content"><!-- .tab-content -->
<?php
	if (in_array("processf", explode(",", $fmea->getCurrentDetailTable())) && $processf->DetailAdd) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "processf")
			$firstActiveDetailTable = "processf";
?>
		<div class="tab-pane <?php echo $fmea_add->DetailPages->pageStyle("processf") ?>" id="tab_processf"><!-- page* -->
<?php include_once "processfgrid.php" ?>
		</div><!-- /page* -->
<?php } ?>
<?php
	if (in_array("issue", explode(",", $fmea->getCurrentDetailTable())) && $issue->DetailAdd) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "issue")
			$firstActiveDetailTable = "issue";
?>
		<div class="tab-pane <?php echo $fmea_add->DetailPages->pageStyle("issue") ?>" id="tab_issue"><!-- page* -->
<?php include_once "issuegrid.php" ?>
		</div><!-- /page* -->
<?php } ?>
	</div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
<?php } ?>
<?php if (!$fmea_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $fmea_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $fmea_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$fmea_add->showPageFooter();
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
$fmea_add->terminate();
?>