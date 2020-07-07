<?php
namespace PHPMaker2020\fmeaPRD;

// Write header
WriteHeader(FALSE);

// Create page object
if (!isset($issue_grid))
	$issue_grid = new issue_grid();

// Run the page
$issue_grid->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$issue_grid->Page_Render();
?>
<?php if (!$issue_grid->isExport()) { ?>
<script>
var fissuegrid, currentPageID;
loadjs.ready("head", function() {

	// Form object
	fissuegrid = new ew.Form("fissuegrid", "grid");
	fissuegrid.formKeyCountName = '<?php echo $issue_grid->FormKeyCountName ?>';

	// Validate form
	fissuegrid.validate = function() {
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
			<?php if ($issue_grid->fmea->Required) { ?>
				elm = this.getElements("x" + infix + "_fmea");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $issue_grid->fmea->caption(), $issue_grid->fmea->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($issue_grid->issue->Required) { ?>
				elm = this.getElements("x" + infix + "_issue");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $issue_grid->issue->caption(), $issue_grid->issue->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($issue_grid->date->Required) { ?>
				elm = this.getElements("x" + infix + "_date");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $issue_grid->date->caption(), $issue_grid->date->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_date");
				if (elm && !ew.checkDateDef(elm.value))
					return this.onError(elm, "<?php echo JsEncode($issue_grid->date->errorMessage()) ?>");
			<?php if ($issue_grid->cause->Required) { ?>
				elm = this.getElements("x" + infix + "_cause");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $issue_grid->cause->caption(), $issue_grid->cause->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($issue_grid->leader->Required) { ?>
				elm = this.getElements("x" + infix + "_leader[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $issue_grid->leader->caption(), $issue_grid->leader->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($issue_grid->employee->Required) { ?>
				elm = this.getElements("x" + infix + "_employee[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $issue_grid->employee->caption(), $issue_grid->employee->RequiredErrorMessage)) ?>");
			<?php } ?>

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
			} // End Grid Add checking
		}
		return true;
	}

	// Check empty row
	fissuegrid.emptyRow = function(infix) {
		var fobj = this._form;
		if (ew.valueChanged(fobj, infix, "fmea", false)) return false;
		if (ew.valueChanged(fobj, infix, "date", false)) return false;
		if (ew.valueChanged(fobj, infix, "cause", false)) return false;
		if (ew.valueChanged(fobj, infix, "leader[]", false)) return false;
		if (ew.valueChanged(fobj, infix, "employee[]", false)) return false;
		return true;
	}

	// Form_CustomValidate
	fissuegrid.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fissuegrid.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fissuegrid.lists["x_fmea"] = <?php echo $issue_grid->fmea->Lookup->toClientList($issue_grid) ?>;
	fissuegrid.lists["x_fmea"].options = <?php echo JsonEncode($issue_grid->fmea->lookupOptions()) ?>;
	fissuegrid.lists["x_leader[]"] = <?php echo $issue_grid->leader->Lookup->toClientList($issue_grid) ?>;
	fissuegrid.lists["x_leader[]"].options = <?php echo JsonEncode($issue_grid->leader->lookupOptions()) ?>;
	fissuegrid.lists["x_employee[]"] = <?php echo $issue_grid->employee->Lookup->toClientList($issue_grid) ?>;
	fissuegrid.lists["x_employee[]"].options = <?php echo JsonEncode($issue_grid->employee->lookupOptions()) ?>;
	loadjs.done("fissuegrid");
});
</script>
<?php } ?>
<?php
$issue_grid->renderOtherOptions();
?>
<?php if ($issue_grid->TotalRecords > 0 || $issue->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($issue_grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> issue">
<?php if ($issue_grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $issue_grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fissuegrid" class="ew-form ew-list-form form-inline">
<div id="gmp_issue" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_issuegrid" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$issue->RowType = ROWTYPE_HEADER;

// Render list options
$issue_grid->renderListOptions();

// Render list options (header, left)
$issue_grid->ListOptions->render("header", "left");
?>
<?php if ($issue_grid->fmea->Visible) { // fmea ?>
	<?php if ($issue_grid->SortUrl($issue_grid->fmea) == "") { ?>
		<th data-name="fmea" class="<?php echo $issue_grid->fmea->headerCellClass() ?>"><div id="elh_issue_fmea" class="issue_fmea"><div class="ew-table-header-caption"><?php echo $issue_grid->fmea->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fmea" class="<?php echo $issue_grid->fmea->headerCellClass() ?>"><div><div id="elh_issue_fmea" class="issue_fmea">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $issue_grid->fmea->caption() ?></span><span class="ew-table-header-sort"><?php if ($issue_grid->fmea->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($issue_grid->fmea->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($issue_grid->issue->Visible) { // issue ?>
	<?php if ($issue_grid->SortUrl($issue_grid->issue) == "") { ?>
		<th data-name="issue" class="<?php echo $issue_grid->issue->headerCellClass() ?>"><div id="elh_issue_issue" class="issue_issue"><div class="ew-table-header-caption"><?php echo $issue_grid->issue->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="issue" class="<?php echo $issue_grid->issue->headerCellClass() ?>"><div><div id="elh_issue_issue" class="issue_issue">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $issue_grid->issue->caption() ?></span><span class="ew-table-header-sort"><?php if ($issue_grid->issue->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($issue_grid->issue->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($issue_grid->date->Visible) { // date ?>
	<?php if ($issue_grid->SortUrl($issue_grid->date) == "") { ?>
		<th data-name="date" class="<?php echo $issue_grid->date->headerCellClass() ?>"><div id="elh_issue_date" class="issue_date"><div class="ew-table-header-caption"><?php echo $issue_grid->date->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="date" class="<?php echo $issue_grid->date->headerCellClass() ?>"><div><div id="elh_issue_date" class="issue_date">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $issue_grid->date->caption() ?></span><span class="ew-table-header-sort"><?php if ($issue_grid->date->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($issue_grid->date->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($issue_grid->cause->Visible) { // cause ?>
	<?php if ($issue_grid->SortUrl($issue_grid->cause) == "") { ?>
		<th data-name="cause" class="<?php echo $issue_grid->cause->headerCellClass() ?>"><div id="elh_issue_cause" class="issue_cause"><div class="ew-table-header-caption"><?php echo $issue_grid->cause->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cause" class="<?php echo $issue_grid->cause->headerCellClass() ?>"><div><div id="elh_issue_cause" class="issue_cause">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $issue_grid->cause->caption() ?></span><span class="ew-table-header-sort"><?php if ($issue_grid->cause->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($issue_grid->cause->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($issue_grid->leader->Visible) { // leader ?>
	<?php if ($issue_grid->SortUrl($issue_grid->leader) == "") { ?>
		<th data-name="leader" class="<?php echo $issue_grid->leader->headerCellClass() ?>"><div id="elh_issue_leader" class="issue_leader"><div class="ew-table-header-caption"><?php echo $issue_grid->leader->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="leader" class="<?php echo $issue_grid->leader->headerCellClass() ?>"><div><div id="elh_issue_leader" class="issue_leader">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $issue_grid->leader->caption() ?></span><span class="ew-table-header-sort"><?php if ($issue_grid->leader->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($issue_grid->leader->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($issue_grid->employee->Visible) { // employee ?>
	<?php if ($issue_grid->SortUrl($issue_grid->employee) == "") { ?>
		<th data-name="employee" class="<?php echo $issue_grid->employee->headerCellClass() ?>"><div id="elh_issue_employee" class="issue_employee"><div class="ew-table-header-caption"><?php echo $issue_grid->employee->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="employee" class="<?php echo $issue_grid->employee->headerCellClass() ?>"><div><div id="elh_issue_employee" class="issue_employee">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $issue_grid->employee->caption() ?></span><span class="ew-table-header-sort"><?php if ($issue_grid->employee->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($issue_grid->employee->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$issue_grid->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$issue_grid->StartRecord = 1;
$issue_grid->StopRecord = $issue_grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($issue->isConfirm() || $issue_grid->EventCancelled)) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($issue_grid->FormKeyCountName) && ($issue_grid->isGridAdd() || $issue_grid->isGridEdit() || $issue->isConfirm())) {
		$issue_grid->KeyCount = $CurrentForm->getValue($issue_grid->FormKeyCountName);
		$issue_grid->StopRecord = $issue_grid->StartRecord + $issue_grid->KeyCount - 1;
	}
}
$issue_grid->RecordCount = $issue_grid->StartRecord - 1;
if ($issue_grid->Recordset && !$issue_grid->Recordset->EOF) {
	$issue_grid->Recordset->moveFirst();
	$selectLimit = $issue_grid->UseSelectLimit;
	if (!$selectLimit && $issue_grid->StartRecord > 1)
		$issue_grid->Recordset->move($issue_grid->StartRecord - 1);
} elseif (!$issue->AllowAddDeleteRow && $issue_grid->StopRecord == 0) {
	$issue_grid->StopRecord = $issue->GridAddRowCount;
}

// Initialize aggregate
$issue->RowType = ROWTYPE_AGGREGATEINIT;
$issue->resetAttributes();
$issue_grid->renderRow();
if ($issue_grid->isGridAdd())
	$issue_grid->RowIndex = 0;
if ($issue_grid->isGridEdit())
	$issue_grid->RowIndex = 0;
while ($issue_grid->RecordCount < $issue_grid->StopRecord) {
	$issue_grid->RecordCount++;
	if ($issue_grid->RecordCount >= $issue_grid->StartRecord) {
		$issue_grid->RowCount++;
		if ($issue_grid->isGridAdd() || $issue_grid->isGridEdit() || $issue->isConfirm()) {
			$issue_grid->RowIndex++;
			$CurrentForm->Index = $issue_grid->RowIndex;
			if ($CurrentForm->hasValue($issue_grid->FormActionName) && ($issue->isConfirm() || $issue_grid->EventCancelled))
				$issue_grid->RowAction = strval($CurrentForm->getValue($issue_grid->FormActionName));
			elseif ($issue_grid->isGridAdd())
				$issue_grid->RowAction = "insert";
			else
				$issue_grid->RowAction = "";
		}

		// Set up key count
		$issue_grid->KeyCount = $issue_grid->RowIndex;

		// Init row class and style
		$issue->resetAttributes();
		$issue->CssClass = "";
		if ($issue_grid->isGridAdd()) {
			if ($issue->CurrentMode == "copy") {
				$issue_grid->loadRowValues($issue_grid->Recordset); // Load row values
				$issue_grid->setRecordKey($issue_grid->RowOldKey, $issue_grid->Recordset); // Set old record key
			} else {
				$issue_grid->loadRowValues(); // Load default values
				$issue_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$issue_grid->loadRowValues($issue_grid->Recordset); // Load row values
		}
		$issue->RowType = ROWTYPE_VIEW; // Render view
		if ($issue_grid->isGridAdd()) // Grid add
			$issue->RowType = ROWTYPE_ADD; // Render add
		if ($issue_grid->isGridAdd() && $issue->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$issue_grid->restoreCurrentRowFormValues($issue_grid->RowIndex); // Restore form values
		if ($issue_grid->isGridEdit()) { // Grid edit
			if ($issue->EventCancelled)
				$issue_grid->restoreCurrentRowFormValues($issue_grid->RowIndex); // Restore form values
			if ($issue_grid->RowAction == "insert")
				$issue->RowType = ROWTYPE_ADD; // Render add
			else
				$issue->RowType = ROWTYPE_EDIT; // Render edit
		}
		if ($issue_grid->isGridEdit() && ($issue->RowType == ROWTYPE_EDIT || $issue->RowType == ROWTYPE_ADD) && $issue->EventCancelled) // Update failed
			$issue_grid->restoreCurrentRowFormValues($issue_grid->RowIndex); // Restore form values
		if ($issue->RowType == ROWTYPE_EDIT) // Edit row
			$issue_grid->EditRowCount++;
		if ($issue->isConfirm()) // Confirm row
			$issue_grid->restoreCurrentRowFormValues($issue_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$issue->RowAttrs->merge(["data-rowindex" => $issue_grid->RowCount, "id" => "r" . $issue_grid->RowCount . "_issue", "data-rowtype" => $issue->RowType]);

		// Render row
		$issue_grid->renderRow();

		// Render list options
		$issue_grid->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($issue_grid->RowAction != "delete" && $issue_grid->RowAction != "insertdelete" && !($issue_grid->RowAction == "insert" && $issue->isConfirm() && $issue_grid->emptyRow())) {
?>
	<tr <?php echo $issue->rowAttributes() ?>>
<?php

// Render list options (body, left)
$issue_grid->ListOptions->render("body", "left", $issue_grid->RowCount);
?>
	<?php if ($issue_grid->fmea->Visible) { // fmea ?>
		<td data-name="fmea" <?php echo $issue_grid->fmea->cellAttributes() ?>>
<?php if ($issue->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($issue_grid->fmea->getSessionValue() != "") { ?>
<span id="el<?php echo $issue_grid->RowCount ?>_issue_fmea" class="form-group">
<span<?php echo $issue_grid->fmea->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($issue_grid->fmea->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $issue_grid->RowIndex ?>_fmea" name="x<?php echo $issue_grid->RowIndex ?>_fmea" value="<?php echo HtmlEncode($issue_grid->fmea->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $issue_grid->RowCount ?>_issue_fmea" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="issue" data-field="x_fmea" data-value-separator="<?php echo $issue_grid->fmea->displayValueSeparatorAttribute() ?>" id="x<?php echo $issue_grid->RowIndex ?>_fmea" name="x<?php echo $issue_grid->RowIndex ?>_fmea"<?php echo $issue_grid->fmea->editAttributes() ?>>
			<?php echo $issue_grid->fmea->selectOptionListHtml("x{$issue_grid->RowIndex}_fmea") ?>
		</select>
</div>
<?php echo $issue_grid->fmea->Lookup->getParamTag($issue_grid, "p_x" . $issue_grid->RowIndex . "_fmea") ?>
</span>
<?php } ?>
<input type="hidden" data-table="issue" data-field="x_fmea" name="o<?php echo $issue_grid->RowIndex ?>_fmea" id="o<?php echo $issue_grid->RowIndex ?>_fmea" value="<?php echo HtmlEncode($issue_grid->fmea->OldValue) ?>">
<?php } ?>
<?php if ($issue->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($issue_grid->fmea->getSessionValue() != "") { ?>

<span id="el<?php echo $issue_grid->RowCount ?>_issue_fmea" class="form-group">
<span<?php echo $issue_grid->fmea->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($issue_grid->fmea->EditValue)) ?>"></span>
</span>

<input type="hidden" id="x<?php echo $issue_grid->RowIndex ?>_fmea" name="x<?php echo $issue_grid->RowIndex ?>_fmea" value="<?php echo HtmlEncode($issue_grid->fmea->CurrentValue) ?>">
<?php } else { ?>

<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="issue" data-field="x_fmea" data-value-separator="<?php echo $issue_grid->fmea->displayValueSeparatorAttribute() ?>" id="x<?php echo $issue_grid->RowIndex ?>_fmea" name="x<?php echo $issue_grid->RowIndex ?>_fmea"<?php echo $issue_grid->fmea->editAttributes() ?>>
			<?php echo $issue_grid->fmea->selectOptionListHtml("x{$issue_grid->RowIndex}_fmea") ?>
		</select>
</div>
<?php echo $issue_grid->fmea->Lookup->getParamTag($issue_grid, "p_x" . $issue_grid->RowIndex . "_fmea") ?>

<?php } ?>

<input type="hidden" data-table="issue" data-field="x_fmea" name="o<?php echo $issue_grid->RowIndex ?>_fmea" id="o<?php echo $issue_grid->RowIndex ?>_fmea" value="<?php echo HtmlEncode($issue_grid->fmea->OldValue != null ? $issue_grid->fmea->OldValue : $issue_grid->fmea->CurrentValue) ?>">
<?php } ?>
<?php if ($issue->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $issue_grid->RowCount ?>_issue_fmea">
<span<?php echo $issue_grid->fmea->viewAttributes() ?>><?php echo $issue_grid->fmea->getViewValue() ?></span>
</span>
<?php if (!$issue->isConfirm()) { ?>
<input type="hidden" data-table="issue" data-field="x_fmea" name="x<?php echo $issue_grid->RowIndex ?>_fmea" id="x<?php echo $issue_grid->RowIndex ?>_fmea" value="<?php echo HtmlEncode($issue_grid->fmea->FormValue) ?>">
<input type="hidden" data-table="issue" data-field="x_fmea" name="o<?php echo $issue_grid->RowIndex ?>_fmea" id="o<?php echo $issue_grid->RowIndex ?>_fmea" value="<?php echo HtmlEncode($issue_grid->fmea->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="issue" data-field="x_fmea" name="fissuegrid$x<?php echo $issue_grid->RowIndex ?>_fmea" id="fissuegrid$x<?php echo $issue_grid->RowIndex ?>_fmea" value="<?php echo HtmlEncode($issue_grid->fmea->FormValue) ?>">
<input type="hidden" data-table="issue" data-field="x_fmea" name="fissuegrid$o<?php echo $issue_grid->RowIndex ?>_fmea" id="fissuegrid$o<?php echo $issue_grid->RowIndex ?>_fmea" value="<?php echo HtmlEncode($issue_grid->fmea->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($issue_grid->issue->Visible) { // issue ?>
		<td data-name="issue" <?php echo $issue_grid->issue->cellAttributes() ?>>
<?php if ($issue->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $issue_grid->RowCount ?>_issue_issue" class="form-group"></span>
<input type="hidden" data-table="issue" data-field="x_issue" name="o<?php echo $issue_grid->RowIndex ?>_issue" id="o<?php echo $issue_grid->RowIndex ?>_issue" value="<?php echo HtmlEncode($issue_grid->issue->OldValue) ?>">
<?php } ?>
<?php if ($issue->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $issue_grid->RowCount ?>_issue_issue" class="form-group">
<span<?php echo $issue_grid->issue->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($issue_grid->issue->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="issue" data-field="x_issue" name="x<?php echo $issue_grid->RowIndex ?>_issue" id="x<?php echo $issue_grid->RowIndex ?>_issue" value="<?php echo HtmlEncode($issue_grid->issue->CurrentValue) ?>">
<?php } ?>
<?php if ($issue->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $issue_grid->RowCount ?>_issue_issue">
<span<?php echo $issue_grid->issue->viewAttributes() ?>><?php echo $issue_grid->issue->getViewValue() ?></span>
</span>
<?php if (!$issue->isConfirm()) { ?>
<input type="hidden" data-table="issue" data-field="x_issue" name="x<?php echo $issue_grid->RowIndex ?>_issue" id="x<?php echo $issue_grid->RowIndex ?>_issue" value="<?php echo HtmlEncode($issue_grid->issue->FormValue) ?>">
<input type="hidden" data-table="issue" data-field="x_issue" name="o<?php echo $issue_grid->RowIndex ?>_issue" id="o<?php echo $issue_grid->RowIndex ?>_issue" value="<?php echo HtmlEncode($issue_grid->issue->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="issue" data-field="x_issue" name="fissuegrid$x<?php echo $issue_grid->RowIndex ?>_issue" id="fissuegrid$x<?php echo $issue_grid->RowIndex ?>_issue" value="<?php echo HtmlEncode($issue_grid->issue->FormValue) ?>">
<input type="hidden" data-table="issue" data-field="x_issue" name="fissuegrid$o<?php echo $issue_grid->RowIndex ?>_issue" id="fissuegrid$o<?php echo $issue_grid->RowIndex ?>_issue" value="<?php echo HtmlEncode($issue_grid->issue->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($issue_grid->date->Visible) { // date ?>
		<td data-name="date" <?php echo $issue_grid->date->cellAttributes() ?>>
<?php if ($issue->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $issue_grid->RowCount ?>_issue_date" class="form-group">
<input type="text" data-table="issue" data-field="x_date" name="x<?php echo $issue_grid->RowIndex ?>_date" id="x<?php echo $issue_grid->RowIndex ?>_date" maxlength="10" placeholder="<?php echo HtmlEncode($issue_grid->date->getPlaceHolder()) ?>" value="<?php echo $issue_grid->date->EditValue ?>"<?php echo $issue_grid->date->editAttributes() ?>>
<?php if (!$issue_grid->date->ReadOnly && !$issue_grid->date->Disabled && !isset($issue_grid->date->EditAttrs["readonly"]) && !isset($issue_grid->date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fissuegrid", "datetimepicker"], function() {
	ew.createDateTimePicker("fissuegrid", "x<?php echo $issue_grid->RowIndex ?>_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="issue" data-field="x_date" name="o<?php echo $issue_grid->RowIndex ?>_date" id="o<?php echo $issue_grid->RowIndex ?>_date" value="<?php echo HtmlEncode($issue_grid->date->OldValue) ?>">
<?php } ?>
<?php if ($issue->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $issue_grid->RowCount ?>_issue_date" class="form-group">
<input type="text" data-table="issue" data-field="x_date" name="x<?php echo $issue_grid->RowIndex ?>_date" id="x<?php echo $issue_grid->RowIndex ?>_date" maxlength="10" placeholder="<?php echo HtmlEncode($issue_grid->date->getPlaceHolder()) ?>" value="<?php echo $issue_grid->date->EditValue ?>"<?php echo $issue_grid->date->editAttributes() ?>>
<?php if (!$issue_grid->date->ReadOnly && !$issue_grid->date->Disabled && !isset($issue_grid->date->EditAttrs["readonly"]) && !isset($issue_grid->date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fissuegrid", "datetimepicker"], function() {
	ew.createDateTimePicker("fissuegrid", "x<?php echo $issue_grid->RowIndex ?>_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($issue->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $issue_grid->RowCount ?>_issue_date">
<span<?php echo $issue_grid->date->viewAttributes() ?>><?php echo $issue_grid->date->getViewValue() ?></span>
</span>
<?php if (!$issue->isConfirm()) { ?>
<input type="hidden" data-table="issue" data-field="x_date" name="x<?php echo $issue_grid->RowIndex ?>_date" id="x<?php echo $issue_grid->RowIndex ?>_date" value="<?php echo HtmlEncode($issue_grid->date->FormValue) ?>">
<input type="hidden" data-table="issue" data-field="x_date" name="o<?php echo $issue_grid->RowIndex ?>_date" id="o<?php echo $issue_grid->RowIndex ?>_date" value="<?php echo HtmlEncode($issue_grid->date->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="issue" data-field="x_date" name="fissuegrid$x<?php echo $issue_grid->RowIndex ?>_date" id="fissuegrid$x<?php echo $issue_grid->RowIndex ?>_date" value="<?php echo HtmlEncode($issue_grid->date->FormValue) ?>">
<input type="hidden" data-table="issue" data-field="x_date" name="fissuegrid$o<?php echo $issue_grid->RowIndex ?>_date" id="fissuegrid$o<?php echo $issue_grid->RowIndex ?>_date" value="<?php echo HtmlEncode($issue_grid->date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($issue_grid->cause->Visible) { // cause ?>
		<td data-name="cause" <?php echo $issue_grid->cause->cellAttributes() ?>>
<?php if ($issue->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $issue_grid->RowCount ?>_issue_cause" class="form-group">
<textarea data-table="issue" data-field="x_cause" name="x<?php echo $issue_grid->RowIndex ?>_cause" id="x<?php echo $issue_grid->RowIndex ?>_cause" cols="35" rows="4" placeholder="<?php echo HtmlEncode($issue_grid->cause->getPlaceHolder()) ?>"<?php echo $issue_grid->cause->editAttributes() ?>><?php echo $issue_grid->cause->EditValue ?></textarea>
</span>
<input type="hidden" data-table="issue" data-field="x_cause" name="o<?php echo $issue_grid->RowIndex ?>_cause" id="o<?php echo $issue_grid->RowIndex ?>_cause" value="<?php echo HtmlEncode($issue_grid->cause->OldValue) ?>">
<?php } ?>
<?php if ($issue->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $issue_grid->RowCount ?>_issue_cause" class="form-group">
<textarea data-table="issue" data-field="x_cause" name="x<?php echo $issue_grid->RowIndex ?>_cause" id="x<?php echo $issue_grid->RowIndex ?>_cause" cols="35" rows="4" placeholder="<?php echo HtmlEncode($issue_grid->cause->getPlaceHolder()) ?>"<?php echo $issue_grid->cause->editAttributes() ?>><?php echo $issue_grid->cause->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($issue->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $issue_grid->RowCount ?>_issue_cause">
<span<?php echo $issue_grid->cause->viewAttributes() ?>><?php echo $issue_grid->cause->getViewValue() ?></span>
</span>
<?php if (!$issue->isConfirm()) { ?>
<input type="hidden" data-table="issue" data-field="x_cause" name="x<?php echo $issue_grid->RowIndex ?>_cause" id="x<?php echo $issue_grid->RowIndex ?>_cause" value="<?php echo HtmlEncode($issue_grid->cause->FormValue) ?>">
<input type="hidden" data-table="issue" data-field="x_cause" name="o<?php echo $issue_grid->RowIndex ?>_cause" id="o<?php echo $issue_grid->RowIndex ?>_cause" value="<?php echo HtmlEncode($issue_grid->cause->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="issue" data-field="x_cause" name="fissuegrid$x<?php echo $issue_grid->RowIndex ?>_cause" id="fissuegrid$x<?php echo $issue_grid->RowIndex ?>_cause" value="<?php echo HtmlEncode($issue_grid->cause->FormValue) ?>">
<input type="hidden" data-table="issue" data-field="x_cause" name="fissuegrid$o<?php echo $issue_grid->RowIndex ?>_cause" id="fissuegrid$o<?php echo $issue_grid->RowIndex ?>_cause" value="<?php echo HtmlEncode($issue_grid->cause->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($issue_grid->leader->Visible) { // leader ?>
		<td data-name="leader" <?php echo $issue_grid->leader->cellAttributes() ?>>
<?php if ($issue->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $issue_grid->RowCount ?>_issue_leader" class="form-group">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $issue_grid->RowIndex ?>_leader"><?php echo EmptyValue(strval($issue_grid->leader->ViewValue)) ? $Language->phrase("PleaseSelect") : $issue_grid->leader->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($issue_grid->leader->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($issue_grid->leader->ReadOnly || $issue_grid->leader->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $issue_grid->RowIndex ?>_leader[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $issue_grid->leader->Lookup->getParamTag($issue_grid, "p_x" . $issue_grid->RowIndex . "_leader") ?>
<input type="hidden" data-table="issue" data-field="x_leader" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $issue_grid->leader->displayValueSeparatorAttribute() ?>" name="x<?php echo $issue_grid->RowIndex ?>_leader[]" id="x<?php echo $issue_grid->RowIndex ?>_leader[]" value="<?php echo $issue_grid->leader->CurrentValue ?>"<?php echo $issue_grid->leader->editAttributes() ?>>
</span>
<input type="hidden" data-table="issue" data-field="x_leader" name="o<?php echo $issue_grid->RowIndex ?>_leader[]" id="o<?php echo $issue_grid->RowIndex ?>_leader[]" value="<?php echo HtmlEncode($issue_grid->leader->OldValue) ?>">
<?php } ?>
<?php if ($issue->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $issue_grid->RowCount ?>_issue_leader" class="form-group">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $issue_grid->RowIndex ?>_leader"><?php echo EmptyValue(strval($issue_grid->leader->ViewValue)) ? $Language->phrase("PleaseSelect") : $issue_grid->leader->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($issue_grid->leader->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($issue_grid->leader->ReadOnly || $issue_grid->leader->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $issue_grid->RowIndex ?>_leader[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $issue_grid->leader->Lookup->getParamTag($issue_grid, "p_x" . $issue_grid->RowIndex . "_leader") ?>
<input type="hidden" data-table="issue" data-field="x_leader" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $issue_grid->leader->displayValueSeparatorAttribute() ?>" name="x<?php echo $issue_grid->RowIndex ?>_leader[]" id="x<?php echo $issue_grid->RowIndex ?>_leader[]" value="<?php echo $issue_grid->leader->CurrentValue ?>"<?php echo $issue_grid->leader->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($issue->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $issue_grid->RowCount ?>_issue_leader">
<span<?php echo $issue_grid->leader->viewAttributes() ?>><?php echo $issue_grid->leader->getViewValue() ?></span>
</span>
<?php if (!$issue->isConfirm()) { ?>
<input type="hidden" data-table="issue" data-field="x_leader" name="x<?php echo $issue_grid->RowIndex ?>_leader" id="x<?php echo $issue_grid->RowIndex ?>_leader" value="<?php echo HtmlEncode($issue_grid->leader->FormValue) ?>">
<input type="hidden" data-table="issue" data-field="x_leader" name="o<?php echo $issue_grid->RowIndex ?>_leader[]" id="o<?php echo $issue_grid->RowIndex ?>_leader[]" value="<?php echo HtmlEncode($issue_grid->leader->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="issue" data-field="x_leader" name="fissuegrid$x<?php echo $issue_grid->RowIndex ?>_leader" id="fissuegrid$x<?php echo $issue_grid->RowIndex ?>_leader" value="<?php echo HtmlEncode($issue_grid->leader->FormValue) ?>">
<input type="hidden" data-table="issue" data-field="x_leader" name="fissuegrid$o<?php echo $issue_grid->RowIndex ?>_leader[]" id="fissuegrid$o<?php echo $issue_grid->RowIndex ?>_leader[]" value="<?php echo HtmlEncode($issue_grid->leader->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($issue_grid->employee->Visible) { // employee ?>
		<td data-name="employee" <?php echo $issue_grid->employee->cellAttributes() ?>>
<?php if ($issue->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $issue_grid->RowCount ?>_issue_employee" class="form-group">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $issue_grid->RowIndex ?>_employee"><?php echo EmptyValue(strval($issue_grid->employee->ViewValue)) ? $Language->phrase("PleaseSelect") : $issue_grid->employee->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($issue_grid->employee->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($issue_grid->employee->ReadOnly || $issue_grid->employee->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $issue_grid->RowIndex ?>_employee[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $issue_grid->employee->Lookup->getParamTag($issue_grid, "p_x" . $issue_grid->RowIndex . "_employee") ?>
<input type="hidden" data-table="issue" data-field="x_employee" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $issue_grid->employee->displayValueSeparatorAttribute() ?>" name="x<?php echo $issue_grid->RowIndex ?>_employee[]" id="x<?php echo $issue_grid->RowIndex ?>_employee[]" value="<?php echo $issue_grid->employee->CurrentValue ?>"<?php echo $issue_grid->employee->editAttributes() ?>>
</span>
<input type="hidden" data-table="issue" data-field="x_employee" name="o<?php echo $issue_grid->RowIndex ?>_employee[]" id="o<?php echo $issue_grid->RowIndex ?>_employee[]" value="<?php echo HtmlEncode($issue_grid->employee->OldValue) ?>">
<?php } ?>
<?php if ($issue->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $issue_grid->RowCount ?>_issue_employee" class="form-group">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $issue_grid->RowIndex ?>_employee"><?php echo EmptyValue(strval($issue_grid->employee->ViewValue)) ? $Language->phrase("PleaseSelect") : $issue_grid->employee->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($issue_grid->employee->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($issue_grid->employee->ReadOnly || $issue_grid->employee->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $issue_grid->RowIndex ?>_employee[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $issue_grid->employee->Lookup->getParamTag($issue_grid, "p_x" . $issue_grid->RowIndex . "_employee") ?>
<input type="hidden" data-table="issue" data-field="x_employee" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $issue_grid->employee->displayValueSeparatorAttribute() ?>" name="x<?php echo $issue_grid->RowIndex ?>_employee[]" id="x<?php echo $issue_grid->RowIndex ?>_employee[]" value="<?php echo $issue_grid->employee->CurrentValue ?>"<?php echo $issue_grid->employee->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($issue->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $issue_grid->RowCount ?>_issue_employee">
<span<?php echo $issue_grid->employee->viewAttributes() ?>><?php echo $issue_grid->employee->getViewValue() ?></span>
</span>
<?php if (!$issue->isConfirm()) { ?>
<input type="hidden" data-table="issue" data-field="x_employee" name="x<?php echo $issue_grid->RowIndex ?>_employee" id="x<?php echo $issue_grid->RowIndex ?>_employee" value="<?php echo HtmlEncode($issue_grid->employee->FormValue) ?>">
<input type="hidden" data-table="issue" data-field="x_employee" name="o<?php echo $issue_grid->RowIndex ?>_employee[]" id="o<?php echo $issue_grid->RowIndex ?>_employee[]" value="<?php echo HtmlEncode($issue_grid->employee->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="issue" data-field="x_employee" name="fissuegrid$x<?php echo $issue_grid->RowIndex ?>_employee" id="fissuegrid$x<?php echo $issue_grid->RowIndex ?>_employee" value="<?php echo HtmlEncode($issue_grid->employee->FormValue) ?>">
<input type="hidden" data-table="issue" data-field="x_employee" name="fissuegrid$o<?php echo $issue_grid->RowIndex ?>_employee[]" id="fissuegrid$o<?php echo $issue_grid->RowIndex ?>_employee[]" value="<?php echo HtmlEncode($issue_grid->employee->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$issue_grid->ListOptions->render("body", "right", $issue_grid->RowCount);
?>
	</tr>
<?php if ($issue->RowType == ROWTYPE_ADD || $issue->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fissuegrid", "load"], function() {
	fissuegrid.updateLists(<?php echo $issue_grid->RowIndex ?>);
});
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$issue_grid->isGridAdd() || $issue->CurrentMode == "copy")
		if (!$issue_grid->Recordset->EOF)
			$issue_grid->Recordset->moveNext();
}
?>
<?php
	if ($issue->CurrentMode == "add" || $issue->CurrentMode == "copy" || $issue->CurrentMode == "edit") {
		$issue_grid->RowIndex = '$rowindex$';
		$issue_grid->loadRowValues();

		// Set row properties
		$issue->resetAttributes();
		$issue->RowAttrs->merge(["data-rowindex" => $issue_grid->RowIndex, "id" => "r0_issue", "data-rowtype" => ROWTYPE_ADD]);
		$issue->RowAttrs->appendClass("ew-template");
		$issue->RowType = ROWTYPE_ADD;

		// Render row
		$issue_grid->renderRow();

		// Render list options
		$issue_grid->renderListOptions();
		$issue_grid->StartRowCount = 0;
?>
	<tr <?php echo $issue->rowAttributes() ?>>
<?php

// Render list options (body, left)
$issue_grid->ListOptions->render("body", "left", $issue_grid->RowIndex);
?>
	<?php if ($issue_grid->fmea->Visible) { // fmea ?>
		<td data-name="fmea">
<?php if (!$issue->isConfirm()) { ?>
<?php if ($issue_grid->fmea->getSessionValue() != "") { ?>
<span id="el$rowindex$_issue_fmea" class="form-group issue_fmea">
<span<?php echo $issue_grid->fmea->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($issue_grid->fmea->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $issue_grid->RowIndex ?>_fmea" name="x<?php echo $issue_grid->RowIndex ?>_fmea" value="<?php echo HtmlEncode($issue_grid->fmea->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_issue_fmea" class="form-group issue_fmea">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="issue" data-field="x_fmea" data-value-separator="<?php echo $issue_grid->fmea->displayValueSeparatorAttribute() ?>" id="x<?php echo $issue_grid->RowIndex ?>_fmea" name="x<?php echo $issue_grid->RowIndex ?>_fmea"<?php echo $issue_grid->fmea->editAttributes() ?>>
			<?php echo $issue_grid->fmea->selectOptionListHtml("x{$issue_grid->RowIndex}_fmea") ?>
		</select>
</div>
<?php echo $issue_grid->fmea->Lookup->getParamTag($issue_grid, "p_x" . $issue_grid->RowIndex . "_fmea") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_issue_fmea" class="form-group issue_fmea">
<span<?php echo $issue_grid->fmea->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($issue_grid->fmea->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="issue" data-field="x_fmea" name="x<?php echo $issue_grid->RowIndex ?>_fmea" id="x<?php echo $issue_grid->RowIndex ?>_fmea" value="<?php echo HtmlEncode($issue_grid->fmea->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="issue" data-field="x_fmea" name="o<?php echo $issue_grid->RowIndex ?>_fmea" id="o<?php echo $issue_grid->RowIndex ?>_fmea" value="<?php echo HtmlEncode($issue_grid->fmea->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($issue_grid->issue->Visible) { // issue ?>
		<td data-name="issue">
<?php if (!$issue->isConfirm()) { ?>
<span id="el$rowindex$_issue_issue" class="form-group issue_issue"></span>
<?php } else { ?>
<span id="el$rowindex$_issue_issue" class="form-group issue_issue">
<span<?php echo $issue_grid->issue->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($issue_grid->issue->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="issue" data-field="x_issue" name="x<?php echo $issue_grid->RowIndex ?>_issue" id="x<?php echo $issue_grid->RowIndex ?>_issue" value="<?php echo HtmlEncode($issue_grid->issue->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="issue" data-field="x_issue" name="o<?php echo $issue_grid->RowIndex ?>_issue" id="o<?php echo $issue_grid->RowIndex ?>_issue" value="<?php echo HtmlEncode($issue_grid->issue->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($issue_grid->date->Visible) { // date ?>
		<td data-name="date">
<?php if (!$issue->isConfirm()) { ?>
<span id="el$rowindex$_issue_date" class="form-group issue_date">
<input type="text" data-table="issue" data-field="x_date" name="x<?php echo $issue_grid->RowIndex ?>_date" id="x<?php echo $issue_grid->RowIndex ?>_date" maxlength="10" placeholder="<?php echo HtmlEncode($issue_grid->date->getPlaceHolder()) ?>" value="<?php echo $issue_grid->date->EditValue ?>"<?php echo $issue_grid->date->editAttributes() ?>>
<?php if (!$issue_grid->date->ReadOnly && !$issue_grid->date->Disabled && !isset($issue_grid->date->EditAttrs["readonly"]) && !isset($issue_grid->date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fissuegrid", "datetimepicker"], function() {
	ew.createDateTimePicker("fissuegrid", "x<?php echo $issue_grid->RowIndex ?>_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_issue_date" class="form-group issue_date">
<span<?php echo $issue_grid->date->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($issue_grid->date->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="issue" data-field="x_date" name="x<?php echo $issue_grid->RowIndex ?>_date" id="x<?php echo $issue_grid->RowIndex ?>_date" value="<?php echo HtmlEncode($issue_grid->date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="issue" data-field="x_date" name="o<?php echo $issue_grid->RowIndex ?>_date" id="o<?php echo $issue_grid->RowIndex ?>_date" value="<?php echo HtmlEncode($issue_grid->date->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($issue_grid->cause->Visible) { // cause ?>
		<td data-name="cause">
<?php if (!$issue->isConfirm()) { ?>
<span id="el$rowindex$_issue_cause" class="form-group issue_cause">
<textarea data-table="issue" data-field="x_cause" name="x<?php echo $issue_grid->RowIndex ?>_cause" id="x<?php echo $issue_grid->RowIndex ?>_cause" cols="35" rows="4" placeholder="<?php echo HtmlEncode($issue_grid->cause->getPlaceHolder()) ?>"<?php echo $issue_grid->cause->editAttributes() ?>><?php echo $issue_grid->cause->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_issue_cause" class="form-group issue_cause">
<span<?php echo $issue_grid->cause->viewAttributes() ?>><?php echo $issue_grid->cause->ViewValue ?></span>
</span>
<input type="hidden" data-table="issue" data-field="x_cause" name="x<?php echo $issue_grid->RowIndex ?>_cause" id="x<?php echo $issue_grid->RowIndex ?>_cause" value="<?php echo HtmlEncode($issue_grid->cause->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="issue" data-field="x_cause" name="o<?php echo $issue_grid->RowIndex ?>_cause" id="o<?php echo $issue_grid->RowIndex ?>_cause" value="<?php echo HtmlEncode($issue_grid->cause->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($issue_grid->leader->Visible) { // leader ?>
		<td data-name="leader">
<?php if (!$issue->isConfirm()) { ?>
<span id="el$rowindex$_issue_leader" class="form-group issue_leader">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $issue_grid->RowIndex ?>_leader"><?php echo EmptyValue(strval($issue_grid->leader->ViewValue)) ? $Language->phrase("PleaseSelect") : $issue_grid->leader->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($issue_grid->leader->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($issue_grid->leader->ReadOnly || $issue_grid->leader->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $issue_grid->RowIndex ?>_leader[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $issue_grid->leader->Lookup->getParamTag($issue_grid, "p_x" . $issue_grid->RowIndex . "_leader") ?>
<input type="hidden" data-table="issue" data-field="x_leader" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $issue_grid->leader->displayValueSeparatorAttribute() ?>" name="x<?php echo $issue_grid->RowIndex ?>_leader[]" id="x<?php echo $issue_grid->RowIndex ?>_leader[]" value="<?php echo $issue_grid->leader->CurrentValue ?>"<?php echo $issue_grid->leader->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_issue_leader" class="form-group issue_leader">
<span<?php echo $issue_grid->leader->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($issue_grid->leader->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="issue" data-field="x_leader" name="x<?php echo $issue_grid->RowIndex ?>_leader" id="x<?php echo $issue_grid->RowIndex ?>_leader" value="<?php echo HtmlEncode($issue_grid->leader->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="issue" data-field="x_leader" name="o<?php echo $issue_grid->RowIndex ?>_leader[]" id="o<?php echo $issue_grid->RowIndex ?>_leader[]" value="<?php echo HtmlEncode($issue_grid->leader->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($issue_grid->employee->Visible) { // employee ?>
		<td data-name="employee">
<?php if (!$issue->isConfirm()) { ?>
<span id="el$rowindex$_issue_employee" class="form-group issue_employee">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $issue_grid->RowIndex ?>_employee"><?php echo EmptyValue(strval($issue_grid->employee->ViewValue)) ? $Language->phrase("PleaseSelect") : $issue_grid->employee->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($issue_grid->employee->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($issue_grid->employee->ReadOnly || $issue_grid->employee->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $issue_grid->RowIndex ?>_employee[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $issue_grid->employee->Lookup->getParamTag($issue_grid, "p_x" . $issue_grid->RowIndex . "_employee") ?>
<input type="hidden" data-table="issue" data-field="x_employee" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $issue_grid->employee->displayValueSeparatorAttribute() ?>" name="x<?php echo $issue_grid->RowIndex ?>_employee[]" id="x<?php echo $issue_grid->RowIndex ?>_employee[]" value="<?php echo $issue_grid->employee->CurrentValue ?>"<?php echo $issue_grid->employee->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_issue_employee" class="form-group issue_employee">
<span<?php echo $issue_grid->employee->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($issue_grid->employee->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="issue" data-field="x_employee" name="x<?php echo $issue_grid->RowIndex ?>_employee" id="x<?php echo $issue_grid->RowIndex ?>_employee" value="<?php echo HtmlEncode($issue_grid->employee->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="issue" data-field="x_employee" name="o<?php echo $issue_grid->RowIndex ?>_employee[]" id="o<?php echo $issue_grid->RowIndex ?>_employee[]" value="<?php echo HtmlEncode($issue_grid->employee->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$issue_grid->ListOptions->render("body", "right", $issue_grid->RowIndex);
?>
<script>
loadjs.ready(["fissuegrid", "load"], function() {
	fissuegrid.updateLists(<?php echo $issue_grid->RowIndex ?>);
});
</script>
	</tr>
<?php
	}
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($issue->CurrentMode == "add" || $issue->CurrentMode == "copy") { ?>
<input type="hidden" name="<?php echo $issue_grid->FormKeyCountName ?>" id="<?php echo $issue_grid->FormKeyCountName ?>" value="<?php echo $issue_grid->KeyCount ?>">
<?php echo $issue_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($issue->CurrentMode == "edit") { ?>
<input type="hidden" name="<?php echo $issue_grid->FormKeyCountName ?>" id="<?php echo $issue_grid->FormKeyCountName ?>" value="<?php echo $issue_grid->KeyCount ?>">
<?php echo $issue_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($issue->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fissuegrid">
</div><!-- /.ew-list-form -->
<?php

// Close recordset
if ($issue_grid->Recordset)
	$issue_grid->Recordset->Close();
?>
<?php if ($issue_grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $issue_grid->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($issue_grid->TotalRecords == 0 && !$issue->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $issue_grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if (!$issue_grid->isExport()) { ?>
<script>
loadjs.ready("load", function() {

	// Startup script
	// Write your table-specific startup script here
	// console.log("page loaded");

});
</script>
<?php } ?>
<?php
$issue_grid->terminate();
?>