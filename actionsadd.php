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
$actions_add = new actions_add();

// Run the page
$actions_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$actions_add->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var factionsadd, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "add";
	factionsadd = currentForm = new ew.Form("factionsadd", "add");

	// Validate form
	factionsadd.validate = function() {
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
			<?php if ($actions_add->idCause->Required) { ?>
				elm = this.getElements("x" + infix + "_idCause");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->idCause->caption(), $actions_add->idCause->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_add->potentialCauses->Required) { ?>
				elm = this.getElements("x" + infix + "_potentialCauses");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->potentialCauses->caption(), $actions_add->potentialCauses->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_add->currentPreventiveControlMethod->Required) { ?>
				elm = this.getElements("x" + infix + "_currentPreventiveControlMethod");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->currentPreventiveControlMethod->caption(), $actions_add->currentPreventiveControlMethod->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_add->occurrence->Required) { ?>
				elm = this.getElements("x" + infix + "_occurrence");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->occurrence->caption(), $actions_add->occurrence->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_occurrence");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_add->occurrence->errorMessage()) ?>");
			<?php if ($actions_add->currentControlMethod->Required) { ?>
				elm = this.getElements("x" + infix + "_currentControlMethod");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->currentControlMethod->caption(), $actions_add->currentControlMethod->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_add->detection->Required) { ?>
				elm = this.getElements("x" + infix + "_detection");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->detection->caption(), $actions_add->detection->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_detection");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_add->detection->errorMessage()) ?>");
			<?php if ($actions_add->RPNCalc->Required) { ?>
				elm = this.getElements("x" + infix + "_RPNCalc");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->RPNCalc->caption(), $actions_add->RPNCalc->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_RPNCalc");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_add->RPNCalc->errorMessage()) ?>");
			<?php if ($actions_add->recomendedAction->Required) { ?>
				elm = this.getElements("x" + infix + "_recomendedAction");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->recomendedAction->caption(), $actions_add->recomendedAction->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_add->idResponsible->Required) { ?>
				elm = this.getElements("x" + infix + "_idResponsible[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->idResponsible->caption(), $actions_add->idResponsible->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_add->targetDate->Required) { ?>
				elm = this.getElements("x" + infix + "_targetDate");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->targetDate->caption(), $actions_add->targetDate->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_targetDate");
				if (elm && !ew.checkShortEuroDate(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_add->targetDate->errorMessage()) ?>");
			<?php if ($actions_add->revisedKc->Required) { ?>
				elm = this.getElements("x" + infix + "_revisedKc[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->revisedKc->caption(), $actions_add->revisedKc->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_add->expectedSeverity->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedSeverity");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->expectedSeverity->caption(), $actions_add->expectedSeverity->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_expectedSeverity");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_add->expectedSeverity->errorMessage()) ?>");
			<?php if ($actions_add->expectedOccurrence->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedOccurrence");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->expectedOccurrence->caption(), $actions_add->expectedOccurrence->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_expectedOccurrence");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_add->expectedOccurrence->errorMessage()) ?>");
			<?php if ($actions_add->expectedDetection->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedDetection");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->expectedDetection->caption(), $actions_add->expectedDetection->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_expectedDetection");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_add->expectedDetection->errorMessage()) ?>");
			<?php if ($actions_add->expectedClosureDate->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedClosureDate");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->expectedClosureDate->caption(), $actions_add->expectedClosureDate->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_expectedClosureDate");
				if (elm && !ew.checkShortDate(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_add->expectedClosureDate->errorMessage()) ?>");
			<?php if ($actions_add->recomendedActiondet->Required) { ?>
				elm = this.getElements("x" + infix + "_recomendedActiondet");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->recomendedActiondet->caption(), $actions_add->recomendedActiondet->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_add->idResponsibleDet->Required) { ?>
				elm = this.getElements("x" + infix + "_idResponsibleDet[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->idResponsibleDet->caption(), $actions_add->idResponsibleDet->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_add->targetDatedet->Required) { ?>
				elm = this.getElements("x" + infix + "_targetDatedet");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->targetDatedet->caption(), $actions_add->targetDatedet->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_targetDatedet");
				if (elm && !ew.checkShortEuroDate(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_add->targetDatedet->errorMessage()) ?>");
			<?php if ($actions_add->kcdet->Required) { ?>
				elm = this.getElements("x" + infix + "_kcdet[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->kcdet->caption(), $actions_add->kcdet->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($actions_add->expectedSeveritydet->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedSeveritydet");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->expectedSeveritydet->caption(), $actions_add->expectedSeveritydet->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_expectedSeveritydet");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_add->expectedSeveritydet->errorMessage()) ?>");
			<?php if ($actions_add->expectedOccurrencedet->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedOccurrencedet");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->expectedOccurrencedet->caption(), $actions_add->expectedOccurrencedet->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_expectedOccurrencedet");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_add->expectedOccurrencedet->errorMessage()) ?>");
			<?php if ($actions_add->expectedDetectiondet->Required) { ?>
				elm = this.getElements("x" + infix + "_expectedDetectiondet");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->expectedDetectiondet->caption(), $actions_add->expectedDetectiondet->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_expectedDetectiondet");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_add->expectedDetectiondet->errorMessage()) ?>");
			<?php if ($actions_add->revisedClosureDatedet->Required) { ?>
				elm = this.getElements("x" + infix + "_revisedClosureDatedet");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->revisedClosureDatedet->caption(), $actions_add->revisedClosureDatedet->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_revisedClosureDatedet");
				if (elm && !ew.checkShortEuroDate(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_add->revisedClosureDatedet->errorMessage()) ?>");
			<?php if ($actions_add->revisedSeverity->Required) { ?>
				elm = this.getElements("x" + infix + "_revisedSeverity");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->revisedSeverity->caption(), $actions_add->revisedSeverity->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_revisedSeverity");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_add->revisedSeverity->errorMessage()) ?>");
			<?php if ($actions_add->revisedOccurrence->Required) { ?>
				elm = this.getElements("x" + infix + "_revisedOccurrence");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->revisedOccurrence->caption(), $actions_add->revisedOccurrence->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_revisedOccurrence");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_add->revisedOccurrence->errorMessage()) ?>");
			<?php if ($actions_add->revisedDetection->Required) { ?>
				elm = this.getElements("x" + infix + "_revisedDetection");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->revisedDetection->caption(), $actions_add->revisedDetection->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_revisedDetection");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_add->revisedDetection->errorMessage()) ?>");
			<?php if ($actions_add->revisedRpn->Required) { ?>
				elm = this.getElements("x" + infix + "_revisedRpn");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $actions_add->revisedRpn->caption(), $actions_add->revisedRpn->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_revisedRpn");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($actions_add->revisedRpn->errorMessage()) ?>");

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
	factionsadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	factionsadd.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	factionsadd.lists["x_idCause"] = <?php echo $actions_add->idCause->Lookup->toClientList($actions_add) ?>;
	factionsadd.lists["x_idCause"].options = <?php echo JsonEncode($actions_add->idCause->lookupOptions()) ?>;
	factionsadd.lists["x_idResponsible[]"] = <?php echo $actions_add->idResponsible->Lookup->toClientList($actions_add) ?>;
	factionsadd.lists["x_idResponsible[]"].options = <?php echo JsonEncode($actions_add->idResponsible->lookupOptions()) ?>;
	factionsadd.lists["x_revisedKc[]"] = <?php echo $actions_add->revisedKc->Lookup->toClientList($actions_add) ?>;
	factionsadd.lists["x_revisedKc[]"].options = <?php echo JsonEncode($actions_add->revisedKc->options(FALSE, TRUE)) ?>;
	factionsadd.lists["x_idResponsibleDet[]"] = <?php echo $actions_add->idResponsibleDet->Lookup->toClientList($actions_add) ?>;
	factionsadd.lists["x_idResponsibleDet[]"].options = <?php echo JsonEncode($actions_add->idResponsibleDet->lookupOptions()) ?>;
	factionsadd.lists["x_kcdet[]"] = <?php echo $actions_add->kcdet->Lookup->toClientList($actions_add) ?>;
	factionsadd.lists["x_kcdet[]"].options = <?php echo JsonEncode($actions_add->kcdet->options(FALSE, TRUE)) ?>;
	loadjs.done("factionsadd");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

		if ($this->idProcess->CurrentValue !== NULL && $this->idProcess->CurrentValue !== "")
		{
			$det2=$this->idProcess->CurrentValue;
			$cau=$this->idCause->CurrentValue;
			$sev = ExecuteScalar("SELECT severity FROM processf WHERE idProcess = $det2");
			console.log($sev);
			$this->severity->ViewValue = $sev;
			$this->severity->CurrentValue = $sev;
			$this->expectedSeverity->CurrentValue = $sev;
			$this->expectedSeverity->ViewValue = $sev;
		}
});
</script>
<?php $actions_add->showPageHeader(); ?>
<?php
$actions_add->showMessage();
?>
<form name="factionsadd" id="factionsadd" class="<?php echo $actions_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="actions">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$actions_add->IsModal ?>">
<?php if ($actions->getCurrentMasterTable() == "processf") { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="processf">
<input type="hidden" name="fk_idProcess" value="<?php echo $actions_add->idProcess->getSessionValue() ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($actions_add->idCause->Visible) { // idCause ?>
	<div id="r_idCause" class="form-group row">
		<label id="elh_actions_idCause" for="x_idCause" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->idCause->caption() ?><?php echo $actions_add->idCause->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->idCause->cellAttributes() ?>>
<span id="el_actions_idCause">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="actions" data-field="x_idCause" data-value-separator="<?php echo $actions_add->idCause->displayValueSeparatorAttribute() ?>" id="x_idCause" name="x_idCause"<?php echo $actions_add->idCause->editAttributes() ?>>
			<?php echo $actions_add->idCause->selectOptionListHtml("x_idCause") ?>
		</select>
</div>
<?php echo $actions_add->idCause->Lookup->getParamTag($actions_add, "p_x_idCause") ?>
</span>
<?php echo $actions_add->idCause->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->potentialCauses->Visible) { // potentialCauses ?>
	<div id="r_potentialCauses" class="form-group row">
		<label id="elh_actions_potentialCauses" for="x_potentialCauses" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->potentialCauses->caption() ?><?php echo $actions_add->potentialCauses->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->potentialCauses->cellAttributes() ?>>
<span id="el_actions_potentialCauses">
<textarea data-table="actions" data-field="x_potentialCauses" name="x_potentialCauses" id="x_potentialCauses" cols="35" rows="4" placeholder="<?php echo HtmlEncode($actions_add->potentialCauses->getPlaceHolder()) ?>"<?php echo $actions_add->potentialCauses->editAttributes() ?>><?php echo $actions_add->potentialCauses->EditValue ?></textarea>
</span>
<?php echo $actions_add->potentialCauses->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->currentPreventiveControlMethod->Visible) { // currentPreventiveControlMethod ?>
	<div id="r_currentPreventiveControlMethod" class="form-group row">
		<label id="elh_actions_currentPreventiveControlMethod" for="x_currentPreventiveControlMethod" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->currentPreventiveControlMethod->caption() ?><?php echo $actions_add->currentPreventiveControlMethod->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->currentPreventiveControlMethod->cellAttributes() ?>>
<span id="el_actions_currentPreventiveControlMethod">
<input type="text" data-table="actions" data-field="x_currentPreventiveControlMethod" name="x_currentPreventiveControlMethod" id="x_currentPreventiveControlMethod" size="7" maxlength="255" placeholder="<?php echo HtmlEncode($actions_add->currentPreventiveControlMethod->getPlaceHolder()) ?>" value="<?php echo $actions_add->currentPreventiveControlMethod->EditValue ?>"<?php echo $actions_add->currentPreventiveControlMethod->editAttributes() ?>>
</span>
<?php echo $actions_add->currentPreventiveControlMethod->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->occurrence->Visible) { // occurrence ?>
	<div id="r_occurrence" class="form-group row">
		<label id="elh_actions_occurrence" for="x_occurrence" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->occurrence->caption() ?><?php echo $actions_add->occurrence->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->occurrence->cellAttributes() ?>>
<span id="el_actions_occurrence">
<input type="text" data-table="actions" data-field="x_occurrence" name="x_occurrence" id="x_occurrence" size="3" placeholder="<?php echo HtmlEncode($actions_add->occurrence->getPlaceHolder()) ?>" value="<?php echo $actions_add->occurrence->EditValue ?>"<?php echo $actions_add->occurrence->editAttributes() ?>>
</span>
<?php echo $actions_add->occurrence->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->currentControlMethod->Visible) { // currentControlMethod ?>
	<div id="r_currentControlMethod" class="form-group row">
		<label id="elh_actions_currentControlMethod" for="x_currentControlMethod" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->currentControlMethod->caption() ?><?php echo $actions_add->currentControlMethod->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->currentControlMethod->cellAttributes() ?>>
<span id="el_actions_currentControlMethod">
<input type="text" data-table="actions" data-field="x_currentControlMethod" name="x_currentControlMethod" id="x_currentControlMethod" size="10" maxlength="255" placeholder="<?php echo HtmlEncode($actions_add->currentControlMethod->getPlaceHolder()) ?>" value="<?php echo $actions_add->currentControlMethod->EditValue ?>"<?php echo $actions_add->currentControlMethod->editAttributes() ?>>
</span>
<?php echo $actions_add->currentControlMethod->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->detection->Visible) { // detection ?>
	<div id="r_detection" class="form-group row">
		<label id="elh_actions_detection" for="x_detection" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->detection->caption() ?><?php echo $actions_add->detection->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->detection->cellAttributes() ?>>
<span id="el_actions_detection">
<input type="text" data-table="actions" data-field="x_detection" name="x_detection" id="x_detection" size="3" placeholder="<?php echo HtmlEncode($actions_add->detection->getPlaceHolder()) ?>" value="<?php echo $actions_add->detection->EditValue ?>"<?php echo $actions_add->detection->editAttributes() ?>>
</span>
<?php echo $actions_add->detection->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->RPNCalc->Visible) { // RPNCalc ?>
	<div id="r_RPNCalc" class="form-group row">
		<label id="elh_actions_RPNCalc" for="x_RPNCalc" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->RPNCalc->caption() ?><?php echo $actions_add->RPNCalc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->RPNCalc->cellAttributes() ?>>
<span id="el_actions_RPNCalc">
<input type="text" data-table="actions" data-field="x_RPNCalc" name="x_RPNCalc" id="x_RPNCalc" size="30" maxlength="31" placeholder="<?php echo HtmlEncode($actions_add->RPNCalc->getPlaceHolder()) ?>" value="<?php echo $actions_add->RPNCalc->EditValue ?>"<?php echo $actions_add->RPNCalc->editAttributes() ?>>
</span>
<?php echo $actions_add->RPNCalc->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->recomendedAction->Visible) { // recomendedAction ?>
	<div id="r_recomendedAction" class="form-group row">
		<label id="elh_actions_recomendedAction" for="x_recomendedAction" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->recomendedAction->caption() ?><?php echo $actions_add->recomendedAction->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->recomendedAction->cellAttributes() ?>>
<span id="el_actions_recomendedAction">
<textarea data-table="actions" data-field="x_recomendedAction" name="x_recomendedAction" id="x_recomendedAction" cols="10" rows="4" placeholder="<?php echo HtmlEncode($actions_add->recomendedAction->getPlaceHolder()) ?>"<?php echo $actions_add->recomendedAction->editAttributes() ?>><?php echo $actions_add->recomendedAction->EditValue ?></textarea>
</span>
<?php echo $actions_add->recomendedAction->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->idResponsible->Visible) { // idResponsible ?>
	<div id="r_idResponsible" class="form-group row">
		<label id="elh_actions_idResponsible" for="x_idResponsible" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->idResponsible->caption() ?><?php echo $actions_add->idResponsible->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->idResponsible->cellAttributes() ?>>
<span id="el_actions_idResponsible">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_idResponsible"><?php echo EmptyValue(strval($actions_add->idResponsible->ViewValue)) ? $Language->phrase("PleaseSelect") : $actions_add->idResponsible->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($actions_add->idResponsible->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($actions_add->idResponsible->ReadOnly || $actions_add->idResponsible->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_idResponsible[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $actions_add->idResponsible->Lookup->getParamTag($actions_add, "p_x_idResponsible") ?>
<input type="hidden" data-table="actions" data-field="x_idResponsible" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $actions_add->idResponsible->displayValueSeparatorAttribute() ?>" name="x_idResponsible[]" id="x_idResponsible[]" value="<?php echo $actions_add->idResponsible->CurrentValue ?>"<?php echo $actions_add->idResponsible->editAttributes() ?>>
</span>
<?php echo $actions_add->idResponsible->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->targetDate->Visible) { // targetDate ?>
	<div id="r_targetDate" class="form-group row">
		<label id="elh_actions_targetDate" for="x_targetDate" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->targetDate->caption() ?><?php echo $actions_add->targetDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->targetDate->cellAttributes() ?>>
<span id="el_actions_targetDate">
<input type="text" data-table="actions" data-field="x_targetDate" data-format="14" name="x_targetDate" id="x_targetDate" size="7" placeholder="<?php echo HtmlEncode($actions_add->targetDate->getPlaceHolder()) ?>" value="<?php echo $actions_add->targetDate->EditValue ?>"<?php echo $actions_add->targetDate->editAttributes() ?>>
<?php if (!$actions_add->targetDate->ReadOnly && !$actions_add->targetDate->Disabled && !isset($actions_add->targetDate->EditAttrs["readonly"]) && !isset($actions_add->targetDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["factionsadd", "datetimepicker"], function() {
	ew.createDateTimePicker("factionsadd", "x_targetDate", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<?php } ?>
</span>
<?php echo $actions_add->targetDate->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->revisedKc->Visible) { // revisedKc ?>
	<div id="r_revisedKc" class="form-group row">
		<label id="elh_actions_revisedKc" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->revisedKc->caption() ?><?php echo $actions_add->revisedKc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->revisedKc->cellAttributes() ?>>
<span id="el_actions_revisedKc">
<?php
$selwrk = ConvertToBool($actions_add->revisedKc->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="actions" data-field="x_revisedKc" name="x_revisedKc[]" id="x_revisedKc[]" value="1"<?php echo $selwrk ?><?php echo $actions_add->revisedKc->editAttributes() ?>>
	<label class="custom-control-label" for="x_revisedKc[]"></label>
</div>
</span>
<?php echo $actions_add->revisedKc->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->expectedSeverity->Visible) { // expectedSeverity ?>
	<div id="r_expectedSeverity" class="form-group row">
		<label id="elh_actions_expectedSeverity" for="x_expectedSeverity" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->expectedSeverity->caption() ?><?php echo $actions_add->expectedSeverity->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->expectedSeverity->cellAttributes() ?>>
<span id="el_actions_expectedSeverity">
<input type="text" data-table="actions" data-field="x_expectedSeverity" name="x_expectedSeverity" id="x_expectedSeverity" size="3" placeholder="<?php echo HtmlEncode($actions_add->expectedSeverity->getPlaceHolder()) ?>" value="<?php echo $actions_add->expectedSeverity->EditValue ?>"<?php echo $actions_add->expectedSeverity->editAttributes() ?>>
</span>
<?php echo $actions_add->expectedSeverity->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->expectedOccurrence->Visible) { // expectedOccurrence ?>
	<div id="r_expectedOccurrence" class="form-group row">
		<label id="elh_actions_expectedOccurrence" for="x_expectedOccurrence" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->expectedOccurrence->caption() ?><?php echo $actions_add->expectedOccurrence->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->expectedOccurrence->cellAttributes() ?>>
<span id="el_actions_expectedOccurrence">
<input type="text" data-table="actions" data-field="x_expectedOccurrence" name="x_expectedOccurrence" id="x_expectedOccurrence" size="3" placeholder="<?php echo HtmlEncode($actions_add->expectedOccurrence->getPlaceHolder()) ?>" value="<?php echo $actions_add->expectedOccurrence->EditValue ?>"<?php echo $actions_add->expectedOccurrence->editAttributes() ?>>
</span>
<?php echo $actions_add->expectedOccurrence->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->expectedDetection->Visible) { // expectedDetection ?>
	<div id="r_expectedDetection" class="form-group row">
		<label id="elh_actions_expectedDetection" for="x_expectedDetection" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->expectedDetection->caption() ?><?php echo $actions_add->expectedDetection->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->expectedDetection->cellAttributes() ?>>
<span id="el_actions_expectedDetection">
<input type="text" data-table="actions" data-field="x_expectedDetection" name="x_expectedDetection" id="x_expectedDetection" size="3" placeholder="<?php echo HtmlEncode($actions_add->expectedDetection->getPlaceHolder()) ?>" value="<?php echo $actions_add->expectedDetection->EditValue ?>"<?php echo $actions_add->expectedDetection->editAttributes() ?>>
</span>
<?php echo $actions_add->expectedDetection->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->expectedClosureDate->Visible) { // expectedClosureDate ?>
	<div id="r_expectedClosureDate" class="form-group row">
		<label id="elh_actions_expectedClosureDate" for="x_expectedClosureDate" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->expectedClosureDate->caption() ?><?php echo $actions_add->expectedClosureDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->expectedClosureDate->cellAttributes() ?>>
<span id="el_actions_expectedClosureDate">
<input type="text" data-table="actions" data-field="x_expectedClosureDate" data-format="12" name="x_expectedClosureDate" id="x_expectedClosureDate" size="7" placeholder="<?php echo HtmlEncode($actions_add->expectedClosureDate->getPlaceHolder()) ?>" value="<?php echo $actions_add->expectedClosureDate->EditValue ?>"<?php echo $actions_add->expectedClosureDate->editAttributes() ?>>
<?php if (!$actions_add->expectedClosureDate->ReadOnly && !$actions_add->expectedClosureDate->Disabled && !isset($actions_add->expectedClosureDate->EditAttrs["readonly"]) && !isset($actions_add->expectedClosureDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["factionsadd", "datetimepicker"], function() {
	ew.createDateTimePicker("factionsadd", "x_expectedClosureDate", {"ignoreReadonly":true,"useCurrent":false,"format":12});
});
</script>
<?php } ?>
</span>
<?php echo $actions_add->expectedClosureDate->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->recomendedActiondet->Visible) { // recomendedActiondet ?>
	<div id="r_recomendedActiondet" class="form-group row">
		<label id="elh_actions_recomendedActiondet" for="x_recomendedActiondet" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->recomendedActiondet->caption() ?><?php echo $actions_add->recomendedActiondet->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->recomendedActiondet->cellAttributes() ?>>
<span id="el_actions_recomendedActiondet">
<input type="text" data-table="actions" data-field="x_recomendedActiondet" name="x_recomendedActiondet" id="x_recomendedActiondet" size="10" placeholder="<?php echo HtmlEncode($actions_add->recomendedActiondet->getPlaceHolder()) ?>" value="<?php echo $actions_add->recomendedActiondet->EditValue ?>"<?php echo $actions_add->recomendedActiondet->editAttributes() ?>>
</span>
<?php echo $actions_add->recomendedActiondet->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->idResponsibleDet->Visible) { // idResponsibleDet ?>
	<div id="r_idResponsibleDet" class="form-group row">
		<label id="elh_actions_idResponsibleDet" for="x_idResponsibleDet" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->idResponsibleDet->caption() ?><?php echo $actions_add->idResponsibleDet->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->idResponsibleDet->cellAttributes() ?>>
<span id="el_actions_idResponsibleDet">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_idResponsibleDet"><?php echo EmptyValue(strval($actions_add->idResponsibleDet->ViewValue)) ? $Language->phrase("PleaseSelect") : $actions_add->idResponsibleDet->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($actions_add->idResponsibleDet->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($actions_add->idResponsibleDet->ReadOnly || $actions_add->idResponsibleDet->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_idResponsibleDet[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $actions_add->idResponsibleDet->Lookup->getParamTag($actions_add, "p_x_idResponsibleDet") ?>
<input type="hidden" data-table="actions" data-field="x_idResponsibleDet" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $actions_add->idResponsibleDet->displayValueSeparatorAttribute() ?>" name="x_idResponsibleDet[]" id="x_idResponsibleDet[]" value="<?php echo $actions_add->idResponsibleDet->CurrentValue ?>"<?php echo $actions_add->idResponsibleDet->editAttributes() ?>>
</span>
<?php echo $actions_add->idResponsibleDet->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->targetDatedet->Visible) { // targetDatedet ?>
	<div id="r_targetDatedet" class="form-group row">
		<label id="elh_actions_targetDatedet" for="x_targetDatedet" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->targetDatedet->caption() ?><?php echo $actions_add->targetDatedet->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->targetDatedet->cellAttributes() ?>>
<span id="el_actions_targetDatedet">
<input type="text" data-table="actions" data-field="x_targetDatedet" data-format="14" name="x_targetDatedet" id="x_targetDatedet" size="7" placeholder="<?php echo HtmlEncode($actions_add->targetDatedet->getPlaceHolder()) ?>" value="<?php echo $actions_add->targetDatedet->EditValue ?>"<?php echo $actions_add->targetDatedet->editAttributes() ?>>
<?php if (!$actions_add->targetDatedet->ReadOnly && !$actions_add->targetDatedet->Disabled && !isset($actions_add->targetDatedet->EditAttrs["readonly"]) && !isset($actions_add->targetDatedet->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["factionsadd", "datetimepicker"], function() {
	ew.createDateTimePicker("factionsadd", "x_targetDatedet", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<?php } ?>
</span>
<?php echo $actions_add->targetDatedet->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->kcdet->Visible) { // kcdet ?>
	<div id="r_kcdet" class="form-group row">
		<label id="elh_actions_kcdet" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->kcdet->caption() ?><?php echo $actions_add->kcdet->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->kcdet->cellAttributes() ?>>
<span id="el_actions_kcdet">
<?php
$selwrk = ConvertToBool($actions_add->kcdet->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="actions" data-field="x_kcdet" name="x_kcdet[]" id="x_kcdet[]" value="1"<?php echo $selwrk ?><?php echo $actions_add->kcdet->editAttributes() ?>>
	<label class="custom-control-label" for="x_kcdet[]"></label>
</div>
</span>
<?php echo $actions_add->kcdet->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->expectedSeveritydet->Visible) { // expectedSeveritydet ?>
	<div id="r_expectedSeveritydet" class="form-group row">
		<label id="elh_actions_expectedSeveritydet" for="x_expectedSeveritydet" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->expectedSeveritydet->caption() ?><?php echo $actions_add->expectedSeveritydet->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->expectedSeveritydet->cellAttributes() ?>>
<span id="el_actions_expectedSeveritydet">
<input type="text" data-table="actions" data-field="x_expectedSeveritydet" name="x_expectedSeveritydet" id="x_expectedSeveritydet" size="3" placeholder="<?php echo HtmlEncode($actions_add->expectedSeveritydet->getPlaceHolder()) ?>" value="<?php echo $actions_add->expectedSeveritydet->EditValue ?>"<?php echo $actions_add->expectedSeveritydet->editAttributes() ?>>
</span>
<?php echo $actions_add->expectedSeveritydet->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->expectedOccurrencedet->Visible) { // expectedOccurrencedet ?>
	<div id="r_expectedOccurrencedet" class="form-group row">
		<label id="elh_actions_expectedOccurrencedet" for="x_expectedOccurrencedet" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->expectedOccurrencedet->caption() ?><?php echo $actions_add->expectedOccurrencedet->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->expectedOccurrencedet->cellAttributes() ?>>
<span id="el_actions_expectedOccurrencedet">
<input type="text" data-table="actions" data-field="x_expectedOccurrencedet" name="x_expectedOccurrencedet" id="x_expectedOccurrencedet" size="3" placeholder="<?php echo HtmlEncode($actions_add->expectedOccurrencedet->getPlaceHolder()) ?>" value="<?php echo $actions_add->expectedOccurrencedet->EditValue ?>"<?php echo $actions_add->expectedOccurrencedet->editAttributes() ?>>
</span>
<?php echo $actions_add->expectedOccurrencedet->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->expectedDetectiondet->Visible) { // expectedDetectiondet ?>
	<div id="r_expectedDetectiondet" class="form-group row">
		<label id="elh_actions_expectedDetectiondet" for="x_expectedDetectiondet" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->expectedDetectiondet->caption() ?><?php echo $actions_add->expectedDetectiondet->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->expectedDetectiondet->cellAttributes() ?>>
<span id="el_actions_expectedDetectiondet">
<input type="text" data-table="actions" data-field="x_expectedDetectiondet" name="x_expectedDetectiondet" id="x_expectedDetectiondet" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($actions_add->expectedDetectiondet->getPlaceHolder()) ?>" value="<?php echo $actions_add->expectedDetectiondet->EditValue ?>"<?php echo $actions_add->expectedDetectiondet->editAttributes() ?>>
</span>
<?php echo $actions_add->expectedDetectiondet->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->revisedClosureDatedet->Visible) { // revisedClosureDatedet ?>
	<div id="r_revisedClosureDatedet" class="form-group row">
		<label id="elh_actions_revisedClosureDatedet" for="x_revisedClosureDatedet" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->revisedClosureDatedet->caption() ?><?php echo $actions_add->revisedClosureDatedet->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->revisedClosureDatedet->cellAttributes() ?>>
<span id="el_actions_revisedClosureDatedet">
<input type="text" data-table="actions" data-field="x_revisedClosureDatedet" data-format="14" name="x_revisedClosureDatedet" id="x_revisedClosureDatedet" size="7" placeholder="<?php echo HtmlEncode($actions_add->revisedClosureDatedet->getPlaceHolder()) ?>" value="<?php echo $actions_add->revisedClosureDatedet->EditValue ?>"<?php echo $actions_add->revisedClosureDatedet->editAttributes() ?>>
<?php if (!$actions_add->revisedClosureDatedet->ReadOnly && !$actions_add->revisedClosureDatedet->Disabled && !isset($actions_add->revisedClosureDatedet->EditAttrs["readonly"]) && !isset($actions_add->revisedClosureDatedet->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["factionsadd", "datetimepicker"], function() {
	ew.createDateTimePicker("factionsadd", "x_revisedClosureDatedet", {"ignoreReadonly":true,"useCurrent":false,"format":14});
});
</script>
<?php } ?>
</span>
<?php echo $actions_add->revisedClosureDatedet->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->revisedSeverity->Visible) { // revisedSeverity ?>
	<div id="r_revisedSeverity" class="form-group row">
		<label id="elh_actions_revisedSeverity" for="x_revisedSeverity" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->revisedSeverity->caption() ?><?php echo $actions_add->revisedSeverity->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->revisedSeverity->cellAttributes() ?>>
<span id="el_actions_revisedSeverity">
<input type="text" data-table="actions" data-field="x_revisedSeverity" name="x_revisedSeverity" id="x_revisedSeverity" size="3" placeholder="<?php echo HtmlEncode($actions_add->revisedSeverity->getPlaceHolder()) ?>" value="<?php echo $actions_add->revisedSeverity->EditValue ?>"<?php echo $actions_add->revisedSeverity->editAttributes() ?>>
</span>
<?php echo $actions_add->revisedSeverity->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->revisedOccurrence->Visible) { // revisedOccurrence ?>
	<div id="r_revisedOccurrence" class="form-group row">
		<label id="elh_actions_revisedOccurrence" for="x_revisedOccurrence" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->revisedOccurrence->caption() ?><?php echo $actions_add->revisedOccurrence->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->revisedOccurrence->cellAttributes() ?>>
<span id="el_actions_revisedOccurrence">
<input type="text" data-table="actions" data-field="x_revisedOccurrence" name="x_revisedOccurrence" id="x_revisedOccurrence" size="3" placeholder="<?php echo HtmlEncode($actions_add->revisedOccurrence->getPlaceHolder()) ?>" value="<?php echo $actions_add->revisedOccurrence->EditValue ?>"<?php echo $actions_add->revisedOccurrence->editAttributes() ?>>
</span>
<?php echo $actions_add->revisedOccurrence->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->revisedDetection->Visible) { // revisedDetection ?>
	<div id="r_revisedDetection" class="form-group row">
		<label id="elh_actions_revisedDetection" for="x_revisedDetection" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->revisedDetection->caption() ?><?php echo $actions_add->revisedDetection->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->revisedDetection->cellAttributes() ?>>
<span id="el_actions_revisedDetection">
<input type="text" data-table="actions" data-field="x_revisedDetection" name="x_revisedDetection" id="x_revisedDetection" size="3" placeholder="<?php echo HtmlEncode($actions_add->revisedDetection->getPlaceHolder()) ?>" value="<?php echo $actions_add->revisedDetection->EditValue ?>"<?php echo $actions_add->revisedDetection->editAttributes() ?>>
</span>
<?php echo $actions_add->revisedDetection->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($actions_add->revisedRpn->Visible) { // revisedRpn ?>
	<div id="r_revisedRpn" class="form-group row">
		<label id="elh_actions_revisedRpn" for="x_revisedRpn" class="<?php echo $actions_add->LeftColumnClass ?>"><?php echo $actions_add->revisedRpn->caption() ?><?php echo $actions_add->revisedRpn->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $actions_add->RightColumnClass ?>"><div <?php echo $actions_add->revisedRpn->cellAttributes() ?>>
<span id="el_actions_revisedRpn">
<input type="text" data-table="actions" data-field="x_revisedRpn" name="x_revisedRpn" id="x_revisedRpn" size="3" placeholder="<?php echo HtmlEncode($actions_add->revisedRpn->getPlaceHolder()) ?>" value="<?php echo $actions_add->revisedRpn->EditValue ?>"<?php echo $actions_add->revisedRpn->editAttributes() ?>>
</span>
<?php echo $actions_add->revisedRpn->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
	<?php if (strval($actions_add->idProcess->getSessionValue()) != "") { ?>
	<input type="hidden" name="x_idProcess" id="x_idProcess" value="<?php echo HtmlEncode(strval($actions_add->idProcess->getSessionValue())) ?>">
	<?php } ?>
<?php if (!$actions_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $actions_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $actions_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$actions_add->showPageFooter();
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
$actions_add->terminate();
?>