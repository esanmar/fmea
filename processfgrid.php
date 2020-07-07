<?php
namespace PHPMaker2020\fmeaPRD;

// Write header
WriteHeader(FALSE);

// Create page object
if (!isset($processf_grid))
	$processf_grid = new processf_grid();

// Run the page
$processf_grid->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$processf_grid->Page_Render();
?>
<?php if (!$processf_grid->isExport()) { ?>
<script>
var fprocessfgrid, currentPageID;
loadjs.ready("head", function() {

	// Form object
	fprocessfgrid = new ew.Form("fprocessfgrid", "grid");
	fprocessfgrid.formKeyCountName = '<?php echo $processf_grid->FormKeyCountName ?>';

	// Validate form
	fprocessfgrid.validate = function() {
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
			var checkrow = (gridinsert) ? !this.emptyRow(infix) : true;
			if (checkrow) {
				addcnt++;
			<?php if ($processf_grid->fmea->Required) { ?>
				elm = this.getElements("x" + infix + "_fmea");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_grid->fmea->caption(), $processf_grid->fmea->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_grid->step->Required) { ?>
				elm = this.getElements("x" + infix + "_step");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_grid->step->caption(), $processf_grid->step->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_step");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($processf_grid->step->errorMessage()) ?>");
			<?php if ($processf_grid->flowchartDesc->Required) { ?>
				elm = this.getElements("x" + infix + "_flowchartDesc");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_grid->flowchartDesc->caption(), $processf_grid->flowchartDesc->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_grid->partnumber->Required) { ?>
				elm = this.getElements("x" + infix + "_partnumber");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_grid->partnumber->caption(), $processf_grid->partnumber->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_grid->operation->Required) { ?>
				elm = this.getElements("x" + infix + "_operation");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_grid->operation->caption(), $processf_grid->operation->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_grid->derivedFromNC->Required) { ?>
				elm = this.getElements("x" + infix + "_derivedFromNC[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_grid->derivedFromNC->caption(), $processf_grid->derivedFromNC->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_grid->numberOfNC->Required) { ?>
				elm = this.getElements("x" + infix + "_numberOfNC");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_grid->numberOfNC->caption(), $processf_grid->numberOfNC->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_grid->flowchart->Required) { ?>
				elm = this.getElements("x" + infix + "_flowchart");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_grid->flowchart->caption(), $processf_grid->flowchart->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_grid->subprocess->Required) { ?>
				elm = this.getElements("x" + infix + "_subprocess");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_grid->subprocess->caption(), $processf_grid->subprocess->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_grid->requirement->Required) { ?>
				elm = this.getElements("x" + infix + "_requirement");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_grid->requirement->caption(), $processf_grid->requirement->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_grid->potencialFailureMode->Required) { ?>
				elm = this.getElements("x" + infix + "_potencialFailureMode");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_grid->potencialFailureMode->caption(), $processf_grid->potencialFailureMode->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_grid->potencialFailurEffect->Required) { ?>
				elm = this.getElements("x" + infix + "_potencialFailurEffect");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_grid->potencialFailurEffect->caption(), $processf_grid->potencialFailurEffect->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_grid->kc->Required) { ?>
				elm = this.getElements("x" + infix + "_kc[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_grid->kc->caption(), $processf_grid->kc->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_grid->severity->Required) { ?>
				elm = this.getElements("x" + infix + "_severity");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_grid->severity->caption(), $processf_grid->severity->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_severity");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($processf_grid->severity->errorMessage()) ?>");

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
			} // End Grid Add checking
		}
		return true;
	}

	// Check empty row
	fprocessfgrid.emptyRow = function(infix) {
		var fobj = this._form;
		if (ew.valueChanged(fobj, infix, "fmea", false)) return false;
		if (ew.valueChanged(fobj, infix, "step", false)) return false;
		if (ew.valueChanged(fobj, infix, "flowchartDesc", false)) return false;
		if (ew.valueChanged(fobj, infix, "partnumber", false)) return false;
		if (ew.valueChanged(fobj, infix, "operation", false)) return false;
		if (ew.valueChanged(fobj, infix, "derivedFromNC[]", true)) return false;
		if (ew.valueChanged(fobj, infix, "numberOfNC", false)) return false;
		if (ew.valueChanged(fobj, infix, "flowchart", false)) return false;
		if (ew.valueChanged(fobj, infix, "subprocess", false)) return false;
		if (ew.valueChanged(fobj, infix, "requirement", false)) return false;
		if (ew.valueChanged(fobj, infix, "potencialFailureMode", false)) return false;
		if (ew.valueChanged(fobj, infix, "potencialFailurEffect", false)) return false;
		if (ew.valueChanged(fobj, infix, "kc[]", true)) return false;
		if (ew.valueChanged(fobj, infix, "severity", false)) return false;
		return true;
	}

	// Form_CustomValidate
	fprocessfgrid.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fprocessfgrid.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fprocessfgrid.lists["x_fmea"] = <?php echo $processf_grid->fmea->Lookup->toClientList($processf_grid) ?>;
	fprocessfgrid.lists["x_fmea"].options = <?php echo JsonEncode($processf_grid->fmea->lookupOptions()) ?>;
	fprocessfgrid.lists["x_derivedFromNC[]"] = <?php echo $processf_grid->derivedFromNC->Lookup->toClientList($processf_grid) ?>;
	fprocessfgrid.lists["x_derivedFromNC[]"].options = <?php echo JsonEncode($processf_grid->derivedFromNC->options(FALSE, TRUE)) ?>;
	fprocessfgrid.lists["x_kc[]"] = <?php echo $processf_grid->kc->Lookup->toClientList($processf_grid) ?>;
	fprocessfgrid.lists["x_kc[]"].options = <?php echo JsonEncode($processf_grid->kc->options(FALSE, TRUE)) ?>;
	loadjs.done("fprocessfgrid");
});
</script>
<?php } ?>
<?php
$processf_grid->renderOtherOptions();
?>
<?php if ($processf_grid->TotalRecords > 0 || $processf->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($processf_grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> processf">
<?php if ($processf_grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $processf_grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fprocessfgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_processf" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_processfgrid" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$processf->RowType = ROWTYPE_HEADER;

// Render list options
$processf_grid->renderListOptions();

// Render list options (header, left)
$processf_grid->ListOptions->render("header", "left");
?>
<?php if ($processf_grid->fmea->Visible) { // fmea ?>
	<?php if ($processf_grid->SortUrl($processf_grid->fmea) == "") { ?>
		<th data-name="fmea" class="<?php echo $processf_grid->fmea->headerCellClass() ?>"><div id="elh_processf_fmea" class="processf_fmea"><div class="ew-table-header-caption"><?php echo $processf_grid->fmea->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fmea" class="<?php echo $processf_grid->fmea->headerCellClass() ?>"><div><div id="elh_processf_fmea" class="processf_fmea">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_grid->fmea->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_grid->fmea->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_grid->fmea->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_grid->step->Visible) { // step ?>
	<?php if ($processf_grid->SortUrl($processf_grid->step) == "") { ?>
		<th data-name="step" class="<?php echo $processf_grid->step->headerCellClass() ?>"><div id="elh_processf_step" class="processf_step"><div class="ew-table-header-caption"><?php echo $processf_grid->step->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="step" class="<?php echo $processf_grid->step->headerCellClass() ?>"><div><div id="elh_processf_step" class="processf_step">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_grid->step->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_grid->step->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_grid->step->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_grid->flowchartDesc->Visible) { // flowchartDesc ?>
	<?php if ($processf_grid->SortUrl($processf_grid->flowchartDesc) == "") { ?>
		<th data-name="flowchartDesc" class="<?php echo $processf_grid->flowchartDesc->headerCellClass() ?>"><div id="elh_processf_flowchartDesc" class="processf_flowchartDesc"><div class="ew-table-header-caption"><?php echo $processf_grid->flowchartDesc->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="flowchartDesc" class="<?php echo $processf_grid->flowchartDesc->headerCellClass() ?>"><div><div id="elh_processf_flowchartDesc" class="processf_flowchartDesc">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_grid->flowchartDesc->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_grid->flowchartDesc->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_grid->flowchartDesc->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_grid->partnumber->Visible) { // partnumber ?>
	<?php if ($processf_grid->SortUrl($processf_grid->partnumber) == "") { ?>
		<th data-name="partnumber" class="<?php echo $processf_grid->partnumber->headerCellClass() ?>"><div id="elh_processf_partnumber" class="processf_partnumber"><div class="ew-table-header-caption"><?php echo $processf_grid->partnumber->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="partnumber" class="<?php echo $processf_grid->partnumber->headerCellClass() ?>"><div><div id="elh_processf_partnumber" class="processf_partnumber">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_grid->partnumber->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_grid->partnumber->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_grid->partnumber->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_grid->operation->Visible) { // operation ?>
	<?php if ($processf_grid->SortUrl($processf_grid->operation) == "") { ?>
		<th data-name="operation" class="<?php echo $processf_grid->operation->headerCellClass() ?>"><div id="elh_processf_operation" class="processf_operation"><div class="ew-table-header-caption"><?php echo $processf_grid->operation->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="operation" class="<?php echo $processf_grid->operation->headerCellClass() ?>"><div><div id="elh_processf_operation" class="processf_operation">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_grid->operation->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_grid->operation->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_grid->operation->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_grid->derivedFromNC->Visible) { // derivedFromNC ?>
	<?php if ($processf_grid->SortUrl($processf_grid->derivedFromNC) == "") { ?>
		<th data-name="derivedFromNC" class="<?php echo $processf_grid->derivedFromNC->headerCellClass() ?>"><div id="elh_processf_derivedFromNC" class="processf_derivedFromNC"><div class="ew-table-header-caption"><?php echo $processf_grid->derivedFromNC->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="derivedFromNC" class="<?php echo $processf_grid->derivedFromNC->headerCellClass() ?>"><div><div id="elh_processf_derivedFromNC" class="processf_derivedFromNC">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_grid->derivedFromNC->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_grid->derivedFromNC->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_grid->derivedFromNC->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_grid->numberOfNC->Visible) { // numberOfNC ?>
	<?php if ($processf_grid->SortUrl($processf_grid->numberOfNC) == "") { ?>
		<th data-name="numberOfNC" class="<?php echo $processf_grid->numberOfNC->headerCellClass() ?>"><div id="elh_processf_numberOfNC" class="processf_numberOfNC"><div class="ew-table-header-caption"><?php echo $processf_grid->numberOfNC->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="numberOfNC" class="<?php echo $processf_grid->numberOfNC->headerCellClass() ?>"><div><div id="elh_processf_numberOfNC" class="processf_numberOfNC">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_grid->numberOfNC->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_grid->numberOfNC->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_grid->numberOfNC->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_grid->flowchart->Visible) { // flowchart ?>
	<?php if ($processf_grid->SortUrl($processf_grid->flowchart) == "") { ?>
		<th data-name="flowchart" class="<?php echo $processf_grid->flowchart->headerCellClass() ?>"><div id="elh_processf_flowchart" class="processf_flowchart"><div class="ew-table-header-caption"><?php echo $processf_grid->flowchart->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="flowchart" class="<?php echo $processf_grid->flowchart->headerCellClass() ?>"><div><div id="elh_processf_flowchart" class="processf_flowchart">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_grid->flowchart->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_grid->flowchart->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_grid->flowchart->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_grid->subprocess->Visible) { // subprocess ?>
	<?php if ($processf_grid->SortUrl($processf_grid->subprocess) == "") { ?>
		<th data-name="subprocess" class="<?php echo $processf_grid->subprocess->headerCellClass() ?>"><div id="elh_processf_subprocess" class="processf_subprocess"><div class="ew-table-header-caption"><?php echo $processf_grid->subprocess->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="subprocess" class="<?php echo $processf_grid->subprocess->headerCellClass() ?>"><div><div id="elh_processf_subprocess" class="processf_subprocess">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_grid->subprocess->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_grid->subprocess->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_grid->subprocess->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_grid->requirement->Visible) { // requirement ?>
	<?php if ($processf_grid->SortUrl($processf_grid->requirement) == "") { ?>
		<th data-name="requirement" class="<?php echo $processf_grid->requirement->headerCellClass() ?>"><div id="elh_processf_requirement" class="processf_requirement"><div class="ew-table-header-caption"><?php echo $processf_grid->requirement->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="requirement" class="<?php echo $processf_grid->requirement->headerCellClass() ?>"><div><div id="elh_processf_requirement" class="processf_requirement">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_grid->requirement->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_grid->requirement->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_grid->requirement->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_grid->potencialFailureMode->Visible) { // potencialFailureMode ?>
	<?php if ($processf_grid->SortUrl($processf_grid->potencialFailureMode) == "") { ?>
		<th data-name="potencialFailureMode" class="<?php echo $processf_grid->potencialFailureMode->headerCellClass() ?>"><div id="elh_processf_potencialFailureMode" class="processf_potencialFailureMode"><div class="ew-table-header-caption"><?php echo $processf_grid->potencialFailureMode->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="potencialFailureMode" class="<?php echo $processf_grid->potencialFailureMode->headerCellClass() ?>"><div><div id="elh_processf_potencialFailureMode" class="processf_potencialFailureMode">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_grid->potencialFailureMode->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_grid->potencialFailureMode->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_grid->potencialFailureMode->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_grid->potencialFailurEffect->Visible) { // potencialFailurEffect ?>
	<?php if ($processf_grid->SortUrl($processf_grid->potencialFailurEffect) == "") { ?>
		<th data-name="potencialFailurEffect" class="<?php echo $processf_grid->potencialFailurEffect->headerCellClass() ?>"><div id="elh_processf_potencialFailurEffect" class="processf_potencialFailurEffect"><div class="ew-table-header-caption"><?php echo $processf_grid->potencialFailurEffect->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="potencialFailurEffect" class="<?php echo $processf_grid->potencialFailurEffect->headerCellClass() ?>"><div><div id="elh_processf_potencialFailurEffect" class="processf_potencialFailurEffect">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_grid->potencialFailurEffect->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_grid->potencialFailurEffect->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_grid->potencialFailurEffect->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_grid->kc->Visible) { // kc ?>
	<?php if ($processf_grid->SortUrl($processf_grid->kc) == "") { ?>
		<th data-name="kc" class="<?php echo $processf_grid->kc->headerCellClass() ?>"><div id="elh_processf_kc" class="processf_kc"><div class="ew-table-header-caption"><?php echo $processf_grid->kc->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kc" class="<?php echo $processf_grid->kc->headerCellClass() ?>"><div><div id="elh_processf_kc" class="processf_kc">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_grid->kc->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_grid->kc->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_grid->kc->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_grid->severity->Visible) { // severity ?>
	<?php if ($processf_grid->SortUrl($processf_grid->severity) == "") { ?>
		<th data-name="severity" class="<?php echo $processf_grid->severity->headerCellClass() ?>"><div id="elh_processf_severity" class="processf_severity"><div class="ew-table-header-caption"><?php echo $processf_grid->severity->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="severity" class="<?php echo $processf_grid->severity->headerCellClass() ?>"><div><div id="elh_processf_severity" class="processf_severity">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_grid->severity->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_grid->severity->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_grid->severity->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$processf_grid->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$processf_grid->StartRecord = 1;
$processf_grid->StopRecord = $processf_grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($processf->isConfirm() || $processf_grid->EventCancelled)) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($processf_grid->FormKeyCountName) && ($processf_grid->isGridAdd() || $processf_grid->isGridEdit() || $processf->isConfirm())) {
		$processf_grid->KeyCount = $CurrentForm->getValue($processf_grid->FormKeyCountName);
		$processf_grid->StopRecord = $processf_grid->StartRecord + $processf_grid->KeyCount - 1;
	}
}
$processf_grid->RecordCount = $processf_grid->StartRecord - 1;
if ($processf_grid->Recordset && !$processf_grid->Recordset->EOF) {
	$processf_grid->Recordset->moveFirst();
	$selectLimit = $processf_grid->UseSelectLimit;
	if (!$selectLimit && $processf_grid->StartRecord > 1)
		$processf_grid->Recordset->move($processf_grid->StartRecord - 1);
} elseif (!$processf->AllowAddDeleteRow && $processf_grid->StopRecord == 0) {
	$processf_grid->StopRecord = $processf->GridAddRowCount;
}

// Initialize aggregate
$processf->RowType = ROWTYPE_AGGREGATEINIT;
$processf->resetAttributes();
$processf_grid->renderRow();
if ($processf_grid->isGridAdd())
	$processf_grid->RowIndex = 0;
if ($processf_grid->isGridEdit())
	$processf_grid->RowIndex = 0;
while ($processf_grid->RecordCount < $processf_grid->StopRecord) {
	$processf_grid->RecordCount++;
	if ($processf_grid->RecordCount >= $processf_grid->StartRecord) {
		$processf_grid->RowCount++;
		if ($processf_grid->isGridAdd() || $processf_grid->isGridEdit() || $processf->isConfirm()) {
			$processf_grid->RowIndex++;
			$CurrentForm->Index = $processf_grid->RowIndex;
			if ($CurrentForm->hasValue($processf_grid->FormActionName) && ($processf->isConfirm() || $processf_grid->EventCancelled))
				$processf_grid->RowAction = strval($CurrentForm->getValue($processf_grid->FormActionName));
			elseif ($processf_grid->isGridAdd())
				$processf_grid->RowAction = "insert";
			else
				$processf_grid->RowAction = "";
		}

		// Set up key count
		$processf_grid->KeyCount = $processf_grid->RowIndex;

		// Init row class and style
		$processf->resetAttributes();
		$processf->CssClass = "";
		if ($processf_grid->isGridAdd()) {
			if ($processf->CurrentMode == "copy") {
				$processf_grid->loadRowValues($processf_grid->Recordset); // Load row values
				$processf_grid->setRecordKey($processf_grid->RowOldKey, $processf_grid->Recordset); // Set old record key
			} else {
				$processf_grid->loadRowValues(); // Load default values
				$processf_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$processf_grid->loadRowValues($processf_grid->Recordset); // Load row values
		}
		$processf->RowType = ROWTYPE_VIEW; // Render view
		if ($processf_grid->isGridAdd()) // Grid add
			$processf->RowType = ROWTYPE_ADD; // Render add
		if ($processf_grid->isGridAdd() && $processf->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$processf_grid->restoreCurrentRowFormValues($processf_grid->RowIndex); // Restore form values
		if ($processf_grid->isGridEdit()) { // Grid edit
			if ($processf->EventCancelled)
				$processf_grid->restoreCurrentRowFormValues($processf_grid->RowIndex); // Restore form values
			if ($processf_grid->RowAction == "insert")
				$processf->RowType = ROWTYPE_ADD; // Render add
			else
				$processf->RowType = ROWTYPE_EDIT; // Render edit
			if (!$processf->EventCancelled)
				$processf_grid->HashValue = $processf_grid->getRowHash($processf_grid->Recordset); // Get hash value for record
		}
		if ($processf_grid->isGridEdit() && ($processf->RowType == ROWTYPE_EDIT || $processf->RowType == ROWTYPE_ADD) && $processf->EventCancelled) // Update failed
			$processf_grid->restoreCurrentRowFormValues($processf_grid->RowIndex); // Restore form values
		if ($processf->RowType == ROWTYPE_EDIT) // Edit row
			$processf_grid->EditRowCount++;
		if ($processf->isConfirm()) // Confirm row
			$processf_grid->restoreCurrentRowFormValues($processf_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$processf->RowAttrs->merge(["data-rowindex" => $processf_grid->RowCount, "id" => "r" . $processf_grid->RowCount . "_processf", "data-rowtype" => $processf->RowType]);

		// Render row
		$processf_grid->renderRow();

		// Render list options
		$processf_grid->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($processf_grid->RowAction != "delete" && $processf_grid->RowAction != "insertdelete" && !($processf_grid->RowAction == "insert" && $processf->isConfirm() && $processf_grid->emptyRow())) {
?>
	<tr <?php echo $processf->rowAttributes() ?>>
<?php

// Render list options (body, left)
$processf_grid->ListOptions->render("body", "left", $processf_grid->RowCount);
?>
	<?php if ($processf_grid->fmea->Visible) { // fmea ?>
		<td data-name="fmea" <?php echo $processf_grid->fmea->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($processf_grid->fmea->getSessionValue() != "") { ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_fmea" class="form-group">
<span<?php echo $processf_grid->fmea->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($processf_grid->fmea->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $processf_grid->RowIndex ?>_fmea" name="x<?php echo $processf_grid->RowIndex ?>_fmea" value="<?php echo HtmlEncode($processf_grid->fmea->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_fmea" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="processf" data-field="x_fmea" data-value-separator="<?php echo $processf_grid->fmea->displayValueSeparatorAttribute() ?>" id="x<?php echo $processf_grid->RowIndex ?>_fmea" name="x<?php echo $processf_grid->RowIndex ?>_fmea"<?php echo $processf_grid->fmea->editAttributes() ?>>
			<?php echo $processf_grid->fmea->selectOptionListHtml("x{$processf_grid->RowIndex}_fmea") ?>
		</select>
</div>
<?php echo $processf_grid->fmea->Lookup->getParamTag($processf_grid, "p_x" . $processf_grid->RowIndex . "_fmea") ?>
</span>
<?php } ?>
<input type="hidden" data-table="processf" data-field="x_fmea" name="o<?php echo $processf_grid->RowIndex ?>_fmea" id="o<?php echo $processf_grid->RowIndex ?>_fmea" value="<?php echo HtmlEncode($processf_grid->fmea->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($processf_grid->fmea->getSessionValue() != "") { ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_fmea" class="form-group">
<span<?php echo $processf_grid->fmea->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($processf_grid->fmea->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $processf_grid->RowIndex ?>_fmea" name="x<?php echo $processf_grid->RowIndex ?>_fmea" value="<?php echo HtmlEncode($processf_grid->fmea->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_fmea" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="processf" data-field="x_fmea" data-value-separator="<?php echo $processf_grid->fmea->displayValueSeparatorAttribute() ?>" id="x<?php echo $processf_grid->RowIndex ?>_fmea" name="x<?php echo $processf_grid->RowIndex ?>_fmea"<?php echo $processf_grid->fmea->editAttributes() ?>>
			<?php echo $processf_grid->fmea->selectOptionListHtml("x{$processf_grid->RowIndex}_fmea") ?>
		</select>
</div>
<?php echo $processf_grid->fmea->Lookup->getParamTag($processf_grid, "p_x" . $processf_grid->RowIndex . "_fmea") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_fmea">
<span<?php echo $processf_grid->fmea->viewAttributes() ?>><?php echo $processf_grid->fmea->getViewValue() ?></span>
</span>
<?php if (!$processf->isConfirm()) { ?>
<input type="hidden" data-table="processf" data-field="x_fmea" name="x<?php echo $processf_grid->RowIndex ?>_fmea" id="x<?php echo $processf_grid->RowIndex ?>_fmea" value="<?php echo HtmlEncode($processf_grid->fmea->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_fmea" name="o<?php echo $processf_grid->RowIndex ?>_fmea" id="o<?php echo $processf_grid->RowIndex ?>_fmea" value="<?php echo HtmlEncode($processf_grid->fmea->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="processf" data-field="x_fmea" name="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_fmea" id="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_fmea" value="<?php echo HtmlEncode($processf_grid->fmea->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_fmea" name="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_fmea" id="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_fmea" value="<?php echo HtmlEncode($processf_grid->fmea->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="processf" data-field="x_idProcess" name="x<?php echo $processf_grid->RowIndex ?>_idProcess" id="x<?php echo $processf_grid->RowIndex ?>_idProcess" value="<?php echo HtmlEncode($processf_grid->idProcess->CurrentValue) ?>">
<input type="hidden" data-table="processf" data-field="x_idProcess" name="o<?php echo $processf_grid->RowIndex ?>_idProcess" id="o<?php echo $processf_grid->RowIndex ?>_idProcess" value="<?php echo HtmlEncode($processf_grid->idProcess->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT || $processf->CurrentMode == "edit") { ?>
<input type="hidden" data-table="processf" data-field="x_idProcess" name="x<?php echo $processf_grid->RowIndex ?>_idProcess" id="x<?php echo $processf_grid->RowIndex ?>_idProcess" value="<?php echo HtmlEncode($processf_grid->idProcess->CurrentValue) ?>">
<?php } ?>
	<?php if ($processf_grid->step->Visible) { // step ?>
		<td data-name="step" <?php echo $processf_grid->step->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_step" class="form-group">
<input type="text" data-table="processf" data-field="x_step" name="x<?php echo $processf_grid->RowIndex ?>_step" id="x<?php echo $processf_grid->RowIndex ?>_step" size="30" maxlength="6" placeholder="<?php echo HtmlEncode($processf_grid->step->getPlaceHolder()) ?>" value="<?php echo $processf_grid->step->EditValue ?>"<?php echo $processf_grid->step->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_step" name="o<?php echo $processf_grid->RowIndex ?>_step" id="o<?php echo $processf_grid->RowIndex ?>_step" value="<?php echo HtmlEncode($processf_grid->step->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_step" class="form-group">
<input type="text" data-table="processf" data-field="x_step" name="x<?php echo $processf_grid->RowIndex ?>_step" id="x<?php echo $processf_grid->RowIndex ?>_step" size="30" maxlength="6" placeholder="<?php echo HtmlEncode($processf_grid->step->getPlaceHolder()) ?>" value="<?php echo $processf_grid->step->EditValue ?>"<?php echo $processf_grid->step->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_step">
<span<?php echo $processf_grid->step->viewAttributes() ?>><?php echo $processf_grid->step->getViewValue() ?></span>
</span>
<?php if (!$processf->isConfirm()) { ?>
<input type="hidden" data-table="processf" data-field="x_step" name="x<?php echo $processf_grid->RowIndex ?>_step" id="x<?php echo $processf_grid->RowIndex ?>_step" value="<?php echo HtmlEncode($processf_grid->step->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_step" name="o<?php echo $processf_grid->RowIndex ?>_step" id="o<?php echo $processf_grid->RowIndex ?>_step" value="<?php echo HtmlEncode($processf_grid->step->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="processf" data-field="x_step" name="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_step" id="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_step" value="<?php echo HtmlEncode($processf_grid->step->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_step" name="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_step" id="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_step" value="<?php echo HtmlEncode($processf_grid->step->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($processf_grid->flowchartDesc->Visible) { // flowchartDesc ?>
		<td data-name="flowchartDesc" <?php echo $processf_grid->flowchartDesc->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_flowchartDesc" class="form-group">
<textarea data-table="processf" data-field="x_flowchartDesc" name="x<?php echo $processf_grid->RowIndex ?>_flowchartDesc" id="x<?php echo $processf_grid->RowIndex ?>_flowchartDesc" cols="35" rows="2" placeholder="<?php echo HtmlEncode($processf_grid->flowchartDesc->getPlaceHolder()) ?>"<?php echo $processf_grid->flowchartDesc->editAttributes() ?>><?php echo $processf_grid->flowchartDesc->EditValue ?></textarea>
</span>
<input type="hidden" data-table="processf" data-field="x_flowchartDesc" name="o<?php echo $processf_grid->RowIndex ?>_flowchartDesc" id="o<?php echo $processf_grid->RowIndex ?>_flowchartDesc" value="<?php echo HtmlEncode($processf_grid->flowchartDesc->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_flowchartDesc" class="form-group">
<textarea data-table="processf" data-field="x_flowchartDesc" name="x<?php echo $processf_grid->RowIndex ?>_flowchartDesc" id="x<?php echo $processf_grid->RowIndex ?>_flowchartDesc" cols="35" rows="2" placeholder="<?php echo HtmlEncode($processf_grid->flowchartDesc->getPlaceHolder()) ?>"<?php echo $processf_grid->flowchartDesc->editAttributes() ?>><?php echo $processf_grid->flowchartDesc->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_flowchartDesc">
<span<?php echo $processf_grid->flowchartDesc->viewAttributes() ?>><?php echo $processf_grid->flowchartDesc->getViewValue() ?></span>
</span>
<?php if (!$processf->isConfirm()) { ?>
<input type="hidden" data-table="processf" data-field="x_flowchartDesc" name="x<?php echo $processf_grid->RowIndex ?>_flowchartDesc" id="x<?php echo $processf_grid->RowIndex ?>_flowchartDesc" value="<?php echo HtmlEncode($processf_grid->flowchartDesc->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_flowchartDesc" name="o<?php echo $processf_grid->RowIndex ?>_flowchartDesc" id="o<?php echo $processf_grid->RowIndex ?>_flowchartDesc" value="<?php echo HtmlEncode($processf_grid->flowchartDesc->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="processf" data-field="x_flowchartDesc" name="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_flowchartDesc" id="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_flowchartDesc" value="<?php echo HtmlEncode($processf_grid->flowchartDesc->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_flowchartDesc" name="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_flowchartDesc" id="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_flowchartDesc" value="<?php echo HtmlEncode($processf_grid->flowchartDesc->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($processf_grid->partnumber->Visible) { // partnumber ?>
		<td data-name="partnumber" <?php echo $processf_grid->partnumber->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_partnumber" class="form-group">
<input type="text" data-table="processf" data-field="x_partnumber" name="x<?php echo $processf_grid->RowIndex ?>_partnumber" id="x<?php echo $processf_grid->RowIndex ?>_partnumber" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_grid->partnumber->getPlaceHolder()) ?>" value="<?php echo $processf_grid->partnumber->EditValue ?>"<?php echo $processf_grid->partnumber->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_partnumber" name="o<?php echo $processf_grid->RowIndex ?>_partnumber" id="o<?php echo $processf_grid->RowIndex ?>_partnumber" value="<?php echo HtmlEncode($processf_grid->partnumber->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_partnumber" class="form-group">
<input type="text" data-table="processf" data-field="x_partnumber" name="x<?php echo $processf_grid->RowIndex ?>_partnumber" id="x<?php echo $processf_grid->RowIndex ?>_partnumber" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_grid->partnumber->getPlaceHolder()) ?>" value="<?php echo $processf_grid->partnumber->EditValue ?>"<?php echo $processf_grid->partnumber->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_partnumber">
<span<?php echo $processf_grid->partnumber->viewAttributes() ?>><?php echo $processf_grid->partnumber->getViewValue() ?></span>
</span>
<?php if (!$processf->isConfirm()) { ?>
<input type="hidden" data-table="processf" data-field="x_partnumber" name="x<?php echo $processf_grid->RowIndex ?>_partnumber" id="x<?php echo $processf_grid->RowIndex ?>_partnumber" value="<?php echo HtmlEncode($processf_grid->partnumber->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_partnumber" name="o<?php echo $processf_grid->RowIndex ?>_partnumber" id="o<?php echo $processf_grid->RowIndex ?>_partnumber" value="<?php echo HtmlEncode($processf_grid->partnumber->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="processf" data-field="x_partnumber" name="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_partnumber" id="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_partnumber" value="<?php echo HtmlEncode($processf_grid->partnumber->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_partnumber" name="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_partnumber" id="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_partnumber" value="<?php echo HtmlEncode($processf_grid->partnumber->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($processf_grid->operation->Visible) { // operation ?>
		<td data-name="operation" <?php echo $processf_grid->operation->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_operation" class="form-group">
<input type="text" data-table="processf" data-field="x_operation" name="x<?php echo $processf_grid->RowIndex ?>_operation" id="x<?php echo $processf_grid->RowIndex ?>_operation" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_grid->operation->getPlaceHolder()) ?>" value="<?php echo $processf_grid->operation->EditValue ?>"<?php echo $processf_grid->operation->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_operation" name="o<?php echo $processf_grid->RowIndex ?>_operation" id="o<?php echo $processf_grid->RowIndex ?>_operation" value="<?php echo HtmlEncode($processf_grid->operation->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_operation" class="form-group">
<input type="text" data-table="processf" data-field="x_operation" name="x<?php echo $processf_grid->RowIndex ?>_operation" id="x<?php echo $processf_grid->RowIndex ?>_operation" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_grid->operation->getPlaceHolder()) ?>" value="<?php echo $processf_grid->operation->EditValue ?>"<?php echo $processf_grid->operation->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_operation">
<span<?php echo $processf_grid->operation->viewAttributes() ?>><?php echo $processf_grid->operation->getViewValue() ?></span>
</span>
<?php if (!$processf->isConfirm()) { ?>
<input type="hidden" data-table="processf" data-field="x_operation" name="x<?php echo $processf_grid->RowIndex ?>_operation" id="x<?php echo $processf_grid->RowIndex ?>_operation" value="<?php echo HtmlEncode($processf_grid->operation->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_operation" name="o<?php echo $processf_grid->RowIndex ?>_operation" id="o<?php echo $processf_grid->RowIndex ?>_operation" value="<?php echo HtmlEncode($processf_grid->operation->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="processf" data-field="x_operation" name="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_operation" id="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_operation" value="<?php echo HtmlEncode($processf_grid->operation->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_operation" name="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_operation" id="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_operation" value="<?php echo HtmlEncode($processf_grid->operation->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($processf_grid->derivedFromNC->Visible) { // derivedFromNC ?>
		<td data-name="derivedFromNC" <?php echo $processf_grid->derivedFromNC->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_derivedFromNC" class="form-group">
<?php
$selwrk = ConvertToBool($processf_grid->derivedFromNC->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="processf" data-field="x_derivedFromNC" name="x<?php echo $processf_grid->RowIndex ?>_derivedFromNC[]" id="x<?php echo $processf_grid->RowIndex ?>_derivedFromNC[]" value="1"<?php echo $selwrk ?><?php echo $processf_grid->derivedFromNC->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $processf_grid->RowIndex ?>_derivedFromNC[]"></label>
</div>
</span>
<input type="hidden" data-table="processf" data-field="x_derivedFromNC" name="o<?php echo $processf_grid->RowIndex ?>_derivedFromNC[]" id="o<?php echo $processf_grid->RowIndex ?>_derivedFromNC[]" value="<?php echo HtmlEncode($processf_grid->derivedFromNC->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_derivedFromNC" class="form-group">
<?php
$selwrk = ConvertToBool($processf_grid->derivedFromNC->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="processf" data-field="x_derivedFromNC" name="x<?php echo $processf_grid->RowIndex ?>_derivedFromNC[]" id="x<?php echo $processf_grid->RowIndex ?>_derivedFromNC[]" value="1"<?php echo $selwrk ?><?php echo $processf_grid->derivedFromNC->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $processf_grid->RowIndex ?>_derivedFromNC[]"></label>
</div>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_derivedFromNC">
<span<?php echo $processf_grid->derivedFromNC->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_derivedFromNC" class="custom-control-input" value="<?php echo $processf_grid->derivedFromNC->getViewValue() ?>" disabled<?php if (ConvertToBool($processf_grid->derivedFromNC->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_derivedFromNC"></label></div></span>
</span>
<?php if (!$processf->isConfirm()) { ?>
<input type="hidden" data-table="processf" data-field="x_derivedFromNC" name="x<?php echo $processf_grid->RowIndex ?>_derivedFromNC" id="x<?php echo $processf_grid->RowIndex ?>_derivedFromNC" value="<?php echo HtmlEncode($processf_grid->derivedFromNC->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_derivedFromNC" name="o<?php echo $processf_grid->RowIndex ?>_derivedFromNC[]" id="o<?php echo $processf_grid->RowIndex ?>_derivedFromNC[]" value="<?php echo HtmlEncode($processf_grid->derivedFromNC->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="processf" data-field="x_derivedFromNC" name="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_derivedFromNC" id="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_derivedFromNC" value="<?php echo HtmlEncode($processf_grid->derivedFromNC->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_derivedFromNC" name="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_derivedFromNC[]" id="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_derivedFromNC[]" value="<?php echo HtmlEncode($processf_grid->derivedFromNC->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($processf_grid->numberOfNC->Visible) { // numberOfNC ?>
		<td data-name="numberOfNC" <?php echo $processf_grid->numberOfNC->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_numberOfNC" class="form-group">
<input type="text" data-table="processf" data-field="x_numberOfNC" name="x<?php echo $processf_grid->RowIndex ?>_numberOfNC" id="x<?php echo $processf_grid->RowIndex ?>_numberOfNC" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_grid->numberOfNC->getPlaceHolder()) ?>" value="<?php echo $processf_grid->numberOfNC->EditValue ?>"<?php echo $processf_grid->numberOfNC->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_numberOfNC" name="o<?php echo $processf_grid->RowIndex ?>_numberOfNC" id="o<?php echo $processf_grid->RowIndex ?>_numberOfNC" value="<?php echo HtmlEncode($processf_grid->numberOfNC->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_numberOfNC" class="form-group">
<input type="text" data-table="processf" data-field="x_numberOfNC" name="x<?php echo $processf_grid->RowIndex ?>_numberOfNC" id="x<?php echo $processf_grid->RowIndex ?>_numberOfNC" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_grid->numberOfNC->getPlaceHolder()) ?>" value="<?php echo $processf_grid->numberOfNC->EditValue ?>"<?php echo $processf_grid->numberOfNC->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_numberOfNC">
<span<?php echo $processf_grid->numberOfNC->viewAttributes() ?>><?php echo $processf_grid->numberOfNC->getViewValue() ?></span>
</span>
<?php if (!$processf->isConfirm()) { ?>
<input type="hidden" data-table="processf" data-field="x_numberOfNC" name="x<?php echo $processf_grid->RowIndex ?>_numberOfNC" id="x<?php echo $processf_grid->RowIndex ?>_numberOfNC" value="<?php echo HtmlEncode($processf_grid->numberOfNC->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_numberOfNC" name="o<?php echo $processf_grid->RowIndex ?>_numberOfNC" id="o<?php echo $processf_grid->RowIndex ?>_numberOfNC" value="<?php echo HtmlEncode($processf_grid->numberOfNC->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="processf" data-field="x_numberOfNC" name="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_numberOfNC" id="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_numberOfNC" value="<?php echo HtmlEncode($processf_grid->numberOfNC->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_numberOfNC" name="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_numberOfNC" id="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_numberOfNC" value="<?php echo HtmlEncode($processf_grid->numberOfNC->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($processf_grid->flowchart->Visible) { // flowchart ?>
		<td data-name="flowchart" <?php echo $processf_grid->flowchart->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_flowchart" class="form-group">
<input type="text" data-table="processf" data-field="x_flowchart" name="x<?php echo $processf_grid->RowIndex ?>_flowchart" id="x<?php echo $processf_grid->RowIndex ?>_flowchart" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_grid->flowchart->getPlaceHolder()) ?>" value="<?php echo $processf_grid->flowchart->EditValue ?>"<?php echo $processf_grid->flowchart->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_flowchart" name="o<?php echo $processf_grid->RowIndex ?>_flowchart" id="o<?php echo $processf_grid->RowIndex ?>_flowchart" value="<?php echo HtmlEncode($processf_grid->flowchart->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_flowchart" class="form-group">
<input type="text" data-table="processf" data-field="x_flowchart" name="x<?php echo $processf_grid->RowIndex ?>_flowchart" id="x<?php echo $processf_grid->RowIndex ?>_flowchart" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_grid->flowchart->getPlaceHolder()) ?>" value="<?php echo $processf_grid->flowchart->EditValue ?>"<?php echo $processf_grid->flowchart->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_flowchart">
<span<?php echo $processf_grid->flowchart->viewAttributes() ?>><?php echo $processf_grid->flowchart->getViewValue() ?></span>
</span>
<?php if (!$processf->isConfirm()) { ?>
<input type="hidden" data-table="processf" data-field="x_flowchart" name="x<?php echo $processf_grid->RowIndex ?>_flowchart" id="x<?php echo $processf_grid->RowIndex ?>_flowchart" value="<?php echo HtmlEncode($processf_grid->flowchart->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_flowchart" name="o<?php echo $processf_grid->RowIndex ?>_flowchart" id="o<?php echo $processf_grid->RowIndex ?>_flowchart" value="<?php echo HtmlEncode($processf_grid->flowchart->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="processf" data-field="x_flowchart" name="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_flowchart" id="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_flowchart" value="<?php echo HtmlEncode($processf_grid->flowchart->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_flowchart" name="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_flowchart" id="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_flowchart" value="<?php echo HtmlEncode($processf_grid->flowchart->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($processf_grid->subprocess->Visible) { // subprocess ?>
		<td data-name="subprocess" <?php echo $processf_grid->subprocess->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_subprocess" class="form-group">
<input type="text" data-table="processf" data-field="x_subprocess" name="x<?php echo $processf_grid->RowIndex ?>_subprocess" id="x<?php echo $processf_grid->RowIndex ?>_subprocess" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_grid->subprocess->getPlaceHolder()) ?>" value="<?php echo $processf_grid->subprocess->EditValue ?>"<?php echo $processf_grid->subprocess->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_subprocess" name="o<?php echo $processf_grid->RowIndex ?>_subprocess" id="o<?php echo $processf_grid->RowIndex ?>_subprocess" value="<?php echo HtmlEncode($processf_grid->subprocess->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_subprocess" class="form-group">
<input type="text" data-table="processf" data-field="x_subprocess" name="x<?php echo $processf_grid->RowIndex ?>_subprocess" id="x<?php echo $processf_grid->RowIndex ?>_subprocess" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_grid->subprocess->getPlaceHolder()) ?>" value="<?php echo $processf_grid->subprocess->EditValue ?>"<?php echo $processf_grid->subprocess->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_subprocess">
<span<?php echo $processf_grid->subprocess->viewAttributes() ?>><?php echo $processf_grid->subprocess->getViewValue() ?></span>
</span>
<?php if (!$processf->isConfirm()) { ?>
<input type="hidden" data-table="processf" data-field="x_subprocess" name="x<?php echo $processf_grid->RowIndex ?>_subprocess" id="x<?php echo $processf_grid->RowIndex ?>_subprocess" value="<?php echo HtmlEncode($processf_grid->subprocess->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_subprocess" name="o<?php echo $processf_grid->RowIndex ?>_subprocess" id="o<?php echo $processf_grid->RowIndex ?>_subprocess" value="<?php echo HtmlEncode($processf_grid->subprocess->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="processf" data-field="x_subprocess" name="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_subprocess" id="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_subprocess" value="<?php echo HtmlEncode($processf_grid->subprocess->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_subprocess" name="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_subprocess" id="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_subprocess" value="<?php echo HtmlEncode($processf_grid->subprocess->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($processf_grid->requirement->Visible) { // requirement ?>
		<td data-name="requirement" <?php echo $processf_grid->requirement->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_requirement" class="form-group">
<input type="text" data-table="processf" data-field="x_requirement" name="x<?php echo $processf_grid->RowIndex ?>_requirement" id="x<?php echo $processf_grid->RowIndex ?>_requirement" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_grid->requirement->getPlaceHolder()) ?>" value="<?php echo $processf_grid->requirement->EditValue ?>"<?php echo $processf_grid->requirement->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_requirement" name="o<?php echo $processf_grid->RowIndex ?>_requirement" id="o<?php echo $processf_grid->RowIndex ?>_requirement" value="<?php echo HtmlEncode($processf_grid->requirement->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_requirement" class="form-group">
<input type="text" data-table="processf" data-field="x_requirement" name="x<?php echo $processf_grid->RowIndex ?>_requirement" id="x<?php echo $processf_grid->RowIndex ?>_requirement" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_grid->requirement->getPlaceHolder()) ?>" value="<?php echo $processf_grid->requirement->EditValue ?>"<?php echo $processf_grid->requirement->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_requirement">
<span<?php echo $processf_grid->requirement->viewAttributes() ?>><?php echo $processf_grid->requirement->getViewValue() ?></span>
</span>
<?php if (!$processf->isConfirm()) { ?>
<input type="hidden" data-table="processf" data-field="x_requirement" name="x<?php echo $processf_grid->RowIndex ?>_requirement" id="x<?php echo $processf_grid->RowIndex ?>_requirement" value="<?php echo HtmlEncode($processf_grid->requirement->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_requirement" name="o<?php echo $processf_grid->RowIndex ?>_requirement" id="o<?php echo $processf_grid->RowIndex ?>_requirement" value="<?php echo HtmlEncode($processf_grid->requirement->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="processf" data-field="x_requirement" name="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_requirement" id="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_requirement" value="<?php echo HtmlEncode($processf_grid->requirement->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_requirement" name="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_requirement" id="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_requirement" value="<?php echo HtmlEncode($processf_grid->requirement->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($processf_grid->potencialFailureMode->Visible) { // potencialFailureMode ?>
		<td data-name="potencialFailureMode" <?php echo $processf_grid->potencialFailureMode->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_potencialFailureMode" class="form-group">
<input type="text" data-table="processf" data-field="x_potencialFailureMode" name="x<?php echo $processf_grid->RowIndex ?>_potencialFailureMode" id="x<?php echo $processf_grid->RowIndex ?>_potencialFailureMode" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_grid->potencialFailureMode->getPlaceHolder()) ?>" value="<?php echo $processf_grid->potencialFailureMode->EditValue ?>"<?php echo $processf_grid->potencialFailureMode->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_potencialFailureMode" name="o<?php echo $processf_grid->RowIndex ?>_potencialFailureMode" id="o<?php echo $processf_grid->RowIndex ?>_potencialFailureMode" value="<?php echo HtmlEncode($processf_grid->potencialFailureMode->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_potencialFailureMode" class="form-group">
<input type="text" data-table="processf" data-field="x_potencialFailureMode" name="x<?php echo $processf_grid->RowIndex ?>_potencialFailureMode" id="x<?php echo $processf_grid->RowIndex ?>_potencialFailureMode" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_grid->potencialFailureMode->getPlaceHolder()) ?>" value="<?php echo $processf_grid->potencialFailureMode->EditValue ?>"<?php echo $processf_grid->potencialFailureMode->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_potencialFailureMode">
<span<?php echo $processf_grid->potencialFailureMode->viewAttributes() ?>><?php echo $processf_grid->potencialFailureMode->getViewValue() ?></span>
</span>
<?php if (!$processf->isConfirm()) { ?>
<input type="hidden" data-table="processf" data-field="x_potencialFailureMode" name="x<?php echo $processf_grid->RowIndex ?>_potencialFailureMode" id="x<?php echo $processf_grid->RowIndex ?>_potencialFailureMode" value="<?php echo HtmlEncode($processf_grid->potencialFailureMode->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_potencialFailureMode" name="o<?php echo $processf_grid->RowIndex ?>_potencialFailureMode" id="o<?php echo $processf_grid->RowIndex ?>_potencialFailureMode" value="<?php echo HtmlEncode($processf_grid->potencialFailureMode->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="processf" data-field="x_potencialFailureMode" name="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_potencialFailureMode" id="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_potencialFailureMode" value="<?php echo HtmlEncode($processf_grid->potencialFailureMode->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_potencialFailureMode" name="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_potencialFailureMode" id="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_potencialFailureMode" value="<?php echo HtmlEncode($processf_grid->potencialFailureMode->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($processf_grid->potencialFailurEffect->Visible) { // potencialFailurEffect ?>
		<td data-name="potencialFailurEffect" <?php echo $processf_grid->potencialFailurEffect->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_potencialFailurEffect" class="form-group">
<input type="text" data-table="processf" data-field="x_potencialFailurEffect" name="x<?php echo $processf_grid->RowIndex ?>_potencialFailurEffect" id="x<?php echo $processf_grid->RowIndex ?>_potencialFailurEffect" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_grid->potencialFailurEffect->getPlaceHolder()) ?>" value="<?php echo $processf_grid->potencialFailurEffect->EditValue ?>"<?php echo $processf_grid->potencialFailurEffect->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_potencialFailurEffect" name="o<?php echo $processf_grid->RowIndex ?>_potencialFailurEffect" id="o<?php echo $processf_grid->RowIndex ?>_potencialFailurEffect" value="<?php echo HtmlEncode($processf_grid->potencialFailurEffect->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_potencialFailurEffect" class="form-group">
<input type="text" data-table="processf" data-field="x_potencialFailurEffect" name="x<?php echo $processf_grid->RowIndex ?>_potencialFailurEffect" id="x<?php echo $processf_grid->RowIndex ?>_potencialFailurEffect" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_grid->potencialFailurEffect->getPlaceHolder()) ?>" value="<?php echo $processf_grid->potencialFailurEffect->EditValue ?>"<?php echo $processf_grid->potencialFailurEffect->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_potencialFailurEffect">
<span<?php echo $processf_grid->potencialFailurEffect->viewAttributes() ?>><?php echo $processf_grid->potencialFailurEffect->getViewValue() ?></span>
</span>
<?php if (!$processf->isConfirm()) { ?>
<input type="hidden" data-table="processf" data-field="x_potencialFailurEffect" name="x<?php echo $processf_grid->RowIndex ?>_potencialFailurEffect" id="x<?php echo $processf_grid->RowIndex ?>_potencialFailurEffect" value="<?php echo HtmlEncode($processf_grid->potencialFailurEffect->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_potencialFailurEffect" name="o<?php echo $processf_grid->RowIndex ?>_potencialFailurEffect" id="o<?php echo $processf_grid->RowIndex ?>_potencialFailurEffect" value="<?php echo HtmlEncode($processf_grid->potencialFailurEffect->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="processf" data-field="x_potencialFailurEffect" name="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_potencialFailurEffect" id="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_potencialFailurEffect" value="<?php echo HtmlEncode($processf_grid->potencialFailurEffect->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_potencialFailurEffect" name="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_potencialFailurEffect" id="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_potencialFailurEffect" value="<?php echo HtmlEncode($processf_grid->potencialFailurEffect->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($processf_grid->kc->Visible) { // kc ?>
		<td data-name="kc" <?php echo $processf_grid->kc->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_kc" class="form-group">
<?php
$selwrk = ConvertToBool($processf_grid->kc->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="processf" data-field="x_kc" name="x<?php echo $processf_grid->RowIndex ?>_kc[]" id="x<?php echo $processf_grid->RowIndex ?>_kc[]" value="1"<?php echo $selwrk ?><?php echo $processf_grid->kc->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $processf_grid->RowIndex ?>_kc[]"></label>
</div>
</span>
<input type="hidden" data-table="processf" data-field="x_kc" name="o<?php echo $processf_grid->RowIndex ?>_kc[]" id="o<?php echo $processf_grid->RowIndex ?>_kc[]" value="<?php echo HtmlEncode($processf_grid->kc->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_kc" class="form-group">
<?php
$selwrk = ConvertToBool($processf_grid->kc->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="processf" data-field="x_kc" name="x<?php echo $processf_grid->RowIndex ?>_kc[]" id="x<?php echo $processf_grid->RowIndex ?>_kc[]" value="1"<?php echo $selwrk ?><?php echo $processf_grid->kc->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $processf_grid->RowIndex ?>_kc[]"></label>
</div>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_kc">
<span<?php echo $processf_grid->kc->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_kc" class="custom-control-input" value="<?php echo $processf_grid->kc->getViewValue() ?>" disabled<?php if (ConvertToBool($processf_grid->kc->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_kc"></label></div></span>
</span>
<?php if (!$processf->isConfirm()) { ?>
<input type="hidden" data-table="processf" data-field="x_kc" name="x<?php echo $processf_grid->RowIndex ?>_kc" id="x<?php echo $processf_grid->RowIndex ?>_kc" value="<?php echo HtmlEncode($processf_grid->kc->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_kc" name="o<?php echo $processf_grid->RowIndex ?>_kc[]" id="o<?php echo $processf_grid->RowIndex ?>_kc[]" value="<?php echo HtmlEncode($processf_grid->kc->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="processf" data-field="x_kc" name="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_kc" id="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_kc" value="<?php echo HtmlEncode($processf_grid->kc->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_kc" name="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_kc[]" id="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_kc[]" value="<?php echo HtmlEncode($processf_grid->kc->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($processf_grid->severity->Visible) { // severity ?>
		<td data-name="severity" <?php echo $processf_grid->severity->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_severity" class="form-group">
<input type="text" data-table="processf" data-field="x_severity" name="x<?php echo $processf_grid->RowIndex ?>_severity" id="x<?php echo $processf_grid->RowIndex ?>_severity" size="3" placeholder="<?php echo HtmlEncode($processf_grid->severity->getPlaceHolder()) ?>" value="<?php echo $processf_grid->severity->EditValue ?>"<?php echo $processf_grid->severity->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_severity" name="o<?php echo $processf_grid->RowIndex ?>_severity" id="o<?php echo $processf_grid->RowIndex ?>_severity" value="<?php echo HtmlEncode($processf_grid->severity->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_severity" class="form-group">
<input type="text" data-table="processf" data-field="x_severity" name="x<?php echo $processf_grid->RowIndex ?>_severity" id="x<?php echo $processf_grid->RowIndex ?>_severity" size="3" placeholder="<?php echo HtmlEncode($processf_grid->severity->getPlaceHolder()) ?>" value="<?php echo $processf_grid->severity->EditValue ?>"<?php echo $processf_grid->severity->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_grid->RowCount ?>_processf_severity">
<span<?php echo $processf_grid->severity->viewAttributes() ?>><?php echo $processf_grid->severity->getViewValue() ?></span>
</span>
<?php if (!$processf->isConfirm()) { ?>
<input type="hidden" data-table="processf" data-field="x_severity" name="x<?php echo $processf_grid->RowIndex ?>_severity" id="x<?php echo $processf_grid->RowIndex ?>_severity" value="<?php echo HtmlEncode($processf_grid->severity->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_severity" name="o<?php echo $processf_grid->RowIndex ?>_severity" id="o<?php echo $processf_grid->RowIndex ?>_severity" value="<?php echo HtmlEncode($processf_grid->severity->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="processf" data-field="x_severity" name="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_severity" id="fprocessfgrid$x<?php echo $processf_grid->RowIndex ?>_severity" value="<?php echo HtmlEncode($processf_grid->severity->FormValue) ?>">
<input type="hidden" data-table="processf" data-field="x_severity" name="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_severity" id="fprocessfgrid$o<?php echo $processf_grid->RowIndex ?>_severity" value="<?php echo HtmlEncode($processf_grid->severity->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$processf_grid->ListOptions->render("body", "right", $processf_grid->RowCount);
?>
	</tr>
<?php if ($processf->RowType == ROWTYPE_ADD || $processf->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fprocessfgrid", "load"], function() {
	fprocessfgrid.updateLists(<?php echo $processf_grid->RowIndex ?>);
});
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$processf_grid->isGridAdd() || $processf->CurrentMode == "copy")
		if (!$processf_grid->Recordset->EOF)
			$processf_grid->Recordset->moveNext();
}
?>
<?php
	if ($processf->CurrentMode == "add" || $processf->CurrentMode == "copy" || $processf->CurrentMode == "edit") {
		$processf_grid->RowIndex = '$rowindex$';
		$processf_grid->loadRowValues();

		// Set row properties
		$processf->resetAttributes();
		$processf->RowAttrs->merge(["data-rowindex" => $processf_grid->RowIndex, "id" => "r0_processf", "data-rowtype" => ROWTYPE_ADD]);
		$processf->RowAttrs->appendClass("ew-template");
		$processf->RowType = ROWTYPE_ADD;

		// Render row
		$processf_grid->renderRow();

		// Render list options
		$processf_grid->renderListOptions();
		$processf_grid->StartRowCount = 0;
?>
	<tr <?php echo $processf->rowAttributes() ?>>
<?php

// Render list options (body, left)
$processf_grid->ListOptions->render("body", "left", $processf_grid->RowIndex);
?>
	<?php if ($processf_grid->fmea->Visible) { // fmea ?>
		<td data-name="fmea">
<?php if (!$processf->isConfirm()) { ?>
<?php if ($processf_grid->fmea->getSessionValue() != "") { ?>
<span id="el$rowindex$_processf_fmea" class="form-group processf_fmea">
<span<?php echo $processf_grid->fmea->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($processf_grid->fmea->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $processf_grid->RowIndex ?>_fmea" name="x<?php echo $processf_grid->RowIndex ?>_fmea" value="<?php echo HtmlEncode($processf_grid->fmea->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_processf_fmea" class="form-group processf_fmea">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="processf" data-field="x_fmea" data-value-separator="<?php echo $processf_grid->fmea->displayValueSeparatorAttribute() ?>" id="x<?php echo $processf_grid->RowIndex ?>_fmea" name="x<?php echo $processf_grid->RowIndex ?>_fmea"<?php echo $processf_grid->fmea->editAttributes() ?>>
			<?php echo $processf_grid->fmea->selectOptionListHtml("x{$processf_grid->RowIndex}_fmea") ?>
		</select>
</div>
<?php echo $processf_grid->fmea->Lookup->getParamTag($processf_grid, "p_x" . $processf_grid->RowIndex . "_fmea") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_processf_fmea" class="form-group processf_fmea">
<span<?php echo $processf_grid->fmea->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($processf_grid->fmea->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="processf" data-field="x_fmea" name="x<?php echo $processf_grid->RowIndex ?>_fmea" id="x<?php echo $processf_grid->RowIndex ?>_fmea" value="<?php echo HtmlEncode($processf_grid->fmea->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="processf" data-field="x_fmea" name="o<?php echo $processf_grid->RowIndex ?>_fmea" id="o<?php echo $processf_grid->RowIndex ?>_fmea" value="<?php echo HtmlEncode($processf_grid->fmea->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_grid->step->Visible) { // step ?>
		<td data-name="step">
<?php if (!$processf->isConfirm()) { ?>
<span id="el$rowindex$_processf_step" class="form-group processf_step">
<input type="text" data-table="processf" data-field="x_step" name="x<?php echo $processf_grid->RowIndex ?>_step" id="x<?php echo $processf_grid->RowIndex ?>_step" size="30" maxlength="6" placeholder="<?php echo HtmlEncode($processf_grid->step->getPlaceHolder()) ?>" value="<?php echo $processf_grid->step->EditValue ?>"<?php echo $processf_grid->step->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_processf_step" class="form-group processf_step">
<span<?php echo $processf_grid->step->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($processf_grid->step->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="processf" data-field="x_step" name="x<?php echo $processf_grid->RowIndex ?>_step" id="x<?php echo $processf_grid->RowIndex ?>_step" value="<?php echo HtmlEncode($processf_grid->step->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="processf" data-field="x_step" name="o<?php echo $processf_grid->RowIndex ?>_step" id="o<?php echo $processf_grid->RowIndex ?>_step" value="<?php echo HtmlEncode($processf_grid->step->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_grid->flowchartDesc->Visible) { // flowchartDesc ?>
		<td data-name="flowchartDesc">
<?php if (!$processf->isConfirm()) { ?>
<span id="el$rowindex$_processf_flowchartDesc" class="form-group processf_flowchartDesc">
<textarea data-table="processf" data-field="x_flowchartDesc" name="x<?php echo $processf_grid->RowIndex ?>_flowchartDesc" id="x<?php echo $processf_grid->RowIndex ?>_flowchartDesc" cols="35" rows="2" placeholder="<?php echo HtmlEncode($processf_grid->flowchartDesc->getPlaceHolder()) ?>"<?php echo $processf_grid->flowchartDesc->editAttributes() ?>><?php echo $processf_grid->flowchartDesc->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_processf_flowchartDesc" class="form-group processf_flowchartDesc">
<span<?php echo $processf_grid->flowchartDesc->viewAttributes() ?>><?php echo $processf_grid->flowchartDesc->ViewValue ?></span>
</span>
<input type="hidden" data-table="processf" data-field="x_flowchartDesc" name="x<?php echo $processf_grid->RowIndex ?>_flowchartDesc" id="x<?php echo $processf_grid->RowIndex ?>_flowchartDesc" value="<?php echo HtmlEncode($processf_grid->flowchartDesc->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="processf" data-field="x_flowchartDesc" name="o<?php echo $processf_grid->RowIndex ?>_flowchartDesc" id="o<?php echo $processf_grid->RowIndex ?>_flowchartDesc" value="<?php echo HtmlEncode($processf_grid->flowchartDesc->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_grid->partnumber->Visible) { // partnumber ?>
		<td data-name="partnumber">
<?php if (!$processf->isConfirm()) { ?>
<span id="el$rowindex$_processf_partnumber" class="form-group processf_partnumber">
<input type="text" data-table="processf" data-field="x_partnumber" name="x<?php echo $processf_grid->RowIndex ?>_partnumber" id="x<?php echo $processf_grid->RowIndex ?>_partnumber" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_grid->partnumber->getPlaceHolder()) ?>" value="<?php echo $processf_grid->partnumber->EditValue ?>"<?php echo $processf_grid->partnumber->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_processf_partnumber" class="form-group processf_partnumber">
<span<?php echo $processf_grid->partnumber->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($processf_grid->partnumber->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="processf" data-field="x_partnumber" name="x<?php echo $processf_grid->RowIndex ?>_partnumber" id="x<?php echo $processf_grid->RowIndex ?>_partnumber" value="<?php echo HtmlEncode($processf_grid->partnumber->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="processf" data-field="x_partnumber" name="o<?php echo $processf_grid->RowIndex ?>_partnumber" id="o<?php echo $processf_grid->RowIndex ?>_partnumber" value="<?php echo HtmlEncode($processf_grid->partnumber->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_grid->operation->Visible) { // operation ?>
		<td data-name="operation">
<?php if (!$processf->isConfirm()) { ?>
<span id="el$rowindex$_processf_operation" class="form-group processf_operation">
<input type="text" data-table="processf" data-field="x_operation" name="x<?php echo $processf_grid->RowIndex ?>_operation" id="x<?php echo $processf_grid->RowIndex ?>_operation" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_grid->operation->getPlaceHolder()) ?>" value="<?php echo $processf_grid->operation->EditValue ?>"<?php echo $processf_grid->operation->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_processf_operation" class="form-group processf_operation">
<span<?php echo $processf_grid->operation->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($processf_grid->operation->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="processf" data-field="x_operation" name="x<?php echo $processf_grid->RowIndex ?>_operation" id="x<?php echo $processf_grid->RowIndex ?>_operation" value="<?php echo HtmlEncode($processf_grid->operation->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="processf" data-field="x_operation" name="o<?php echo $processf_grid->RowIndex ?>_operation" id="o<?php echo $processf_grid->RowIndex ?>_operation" value="<?php echo HtmlEncode($processf_grid->operation->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_grid->derivedFromNC->Visible) { // derivedFromNC ?>
		<td data-name="derivedFromNC">
<?php if (!$processf->isConfirm()) { ?>
<span id="el$rowindex$_processf_derivedFromNC" class="form-group processf_derivedFromNC">
<?php
$selwrk = ConvertToBool($processf_grid->derivedFromNC->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="processf" data-field="x_derivedFromNC" name="x<?php echo $processf_grid->RowIndex ?>_derivedFromNC[]" id="x<?php echo $processf_grid->RowIndex ?>_derivedFromNC[]" value="1"<?php echo $selwrk ?><?php echo $processf_grid->derivedFromNC->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $processf_grid->RowIndex ?>_derivedFromNC[]"></label>
</div>
</span>
<?php } else { ?>
<span id="el$rowindex$_processf_derivedFromNC" class="form-group processf_derivedFromNC">
<span<?php echo $processf_grid->derivedFromNC->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_derivedFromNC" class="custom-control-input" value="<?php echo $processf_grid->derivedFromNC->ViewValue ?>" disabled<?php if (ConvertToBool($processf_grid->derivedFromNC->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_derivedFromNC"></label></div></span>
</span>
<input type="hidden" data-table="processf" data-field="x_derivedFromNC" name="x<?php echo $processf_grid->RowIndex ?>_derivedFromNC" id="x<?php echo $processf_grid->RowIndex ?>_derivedFromNC" value="<?php echo HtmlEncode($processf_grid->derivedFromNC->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="processf" data-field="x_derivedFromNC" name="o<?php echo $processf_grid->RowIndex ?>_derivedFromNC[]" id="o<?php echo $processf_grid->RowIndex ?>_derivedFromNC[]" value="<?php echo HtmlEncode($processf_grid->derivedFromNC->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_grid->numberOfNC->Visible) { // numberOfNC ?>
		<td data-name="numberOfNC">
<?php if (!$processf->isConfirm()) { ?>
<span id="el$rowindex$_processf_numberOfNC" class="form-group processf_numberOfNC">
<input type="text" data-table="processf" data-field="x_numberOfNC" name="x<?php echo $processf_grid->RowIndex ?>_numberOfNC" id="x<?php echo $processf_grid->RowIndex ?>_numberOfNC" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_grid->numberOfNC->getPlaceHolder()) ?>" value="<?php echo $processf_grid->numberOfNC->EditValue ?>"<?php echo $processf_grid->numberOfNC->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_processf_numberOfNC" class="form-group processf_numberOfNC">
<span<?php echo $processf_grid->numberOfNC->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($processf_grid->numberOfNC->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="processf" data-field="x_numberOfNC" name="x<?php echo $processf_grid->RowIndex ?>_numberOfNC" id="x<?php echo $processf_grid->RowIndex ?>_numberOfNC" value="<?php echo HtmlEncode($processf_grid->numberOfNC->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="processf" data-field="x_numberOfNC" name="o<?php echo $processf_grid->RowIndex ?>_numberOfNC" id="o<?php echo $processf_grid->RowIndex ?>_numberOfNC" value="<?php echo HtmlEncode($processf_grid->numberOfNC->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_grid->flowchart->Visible) { // flowchart ?>
		<td data-name="flowchart">
<?php if (!$processf->isConfirm()) { ?>
<span id="el$rowindex$_processf_flowchart" class="form-group processf_flowchart">
<input type="text" data-table="processf" data-field="x_flowchart" name="x<?php echo $processf_grid->RowIndex ?>_flowchart" id="x<?php echo $processf_grid->RowIndex ?>_flowchart" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_grid->flowchart->getPlaceHolder()) ?>" value="<?php echo $processf_grid->flowchart->EditValue ?>"<?php echo $processf_grid->flowchart->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_processf_flowchart" class="form-group processf_flowchart">
<span<?php echo $processf_grid->flowchart->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($processf_grid->flowchart->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="processf" data-field="x_flowchart" name="x<?php echo $processf_grid->RowIndex ?>_flowchart" id="x<?php echo $processf_grid->RowIndex ?>_flowchart" value="<?php echo HtmlEncode($processf_grid->flowchart->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="processf" data-field="x_flowchart" name="o<?php echo $processf_grid->RowIndex ?>_flowchart" id="o<?php echo $processf_grid->RowIndex ?>_flowchart" value="<?php echo HtmlEncode($processf_grid->flowchart->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_grid->subprocess->Visible) { // subprocess ?>
		<td data-name="subprocess">
<?php if (!$processf->isConfirm()) { ?>
<span id="el$rowindex$_processf_subprocess" class="form-group processf_subprocess">
<input type="text" data-table="processf" data-field="x_subprocess" name="x<?php echo $processf_grid->RowIndex ?>_subprocess" id="x<?php echo $processf_grid->RowIndex ?>_subprocess" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_grid->subprocess->getPlaceHolder()) ?>" value="<?php echo $processf_grid->subprocess->EditValue ?>"<?php echo $processf_grid->subprocess->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_processf_subprocess" class="form-group processf_subprocess">
<span<?php echo $processf_grid->subprocess->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($processf_grid->subprocess->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="processf" data-field="x_subprocess" name="x<?php echo $processf_grid->RowIndex ?>_subprocess" id="x<?php echo $processf_grid->RowIndex ?>_subprocess" value="<?php echo HtmlEncode($processf_grid->subprocess->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="processf" data-field="x_subprocess" name="o<?php echo $processf_grid->RowIndex ?>_subprocess" id="o<?php echo $processf_grid->RowIndex ?>_subprocess" value="<?php echo HtmlEncode($processf_grid->subprocess->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_grid->requirement->Visible) { // requirement ?>
		<td data-name="requirement">
<?php if (!$processf->isConfirm()) { ?>
<span id="el$rowindex$_processf_requirement" class="form-group processf_requirement">
<input type="text" data-table="processf" data-field="x_requirement" name="x<?php echo $processf_grid->RowIndex ?>_requirement" id="x<?php echo $processf_grid->RowIndex ?>_requirement" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_grid->requirement->getPlaceHolder()) ?>" value="<?php echo $processf_grid->requirement->EditValue ?>"<?php echo $processf_grid->requirement->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_processf_requirement" class="form-group processf_requirement">
<span<?php echo $processf_grid->requirement->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($processf_grid->requirement->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="processf" data-field="x_requirement" name="x<?php echo $processf_grid->RowIndex ?>_requirement" id="x<?php echo $processf_grid->RowIndex ?>_requirement" value="<?php echo HtmlEncode($processf_grid->requirement->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="processf" data-field="x_requirement" name="o<?php echo $processf_grid->RowIndex ?>_requirement" id="o<?php echo $processf_grid->RowIndex ?>_requirement" value="<?php echo HtmlEncode($processf_grid->requirement->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_grid->potencialFailureMode->Visible) { // potencialFailureMode ?>
		<td data-name="potencialFailureMode">
<?php if (!$processf->isConfirm()) { ?>
<span id="el$rowindex$_processf_potencialFailureMode" class="form-group processf_potencialFailureMode">
<input type="text" data-table="processf" data-field="x_potencialFailureMode" name="x<?php echo $processf_grid->RowIndex ?>_potencialFailureMode" id="x<?php echo $processf_grid->RowIndex ?>_potencialFailureMode" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_grid->potencialFailureMode->getPlaceHolder()) ?>" value="<?php echo $processf_grid->potencialFailureMode->EditValue ?>"<?php echo $processf_grid->potencialFailureMode->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_processf_potencialFailureMode" class="form-group processf_potencialFailureMode">
<span<?php echo $processf_grid->potencialFailureMode->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($processf_grid->potencialFailureMode->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="processf" data-field="x_potencialFailureMode" name="x<?php echo $processf_grid->RowIndex ?>_potencialFailureMode" id="x<?php echo $processf_grid->RowIndex ?>_potencialFailureMode" value="<?php echo HtmlEncode($processf_grid->potencialFailureMode->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="processf" data-field="x_potencialFailureMode" name="o<?php echo $processf_grid->RowIndex ?>_potencialFailureMode" id="o<?php echo $processf_grid->RowIndex ?>_potencialFailureMode" value="<?php echo HtmlEncode($processf_grid->potencialFailureMode->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_grid->potencialFailurEffect->Visible) { // potencialFailurEffect ?>
		<td data-name="potencialFailurEffect">
<?php if (!$processf->isConfirm()) { ?>
<span id="el$rowindex$_processf_potencialFailurEffect" class="form-group processf_potencialFailurEffect">
<input type="text" data-table="processf" data-field="x_potencialFailurEffect" name="x<?php echo $processf_grid->RowIndex ?>_potencialFailurEffect" id="x<?php echo $processf_grid->RowIndex ?>_potencialFailurEffect" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_grid->potencialFailurEffect->getPlaceHolder()) ?>" value="<?php echo $processf_grid->potencialFailurEffect->EditValue ?>"<?php echo $processf_grid->potencialFailurEffect->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_processf_potencialFailurEffect" class="form-group processf_potencialFailurEffect">
<span<?php echo $processf_grid->potencialFailurEffect->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($processf_grid->potencialFailurEffect->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="processf" data-field="x_potencialFailurEffect" name="x<?php echo $processf_grid->RowIndex ?>_potencialFailurEffect" id="x<?php echo $processf_grid->RowIndex ?>_potencialFailurEffect" value="<?php echo HtmlEncode($processf_grid->potencialFailurEffect->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="processf" data-field="x_potencialFailurEffect" name="o<?php echo $processf_grid->RowIndex ?>_potencialFailurEffect" id="o<?php echo $processf_grid->RowIndex ?>_potencialFailurEffect" value="<?php echo HtmlEncode($processf_grid->potencialFailurEffect->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_grid->kc->Visible) { // kc ?>
		<td data-name="kc">
<?php if (!$processf->isConfirm()) { ?>
<span id="el$rowindex$_processf_kc" class="form-group processf_kc">
<?php
$selwrk = ConvertToBool($processf_grid->kc->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="processf" data-field="x_kc" name="x<?php echo $processf_grid->RowIndex ?>_kc[]" id="x<?php echo $processf_grid->RowIndex ?>_kc[]" value="1"<?php echo $selwrk ?><?php echo $processf_grid->kc->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $processf_grid->RowIndex ?>_kc[]"></label>
</div>
</span>
<?php } else { ?>
<span id="el$rowindex$_processf_kc" class="form-group processf_kc">
<span<?php echo $processf_grid->kc->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_kc" class="custom-control-input" value="<?php echo $processf_grid->kc->ViewValue ?>" disabled<?php if (ConvertToBool($processf_grid->kc->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_kc"></label></div></span>
</span>
<input type="hidden" data-table="processf" data-field="x_kc" name="x<?php echo $processf_grid->RowIndex ?>_kc" id="x<?php echo $processf_grid->RowIndex ?>_kc" value="<?php echo HtmlEncode($processf_grid->kc->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="processf" data-field="x_kc" name="o<?php echo $processf_grid->RowIndex ?>_kc[]" id="o<?php echo $processf_grid->RowIndex ?>_kc[]" value="<?php echo HtmlEncode($processf_grid->kc->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_grid->severity->Visible) { // severity ?>
		<td data-name="severity">
<?php if (!$processf->isConfirm()) { ?>
<span id="el$rowindex$_processf_severity" class="form-group processf_severity">
<input type="text" data-table="processf" data-field="x_severity" name="x<?php echo $processf_grid->RowIndex ?>_severity" id="x<?php echo $processf_grid->RowIndex ?>_severity" size="3" placeholder="<?php echo HtmlEncode($processf_grid->severity->getPlaceHolder()) ?>" value="<?php echo $processf_grid->severity->EditValue ?>"<?php echo $processf_grid->severity->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_processf_severity" class="form-group processf_severity">
<span<?php echo $processf_grid->severity->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($processf_grid->severity->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="processf" data-field="x_severity" name="x<?php echo $processf_grid->RowIndex ?>_severity" id="x<?php echo $processf_grid->RowIndex ?>_severity" value="<?php echo HtmlEncode($processf_grid->severity->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="processf" data-field="x_severity" name="o<?php echo $processf_grid->RowIndex ?>_severity" id="o<?php echo $processf_grid->RowIndex ?>_severity" value="<?php echo HtmlEncode($processf_grid->severity->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$processf_grid->ListOptions->render("body", "right", $processf_grid->RowIndex);
?>
<script>
loadjs.ready(["fprocessfgrid", "load"], function() {
	fprocessfgrid.updateLists(<?php echo $processf_grid->RowIndex ?>);
});
</script>
	</tr>
<?php
	}
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($processf->CurrentMode == "add" || $processf->CurrentMode == "copy") { ?>
<input type="hidden" name="<?php echo $processf_grid->FormKeyCountName ?>" id="<?php echo $processf_grid->FormKeyCountName ?>" value="<?php echo $processf_grid->KeyCount ?>">
<?php echo $processf_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($processf->CurrentMode == "edit") { ?>
<input type="hidden" name="<?php echo $processf_grid->FormKeyCountName ?>" id="<?php echo $processf_grid->FormKeyCountName ?>" value="<?php echo $processf_grid->KeyCount ?>">
<?php echo $processf_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($processf->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fprocessfgrid">
</div><!-- /.ew-list-form -->
<?php

// Close recordset
if ($processf_grid->Recordset)
	$processf_grid->Recordset->Close();
?>
<?php if ($processf_grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $processf_grid->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($processf_grid->TotalRecords == 0 && !$processf->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $processf_grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if (!$processf_grid->isExport()) { ?>
<script>
loadjs.ready("load", function() {

	// Startup script
	// Write your table-specific startup script here
	// console.log("page loaded");

});
</script>
<?php } ?>
<?php
$processf_grid->terminate();
?>