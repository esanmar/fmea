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
$fmea_edit = new fmea_edit();

// Run the page
$fmea_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$fmea_edit->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var ffmeaedit, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "edit";
	ffmeaedit = currentForm = new ew.Form("ffmeaedit", "edit");

	// Validate form
	ffmeaedit.validate = function() {
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
			<?php if ($fmea_edit->fmea->Required) { ?>
				elm = this.getElements("x" + infix + "_fmea");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $fmea_edit->fmea->caption(), $fmea_edit->fmea->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($fmea_edit->idFactory->Required) { ?>
				elm = this.getElements("x" + infix + "_idFactory");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $fmea_edit->idFactory->caption(), $fmea_edit->idFactory->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($fmea_edit->dateFmea->Required) { ?>
				elm = this.getElements("x" + infix + "_dateFmea");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $fmea_edit->dateFmea->caption(), $fmea_edit->dateFmea->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_dateFmea");
				if (elm && !ew.checkDateDef(elm.value))
					return this.onError(elm, "<?php echo JsEncode($fmea_edit->dateFmea->errorMessage()) ?>");
			<?php if ($fmea_edit->partnumbers->Required) { ?>
				elm = this.getElements("x" + infix + "_partnumbers");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $fmea_edit->partnumbers->caption(), $fmea_edit->partnumbers->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($fmea_edit->description->Required) { ?>
				elm = this.getElements("x" + infix + "_description");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $fmea_edit->description->caption(), $fmea_edit->description->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($fmea_edit->idEmployee->Required) { ?>
				elm = this.getElements("x" + infix + "_idEmployee[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $fmea_edit->idEmployee->caption(), $fmea_edit->idEmployee->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($fmea_edit->idworkcenter->Required) { ?>
				elm = this.getElements("x" + infix + "_idworkcenter");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $fmea_edit->idworkcenter->caption(), $fmea_edit->idworkcenter->RequiredErrorMessage)) ?>");
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
	ffmeaedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	ffmeaedit.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	ffmeaedit.lists["x_idFactory"] = <?php echo $fmea_edit->idFactory->Lookup->toClientList($fmea_edit) ?>;
	ffmeaedit.lists["x_idFactory"].options = <?php echo JsonEncode($fmea_edit->idFactory->lookupOptions()) ?>;
	ffmeaedit.lists["x_idEmployee[]"] = <?php echo $fmea_edit->idEmployee->Lookup->toClientList($fmea_edit) ?>;
	ffmeaedit.lists["x_idEmployee[]"].options = <?php echo JsonEncode($fmea_edit->idEmployee->lookupOptions()) ?>;
	ffmeaedit.lists["x_idworkcenter"] = <?php echo $fmea_edit->idworkcenter->Lookup->toClientList($fmea_edit) ?>;
	ffmeaedit.lists["x_idworkcenter"].options = <?php echo JsonEncode($fmea_edit->idworkcenter->lookupOptions()) ?>;
	loadjs.done("ffmeaedit");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $fmea_edit->showPageHeader(); ?>
<?php
$fmea_edit->showMessage();
?>
<?php if (!$fmea_edit->IsModal) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $fmea_edit->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="ffmeaedit" id="ffmeaedit" class="<?php echo $fmea_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="fmea">
<input type="hidden" name="k_hash" id="k_hash" value="<?php echo $fmea_edit->HashValue ?>">
<?php if ($fmea->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="conflict" id="conflict" value="1">
<?php } ?>
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$fmea_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($fmea_edit->fmea->Visible) { // fmea ?>
	<div id="r_fmea" class="form-group row">
		<label id="elh_fmea_fmea" for="x_fmea" class="<?php echo $fmea_edit->LeftColumnClass ?>"><?php echo $fmea_edit->fmea->caption() ?><?php echo $fmea_edit->fmea->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $fmea_edit->RightColumnClass ?>"><div <?php echo $fmea_edit->fmea->cellAttributes() ?>>
<input type="text" data-table="fmea" data-field="x_fmea" name="x_fmea" id="x_fmea" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($fmea_edit->fmea->getPlaceHolder()) ?>" value="<?php echo $fmea_edit->fmea->EditValue ?>"<?php echo $fmea_edit->fmea->editAttributes() ?>>
<input type="hidden" data-table="fmea" data-field="x_fmea" name="o_fmea" id="o_fmea" value="<?php echo HtmlEncode($fmea_edit->fmea->OldValue != null ? $fmea_edit->fmea->OldValue : $fmea_edit->fmea->CurrentValue) ?>">
<?php echo $fmea_edit->fmea->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($fmea_edit->idFactory->Visible) { // idFactory ?>
	<div id="r_idFactory" class="form-group row">
		<label id="elh_fmea_idFactory" for="x_idFactory" class="<?php echo $fmea_edit->LeftColumnClass ?>"><?php echo $fmea_edit->idFactory->caption() ?><?php echo $fmea_edit->idFactory->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $fmea_edit->RightColumnClass ?>"><div <?php echo $fmea_edit->idFactory->cellAttributes() ?>>
<span id="el_fmea_idFactory">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="fmea" data-field="x_idFactory" data-value-separator="<?php echo $fmea_edit->idFactory->displayValueSeparatorAttribute() ?>" id="x_idFactory" name="x_idFactory"<?php echo $fmea_edit->idFactory->editAttributes() ?>>
			<?php echo $fmea_edit->idFactory->selectOptionListHtml("x_idFactory") ?>
		</select>
</div>
<?php echo $fmea_edit->idFactory->Lookup->getParamTag($fmea_edit, "p_x_idFactory") ?>
</span>
<?php echo $fmea_edit->idFactory->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($fmea_edit->dateFmea->Visible) { // dateFmea ?>
	<div id="r_dateFmea" class="form-group row">
		<label id="elh_fmea_dateFmea" for="x_dateFmea" class="<?php echo $fmea_edit->LeftColumnClass ?>"><?php echo $fmea_edit->dateFmea->caption() ?><?php echo $fmea_edit->dateFmea->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $fmea_edit->RightColumnClass ?>"><div <?php echo $fmea_edit->dateFmea->cellAttributes() ?>>
<span id="el_fmea_dateFmea">
<input type="text" data-table="fmea" data-field="x_dateFmea" name="x_dateFmea" id="x_dateFmea" placeholder="<?php echo HtmlEncode($fmea_edit->dateFmea->getPlaceHolder()) ?>" value="<?php echo $fmea_edit->dateFmea->EditValue ?>"<?php echo $fmea_edit->dateFmea->editAttributes() ?>>
<?php if (!$fmea_edit->dateFmea->ReadOnly && !$fmea_edit->dateFmea->Disabled && !isset($fmea_edit->dateFmea->EditAttrs["readonly"]) && !isset($fmea_edit->dateFmea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffmeaedit", "datetimepicker"], function() {
	ew.createDateTimePicker("ffmeaedit", "x_dateFmea", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php echo $fmea_edit->dateFmea->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($fmea_edit->partnumbers->Visible) { // partnumbers ?>
	<div id="r_partnumbers" class="form-group row">
		<label id="elh_fmea_partnumbers" for="x_partnumbers" class="<?php echo $fmea_edit->LeftColumnClass ?>"><?php echo $fmea_edit->partnumbers->caption() ?><?php echo $fmea_edit->partnumbers->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $fmea_edit->RightColumnClass ?>"><div <?php echo $fmea_edit->partnumbers->cellAttributes() ?>>
<span id="el_fmea_partnumbers">
<textarea data-table="fmea" data-field="x_partnumbers" name="x_partnumbers" id="x_partnumbers" cols="35" rows="4" placeholder="<?php echo HtmlEncode($fmea_edit->partnumbers->getPlaceHolder()) ?>"<?php echo $fmea_edit->partnumbers->editAttributes() ?>><?php echo $fmea_edit->partnumbers->EditValue ?></textarea>
</span>
<?php echo $fmea_edit->partnumbers->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($fmea_edit->description->Visible) { // description ?>
	<div id="r_description" class="form-group row">
		<label id="elh_fmea_description" for="x_description" class="<?php echo $fmea_edit->LeftColumnClass ?>"><?php echo $fmea_edit->description->caption() ?><?php echo $fmea_edit->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $fmea_edit->RightColumnClass ?>"><div <?php echo $fmea_edit->description->cellAttributes() ?>>
<span id="el_fmea_description">
<textarea data-table="fmea" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?php echo HtmlEncode($fmea_edit->description->getPlaceHolder()) ?>"<?php echo $fmea_edit->description->editAttributes() ?>><?php echo $fmea_edit->description->EditValue ?></textarea>
</span>
<?php echo $fmea_edit->description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($fmea_edit->idEmployee->Visible) { // idEmployee ?>
	<div id="r_idEmployee" class="form-group row">
		<label id="elh_fmea_idEmployee" for="x_idEmployee" class="<?php echo $fmea_edit->LeftColumnClass ?>"><?php echo $fmea_edit->idEmployee->caption() ?><?php echo $fmea_edit->idEmployee->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $fmea_edit->RightColumnClass ?>"><div <?php echo $fmea_edit->idEmployee->cellAttributes() ?>>
<span id="el_fmea_idEmployee">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_idEmployee"><?php echo EmptyValue(strval($fmea_edit->idEmployee->ViewValue)) ? $Language->phrase("PleaseSelect") : $fmea_edit->idEmployee->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($fmea_edit->idEmployee->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($fmea_edit->idEmployee->ReadOnly || $fmea_edit->idEmployee->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_idEmployee[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $fmea_edit->idEmployee->Lookup->getParamTag($fmea_edit, "p_x_idEmployee") ?>
<input type="hidden" data-table="fmea" data-field="x_idEmployee" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $fmea_edit->idEmployee->displayValueSeparatorAttribute() ?>" name="x_idEmployee[]" id="x_idEmployee[]" value="<?php echo $fmea_edit->idEmployee->CurrentValue ?>"<?php echo $fmea_edit->idEmployee->editAttributes() ?>>
</span>
<?php echo $fmea_edit->idEmployee->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($fmea_edit->idworkcenter->Visible) { // idworkcenter ?>
	<div id="r_idworkcenter" class="form-group row">
		<label id="elh_fmea_idworkcenter" for="x_idworkcenter" class="<?php echo $fmea_edit->LeftColumnClass ?>"><?php echo $fmea_edit->idworkcenter->caption() ?><?php echo $fmea_edit->idworkcenter->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $fmea_edit->RightColumnClass ?>"><div <?php echo $fmea_edit->idworkcenter->cellAttributes() ?>>
<span id="el_fmea_idworkcenter">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="fmea" data-field="x_idworkcenter" data-value-separator="<?php echo $fmea_edit->idworkcenter->displayValueSeparatorAttribute() ?>" id="x_idworkcenter" name="x_idworkcenter"<?php echo $fmea_edit->idworkcenter->editAttributes() ?>>
			<?php echo $fmea_edit->idworkcenter->selectOptionListHtml("x_idworkcenter") ?>
		</select>
</div>
<?php echo $fmea_edit->idworkcenter->Lookup->getParamTag($fmea_edit, "p_x_idworkcenter") ?>
</span>
<?php echo $fmea_edit->idworkcenter->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if ($fmea->getCurrentDetailTable() != "") { ?>
<?php
	$fmea_edit->DetailPages->ValidKeys = explode(",", $fmea->getCurrentDetailTable());
	$firstActiveDetailTable = $fmea_edit->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav-tabs" id="fmea_edit_details"><!-- tabs -->
	<ul class="<?php echo $fmea_edit->DetailPages->navStyle() ?>"><!-- .nav -->
<?php
	if (in_array("processf", explode(",", $fmea->getCurrentDetailTable())) && $processf->DetailEdit) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "processf") {
			$firstActiveDetailTable = "processf";
		}
?>
		<li class="nav-item"><a class="nav-link <?php echo $fmea_edit->DetailPages->pageStyle("processf") ?>" href="#tab_processf" data-toggle="tab"><?php echo $Language->tablePhrase("processf", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("issue", explode(",", $fmea->getCurrentDetailTable())) && $issue->DetailEdit) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "issue") {
			$firstActiveDetailTable = "issue";
		}
?>
		<li class="nav-item"><a class="nav-link <?php echo $fmea_edit->DetailPages->pageStyle("issue") ?>" href="#tab_issue" data-toggle="tab"><?php echo $Language->tablePhrase("issue", "TblCaption") ?></a></li>
<?php
	}
?>
	</ul><!-- /.nav -->
	<div class="tab-content"><!-- .tab-content -->
<?php
	if (in_array("processf", explode(",", $fmea->getCurrentDetailTable())) && $processf->DetailEdit) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "processf")
			$firstActiveDetailTable = "processf";
?>
		<div class="tab-pane <?php echo $fmea_edit->DetailPages->pageStyle("processf") ?>" id="tab_processf"><!-- page* -->
<?php include_once "processfgrid.php" ?>
		</div><!-- /page* -->
<?php } ?>
<?php
	if (in_array("issue", explode(",", $fmea->getCurrentDetailTable())) && $issue->DetailEdit) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "issue")
			$firstActiveDetailTable = "issue";
?>
		<div class="tab-pane <?php echo $fmea_edit->DetailPages->pageStyle("issue") ?>" id="tab_issue"><!-- page* -->
<?php include_once "issuegrid.php" ?>
		</div><!-- /page* -->
<?php } ?>
	</div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
<?php } ?>
<?php if (!$fmea_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $fmea_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($fmea->UpdateConflict == "U") { // Record already updated by other user ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" onclick="this.form.action.value='overwrite';"><?php echo $Language->phrase("OverwriteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-reload" id="btn-reload" type="submit" onclick="this.form.action.value='show';"><?php echo $Language->phrase("ReloadBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $fmea_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
<?php } ?>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$fmea_edit->IsModal) { ?>
<?php echo $fmea_edit->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<?php
$fmea_edit->showPageFooter();
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
$fmea_edit->terminate();
?>