<?php
namespace PHPMaker2020\SupplierMapping;

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
$mapping_list = new mapping_list();

// Run the page
$mapping_list->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$mapping_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$mapping_list->isExport()) { ?>
<script>
var fmappinglist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	fmappinglist = currentForm = new ew.Form("fmappinglist", "list");
	fmappinglist.formKeyCountName = '<?php echo $mapping_list->FormKeyCountName ?>';

	// Validate form
	fmappinglist.validate = function() {
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
			<?php if ($mapping_list->idProcess->Required) { ?>
				elm = this.getElements("x" + infix + "_idProcess");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $mapping_list->idProcess->caption(), $mapping_list->idProcess->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($mapping_list->process->Required) { ?>
				elm = this.getElements("x" + infix + "_process");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $mapping_list->process->caption(), $mapping_list->process->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($mapping_list->regulation->Required) { ?>
				elm = this.getElements("x" + infix + "_regulation[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $mapping_list->regulation->caption(), $mapping_list->regulation->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($mapping_list->qualification->Required) { ?>
				elm = this.getElements("x" + infix + "_qualification");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $mapping_list->qualification->caption(), $mapping_list->qualification->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($mapping_list->supplierLevel2->Required) { ?>
				elm = this.getElements("x" + infix + "_supplierLevel2[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $mapping_list->supplierLevel2->caption(), $mapping_list->supplierLevel2->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($mapping_list->supplierLevel3->Required) { ?>
				elm = this.getElements("x" + infix + "_supplierLevel3[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $mapping_list->supplierLevel3->caption(), $mapping_list->supplierLevel3->RequiredErrorMessage)) ?>");
			<?php } ?>

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
		}
		return true;
	}

	// Form_CustomValidate
	fmappinglist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fmappinglist.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fmappinglist.lists["x_regulation[]"] = <?php echo $mapping_list->regulation->Lookup->toClientList($mapping_list) ?>;
	fmappinglist.lists["x_regulation[]"].options = <?php echo JsonEncode($mapping_list->regulation->lookupOptions()) ?>;
	fmappinglist.lists["x_qualification"] = <?php echo $mapping_list->qualification->Lookup->toClientList($mapping_list) ?>;
	fmappinglist.lists["x_qualification"].options = <?php echo JsonEncode($mapping_list->qualification->options(FALSE, TRUE)) ?>;
	fmappinglist.lists["x_supplierLevel2[]"] = <?php echo $mapping_list->supplierLevel2->Lookup->toClientList($mapping_list) ?>;
	fmappinglist.lists["x_supplierLevel2[]"].options = <?php echo JsonEncode($mapping_list->supplierLevel2->lookupOptions()) ?>;
	fmappinglist.lists["x_supplierLevel3[]"] = <?php echo $mapping_list->supplierLevel3->Lookup->toClientList($mapping_list) ?>;
	fmappinglist.lists["x_supplierLevel3[]"].options = <?php echo JsonEncode($mapping_list->supplierLevel3->lookupOptions()) ?>;
	loadjs.done("fmappinglist");
});
var fmappinglistsrch;
loadjs.ready("head", function() {

	// Form object for search
	fmappinglistsrch = currentSearchForm = new ew.Form("fmappinglistsrch");

	// Dynamic selection lists
	// Filters

	fmappinglistsrch.filterList = <?php echo $mapping_list->getFilterList() ?>;
	loadjs.done("fmappinglistsrch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$mapping_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($mapping_list->TotalRecords > 0 && $mapping_list->ExportOptions->visible()) { ?>
<?php $mapping_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($mapping_list->ImportOptions->visible()) { ?>
<?php $mapping_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($mapping_list->SearchOptions->visible()) { ?>
<?php $mapping_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($mapping_list->FilterOptions->visible()) { ?>
<?php $mapping_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$mapping_list->renderOtherOptions();
?>
<?php if (!$mapping_list->isExport() && !$mapping->CurrentAction) { ?>
<form name="fmappinglistsrch" id="fmappinglistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="fmappinglistsrch-search-panel" class="<?php echo $mapping_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="mapping">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $mapping_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($mapping_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($mapping_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $mapping_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($mapping_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($mapping_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($mapping_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($mapping_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php $mapping_list->showPageHeader(); ?>
<?php
$mapping_list->showMessage();
?>
<?php if ($mapping_list->TotalRecords > 0 || $mapping->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($mapping_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> mapping">
<?php if (!$mapping_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$mapping_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $mapping_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $mapping_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fmappinglist" id="fmappinglist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="mapping">
<div id="gmp_mapping" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($mapping_list->TotalRecords > 0 || $mapping_list->isGridEdit()) { ?>
<table id="tbl_mappinglist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$mapping->RowType = ROWTYPE_HEADER;

// Render list options
$mapping_list->renderListOptions();

// Render list options (header, left)
$mapping_list->ListOptions->render("header", "left");
?>
<?php if ($mapping_list->idProcess->Visible) { // idProcess ?>
	<?php if ($mapping_list->SortUrl($mapping_list->idProcess) == "") { ?>
		<th data-name="idProcess" class="<?php echo $mapping_list->idProcess->headerCellClass() ?>"><div id="elh_mapping_idProcess" class="mapping_idProcess"><div class="ew-table-header-caption"><?php echo $mapping_list->idProcess->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idProcess" class="<?php echo $mapping_list->idProcess->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $mapping_list->SortUrl($mapping_list->idProcess) ?>', 2);"><div id="elh_mapping_idProcess" class="mapping_idProcess">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $mapping_list->idProcess->caption() ?></span><span class="ew-table-header-sort"><?php if ($mapping_list->idProcess->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($mapping_list->idProcess->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($mapping_list->process->Visible) { // process ?>
	<?php if ($mapping_list->SortUrl($mapping_list->process) == "") { ?>
		<th data-name="process" class="<?php echo $mapping_list->process->headerCellClass() ?>"><div id="elh_mapping_process" class="mapping_process"><div class="ew-table-header-caption"><?php echo $mapping_list->process->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="process" class="<?php echo $mapping_list->process->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $mapping_list->SortUrl($mapping_list->process) ?>', 2);"><div id="elh_mapping_process" class="mapping_process">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $mapping_list->process->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($mapping_list->process->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($mapping_list->process->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($mapping_list->regulation->Visible) { // regulation ?>
	<?php if ($mapping_list->SortUrl($mapping_list->regulation) == "") { ?>
		<th data-name="regulation" class="<?php echo $mapping_list->regulation->headerCellClass() ?>"><div id="elh_mapping_regulation" class="mapping_regulation"><div class="ew-table-header-caption"><?php echo $mapping_list->regulation->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="regulation" class="<?php echo $mapping_list->regulation->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $mapping_list->SortUrl($mapping_list->regulation) ?>', 2);"><div id="elh_mapping_regulation" class="mapping_regulation">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $mapping_list->regulation->caption() ?></span><span class="ew-table-header-sort"><?php if ($mapping_list->regulation->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($mapping_list->regulation->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($mapping_list->qualification->Visible) { // qualification ?>
	<?php if ($mapping_list->SortUrl($mapping_list->qualification) == "") { ?>
		<th data-name="qualification" class="<?php echo $mapping_list->qualification->headerCellClass() ?>"><div id="elh_mapping_qualification" class="mapping_qualification"><div class="ew-table-header-caption"><?php echo $mapping_list->qualification->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="qualification" class="<?php echo $mapping_list->qualification->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $mapping_list->SortUrl($mapping_list->qualification) ?>', 2);"><div id="elh_mapping_qualification" class="mapping_qualification">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $mapping_list->qualification->caption() ?></span><span class="ew-table-header-sort"><?php if ($mapping_list->qualification->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($mapping_list->qualification->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($mapping_list->supplierLevel2->Visible) { // supplierLevel2 ?>
	<?php if ($mapping_list->SortUrl($mapping_list->supplierLevel2) == "") { ?>
		<th data-name="supplierLevel2" class="<?php echo $mapping_list->supplierLevel2->headerCellClass() ?>"><div id="elh_mapping_supplierLevel2" class="mapping_supplierLevel2"><div class="ew-table-header-caption"><?php echo $mapping_list->supplierLevel2->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="supplierLevel2" class="<?php echo $mapping_list->supplierLevel2->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $mapping_list->SortUrl($mapping_list->supplierLevel2) ?>', 2);"><div id="elh_mapping_supplierLevel2" class="mapping_supplierLevel2">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $mapping_list->supplierLevel2->caption() ?></span><span class="ew-table-header-sort"><?php if ($mapping_list->supplierLevel2->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($mapping_list->supplierLevel2->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($mapping_list->supplierLevel3->Visible) { // supplierLevel3 ?>
	<?php if ($mapping_list->SortUrl($mapping_list->supplierLevel3) == "") { ?>
		<th data-name="supplierLevel3" class="<?php echo $mapping_list->supplierLevel3->headerCellClass() ?>"><div id="elh_mapping_supplierLevel3" class="mapping_supplierLevel3"><div class="ew-table-header-caption"><?php echo $mapping_list->supplierLevel3->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="supplierLevel3" class="<?php echo $mapping_list->supplierLevel3->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $mapping_list->SortUrl($mapping_list->supplierLevel3) ?>', 2);"><div id="elh_mapping_supplierLevel3" class="mapping_supplierLevel3">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $mapping_list->supplierLevel3->caption() ?></span><span class="ew-table-header-sort"><?php if ($mapping_list->supplierLevel3->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($mapping_list->supplierLevel3->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$mapping_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($mapping_list->ExportAll && $mapping_list->isExport()) {
	$mapping_list->StopRecord = $mapping_list->TotalRecords;
} else {

	// Set the last record to display
	if ($mapping_list->TotalRecords > $mapping_list->StartRecord + $mapping_list->DisplayRecords - 1)
		$mapping_list->StopRecord = $mapping_list->StartRecord + $mapping_list->DisplayRecords - 1;
	else
		$mapping_list->StopRecord = $mapping_list->TotalRecords;
}

// Restore number of post back records
if ($CurrentForm && ($mapping->isConfirm() || $mapping_list->EventCancelled)) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($mapping_list->FormKeyCountName) && ($mapping_list->isGridAdd() || $mapping_list->isGridEdit() || $mapping->isConfirm())) {
		$mapping_list->KeyCount = $CurrentForm->getValue($mapping_list->FormKeyCountName);
		$mapping_list->StopRecord = $mapping_list->StartRecord + $mapping_list->KeyCount - 1;
	}
}
$mapping_list->RecordCount = $mapping_list->StartRecord - 1;
if ($mapping_list->Recordset && !$mapping_list->Recordset->EOF) {
	$mapping_list->Recordset->moveFirst();
	$selectLimit = $mapping_list->UseSelectLimit;
	if (!$selectLimit && $mapping_list->StartRecord > 1)
		$mapping_list->Recordset->move($mapping_list->StartRecord - 1);
} elseif (!$mapping->AllowAddDeleteRow && $mapping_list->StopRecord == 0) {
	$mapping_list->StopRecord = $mapping->GridAddRowCount;
}

// Initialize aggregate
$mapping->RowType = ROWTYPE_AGGREGATEINIT;
$mapping->resetAttributes();
$mapping_list->renderRow();
$mapping_list->EditRowCount = 0;
if ($mapping_list->isEdit())
	$mapping_list->RowIndex = 1;
if ($mapping_list->isGridEdit())
	$mapping_list->RowIndex = 0;
while ($mapping_list->RecordCount < $mapping_list->StopRecord) {
	$mapping_list->RecordCount++;
	if ($mapping_list->RecordCount >= $mapping_list->StartRecord) {
		$mapping_list->RowCount++;
		if ($mapping_list->isGridAdd() || $mapping_list->isGridEdit() || $mapping->isConfirm()) {
			$mapping_list->RowIndex++;
			$CurrentForm->Index = $mapping_list->RowIndex;
			if ($CurrentForm->hasValue($mapping_list->FormActionName) && ($mapping->isConfirm() || $mapping_list->EventCancelled))
				$mapping_list->RowAction = strval($CurrentForm->getValue($mapping_list->FormActionName));
			elseif ($mapping_list->isGridAdd())
				$mapping_list->RowAction = "insert";
			else
				$mapping_list->RowAction = "";
		}

		// Set up key count
		$mapping_list->KeyCount = $mapping_list->RowIndex;

		// Init row class and style
		$mapping->resetAttributes();
		$mapping->CssClass = "";
		if ($mapping_list->isGridAdd()) {
			$mapping_list->loadRowValues(); // Load default values
		} else {
			$mapping_list->loadRowValues($mapping_list->Recordset); // Load row values
		}
		$mapping->RowType = ROWTYPE_VIEW; // Render view
		if ($mapping_list->isEdit()) {
			if ($mapping_list->checkInlineEditKey() && $mapping_list->EditRowCount == 0) { // Inline edit
				$mapping->RowType = ROWTYPE_EDIT; // Render edit
			}
		}
		if ($mapping_list->isGridEdit()) { // Grid edit
			if ($mapping->EventCancelled)
				$mapping_list->restoreCurrentRowFormValues($mapping_list->RowIndex); // Restore form values
			if ($mapping_list->RowAction == "insert")
				$mapping->RowType = ROWTYPE_ADD; // Render add
			else
				$mapping->RowType = ROWTYPE_EDIT; // Render edit
		}
		if ($mapping_list->isEdit() && $mapping->RowType == ROWTYPE_EDIT && $mapping->EventCancelled) { // Update failed
			$CurrentForm->Index = 1;
			$mapping_list->restoreFormValues(); // Restore form values
		}
		if ($mapping_list->isGridEdit() && ($mapping->RowType == ROWTYPE_EDIT || $mapping->RowType == ROWTYPE_ADD) && $mapping->EventCancelled) // Update failed
			$mapping_list->restoreCurrentRowFormValues($mapping_list->RowIndex); // Restore form values
		if ($mapping->RowType == ROWTYPE_EDIT) // Edit row
			$mapping_list->EditRowCount++;

		// Set up row id / data-rowindex
		$mapping->RowAttrs->merge(["data-rowindex" => $mapping_list->RowCount, "id" => "r" . $mapping_list->RowCount . "_mapping", "data-rowtype" => $mapping->RowType]);

		// Render row
		$mapping_list->renderRow();

		// Render list options
		$mapping_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($mapping_list->RowAction != "delete" && $mapping_list->RowAction != "insertdelete" && !($mapping_list->RowAction == "insert" && $mapping->isConfirm() && $mapping_list->emptyRow())) {
?>
	<tr <?php echo $mapping->rowAttributes() ?>>
<?php

// Render list options (body, left)
$mapping_list->ListOptions->render("body", "left", $mapping_list->RowCount);
?>
	<?php if ($mapping_list->idProcess->Visible) { // idProcess ?>
		<td data-name="idProcess" <?php echo $mapping_list->idProcess->cellAttributes() ?>>
<?php if ($mapping->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $mapping_list->RowCount ?>_mapping_idProcess" class="form-group"></span>
<input type="hidden" data-table="mapping" data-field="x_idProcess" name="o<?php echo $mapping_list->RowIndex ?>_idProcess" id="o<?php echo $mapping_list->RowIndex ?>_idProcess" value="<?php echo HtmlEncode($mapping_list->idProcess->OldValue) ?>">
<?php } ?>
<?php if ($mapping->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $mapping_list->RowCount ?>_mapping_idProcess" class="form-group">
<span<?php echo $mapping_list->idProcess->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($mapping_list->idProcess->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="mapping" data-field="x_idProcess" name="x<?php echo $mapping_list->RowIndex ?>_idProcess" id="x<?php echo $mapping_list->RowIndex ?>_idProcess" value="<?php echo HtmlEncode($mapping_list->idProcess->CurrentValue) ?>">
<?php } ?>
<?php if ($mapping->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $mapping_list->RowCount ?>_mapping_idProcess">
<span<?php echo $mapping_list->idProcess->viewAttributes() ?>><?php echo $mapping_list->idProcess->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($mapping_list->process->Visible) { // process ?>
		<td data-name="process" <?php echo $mapping_list->process->cellAttributes() ?>>
<?php if ($mapping->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $mapping_list->RowCount ?>_mapping_process" class="form-group">
<input type="text" data-table="mapping" data-field="x_process" name="x<?php echo $mapping_list->RowIndex ?>_process" id="x<?php echo $mapping_list->RowIndex ?>_process" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($mapping_list->process->getPlaceHolder()) ?>" value="<?php echo $mapping_list->process->EditValue ?>"<?php echo $mapping_list->process->editAttributes() ?>>
</span>
<input type="hidden" data-table="mapping" data-field="x_process" name="o<?php echo $mapping_list->RowIndex ?>_process" id="o<?php echo $mapping_list->RowIndex ?>_process" value="<?php echo HtmlEncode($mapping_list->process->OldValue) ?>">
<?php } ?>
<?php if ($mapping->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $mapping_list->RowCount ?>_mapping_process" class="form-group">
<input type="text" data-table="mapping" data-field="x_process" name="x<?php echo $mapping_list->RowIndex ?>_process" id="x<?php echo $mapping_list->RowIndex ?>_process" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($mapping_list->process->getPlaceHolder()) ?>" value="<?php echo $mapping_list->process->EditValue ?>"<?php echo $mapping_list->process->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($mapping->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $mapping_list->RowCount ?>_mapping_process">
<span<?php echo $mapping_list->process->viewAttributes() ?>><?php echo $mapping_list->process->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($mapping_list->regulation->Visible) { // regulation ?>
		<td data-name="regulation" <?php echo $mapping_list->regulation->cellAttributes() ?>>
<?php if ($mapping->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $mapping_list->RowCount ?>_mapping_regulation" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="mapping" data-field="x_regulation" data-value-separator="<?php echo $mapping_list->regulation->displayValueSeparatorAttribute() ?>" id="x<?php echo $mapping_list->RowIndex ?>_regulation[]" name="x<?php echo $mapping_list->RowIndex ?>_regulation[]" multiple="multiple"<?php echo $mapping_list->regulation->editAttributes() ?>>
			<?php echo $mapping_list->regulation->selectOptionListHtml("x{$mapping_list->RowIndex}_regulation[]") ?>
		</select>
</div>
<?php echo $mapping_list->regulation->Lookup->getParamTag($mapping_list, "p_x" . $mapping_list->RowIndex . "_regulation") ?>
</span>
<input type="hidden" data-table="mapping" data-field="x_regulation" name="o<?php echo $mapping_list->RowIndex ?>_regulation[]" id="o<?php echo $mapping_list->RowIndex ?>_regulation[]" value="<?php echo HtmlEncode($mapping_list->regulation->OldValue) ?>">
<?php } ?>
<?php if ($mapping->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $mapping_list->RowCount ?>_mapping_regulation" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="mapping" data-field="x_regulation" data-value-separator="<?php echo $mapping_list->regulation->displayValueSeparatorAttribute() ?>" id="x<?php echo $mapping_list->RowIndex ?>_regulation[]" name="x<?php echo $mapping_list->RowIndex ?>_regulation[]" multiple="multiple"<?php echo $mapping_list->regulation->editAttributes() ?>>
			<?php echo $mapping_list->regulation->selectOptionListHtml("x{$mapping_list->RowIndex}_regulation[]") ?>
		</select>
</div>
<?php echo $mapping_list->regulation->Lookup->getParamTag($mapping_list, "p_x" . $mapping_list->RowIndex . "_regulation") ?>
</span>
<?php } ?>
<?php if ($mapping->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $mapping_list->RowCount ?>_mapping_regulation">
<span<?php echo $mapping_list->regulation->viewAttributes() ?>><?php echo $mapping_list->regulation->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($mapping_list->qualification->Visible) { // qualification ?>
		<td data-name="qualification" <?php echo $mapping_list->qualification->cellAttributes() ?>>
<?php if ($mapping->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $mapping_list->RowCount ?>_mapping_qualification" class="form-group">
<div id="tp_x<?php echo $mapping_list->RowIndex ?>_qualification" class="ew-template"><input type="radio" class="custom-control-input" data-table="mapping" data-field="x_qualification" data-value-separator="<?php echo $mapping_list->qualification->displayValueSeparatorAttribute() ?>" name="x<?php echo $mapping_list->RowIndex ?>_qualification" id="x<?php echo $mapping_list->RowIndex ?>_qualification" value="{value}"<?php echo $mapping_list->qualification->editAttributes() ?>></div>
<div id="dsl_x<?php echo $mapping_list->RowIndex ?>_qualification" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $mapping_list->qualification->radioButtonListHtml(FALSE, "x{$mapping_list->RowIndex}_qualification") ?>
</div></div>
</span>
<input type="hidden" data-table="mapping" data-field="x_qualification" name="o<?php echo $mapping_list->RowIndex ?>_qualification" id="o<?php echo $mapping_list->RowIndex ?>_qualification" value="<?php echo HtmlEncode($mapping_list->qualification->OldValue) ?>">
<?php } ?>
<?php if ($mapping->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $mapping_list->RowCount ?>_mapping_qualification" class="form-group">
<div id="tp_x<?php echo $mapping_list->RowIndex ?>_qualification" class="ew-template"><input type="radio" class="custom-control-input" data-table="mapping" data-field="x_qualification" data-value-separator="<?php echo $mapping_list->qualification->displayValueSeparatorAttribute() ?>" name="x<?php echo $mapping_list->RowIndex ?>_qualification" id="x<?php echo $mapping_list->RowIndex ?>_qualification" value="{value}"<?php echo $mapping_list->qualification->editAttributes() ?>></div>
<div id="dsl_x<?php echo $mapping_list->RowIndex ?>_qualification" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $mapping_list->qualification->radioButtonListHtml(FALSE, "x{$mapping_list->RowIndex}_qualification") ?>
</div></div>
</span>
<?php } ?>
<?php if ($mapping->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $mapping_list->RowCount ?>_mapping_qualification">
<span<?php echo $mapping_list->qualification->viewAttributes() ?>><?php echo $mapping_list->qualification->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($mapping_list->supplierLevel2->Visible) { // supplierLevel2 ?>
		<td data-name="supplierLevel2" <?php echo $mapping_list->supplierLevel2->cellAttributes() ?>>
<?php if ($mapping->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $mapping_list->RowCount ?>_mapping_supplierLevel2" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="mapping" data-field="x_supplierLevel2" data-value-separator="<?php echo $mapping_list->supplierLevel2->displayValueSeparatorAttribute() ?>" id="x<?php echo $mapping_list->RowIndex ?>_supplierLevel2[]" name="x<?php echo $mapping_list->RowIndex ?>_supplierLevel2[]" multiple="multiple"<?php echo $mapping_list->supplierLevel2->editAttributes() ?>>
			<?php echo $mapping_list->supplierLevel2->selectOptionListHtml("x{$mapping_list->RowIndex}_supplierLevel2[]") ?>
		</select>
</div>
<?php echo $mapping_list->supplierLevel2->Lookup->getParamTag($mapping_list, "p_x" . $mapping_list->RowIndex . "_supplierLevel2") ?>
</span>
<input type="hidden" data-table="mapping" data-field="x_supplierLevel2" name="o<?php echo $mapping_list->RowIndex ?>_supplierLevel2[]" id="o<?php echo $mapping_list->RowIndex ?>_supplierLevel2[]" value="<?php echo HtmlEncode($mapping_list->supplierLevel2->OldValue) ?>">
<?php } ?>
<?php if ($mapping->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $mapping_list->RowCount ?>_mapping_supplierLevel2" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="mapping" data-field="x_supplierLevel2" data-value-separator="<?php echo $mapping_list->supplierLevel2->displayValueSeparatorAttribute() ?>" id="x<?php echo $mapping_list->RowIndex ?>_supplierLevel2[]" name="x<?php echo $mapping_list->RowIndex ?>_supplierLevel2[]" multiple="multiple"<?php echo $mapping_list->supplierLevel2->editAttributes() ?>>
			<?php echo $mapping_list->supplierLevel2->selectOptionListHtml("x{$mapping_list->RowIndex}_supplierLevel2[]") ?>
		</select>
</div>
<?php echo $mapping_list->supplierLevel2->Lookup->getParamTag($mapping_list, "p_x" . $mapping_list->RowIndex . "_supplierLevel2") ?>
</span>
<?php } ?>
<?php if ($mapping->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $mapping_list->RowCount ?>_mapping_supplierLevel2">
<span<?php echo $mapping_list->supplierLevel2->viewAttributes() ?>><?php echo $mapping_list->supplierLevel2->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($mapping_list->supplierLevel3->Visible) { // supplierLevel3 ?>
		<td data-name="supplierLevel3" <?php echo $mapping_list->supplierLevel3->cellAttributes() ?>>
<?php if ($mapping->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $mapping_list->RowCount ?>_mapping_supplierLevel3" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="mapping" data-field="x_supplierLevel3" data-value-separator="<?php echo $mapping_list->supplierLevel3->displayValueSeparatorAttribute() ?>" id="x<?php echo $mapping_list->RowIndex ?>_supplierLevel3[]" name="x<?php echo $mapping_list->RowIndex ?>_supplierLevel3[]" multiple="multiple"<?php echo $mapping_list->supplierLevel3->editAttributes() ?>>
			<?php echo $mapping_list->supplierLevel3->selectOptionListHtml("x{$mapping_list->RowIndex}_supplierLevel3[]") ?>
		</select>
</div>
<?php echo $mapping_list->supplierLevel3->Lookup->getParamTag($mapping_list, "p_x" . $mapping_list->RowIndex . "_supplierLevel3") ?>
</span>
<input type="hidden" data-table="mapping" data-field="x_supplierLevel3" name="o<?php echo $mapping_list->RowIndex ?>_supplierLevel3[]" id="o<?php echo $mapping_list->RowIndex ?>_supplierLevel3[]" value="<?php echo HtmlEncode($mapping_list->supplierLevel3->OldValue) ?>">
<?php } ?>
<?php if ($mapping->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $mapping_list->RowCount ?>_mapping_supplierLevel3" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="mapping" data-field="x_supplierLevel3" data-value-separator="<?php echo $mapping_list->supplierLevel3->displayValueSeparatorAttribute() ?>" id="x<?php echo $mapping_list->RowIndex ?>_supplierLevel3[]" name="x<?php echo $mapping_list->RowIndex ?>_supplierLevel3[]" multiple="multiple"<?php echo $mapping_list->supplierLevel3->editAttributes() ?>>
			<?php echo $mapping_list->supplierLevel3->selectOptionListHtml("x{$mapping_list->RowIndex}_supplierLevel3[]") ?>
		</select>
</div>
<?php echo $mapping_list->supplierLevel3->Lookup->getParamTag($mapping_list, "p_x" . $mapping_list->RowIndex . "_supplierLevel3") ?>
</span>
<?php } ?>
<?php if ($mapping->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $mapping_list->RowCount ?>_mapping_supplierLevel3">
<span<?php echo $mapping_list->supplierLevel3->viewAttributes() ?>><?php echo $mapping_list->supplierLevel3->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$mapping_list->ListOptions->render("body", "right", $mapping_list->RowCount);
?>
	</tr>
<?php if ($mapping->RowType == ROWTYPE_ADD || $mapping->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fmappinglist", "load"], function() {
	fmappinglist.updateLists(<?php echo $mapping_list->RowIndex ?>);
});
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$mapping_list->isGridAdd())
		if (!$mapping_list->Recordset->EOF)
			$mapping_list->Recordset->moveNext();
}
?>
<?php
	if ($mapping_list->isGridAdd() || $mapping_list->isGridEdit()) {
		$mapping_list->RowIndex = '$rowindex$';
		$mapping_list->loadRowValues();

		// Set row properties
		$mapping->resetAttributes();
		$mapping->RowAttrs->merge(["data-rowindex" => $mapping_list->RowIndex, "id" => "r0_mapping", "data-rowtype" => ROWTYPE_ADD]);
		$mapping->RowAttrs->appendClass("ew-template");
		$mapping->RowType = ROWTYPE_ADD;

		// Render row
		$mapping_list->renderRow();

		// Render list options
		$mapping_list->renderListOptions();
		$mapping_list->StartRowCount = 0;
?>
	<tr <?php echo $mapping->rowAttributes() ?>>
<?php

// Render list options (body, left)
$mapping_list->ListOptions->render("body", "left", $mapping_list->RowIndex);
?>
	<?php if ($mapping_list->idProcess->Visible) { // idProcess ?>
		<td data-name="idProcess">
<span id="el$rowindex$_mapping_idProcess" class="form-group mapping_idProcess"></span>
<input type="hidden" data-table="mapping" data-field="x_idProcess" name="o<?php echo $mapping_list->RowIndex ?>_idProcess" id="o<?php echo $mapping_list->RowIndex ?>_idProcess" value="<?php echo HtmlEncode($mapping_list->idProcess->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($mapping_list->process->Visible) { // process ?>
		<td data-name="process">
<span id="el$rowindex$_mapping_process" class="form-group mapping_process">
<input type="text" data-table="mapping" data-field="x_process" name="x<?php echo $mapping_list->RowIndex ?>_process" id="x<?php echo $mapping_list->RowIndex ?>_process" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($mapping_list->process->getPlaceHolder()) ?>" value="<?php echo $mapping_list->process->EditValue ?>"<?php echo $mapping_list->process->editAttributes() ?>>
</span>
<input type="hidden" data-table="mapping" data-field="x_process" name="o<?php echo $mapping_list->RowIndex ?>_process" id="o<?php echo $mapping_list->RowIndex ?>_process" value="<?php echo HtmlEncode($mapping_list->process->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($mapping_list->regulation->Visible) { // regulation ?>
		<td data-name="regulation">
<span id="el$rowindex$_mapping_regulation" class="form-group mapping_regulation">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="mapping" data-field="x_regulation" data-value-separator="<?php echo $mapping_list->regulation->displayValueSeparatorAttribute() ?>" id="x<?php echo $mapping_list->RowIndex ?>_regulation[]" name="x<?php echo $mapping_list->RowIndex ?>_regulation[]" multiple="multiple"<?php echo $mapping_list->regulation->editAttributes() ?>>
			<?php echo $mapping_list->regulation->selectOptionListHtml("x{$mapping_list->RowIndex}_regulation[]") ?>
		</select>
</div>
<?php echo $mapping_list->regulation->Lookup->getParamTag($mapping_list, "p_x" . $mapping_list->RowIndex . "_regulation") ?>
</span>
<input type="hidden" data-table="mapping" data-field="x_regulation" name="o<?php echo $mapping_list->RowIndex ?>_regulation[]" id="o<?php echo $mapping_list->RowIndex ?>_regulation[]" value="<?php echo HtmlEncode($mapping_list->regulation->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($mapping_list->qualification->Visible) { // qualification ?>
		<td data-name="qualification">
<span id="el$rowindex$_mapping_qualification" class="form-group mapping_qualification">
<div id="tp_x<?php echo $mapping_list->RowIndex ?>_qualification" class="ew-template"><input type="radio" class="custom-control-input" data-table="mapping" data-field="x_qualification" data-value-separator="<?php echo $mapping_list->qualification->displayValueSeparatorAttribute() ?>" name="x<?php echo $mapping_list->RowIndex ?>_qualification" id="x<?php echo $mapping_list->RowIndex ?>_qualification" value="{value}"<?php echo $mapping_list->qualification->editAttributes() ?>></div>
<div id="dsl_x<?php echo $mapping_list->RowIndex ?>_qualification" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $mapping_list->qualification->radioButtonListHtml(FALSE, "x{$mapping_list->RowIndex}_qualification") ?>
</div></div>
</span>
<input type="hidden" data-table="mapping" data-field="x_qualification" name="o<?php echo $mapping_list->RowIndex ?>_qualification" id="o<?php echo $mapping_list->RowIndex ?>_qualification" value="<?php echo HtmlEncode($mapping_list->qualification->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($mapping_list->supplierLevel2->Visible) { // supplierLevel2 ?>
		<td data-name="supplierLevel2">
<span id="el$rowindex$_mapping_supplierLevel2" class="form-group mapping_supplierLevel2">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="mapping" data-field="x_supplierLevel2" data-value-separator="<?php echo $mapping_list->supplierLevel2->displayValueSeparatorAttribute() ?>" id="x<?php echo $mapping_list->RowIndex ?>_supplierLevel2[]" name="x<?php echo $mapping_list->RowIndex ?>_supplierLevel2[]" multiple="multiple"<?php echo $mapping_list->supplierLevel2->editAttributes() ?>>
			<?php echo $mapping_list->supplierLevel2->selectOptionListHtml("x{$mapping_list->RowIndex}_supplierLevel2[]") ?>
		</select>
</div>
<?php echo $mapping_list->supplierLevel2->Lookup->getParamTag($mapping_list, "p_x" . $mapping_list->RowIndex . "_supplierLevel2") ?>
</span>
<input type="hidden" data-table="mapping" data-field="x_supplierLevel2" name="o<?php echo $mapping_list->RowIndex ?>_supplierLevel2[]" id="o<?php echo $mapping_list->RowIndex ?>_supplierLevel2[]" value="<?php echo HtmlEncode($mapping_list->supplierLevel2->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($mapping_list->supplierLevel3->Visible) { // supplierLevel3 ?>
		<td data-name="supplierLevel3">
<span id="el$rowindex$_mapping_supplierLevel3" class="form-group mapping_supplierLevel3">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="mapping" data-field="x_supplierLevel3" data-value-separator="<?php echo $mapping_list->supplierLevel3->displayValueSeparatorAttribute() ?>" id="x<?php echo $mapping_list->RowIndex ?>_supplierLevel3[]" name="x<?php echo $mapping_list->RowIndex ?>_supplierLevel3[]" multiple="multiple"<?php echo $mapping_list->supplierLevel3->editAttributes() ?>>
			<?php echo $mapping_list->supplierLevel3->selectOptionListHtml("x{$mapping_list->RowIndex}_supplierLevel3[]") ?>
		</select>
</div>
<?php echo $mapping_list->supplierLevel3->Lookup->getParamTag($mapping_list, "p_x" . $mapping_list->RowIndex . "_supplierLevel3") ?>
</span>
<input type="hidden" data-table="mapping" data-field="x_supplierLevel3" name="o<?php echo $mapping_list->RowIndex ?>_supplierLevel3[]" id="o<?php echo $mapping_list->RowIndex ?>_supplierLevel3[]" value="<?php echo HtmlEncode($mapping_list->supplierLevel3->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$mapping_list->ListOptions->render("body", "right", $mapping_list->RowIndex);
?>
<script>
loadjs.ready(["fmappinglist", "load"], function() {
	fmappinglist.updateLists(<?php echo $mapping_list->RowIndex ?>);
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
<?php if ($mapping_list->isEdit()) { ?>
<input type="hidden" name="<?php echo $mapping_list->FormKeyCountName ?>" id="<?php echo $mapping_list->FormKeyCountName ?>" value="<?php echo $mapping_list->KeyCount ?>">
<?php } ?>
<?php if ($mapping_list->isGridEdit()) { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<input type="hidden" name="<?php echo $mapping_list->FormKeyCountName ?>" id="<?php echo $mapping_list->FormKeyCountName ?>" value="<?php echo $mapping_list->KeyCount ?>">
<?php echo $mapping_list->MultiSelectKey ?>
<?php } ?>
<?php if (!$mapping->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($mapping_list->Recordset)
	$mapping_list->Recordset->Close();
?>
<?php if (!$mapping_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$mapping_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $mapping_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $mapping_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($mapping_list->TotalRecords == 0 && !$mapping->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $mapping_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$mapping_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$mapping_list->isExport()) { ?>
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
$mapping_list->terminate();
?>