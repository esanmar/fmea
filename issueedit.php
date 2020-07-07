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
$issue_edit = new issue_edit();

// Run the page
$issue_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$issue_edit->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fissueedit, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "edit";
	fissueedit = currentForm = new ew.Form("fissueedit", "edit");

	// Validate form
	fissueedit.validate = function() {
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
			<?php if ($issue_edit->fmea->Required) { ?>
				elm = this.getElements("x" + infix + "_fmea");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $issue_edit->fmea->caption(), $issue_edit->fmea->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($issue_edit->issue->Required) { ?>
				elm = this.getElements("x" + infix + "_issue");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $issue_edit->issue->caption(), $issue_edit->issue->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($issue_edit->date->Required) { ?>
				elm = this.getElements("x" + infix + "_date");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $issue_edit->date->caption(), $issue_edit->date->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_date");
				if (elm && !ew.checkDateDef(elm.value))
					return this.onError(elm, "<?php echo JsEncode($issue_edit->date->errorMessage()) ?>");
			<?php if ($issue_edit->cause->Required) { ?>
				elm = this.getElements("x" + infix + "_cause");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $issue_edit->cause->caption(), $issue_edit->cause->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($issue_edit->leader->Required) { ?>
				elm = this.getElements("x" + infix + "_leader[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $issue_edit->leader->caption(), $issue_edit->leader->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($issue_edit->employee->Required) { ?>
				elm = this.getElements("x" + infix + "_employee[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $issue_edit->employee->caption(), $issue_edit->employee->RequiredErrorMessage)) ?>");
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
	fissueedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fissueedit.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fissueedit.lists["x_fmea"] = <?php echo $issue_edit->fmea->Lookup->toClientList($issue_edit) ?>;
	fissueedit.lists["x_fmea"].options = <?php echo JsonEncode($issue_edit->fmea->lookupOptions()) ?>;
	fissueedit.lists["x_leader[]"] = <?php echo $issue_edit->leader->Lookup->toClientList($issue_edit) ?>;
	fissueedit.lists["x_leader[]"].options = <?php echo JsonEncode($issue_edit->leader->lookupOptions()) ?>;
	fissueedit.lists["x_employee[]"] = <?php echo $issue_edit->employee->Lookup->toClientList($issue_edit) ?>;
	fissueedit.lists["x_employee[]"].options = <?php echo JsonEncode($issue_edit->employee->lookupOptions()) ?>;
	loadjs.done("fissueedit");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $issue_edit->showPageHeader(); ?>
<?php
$issue_edit->showMessage();
?>
<?php if (!$issue_edit->IsModal) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $issue_edit->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fissueedit" id="fissueedit" class="<?php echo $issue_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="issue">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$issue_edit->IsModal ?>">
<?php if ($issue->getCurrentMasterTable() == "fmea") { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="fmea">
<input type="hidden" name="fk_fmea" value="<?php echo $issue_edit->fmea->getSessionValue() ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($issue_edit->fmea->Visible) { // fmea ?>
	<div id="r_fmea" class="form-group row">
		<label id="elh_issue_fmea" for="x_fmea" class="<?php echo $issue_edit->LeftColumnClass ?>"><?php echo $issue_edit->fmea->caption() ?><?php echo $issue_edit->fmea->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $issue_edit->RightColumnClass ?>"><div <?php echo $issue_edit->fmea->cellAttributes() ?>>
<?php if ($issue_edit->fmea->getSessionValue() != "") { ?>

<span id="el_issue_fmea">
<span<?php echo $issue_edit->fmea->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($issue_edit->fmea->EditValue)) ?>"></span>
</span>

<input type="hidden" id="x_fmea" name="x_fmea" value="<?php echo HtmlEncode($issue_edit->fmea->CurrentValue) ?>">
<?php } else { ?>

<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="issue" data-field="x_fmea" data-value-separator="<?php echo $issue_edit->fmea->displayValueSeparatorAttribute() ?>" id="x_fmea" name="x_fmea"<?php echo $issue_edit->fmea->editAttributes() ?>>
			<?php echo $issue_edit->fmea->selectOptionListHtml("x_fmea") ?>
		</select>
</div>
<?php echo $issue_edit->fmea->Lookup->getParamTag($issue_edit, "p_x_fmea") ?>

<?php } ?>

<input type="hidden" data-table="issue" data-field="x_fmea" name="o_fmea" id="o_fmea" value="<?php echo HtmlEncode($issue_edit->fmea->OldValue != null ? $issue_edit->fmea->OldValue : $issue_edit->fmea->CurrentValue) ?>">
<?php echo $issue_edit->fmea->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($issue_edit->issue->Visible) { // issue ?>
	<div id="r_issue" class="form-group row">
		<label id="elh_issue_issue" class="<?php echo $issue_edit->LeftColumnClass ?>"><?php echo $issue_edit->issue->caption() ?><?php echo $issue_edit->issue->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $issue_edit->RightColumnClass ?>"><div <?php echo $issue_edit->issue->cellAttributes() ?>>
<span id="el_issue_issue">
<span<?php echo $issue_edit->issue->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($issue_edit->issue->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="issue" data-field="x_issue" name="x_issue" id="x_issue" value="<?php echo HtmlEncode($issue_edit->issue->CurrentValue) ?>">
<?php echo $issue_edit->issue->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($issue_edit->date->Visible) { // date ?>
	<div id="r_date" class="form-group row">
		<label id="elh_issue_date" for="x_date" class="<?php echo $issue_edit->LeftColumnClass ?>"><?php echo $issue_edit->date->caption() ?><?php echo $issue_edit->date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $issue_edit->RightColumnClass ?>"><div <?php echo $issue_edit->date->cellAttributes() ?>>
<span id="el_issue_date">
<input type="text" data-table="issue" data-field="x_date" name="x_date" id="x_date" maxlength="10" placeholder="<?php echo HtmlEncode($issue_edit->date->getPlaceHolder()) ?>" value="<?php echo $issue_edit->date->EditValue ?>"<?php echo $issue_edit->date->editAttributes() ?>>
<?php if (!$issue_edit->date->ReadOnly && !$issue_edit->date->Disabled && !isset($issue_edit->date->EditAttrs["readonly"]) && !isset($issue_edit->date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fissueedit", "datetimepicker"], function() {
	ew.createDateTimePicker("fissueedit", "x_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php echo $issue_edit->date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($issue_edit->cause->Visible) { // cause ?>
	<div id="r_cause" class="form-group row">
		<label id="elh_issue_cause" for="x_cause" class="<?php echo $issue_edit->LeftColumnClass ?>"><?php echo $issue_edit->cause->caption() ?><?php echo $issue_edit->cause->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $issue_edit->RightColumnClass ?>"><div <?php echo $issue_edit->cause->cellAttributes() ?>>
<span id="el_issue_cause">
<textarea data-table="issue" data-field="x_cause" name="x_cause" id="x_cause" cols="35" rows="4" placeholder="<?php echo HtmlEncode($issue_edit->cause->getPlaceHolder()) ?>"<?php echo $issue_edit->cause->editAttributes() ?>><?php echo $issue_edit->cause->EditValue ?></textarea>
</span>
<?php echo $issue_edit->cause->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($issue_edit->leader->Visible) { // leader ?>
	<div id="r_leader" class="form-group row">
		<label id="elh_issue_leader" for="x_leader" class="<?php echo $issue_edit->LeftColumnClass ?>"><?php echo $issue_edit->leader->caption() ?><?php echo $issue_edit->leader->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $issue_edit->RightColumnClass ?>"><div <?php echo $issue_edit->leader->cellAttributes() ?>>
<span id="el_issue_leader">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_leader"><?php echo EmptyValue(strval($issue_edit->leader->ViewValue)) ? $Language->phrase("PleaseSelect") : $issue_edit->leader->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($issue_edit->leader->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($issue_edit->leader->ReadOnly || $issue_edit->leader->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_leader[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $issue_edit->leader->Lookup->getParamTag($issue_edit, "p_x_leader") ?>
<input type="hidden" data-table="issue" data-field="x_leader" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $issue_edit->leader->displayValueSeparatorAttribute() ?>" name="x_leader[]" id="x_leader[]" value="<?php echo $issue_edit->leader->CurrentValue ?>"<?php echo $issue_edit->leader->editAttributes() ?>>
</span>
<?php echo $issue_edit->leader->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($issue_edit->employee->Visible) { // employee ?>
	<div id="r_employee" class="form-group row">
		<label id="elh_issue_employee" for="x_employee" class="<?php echo $issue_edit->LeftColumnClass ?>"><?php echo $issue_edit->employee->caption() ?><?php echo $issue_edit->employee->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $issue_edit->RightColumnClass ?>"><div <?php echo $issue_edit->employee->cellAttributes() ?>>
<span id="el_issue_employee">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_employee"><?php echo EmptyValue(strval($issue_edit->employee->ViewValue)) ? $Language->phrase("PleaseSelect") : $issue_edit->employee->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($issue_edit->employee->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($issue_edit->employee->ReadOnly || $issue_edit->employee->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_employee[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $issue_edit->employee->Lookup->getParamTag($issue_edit, "p_x_employee") ?>
<input type="hidden" data-table="issue" data-field="x_employee" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $issue_edit->employee->displayValueSeparatorAttribute() ?>" name="x_employee[]" id="x_employee[]" value="<?php echo $issue_edit->employee->CurrentValue ?>"<?php echo $issue_edit->employee->editAttributes() ?>>
</span>
<?php echo $issue_edit->employee->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$issue_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $issue_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $issue_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$issue_edit->IsModal) { ?>
<?php echo $issue_edit->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<?php
$issue_edit->showPageFooter();
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
$issue_edit->terminate();
?>