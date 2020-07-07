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
$causes_list = new causes_list();

// Run the page
$causes_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$causes_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$causes_list->isExport()) { ?>
<script>
var fcauseslist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	fcauseslist = currentForm = new ew.Form("fcauseslist", "list");
	fcauseslist.formKeyCountName = '<?php echo $causes_list->FormKeyCountName ?>';

	// Validate form
	fcauseslist.validate = function() {
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
			<?php if ($causes_list->idCause->Required) { ?>
				elm = this.getElements("x" + infix + "_idCause");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $causes_list->idCause->caption(), $causes_list->idCause->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_idCause");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($causes_list->idCause->errorMessage()) ?>");
			<?php if ($causes_list->cause->Required) { ?>
				elm = this.getElements("x" + infix + "_cause");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $causes_list->cause->caption(), $causes_list->cause->RequiredErrorMessage)) ?>");
			<?php } ?>

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
			} // End Grid Add checking
		}
		if (gridinsert && addcnt == 0) { // No row added
			ew.alert(ew.language.phrase("NoAddRecord"));
			return false;
		}
		return true;
	}

	// Check empty row
	fcauseslist.emptyRow = function(infix) {
		var fobj = this._form;
		if (ew.valueChanged(fobj, infix, "idCause", false)) return false;
		if (ew.valueChanged(fobj, infix, "cause", false)) return false;
		return true;
	}

	// Form_CustomValidate
	fcauseslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fcauseslist.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fcauseslist");
});
var fcauseslistsrch;
loadjs.ready("head", function() {

	// Form object for search
	fcauseslistsrch = currentSearchForm = new ew.Form("fcauseslistsrch");

	// Dynamic selection lists
	// Filters

	fcauseslistsrch.filterList = <?php echo $causes_list->getFilterList() ?>;
	loadjs.done("fcauseslistsrch");
});
</script>
<style type="text/css">
.ew-table-preview-row { /* main table preview row color */
	background-color: #FFFFFF; /* preview row color */
}
.ew-table-preview-row .ew-grid {
	display: table;
}
</style>
<div id="ew-preview" class="d-none"><!-- preview -->
	<div class="ew-nav-tabs"><!-- .ew-nav-tabs -->
		<ul class="nav nav-tabs"></ul>
		<div class="tab-content"><!-- .tab-content -->
			<div class="tab-pane fade active show"></div>
		</div><!-- /.tab-content -->
	</div><!-- /.ew-nav-tabs -->
