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
$employees_edit = new employees_edit();

// Run the page
$employees_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$employees_edit->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var femployeesedit, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "edit";
	femployeesedit = currentForm = new ew.Form("femployeesedit", "edit");

	// Validate form
	femployeesedit.validate = function() {
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
			<?php if ($employees_edit->idEmployee->Required) { ?>
				elm = this.getElements("x" + infix + "_idEmployee");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $employees_edit->idEmployee->caption(), $employees_edit->idEmployee->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($employees_edit->name->Required) { ?>
				elm = this.getElements("x" + infix + "_name");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $employees_edit->name->caption(), $employees_edit->name->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($employees_edit->surname->Required) { ?>
				elm = this.getElements("x" + infix + "_surname");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $employees_edit->surname->caption(), $employees_edit->surname->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($employees_edit->idFactory->Required) { ?>
				elm = this.getElements("x" + infix + "_idFactory");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $employees_edit->idFactory->caption(), $employees_edit->idFactory->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($employees_edit->userlevel->Required) { ?>
				elm = this.getElements("x" + infix + "_userlevel");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $employees_edit->userlevel->caption(), $employees_edit->userlevel->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($employees_edit->password->Required) { ?>
				elm = this.getElements("x" + infix + "_password");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $employees_edit->password->caption(), $employees_edit->password->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($employees_edit->workcenter->Required) { ?>
				elm = this.getElements("x" + infix + "_workcenter");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $employees_edit->workcenter->caption(), $employees_edit->workcenter->RequiredErrorMessage)) ?>");
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
	femployeesedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	femployeesedit.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	femployeesedit.lists["x_idFactory"] = <?php echo $employees_edit->idFactory->Lookup->toClientList($employees_edit) ?>;
	femployeesedit.lists["x_idFactory"].options = <?php echo JsonEncode($employees_edit->idFactory->lookupOptions()) ?>;
	femployeesedit.autoSuggests["x_idFactory"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
	femployeesedit.lists["x_userlevel"] = <?php echo $employees_edit->userlevel->Lookup->toClientList($employees_edit) ?>;
	femployeesedit.lists["x_userlevel"].options = <?php echo JsonEncode($employees_edit->userlevel->options(FALSE, TRUE)) ?>;
	femployeesedit.lists["x_workcenter"] = <?php echo $employees_edit->workcenter->Lookup->toClientList($employees_edit) ?>;
	femployeesedit.lists["x_workcenter"].options = <?php echo JsonEncode($employees_edit->workcenter->lookupOptions()) ?>;
	femployeesedit.autoSuggests["x_workcenter"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
	loadjs.done("femployeesedit");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $employees_edit->showPageHeader(); ?>
<?php
$employees_edit->showMessage();
?>
<?php if (!$employees_edit->IsModal) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $employees_edit->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="femployeesedit" id="femployeesedit" class="<?php echo $employees_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="employees">
<input type="hidden" name="k_hash" id="k_hash" value="<?php echo $employees_edit->HashValue ?>">
<?php if ($employees->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="conflict" id="conflict" value="1">
<?php } ?>
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$employees_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($employees_edit->idEmployee->Visible) { // idEmployee ?>
	<div id="r_idEmployee" class="form-group row">
		<label id="elh_employees_idEmployee" for="x_idEmployee" class="<?php echo $employees_edit->LeftColumnClass ?>"><?php echo $employees_edit->idEmployee->caption() ?><?php echo $employees_edit->idEmployee->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $employees_edit->RightColumnClass ?>"><div <?php echo $employees_edit->idEmployee->cellAttributes() ?>>
<input type="text" data-table="employees" data-field="x_idEmployee" name="x_idEmployee" id="x_idEmployee" size="30" maxlength="30" placeholder="<?php echo HtmlEncode($employees_edit->idEmployee->getPlaceHolder()) ?>" value="<?php echo $employees_edit->idEmployee->EditValue ?>"<?php echo $employees_edit->idEmployee->editAttributes() ?>>
<input type="hidden" data-table="employees" data-field="x_idEmployee" name="o_idEmployee" id="o_idEmployee" value="<?php echo HtmlEncode($employees_edit->idEmployee->OldValue != null ? $employees_edit->idEmployee->OldValue : $employees_edit->idEmployee->CurrentValue) ?>">
<?php echo $employees_edit->idEmployee->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees_edit->name->Visible) { // name ?>
	<div id="r_name" class="form-group row">
		<label id="elh_employees_name" for="x_name" class="<?php echo $employees_edit->LeftColumnClass ?>"><?php echo $employees_edit->name->caption() ?><?php echo $employees_edit->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $employees_edit->RightColumnClass ?>"><div <?php echo $employees_edit->name->cellAttributes() ?>>
<span id="el_employees_name">
<input type="text" data-table="employees" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($employees_edit->name->getPlaceHolder()) ?>" value="<?php echo $employees_edit->name->EditValue ?>"<?php echo $employees_edit->name->editAttributes() ?>>
</span>
<?php echo $employees_edit->name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees_edit->surname->Visible) { // surname ?>
	<div id="r_surname" class="form-group row">
		<label id="elh_employees_surname" for="x_surname" class="<?php echo $employees_edit->LeftColumnClass ?>"><?php echo $employees_edit->surname->caption() ?><?php echo $employees_edit->surname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $employees_edit->RightColumnClass ?>"><div <?php echo $employees_edit->surname->cellAttributes() ?>>
<span id="el_employees_surname">
<input type="text" data-table="employees" data-field="x_surname" name="x_surname" id="x_surname" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($employees_edit->surname->getPlaceHolder()) ?>" value="<?php echo $employees_edit->surname->EditValue ?>"<?php echo $employees_edit->surname->editAttributes() ?>>
</span>
<?php echo $employees_edit->surname->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees_edit->idFactory->Visible) { // idFactory ?>
	<div id="r_idFactory" class="form-group row">
		<label id="elh_employees_idFactory" class="<?php echo $employees_edit->LeftColumnClass ?>"><?php echo $employees_edit->idFactory->caption() ?><?php echo $employees_edit->idFactory->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $employees_edit->RightColumnClass ?>"><div <?php echo $employees_edit->idFactory->cellAttributes() ?>>
<span id="el_employees_idFactory">
<?php
$onchange = $employees_edit->idFactory->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$employees_edit->idFactory->EditAttrs["onchange"] = "";
?>
<span id="as_x_idFactory">
	<input type="text" class="form-control" name="sv_x_idFactory" id="sv_x_idFactory" value="<?php echo RemoveHtml($employees_edit->idFactory->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($employees_edit->idFactory->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($employees_edit->idFactory->getPlaceHolder()) ?>"<?php echo $employees_edit->idFactory->editAttributes() ?>>
</span>
<input type="hidden" data-table="employees" data-field="x_idFactory" data-value-separator="<?php echo $employees_edit->idFactory->displayValueSeparatorAttribute() ?>" name="x_idFactory" id="x_idFactory" value="<?php echo HtmlEncode($employees_edit->idFactory->CurrentValue) ?>"<?php echo $onchange ?>>
<script>
loadjs.ready(["femployeesedit"], function() {
	femployeesedit.createAutoSuggest({"id":"x_idFactory","forceSelect":false});
});
</script>
<?php echo $employees_edit->idFactory->Lookup->getParamTag($employees_edit, "p_x_idFactory") ?>
</span>
<?php echo $employees_edit->idFactory->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees_edit->userlevel->Visible) { // userlevel ?>
	<div id="r_userlevel" class="form-group row">
		<label id="elh_employees_userlevel" for="x_userlevel" class="<?php echo $employees_edit->LeftColumnClass ?>"><?php echo $employees_edit->userlevel->caption() ?><?php echo $employees_edit->userlevel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $employees_edit->RightColumnClass ?>"><div <?php echo $employees_edit->userlevel->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_employees_userlevel">
<input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($employees_edit->userlevel->EditValue)) ?>">
</span>
<?php } else { ?>
<span id="el_employees_userlevel">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="employees" data-field="x_userlevel" data-value-separator="<?php echo $employees_edit->userlevel->displayValueSeparatorAttribute() ?>" id="x_userlevel" name="x_userlevel"<?php echo $employees_edit->userlevel->editAttributes() ?>>
			<?php echo $employees_edit->userlevel->selectOptionListHtml("x_userlevel") ?>
		</select>
</div>
</span>
<?php } ?>
<?php echo $employees_edit->userlevel->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees_edit->password->Visible) { // password ?>
	<div id="r_password" class="form-group row">
		<label id="elh_employees_password" for="x_password" class="<?php echo $employees_edit->LeftColumnClass ?>"><?php echo $employees_edit->password->caption() ?><?php echo $employees_edit->password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $employees_edit->RightColumnClass ?>"><div <?php echo $employees_edit->password->cellAttributes() ?>>
<span id="el_employees_password">
<input type="text" data-table="employees" data-field="x_password" name="x_password" id="x_password" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($employees_edit->password->getPlaceHolder()) ?>" value="<?php echo $employees_edit->password->EditValue ?>"<?php echo $employees_edit->password->editAttributes() ?>>
</span>
<?php echo $employees_edit->password->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees_edit->workcenter->Visible) { // workcenter ?>
	<div id="r_workcenter" class="form-group row">
		<label id="elh_employees_workcenter" class="<?php echo $employees_edit->LeftColumnClass ?>"><?php echo $employees_edit->workcenter->caption() ?><?php echo $employees_edit->workcenter->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $employees_edit->RightColumnClass ?>"><div <?php echo $employees_edit->workcenter->cellAttributes() ?>>
<span id="el_employees_workcenter">
<?php
$onchange = $employees_edit->workcenter->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$employees_edit->workcenter->EditAttrs["onchange"] = "";
?>
<span id="as_x_workcenter">
	<input type="text" class="form-control" name="sv_x_workcenter" id="sv_x_workcenter" value="<?php echo RemoveHtml($employees_edit->workcenter->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($employees_edit->workcenter->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($employees_edit->workcenter->getPlaceHolder()) ?>"<?php echo $employees_edit->workcenter->editAttributes() ?>>
</span>
<input type="hidden" data-table="employees" data-field="x_workcenter" data-value-separator="<?php echo $employees_edit->workcenter->displayValueSeparatorAttribute() ?>" name="x_workcenter" id="x_workcenter" value="<?php echo HtmlEncode($employees_edit->workcenter->CurrentValue) ?>"<?php echo $onchange ?>>
<script>
loadjs.ready(["femployeesedit"], function() {
	femployeesedit.createAutoSuggest({"id":"x_workcenter","forceSelect":false});
});
</script>
<?php echo $employees_edit->workcenter->Lookup->getParamTag($employees_edit, "p_x_workcenter") ?>
</span>
<?php echo $employees_edit->workcenter->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$employees_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $employees_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($employees->UpdateConflict == "U") { // Record already updated by other user ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" onclick="this.form.action.value='overwrite';"><?php echo $Language->phrase("OverwriteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-reload" id="btn-reload" type="submit" onclick="this.form.action.value='show';"><?php echo $Language->phrase("ReloadBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $employees_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
<?php } ?>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$employees_edit->IsModal) { ?>
<?php echo $employees_edit->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<?php
$employees_edit->showPageFooter();
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
$employees_edit->terminate();
?>