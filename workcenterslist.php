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
$workcenters_list = new workcenters_list();

// Run the page
$workcenters_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$workcenters_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$workcenters_list->isExport()) { ?>
<script>
var fworkcenterslist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	fworkcenterslist = currentForm = new ew.Form("fworkcenterslist", "list");
	fworkcenterslist.formKeyCountName = '<?php echo $workcenters_list->FormKeyCountName ?>';
	loadjs.done("fworkcenterslist");
});
var fworkcenterslistsrch;
loadjs.ready("head", function() {

	// Form object for search
	fworkcenterslistsrch = currentSearchForm = new ew.Form("fworkcenterslistsrch");

	// Dynamic selection lists
	// Filters

	fworkcenterslistsrch.filterList = <?php echo $workcenters_list->getFilterList() ?>;
	loadjs.done("fworkcenterslistsrch");
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
<?php if (!$workcenters_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($workcenters_list->TotalRecords > 0 && $workcenters_list->ExportOptions->visible()) { ?>
<?php $workcenters_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($workcenters_list->ImportOptions->visible()) { ?>
<?php $workcenters_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($workcenters_list->SearchOptions->visible()) { ?>
<?php $workcenters_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($workcenters_list->FilterOptions->visible()) { ?>
<?php $workcenters_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$workcenters_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$workcenters_list->isExport() && !$workcenters->CurrentAction) { ?>
<form name="fworkcenterslistsrch" id="fworkcenterslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="fworkcenterslistsrch-search-panel" class="<?php echo $workcenters_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="workcenters">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $workcenters_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($workcenters_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($workcenters_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $workcenters_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($workcenters_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($workcenters_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($workcenters_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($workcenters_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $workcenters_list->showPageHeader(); ?>
<?php
$workcenters_list->showMessage();
?>
<?php if ($workcenters_list->TotalRecords > 0 || $workcenters->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($workcenters_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> workcenters">
<?php if (!$workcenters_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$workcenters_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $workcenters_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $workcenters_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fworkcenterslist" id="fworkcenterslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="workcenters">
<div id="gmp_workcenters" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($workcenters_list->TotalRecords > 0 || $workcenters_list->isGridEdit()) { ?>
<table id="tbl_workcenterslist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$workcenters->RowType = ROWTYPE_HEADER;

// Render list options
$workcenters_list->renderListOptions();

// Render list options (header, left)
$workcenters_list->ListOptions->render("header", "left");
?>
<?php if ($workcenters_list->workcenter->Visible) { // workcenter ?>
	<?php if ($workcenters_list->SortUrl($workcenters_list->workcenter) == "") { ?>
		<th data-name="workcenter" class="<?php echo $workcenters_list->workcenter->headerCellClass() ?>"><div id="elh_workcenters_workcenter" class="workcenters_workcenter"><div class="ew-table-header-caption"><?php echo $workcenters_list->workcenter->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="workcenter" class="<?php echo $workcenters_list->workcenter->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $workcenters_list->SortUrl($workcenters_list->workcenter) ?>', 2);"><div id="elh_workcenters_workcenter" class="workcenters_workcenter">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $workcenters_list->workcenter->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($workcenters_list->workcenter->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($workcenters_list->workcenter->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($workcenters_list->description->Visible) { // description ?>
	<?php if ($workcenters_list->SortUrl($workcenters_list->description) == "") { ?>
		<th data-name="description" class="<?php echo $workcenters_list->description->headerCellClass() ?>"><div id="elh_workcenters_description" class="workcenters_description"><div class="ew-table-header-caption"><?php echo $workcenters_list->description->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="description" class="<?php echo $workcenters_list->description->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $workcenters_list->SortUrl($workcenters_list->description) ?>', 2);"><div id="elh_workcenters_description" class="workcenters_description">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $workcenters_list->description->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($workcenters_list->description->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($workcenters_list->description->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$workcenters_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($workcenters_list->ExportAll && $workcenters_list->isExport()) {
	$workcenters_list->StopRecord = $workcenters_list->TotalRecords;
} else {

	// Set the last record to display
	if ($workcenters_list->TotalRecords > $workcenters_list->StartRecord + $workcenters_list->DisplayRecords - 1)
		$workcenters_list->StopRecord = $workcenters_list->StartRecord + $workcenters_list->DisplayRecords - 1;
	else
		$workcenters_list->StopRecord = $workcenters_list->TotalRecords;
}
$workcenters_list->RecordCount = $workcenters_list->StartRecord - 1;
if ($workcenters_list->Recordset && !$workcenters_list->Recordset->EOF) {
	$workcenters_list->Recordset->moveFirst();
	$selectLimit = $workcenters_list->UseSelectLimit;
	if (!$selectLimit && $workcenters_list->StartRecord > 1)
		$workcenters_list->Recordset->move($workcenters_list->StartRecord - 1);
} elseif (!$workcenters->AllowAddDeleteRow && $workcenters_list->StopRecord == 0) {
	$workcenters_list->StopRecord = $workcenters->GridAddRowCount;
}

// Initialize aggregate
$workcenters->RowType = ROWTYPE_AGGREGATEINIT;
$workcenters->resetAttributes();
$workcenters_list->renderRow();
while ($workcenters_list->RecordCount < $workcenters_list->StopRecord) {
	$workcenters_list->RecordCount++;
	if ($workcenters_list->RecordCount >= $workcenters_list->StartRecord) {
		$workcenters_list->RowCount++;

		// Set up key count
		$workcenters_list->KeyCount = $workcenters_list->RowIndex;

		// Init row class and style
		$workcenters->resetAttributes();
		$workcenters->CssClass = "";
		if ($workcenters_list->isGridAdd()) {
		} else {
			$workcenters_list->loadRowValues($workcenters_list->Recordset); // Load row values
		}
		$workcenters->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$workcenters->RowAttrs->merge(["data-rowindex" => $workcenters_list->RowCount, "id" => "r" . $workcenters_list->RowCount . "_workcenters", "data-rowtype" => $workcenters->RowType]);

		// Render row
		$workcenters_list->renderRow();

		// Render list options
		$workcenters_list->renderListOptions();
?>
	<tr <?php echo $workcenters->rowAttributes() ?>>
<?php

// Render list options (body, left)
$workcenters_list->ListOptions->render("body", "left", $workcenters_list->RowCount);
?>
	<?php if ($workcenters_list->workcenter->Visible) { // workcenter ?>
		<td data-name="workcenter" <?php echo $workcenters_list->workcenter->cellAttributes() ?>>
<span id="el<?php echo $workcenters_list->RowCount ?>_workcenters_workcenter">
<span<?php echo $workcenters_list->workcenter->viewAttributes() ?>><?php echo $workcenters_list->workcenter->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($workcenters_list->description->Visible) { // description ?>
		<td data-name="description" <?php echo $workcenters_list->description->cellAttributes() ?>>
<span id="el<?php echo $workcenters_list->RowCount ?>_workcenters_description">
<span<?php echo $workcenters_list->description->viewAttributes() ?>><?php echo $workcenters_list->description->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$workcenters_list->ListOptions->render("body", "right", $workcenters_list->RowCount);
?>
	</tr>
<?php
	}
	if (!$workcenters_list->isGridAdd())
		$workcenters_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$workcenters->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($workcenters_list->Recordset)
	$workcenters_list->Recordset->Close();
?>
<?php if (!$workcenters_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$workcenters_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $workcenters_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $workcenters_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($workcenters_list->TotalRecords == 0 && !$workcenters->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $workcenters_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$workcenters_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$workcenters_list->isExport()) { ?>
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
$workcenters_list->terminate();
?>