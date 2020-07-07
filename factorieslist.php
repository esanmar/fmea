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
$factories_list = new factories_list();

// Run the page
$factories_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$factories_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$factories_list->isExport()) { ?>
<script>
var ffactorieslist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	ffactorieslist = currentForm = new ew.Form("ffactorieslist", "list");
	ffactorieslist.formKeyCountName = '<?php echo $factories_list->FormKeyCountName ?>';

	// Validate form
	ffactorieslist.validate = function() {
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
			<?php if ($factories_list->idFactory->Required) { ?>
				elm = this.getElements("x" + infix + "_idFactory");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $factories_list->idFactory->caption(), $factories_list->idFactory->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_idFactory");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($factories_list->idFactory->errorMessage()) ?>");
			<?php if ($factories_list->factory->Required) { ?>
				elm = this.getElements("x" + infix + "_factory");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $factories_list->factory->caption(), $factories_list->factory->RequiredErrorMessage)) ?>");
			<?php } ?>

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
		}
		return true;
	}

	// Form_CustomValidate
	ffactorieslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	ffactorieslist.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("ffactorieslist");
});
var ffactorieslistsrch;
loadjs.ready("head", function() {

	// Form object for search
	ffactorieslistsrch = currentSearchForm = new ew.Form("ffactorieslistsrch");

	// Dynamic selection lists
	// Filters

	ffactorieslistsrch.filterList = <?php echo $factories_list->getFilterList() ?>;
	loadjs.done("ffactorieslistsrch");
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
<?php if (!$factories_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($factories_list->TotalRecords > 0 && $factories_list->ExportOptions->visible()) { ?>
<?php $factories_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($factories_list->ImportOptions->visible()) { ?>
<?php $factories_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($factories_list->SearchOptions->visible()) { ?>
<?php $factories_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($factories_list->FilterOptions->visible()) { ?>
<?php $factories_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$factories_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$factories_list->isExport() && !$factories->CurrentAction) { ?>
<form name="ffactorieslistsrch" id="ffactorieslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="ffactorieslistsrch-search-panel" class="<?php echo $factories_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="factories">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $factories_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($factories_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($factories_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $factories_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($factories_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($factories_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($factories_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($factories_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $factories_list->showPageHeader(); ?>
<?php
$factories_list->showMessage();
?>
<?php if ($factories_list->TotalRecords > 0 || $factories->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($factories_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> factories">
<?php if (!$factories_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$factories_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $factories_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $factories_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="ffactorieslist" id="ffactorieslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="factories">
<div id="gmp_factories" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($factories_list->TotalRecords > 0 || $factories_list->isGridEdit()) { ?>
<table id="tbl_factorieslist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$factories->RowType = ROWTYPE_HEADER;

// Render list options
$factories_list->renderListOptions();

// Render list options (header, left)
$factories_list->ListOptions->render("header", "left");
?>
<?php if ($factories_list->idFactory->Visible) { // idFactory ?>
	<?php if ($factories_list->SortUrl($factories_list->idFactory) == "") { ?>
		<th data-name="idFactory" class="<?php echo $factories_list->idFactory->headerCellClass() ?>"><div id="elh_factories_idFactory" class="factories_idFactory"><div class="ew-table-header-caption"><?php echo $factories_list->idFactory->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idFactory" class="<?php echo $factories_list->idFactory->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $factories_list->SortUrl($factories_list->idFactory) ?>', 2);"><div id="elh_factories_idFactory" class="factories_idFactory">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $factories_list->idFactory->caption() ?></span><span class="ew-table-header-sort"><?php if ($factories_list->idFactory->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($factories_list->idFactory->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($factories_list->factory->Visible) { // factory ?>
	<?php if ($factories_list->SortUrl($factories_list->factory) == "") { ?>
		<th data-name="factory" class="<?php echo $factories_list->factory->headerCellClass() ?>"><div id="elh_factories_factory" class="factories_factory"><div class="ew-table-header-caption"><?php echo $factories_list->factory->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="factory" class="<?php echo $factories_list->factory->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $factories_list->SortUrl($factories_list->factory) ?>', 2);"><div id="elh_factories_factory" class="factories_factory">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $factories_list->factory->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($factories_list->factory->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($factories_list->factory->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$factories_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($factories_list->ExportAll && $factories_list->isExport()) {
	$factories_list->StopRecord = $factories_list->TotalRecords;
} else {

	// Set the last record to display
	if ($factories_list->TotalRecords > $factories_list->StartRecord + $factories_list->DisplayRecords - 1)
		$factories_list->StopRecord = $factories_list->StartRecord + $factories_list->DisplayRecords - 1;
	else
		$factories_list->StopRecord = $factories_list->TotalRecords;
}

// Restore number of post back records
if ($CurrentForm && ($factories->isConfirm() || $factories_list->EventCancelled)) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($factories_list->FormKeyCountName) && ($factories_list->isGridAdd() || $factories_list->isGridEdit() || $factories->isConfirm())) {
		$factories_list->KeyCount = $CurrentForm->getValue($factories_list->FormKeyCountName);
		$factories_list->StopRecord = $factories_list->StartRecord + $factories_list->KeyCount - 1;
	}
}
$factories_list->RecordCount = $factories_list->StartRecord - 1;
if ($factories_list->Recordset && !$factories_list->Recordset->EOF) {
	$factories_list->Recordset->moveFirst();
	$selectLimit = $factories_list->UseSelectLimit;
	if (!$selectLimit && $factories_list->StartRecord > 1)
		$factories_list->Recordset->move($factories_list->StartRecord - 1);
} elseif (!$factories->AllowAddDeleteRow && $factories_list->StopRecord == 0) {
	$factories_list->StopRecord = $factories->GridAddRowCount;
}

// Initialize aggregate
$factories->RowType = ROWTYPE_AGGREGATEINIT;
$factories->resetAttributes();
$factories_list->renderRow();
if ($factories_list->isGridEdit())
	$factories_list->RowIndex = 0;
while ($factories_list->RecordCount < $factories_list->StopRecord) {
	$factories_list->RecordCount++;
	if ($factories_list->RecordCount >= $factories_list->StartRecord) {
		$factories_list->RowCount++;
		if ($factories_list->isGridAdd() || $factories_list->isGridEdit() || $factories->isConfirm()) {
			$factories_list->RowIndex++;
			$CurrentForm->Index = $factories_list->RowIndex;
			if ($CurrentForm->hasValue($factories_list->FormActionName) && ($factories->isConfirm() || $factories_list->EventCancelled))
				$factories_list->RowAction = strval($CurrentForm->getValue($factories_list->FormActionName));
			elseif ($factories_list->isGridAdd())
				$factories_list->RowAction = "insert";
			else
				$factories_list->RowAction = "";
		}

		// Set up key count
		$factories_list->KeyCount = $factories_list->RowIndex;

		// Init row class and style
		$factories->resetAttributes();
		$factories->CssClass = "";
		if ($factories_list->isGridAdd()) {
			$factories_list->loadRowValues(); // Load default values
		} else {
			$factories_list->loadRowValues($factories_list->Recordset); // Load row values
		}
		$factories->RowType = ROWTYPE_VIEW; // Render view
		if ($factories_list->isGridEdit()) { // Grid edit
			if ($factories->EventCancelled)
				$factories_list->restoreCurrentRowFormValues($factories_list->RowIndex); // Restore form values
			if ($factories_list->RowAction == "insert")
				$factories->RowType = ROWTYPE_ADD; // Render add
			else
				$factories->RowType = ROWTYPE_EDIT; // Render edit
			if (!$factories->EventCancelled)
				$factories_list->HashValue = $factories_list->getRowHash($factories_list->Recordset); // Get hash value for record
		}
		if ($factories_list->isGridEdit() && ($factories->RowType == ROWTYPE_EDIT || $factories->RowType == ROWTYPE_ADD) && $factories->EventCancelled) // Update failed
			$factories_list->restoreCurrentRowFormValues($factories_list->RowIndex); // Restore form values
		if ($factories->RowType == ROWTYPE_EDIT) // Edit row
			$factories_list->EditRowCount++;

		// Set up row id / data-rowindex
		$factories->RowAttrs->merge(["data-rowindex" => $factories_list->RowCount, "id" => "r" . $factories_list->RowCount . "_factories", "data-rowtype" => $factories->RowType]);

		// Render row
		$factories_list->renderRow();

		// Render list options
		$factories_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($factories_list->RowAction != "delete" && $factories_list->RowAction != "insertdelete" && !($factories_list->RowAction == "insert" && $factories->isConfirm() && $factories_list->emptyRow())) {
?>
	<tr <?php echo $factories->rowAttributes() ?>>
<?php

// Render list options (body, left)
$factories_list->ListOptions->render("body", "left", $factories_list->RowCount);
?>
	<?php if ($factories_list->idFactory->Visible) { // idFactory ?>
		<td data-name="idFactory" <?php echo $factories_list->idFactory->cellAttributes() ?>>
<?php if ($factories->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $factories_list->RowCount ?>_factories_idFactory" class="form-group">
<input type="text" data-table="factories" data-field="x_idFactory" name="x<?php echo $factories_list->RowIndex ?>_idFactory" id="x<?php echo $factories_list->RowIndex ?>_idFactory" placeholder="<?php echo HtmlEncode($factories_list->idFactory->getPlaceHolder()) ?>" value="<?php echo $factories_list->idFactory->EditValue ?>"<?php echo $factories_list->idFactory->editAttributes() ?>>
</span>
<input type="hidden" data-table="factories" data-field="x_idFactory" name="o<?php echo $factories_list->RowIndex ?>_idFactory" id="o<?php echo $factories_list->RowIndex ?>_idFactory" value="<?php echo HtmlEncode($factories_list->idFactory->OldValue) ?>">
<?php } ?>
<?php if ($factories->RowType == ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-table="factories" data-field="x_idFactory" name="x<?php echo $factories_list->RowIndex ?>_idFactory" id="x<?php echo $factories_list->RowIndex ?>_idFactory" placeholder="<?php echo HtmlEncode($factories_list->idFactory->getPlaceHolder()) ?>" value="<?php echo $factories_list->idFactory->EditValue ?>"<?php echo $factories_list->idFactory->editAttributes() ?>>
<input type="hidden" data-table="factories" data-field="x_idFactory" name="o<?php echo $factories_list->RowIndex ?>_idFactory" id="o<?php echo $factories_list->RowIndex ?>_idFactory" value="<?php echo HtmlEncode($factories_list->idFactory->OldValue != null ? $factories_list->idFactory->OldValue : $factories_list->idFactory->CurrentValue) ?>">
<?php } ?>
<?php if ($factories->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $factories_list->RowCount ?>_factories_idFactory">
<span<?php echo $factories_list->idFactory->viewAttributes() ?>><?php echo $factories_list->idFactory->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($factories_list->factory->Visible) { // factory ?>
		<td data-name="factory" <?php echo $factories_list->factory->cellAttributes() ?>>
<?php if ($factories->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $factories_list->RowCount ?>_factories_factory" class="form-group">
<input type="text" data-table="factories" data-field="x_factory" name="x<?php echo $factories_list->RowIndex ?>_factory" id="x<?php echo $factories_list->RowIndex ?>_factory" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($factories_list->factory->getPlaceHolder()) ?>" value="<?php echo $factories_list->factory->EditValue ?>"<?php echo $factories_list->factory->editAttributes() ?>>
</span>
<input type="hidden" data-table="factories" data-field="x_factory" name="o<?php echo $factories_list->RowIndex ?>_factory" id="o<?php echo $factories_list->RowIndex ?>_factory" value="<?php echo HtmlEncode($factories_list->factory->OldValue) ?>">
<?php } ?>
<?php if ($factories->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $factories_list->RowCount ?>_factories_factory" class="form-group">
<input type="text" data-table="factories" data-field="x_factory" name="x<?php echo $factories_list->RowIndex ?>_factory" id="x<?php echo $factories_list->RowIndex ?>_factory" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($factories_list->factory->getPlaceHolder()) ?>" value="<?php echo $factories_list->factory->EditValue ?>"<?php echo $factories_list->factory->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($factories->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $factories_list->RowCount ?>_factories_factory">
<span<?php echo $factories_list->factory->viewAttributes() ?>><?php echo $factories_list->factory->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$factories_list->ListOptions->render("body", "right", $factories_list->RowCount);
?>
	</tr>
<?php if ($factories->RowType == ROWTYPE_ADD || $factories->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["ffactorieslist", "load"], function() {
	ffactorieslist.updateLists(<?php echo $factories_list->RowIndex ?>);
});
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$factories_list->isGridAdd())
		if (!$factories_list->Recordset->EOF)
			$factories_list->Recordset->moveNext();
}
?>
<?php
	if ($factories_list->isGridAdd() || $factories_list->isGridEdit()) {
		$factories_list->RowIndex = '$rowindex$';
		$factories_list->loadRowValues();

		// Set row properties
		$factories->resetAttributes();
		$factories->RowAttrs->merge(["data-rowindex" => $factories_list->RowIndex, "id" => "r0_factories", "data-rowtype" => ROWTYPE_ADD]);
		$factories->RowAttrs->appendClass("ew-template");
		$factories->RowType = ROWTYPE_ADD;

		// Render row
		$factories_list->renderRow();

		// Render list options
		$factories_list->renderListOptions();
		$factories_list->StartRowCount = 0;
?>
	<tr <?php echo $factories->rowAttributes() ?>>
<?php

// Render list options (body, left)
$factories_list->ListOptions->render("body", "left", $factories_list->RowIndex);
?>
	<?php if ($factories_list->idFactory->Visible) { // idFactory ?>
		<td data-name="idFactory">
<span id="el$rowindex$_factories_idFactory" class="form-group factories_idFactory">
<input type="text" data-table="factories" data-field="x_idFactory" name="x<?php echo $factories_list->RowIndex ?>_idFactory" id="x<?php echo $factories_list->RowIndex ?>_idFactory" placeholder="<?php echo HtmlEncode($factories_list->idFactory->getPlaceHolder()) ?>" value="<?php echo $factories_list->idFactory->EditValue ?>"<?php echo $factories_list->idFactory->editAttributes() ?>>
</span>
<input type="hidden" data-table="factories" data-field="x_idFactory" name="o<?php echo $factories_list->RowIndex ?>_idFactory" id="o<?php echo $factories_list->RowIndex ?>_idFactory" value="<?php echo HtmlEncode($factories_list->idFactory->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($factories_list->factory->Visible) { // factory ?>
		<td data-name="factory">
<span id="el$rowindex$_factories_factory" class="form-group factories_factory">
<input type="text" data-table="factories" data-field="x_factory" name="x<?php echo $factories_list->RowIndex ?>_factory" id="x<?php echo $factories_list->RowIndex ?>_factory" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($factories_list->factory->getPlaceHolder()) ?>" value="<?php echo $factories_list->factory->EditValue ?>"<?php echo $factories_list->factory->editAttributes() ?>>
</span>
<input type="hidden" data-table="factories" data-field="x_factory" name="o<?php echo $factories_list->RowIndex ?>_factory" id="o<?php echo $factories_list->RowIndex ?>_factory" value="<?php echo HtmlEncode($factories_list->factory->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$factories_list->ListOptions->render("body", "right", $factories_list->RowIndex);
?>
<script>
loadjs.ready(["ffactorieslist", "load"], function() {
	ffactorieslist.updateLists(<?php echo $factories_list->RowIndex ?>);
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
<?php if ($factories_list->isGridEdit()) { ?>
<?php if ($factories->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="action" id="action" value="gridoverwrite">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<?php } ?>
<input type="hidden" name="<?php echo $factories_list->FormKeyCountName ?>" id="<?php echo $factories_list->FormKeyCountName ?>" value="<?php echo $factories_list->KeyCount ?>">
<?php echo $factories_list->MultiSelectKey ?>
<?php } ?>
<?php if (!$factories->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($factories_list->Recordset)
	$factories_list->Recordset->Close();
?>
<?php if (!$factories_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$factories_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $factories_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $factories_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($factories_list->TotalRecords == 0 && !$factories->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $factories_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$factories_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$factories_list->isExport()) { ?>
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
$factories_list->terminate();
?>