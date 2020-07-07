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
$occurrence_list = new occurrence_list();

// Run the page
$occurrence_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$occurrence_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$occurrence_list->isExport()) { ?>
<script>
var foccurrencelist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	foccurrencelist = currentForm = new ew.Form("foccurrencelist", "list");
	foccurrencelist.formKeyCountName = '<?php echo $occurrence_list->FormKeyCountName ?>';

	// Validate form
	foccurrencelist.validate = function() {
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
			<?php if ($occurrence_list->idOccurrence->Required) { ?>
				elm = this.getElements("x" + infix + "_idOccurrence");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $occurrence_list->idOccurrence->caption(), $occurrence_list->idOccurrence->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($occurrence_list->probability->Required) { ?>
				elm = this.getElements("x" + infix + "_probability");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $occurrence_list->probability->caption(), $occurrence_list->probability->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($occurrence_list->description->Required) { ?>
				elm = this.getElements("x" + infix + "_description");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $occurrence_list->description->caption(), $occurrence_list->description->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($occurrence_list->likelihood->Required) { ?>
				elm = this.getElements("x" + infix + "_likelihood");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $occurrence_list->likelihood->caption(), $occurrence_list->likelihood->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($occurrence_list->timebased->Required) { ?>
				elm = this.getElements("x" + infix + "_timebased");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $occurrence_list->timebased->caption(), $occurrence_list->timebased->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($occurrence_list->color->Required) { ?>
				elm = this.getElements("x" + infix + "_color");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $occurrence_list->color->caption(), $occurrence_list->color->RequiredErrorMessage)) ?>");
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
	foccurrencelist.emptyRow = function(infix) {
		var fobj = this._form;
		if (ew.valueChanged(fobj, infix, "probability", false)) return false;
		if (ew.valueChanged(fobj, infix, "description", false)) return false;
		if (ew.valueChanged(fobj, infix, "likelihood", false)) return false;
		if (ew.valueChanged(fobj, infix, "timebased", false)) return false;
		if (ew.valueChanged(fobj, infix, "color", false)) return false;
		return true;
	}

	// Form_CustomValidate
	foccurrencelist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	foccurrencelist.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("foccurrencelist");
});
var foccurrencelistsrch;
loadjs.ready("head", function() {

	// Form object for search
	foccurrencelistsrch = currentSearchForm = new ew.Form("foccurrencelistsrch");

	// Dynamic selection lists
	// Filters

	foccurrencelistsrch.filterList = <?php echo $occurrence_list->getFilterList() ?>;
	loadjs.done("foccurrencelistsrch");
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
<?php if (!$occurrence_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($occurrence_list->TotalRecords > 0 && $occurrence_list->ExportOptions->visible()) { ?>
<?php $occurrence_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($occurrence_list->ImportOptions->visible()) { ?>
<?php $occurrence_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($occurrence_list->SearchOptions->visible()) { ?>
<?php $occurrence_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($occurrence_list->FilterOptions->visible()) { ?>
<?php $occurrence_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$occurrence_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$occurrence_list->isExport() && !$occurrence->CurrentAction) { ?>
<form name="foccurrencelistsrch" id="foccurrencelistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="foccurrencelistsrch-search-panel" class="<?php echo $occurrence_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="occurrence">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $occurrence_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($occurrence_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($occurrence_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $occurrence_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($occurrence_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($occurrence_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($occurrence_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($occurrence_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $occurrence_list->showPageHeader(); ?>
<?php
$occurrence_list->showMessage();
?>
<?php if ($occurrence_list->TotalRecords > 0 || $occurrence->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($occurrence_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> occurrence">
<?php if (!$occurrence_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$occurrence_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $occurrence_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $occurrence_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="foccurrencelist" id="foccurrencelist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="occurrence">
<div id="gmp_occurrence" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($occurrence_list->TotalRecords > 0 || $occurrence_list->isGridEdit()) { ?>
<table id="tbl_occurrencelist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$occurrence->RowType = ROWTYPE_HEADER;

// Render list options
$occurrence_list->renderListOptions();

// Render list options (header, left)
$occurrence_list->ListOptions->render("header", "left");
?>
<?php if ($occurrence_list->idOccurrence->Visible) { // idOccurrence ?>
	<?php if ($occurrence_list->SortUrl($occurrence_list->idOccurrence) == "") { ?>
		<th data-name="idOccurrence" class="<?php echo $occurrence_list->idOccurrence->headerCellClass() ?>"><div id="elh_occurrence_idOccurrence" class="occurrence_idOccurrence"><div class="ew-table-header-caption"><?php echo $occurrence_list->idOccurrence->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idOccurrence" class="<?php echo $occurrence_list->idOccurrence->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $occurrence_list->SortUrl($occurrence_list->idOccurrence) ?>', 2);"><div id="elh_occurrence_idOccurrence" class="occurrence_idOccurrence">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $occurrence_list->idOccurrence->caption() ?></span><span class="ew-table-header-sort"><?php if ($occurrence_list->idOccurrence->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($occurrence_list->idOccurrence->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($occurrence_list->probability->Visible) { // probability ?>
	<?php if ($occurrence_list->SortUrl($occurrence_list->probability) == "") { ?>
		<th data-name="probability" class="<?php echo $occurrence_list->probability->headerCellClass() ?>"><div id="elh_occurrence_probability" class="occurrence_probability"><div class="ew-table-header-caption"><?php echo $occurrence_list->probability->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="probability" class="<?php echo $occurrence_list->probability->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $occurrence_list->SortUrl($occurrence_list->probability) ?>', 2);"><div id="elh_occurrence_probability" class="occurrence_probability">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $occurrence_list->probability->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($occurrence_list->probability->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($occurrence_list->probability->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($occurrence_list->description->Visible) { // description ?>
	<?php if ($occurrence_list->SortUrl($occurrence_list->description) == "") { ?>
		<th data-name="description" class="<?php echo $occurrence_list->description->headerCellClass() ?>"><div id="elh_occurrence_description" class="occurrence_description"><div class="ew-table-header-caption"><?php echo $occurrence_list->description->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="description" class="<?php echo $occurrence_list->description->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $occurrence_list->SortUrl($occurrence_list->description) ?>', 2);"><div id="elh_occurrence_description" class="occurrence_description">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $occurrence_list->description->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($occurrence_list->description->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($occurrence_list->description->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($occurrence_list->likelihood->Visible) { // likelihood ?>
	<?php if ($occurrence_list->SortUrl($occurrence_list->likelihood) == "") { ?>
		<th data-name="likelihood" class="<?php echo $occurrence_list->likelihood->headerCellClass() ?>"><div id="elh_occurrence_likelihood" class="occurrence_likelihood"><div class="ew-table-header-caption"><?php echo $occurrence_list->likelihood->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="likelihood" class="<?php echo $occurrence_list->likelihood->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $occurrence_list->SortUrl($occurrence_list->likelihood) ?>', 2);"><div id="elh_occurrence_likelihood" class="occurrence_likelihood">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $occurrence_list->likelihood->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($occurrence_list->likelihood->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($occurrence_list->likelihood->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($occurrence_list->timebased->Visible) { // timebased ?>
	<?php if ($occurrence_list->SortUrl($occurrence_list->timebased) == "") { ?>
		<th data-name="timebased" class="<?php echo $occurrence_list->timebased->headerCellClass() ?>"><div id="elh_occurrence_timebased" class="occurrence_timebased"><div class="ew-table-header-caption"><?php echo $occurrence_list->timebased->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="timebased" class="<?php echo $occurrence_list->timebased->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $occurrence_list->SortUrl($occurrence_list->timebased) ?>', 2);"><div id="elh_occurrence_timebased" class="occurrence_timebased">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $occurrence_list->timebased->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($occurrence_list->timebased->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($occurrence_list->timebased->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($occurrence_list->color->Visible) { // color ?>
	<?php if ($occurrence_list->SortUrl($occurrence_list->color) == "") { ?>
		<th data-name="color" class="<?php echo $occurrence_list->color->headerCellClass() ?>"><div id="elh_occurrence_color" class="occurrence_color"><div class="ew-table-header-caption"><?php echo $occurrence_list->color->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="color" class="<?php echo $occurrence_list->color->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $occurrence_list->SortUrl($occurrence_list->color) ?>', 2);"><div id="elh_occurrence_color" class="occurrence_color">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $occurrence_list->color->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($occurrence_list->color->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($occurrence_list->color->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$occurrence_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($occurrence_list->ExportAll && $occurrence_list->isExport()) {
	$occurrence_list->StopRecord = $occurrence_list->TotalRecords;
} else {

	// Set the last record to display
	if ($occurrence_list->TotalRecords > $occurrence_list->StartRecord + $occurrence_list->DisplayRecords - 1)
		$occurrence_list->StopRecord = $occurrence_list->StartRecord + $occurrence_list->DisplayRecords - 1;
	else
		$occurrence_list->StopRecord = $occurrence_list->TotalRecords;
}

// Restore number of post back records
if ($CurrentForm && ($occurrence->isConfirm() || $occurrence_list->EventCancelled)) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($occurrence_list->FormKeyCountName) && ($occurrence_list->isGridAdd() || $occurrence_list->isGridEdit() || $occurrence->isConfirm())) {
		$occurrence_list->KeyCount = $CurrentForm->getValue($occurrence_list->FormKeyCountName);
		$occurrence_list->StopRecord = $occurrence_list->StartRecord + $occurrence_list->KeyCount - 1;
	}
}
$occurrence_list->RecordCount = $occurrence_list->StartRecord - 1;
if ($occurrence_list->Recordset && !$occurrence_list->Recordset->EOF) {
	$occurrence_list->Recordset->moveFirst();
	$selectLimit = $occurrence_list->UseSelectLimit;
	if (!$selectLimit && $occurrence_list->StartRecord > 1)
		$occurrence_list->Recordset->move($occurrence_list->StartRecord - 1);
} elseif (!$occurrence->AllowAddDeleteRow && $occurrence_list->StopRecord == 0) {
	$occurrence_list->StopRecord = $occurrence->GridAddRowCount;
}

// Initialize aggregate
$occurrence->RowType = ROWTYPE_AGGREGATEINIT;
$occurrence->resetAttributes();
$occurrence_list->renderRow();
$occurrence_list->EditRowCount = 0;
if ($occurrence_list->isEdit())
	$occurrence_list->RowIndex = 1;
if ($occurrence_list->isGridAdd())
	$occurrence_list->RowIndex = 0;
if ($occurrence_list->isGridEdit())
	$occurrence_list->RowIndex = 0;
while ($occurrence_list->RecordCount < $occurrence_list->StopRecord) {
	$occurrence_list->RecordCount++;
	if ($occurrence_list->RecordCount >= $occurrence_list->StartRecord) {
		$occurrence_list->RowCount++;
		if ($occurrence_list->isGridAdd() || $occurrence_list->isGridEdit() || $occurrence->isConfirm()) {
			$occurrence_list->RowIndex++;
			$CurrentForm->Index = $occurrence_list->RowIndex;
			if ($CurrentForm->hasValue($occurrence_list->FormActionName) && ($occurrence->isConfirm() || $occurrence_list->EventCancelled))
				$occurrence_list->RowAction = strval($CurrentForm->getValue($occurrence_list->FormActionName));
			elseif ($occurrence_list->isGridAdd())
				$occurrence_list->RowAction = "insert";
			else
				$occurrence_list->RowAction = "";
		}

		// Set up key count
		$occurrence_list->KeyCount = $occurrence_list->RowIndex;

		// Init row class and style
		$occurrence->resetAttributes();
		$occurrence->CssClass = "";
		if ($occurrence_list->isGridAdd()) {
			$occurrence_list->loadRowValues(); // Load default values
		} else {
			$occurrence_list->loadRowValues($occurrence_list->Recordset); // Load row values
		}
		$occurrence->RowType = ROWTYPE_VIEW; // Render view
		if ($occurrence_list->isGridAdd()) // Grid add
			$occurrence->RowType = ROWTYPE_ADD; // Render add
		if ($occurrence_list->isGridAdd() && $occurrence->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$occurrence_list->restoreCurrentRowFormValues($occurrence_list->RowIndex); // Restore form values
		if ($occurrence_list->isEdit()) {
			if ($occurrence_list->checkInlineEditKey() && $occurrence_list->EditRowCount == 0) { // Inline edit
				$occurrence->RowType = ROWTYPE_EDIT; // Render edit
				if (!$occurrence->EventCancelled)
					$occurrence_list->HashValue = $occurrence_list->getRowHash($occurrence_list->Recordset); // Get hash value for record
			}
		}
		if ($occurrence_list->isGridEdit()) { // Grid edit
			if ($occurrence->EventCancelled)
				$occurrence_list->restoreCurrentRowFormValues($occurrence_list->RowIndex); // Restore form values
			if ($occurrence_list->RowAction == "insert")
				$occurrence->RowType = ROWTYPE_ADD; // Render add
			else
				$occurrence->RowType = ROWTYPE_EDIT; // Render edit
			if (!$occurrence->EventCancelled)
				$occurrence_list->HashValue = $occurrence_list->getRowHash($occurrence_list->Recordset); // Get hash value for record
		}
		if ($occurrence_list->isEdit() && $occurrence->RowType == ROWTYPE_EDIT && $occurrence->EventCancelled) { // Update failed
			$CurrentForm->Index = 1;
			$occurrence_list->restoreFormValues(); // Restore form values
		}
		if ($occurrence_list->isGridEdit() && ($occurrence->RowType == ROWTYPE_EDIT || $occurrence->RowType == ROWTYPE_ADD) && $occurrence->EventCancelled) // Update failed
			$occurrence_list->restoreCurrentRowFormValues($occurrence_list->RowIndex); // Restore form values
		if ($occurrence->RowType == ROWTYPE_EDIT) // Edit row
			$occurrence_list->EditRowCount++;

		// Set up row id / data-rowindex
		$occurrence->RowAttrs->merge(["data-rowindex" => $occurrence_list->RowCount, "id" => "r" . $occurrence_list->RowCount . "_occurrence", "data-rowtype" => $occurrence->RowType]);

		// Render row
		$occurrence_list->renderRow();

		// Render list options
		$occurrence_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($occurrence_list->RowAction != "delete" && $occurrence_list->RowAction != "insertdelete" && !($occurrence_list->RowAction == "insert" && $occurrence->isConfirm() && $occurrence_list->emptyRow())) {
?>
	<tr <?php echo $occurrence->rowAttributes() ?>>
<?php

// Render list options (body, left)
$occurrence_list->ListOptions->render("body", "left", $occurrence_list->RowCount);
?>
	<?php if ($occurrence_list->idOccurrence->Visible) { // idOccurrence ?>
		<td data-name="idOccurrence" <?php echo $occurrence_list->idOccurrence->cellAttributes() ?>>
<?php if ($occurrence->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $occurrence_list->RowCount ?>_occurrence_idOccurrence" class="form-group"></span>
<input type="hidden" data-table="occurrence" data-field="x_idOccurrence" name="o<?php echo $occurrence_list->RowIndex ?>_idOccurrence" id="o<?php echo $occurrence_list->RowIndex ?>_idOccurrence" value="<?php echo HtmlEncode($occurrence_list->idOccurrence->OldValue) ?>">
<?php } ?>
<?php if ($occurrence->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $occurrence_list->RowCount ?>_occurrence_idOccurrence" class="form-group">
<span<?php echo $occurrence_list->idOccurrence->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($occurrence_list->idOccurrence->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="occurrence" data-field="x_idOccurrence" name="x<?php echo $occurrence_list->RowIndex ?>_idOccurrence" id="x<?php echo $occurrence_list->RowIndex ?>_idOccurrence" value="<?php echo HtmlEncode($occurrence_list->idOccurrence->CurrentValue) ?>">
<?php } ?>
<?php if ($occurrence->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $occurrence_list->RowCount ?>_occurrence_idOccurrence">
<span<?php echo $occurrence_list->idOccurrence->viewAttributes() ?>><?php echo $occurrence_list->idOccurrence->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($occurrence_list->probability->Visible) { // probability ?>
		<td data-name="probability" <?php echo $occurrence_list->probability->cellAttributes() ?>>
<?php if ($occurrence->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $occurrence_list->RowCount ?>_occurrence_probability" class="form-group">
<input type="text" data-table="occurrence" data-field="x_probability" name="x<?php echo $occurrence_list->RowIndex ?>_probability" id="x<?php echo $occurrence_list->RowIndex ?>_probability" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($occurrence_list->probability->getPlaceHolder()) ?>" value="<?php echo $occurrence_list->probability->EditValue ?>"<?php echo $occurrence_list->probability->editAttributes() ?>>
</span>
<input type="hidden" data-table="occurrence" data-field="x_probability" name="o<?php echo $occurrence_list->RowIndex ?>_probability" id="o<?php echo $occurrence_list->RowIndex ?>_probability" value="<?php echo HtmlEncode($occurrence_list->probability->OldValue) ?>">
<?php } ?>
<?php if ($occurrence->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $occurrence_list->RowCount ?>_occurrence_probability" class="form-group">
<input type="text" data-table="occurrence" data-field="x_probability" name="x<?php echo $occurrence_list->RowIndex ?>_probability" id="x<?php echo $occurrence_list->RowIndex ?>_probability" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($occurrence_list->probability->getPlaceHolder()) ?>" value="<?php echo $occurrence_list->probability->EditValue ?>"<?php echo $occurrence_list->probability->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($occurrence->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $occurrence_list->RowCount ?>_occurrence_probability">
<span<?php echo $occurrence_list->probability->viewAttributes() ?>><?php echo $occurrence_list->probability->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($occurrence_list->description->Visible) { // description ?>
		<td data-name="description" <?php echo $occurrence_list->description->cellAttributes() ?>>
<?php if ($occurrence->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $occurrence_list->RowCount ?>_occurrence_description" class="form-group">
<textarea data-table="occurrence" data-field="x_description" name="x<?php echo $occurrence_list->RowIndex ?>_description" id="x<?php echo $occurrence_list->RowIndex ?>_description" cols="35" rows="4" placeholder="<?php echo HtmlEncode($occurrence_list->description->getPlaceHolder()) ?>"<?php echo $occurrence_list->description->editAttributes() ?>><?php echo $occurrence_list->description->EditValue ?></textarea>
</span>
<input type="hidden" data-table="occurrence" data-field="x_description" name="o<?php echo $occurrence_list->RowIndex ?>_description" id="o<?php echo $occurrence_list->RowIndex ?>_description" value="<?php echo HtmlEncode($occurrence_list->description->OldValue) ?>">
<?php } ?>
<?php if ($occurrence->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $occurrence_list->RowCount ?>_occurrence_description" class="form-group">
<textarea data-table="occurrence" data-field="x_description" name="x<?php echo $occurrence_list->RowIndex ?>_description" id="x<?php echo $occurrence_list->RowIndex ?>_description" cols="35" rows="4" placeholder="<?php echo HtmlEncode($occurrence_list->description->getPlaceHolder()) ?>"<?php echo $occurrence_list->description->editAttributes() ?>><?php echo $occurrence_list->description->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($occurrence->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $occurrence_list->RowCount ?>_occurrence_description">
<span<?php echo $occurrence_list->description->viewAttributes() ?>><?php echo $occurrence_list->description->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($occurrence_list->likelihood->Visible) { // likelihood ?>
		<td data-name="likelihood" <?php echo $occurrence_list->likelihood->cellAttributes() ?>>
<?php if ($occurrence->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $occurrence_list->RowCount ?>_occurrence_likelihood" class="form-group">
<textarea data-table="occurrence" data-field="x_likelihood" name="x<?php echo $occurrence_list->RowIndex ?>_likelihood" id="x<?php echo $occurrence_list->RowIndex ?>_likelihood" cols="35" rows="4" placeholder="<?php echo HtmlEncode($occurrence_list->likelihood->getPlaceHolder()) ?>"<?php echo $occurrence_list->likelihood->editAttributes() ?>><?php echo $occurrence_list->likelihood->EditValue ?></textarea>
</span>
<input type="hidden" data-table="occurrence" data-field="x_likelihood" name="o<?php echo $occurrence_list->RowIndex ?>_likelihood" id="o<?php echo $occurrence_list->RowIndex ?>_likelihood" value="<?php echo HtmlEncode($occurrence_list->likelihood->OldValue) ?>">
<?php } ?>
<?php if ($occurrence->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $occurrence_list->RowCount ?>_occurrence_likelihood" class="form-group">
<textarea data-table="occurrence" data-field="x_likelihood" name="x<?php echo $occurrence_list->RowIndex ?>_likelihood" id="x<?php echo $occurrence_list->RowIndex ?>_likelihood" cols="35" rows="4" placeholder="<?php echo HtmlEncode($occurrence_list->likelihood->getPlaceHolder()) ?>"<?php echo $occurrence_list->likelihood->editAttributes() ?>><?php echo $occurrence_list->likelihood->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($occurrence->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $occurrence_list->RowCount ?>_occurrence_likelihood">
<span<?php echo $occurrence_list->likelihood->viewAttributes() ?>><?php echo $occurrence_list->likelihood->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($occurrence_list->timebased->Visible) { // timebased ?>
		<td data-name="timebased" <?php echo $occurrence_list->timebased->cellAttributes() ?>>
<?php if ($occurrence->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $occurrence_list->RowCount ?>_occurrence_timebased" class="form-group">
<input type="text" data-table="occurrence" data-field="x_timebased" name="x<?php echo $occurrence_list->RowIndex ?>_timebased" id="x<?php echo $occurrence_list->RowIndex ?>_timebased" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($occurrence_list->timebased->getPlaceHolder()) ?>" value="<?php echo $occurrence_list->timebased->EditValue ?>"<?php echo $occurrence_list->timebased->editAttributes() ?>>
</span>
<input type="hidden" data-table="occurrence" data-field="x_timebased" name="o<?php echo $occurrence_list->RowIndex ?>_timebased" id="o<?php echo $occurrence_list->RowIndex ?>_timebased" value="<?php echo HtmlEncode($occurrence_list->timebased->OldValue) ?>">
<?php } ?>
<?php if ($occurrence->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $occurrence_list->RowCount ?>_occurrence_timebased" class="form-group">
<input type="text" data-table="occurrence" data-field="x_timebased" name="x<?php echo $occurrence_list->RowIndex ?>_timebased" id="x<?php echo $occurrence_list->RowIndex ?>_timebased" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($occurrence_list->timebased->getPlaceHolder()) ?>" value="<?php echo $occurrence_list->timebased->EditValue ?>"<?php echo $occurrence_list->timebased->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($occurrence->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $occurrence_list->RowCount ?>_occurrence_timebased">
<span<?php echo $occurrence_list->timebased->viewAttributes() ?>><?php echo $occurrence_list->timebased->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($occurrence_list->color->Visible) { // color ?>
		<td data-name="color" <?php echo $occurrence_list->color->cellAttributes() ?>>
<?php if ($occurrence->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $occurrence_list->RowCount ?>_occurrence_color" class="form-group">
<input type="text" data-table="occurrence" data-field="x_color" name="x<?php echo $occurrence_list->RowIndex ?>_color" id="x<?php echo $occurrence_list->RowIndex ?>_color" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($occurrence_list->color->getPlaceHolder()) ?>" value="<?php echo $occurrence_list->color->EditValue ?>"<?php echo $occurrence_list->color->editAttributes() ?>>

<script>
loadjs.ready("head", function() {
	jQuery("[id='x<?php echo $occurrence_list->RowIndex ?>_color']:not([id*='$rowindex$'])").colorpicker({ format: "hex" });
});
</script>

</span>
<input type="hidden" data-table="occurrence" data-field="x_color" name="o<?php echo $occurrence_list->RowIndex ?>_color" id="o<?php echo $occurrence_list->RowIndex ?>_color" value="<?php echo HtmlEncode($occurrence_list->color->OldValue) ?>">
<?php } ?>
<?php if ($occurrence->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $occurrence_list->RowCount ?>_occurrence_color" class="form-group">
<input type="text" data-table="occurrence" data-field="x_color" name="x<?php echo $occurrence_list->RowIndex ?>_color" id="x<?php echo $occurrence_list->RowIndex ?>_color" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($occurrence_list->color->getPlaceHolder()) ?>" value="<?php echo $occurrence_list->color->EditValue ?>"<?php echo $occurrence_list->color->editAttributes() ?>>

<script>
loadjs.ready("head", function() {
	jQuery("[id='x<?php echo $occurrence_list->RowIndex ?>_color']:not([id*='$rowindex$'])").colorpicker({ format: "hex" });
});
</script>

</span>
<?php } ?>
<?php if ($occurrence->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $occurrence_list->RowCount ?>_occurrence_color">
<span<?php echo $occurrence_list->color->viewAttributes() ?>><?php echo $occurrence_list->color->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$occurrence_list->ListOptions->render("body", "right", $occurrence_list->RowCount);
?>
	</tr>
<?php if ($occurrence->RowType == ROWTYPE_ADD || $occurrence->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["foccurrencelist", "load"], function() {
	foccurrencelist.updateLists(<?php echo $occurrence_list->RowIndex ?>);
});
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$occurrence_list->isGridAdd())
		if (!$occurrence_list->Recordset->EOF)
			$occurrence_list->Recordset->moveNext();
}
?>
<?php
	if ($occurrence_list->isGridAdd() || $occurrence_list->isGridEdit()) {
		$occurrence_list->RowIndex = '$rowindex$';
		$occurrence_list->loadRowValues();

		// Set row properties
		$occurrence->resetAttributes();
		$occurrence->RowAttrs->merge(["data-rowindex" => $occurrence_list->RowIndex, "id" => "r0_occurrence", "data-rowtype" => ROWTYPE_ADD]);
		$occurrence->RowAttrs->appendClass("ew-template");
		$occurrence->RowType = ROWTYPE_ADD;

		// Render row
		$occurrence_list->renderRow();

		// Render list options
		$occurrence_list->renderListOptions();
		$occurrence_list->StartRowCount = 0;
?>
	<tr <?php echo $occurrence->rowAttributes() ?>>
<?php

// Render list options (body, left)
$occurrence_list->ListOptions->render("body", "left", $occurrence_list->RowIndex);
?>
	<?php if ($occurrence_list->idOccurrence->Visible) { // idOccurrence ?>
		<td data-name="idOccurrence">
<span id="el$rowindex$_occurrence_idOccurrence" class="form-group occurrence_idOccurrence"></span>
<input type="hidden" data-table="occurrence" data-field="x_idOccurrence" name="o<?php echo $occurrence_list->RowIndex ?>_idOccurrence" id="o<?php echo $occurrence_list->RowIndex ?>_idOccurrence" value="<?php echo HtmlEncode($occurrence_list->idOccurrence->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($occurrence_list->probability->Visible) { // probability ?>
		<td data-name="probability">
<span id="el$rowindex$_occurrence_probability" class="form-group occurrence_probability">
<input type="text" data-table="occurrence" data-field="x_probability" name="x<?php echo $occurrence_list->RowIndex ?>_probability" id="x<?php echo $occurrence_list->RowIndex ?>_probability" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($occurrence_list->probability->getPlaceHolder()) ?>" value="<?php echo $occurrence_list->probability->EditValue ?>"<?php echo $occurrence_list->probability->editAttributes() ?>>
</span>
<input type="hidden" data-table="occurrence" data-field="x_probability" name="o<?php echo $occurrence_list->RowIndex ?>_probability" id="o<?php echo $occurrence_list->RowIndex ?>_probability" value="<?php echo HtmlEncode($occurrence_list->probability->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($occurrence_list->description->Visible) { // description ?>
		<td data-name="description">
<span id="el$rowindex$_occurrence_description" class="form-group occurrence_description">
<textarea data-table="occurrence" data-field="x_description" name="x<?php echo $occurrence_list->RowIndex ?>_description" id="x<?php echo $occurrence_list->RowIndex ?>_description" cols="35" rows="4" placeholder="<?php echo HtmlEncode($occurrence_list->description->getPlaceHolder()) ?>"<?php echo $occurrence_list->description->editAttributes() ?>><?php echo $occurrence_list->description->EditValue ?></textarea>
</span>
<input type="hidden" data-table="occurrence" data-field="x_description" name="o<?php echo $occurrence_list->RowIndex ?>_description" id="o<?php echo $occurrence_list->RowIndex ?>_description" value="<?php echo HtmlEncode($occurrence_list->description->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($occurrence_list->likelihood->Visible) { // likelihood ?>
		<td data-name="likelihood">
<span id="el$rowindex$_occurrence_likelihood" class="form-group occurrence_likelihood">
<textarea data-table="occurrence" data-field="x_likelihood" name="x<?php echo $occurrence_list->RowIndex ?>_likelihood" id="x<?php echo $occurrence_list->RowIndex ?>_likelihood" cols="35" rows="4" placeholder="<?php echo HtmlEncode($occurrence_list->likelihood->getPlaceHolder()) ?>"<?php echo $occurrence_list->likelihood->editAttributes() ?>><?php echo $occurrence_list->likelihood->EditValue ?></textarea>
</span>
<input type="hidden" data-table="occurrence" data-field="x_likelihood" name="o<?php echo $occurrence_list->RowIndex ?>_likelihood" id="o<?php echo $occurrence_list->RowIndex ?>_likelihood" value="<?php echo HtmlEncode($occurrence_list->likelihood->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($occurrence_list->timebased->Visible) { // timebased ?>
		<td data-name="timebased">
<span id="el$rowindex$_occurrence_timebased" class="form-group occurrence_timebased">
<input type="text" data-table="occurrence" data-field="x_timebased" name="x<?php echo $occurrence_list->RowIndex ?>_timebased" id="x<?php echo $occurrence_list->RowIndex ?>_timebased" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($occurrence_list->timebased->getPlaceHolder()) ?>" value="<?php echo $occurrence_list->timebased->EditValue ?>"<?php echo $occurrence_list->timebased->editAttributes() ?>>
</span>
<input type="hidden" data-table="occurrence" data-field="x_timebased" name="o<?php echo $occurrence_list->RowIndex ?>_timebased" id="o<?php echo $occurrence_list->RowIndex ?>_timebased" value="<?php echo HtmlEncode($occurrence_list->timebased->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($occurrence_list->color->Visible) { // color ?>
		<td data-name="color">
<span id="el$rowindex$_occurrence_color" class="form-group occurrence_color">
<input type="text" data-table="occurrence" data-field="x_color" name="x<?php echo $occurrence_list->RowIndex ?>_color" id="x<?php echo $occurrence_list->RowIndex ?>_color" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($occurrence_list->color->getPlaceHolder()) ?>" value="<?php echo $occurrence_list->color->EditValue ?>"<?php echo $occurrence_list->color->editAttributes() ?>>

<script>
loadjs.ready("head", function() {
	jQuery("[id='x<?php echo $occurrence_list->RowIndex ?>_color']:not([id*='$rowindex$'])").colorpicker({ format: "hex" });
});
</script>

</span>
<input type="hidden" data-table="occurrence" data-field="x_color" name="o<?php echo $occurrence_list->RowIndex ?>_color" id="o<?php echo $occurrence_list->RowIndex ?>_color" value="<?php echo HtmlEncode($occurrence_list->color->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$occurrence_list->ListOptions->render("body", "right", $occurrence_list->RowIndex);
?>
<script>
loadjs.ready(["foccurrencelist", "load"], function() {
	foccurrencelist.updateLists(<?php echo $occurrence_list->RowIndex ?>);
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
<?php if ($occurrence_list->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?php echo $occurrence_list->FormKeyCountName ?>" id="<?php echo $occurrence_list->FormKeyCountName ?>" value="<?php echo $occurrence_list->KeyCount ?>">
<?php echo $occurrence_list->MultiSelectKey ?>
<?php } ?>
<?php if ($occurrence_list->isEdit()) { ?>
<input type="hidden" name="<?php echo $occurrence_list->FormKeyCountName ?>" id="<?php echo $occurrence_list->FormKeyCountName ?>" value="<?php echo $occurrence_list->KeyCount ?>">
<?php } ?>
<?php if ($occurrence_list->isGridEdit()) { ?>
<?php if ($occurrence->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="action" id="action" value="gridoverwrite">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<?php } ?>
<input type="hidden" name="<?php echo $occurrence_list->FormKeyCountName ?>" id="<?php echo $occurrence_list->FormKeyCountName ?>" value="<?php echo $occurrence_list->KeyCount ?>">
<?php echo $occurrence_list->MultiSelectKey ?>
<?php } ?>
<?php if (!$occurrence->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($occurrence_list->Recordset)
	$occurrence_list->Recordset->Close();
?>
<?php if (!$occurrence_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$occurrence_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $occurrence_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $occurrence_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($occurrence_list->TotalRecords == 0 && !$occurrence->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $occurrence_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$occurrence_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$occurrence_list->isExport()) { ?>
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
$occurrence_list->terminate();
?>