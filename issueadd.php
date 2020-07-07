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
$issue_add = new issue_add();

// Run the page
$issue_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$issue_add->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fissueadd, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "add";
	fissueadd = currentForm = new ew.Form("fissueadd", "add");

	// Validate form
	fissueadd.validate = function() {
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
			<?php if ($issue_add->fmea->Required) { ?>
				elm = this.getElements("x" + infix + "_fmea");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $issue_add->fmea->caption(), $issue_add->fmea->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($issue_add->date->Required) { ?>
				elm = this.getElements("x" + infix + "_date");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $issue_add->date->caption(), $issue_add->date->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_date");
				if (elm && !ew.checkDateDef(elm.value))
					return this.onError(elm, "<?php echo JsEncode($issue_add->date->errorMessage()) ?>");
			<?php if ($issue_add->cause->Required) { ?>
				elm = this.getElements("x" + infix + "_cause");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $issue_add->cause->caption(), $issue_add->cause->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($issue_add->leader->Required) { ?>
				elm = this.getElements("x" + infix + "_leader[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $issue_add->leader->caption(), $issue_add->leader->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($issue_add->employee->Required) { ?>
				elm = this.getElements("x" + infix + "_employee[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $issue_add->employee->caption(), $issue_add->employee->RequiredErrorMessage)) ?>");
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
	fissueadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fissueadd.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fissueadd.lists["x_fmea"] = <?php echo $issue_add->fmea->Lookup->toClientList($issue_add) ?>;
	fissueadd.lists["x_fmea"].options = <?php echo JsonEncode($issue_add->fmea->lookupOptions()) ?>;
	fissueadd.lists["x_leader[]"] = <?php echo $issue_add->leader->Lookup->toClientList($issue_add) ?>;
	fissueadd.lists["x_leader[]"].options = <?php echo JsonEncode($issue_add->leader->lookupOptions()) ?>;
	fissueadd.lists["x_employee[]"] = <?php echo $issue_add->employee->Lookup->toClientList($issue_add) ?>;
	fissueadd.lists["x_employee[]"].options = <?php echo JsonEncode($issue_add->employee->lookupOptions()) ?>;
	loadjs.done("fissueadd");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $issue_add->showPageHeader(); ?>
<?php
$issue_add->showMessage();
?>
<form name="fissueadd" id="fissueadd" class="<?php echo $issue_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="issue">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$issue_add->IsModal ?>">
<?php if ($issue->getCurrentMasterTable() == "fmea") { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="fmea">
<input type="hidden" name="fk_fmea" value="<?php echo $issue_add->fmea->getSessionValue() ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($issue_add->fmea->Visible) { // fmea ?>
	<div id="r_fmea" class="form-group row">
		<label id="elh_issue_fmea" for="x_fmea" class="<?php echo $issue_add->LeftColumnClass ?>"><?php echo $issue_add->fmea->caption() ?><?php echo $issue_add->fmea->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $issue_add->RightColumnClass ?>"><div <?php echo $issue_add->fmea->cellAttributes() ?>>
<?php if ($issue_add->fmea->getSessionValue() != "") { ?>
<span id="el_issue_fmea">
<span<?php echo $issue_add->fmea->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($issue_add->fmea->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x_fmea" name="x_fmea" value="<?php echo HtmlEncode($issue_add->fmea->CurrentValue) ?>">
<?php } else { ?>
<span id="el_issue_fmea">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="issue" data-field="x_fmea" data-value-separator="<?php echo $issue_add->fmea->displayValueSeparatorAttribute() ?>" id="x_fmea" name="x_fmea"<?php echo $issue_add->fmea->editAttributes() ?>>
			<?php echo $issue_add->fmea->selectOptionListHtml("x_fmea") ?>
		</select>
</div>
<?php echo $issue_add->fmea->Lookup->getParamTag($issue_add, "p_x_fmea") ?>
</span>
<?php } ?>
<?php echo $issue_add->fmea->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($issue_add->date->Visible) { // date ?>
	<div id="r_date" class="form-group row">
		<label id="elh_issue_date" for="x_date" class="<?php echo $issue_add->LeftColumnClass ?>"><?php echo $issue_add->date->caption() ?><?php echo $issue_add->date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $issue_add->RightColumnClass ?>"><div <?php echo $issue_add->date->cellAttributes() ?>>
<span id="el_issue_date">
<input type="text" data-table="issue" data-field="x_date" name="x_date" id="x_date" maxlength="10" placeholder="<?php echo HtmlEncode($issue_add->date->getPlaceHolder()) ?>" value="<?php echo $issue_add->date->EditValue ?>"<?php echo $issue_add->date->editAttributes() ?>>
<?php if (!$issue_add->date->ReadOnly && !$issue_add->date->Disabled && !isset($issue_add->date->EditAttrs["readonly"]) && !isset($issue_add->date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fissueadd", "datetimepicker"], function() {
	ew.createDateTimePicker("fissueadd", "x_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php echo $issue_add->date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($issue_add->cause->Visible) { // cause ?>
	<div id="r_cause" class="form-group row">
		<label id="elh_issue_cause" for="x_cause" class="<?php echo $issue_add->LeftColumnClass ?>"><?php echo $issue_add->cause->caption() ?><?php echo $issue_add->cause->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $issue_add->RightColumnClass ?>"><div <?php echo $issue_add->cause->cellAttributes() ?>>
<span id="el_issue_cause">
<textarea data-table="issue" data-field="x_cause" name="x_cause" id="x_cause" cols="35" rows="4" placeholder="<?php echo HtmlEncode($issue_add->cause->getPlaceHolder()) ?>"<?php echo $issue_add->cause->editAttributes() ?>><?php echo $issue_add->cause->EditValue ?></textarea>
</span>
<?php echo $issue_add->cause->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($issue_add->leader->Visible) { // leader ?>
	<div id="r_leader" class="form-group row">
		<label id="elh_issue_leader" for="x_leader" class="<?php echo $issue_add->LeftColumnClass ?>"><?php echo $issue_add->leader->caption() ?><?php echo $issue_add->leader->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $issue_add->RightColumnClass ?>"><div <?php echo $issue_add->leader->cellAttributes() ?>>
<span id="el_issue_leader">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_leader"><?php echo EmptyValue(strval($issue_add->leader->ViewValue)) ? $Language->phrase("PleaseSelect") : $issue_add->leader->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($issue_add->leader->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($issue_add->leader->ReadOnly || $issue_add->leader->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_leader[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $issue_add->leader->Lookup->getParamTag($issue_add, "p_x_leader") ?>
<input type="hidden" data-table="issue" data-field="x_leader" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $issue_add->leader->displayValueSeparatorAttribute() ?>" name="x_leader[]" id="x_leader[]" value="<?php echo $issue_add->leader->CurrentValue ?>"<?php echo $issue_add->leader->editAttributes() ?>>
</span>
<?php echo $issue_add->leader->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($issue_add->employee->Visible) { // employee ?>
	<div id="r_employee" class="form-group row">
		<label id="elh_issue_employee" for="x_employee" class="<?php echo $issue_add->LeftColumnClass ?>"><?php echo $issue_add->employee->caption() ?><?php echo $issue_add->employee->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $issue_add->RightColumnClass ?>"><div <?php echo $issue_add->employee->cellAttributes() ?>>
<span id="el_issue_employee">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_employee"><?php echo EmptyValue(strval($issue_add->employee->ViewValue)) ? $Language->phrase("PleaseSelect") : $issue_add->employee->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($issue_add->employee->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($issue_add->employee->ReadOnly || $issue_add->employee->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_employee[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $issue_add->employee->Lookup->getParamTag($issue_add, "p_x_employee") ?>
<input type="hidden" data-table="issue" data-field="x_employee" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $issue_add->employee->displayValueSeparatorAttribute() ?>" name="x_employee[]" id="x_employee[]" value="<?php echo $issue_add->employee->CurrentValue ?>"<?php echo $issue_add->employee->editAttributes() ?>>
</span>
<?php echo $issue_add->employee->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$issue_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $issue_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $issue_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$issue_add->showPageFooter();
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
$issue_add->terminate();
?>