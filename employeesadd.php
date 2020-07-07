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
$employees_add = new employees_add();

// Run the page
$employees_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$employees_add->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var femployeesadd, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "add";
	femployeesadd = currentForm = new ew.Form("femployeesadd", "add");

	// Validate form
	femployeesadd.validate = function() {
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
			<?php if ($employees_add->idEmployee->Required) { ?>
				elm = this.getElements("x" + infix + "_idEmployee");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $employees_add->idEmployee->caption(), $employees_add->idEmployee->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($employees_add->name->Required) { ?>
				elm = this.getElements("x" + infix + "_name");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $employees_add->name->caption(), $employees_add->name->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($employees_add->surname->Required) { ?>
				elm = this.getElements("x" + infix + "_surname");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $employees_add->surname->caption(), $employees_add->surname->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($employees_add->idFactory->Required) { ?>
				elm = this.getElements("x" + infix + "_idFactory");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $employees_add->idFactory->caption(), $employees_add->idFactory->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($employees_add->userlevel->Required) { ?>
				elm = this.getElements("x" + infix + "_userlevel");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $employees_add->userlevel->caption(), $employees_add->userlevel->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($employees_add->password->Required) { ?>
				elm = this.getElements("x" + infix + "_password");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $employees_add->password->caption(), $employees_add->password->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($employees_add->workcenter->Required) { ?>
				elm = this.getElements("x" + infix + "_workcenter");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $employees_add->workcenter->caption(), $employees_add->workcenter->RequiredErrorMessage)) ?>");
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
	femployeesadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	femployeesadd.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	femployeesadd.lists["x_idFactory"] = <?php echo $employees_add->idFactory->Lookup->toClientList($employees_add) ?>;
	femployeesadd.lists["x_idFactory"].options = <?php echo JsonEncode($employees_add->idFactory->lookupOptions()) ?>;
	femployeesadd.autoSuggests["x_idFactory"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
	femployeesadd.lists["x_userlevel"] = <?php echo $employees_add->userlevel->Lookup->toClientList($employees_add) ?>;
	femployeesadd.lists["x_userlevel"].options = <?php echo JsonEncode($employees_add->userlevel->options(FALSE, TRUE)) ?>;
	femployeesadd.lists["x_workcenter"] = <?php echo $employees_add->workcenter->Lookup->toClientList($employees_add) ?>;
	femployeesadd.lists["x_workcenter"].options = <?php echo JsonEncode($employees_add->workcenter->lookupOptions()) ?>;
	femployeesadd.autoSuggests["x_workcenter"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
	loadjs.done("femployeesadd");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $employees_add->showPageHeader(); ?>
<?php
$employees_add->showMessage();
?>
<form name="femployeesadd" id="femployeesadd" class="<?php echo $employees_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="employees">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$employees_add->IsModal ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($employees_add->idEmployee->Visible) { // idEmployee ?>
	<div id="r_idEmployee" class="form-group row">
		<label id="elh_employees_idEmployee" for="x_idEmployee" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees_add->idEmployee->caption() ?><?php echo $employees_add->idEmployee->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div <?php echo $employees_add->idEmployee->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_employees_idEmployee">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="employees" data-field="x_idEmployee" data-value-separator="<?php echo $employees_add->idEmployee->displayValueSeparatorAttribute() ?>" id="x_idEmployee" name="x_idEmployee"<?php echo $employees_add->idEmployee->editAttributes() ?>>
			<?php echo $employees_add->idEmployee->selectOptionListHtml("x_idEmployee") ?>
		</select>
</div>
</span>
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$employees->userIDAllow("add")) { // Non system admin ?>
<span id="el_employees_idEmployee">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="employees" data-field="x_idEmployee" data-value-separator="<?php echo $employees_add->idEmployee->displayValueSeparatorAttribute() ?>" id="x_idEmployee" name="x_idEmployee"<?php echo $employees_add->idEmployee->editAttributes() ?>>
			<?php echo $employees_add->idEmployee->selectOptionListHtml("x_idEmployee") ?>
		</select>
</div>
</span>
<?php } else { ?>
<span id="el_employees_idEmployee">
<input type="text" data-table="employees" data-field="x_idEmployee" name="x_idEmployee" id="x_idEmployee" size="30" maxlength="30" placeholder="<?php echo HtmlEncode($employees_add->idEmployee->getPlaceHolder()) ?>" value="<?php echo $employees_add->idEmployee->EditValue ?>"<?php echo $employees_add->idEmployee->editAttributes() ?>>
</span>
<?php } ?>
<?php echo $employees_add->idEmployee->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees_add->name->Visible) { // name ?>
	<div id="r_name" class="form-group row">
		<label id="elh_employees_name" for="x_name" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees_add->name->caption() ?><?php echo $employees_add->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div <?php echo $employees_add->name->cellAttributes() ?>>
<span id="el_employees_name">
<input type="text" data-table="employees" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($employees_add->name->getPlaceHolder()) ?>" value="<?php echo $employees_add->name->EditValue ?>"<?php echo $employees_add->name->editAttributes() ?>>
</span>
<?php echo $employees_add->name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees_add->surname->Visible) { // surname ?>
	<div id="r_surname" class="form-group row">
		<label id="elh_employees_surname" for="x_surname" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees_add->surname->caption() ?><?php echo $employees_add->surname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div <?php echo $employees_add->surname->cellAttributes() ?>>
<span id="el_employees_surname">
<input type="text" data-table="employees" data-field="x_surname" name="x_surname" id="x_surname" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($employees_add->surname->getPlaceHolder()) ?>" value="<?php echo $employees_add->surname->EditValue ?>"<?php echo $employees_add->surname->editAttributes() ?>>
</span>
<?php echo $employees_add->surname->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees_add->idFactory->Visible) { // idFactory ?>
	<div id="r_idFactory" class="form-group row">
		<label id="elh_employees_idFactory" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees_add->idFactory->caption() ?><?php echo $employees_add->idFactory->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div <?php echo $employees_add->idFactory->cellAttributes() ?>>
<span id="el_employees_idFactory">
<?php
$onchange = $employees_add->idFactory->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$employees_add->idFactory->EditAttrs["onchange"] = "";
?>
<span id="as_x_idFactory">
	<input type="text" class="form-control" name="sv_x_idFactory" id="sv_x_idFactory" value="<?php echo RemoveHtml($employees_add->idFactory->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($employees_add->idFactory->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($employees_add->idFactory->getPlaceHolder()) ?>"<?php echo $employees_add->idFactory->editAttributes() ?>>
</span>
<input type="hidden" data-table="employees" data-field="x_idFactory" data-value-separator="<?php echo $employees_add->idFactory->displayValueSeparatorAttribute() ?>" name="x_idFactory" id="x_idFactory" value="<?php echo HtmlEncode($employees_add->idFactory->CurrentValue) ?>"<?php echo $onchange ?>>
<script>
loadjs.ready(["femployeesadd"], function() {
	femployeesadd.createAutoSuggest({"id":"x_idFactory","forceSelect":false});
});
</script>
<?php echo $employees_add->idFactory->Lookup->getParamTag($employees_add, "p_x_idFactory") ?>
</span>
<?php echo $employees_add->idFactory->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees_add->userlevel->Visible) { // userlevel ?>
	<div id="r_userlevel" class="form-group row">
		<label id="elh_employees_userlevel" for="x_userlevel" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees_add->userlevel->caption() ?><?php echo $employees_add->userlevel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div <?php echo $employees_add->userlevel->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_employees_userlevel">
<input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($employees_add->userlevel->EditValue)) ?>">
</span>
<?php } else { ?>
<span id="el_employees_userlevel">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="employees" data-field="x_userlevel" data-value-separator="<?php echo $employees_add->userlevel->displayValueSeparatorAttribute() ?>" id="x_userlevel" name="x_userlevel"<?php echo $employees_add->userlevel->editAttributes() ?>>
			<?php echo $employees_add->userlevel->selectOptionListHtml("x_userlevel") ?>
		</select>
</div>
</span>
<?php } ?>
<?php echo $employees_add->userlevel->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees_add->password->Visible) { // password ?>
	<div id="r_password" class="form-group row">
		<label id="elh_employees_password" for="x_password" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees_add->password->caption() ?><?php echo $employees_add->password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div <?php echo $employees_add->password->cellAttributes() ?>>
<span id="el_employees_password">
<input type="text" data-table="employees" data-field="x_password" name="x_password" id="x_password" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($employees_add->password->getPlaceHolder()) ?>" value="<?php echo $employees_add->password->EditValue ?>"<?php echo $employees_add->password->editAttributes() ?>>
</span>
<?php echo $employees_add->password->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees_add->workcenter->Visible) { // workcenter ?>
	<div id="r_workcenter" class="form-group row">
		<label id="elh_employees_workcenter" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees_add->workcenter->caption() ?><?php echo $employees_add->workcenter->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div <?php echo $employees_add->workcenter->cellAttributes() ?>>
<span id="el_employees_workcenter">
<?php
$onchange = $employees_add->workcenter->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$employees_add->workcenter->EditAttrs["onchange"] = "";
?>
<span id="as_x_workcenter">
	<input type="text" class="form-control" name="sv_x_workcenter" id="sv_x_workcenter" value="<?php echo RemoveHtml($employees_add->workcenter->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($employees_add->workcenter->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($employees_add->workcenter->getPlaceHolder()) ?>"<?php echo $employees_add->workcenter->editAttributes() ?>>
</span>
<input type="hidden" data-table="employees" data-field="x_workcenter" data-value-separator="<?php echo $employees_add->workcenter->displayValueSeparatorAttribute() ?>" name="x_workcenter" id="x_workcenter" value="<?php echo HtmlEncode($employees_add->workcenter->CurrentValue) ?>"<?php echo $onchange ?>>
<script>
loadjs.ready(["femployeesadd"], function() {
	femployeesadd.createAutoSuggest({"id":"x_workcenter","forceSelect":false});
});
</script>
<?php echo $employees_add->workcenter->Lookup->getParamTag($employees_add, "p_x_workcenter") ?>
</span>
<?php echo $employees_add->workcenter->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$employees_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $employees_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $employees_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$employees_add->showPageFooter();
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
$employees_add->terminate();
?>