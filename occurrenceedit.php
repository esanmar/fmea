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
$occurrence_edit = new occurrence_edit();

// Run the page
$occurrence_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$occurrence_edit->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var foccurrenceedit, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "edit";
	foccurrenceedit = currentForm = new ew.Form("foccurrenceedit", "edit");

	// Validate form
	foccurrenceedit.validate = function() {
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
			<?php if ($occurrence_edit->idOccurrence->Required) { ?>
				elm = this.getElements("x" + infix + "_idOccurrence");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $occurrence_edit->idOccurrence->caption(), $occurrence_edit->idOccurrence->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($occurrence_edit->probability->Required) { ?>
				elm = this.getElements("x" + infix + "_probability");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $occurrence_edit->probability->caption(), $occurrence_edit->probability->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($occurrence_edit->description->Required) { ?>
				elm = this.getElements("x" + infix + "_description");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $occurrence_edit->description->caption(), $occurrence_edit->description->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($occurrence_edit->likelihood->Required) { ?>
				elm = this.getElements("x" + infix + "_likelihood");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $occurrence_edit->likelihood->caption(), $occurrence_edit->likelihood->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($occurrence_edit->timebased->Required) { ?>
				elm = this.getElements("x" + infix + "_timebased");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $occurrence_edit->timebased->caption(), $occurrence_edit->timebased->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($occurrence_edit->color->Required) { ?>
				elm = this.getElements("x" + infix + "_color");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $occurrence_edit->color->caption(), $occurrence_edit->color->RequiredErrorMessage)) ?>");
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
	foccurrenceedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	foccurrenceedit.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("foccurrenceedit");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $occurrence_edit->showPageHeader(); ?>
<?php
$occurrence_edit->showMessage();
?>
<?php if (!$occurrence_edit->IsModal) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $occurrence_edit->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="foccurrenceedit" id="foccurrenceedit" class="<?php echo $occurrence_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="occurrence">
<input type="hidden" name="k_hash" id="k_hash" value="<?php echo $occurrence_edit->HashValue ?>">
<?php if ($occurrence->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="conflict" id="conflict" value="1">
<?php } ?>
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$occurrence_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($occurrence_edit->idOccurrence->Visible) { // idOccurrence ?>
	<div id="r_idOccurrence" class="form-group row">
		<label id="elh_occurrence_idOccurrence" class="<?php echo $occurrence_edit->LeftColumnClass ?>"><?php echo $occurrence_edit->idOccurrence->caption() ?><?php echo $occurrence_edit->idOccurrence->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $occurrence_edit->RightColumnClass ?>"><div <?php echo $occurrence_edit->idOccurrence->cellAttributes() ?>>
<span id="el_occurrence_idOccurrence">
<span<?php echo $occurrence_edit->idOccurrence->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($occurrence_edit->idOccurrence->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="occurrence" data-field="x_idOccurrence" name="x_idOccurrence" id="x_idOccurrence" value="<?php echo HtmlEncode($occurrence_edit->idOccurrence->CurrentValue) ?>">
<?php echo $occurrence_edit->idOccurrence->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($occurrence_edit->probability->Visible) { // probability ?>
	<div id="r_probability" class="form-group row">
		<label id="elh_occurrence_probability" for="x_probability" class="<?php echo $occurrence_edit->LeftColumnClass ?>"><?php echo $occurrence_edit->probability->caption() ?><?php echo $occurrence_edit->probability->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $occurrence_edit->RightColumnClass ?>"><div <?php echo $occurrence_edit->probability->cellAttributes() ?>>
<span id="el_occurrence_probability">
<input type="text" data-table="occurrence" data-field="x_probability" name="x_probability" id="x_probability" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($occurrence_edit->probability->getPlaceHolder()) ?>" value="<?php echo $occurrence_edit->probability->EditValue ?>"<?php echo $occurrence_edit->probability->editAttributes() ?>>
</span>
<?php echo $occurrence_edit->probability->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($occurrence_edit->description->Visible) { // description ?>
	<div id="r_description" class="form-group row">
		<label id="elh_occurrence_description" for="x_description" class="<?php echo $occurrence_edit->LeftColumnClass ?>"><?php echo $occurrence_edit->description->caption() ?><?php echo $occurrence_edit->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $occurrence_edit->RightColumnClass ?>"><div <?php echo $occurrence_edit->description->cellAttributes() ?>>
<span id="el_occurrence_description">
<textarea data-table="occurrence" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?php echo HtmlEncode($occurrence_edit->description->getPlaceHolder()) ?>"<?php echo $occurrence_edit->description->editAttributes() ?>><?php echo $occurrence_edit->description->EditValue ?></textarea>
</span>
<?php echo $occurrence_edit->description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($occurrence_edit->likelihood->Visible) { // likelihood ?>
	<div id="r_likelihood" class="form-group row">
		<label id="elh_occurrence_likelihood" for="x_likelihood" class="<?php echo $occurrence_edit->LeftColumnClass ?>"><?php echo $occurrence_edit->likelihood->caption() ?><?php echo $occurrence_edit->likelihood->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $occurrence_edit->RightColumnClass ?>"><div <?php echo $occurrence_edit->likelihood->cellAttributes() ?>>
<span id="el_occurrence_likelihood">
<textarea data-table="occurrence" data-field="x_likelihood" name="x_likelihood" id="x_likelihood" cols="35" rows="4" placeholder="<?php echo HtmlEncode($occurrence_edit->likelihood->getPlaceHolder()) ?>"<?php echo $occurrence_edit->likelihood->editAttributes() ?>><?php echo $occurrence_edit->likelihood->EditValue ?></textarea>
</span>
<?php echo $occurrence_edit->likelihood->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($occurrence_edit->timebased->Visible) { // timebased ?>
	<div id="r_timebased" class="form-group row">
		<label id="elh_occurrence_timebased" for="x_timebased" class="<?php echo $occurrence_edit->LeftColumnClass ?>"><?php echo $occurrence_edit->timebased->caption() ?><?php echo $occurrence_edit->timebased->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $occurrence_edit->RightColumnClass ?>"><div <?php echo $occurrence_edit->timebased->cellAttributes() ?>>
<span id="el_occurrence_timebased">
<input type="text" data-table="occurrence" data-field="x_timebased" name="x_timebased" id="x_timebased" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($occurrence_edit->timebased->getPlaceHolder()) ?>" value="<?php echo $occurrence_edit->timebased->EditValue ?>"<?php echo $occurrence_edit->timebased->editAttributes() ?>>
</span>
<?php echo $occurrence_edit->timebased->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($occurrence_edit->color->Visible) { // color ?>
	<div id="r_color" class="form-group row">
		<label id="elh_occurrence_color" for="x_color" class="<?php echo $occurrence_edit->LeftColumnClass ?>"><?php echo $occurrence_edit->color->caption() ?><?php echo $occurrence_edit->color->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $occurrence_edit->RightColumnClass ?>"><div <?php echo $occurrence_edit->color->cellAttributes() ?>>
<span id="el_occurrence_color">
<input type="text" data-table="occurrence" data-field="x_color" name="x_color" id="x_color" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($occurrence_edit->color->getPlaceHolder()) ?>" value="<?php echo $occurrence_edit->color->EditValue ?>"<?php echo $occurrence_edit->color->editAttributes() ?>>

<script>
loadjs.ready("head", function() {
	jQuery("[id='x_color']:not([id*='$rowindex$'])").colorpicker({ format: "hex" });
});
</script>

</span>
<?php echo $occurrence_edit->color->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$occurrence_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $occurrence_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($occurrence->UpdateConflict == "U") { // Record already updated by other user ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" onclick="this.form.action.value='overwrite';"><?php echo $Language->phrase("OverwriteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-reload" id="btn-reload" type="submit" onclick="this.form.action.value='show';"><?php echo $Language->phrase("ReloadBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $occurrence_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
<?php } ?>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$occurrence_edit->IsModal) { ?>
<?php echo $occurrence_edit->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<?php
$occurrence_edit->showPageFooter();
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
$occurrence_edit->terminate();
?>