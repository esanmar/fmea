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
$regulations_list = new regulations_list();

// Run the page
$regulations_list->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$regulations_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$regulations_list->isExport()) { ?>
<script>
var fregulationslist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	fregulationslist = currentForm = new ew.Form("fregulationslist", "list");
	fregulationslist.formKeyCountName = '<?php echo $regulations_list->FormKeyCountName ?>';

	// Validate form
	fregulationslist.validate = function() {
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
			<?php if ($regulations_list->regulation->Required) { ?>
				elm = this.getElements("x" + infix + "_regulation");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $regulations_list->regulation->caption(), $regulations_list->regulation->RequiredErrorMessage)) ?>");
			<?php } ?>

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
		}
		return true;
	}

	// Form_CustomValidate
	fregulationslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fregulationslist.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fregulationslist");
});
var fregulationslistsrch;
loadjs.ready("head", function() {

	// Form object for search
	fregulationslistsrch = currentSearchForm = new ew.Form("fregulationslistsrch");

	// Dynamic selection lists
	// Filters

	fregulationslistsrch.filterList = <?php echo $regulations_list->getFilterList() ?>;
	loadjs.done("fregulationslistsrch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$regulations_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($regulations_list->TotalRecords > 0 && $regulations_list->ExportOptions->visible()) { ?>
<?php $regulations_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($regulations_list->ImportOptions->visible()) { ?>
<?php $regulations_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($regulations_list->SearchOptions->visible()) { ?>
<?php $regulations_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($regulations_list->FilterOptions->visible()) { ?>
<?php $regulations_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$regulations_list->renderOtherOptions();
?>
<?php if (!$regulations_list->isExport() && !$regulations->CurrentAction) { ?>
<form name="fregulationslistsrch" id="fregulationslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="fregulationslistsrch-search-panel" class="<?php echo $regulations_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="regulations">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $regulations_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($regulations_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($regulations_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $regulations_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($regulations_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($regulations_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($regulations_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($regulations_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php $regulations_list->showPageHeader(); ?>
<?php
$regulations_list->showMessage();
?>
<?php if ($regulations_list->TotalRecords > 0 || $regulations->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($regulations_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> regulations">
<?php if (!$regulations_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$regulations_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $regulations_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $regulations_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fregulationslist" id="fregulationslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="regulations">
<div id="gmp_regulations" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($regulations_list->TotalRecords > 0 || $regulations_list->isGridEdit()) { ?>
<table id="tbl_regulationslist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$regulations->RowType = ROWTYPE_HEADER;

// Render list options
$regulations_list->renderListOptions();

// Render list options (header, left)
$regulations_list->ListOptions->render("header", "left");
?>
<?php if ($regulations_list->regulation->Visible) { // regulation ?>
	<?php if ($regulations_list->SortUrl($regulations_list->regulation) == "") { ?>
		<th data-name="regulation" class="<?php echo $regulations_list->regulation->headerCellClass() ?>"><div id="elh_regulations_regulation" class="regulations_regulation"><div class="ew-table-header-caption"><?php echo $regulations_list->regulation->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="regulation" class="<?php echo $regulations_list->regulation->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $regulations_list->SortUrl($regulations_list->regulation) ?>', 2);"><div id="elh_regulations_regulation" class="regulations_regulation">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $regulations_list->regulation->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($regulations_list->regulation->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($regulations_list->regulation->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$regulations_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($regulations_list->ExportAll && $regulations_list->isExport()) {
	$regulations_list->StopRecord = $regulations_list->TotalRecords;
} else {

	// Set the last record to display
	if ($regulations_list->TotalRecords > $regulations_list->StartRecord + $regulations_list->DisplayRecords - 1)
		$regulations_list->StopRecord = $regulations_list->StartRecord + $regulations_list->DisplayRecords - 1;
	else
		$regulations_list->StopRecord = $regulations_list->TotalRecords;
}

// Restore number of post back records
if ($CurrentForm && ($regulations->isConfirm() || $regulations_list->EventCancelled)) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($regulations_list->FormKeyCountName) && ($regulations_list->isGridAdd() || $regulations_list->isGridEdit() || $regulations->isConfirm())) {
		$regulations_list->KeyCount = $CurrentForm->getValue($regulations_list->FormKeyCountName);
		$regulations_list->StopRecord = $regulations_list->StartRecord + $regulations_list->KeyCount - 1;
	}
}
$regulations_list->RecordCount = $regulations_list->StartRecord - 1;
if ($regulations_list->Recordset && !$regulations_list->Recordset->EOF) {
	$regulations_list->Recordset->moveFirst();
	$selectLimit = $regulations_list->UseSelectLimit;
	if (!$selectLimit && $regulations_list->StartRecord > 1)
		$regulations_list->Recordset->move($regulations_list->StartRecord - 1);
} elseif (!$regulations->AllowAddDeleteRow && $regulations_list->StopRecord == 0) {
	$regulations_list->StopRecord = $regulations->GridAddRowCount;
}

// Initialize aggregate
$regulations->RowType = ROWTYPE_AGGREGATEINIT;
$regulations->resetAttributes();
$regulations_list->renderRow();
$regulations_list->EditRowCount = 0;
if ($regulations_list->isEdit())
	$regulations_list->RowIndex = 1;
if ($regulations_list->isGridEdit())
	$regulations_list->RowIndex = 0;
while ($regulations_list->RecordCount < $regulations_list->StopRecord) {
	$regulations_list->RecordCount++;
	if ($regulations_list->RecordCount >= $regulations_list->StartRecord) {
		$regulations_list->RowCount++;
		if ($regulations_list->isGridAdd() || $regulations_list->isGridEdit() || $regulations->isConfirm()) {
			$regulations_list->RowIndex++;
			$CurrentForm->Index = $regulations_list->RowIndex;
			if ($CurrentForm->hasValue($regulations_list->FormActionName) && ($regulations->isConfirm() || $regulations_list->EventCancelled))
				$regulations_list->RowAction = strval($CurrentForm->getValue($regulations_list->FormActionName));
			elseif ($regulations_list->isGridAdd())
				$regulations_list->RowAction = "insert";
			else
				$regulations_list->RowAction = "";
		}

		// Set up key count
		$regulations_list->KeyCount = $regulations_list->RowIndex;

		// Init row class and style
		$regulations->resetAttributes();
		$regulations->CssClass = "";
		if ($regulations_list->isGridAdd()) {
			$regulations_list->loadRowValues(); // Load default values
		} else {
			$regulations_list->loadRowValues($regulations_list->Recordset); // Load row values
		}
		$regulations->RowType = ROWTYPE_VIEW; // Render view
		if ($regulations_list->isEdit()) {
			if ($regulations_list->checkInlineEditKey() && $regulations_list->EditRowCount == 0) { // Inline edit
				$regulations->RowType = ROWTYPE_EDIT; // Render edit
			}
		}
		if ($regulations_list->isGridEdit()) { // Grid edit
			if ($regulations->EventCancelled)
				$regulations_list->restoreCurrentRowFormValues($regulations_list->RowIndex); // Restore form values
			if ($regulations_list->RowAction == "insert")
				$regulations->RowType = ROWTYPE_ADD; // Render add
			else
				$regulations->RowType = ROWTYPE_EDIT; // Render edit
		}
		if ($regulations_list->isEdit() && $regulations->RowType == ROWTYPE_EDIT && $regulations->EventCancelled) { // Update failed
			$CurrentForm->Index = 1;
			$regulations_list->restoreFormValues(); // Restore form values
		}
		if ($regulations_list->isGridEdit() && ($regulations->RowType == ROWTYPE_EDIT || $regulations->RowType == ROWTYPE_ADD) && $regulations->EventCancelled) // Update failed
			$regulations_list->restoreCurrentRowFormValues($regulations_list->RowIndex); // Restore form values
		if ($regulations->RowType == ROWTYPE_EDIT) // Edit row
			$regulations_list->EditRowCount++;

		// Set up row id / data-rowindex
		$regulations->RowAttrs->merge(["data-rowindex" => $regulations_list->RowCount, "id" => "r" . $regulations_list->RowCount . "_regulations", "data-rowtype" => $regulations->RowType]);

		// Render row
		$regulations_list->renderRow();

		// Render list options
		$regulations_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($regulations_list->RowAction != "delete" && $regulations_list->RowAction != "insertdelete" && !($regulations_list->RowAction == "insert" && $regulations->isConfirm() && $regulations_list->emptyRow())) {
?>
	<tr <?php echo $regulations->rowAttributes() ?>>
<?php

// Render list options (body, left)
$regulations_list->ListOptions->render("body", "left", $regulations_list->RowCount);
?>
	<?php if ($regulations_list->regulation->Visible) { // regulation ?>
		<td data-name="regulation" <?php echo $regulations_list->regulation->cellAttributes() ?>>
<?php if ($regulations->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $regulations_list->RowCount ?>_regulations_regulation" class="form-group">
<input type="text" data-table="regulations" data-field="x_regulation" name="x<?php echo $regulations_list->RowIndex ?>_regulation" id="x<?php echo $regulations_list->RowIndex ?>_regulation" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($regulations_list->regulation->getPlaceHolder()) ?>" value="<?php echo $regulations_list->regulation->EditValue ?>"<?php echo $regulations_list->regulation->editAttributes() ?>>
</span>
<input type="hidden" data-table="regulations" data-field="x_regulation" name="o<?php echo $regulations_list->RowIndex ?>_regulation" id="o<?php echo $regulations_list->RowIndex ?>_regulation" value="<?php echo HtmlEncode($regulations_list->regulation->OldValue) ?>">
<?php } ?>
<?php if ($regulations->RowType == ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-table="regulations" data-field="x_regulation" name="x<?php echo $regulations_list->RowIndex ?>_regulation" id="x<?php echo $regulations_list->RowIndex ?>_regulation" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($regulations_list->regulation->getPlaceHolder()) ?>" value="<?php echo $regulations_list->regulation->EditValue ?>"<?php echo $regulations_list->regulation->editAttributes() ?>>
<input type="hidden" data-table="regulations" data-field="x_regulation" name="o<?php echo $regulations_list->RowIndex ?>_regulation" id="o<?php echo $regulations_list->RowIndex ?>_regulation" value="<?php echo HtmlEncode($regulations_list->regulation->OldValue != null ? $regulations_list->regulation->OldValue : $regulations_list->regulation->CurrentValue) ?>">
<?php } ?>
<?php if ($regulations->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $regulations_list->RowCount ?>_regulations_regulation">
<span<?php echo $regulations_list->regulation->viewAttributes() ?>><?php echo $regulations_list->regulation->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$regulations_list->ListOptions->render("body", "right", $regulations_list->RowCount);
?>
	</tr>
<?php if ($regulations->RowType == ROWTYPE_ADD || $regulations->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fregulationslist", "load"], function() {
	fregulationslist.updateLists(<?php echo $regulations_list->RowIndex ?>);
});
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$regulations_list->isGridAdd())
		if (!$regulations_list->Recordset->EOF)
			$regulations_list->Recordset->moveNext();
}
?>
<?php
	if ($regulations_list->isGridAdd() || $regulations_list->isGridEdit()) {
		$regulations_list->RowIndex = '$rowindex$';
		$regulations_list->loadRowValues();

		// Set row properties
		$regulations->resetAttributes();
		$regulations->RowAttrs->merge(["data-rowindex" => $regulations_list->RowIndex, "id" => "r0_regulations", "data-rowtype" => ROWTYPE_ADD]);
		$regulations->RowAttrs->appendClass("ew-template");
		$regulations->RowType = ROWTYPE_ADD;

		// Render row
		$regulations_list->renderRow();

		// Render list options
		$regulations_list->renderListOptions();
		$regulations_list->StartRowCount = 0;
?>
	<tr <?php echo $regulations->rowAttributes() ?>>
<?php

// Render list options (body, left)
$regulations_list->ListOptions->render("body", "left", $regulations_list->RowIndex);
?>
	<?php if ($regulations_list->regulation->Visible) { // regulation ?>
		<td data-name="regulation">
<span id="el$rowindex$_regulations_regulation" class="form-group regulations_regulation">
<input type="text" data-table="regulations" data-field="x_regulation" name="x<?php echo $regulations_list->RowIndex ?>_regulation" id="x<?php echo $regulations_list->RowIndex ?>_regulation" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($regulations_list->regulation->getPlaceHolder()) ?>" value="<?php echo $regulations_list->regulation->EditValue ?>"<?php echo $regulations_list->regulation->editAttributes() ?>>
</span>
<input type="hidden" data-table="regulations" data-field="x_regulation" name="o<?php echo $regulations_list->RowIndex ?>_regulation" id="o<?php echo $regulations_list->RowIndex ?>_regulation" value="<?php echo HtmlEncode($regulations_list->regulation->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$regulations_list->ListOptions->render("body", "right", $regulations_list->RowIndex);
?>
<script>
loadjs.ready(["fregulationslist", "load"], function() {
	fregulationslist.updateLists(<?php echo $regulations_list->RowIndex ?>);
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
<?php if ($regulations_list->isEdit()) { ?>
<input type="hidden" name="<?php echo $regulations_list->FormKeyCountName ?>" id="<?php echo $regulations_list->FormKeyCountName ?>" value="<?php echo $regulations_list->KeyCount ?>">
<?php } ?>
<?php if ($regulations_list->isGridEdit()) { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<input type="hidden" name="<?php echo $regulations_list->FormKeyCountName ?>" id="<?php echo $regulations_list->FormKeyCountName ?>" value="<?php echo $regulations_list->KeyCount ?>">
<?php echo $regulations_list->MultiSelectKey ?>
<?php } ?>
<?php if (!$regulations->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($regulations_list->Recordset)
	$regulations_list->Recordset->Close();
?>
<?php if (!$regulations_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$regulations_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $regulations_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $regulations_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($regulations_list->TotalRecords == 0 && !$regulations->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $regulations_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$regulations_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$regulations_list->isExport()) { ?>
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
$regulations_list->terminate();
?>