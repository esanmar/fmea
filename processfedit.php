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
$processf_edit = new processf_edit();

// Run the page
$processf_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$processf_edit->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fprocessfedit, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "edit";
	fprocessfedit = currentForm = new ew.Form("fprocessfedit", "edit");

	// Validate form
	fprocessfedit.validate = function() {
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
			<?php if ($processf_edit->fmea->Required) { ?>
				elm = this.getElements("x" + infix + "_fmea");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_edit->fmea->caption(), $processf_edit->fmea->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_edit->step->Required) { ?>
				elm = this.getElements("x" + infix + "_step");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_edit->step->caption(), $processf_edit->step->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_step");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($processf_edit->step->errorMessage()) ?>");
			<?php if ($processf_edit->flowchartDesc->Required) { ?>
				elm = this.getElements("x" + infix + "_flowchartDesc");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_edit->flowchartDesc->caption(), $processf_edit->flowchartDesc->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_edit->partnumber->Required) { ?>
				elm = this.getElements("x" + infix + "_partnumber");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_edit->partnumber->caption(), $processf_edit->partnumber->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_edit->operation->Required) { ?>
				elm = this.getElements("x" + infix + "_operation");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_edit->operation->caption(), $processf_edit->operation->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_edit->derivedFromNC->Required) { ?>
				elm = this.getElements("x" + infix + "_derivedFromNC[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_edit->derivedFromNC->caption(), $processf_edit->derivedFromNC->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_edit->numberOfNC->Required) { ?>
				elm = this.getElements("x" + infix + "_numberOfNC");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_edit->numberOfNC->caption(), $processf_edit->numberOfNC->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_edit->flowchart->Required) { ?>
				elm = this.getElements("x" + infix + "_flowchart");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_edit->flowchart->caption(), $processf_edit->flowchart->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_edit->subprocess->Required) { ?>
				elm = this.getElements("x" + infix + "_subprocess");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_edit->subprocess->caption(), $processf_edit->subprocess->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_edit->requirement->Required) { ?>
				elm = this.getElements("x" + infix + "_requirement");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_edit->requirement->caption(), $processf_edit->requirement->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_edit->potencialFailureMode->Required) { ?>
				elm = this.getElements("x" + infix + "_potencialFailureMode");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_edit->potencialFailureMode->caption(), $processf_edit->potencialFailureMode->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_edit->potencialFailurEffect->Required) { ?>
				elm = this.getElements("x" + infix + "_potencialFailurEffect");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_edit->potencialFailurEffect->caption(), $processf_edit->potencialFailurEffect->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_edit->kc->Required) { ?>
				elm = this.getElements("x" + infix + "_kc[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_edit->kc->caption(), $processf_edit->kc->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_edit->severity->Required) { ?>
				elm = this.getElements("x" + infix + "_severity");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_edit->severity->caption(), $processf_edit->severity->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_severity");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($processf_edit->severity->errorMessage()) ?>");

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
	fprocessfedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fprocessfedit.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fprocessfedit.lists["x_fmea"] = <?php echo $processf_edit->fmea->Lookup->toClientList($processf_edit) ?>;
	fprocessfedit.lists["x_fmea"].options = <?php echo JsonEncode($processf_edit->fmea->lookupOptions()) ?>;
	fprocessfedit.lists["x_derivedFromNC[]"] = <?php echo $processf_edit->derivedFromNC->Lookup->toClientList($processf_edit) ?>;
	fprocessfedit.lists["x_derivedFromNC[]"].options = <?php echo JsonEncode($processf_edit->derivedFromNC->options(FALSE, TRUE)) ?>;
	fprocessfedit.lists["x_kc[]"] = <?php echo $processf_edit->kc->Lookup->toClientList($processf_edit) ?>;
	fprocessfedit.lists["x_kc[]"].options = <?php echo JsonEncode($processf_edit->kc->options(FALSE, TRUE)) ?>;
	loadjs.done("fprocessfedit");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $processf_edit->showPageHeader(); ?>
<?php
$processf_edit->showMessage();
?>
<?php if (!$processf_edit->IsModal) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $processf_edit->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fprocessfedit" id="fprocessfedit" class="<?php echo $processf_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="processf">
<input type="hidden" name="k_hash" id="k_hash" value="<?php echo $processf_edit->HashValue ?>">
<?php if ($processf->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="conflict" id="conflict" value="1">
<?php } ?>
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$processf_edit->IsModal ?>">
<?php if ($processf->getCurrentMasterTable() == "fmea") { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="fmea">
<input type="hidden" name="fk_fmea" value="<?php echo $processf_edit->fmea->getSessionValue() ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($processf_edit->fmea->Visible) { // fmea ?>
	<div id="r_fmea" class="form-group row">
		<label id="elh_processf_fmea" for="x_fmea" class="<?php echo $processf_edit->LeftColumnClass ?>"><?php echo $processf_edit->fmea->caption() ?><?php echo $processf_edit->fmea->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_edit->RightColumnClass ?>"><div <?php echo $processf_edit->fmea->cellAttributes() ?>>
<?php if ($processf_edit->fmea->getSessionValue() != "") { ?>
<span id="el_processf_fmea">
<span<?php echo $processf_edit->fmea->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($processf_edit->fmea->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x_fmea" name="x_fmea" value="<?php echo HtmlEncode($processf_edit->fmea->CurrentValue) ?>">
<?php } else { ?>
<span id="el_processf_fmea">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="processf" data-field="x_fmea" data-value-separator="<?php echo $processf_edit->fmea->displayValueSeparatorAttribute() ?>" id="x_fmea" name="x_fmea"<?php echo $processf_edit->fmea->editAttributes() ?>>
			<?php echo $processf_edit->fmea->selectOptionListHtml("x_fmea") ?>
		</select>
</div>
<?php echo $processf_edit->fmea->Lookup->getParamTag($processf_edit, "p_x_fmea") ?>
</span>
<?php } ?>
<?php echo $processf_edit->fmea->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_edit->step->Visible) { // step ?>
	<div id="r_step" class="form-group row">
		<label id="elh_processf_step" for="x_step" class="<?php echo $processf_edit->LeftColumnClass ?>"><?php echo $processf_edit->step->caption() ?><?php echo $processf_edit->step->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_edit->RightColumnClass ?>"><div <?php echo $processf_edit->step->cellAttributes() ?>>
<span id="el_processf_step">
<input type="text" data-table="processf" data-field="x_step" name="x_step" id="x_step" size="30" maxlength="6" placeholder="<?php echo HtmlEncode($processf_edit->step->getPlaceHolder()) ?>" value="<?php echo $processf_edit->step->EditValue ?>"<?php echo $processf_edit->step->editAttributes() ?>>
</span>
<?php echo $processf_edit->step->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_edit->flowchartDesc->Visible) { // flowchartDesc ?>
	<div id="r_flowchartDesc" class="form-group row">
		<label id="elh_processf_flowchartDesc" for="x_flowchartDesc" class="<?php echo $processf_edit->LeftColumnClass ?>"><?php echo $processf_edit->flowchartDesc->caption() ?><?php echo $processf_edit->flowchartDesc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_edit->RightColumnClass ?>"><div <?php echo $processf_edit->flowchartDesc->cellAttributes() ?>>
<span id="el_processf_flowchartDesc">
<textarea data-table="processf" data-field="x_flowchartDesc" name="x_flowchartDesc" id="x_flowchartDesc" cols="35" rows="2" placeholder="<?php echo HtmlEncode($processf_edit->flowchartDesc->getPlaceHolder()) ?>"<?php echo $processf_edit->flowchartDesc->editAttributes() ?>><?php echo $processf_edit->flowchartDesc->EditValue ?></textarea>
</span>
<?php echo $processf_edit->flowchartDesc->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_edit->partnumber->Visible) { // partnumber ?>
	<div id="r_partnumber" class="form-group row">
		<label id="elh_processf_partnumber" for="x_partnumber" class="<?php echo $processf_edit->LeftColumnClass ?>"><?php echo $processf_edit->partnumber->caption() ?><?php echo $processf_edit->partnumber->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_edit->RightColumnClass ?>"><div <?php echo $processf_edit->partnumber->cellAttributes() ?>>
<span id="el_processf_partnumber">
<input type="text" data-table="processf" data-field="x_partnumber" name="x_partnumber" id="x_partnumber" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_edit->partnumber->getPlaceHolder()) ?>" value="<?php echo $processf_edit->partnumber->EditValue ?>"<?php echo $processf_edit->partnumber->editAttributes() ?>>
</span>
<?php echo $processf_edit->partnumber->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_edit->operation->Visible) { // operation ?>
	<div id="r_operation" class="form-group row">
		<label id="elh_processf_operation" for="x_operation" class="<?php echo $processf_edit->LeftColumnClass ?>"><?php echo $processf_edit->operation->caption() ?><?php echo $processf_edit->operation->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_edit->RightColumnClass ?>"><div <?php echo $processf_edit->operation->cellAttributes() ?>>
<span id="el_processf_operation">
<input type="text" data-table="processf" data-field="x_operation" name="x_operation" id="x_operation" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_edit->operation->getPlaceHolder()) ?>" value="<?php echo $processf_edit->operation->EditValue ?>"<?php echo $processf_edit->operation->editAttributes() ?>>
</span>
<?php echo $processf_edit->operation->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_edit->derivedFromNC->Visible) { // derivedFromNC ?>
	<div id="r_derivedFromNC" class="form-group row">
		<label id="elh_processf_derivedFromNC" class="<?php echo $processf_edit->LeftColumnClass ?>"><?php echo $processf_edit->derivedFromNC->caption() ?><?php echo $processf_edit->derivedFromNC->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_edit->RightColumnClass ?>"><div <?php echo $processf_edit->derivedFromNC->cellAttributes() ?>>
<span id="el_processf_derivedFromNC">
<?php
$selwrk = ConvertToBool($processf_edit->derivedFromNC->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="processf" data-field="x_derivedFromNC" name="x_derivedFromNC[]" id="x_derivedFromNC[]" value="1"<?php echo $selwrk ?><?php echo $processf_edit->derivedFromNC->editAttributes() ?>>
	<label class="custom-control-label" for="x_derivedFromNC[]"></label>
</div>
</span>
<?php echo $processf_edit->derivedFromNC->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_edit->numberOfNC->Visible) { // numberOfNC ?>
	<div id="r_numberOfNC" class="form-group row">
		<label id="elh_processf_numberOfNC" for="x_numberOfNC" class="<?php echo $processf_edit->LeftColumnClass ?>"><?php echo $processf_edit->numberOfNC->caption() ?><?php echo $processf_edit->numberOfNC->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_edit->RightColumnClass ?>"><div <?php echo $processf_edit->numberOfNC->cellAttributes() ?>>
<span id="el_processf_numberOfNC">
<input type="text" data-table="processf" data-field="x_numberOfNC" name="x_numberOfNC" id="x_numberOfNC" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_edit->numberOfNC->getPlaceHolder()) ?>" value="<?php echo $processf_edit->numberOfNC->EditValue ?>"<?php echo $processf_edit->numberOfNC->editAttributes() ?>>
</span>
<?php echo $processf_edit->numberOfNC->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_edit->flowchart->Visible) { // flowchart ?>
	<div id="r_flowchart" class="form-group row">
		<label id="elh_processf_flowchart" for="x_flowchart" class="<?php echo $processf_edit->LeftColumnClass ?>"><?php echo $processf_edit->flowchart->caption() ?><?php echo $processf_edit->flowchart->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_edit->RightColumnClass ?>"><div <?php echo $processf_edit->flowchart->cellAttributes() ?>>
<span id="el_processf_flowchart">
<input type="text" data-table="processf" data-field="x_flowchart" name="x_flowchart" id="x_flowchart" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_edit->flowchart->getPlaceHolder()) ?>" value="<?php echo $processf_edit->flowchart->EditValue ?>"<?php echo $processf_edit->flowchart->editAttributes() ?>>
</span>
<?php echo $processf_edit->flowchart->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_edit->subprocess->Visible) { // subprocess ?>
	<div id="r_subprocess" class="form-group row">
		<label id="elh_processf_subprocess" for="x_subprocess" class="<?php echo $processf_edit->LeftColumnClass ?>"><?php echo $processf_edit->subprocess->caption() ?><?php echo $processf_edit->subprocess->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_edit->RightColumnClass ?>"><div <?php echo $processf_edit->subprocess->cellAttributes() ?>>
<span id="el_processf_subprocess">
<input type="text" data-table="processf" data-field="x_subprocess" name="x_subprocess" id="x_subprocess" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_edit->subprocess->getPlaceHolder()) ?>" value="<?php echo $processf_edit->subprocess->EditValue ?>"<?php echo $processf_edit->subprocess->editAttributes() ?>>
</span>
<?php echo $processf_edit->subprocess->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_edit->requirement->Visible) { // requirement ?>
	<div id="r_requirement" class="form-group row">
		<label id="elh_processf_requirement" for="x_requirement" class="<?php echo $processf_edit->LeftColumnClass ?>"><?php echo $processf_edit->requirement->caption() ?><?php echo $processf_edit->requirement->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_edit->RightColumnClass ?>"><div <?php echo $processf_edit->requirement->cellAttributes() ?>>
<span id="el_processf_requirement">
<input type="text" data-table="processf" data-field="x_requirement" name="x_requirement" id="x_requirement" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_edit->requirement->getPlaceHolder()) ?>" value="<?php echo $processf_edit->requirement->EditValue ?>"<?php echo $processf_edit->requirement->editAttributes() ?>>
</span>
<?php echo $processf_edit->requirement->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_edit->potencialFailureMode->Visible) { // potencialFailureMode ?>
	<div id="r_potencialFailureMode" class="form-group row">
		<label id="elh_processf_potencialFailureMode" for="x_potencialFailureMode" class="<?php echo $processf_edit->LeftColumnClass ?>"><?php echo $processf_edit->potencialFailureMode->caption() ?><?php echo $processf_edit->potencialFailureMode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_edit->RightColumnClass ?>"><div <?php echo $processf_edit->potencialFailureMode->cellAttributes() ?>>
<span id="el_processf_potencialFailureMode">
<input type="text" data-table="processf" data-field="x_potencialFailureMode" name="x_potencialFailureMode" id="x_potencialFailureMode" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_edit->potencialFailureMode->getPlaceHolder()) ?>" value="<?php echo $processf_edit->potencialFailureMode->EditValue ?>"<?php echo $processf_edit->potencialFailureMode->editAttributes() ?>>
</span>
<?php echo $processf_edit->potencialFailureMode->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_edit->potencialFailurEffect->Visible) { // potencialFailurEffect ?>
	<div id="r_potencialFailurEffect" class="form-group row">
		<label id="elh_processf_potencialFailurEffect" for="x_potencialFailurEffect" class="<?php echo $processf_edit->LeftColumnClass ?>"><?php echo $processf_edit->potencialFailurEffect->caption() ?><?php echo $processf_edit->potencialFailurEffect->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_edit->RightColumnClass ?>"><div <?php echo $processf_edit->potencialFailurEffect->cellAttributes() ?>>
<span id="el_processf_potencialFailurEffect">
<input type="text" data-table="processf" data-field="x_potencialFailurEffect" name="x_potencialFailurEffect" id="x_potencialFailurEffect" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_edit->potencialFailurEffect->getPlaceHolder()) ?>" value="<?php echo $processf_edit->potencialFailurEffect->EditValue ?>"<?php echo $processf_edit->potencialFailurEffect->editAttributes() ?>>
</span>
<?php echo $processf_edit->potencialFailurEffect->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_edit->kc->Visible) { // kc ?>
	<div id="r_kc" class="form-group row">
		<label id="elh_processf_kc" class="<?php echo $processf_edit->LeftColumnClass ?>"><?php echo $processf_edit->kc->caption() ?><?php echo $processf_edit->kc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_edit->RightColumnClass ?>"><div <?php echo $processf_edit->kc->cellAttributes() ?>>
<span id="el_processf_kc">
<?php
$selwrk = ConvertToBool($processf_edit->kc->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="processf" data-field="x_kc" name="x_kc[]" id="x_kc[]" value="1"<?php echo $selwrk ?><?php echo $processf_edit->kc->editAttributes() ?>>
	<label class="custom-control-label" for="x_kc[]"></label>
</div>
</span>
<?php echo $processf_edit->kc->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_edit->severity->Visible) { // severity ?>
	<div id="r_severity" class="form-group row">
		<label id="elh_processf_severity" for="x_severity" class="<?php echo $processf_edit->LeftColumnClass ?>"><?php echo $processf_edit->severity->caption() ?><?php echo $processf_edit->severity->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_edit->RightColumnClass ?>"><div <?php echo $processf_edit->severity->cellAttributes() ?>>
<span id="el_processf_severity">
<input type="text" data-table="processf" data-field="x_severity" name="x_severity" id="x_severity" size="3" placeholder="<?php echo HtmlEncode($processf_edit->severity->getPlaceHolder()) ?>" value="<?php echo $processf_edit->severity->EditValue ?>"<?php echo $processf_edit->severity->editAttributes() ?>>
</span>
<?php echo $processf_edit->severity->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
	<input type="hidden" data-table="processf" data-field="x_idProcess" name="x_idProcess" id="x_idProcess" value="<?php echo HtmlEncode($processf_edit->idProcess->CurrentValue) ?>">
<?php
	if (in_array("actions", explode(",", $processf->getCurrentDetailTable())) && $actions->DetailEdit) {
?>
<?php if ($processf->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?php echo $Language->tablePhrase("actions", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "actionsgrid.php" ?>
<?php } ?>
<?php if (!$processf_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $processf_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($processf->UpdateConflict == "U") { // Record already updated by other user ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" onclick="this.form.action.value='overwrite';"><?php echo $Language->phrase("OverwriteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-reload" id="btn-reload" type="submit" onclick="this.form.action.value='show';"><?php echo $Language->phrase("ReloadBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $processf_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
<?php } ?>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$processf_edit->IsModal) { ?>
<?php echo $processf_edit->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<?php
$processf_edit->showPageFooter();
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
$processf_edit->terminate();
?>