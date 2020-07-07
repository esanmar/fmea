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
$workcenters_add = new workcenters_add();

// Run the page
$workcenters_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$workcenters_add->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fworkcentersadd, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "add";
	fworkcentersadd = currentForm = new ew.Form("fworkcentersadd", "add");

	// Validate form
	fworkcentersadd.validate = function() {
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
			<?php if ($workcenters_add->workcenter->Required) { ?>
				elm = this.getElements("x" + infix + "_workcenter");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $workcenters_add->workcenter->caption(), $workcenters_add->workcenter->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($workcenters_add->description->Required) { ?>
				elm = this.getElements("x" + infix + "_description");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $workcenters_add->description->caption(), $workcenters_add->description->RequiredErrorMessage)) ?>");
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
	fworkcentersadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fworkcentersadd.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fworkcentersadd");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $workcenters_add->showPageHeader(); ?>
<?php
$workcenters_add->showMessage();
?>
<form name="fworkcentersadd" id="fworkcentersadd" class="<?php echo $workcenters_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="workcenters">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$workcenters_add->IsModal ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($workcenters_add->workcenter->Visible) { // workcenter ?>
	<div id="r_workcenter" class="form-group row">
		<label id="elh_workcenters_workcenter" for="x_workcenter" class="<?php echo $workcenters_add->LeftColumnClass ?>"><?php echo $workcenters_add->workcenter->caption() ?><?php echo $workcenters_add->workcenter->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $workcenters_add->RightColumnClass ?>"><div <?php echo $workcenters_add->workcenter->cellAttributes() ?>>
<span id="el_workcenters_workcenter">
<input type="text" data-table="workcenters" data-field="x_workcenter" name="x_workcenter" id="x_workcenter" size="30" maxlength="6" placeholder="<?php echo HtmlEncode($workcenters_add->workcenter->getPlaceHolder()) ?>" value="<?php echo $workcenters_add->workcenter->EditValue ?>"<?php echo $workcenters_add->workcenter->editAttributes() ?>>
</span>
<?php echo $workcenters_add->workcenter->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($workcenters_add->description->Visible) { // description ?>
	<div id="r_description" class="form-group row">
		<label id="elh_workcenters_description" for="x_description" class="<?php echo $workcenters_add->LeftColumnClass ?>"><?php echo $workcenters_add->description->caption() ?><?php echo $workcenters_add->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $workcenters_add->RightColumnClass ?>"><div <?php echo $workcenters_add->description->cellAttributes() ?>>
<span id="el_workcenters_description">
<input type="text" data-table="workcenters" data-field="x_description" name="x_description" id="x_description" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($workcenters_add->description->getPlaceHolder()) ?>" value="<?php echo $workcenters_add->description->EditValue ?>"<?php echo $workcenters_add->description->editAttributes() ?>>
</span>
<?php echo $workcenters_add->description->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$workcenters_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $workcenters_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $workcenters_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$workcenters_add->showPageFooter();
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
$workcenters_add->terminate();
?>