</div><!-- /preview -->
<script>
loadjs.ready("head", function() {
	ew.PREVIEW_PLACEMENT = ew.CSS_FLIP ? "left" : "right";
	ew.PREVIEW_SINGLE_ROW = false;
	ew.PREVIEW_OVERLAY = false;
	loadjs("js/ewpreview.js", "preview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$causes_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($causes_list->TotalRecords > 0 && $causes_list->ExportOptions->visible()) { ?>
<?php $causes_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($causes_list->ImportOptions->visible()) { ?>
<?php $causes_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($causes_list->SearchOptions->visible()) { ?>
<?php $causes_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($causes_list->FilterOptions->visible()) { ?>
<?php $causes_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$causes_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$causes_list->isExport() && !$causes->CurrentAction) { ?>
<form name="fcauseslistsrch" id="fcauseslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="fcauseslistsrch-search-panel" class="<?php echo $causes_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="causes">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $causes_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($causes_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($causes_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $causes_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($causes_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($causes_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($causes_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($causes_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $causes_list->showPageHeader(); ?>
<?php
$causes_list->showMessage();
?>
<?php if ($causes_list->TotalRecords > 0 || $causes->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($causes_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> causes">
<?php if (!$causes_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$causes_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $causes_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $causes_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fcauseslist" id="fcauseslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="causes">
<div id="gmp_causes" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($causes_list->TotalRecords > 0 || $causes_list->isGridEdit()) { ?>
<table id="tbl_causeslist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$causes->RowType = ROWTYPE_HEADER;

// Render list options
$causes_list->renderListOptions();

// Render list options (header, left)
$causes_list->ListOptions->render("header", "left");
?>
<?php if ($causes_list->idCause->Visible) { // idCause ?>
	<?php if ($causes_list->SortUrl($causes_list->idCause) == "") { ?>
		<th data-name="idCause" class="<?php echo $causes_list->idCause->headerCellClass() ?>"><div id="elh_causes_idCause" class="causes_idCause"><div class="ew-table-header-caption"><?php echo $causes_list->idCause->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idCause" class="<?php echo $causes_list->idCause->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $causes_list->SortUrl($causes_list->idCause) ?>', 2);"><div id="elh_causes_idCause" class="causes_idCause">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $causes_list->idCause->caption() ?></span><span class="ew-table-header-sort"><?php if ($causes_list->idCause->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($causes_list->idCause->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($causes_list->cause->Visible) { // cause ?>
	<?php if ($causes_list->SortUrl($causes_list->cause) == "") { ?>
		<th data-name="cause" class="<?php echo $causes_list->cause->headerCellClass() ?>"><div id="elh_causes_cause" class="causes_cause"><div class="ew-table-header-caption"><?php echo $causes_list->cause->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cause" class="<?php echo $causes_list->cause->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $causes_list->SortUrl($causes_list->cause) ?>', 2);"><div id="elh_causes_cause" class="causes_cause">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $causes_list->cause->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($causes_list->cause->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($causes_list->cause->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$causes_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($causes_list->ExportAll && $causes_list->isExport()) {
	$causes_list->StopRecord = $causes_list->TotalRecords;
} else {

	// Set the last record to display
	if ($causes_list->TotalRecords > $causes_list->StartRecord + $causes_list->DisplayRecords - 1)
		$causes_list->StopRecord = $causes_list->StartRecord + $causes_list->DisplayRecords - 1;
	else
		$causes_list->StopRecord = $causes_list->TotalRecords;
}

// Restore number of post back records
if ($CurrentForm && ($causes->isConfirm() || $causes_list->EventCancelled)) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($causes_list->FormKeyCountName) && ($causes_list->isGridAdd() || $causes_list->isGridEdit() || $causes->isConfirm())) {
		$causes_list->KeyCount = $CurrentForm->getValue($causes_list->FormKeyCountName);
		$causes_list->StopRecord = $causes_list->StartRecord + $causes_list->KeyCount - 1;
	}
}
$causes_list->RecordCount = $causes_list->StartRecord - 1;
if ($causes_list->Recordset && !$causes_list->Recordset->EOF) {
	$causes_list->Recordset->moveFirst();
	$selectLimit = $causes_list->UseSelectLimit;
	if (!$selectLimit && $causes_list->StartRecord > 1)
		$causes_list->Recordset->move($causes_list->StartRecord - 1);
} elseif (!$causes->AllowAddDeleteRow && $causes_list->StopRecord == 0) {
	$causes_list->StopRecord = $causes->GridAddRowCount;
}

// Initialize aggregate
$causes->RowType = ROWTYPE_AGGREGATEINIT;
$causes->resetAttributes();
$causes_list->renderRow();
$causes_list->EditRowCount = 0;
if ($causes_list->isEdit())
	$causes_list->RowIndex = 1;
if ($causes_list->isGridAdd())
	$causes_list->RowIndex = 0;
if ($causes_list->isGridEdit())
	$causes_list->RowIndex = 0;
while ($causes_list->RecordCount < $causes_list->StopRecord) {
	$causes_list->RecordCount++;
	if ($causes_list->RecordCount >= $causes_list->StartRecord) {
		$causes_list->RowCount++;
		if ($causes_list->isGridAdd() || $causes_list->isGridEdit() || $causes->isConfirm()) {
			$causes_list->RowIndex++;
			$CurrentForm->Index = $causes_list->RowIndex;
			if ($CurrentForm->hasValue($causes_list->FormActionName) && ($causes->isConfirm() || $causes_list->EventCancelled))
				$causes_list->RowAction = strval($CurrentForm->getValue($causes_list->FormActionName));
			elseif ($causes_list->isGridAdd())
				$causes_list->RowAction = "insert";
			else
				$causes_list->RowAction = "";
		}

		// Set up key count
		$causes_list->KeyCount = $causes_list->RowIndex;

		// Init row class and style
		$causes->resetAttributes();
		$causes->CssClass = "";
		if ($causes_list->isGridAdd()) {
			$causes_list->loadRowValues(); // Load default values
		} else {
			$causes_list->loadRowValues($causes_list->Recordset); // Load row values
		}
		$causes->RowType = ROWTYPE_VIEW; // Render view
		if ($causes_list->isGridAdd()) // Grid add
			$causes->RowType = ROWTYPE_ADD; // Render add
		if ($causes_list->isGridAdd() && $causes->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$causes_list->restoreCurrentRowFormValues($causes_list->RowIndex); // Restore form values
		if ($causes_list->isEdit()) {
			if ($causes_list->checkInlineEditKey() && $causes_list->EditRowCount == 0) { // Inline edit
				$causes->RowType = ROWTYPE_EDIT; // Render edit
				if (!$causes->EventCancelled)
					$causes_list->HashValue = $causes_list->getRowHash($causes_list->Recordset); // Get hash value for record
			}
		}
		if ($causes_list->isGridEdit()) { // Grid edit
			if ($causes->EventCancelled)
				$causes_list->restoreCurrentRowFormValues($causes_list->RowIndex); // Restore form values
			if ($causes_list->RowAction == "insert")
				$causes->RowType = ROWTYPE_ADD; // Render add
			else
				$causes->RowType = ROWTYPE_EDIT; // Render edit
			if (!$causes->EventCancelled)
				$causes_list->HashValue = $causes_list->getRowHash($causes_list->Recordset); // Get hash value for record
		}
		if ($causes_list->isEdit() && $causes->RowType == ROWTYPE_EDIT && $causes->EventCancelled) { // Update failed
			$CurrentForm->Index = 1;
			$causes_list->restoreFormValues(); // Restore form values
		}
		if ($causes_list->isGridEdit() && ($causes->RowType == ROWTYPE_EDIT || $causes->RowType == ROWTYPE_ADD) && $causes->EventCancelled) // Update failed
			$causes_list->restoreCurrentRowFormValues($causes_list->RowIndex); // Restore form values
		if ($causes->RowType == ROWTYPE_EDIT) // Edit row
			$causes_list->EditRowCount++;

		// Set up row id / data-rowindex
		$causes->RowAttrs->merge(["data-rowindex" => $causes_list->RowCount, "id" => "r" . $causes_list->RowCount . "_causes", "data-rowtype" => $causes->RowType]);

		// Render row
		$causes_list->renderRow();

		// Render list options
		$causes_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($causes_list->RowAction != "delete" && $causes_list->RowAction != "insertdelete" && !($causes_list->RowAction == "insert" && $causes->isConfirm() && $causes_list->emptyRow())) {
?>
	<tr <?php echo $causes->rowAttributes() ?>>
<?php

// Render list options (body, left)
$causes_list->ListOptions->render("body", "left", $causes_list->RowCount);
?>
	<?php if ($causes_list->idCause->Visible) { // idCause ?>
		<td data-name="idCause" <?php echo $causes_list->idCause->cellAttributes() ?>>
<?php if ($causes->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $causes_list->RowCount ?>_causes_idCause" class="form-group">
<input type="text" data-table="causes" data-field="x_idCause" name="x<?php echo $causes_list->RowIndex ?>_idCause" id="x<?php echo $causes_list->RowIndex ?>_idCause" placeholder="<?php echo HtmlEncode($causes_list->idCause->getPlaceHolder()) ?>" value="<?php echo $causes_list->idCause->EditValue ?>"<?php echo $causes_list->idCause->editAttributes() ?>>
</span>
<input type="hidden" data-table="causes" data-field="x_idCause" name="o<?php echo $causes_list->RowIndex ?>_idCause" id="o<?php echo $causes_list->RowIndex ?>_idCause" value="<?php echo HtmlEncode($causes_list->idCause->OldValue) ?>">
<?php } ?>
<?php if ($causes->RowType == ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-table="causes" data-field="x_idCause" name="x<?php echo $causes_list->RowIndex ?>_idCause" id="x<?php echo $causes_list->RowIndex ?>_idCause" placeholder="<?php echo HtmlEncode($causes_list->idCause->getPlaceHolder()) ?>" value="<?php echo $causes_list->idCause->EditValue ?>"<?php echo $causes_list->idCause->editAttributes() ?>>
<input type="hidden" data-table="causes" data-field="x_idCause" name="o<?php echo $causes_list->RowIndex ?>_idCause" id="o<?php echo $causes_list->RowIndex ?>_idCause" value="<?php echo HtmlEncode($causes_list->idCause->OldValue != null ? $causes_list->idCause->OldValue : $causes_list->idCause->CurrentValue) ?>">
<?php } ?>
<?php if ($causes->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $causes_list->RowCount ?>_causes_idCause">
<span<?php echo $causes_list->idCause->viewAttributes() ?>><?php echo $causes_list->idCause->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($causes_list->cause->Visible) { // cause ?>
		<td data-name="cause" <?php echo $causes_list->cause->cellAttributes() ?>>
<?php if ($causes->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $causes_list->RowCount ?>_causes_cause" class="form-group">
<input type="text" data-table="causes" data-field="x_cause" name="x<?php echo $causes_list->RowIndex ?>_cause" id="x<?php echo $causes_list->RowIndex ?>_cause" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($causes_list->cause->getPlaceHolder()) ?>" value="<?php echo $causes_list->cause->EditValue ?>"<?php echo $causes_list->cause->editAttributes() ?>>
</span>
<input type="hidden" data-table="causes" data-field="x_cause" name="o<?php echo $causes_list->RowIndex ?>_cause" id="o<?php echo $causes_list->RowIndex ?>_cause" value="<?php echo HtmlEncode($causes_list->cause->OldValue) ?>">
<?php } ?>
<?php if ($causes->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $causes_list->RowCount ?>_causes_cause" class="form-group">
<input type="text" data-table="causes" data-field="x_cause" name="x<?php echo $causes_list->RowIndex ?>_cause" id="x<?php echo $causes_list->RowIndex ?>_cause" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($causes_list->cause->getPlaceHolder()) ?>" value="<?php echo $causes_list->cause->EditValue ?>"<?php echo $causes_list->cause->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($causes->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $causes_list->RowCount ?>_causes_cause">
<span<?php echo $causes_list->cause->viewAttributes() ?>><?php echo $causes_list->cause->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$causes_list->ListOptions->render("body", "right", $causes_list->RowCount);
?>
	</tr>
<?php if ($causes->RowType == ROWTYPE_ADD || $causes->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fcauseslist", "load"], function() {
	fcauseslist.updateLists(<?php echo $causes_list->RowIndex ?>);
});
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$causes_list->isGridAdd())
		if (!$causes_list->Recordset->EOF)
			$causes_list->Recordset->moveNext();
}
?>
<?php
	if ($causes_list->isGridAdd() || $causes_list->isGridEdit()) {
		$causes_list->RowIndex = '$rowindex$';
		$causes_list->loadRowValues();

		// Set row properties
		$causes->resetAttributes();
		$causes->RowAttrs->merge(["data-rowindex" => $causes_list->RowIndex, "id" => "r0_causes", "data-rowtype" => ROWTYPE_ADD]);
		$causes->RowAttrs->appendClass("ew-template");
		$causes->RowType = ROWTYPE_ADD;

		// Render row
		$causes_list->renderRow();

		// Render list options
		$causes_list->renderListOptions();
		$causes_list->StartRowCount = 0;
?>
	<tr <?php echo $causes->rowAttributes() ?>>
<?php

// Render list options (body, left)
$causes_list->ListOptions->render("body", "left", $causes_list->RowIndex);
?>
	<?php if ($causes_list->idCause->Visible) { // idCause ?>
		<td data-name="idCause">
<span id="el$rowindex$_causes_idCause" class="form-group causes_idCause">
<input type="text" data-table="causes" data-field="x_idCause" name="x<?php echo $causes_list->RowIndex ?>_idCause" id="x<?php echo $causes_list->RowIndex ?>_idCause" placeholder="<?php echo HtmlEncode($causes_list->idCause->getPlaceHolder()) ?>" value="<?php echo $causes_list->idCause->EditValue ?>"<?php echo $causes_list->idCause->editAttributes() ?>>
</span>
<input type="hidden" data-table="causes" data-field="x_idCause" name="o<?php echo $causes_list->RowIndex ?>_idCause" id="o<?php echo $causes_list->RowIndex ?>_idCause" value="<?php echo HtmlEncode($causes_list->idCause->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($causes_list->cause->Visible) { // cause ?>
		<td data-name="cause">
<span id="el$rowindex$_causes_cause" class="form-group causes_cause">
<input type="text" data-table="causes" data-field="x_cause" name="x<?php echo $causes_list->RowIndex ?>_cause" id="x<?php echo $causes_list->RowIndex ?>_cause" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($causes_list->cause->getPlaceHolder()) ?>" value="<?php echo $causes_list->cause->EditValue ?>"<?php echo $causes_list->cause->editAttributes() ?>>
</span>
<input type="hidden" data-table="causes" data-field="x_cause" name="o<?php echo $causes_list->RowIndex ?>_cause" id="o<?php echo $causes_list->RowIndex ?>_cause" value="<?php echo HtmlEncode($causes_list->cause->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$causes_list->ListOptions->render("body", "right", $causes_list->RowIndex);
?>
<script>
loadjs.ready(["fcauseslist", "load"], function() {
	fcauseslist.updateLists(<?php echo $causes_list->RowIndex ?>);
});
</script>
	</tr>
<?php
	}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if ($causes_list->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?php echo $causes_list->FormKeyCountName ?>" id="<?php echo $causes_list->FormKeyCountName ?>" value="<?php echo $causes_list->KeyCount ?>">
<?php echo $causes_list->MultiSelectKey ?>
<?php } ?>
<?php if ($causes_list->isEdit()) { ?>
<input type="hidden" name="<?php echo $causes_list->FormKeyCountName ?>" id="<?php echo $causes_list->FormKeyCountName ?>" value="<?php echo $causes_list->KeyCount ?>">
<?php } ?>
<?php if ($causes_list->isGridEdit()) { ?>
<?php if ($causes->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="action" id="action" value="gridoverwrite">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<?php } ?>
<input type="hidden" name="<?php echo $causes_list->FormKeyCountName ?>" id="<?php echo $causes_list->FormKeyCountName ?>" value="<?php echo $causes_list->KeyCount ?>">
<?php echo $causes_list->MultiSelectKey ?>
<?php } ?>
<?php if (!$causes->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($causes_list->Recordset)
	$causes_list->Recordset->Close();
?>
<?php if (!$causes_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$causes_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $causes_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $causes_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($causes_list->TotalRecords == 0 && !$causes->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $causes_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$causes_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$causes_list->isExport()) { ?>
<script>
loadjs.ready("load", function() {

	// Startup script
	// Write your table-specific startup script here
	// console.log("page loaded");

});
</script>
<?php } ?>
<?php include_once "footer.php"; ?>
<?php
$causes_list->terminate();
?>