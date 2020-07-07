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
$processf_add = new processf_add();

// Run the page
$processf_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$processf_add->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fprocessfadd, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "add";
	fprocessfadd = currentForm = new ew.Form("fprocessfadd", "add");

	// Validate form
	fprocessfadd.validate = function() {
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
			<?php if ($processf_add->fmea->Required) { ?>
				elm = this.getElements("x" + infix + "_fmea");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_add->fmea->caption(), $processf_add->fmea->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_add->step->Required) { ?>
				elm = this.getElements("x" + infix + "_step");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_add->step->caption(), $processf_add->step->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_step");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($processf_add->step->errorMessage()) ?>");
			<?php if ($processf_add->flowchartDesc->Required) { ?>
				elm = this.getElements("x" + infix + "_flowchartDesc");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_add->flowchartDesc->caption(), $processf_add->flowchartDesc->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_add->partnumber->Required) { ?>
				elm = this.getElements("x" + infix + "_partnumber");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_add->partnumber->caption(), $processf_add->partnumber->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_add->operation->Required) { ?>
				elm = this.getElements("x" + infix + "_operation");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_add->operation->caption(), $processf_add->operation->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_add->derivedFromNC->Required) { ?>
				elm = this.getElements("x" + infix + "_derivedFromNC[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_add->derivedFromNC->caption(), $processf_add->derivedFromNC->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_add->numberOfNC->Required) { ?>
				elm = this.getElements("x" + infix + "_numberOfNC");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_add->numberOfNC->caption(), $processf_add->numberOfNC->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_add->flowchart->Required) { ?>
				elm = this.getElements("x" + infix + "_flowchart");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_add->flowchart->caption(), $processf_add->flowchart->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_add->subprocess->Required) { ?>
				elm = this.getElements("x" + infix + "_subprocess");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_add->subprocess->caption(), $processf_add->subprocess->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_add->requirement->Required) { ?>
				elm = this.getElements("x" + infix + "_requirement");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_add->requirement->caption(), $processf_add->requirement->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_add->potencialFailureMode->Required) { ?>
				elm = this.getElements("x" + infix + "_potencialFailureMode");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_add->potencialFailureMode->caption(), $processf_add->potencialFailureMode->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_add->potencialFailurEffect->Required) { ?>
				elm = this.getElements("x" + infix + "_potencialFailurEffect");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_add->potencialFailurEffect->caption(), $processf_add->potencialFailurEffect->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_add->kc->Required) { ?>
				elm = this.getElements("x" + infix + "_kc[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_add->kc->caption(), $processf_add->kc->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_add->severity->Required) { ?>
				elm = this.getElements("x" + infix + "_severity");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_add->severity->caption(), $processf_add->severity->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_severity");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($processf_add->severity->errorMessage()) ?>");

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
	fprocessfadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fprocessfadd.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fprocessfadd.lists["x_fmea"] = <?php echo $processf_add->fmea->Lookup->toClientList($processf_add) ?>;
	fprocessfadd.lists["x_fmea"].options = <?php echo JsonEncode($processf_add->fmea->lookupOptions()) ?>;
	fprocessfadd.lists["x_derivedFromNC[]"] = <?php echo $processf_add->derivedFromNC->Lookup->toClientList($processf_add) ?>;
	fprocessfadd.lists["x_derivedFromNC[]"].options = <?php echo JsonEncode($processf_add->derivedFromNC->options(FALSE, TRUE)) ?>;
	fprocessfadd.lists["x_kc[]"] = <?php echo $processf_add->kc->Lookup->toClientList($processf_add) ?>;
	fprocessfadd.lists["x_kc[]"].options = <?php echo JsonEncode($processf_add->kc->options(FALSE, TRUE)) ?>;
	loadjs.done("fprocessfadd");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $processf_add->showPageHeader(); ?>
<?php
$processf_add->showMessage();
?>
<form name="fprocessfadd" id="fprocessfadd" class="<?php echo $processf_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="processf">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$processf_add->IsModal ?>">
<?php if ($processf->getCurrentMasterTable() == "fmea") { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="fmea">
<input type="hidden" name="fk_fmea" value="<?php echo $processf_add->fmea->getSessionValue() ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($processf_add->fmea->Visible) { // fmea ?>
	<div id="r_fmea" class="form-group row">
		<label id="elh_processf_fmea" for="x_fmea" class="<?php echo $processf_add->LeftColumnClass ?>"><?php echo $processf_add->fmea->caption() ?><?php echo $processf_add->fmea->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_add->RightColumnClass ?>"><div <?php echo $processf_add->fmea->cellAttributes() ?>>
<?php if ($processf_add->fmea->getSessionValue() != "") { ?>
<span id="el_processf_fmea">
<span<?php echo $processf_add->fmea->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($processf_add->fmea->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x_fmea" name="x_fmea" value="<?php echo HtmlEncode($processf_add->fmea->CurrentValue) ?>">
<?php } else { ?>
<span id="el_processf_fmea">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="processf" data-field="x_fmea" data-value-separator="<?php echo $processf_add->fmea->displayValueSeparatorAttribute() ?>" id="x_fmea" name="x_fmea"<?php echo $processf_add->fmea->editAttributes() ?>>
			<?php echo $processf_add->fmea->selectOptionListHtml("x_fmea") ?>
		</select>
</div>
<?php echo $processf_add->fmea->Lookup->getParamTag($processf_add, "p_x_fmea") ?>
</span>
<?php } ?>
<?php echo $processf_add->fmea->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_add->step->Visible) { // step ?>
	<div id="r_step" class="form-group row">
		<label id="elh_processf_step" for="x_step" class="<?php echo $processf_add->LeftColumnClass ?>"><?php echo $processf_add->step->caption() ?><?php echo $processf_add->step->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_add->RightColumnClass ?>"><div <?php echo $processf_add->step->cellAttributes() ?>>
<span id="el_processf_step">
<input type="text" data-table="processf" data-field="x_step" name="x_step" id="x_step" size="30" maxlength="6" placeholder="<?php echo HtmlEncode($processf_add->step->getPlaceHolder()) ?>" value="<?php echo $processf_add->step->EditValue ?>"<?php echo $processf_add->step->editAttributes() ?>>
</span>
<?php echo $processf_add->step->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_add->flowchartDesc->Visible) { // flowchartDesc ?>
	<div id="r_flowchartDesc" class="form-group row">
		<label id="elh_processf_flowchartDesc" for="x_flowchartDesc" class="<?php echo $processf_add->LeftColumnClass ?>"><?php echo $processf_add->flowchartDesc->caption() ?><?php echo $processf_add->flowchartDesc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_add->RightColumnClass ?>"><div <?php echo $processf_add->flowchartDesc->cellAttributes() ?>>
<span id="el_processf_flowchartDesc">
<textarea data-table="processf" data-field="x_flowchartDesc" name="x_flowchartDesc" id="x_flowchartDesc" cols="35" rows="2" placeholder="<?php echo HtmlEncode($processf_add->flowchartDesc->getPlaceHolder()) ?>"<?php echo $processf_add->flowchartDesc->editAttributes() ?>><?php echo $processf_add->flowchartDesc->EditValue ?></textarea>
</span>
<?php echo $processf_add->flowchartDesc->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_add->partnumber->Visible) { // partnumber ?>
	<div id="r_partnumber" class="form-group row">
		<label id="elh_processf_partnumber" for="x_partnumber" class="<?php echo $processf_add->LeftColumnClass ?>"><?php echo $processf_add->partnumber->caption() ?><?php echo $processf_add->partnumber->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_add->RightColumnClass ?>"><div <?php echo $processf_add->partnumber->cellAttributes() ?>>
<span id="el_processf_partnumber">
<input type="text" data-table="processf" data-field="x_partnumber" name="x_partnumber" id="x_partnumber" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_add->partnumber->getPlaceHolder()) ?>" value="<?php echo $processf_add->partnumber->EditValue ?>"<?php echo $processf_add->partnumber->editAttributes() ?>>
</span>
<?php echo $processf_add->partnumber->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_add->operation->Visible) { // operation ?>
	<div id="r_operation" class="form-group row">
		<label id="elh_processf_operation" for="x_operation" class="<?php echo $processf_add->LeftColumnClass ?>"><?php echo $processf_add->operation->caption() ?><?php echo $processf_add->operation->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_add->RightColumnClass ?>"><div <?php echo $processf_add->operation->cellAttributes() ?>>
<span id="el_processf_operation">
<input type="text" data-table="processf" data-field="x_operation" name="x_operation" id="x_operation" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_add->operation->getPlaceHolder()) ?>" value="<?php echo $processf_add->operation->EditValue ?>"<?php echo $processf_add->operation->editAttributes() ?>>
</span>
<?php echo $processf_add->operation->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_add->derivedFromNC->Visible) { // derivedFromNC ?>
	<div id="r_derivedFromNC" class="form-group row">
		<label id="elh_processf_derivedFromNC" class="<?php echo $processf_add->LeftColumnClass ?>"><?php echo $processf_add->derivedFromNC->caption() ?><?php echo $processf_add->derivedFromNC->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_add->RightColumnClass ?>"><div <?php echo $processf_add->derivedFromNC->cellAttributes() ?>>
<span id="el_processf_derivedFromNC">
<?php
$selwrk = ConvertToBool($processf_add->derivedFromNC->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="processf" data-field="x_derivedFromNC" name="x_derivedFromNC[]" id="x_derivedFromNC[]" value="1"<?php echo $selwrk ?><?php echo $processf_add->derivedFromNC->editAttributes() ?>>
	<label class="custom-control-label" for="x_derivedFromNC[]"></label>
</div>
</span>
<?php echo $processf_add->derivedFromNC->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_add->numberOfNC->Visible) { // numberOfNC ?>
	<div id="r_numberOfNC" class="form-group row">
		<label id="elh_processf_numberOfNC" for="x_numberOfNC" class="<?php echo $processf_add->LeftColumnClass ?>"><?php echo $processf_add->numberOfNC->caption() ?><?php echo $processf_add->numberOfNC->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_add->RightColumnClass ?>"><div <?php echo $processf_add->numberOfNC->cellAttributes() ?>>
<span id="el_processf_numberOfNC">
<input type="text" data-table="processf" data-field="x_numberOfNC" name="x_numberOfNC" id="x_numberOfNC" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_add->numberOfNC->getPlaceHolder()) ?>" value="<?php echo $processf_add->numberOfNC->EditValue ?>"<?php echo $processf_add->numberOfNC->editAttributes() ?>>
</span>
<?php echo $processf_add->numberOfNC->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_add->flowchart->Visible) { // flowchart ?>
	<div id="r_flowchart" class="form-group row">
		<label id="elh_processf_flowchart" for="x_flowchart" class="<?php echo $processf_add->LeftColumnClass ?>"><?php echo $processf_add->flowchart->caption() ?><?php echo $processf_add->flowchart->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_add->RightColumnClass ?>"><div <?php echo $processf_add->flowchart->cellAttributes() ?>>
<span id="el_processf_flowchart">
<input type="text" data-table="processf" data-field="x_flowchart" name="x_flowchart" id="x_flowchart" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_add->flowchart->getPlaceHolder()) ?>" value="<?php echo $processf_add->flowchart->EditValue ?>"<?php echo $processf_add->flowchart->editAttributes() ?>>
</span>
<?php echo $processf_add->flowchart->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_add->subprocess->Visible) { // subprocess ?>
	<div id="r_subprocess" class="form-group row">
		<label id="elh_processf_subprocess" for="x_subprocess" class="<?php echo $processf_add->LeftColumnClass ?>"><?php echo $processf_add->subprocess->caption() ?><?php echo $processf_add->subprocess->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_add->RightColumnClass ?>"><div <?php echo $processf_add->subprocess->cellAttributes() ?>>
<span id="el_processf_subprocess">
<input type="text" data-table="processf" data-field="x_subprocess" name="x_subprocess" id="x_subprocess" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_add->subprocess->getPlaceHolder()) ?>" value="<?php echo $processf_add->subprocess->EditValue ?>"<?php echo $processf_add->subprocess->editAttributes() ?>>
</span>
<?php echo $processf_add->subprocess->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_add->requirement->Visible) { // requirement ?>
	<div id="r_requirement" class="form-group row">
		<label id="elh_processf_requirement" for="x_requirement" class="<?php echo $processf_add->LeftColumnClass ?>"><?php echo $processf_add->requirement->caption() ?><?php echo $processf_add->requirement->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_add->RightColumnClass ?>"><div <?php echo $processf_add->requirement->cellAttributes() ?>>
<span id="el_processf_requirement">
<input type="text" data-table="processf" data-field="x_requirement" name="x_requirement" id="x_requirement" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_add->requirement->getPlaceHolder()) ?>" value="<?php echo $processf_add->requirement->EditValue ?>"<?php echo $processf_add->requirement->editAttributes() ?>>
</span>
<?php echo $processf_add->requirement->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_add->potencialFailureMode->Visible) { // potencialFailureMode ?>
	<div id="r_potencialFailureMode" class="form-group row">
		<label id="elh_processf_potencialFailureMode" for="x_potencialFailureMode" class="<?php echo $processf_add->LeftColumnClass ?>"><?php echo $processf_add->potencialFailureMode->caption() ?><?php echo $processf_add->potencialFailureMode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_add->RightColumnClass ?>"><div <?php echo $processf_add->potencialFailureMode->cellAttributes() ?>>
<span id="el_processf_potencialFailureMode">
<input type="text" data-table="processf" data-field="x_potencialFailureMode" name="x_potencialFailureMode" id="x_potencialFailureMode" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_add->potencialFailureMode->getPlaceHolder()) ?>" value="<?php echo $processf_add->potencialFailureMode->EditValue ?>"<?php echo $processf_add->potencialFailureMode->editAttributes() ?>>
</span>
<?php echo $processf_add->potencialFailureMode->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_add->potencialFailurEffect->Visible) { // potencialFailurEffect ?>
	<div id="r_potencialFailurEffect" class="form-group row">
		<label id="elh_processf_potencialFailurEffect" for="x_potencialFailurEffect" class="<?php echo $processf_add->LeftColumnClass ?>"><?php echo $processf_add->potencialFailurEffect->caption() ?><?php echo $processf_add->potencialFailurEffect->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_add->RightColumnClass ?>"><div <?php echo $processf_add->potencialFailurEffect->cellAttributes() ?>>
<span id="el_processf_potencialFailurEffect">
<input type="text" data-table="processf" data-field="x_potencialFailurEffect" name="x_potencialFailurEffect" id="x_potencialFailurEffect" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_add->potencialFailurEffect->getPlaceHolder()) ?>" value="<?php echo $processf_add->potencialFailurEffect->EditValue ?>"<?php echo $processf_add->potencialFailurEffect->editAttributes() ?>>
</span>
<?php echo $processf_add->potencialFailurEffect->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_add->kc->Visible) { // kc ?>
	<div id="r_kc" class="form-group row">
		<label id="elh_processf_kc" class="<?php echo $processf_add->LeftColumnClass ?>"><?php echo $processf_add->kc->caption() ?><?php echo $processf_add->kc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_add->RightColumnClass ?>"><div <?php echo $processf_add->kc->cellAttributes() ?>>
<span id="el_processf_kc">
<?php
$selwrk = ConvertToBool($processf_add->kc->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="processf" data-field="x_kc" name="x_kc[]" id="x_kc[]" value="1"<?php echo $selwrk ?><?php echo $processf_add->kc->editAttributes() ?>>
	<label class="custom-control-label" for="x_kc[]"></label>
</div>
</span>
<?php echo $processf_add->kc->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($processf_add->severity->Visible) { // severity ?>
	<div id="r_severity" class="form-group row">
		<label id="elh_processf_severity" for="x_severity" class="<?php echo $processf_add->LeftColumnClass ?>"><?php echo $processf_add->severity->caption() ?><?php echo $processf_add->severity->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $processf_add->RightColumnClass ?>"><div <?php echo $processf_add->severity->cellAttributes() ?>>
<span id="el_processf_severity">
<input type="text" data-table="processf" data-field="x_severity" name="x_severity" id="x_severity" size="3" placeholder="<?php echo HtmlEncode($processf_add->severity->getPlaceHolder()) ?>" value="<?php echo $processf_add->severity->EditValue ?>"<?php echo $processf_add->severity->editAttributes() ?>>
</span>
<?php echo $processf_add->severity->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php
	if (in_array("actions", explode(",", $processf->getCurrentDetailTable())) && $actions->DetailAdd) {
?>
<?php if ($processf->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?php echo $Language->tablePhrase("actions", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "actionsgrid.php" ?>
<?php } ?>
<?php if (!$processf_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $processf_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $processf_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$processf_add->showPageFooter();
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
$processf_add->terminate();
?>