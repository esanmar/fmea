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
$workcenters_edit = new workcenters_edit();

// Run the page
$workcenters_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$workcenters_edit->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fworkcentersedit, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "edit";
	fworkcentersedit = currentForm = new ew.Form("fworkcentersedit", "edit");

	// Validate form
	fworkcentersedit.validate = function() {
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
			<?php if ($workcenters_edit->workcenter->Required) { ?>
				elm = this.getElements("x" + infix + "_workcenter");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $workcenters_edit->workcenter->caption(), $workcenters_edit->workcenter->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($workcenters_edit->description->Required) { ?>
				elm = this.getElements("x" + infix + "_description");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $workcenters_edit->description->caption(), $workcenters_edit->description->RequiredErrorMessage)) ?>");
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
	fworkcentersedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fworkcentersedit.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fworkcentersedit");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $workcenters_edit->showPageHeader(); ?>
<?php
$workcenters_edit->showMessage();
?>
<?php if (!$workcenters_edit->IsModal) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $workcenters_edit->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fworkcentersedit" id="fworkcentersedit" class="<?php echo $workcenters_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="workcenters">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$workcenters_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($workcenters_edit->workcenter->Visible) { // workcenter ?>
	<div id="r_workcenter" class="form-group row">
		<label id="elh_workcenters_workcenter" for="x_workcenter" class="<?php echo $workcenters_edit->LeftColumnClass ?>"><?php echo $workcenters_edit->workcenter->caption() ?><?php echo $workcenters_edit->workcenter->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $workcenters_edit->RightColumnClass ?>"><div <?php echo $workcenters_edit->workcenter->cellAttributes() ?>>
<input type="text" data-table="workcenters" data-field="x_workcenter" name="x_workcenter" id="x_workcenter" size="30" maxlength="6" placeholder="<?php echo HtmlEncode($workcenters_edit->workcenter->getPlaceHolder()) ?>" value="<?php echo $workcenters_edit->workcenter->EditValue ?>"<?php echo $workcenters_edit->workcenter->editAttributes() ?>>
<input type="hidden" data-table="workcenters" data-field="x_workcenter" name="o_workcenter" id="o_workcenter" value="<?php echo HtmlEncode($workcenters_edit->workcenter->OldValue != null ? $workcenters_edit->workcenter->OldValue : $workcenters_edit->workcenter->CurrentValue) ?>">
<?php echo $workcenters_edit->workcenter->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($workcenters_edit->description->Visible) { // description ?>
	<div id="r_description" class="form-group row">
		<label id="elh_workcenters_description" for="x_description" class="<?php echo $workcenters_edit->LeftColumnClass ?>"><?php echo $workcenters_edit->description->caption() ?><?php echo $workcenters_edit->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $workcenters_edit->RightColumnClass ?>"><div <?php echo $workcenters_edit->description->cellAttributes() ?>>
<span id="el_workcenters_description">
<input type="text" data-table="workcenters" data-field="x_description" name="x_description" id="x_description" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($workcenters_edit->description->getPlaceHolder()) ?>" value="<?php echo $workcenters_edit->description->EditValue ?>"<?php echo $workcenters_edit->description->editAttributes() ?>>
</span>
<?php echo $workcenters_edit->description->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$workcenters_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $workcenters_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $workcenters_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$workcenters_edit->IsModal) { ?>
<?php echo $workcenters_edit->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<?php
$workcenters_edit->showPageFooter();
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
$workcenters_edit->terminate();
?>