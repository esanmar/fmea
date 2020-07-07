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
$severity_list = new severity_list();

// Run the page
$severity_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$severity_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$severity_list->isExport()) { ?>
<script>
var fseveritylist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	fseveritylist = currentForm = new ew.Form("fseveritylist", "list");
	fseveritylist.formKeyCountName = '<?php echo $severity_list->FormKeyCountName ?>';

	// Validate form
	fseveritylist.validate = function() {
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
			<?php if ($severity_list->idSeverity->Required) { ?>
				elm = this.getElements("x" + infix + "_idSeverity");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $severity_list->idSeverity->caption(), $severity_list->idSeverity->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($severity_list->effect->Required) { ?>
				elm = this.getElements("x" + infix + "_effect");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $severity_list->effect->caption(), $severity_list->effect->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($severity_list->severityonclient->Required) { ?>
				elm = this.getElements("x" + infix + "_severityonclient");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $severity_list->severityonclient->caption(), $severity_list->severityonclient->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($severity_list->internalseverity->Required) { ?>
				elm = this.getElements("x" + infix + "_internalseverity");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $severity_list->internalseverity->caption(), $severity_list->internalseverity->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($severity_list->color->Required) { ?>
				elm = this.getElements("x" + infix + "_color");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $severity_list->color->caption(), $severity_list->color->RequiredErrorMessage)) ?>");
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
	fseveritylist.emptyRow = function(infix) {
		var fobj = this._form;
		if (ew.valueChanged(fobj, infix, "effect", false)) return false;
		if (ew.valueChanged(fobj, infix, "severityonclient", false)) return false;
		if (ew.valueChanged(fobj, infix, "internalseverity", false)) return false;
		if (ew.valueChanged(fobj, infix, "color", false)) return false;
		return true;
	}

	// Form_CustomValidate
	fseveritylist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fseveritylist.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fseveritylist");
});
var fseveritylistsrch;
loadjs.ready("head", function() {

	// Form object for search
	fseveritylistsrch = currentSearchForm = new ew.Form("fseveritylistsrch");

	// Dynamic selection lists
	// Filters

	fseveritylistsrch.filterList = <?php echo $severity_list->getFilterList() ?>;
	loadjs.done("fseveritylistsrch");
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
<?php if (!$severity_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($severity_list->TotalRecords > 0 && $severity_list->ExportOptions->visible()) { ?>
<?php $severity_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($severity_list->ImportOptions->visible()) { ?>
<?php $severity_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($severity_list->SearchOptions->visible()) { ?>
<?php $severity_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($severity_list->FilterOptions->visible()) { ?>
<?php $severity_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$severity_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$severity_list->isExport() && !$severity->CurrentAction) { ?>
<form name="fseveritylistsrch" id="fseveritylistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="fseveritylistsrch-search-panel" class="<?php echo $severity_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="severity">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $severity_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($severity_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($severity_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $severity_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($severity_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($severity_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($severity_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($severity_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $severity_list->showPageHeader(); ?>
<?php
$severity_list->showMessage();
?>
<?php if ($severity_list->TotalRecords > 0 || $severity->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($severity_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> severity">
<?php if (!$severity_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$severity_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $severity_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $severity_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fseveritylist" id="fseveritylist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="severity">
<div id="gmp_severity" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($severity_list->TotalRecords > 0 || $severity_list->isGridEdit()) { ?>
<table id="tbl_severitylist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$severity->RowType = ROWTYPE_HEADER;

// Render list options
$severity_list->renderListOptions();

// Render list options (header, left)
$severity_list->ListOptions->render("header", "left");
?>
<?php if ($severity_list->idSeverity->Visible) { // idSeverity ?>
	<?php if ($severity_list->SortUrl($severity_list->idSeverity) == "") { ?>
		<th data-name="idSeverity" class="<?php echo $severity_list->idSeverity->headerCellClass() ?>"><div id="elh_severity_idSeverity" class="severity_idSeverity"><div class="ew-table-header-caption"><?php echo $severity_list->idSeverity->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idSeverity" class="<?php echo $severity_list->idSeverity->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $severity_list->SortUrl($severity_list->idSeverity) ?>', 2);"><div id="elh_severity_idSeverity" class="severity_idSeverity">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $severity_list->idSeverity->caption() ?></span><span class="ew-table-header-sort"><?php if ($severity_list->idSeverity->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($severity_list->idSeverity->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($severity_list->effect->Visible) { // effect ?>
	<?php if ($severity_list->SortUrl($severity_list->effect) == "") { ?>
		<th data-name="effect" class="<?php echo $severity_list->effect->headerCellClass() ?>"><div id="elh_severity_effect" class="severity_effect"><div class="ew-table-header-caption"><?php echo $severity_list->effect->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="effect" class="<?php echo $severity_list->effect->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $severity_list->SortUrl($severity_list->effect) ?>', 2);"><div id="elh_severity_effect" class="severity_effect">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $severity_list->effect->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($severity_list->effect->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($severity_list->effect->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($severity_list->severityonclient->Visible) { // severityonclient ?>
	<?php if ($severity_list->SortUrl($severity_list->severityonclient) == "") { ?>
		<th data-name="severityonclient" class="<?php echo $severity_list->severityonclient->headerCellClass() ?>"><div id="elh_severity_severityonclient" class="severity_severityonclient"><div class="ew-table-header-caption"><?php echo $severity_list->severityonclient->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="severityonclient" class="<?php echo $severity_list->severityonclient->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $severity_list->SortUrl($severity_list->severityonclient) ?>', 2);"><div id="elh_severity_severityonclient" class="severity_severityonclient">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $severity_list->severityonclient->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($severity_list->severityonclient->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($severity_list->severityonclient->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($severity_list->internalseverity->Visible) { // internalseverity ?>
	<?php if ($severity_list->SortUrl($severity_list->internalseverity) == "") { ?>
		<th data-name="internalseverity" class="<?php echo $severity_list->internalseverity->headerCellClass() ?>"><div id="elh_severity_internalseverity" class="severity_internalseverity"><div class="ew-table-header-caption"><?php echo $severity_list->internalseverity->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="internalseverity" class="<?php echo $severity_list->internalseverity->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $severity_list->SortUrl($severity_list->internalseverity) ?>', 2);"><div id="elh_severity_internalseverity" class="severity_internalseverity">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $severity_list->internalseverity->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($severity_list->internalseverity->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($severity_list->internalseverity->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($severity_list->color->Visible) { // color ?>
	<?php if ($severity_list->SortUrl($severity_list->color) == "") { ?>
		<th data-name="color" class="<?php echo $severity_list->color->headerCellClass() ?>"><div id="elh_severity_color" class="severity_color"><div class="ew-table-header-caption"><?php echo $severity_list->color->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="color" class="<?php echo $severity_list->color->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $severity_list->SortUrl($severity_list->color) ?>', 2);"><div id="elh_severity_color" class="severity_color">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $severity_list->color->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($severity_list->color->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($severity_list->color->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$severity_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($severity_list->ExportAll && $severity_list->isExport()) {
	$severity_list->StopRecord = $severity_list->TotalRecords;
} else {

	// Set the last record to display
	if ($severity_list->TotalRecords > $severity_list->StartRecord + $severity_list->DisplayRecords - 1)
		$severity_list->StopRecord = $severity_list->StartRecord + $severity_list->DisplayRecords - 1;
	else
		$severity_list->StopRecord = $severity_list->TotalRecords;
}

// Restore number of post back records
if ($CurrentForm && ($severity->isConfirm() || $severity_list->EventCancelled)) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($severity_list->FormKeyCountName) && ($severity_list->isGridAdd() || $severity_list->isGridEdit() || $severity->isConfirm())) {
		$severity_list->KeyCount = $CurrentForm->getValue($severity_list->FormKeyCountName);
		$severity_list->StopRecord = $severity_list->StartRecord + $severity_list->KeyCount - 1;
	}
}
$severity_list->RecordCount = $severity_list->StartRecord - 1;
if ($severity_list->Recordset && !$severity_list->Recordset->EOF) {
	$severity_list->Recordset->moveFirst();
	$selectLimit = $severity_list->UseSelectLimit;
	if (!$selectLimit && $severity_list->StartRecord > 1)
		$severity_list->Recordset->move($severity_list->StartRecord - 1);
} elseif (!$severity->AllowAddDeleteRow && $severity_list->StopRecord == 0) {
	$severity_list->StopRecord = $severity->GridAddRowCount;
}

// Initialize aggregate
$severity->RowType = ROWTYPE_AGGREGATEINIT;
$severity->resetAttributes();
$severity_list->renderRow();
$severity_list->EditRowCount = 0;
if ($severity_list->isEdit())
	$severity_list->RowIndex = 1;
if ($severity_list->isGridAdd())
	$severity_list->RowIndex = 0;
if ($severity_list->isGridEdit())
	$severity_list->RowIndex = 0;
while ($severity_list->RecordCount < $severity_list->StopRecord) {
	$severity_list->RecordCount++;
	if ($severity_list->RecordCount >= $severity_list->StartRecord) {
		$severity_list->RowCount++;
		if ($severity_list->isGridAdd() || $severity_list->isGridEdit() || $severity->isConfirm()) {
			$severity_list->RowIndex++;
			$CurrentForm->Index = $severity_list->RowIndex;
			if ($CurrentForm->hasValue($severity_list->FormActionName) && ($severity->isConfirm() || $severity_list->EventCancelled))
				$severity_list->RowAction = strval($CurrentForm->getValue($severity_list->FormActionName));
			elseif ($severity_list->isGridAdd())
				$severity_list->RowAction = "insert";
			else
				$severity_list->RowAction = "";
		}

		// Set up key count
		$severity_list->KeyCount = $severity_list->RowIndex;

		// Init row class and style
		$severity->resetAttributes();
		$severity->CssClass = "";
		if ($severity_list->isGridAdd()) {
			$severity_list->loadRowValues(); // Load default values
		} else {
			$severity_list->loadRowValues($severity_list->Recordset); // Load row values
		}
		$severity->RowType = ROWTYPE_VIEW; // Render view
		if ($severity_list->isGridAdd()) // Grid add
			$severity->RowType = ROWTYPE_ADD; // Render add
		if ($severity_list->isGridAdd() && $severity->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$severity_list->restoreCurrentRowFormValues($severity_list->RowIndex); // Restore form values
		if ($severity_list->isEdit()) {
			if ($severity_list->checkInlineEditKey() && $severity_list->EditRowCount == 0) { // Inline edit
				$severity->RowType = ROWTYPE_EDIT; // Render edit
				if (!$severity->EventCancelled)
					$severity_list->HashValue = $severity_list->getRowHash($severity_list->Recordset); // Get hash value for record
			}
		}
		if ($severity_list->isGridEdit()) { // Grid edit
			if ($severity->EventCancelled)
				$severity_list->restoreCurrentRowFormValues($severity_list->RowIndex); // Restore form values
			if ($severity_list->RowAction == "insert")
				$severity->RowType = ROWTYPE_ADD; // Render add
			else
				$severity->RowType = ROWTYPE_EDIT; // Render edit
			if (!$severity->EventCancelled)
				$severity_list->HashValue = $severity_list->getRowHash($severity_list->Recordset); // Get hash value for record
		}
		if ($severity_list->isEdit() && $severity->RowType == ROWTYPE_EDIT && $severity->EventCancelled) { // Update failed
			$CurrentForm->Index = 1;
			$severity_list->restoreFormValues(); // Restore form values
		}
		if ($severity_list->isGridEdit() && ($severity->RowType == ROWTYPE_EDIT || $severity->RowType == ROWTYPE_ADD) && $severity->EventCancelled) // Update failed
			$severity_list->restoreCurrentRowFormValues($severity_list->RowIndex); // Restore form values
		if ($severity->RowType == ROWTYPE_EDIT) // Edit row
			$severity_list->EditRowCount++;

		// Set up row id / data-rowindex
		$severity->RowAttrs->merge(["data-rowindex" => $severity_list->RowCount, "id" => "r" . $severity_list->RowCount . "_severity", "data-rowtype" => $severity->RowType]);

		// Render row
		$severity_list->renderRow();

		// Render list options
		$severity_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($severity_list->RowAction != "delete" && $severity_list->RowAction != "insertdelete" && !($severity_list->RowAction == "insert" && $severity->isConfirm() && $severity_list->emptyRow())) {
?>
	<tr <?php echo $severity->rowAttributes() ?>>
<?php

// Render list options (body, left)
$severity_list->ListOptions->render("body", "left", $severity_list->RowCount);
?>
	<?php if ($severity_list->idSeverity->Visible) { // idSeverity ?>
		<td data-name="idSeverity" <?php echo $severity_list->idSeverity->cellAttributes() ?>>
<?php if ($severity->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $severity_list->RowCount ?>_severity_idSeverity" class="form-group"></span>
<input type="hidden" data-table="severity" data-field="x_idSeverity" name="o<?php echo $severity_list->RowIndex ?>_idSeverity" id="o<?php echo $severity_list->RowIndex ?>_idSeverity" value="<?php echo HtmlEncode($severity_list->idSeverity->OldValue) ?>">
<?php } ?>
<?php if ($severity->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $severity_list->RowCount ?>_severity_idSeverity" class="form-group">
<span<?php echo $severity_list->idSeverity->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($severity_list->idSeverity->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="severity" data-field="x_idSeverity" name="x<?php echo $severity_list->RowIndex ?>_idSeverity" id="x<?php echo $severity_list->RowIndex ?>_idSeverity" value="<?php echo HtmlEncode($severity_list->idSeverity->CurrentValue) ?>">
<?php } ?>
<?php if ($severity->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $severity_list->RowCount ?>_severity_idSeverity">
<span<?php echo $severity_list->idSeverity->viewAttributes() ?>><?php echo $severity_list->idSeverity->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($severity_list->effect->Visible) { // effect ?>
		<td data-name="effect" <?php echo $severity_list->effect->cellAttributes() ?>>
<?php if ($severity->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $severity_list->RowCount ?>_severity_effect" class="form-group">
<input type="text" data-table="severity" data-field="x_effect" name="x<?php echo $severity_list->RowIndex ?>_effect" id="x<?php echo $severity_list->RowIndex ?>_effect" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($severity_list->effect->getPlaceHolder()) ?>" value="<?php echo $severity_list->effect->EditValue ?>"<?php echo $severity_list->effect->editAttributes() ?>>
</span>
<input type="hidden" data-table="severity" data-field="x_effect" name="o<?php echo $severity_list->RowIndex ?>_effect" id="o<?php echo $severity_list->RowIndex ?>_effect" value="<?php echo HtmlEncode($severity_list->effect->OldValue) ?>">
<?php } ?>
<?php if ($severity->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $severity_list->RowCount ?>_severity_effect" class="form-group">
<input type="text" data-table="severity" data-field="x_effect" name="x<?php echo $severity_list->RowIndex ?>_effect" id="x<?php echo $severity_list->RowIndex ?>_effect" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($severity_list->effect->getPlaceHolder()) ?>" value="<?php echo $severity_list->effect->EditValue ?>"<?php echo $severity_list->effect->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($severity->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $severity_list->RowCount ?>_severity_effect">
<span<?php echo $severity_list->effect->viewAttributes() ?>><?php echo $severity_list->effect->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($severity_list->severityonclient->Visible) { // severityonclient ?>
		<td data-name="severityonclient" <?php echo $severity_list->severityonclient->cellAttributes() ?>>
<?php if ($severity->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $severity_list->RowCount ?>_severity_severityonclient" class="form-group">
<textarea data-table="severity" data-field="x_severityonclient" name="x<?php echo $severity_list->RowIndex ?>_severityonclient" id="x<?php echo $severity_list->RowIndex ?>_severityonclient" cols="35" rows="4" placeholder="<?php echo HtmlEncode($severity_list->severityonclient->getPlaceHolder()) ?>"<?php echo $severity_list->severityonclient->editAttributes() ?>><?php echo $severity_list->severityonclient->EditValue ?></textarea>
</span>
<input type="hidden" data-table="severity" data-field="x_severityonclient" name="o<?php echo $severity_list->RowIndex ?>_severityonclient" id="o<?php echo $severity_list->RowIndex ?>_severityonclient" value="<?php echo HtmlEncode($severity_list->severityonclient->OldValue) ?>">
<?php } ?>
<?php if ($severity->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $severity_list->RowCount ?>_severity_severityonclient" class="form-group">
<textarea data-table="severity" data-field="x_severityonclient" name="x<?php echo $severity_list->RowIndex ?>_severityonclient" id="x<?php echo $severity_list->RowIndex ?>_severityonclient" cols="35" rows="4" placeholder="<?php echo HtmlEncode($severity_list->severityonclient->getPlaceHolder()) ?>"<?php echo $severity_list->severityonclient->editAttributes() ?>><?php echo $severity_list->severityonclient->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($severity->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $severity_list->RowCount ?>_severity_severityonclient">
<span<?php echo $severity_list->severityonclient->viewAttributes() ?>><?php echo $severity_list->severityonclient->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($severity_list->internalseverity->Visible) { // internalseverity ?>
		<td data-name="internalseverity" <?php echo $severity_list->internalseverity->cellAttributes() ?>>
<?php if ($severity->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $severity_list->RowCount ?>_severity_internalseverity" class="form-group">
<textarea data-table="severity" data-field="x_internalseverity" name="x<?php echo $severity_list->RowIndex ?>_internalseverity" id="x<?php echo $severity_list->RowIndex ?>_internalseverity" cols="35" rows="4" placeholder="<?php echo HtmlEncode($severity_list->internalseverity->getPlaceHolder()) ?>"<?php echo $severity_list->internalseverity->editAttributes() ?>><?php echo $severity_list->internalseverity->EditValue ?></textarea>
</span>
<input type="hidden" data-table="severity" data-field="x_internalseverity" name="o<?php echo $severity_list->RowIndex ?>_internalseverity" id="o<?php echo $severity_list->RowIndex ?>_internalseverity" value="<?php echo HtmlEncode($severity_list->internalseverity->OldValue) ?>">
<?php } ?>
<?php if ($severity->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $severity_list->RowCount ?>_severity_internalseverity" class="form-group">
<textarea data-table="severity" data-field="x_internalseverity" name="x<?php echo $severity_list->RowIndex ?>_internalseverity" id="x<?php echo $severity_list->RowIndex ?>_internalseverity" cols="35" rows="4" placeholder="<?php echo HtmlEncode($severity_list->internalseverity->getPlaceHolder()) ?>"<?php echo $severity_list->internalseverity->editAttributes() ?>><?php echo $severity_list->internalseverity->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($severity->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $severity_list->RowCount ?>_severity_internalseverity">
<span<?php echo $severity_list->internalseverity->viewAttributes() ?>><?php echo $severity_list->internalseverity->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($severity_list->color->Visible) { // color ?>
		<td data-name="color" <?php echo $severity_list->color->cellAttributes() ?>>
<?php if ($severity->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $severity_list->RowCount ?>_severity_color" class="form-group">
<input type="text" data-table="severity" data-field="x_color" name="x<?php echo $severity_list->RowIndex ?>_color" id="x<?php echo $severity_list->RowIndex ?>_color" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($severity_list->color->getPlaceHolder()) ?>" value="<?php echo $severity_list->color->EditValue ?>"<?php echo $severity_list->color->editAttributes() ?>>

<script>
loadjs.ready("head", function() {
	jQuery("[id='x<?php echo $severity_list->RowIndex ?>_color']:not([id*='$rowindex$'])").colorpicker({ format: "hex" });
});
</script>

</span>
<input type="hidden" data-table="severity" data-field="x_color" name="o<?php echo $severity_list->RowIndex ?>_color" id="o<?php echo $severity_list->RowIndex ?>_color" value="<?php echo HtmlEncode($severity_list->color->OldValue) ?>">
<?php } ?>
<?php if ($severity->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $severity_list->RowCount ?>_severity_color" class="form-group">
<input type="text" data-table="severity" data-field="x_color" name="x<?php echo $severity_list->RowIndex ?>_color" id="x<?php echo $severity_list->RowIndex ?>_color" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($severity_list->color->getPlaceHolder()) ?>" value="<?php echo $severity_list->color->EditValue ?>"<?php echo $severity_list->color->editAttributes() ?>>

<script>
loadjs.ready("head", function() {
	jQuery("[id='x<?php echo $severity_list->RowIndex ?>_color']:not([id*='$rowindex$'])").colorpicker({ format: "hex" });
});
</script>

</span>
<?php } ?>
<?php if ($severity->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $severity_list->RowCount ?>_severity_color">
<span<?php echo $severity_list->color->viewAttributes() ?>><?php echo $severity_list->color->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$severity_list->ListOptions->render("body", "right", $severity_list->RowCount);
?>
	</tr>
<?php if ($severity->RowType == ROWTYPE_ADD || $severity->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fseveritylist", "load"], function() {
	fseveritylist.updateLists(<?php echo $severity_list->RowIndex ?>);
});
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$severity_list->isGridAdd())
		if (!$severity_list->Recordset->EOF)
			$severity_list->Recordset->moveNext();
}
?>
<?php
	if ($severity_list->isGridAdd() || $severity_list->isGridEdit()) {
		$severity_list->RowIndex = '$rowindex$';
		$severity_list->loadRowValues();

		// Set row properties
		$severity->resetAttributes();
		$severity->RowAttrs->merge(["data-rowindex" => $severity_list->RowIndex, "id" => "r0_severity", "data-rowtype" => ROWTYPE_ADD]);
		$severity->RowAttrs->appendClass("ew-template");
		$severity->RowType = ROWTYPE_ADD;

		// Render row
		$severity_list->renderRow();

		// Render list options
		$severity_list->renderListOptions();
		$severity_list->StartRowCount = 0;
?>
	<tr <?php echo $severity->rowAttributes() ?>>
<?php

// Render list options (body, left)
$severity_list->ListOptions->render("body", "left", $severity_list->RowIndex);
?>
	<?php if ($severity_list->idSeverity->Visible) { // idSeverity ?>
		<td data-name="idSeverity">
<span id="el$rowindex$_severity_idSeverity" class="form-group severity_idSeverity"></span>
<input type="hidden" data-table="severity" data-field="x_idSeverity" name="o<?php echo $severity_list->RowIndex ?>_idSeverity" id="o<?php echo $severity_list->RowIndex ?>_idSeverity" value="<?php echo HtmlEncode($severity_list->idSeverity->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($severity_list->effect->Visible) { // effect ?>
		<td data-name="effect">
<span id="el$rowindex$_severity_effect" class="form-group severity_effect">
<input type="text" data-table="severity" data-field="x_effect" name="x<?php echo $severity_list->RowIndex ?>_effect" id="x<?php echo $severity_list->RowIndex ?>_effect" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($severity_list->effect->getPlaceHolder()) ?>" value="<?php echo $severity_list->effect->EditValue ?>"<?php echo $severity_list->effect->editAttributes() ?>>
</span>
<input type="hidden" data-table="severity" data-field="x_effect" name="o<?php echo $severity_list->RowIndex ?>_effect" id="o<?php echo $severity_list->RowIndex ?>_effect" value="<?php echo HtmlEncode($severity_list->effect->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($severity_list->severityonclient->Visible) { // severityonclient ?>
		<td data-name="severityonclient">
<span id="el$rowindex$_severity_severityonclient" class="form-group severity_severityonclient">
<textarea data-table="severity" data-field="x_severityonclient" name="x<?php echo $severity_list->RowIndex ?>_severityonclient" id="x<?php echo $severity_list->RowIndex ?>_severityonclient" cols="35" rows="4" placeholder="<?php echo HtmlEncode($severity_list->severityonclient->getPlaceHolder()) ?>"<?php echo $severity_list->severityonclient->editAttributes() ?>><?php echo $severity_list->severityonclient->EditValue ?></textarea>
</span>
<input type="hidden" data-table="severity" data-field="x_severityonclient" name="o<?php echo $severity_list->RowIndex ?>_severityonclient" id="o<?php echo $severity_list->RowIndex ?>_severityonclient" value="<?php echo HtmlEncode($severity_list->severityonclient->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($severity_list->internalseverity->Visible) { // internalseverity ?>
		<td data-name="internalseverity">
<span id="el$rowindex$_severity_internalseverity" class="form-group severity_internalseverity">
<textarea data-table="severity" data-field="x_internalseverity" name="x<?php echo $severity_list->RowIndex ?>_internalseverity" id="x<?php echo $severity_list->RowIndex ?>_internalseverity" cols="35" rows="4" placeholder="<?php echo HtmlEncode($severity_list->internalseverity->getPlaceHolder()) ?>"<?php echo $severity_list->internalseverity->editAttributes() ?>><?php echo $severity_list->internalseverity->EditValue ?></textarea>
</span>
<input type="hidden" data-table="severity" data-field="x_internalseverity" name="o<?php echo $severity_list->RowIndex ?>_internalseverity" id="o<?php echo $severity_list->RowIndex ?>_internalseverity" value="<?php echo HtmlEncode($severity_list->internalseverity->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($severity_list->color->Visible) { // color ?>
		<td data-name="color">
<span id="el$rowindex$_severity_color" class="form-group severity_color">
<input type="text" data-table="severity" data-field="x_color" name="x<?php echo $severity_list->RowIndex ?>_color" id="x<?php echo $severity_list->RowIndex ?>_color" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($severity_list->color->getPlaceHolder()) ?>" value="<?php echo $severity_list->color->EditValue ?>"<?php echo $severity_list->color->editAttributes() ?>>

<script>
loadjs.ready("head", function() {
	jQuery("[id='x<?php echo $severity_list->RowIndex ?>_color']:not([id*='$rowindex$'])").colorpicker({ format: "hex" });
});
</script>

</span>
<input type="hidden" data-table="severity" data-field="x_color" name="o<?php echo $severity_list->RowIndex ?>_color" id="o<?php echo $severity_list->RowIndex ?>_color" value="<?php echo HtmlEncode($severity_list->color->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$severity_list->ListOptions->render("body", "right", $severity_list->RowIndex);
?>
<script>
loadjs.ready(["fseveritylist", "load"], function() {
	fseveritylist.updateLists(<?php echo $severity_list->RowIndex ?>);
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
<?php if ($severity_list->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?php echo $severity_list->FormKeyCountName ?>" id="<?php echo $severity_list->FormKeyCountName ?>" value="<?php echo $severity_list->KeyCount ?>">
<?php echo $severity_list->MultiSelectKey ?>
<?php } ?>
<?php if ($severity_list->isEdit()) { ?>
<input type="hidden" name="<?php echo $severity_list->FormKeyCountName ?>" id="<?php echo $severity_list->FormKeyCountName ?>" value="<?php echo $severity_list->KeyCount ?>">
<?php } ?>
<?php if ($severity_list->isGridEdit()) { ?>
<?php if ($severity->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="action" id="action" value="gridoverwrite">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<?php } ?>
<input type="hidden" name="<?php echo $severity_list->FormKeyCountName ?>" id="<?php echo $severity_list->FormKeyCountName ?>" value="<?php echo $severity_list->KeyCount ?>">
<?php echo $severity_list->MultiSelectKey ?>
<?php } ?>
<?php if (!$severity->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($severity_list->Recordset)
	$severity_list->Recordset->Close();
?>
<?php if (!$severity_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$severity_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $severity_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $severity_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($severity_list->TotalRecords == 0 && !$severity->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $severity_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$severity_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$severity_list->isExport()) { ?>
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
$severity_list->terminate();
?>