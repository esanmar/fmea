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
$occurrence_add = new occurrence_add();

// Run the page
$occurrence_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$occurrence_add->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var foccurrenceadd, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "add";
	foccurrenceadd = currentForm = new ew.Form("foccurrenceadd", "add");

	// Validate form
	foccurrenceadd.validate = function() {
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
			<?php if ($occurrence_add->probability->Required) { ?>
				elm = this.getElements("x" + infix + "_probability");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $occurrence_add->probability->caption(), $occurrence_add->probability->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($occurrence_add->description->Required) { ?>
				elm = this.getElements("x" + infix + "_description");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $occurrence_add->description->caption(), $occurrence_add->description->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($occurrence_add->likelihood->Required) { ?>
				elm = this.getElements("x" + infix + "_likelihood");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $occurrence_add->likelihood->caption(), $occurrence_add->likelihood->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($occurrence_add->timebased->Required) { ?>
				elm = this.getElements("x" + infix + "_timebased");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $occurrence_add->timebased->caption(), $occurrence_add->timebased->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($occurrence_add->color->Required) { ?>
				elm = this.getElements("x" + infix + "_color");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $occurrence_add->color->caption(), $occurrence_add->color->RequiredErrorMessage)) ?>");
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
	foccurrenceadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	foccurrenceadd.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("foccurrenceadd");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $occurrence_add->showPageHeader(); ?>
<?php
$occurrence_add->showMessage();
?>
<form name="foccurrenceadd" id="foccurrenceadd" class="<?php echo $occurrence_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="occurrence">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$occurrence_add->IsModal ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($occurrence_add->probability->Visible) { // probability ?>
	<div id="r_probability" class="form-group row">
		<label id="elh_occurrence_probability" for="x_probability" class="<?php echo $occurrence_add->LeftColumnClass ?>"><?php echo $occurrence_add->probability->caption() ?><?php echo $occurrence_add->probability->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $occurrence_add->RightColumnClass ?>"><div <?php echo $occurrence_add->probability->cellAttributes() ?>>
<span id="el_occurrence_probability">
<input type="text" data-table="occurrence" data-field="x_probability" name="x_probability" id="x_probability" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($occurrence_add->probability->getPlaceHolder()) ?>" value="<?php echo $occurrence_add->probability->EditValue ?>"<?php echo $occurrence_add->probability->editAttributes() ?>>
</span>
<?php echo $occurrence_add->probability->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($occurrence_add->description->Visible) { // description ?>
	<div id="r_description" class="form-group row">
		<label id="elh_occurrence_description" for="x_description" class="<?php echo $occurrence_add->LeftColumnClass ?>"><?php echo $occurrence_add->description->caption() ?><?php echo $occurrence_add->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $occurrence_add->RightColumnClass ?>"><div <?php echo $occurrence_add->description->cellAttributes() ?>>
<span id="el_occurrence_description">
<textarea data-table="occurrence" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?php echo HtmlEncode($occurrence_add->description->getPlaceHolder()) ?>"<?php echo $occurrence_add->description->editAttributes() ?>><?php echo $occurrence_add->description->EditValue ?></textarea>
</span>
<?php echo $occurrence_add->description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($occurrence_add->likelihood->Visible) { // likelihood ?>
	<div id="r_likelihood" class="form-group row">
		<label id="elh_occurrence_likelihood" for="x_likelihood" class="<?php echo $occurrence_add->LeftColumnClass ?>"><?php echo $occurrence_add->likelihood->caption() ?><?php echo $occurrence_add->likelihood->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $occurrence_add->RightColumnClass ?>"><div <?php echo $occurrence_add->likelihood->cellAttributes() ?>>
<span id="el_occurrence_likelihood">
<textarea data-table="occurrence" data-field="x_likelihood" name="x_likelihood" id="x_likelihood" cols="35" rows="4" placeholder="<?php echo HtmlEncode($occurrence_add->likelihood->getPlaceHolder()) ?>"<?php echo $occurrence_add->likelihood->editAttributes() ?>><?php echo $occurrence_add->likelihood->EditValue ?></textarea>
</span>
<?php echo $occurrence_add->likelihood->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($occurrence_add->timebased->Visible) { // timebased ?>
	<div id="r_timebased" class="form-group row">
		<label id="elh_occurrence_timebased" for="x_timebased" class="<?php echo $occurrence_add->LeftColumnClass ?>"><?php echo $occurrence_add->timebased->caption() ?><?php echo $occurrence_add->timebased->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $occurrence_add->RightColumnClass ?>"><div <?php echo $occurrence_add->timebased->cellAttributes() ?>>
<span id="el_occurrence_timebased">
<input type="text" data-table="occurrence" data-field="x_timebased" name="x_timebased" id="x_timebased" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($occurrence_add->timebased->getPlaceHolder()) ?>" value="<?php echo $occurrence_add->timebased->EditValue ?>"<?php echo $occurrence_add->timebased->editAttributes() ?>>
</span>
<?php echo $occurrence_add->timebased->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($occurrence_add->color->Visible) { // color ?>
	<div id="r_color" class="form-group row">
		<label id="elh_occurrence_color" for="x_color" class="<?php echo $occurrence_add->LeftColumnClass ?>"><?php echo $occurrence_add->color->caption() ?><?php echo $occurrence_add->color->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $occurrence_add->RightColumnClass ?>"><div <?php echo $occurrence_add->color->cellAttributes() ?>>
<span id="el_occurrence_color">
<input type="text" data-table="occurrence" data-field="x_color" name="x_color" id="x_color" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($occurrence_add->color->getPlaceHolder()) ?>" value="<?php echo $occurrence_add->color->EditValue ?>"<?php echo $occurrence_add->color->editAttributes() ?>>

<script>
loadjs.ready("head", function() {
	jQuery("[id='x_color']:not([id*='$rowindex$'])").colorpicker({ format: "hex" });
});
</script>

</span>
<?php echo $occurrence_add->color->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$occurrence_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $occurrence_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $occurrence_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$occurrence_add->showPageFooter();
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
$occurrence_add->terminate();
?>