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
$suppliers_list = new suppliers_list();

// Run the page
$suppliers_list->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$suppliers_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$suppliers_list->isExport()) { ?>
<script>
var fsupplierslist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	fsupplierslist = currentForm = new ew.Form("fsupplierslist", "list");
	fsupplierslist.formKeyCountName = '<?php echo $suppliers_list->FormKeyCountName ?>';

	// Validate form
	fsupplierslist.validate = function() {
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
			<?php if ($suppliers_list->supplier->Required) { ?>
				elm = this.getElements("x" + infix + "_supplier");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $suppliers_list->supplier->caption(), $suppliers_list->supplier->RequiredErrorMessage)) ?>");
			<?php } ?>

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
		}
		return true;
	}

	// Form_CustomValidate
	fsupplierslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fsupplierslist.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fsupplierslist");
});
var fsupplierslistsrch;
loadjs.ready("head", function() {

	// Form object for search
	fsupplierslistsrch = currentSearchForm = new ew.Form("fsupplierslistsrch");

	// Dynamic selection lists
	// Filters

	fsupplierslistsrch.filterList = <?php echo $suppliers_list->getFilterList() ?>;
	loadjs.done("fsupplierslistsrch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$suppliers_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($suppliers_list->TotalRecords > 0 && $suppliers_list->ExportOptions->visible()) { ?>
<?php $suppliers_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($suppliers_list->ImportOptions->visible()) { ?>
<?php $suppliers_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($suppliers_list->SearchOptions->visible()) { ?>
<?php $suppliers_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($suppliers_list->FilterOptions->visible()) { ?>
<?php $suppliers_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$suppliers_list->renderOtherOptions();
?>
<?php if (!$suppliers_list->isExport() && !$suppliers->CurrentAction) { ?>
<form name="fsupplierslistsrch" id="fsupplierslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="fsupplierslistsrch-search-panel" class="<?php echo $suppliers_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="suppliers">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $suppliers_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($suppliers_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($suppliers_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $suppliers_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($suppliers_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($suppliers_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($suppliers_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($suppliers_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php $suppliers_list->showPageHeader(); ?>
<?php
$suppliers_list->showMessage();
?>
<?php if ($suppliers_list->TotalRecords > 0 || $suppliers->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($suppliers_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> suppliers">
<?php if (!$suppliers_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$suppliers_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $suppliers_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $suppliers_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fsupplierslist" id="fsupplierslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="suppliers">
<div id="gmp_suppliers" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($suppliers_list->TotalRecords > 0 || $suppliers_list->isGridEdit()) { ?>
<table id="tbl_supplierslist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$suppliers->RowType = ROWTYPE_HEADER;

// Render list options
$suppliers_list->renderListOptions();

// Render list options (header, left)
$suppliers_list->ListOptions->render("header", "left");
?>
<?php if ($suppliers_list->supplier->Visible) { // supplier ?>
	<?php if ($suppliers_list->SortUrl($suppliers_list->supplier) == "") { ?>
		<th data-name="supplier" class="<?php echo $suppliers_list->supplier->headerCellClass() ?>"><div id="elh_suppliers_supplier" class="suppliers_supplier"><div class="ew-table-header-caption"><?php echo $suppliers_list->supplier->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="supplier" class="<?php echo $suppliers_list->supplier->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $suppliers_list->SortUrl($suppliers_list->supplier) ?>', 2);"><div id="elh_suppliers_supplier" class="suppliers_supplier">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $suppliers_list->supplier->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($suppliers_list->supplier->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($suppliers_list->supplier->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$suppliers_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($suppliers_list->ExportAll && $suppliers_list->isExport()) {
	$suppliers_list->StopRecord = $suppliers_list->TotalRecords;
} else {

	// Set the last record to display
	if ($suppliers_list->TotalRecords > $suppliers_list->StartRecord + $suppliers_list->DisplayRecords - 1)
		$suppliers_list->StopRecord = $suppliers_list->StartRecord + $suppliers_list->DisplayRecords - 1;
	else
		$suppliers_list->StopRecord = $suppliers_list->TotalRecords;
}

// Restore number of post back records
if ($CurrentForm && ($suppliers->isConfirm() || $suppliers_list->EventCancelled)) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($suppliers_list->FormKeyCountName) && ($suppliers_list->isGridAdd() || $suppliers_list->isGridEdit() || $suppliers->isConfirm())) {
		$suppliers_list->KeyCount = $CurrentForm->getValue($suppliers_list->FormKeyCountName);
		$suppliers_list->StopRecord = $suppliers_list->StartRecord + $suppliers_list->KeyCount - 1;
	}
}
$suppliers_list->RecordCount = $suppliers_list->StartRecord - 1;
if ($suppliers_list->Recordset && !$suppliers_list->Recordset->EOF) {
	$suppliers_list->Recordset->moveFirst();
	$selectLimit = $suppliers_list->UseSelectLimit;
	if (!$selectLimit && $suppliers_list->StartRecord > 1)
		$suppliers_list->Recordset->move($suppliers_list->StartRecord - 1);
} elseif (!$suppliers->AllowAddDeleteRow && $suppliers_list->StopRecord == 0) {
	$suppliers_list->StopRecord = $suppliers->GridAddRowCount;
}

// Initialize aggregate
$suppliers->RowType = ROWTYPE_AGGREGATEINIT;
$suppliers->resetAttributes();
$suppliers_list->renderRow();
$suppliers_list->EditRowCount = 0;
if ($suppliers_list->isEdit())
	$suppliers_list->RowIndex = 1;
if ($suppliers_list->isGridEdit())
	$suppliers_list->RowIndex = 0;
while ($suppliers_list->RecordCount < $suppliers_list->StopRecord) {
	$suppliers_list->RecordCount++;
	if ($suppliers_list->RecordCount >= $suppliers_list->StartRecord) {
		$suppliers_list->RowCount++;
		if ($suppliers_list->isGridAdd() || $suppliers_list->isGridEdit() || $suppliers->isConfirm()) {
			$suppliers_list->RowIndex++;
			$CurrentForm->Index = $suppliers_list->RowIndex;
			if ($CurrentForm->hasValue($suppliers_list->FormActionName) && ($suppliers->isConfirm() || $suppliers_list->EventCancelled))
				$suppliers_list->RowAction = strval($CurrentForm->getValue($suppliers_list->FormActionName));
			elseif ($suppliers_list->isGridAdd())
				$suppliers_list->RowAction = "insert";
			else
				$suppliers_list->RowAction = "";
		}

		// Set up key count
		$suppliers_list->KeyCount = $suppliers_list->RowIndex;

		// Init row class and style
		$suppliers->resetAttributes();
		$suppliers->CssClass = "";
		if ($suppliers_list->isGridAdd()) {
			$suppliers_list->loadRowValues(); // Load default values
		} else {
			$suppliers_list->loadRowValues($suppliers_list->Recordset); // Load row values
		}
		$suppliers->RowType = ROWTYPE_VIEW; // Render view
		if ($suppliers_list->isEdit()) {
			if ($suppliers_list->checkInlineEditKey() && $suppliers_list->EditRowCount == 0) { // Inline edit
				$suppliers->RowType = ROWTYPE_EDIT; // Render edit
			}
		}
		if ($suppliers_list->isGridEdit()) { // Grid edit
			if ($suppliers->EventCancelled)
				$suppliers_list->restoreCurrentRowFormValues($suppliers_list->RowIndex); // Restore form values
			if ($suppliers_list->RowAction == "insert")
				$suppliers->RowType = ROWTYPE_ADD; // Render add
			else
				$suppliers->RowType = ROWTYPE_EDIT; // Render edit
		}
		if ($suppliers_list->isEdit() && $suppliers->RowType == ROWTYPE_EDIT && $suppliers->EventCancelled) { // Update failed
			$CurrentForm->Index = 1;
			$suppliers_list->restoreFormValues(); // Restore form values
		}
		if ($suppliers_list->isGridEdit() && ($suppliers->RowType == ROWTYPE_EDIT || $suppliers->RowType == ROWTYPE_ADD) && $suppliers->EventCancelled) // Update failed
			$suppliers_list->restoreCurrentRowFormValues($suppliers_list->RowIndex); // Restore form values
		if ($suppliers->RowType == ROWTYPE_EDIT) // Edit row
			$suppliers_list->EditRowCount++;

		// Set up row id / data-rowindex
		$suppliers->RowAttrs->merge(["data-rowindex" => $suppliers_list->RowCount, "id" => "r" . $suppliers_list->RowCount . "_suppliers", "data-rowtype" => $suppliers->RowType]);

		// Render row
		$suppliers_list->renderRow();

		// Render list options
		$suppliers_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($suppliers_list->RowAction != "delete" && $suppliers_list->RowAction != "insertdelete" && !($suppliers_list->RowAction == "insert" && $suppliers->isConfirm() && $suppliers_list->emptyRow())) {
?>
	<tr <?php echo $suppliers->rowAttributes() ?>>
<?php

// Render list options (body, left)
$suppliers_list->ListOptions->render("body", "left", $suppliers_list->RowCount);
?>
	<?php if ($suppliers_list->supplier->Visible) { // supplier ?>
		<td data-name="supplier" <?php echo $suppliers_list->supplier->cellAttributes() ?>>
<?php if ($suppliers->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $suppliers_list->RowCount ?>_suppliers_supplier" class="form-group">
<input type="text" data-table="suppliers" data-field="x_supplier" name="x<?php echo $suppliers_list->RowIndex ?>_supplier" id="x<?php echo $suppliers_list->RowIndex ?>_supplier" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($suppliers_list->supplier->getPlaceHolder()) ?>" value="<?php echo $suppliers_list->supplier->EditValue ?>"<?php echo $suppliers_list->supplier->editAttributes() ?>>
</span>
<input type="hidden" data-table="suppliers" data-field="x_supplier" name="o<?php echo $suppliers_list->RowIndex ?>_supplier" id="o<?php echo $suppliers_list->RowIndex ?>_supplier" value="<?php echo HtmlEncode($suppliers_list->supplier->OldValue) ?>">
<?php } ?>
<?php if ($suppliers->RowType == ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-table="suppliers" data-field="x_supplier" name="x<?php echo $suppliers_list->RowIndex ?>_supplier" id="x<?php echo $suppliers_list->RowIndex ?>_supplier" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($suppliers_list->supplier->getPlaceHolder()) ?>" value="<?php echo $suppliers_list->supplier->EditValue ?>"<?php echo $suppliers_list->supplier->editAttributes() ?>>
<input type="hidden" data-table="suppliers" data-field="x_supplier" name="o<?php echo $suppliers_list->RowIndex ?>_supplier" id="o<?php echo $suppliers_list->RowIndex ?>_supplier" value="<?php echo HtmlEncode($suppliers_list->supplier->OldValue != null ? $suppliers_list->supplier->OldValue : $suppliers_list->supplier->CurrentValue) ?>">
<?php } ?>
<?php if ($suppliers->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $suppliers_list->RowCount ?>_suppliers_supplier">
<span<?php echo $suppliers_list->supplier->viewAttributes() ?>><?php echo $suppliers_list->supplier->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$suppliers_list->ListOptions->render("body", "right", $suppliers_list->RowCount);
?>
	</tr>
<?php if ($suppliers->RowType == ROWTYPE_ADD || $suppliers->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fsupplierslist", "load"], function() {
	fsupplierslist.updateLists(<?php echo $suppliers_list->RowIndex ?>);
});
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$suppliers_list->isGridAdd())
		if (!$suppliers_list->Recordset->EOF)
			$suppliers_list->Recordset->moveNext();
}
?>
<?php
	if ($suppliers_list->isGridAdd() || $suppliers_list->isGridEdit()) {
		$suppliers_list->RowIndex = '$rowindex$';
		$suppliers_list->loadRowValues();

		// Set row properties
		$suppliers->resetAttributes();
		$suppliers->RowAttrs->merge(["data-rowindex" => $suppliers_list->RowIndex, "id" => "r0_suppliers", "data-rowtype" => ROWTYPE_ADD]);
		$suppliers->RowAttrs->appendClass("ew-template");
		$suppliers->RowType = ROWTYPE_ADD;

		// Render row
		$suppliers_list->renderRow();

		// Render list options
		$suppliers_list->renderListOptions();
		$suppliers_list->StartRowCount = 0;
?>
	<tr <?php echo $suppliers->rowAttributes() ?>>
<?php

// Render list options (body, left)
$suppliers_list->ListOptions->render("body", "left", $suppliers_list->RowIndex);
?>
	<?php if ($suppliers_list->supplier->Visible) { // supplier ?>
		<td data-name="supplier">
<span id="el$rowindex$_suppliers_supplier" class="form-group suppliers_supplier">
<input type="text" data-table="suppliers" data-field="x_supplier" name="x<?php echo $suppliers_list->RowIndex ?>_supplier" id="x<?php echo $suppliers_list->RowIndex ?>_supplier" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($suppliers_list->supplier->getPlaceHolder()) ?>" value="<?php echo $suppliers_list->supplier->EditValue ?>"<?php echo $suppliers_list->supplier->editAttributes() ?>>
</span>
<input type="hidden" data-table="suppliers" data-field="x_supplier" name="o<?php echo $suppliers_list->RowIndex ?>_supplier" id="o<?php echo $suppliers_list->RowIndex ?>_supplier" value="<?php echo HtmlEncode($suppliers_list->supplier->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$suppliers_list->ListOptions->render("body", "right", $suppliers_list->RowIndex);
?>
<script>
loadjs.ready(["fsupplierslist", "load"], function() {
	fsupplierslist.updateLists(<?php echo $suppliers_list->RowIndex ?>);
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
<?php if ($suppliers_list->isEdit()) { ?>
<input type="hidden" name="<?php echo $suppliers_list->FormKeyCountName ?>" id="<?php echo $suppliers_list->FormKeyCountName ?>" value="<?php echo $suppliers_list->KeyCount ?>">
<?php } ?>
<?php if ($suppliers_list->isGridEdit()) { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<input type="hidden" name="<?php echo $suppliers_list->FormKeyCountName ?>" id="<?php echo $suppliers_list->FormKeyCountName ?>" value="<?php echo $suppliers_list->KeyCount ?>">
<?php echo $suppliers_list->MultiSelectKey ?>
<?php } ?>
<?php if (!$suppliers->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($suppliers_list->Recordset)
	$suppliers_list->Recordset->Close();
?>
<?php if (!$suppliers_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$suppliers_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $suppliers_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $suppliers_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($suppliers_list->TotalRecords == 0 && !$suppliers->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $suppliers_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$suppliers_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$suppliers_list->isExport()) { ?>
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
$suppliers_list->terminate();
?>