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
$issue_list = new issue_list();

// Run the page
$issue_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$issue_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$issue_list->isExport()) { ?>
<script>
var fissuelist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	fissuelist = currentForm = new ew.Form("fissuelist", "list");
	fissuelist.formKeyCountName = '<?php echo $issue_list->FormKeyCountName ?>';
	loadjs.done("fissuelist");
});
var fissuelistsrch;
loadjs.ready("head", function() {

	// Form object for search
	fissuelistsrch = currentSearchForm = new ew.Form("fissuelistsrch");

	// Dynamic selection lists
	// Filters

	fissuelistsrch.filterList = <?php echo $issue_list->getFilterList() ?>;
	loadjs.done("fissuelistsrch");
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
<?php if (!$issue_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($issue_list->TotalRecords > 0 && $issue_list->ExportOptions->visible()) { ?>
<?php $issue_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($issue_list->ImportOptions->visible()) { ?>
<?php $issue_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($issue_list->SearchOptions->visible()) { ?>
<?php $issue_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($issue_list->FilterOptions->visible()) { ?>
<?php $issue_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (!$issue_list->isExport() || Config("EXPORT_MASTER_RECORD") && $issue_list->isExport("print")) { ?>
<?php
if ($issue_list->DbMasterFilter != "" && $issue->getCurrentMasterTable() == "fmea") {
	if ($issue_list->MasterRecordExists) {
		include_once "fmeamaster.php";
	}
}
?>
<?php } ?>
<?php
$issue_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$issue_list->isExport() && !$issue->CurrentAction) { ?>
<form name="fissuelistsrch" id="fissuelistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="fissuelistsrch-search-panel" class="<?php echo $issue_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="issue">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $issue_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($issue_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($issue_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $issue_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($issue_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($issue_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($issue_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($issue_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $issue_list->showPageHeader(); ?>
<?php
$issue_list->showMessage();
?>
<?php if ($issue_list->TotalRecords > 0 || $issue->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($issue_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> issue">
<?php if (!$issue_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$issue_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $issue_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $issue_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fissuelist" id="fissuelist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="issue">
<?php if ($issue->getCurrentMasterTable() == "fmea" && $issue->CurrentAction) { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="fmea">
<input type="hidden" name="fk_fmea" value="<?php echo $issue_list->fmea->getSessionValue() ?>">
<?php } ?>
<div id="gmp_issue" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($issue_list->TotalRecords > 0 || $issue_list->isGridEdit()) { ?>
<table id="tbl_issuelist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$issue->RowType = ROWTYPE_HEADER;

// Render list options
$issue_list->renderListOptions();

// Render list options (header, left)
$issue_list->ListOptions->render("header", "left");
?>
<?php if ($issue_list->fmea->Visible) { // fmea ?>
	<?php if ($issue_list->SortUrl($issue_list->fmea) == "") { ?>
		<th data-name="fmea" class="<?php echo $issue_list->fmea->headerCellClass() ?>"><div id="elh_issue_fmea" class="issue_fmea"><div class="ew-table-header-caption"><?php echo $issue_list->fmea->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fmea" class="<?php echo $issue_list->fmea->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $issue_list->SortUrl($issue_list->fmea) ?>', 2);"><div id="elh_issue_fmea" class="issue_fmea">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $issue_list->fmea->caption() ?></span><span class="ew-table-header-sort"><?php if ($issue_list->fmea->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($issue_list->fmea->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($issue_list->issue->Visible) { // issue ?>
	<?php if ($issue_list->SortUrl($issue_list->issue) == "") { ?>
		<th data-name="issue" class="<?php echo $issue_list->issue->headerCellClass() ?>"><div id="elh_issue_issue" class="issue_issue"><div class="ew-table-header-caption"><?php echo $issue_list->issue->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="issue" class="<?php echo $issue_list->issue->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $issue_list->SortUrl($issue_list->issue) ?>', 2);"><div id="elh_issue_issue" class="issue_issue">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $issue_list->issue->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($issue_list->issue->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($issue_list->issue->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($issue_list->date->Visible) { // date ?>
	<?php if ($issue_list->SortUrl($issue_list->date) == "") { ?>
		<th data-name="date" class="<?php echo $issue_list->date->headerCellClass() ?>"><div id="elh_issue_date" class="issue_date"><div class="ew-table-header-caption"><?php echo $issue_list->date->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="date" class="<?php echo $issue_list->date->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $issue_list->SortUrl($issue_list->date) ?>', 2);"><div id="elh_issue_date" class="issue_date">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $issue_list->date->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($issue_list->date->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($issue_list->date->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($issue_list->cause->Visible) { // cause ?>
	<?php if ($issue_list->SortUrl($issue_list->cause) == "") { ?>
		<th data-name="cause" class="<?php echo $issue_list->cause->headerCellClass() ?>"><div id="elh_issue_cause" class="issue_cause"><div class="ew-table-header-caption"><?php echo $issue_list->cause->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cause" class="<?php echo $issue_list->cause->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $issue_list->SortUrl($issue_list->cause) ?>', 2);"><div id="elh_issue_cause" class="issue_cause">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $issue_list->cause->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($issue_list->cause->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($issue_list->cause->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($issue_list->leader->Visible) { // leader ?>
	<?php if ($issue_list->SortUrl($issue_list->leader) == "") { ?>
		<th data-name="leader" class="<?php echo $issue_list->leader->headerCellClass() ?>"><div id="elh_issue_leader" class="issue_leader"><div class="ew-table-header-caption"><?php echo $issue_list->leader->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="leader" class="<?php echo $issue_list->leader->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $issue_list->SortUrl($issue_list->leader) ?>', 2);"><div id="elh_issue_leader" class="issue_leader">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $issue_list->leader->caption() ?></span><span class="ew-table-header-sort"><?php if ($issue_list->leader->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($issue_list->leader->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($issue_list->employee->Visible) { // employee ?>
	<?php if ($issue_list->SortUrl($issue_list->employee) == "") { ?>
		<th data-name="employee" class="<?php echo $issue_list->employee->headerCellClass() ?>"><div id="elh_issue_employee" class="issue_employee"><div class="ew-table-header-caption"><?php echo $issue_list->employee->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="employee" class="<?php echo $issue_list->employee->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $issue_list->SortUrl($issue_list->employee) ?>', 2);"><div id="elh_issue_employee" class="issue_employee">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $issue_list->employee->caption() ?></span><span class="ew-table-header-sort"><?php if ($issue_list->employee->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($issue_list->employee->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$issue_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($issue_list->ExportAll && $issue_list->isExport()) {
	$issue_list->StopRecord = $issue_list->TotalRecords;
} else {

	// Set the last record to display
	if ($issue_list->TotalRecords > $issue_list->StartRecord + $issue_list->DisplayRecords - 1)
		$issue_list->StopRecord = $issue_list->StartRecord + $issue_list->DisplayRecords - 1;
	else
		$issue_list->StopRecord = $issue_list->TotalRecords;
}
$issue_list->RecordCount = $issue_list->StartRecord - 1;
if ($issue_list->Recordset && !$issue_list->Recordset->EOF) {
	$issue_list->Recordset->moveFirst();
	$selectLimit = $issue_list->UseSelectLimit;
	if (!$selectLimit && $issue_list->StartRecord > 1)
		$issue_list->Recordset->move($issue_list->StartRecord - 1);
} elseif (!$issue->AllowAddDeleteRow && $issue_list->StopRecord == 0) {
	$issue_list->StopRecord = $issue->GridAddRowCount;
}

// Initialize aggregate
$issue->RowType = ROWTYPE_AGGREGATEINIT;
$issue->resetAttributes();
$issue_list->renderRow();
while ($issue_list->RecordCount < $issue_list->StopRecord) {
	$issue_list->RecordCount++;
	if ($issue_list->RecordCount >= $issue_list->StartRecord) {
		$issue_list->RowCount++;

		// Set up key count
		$issue_list->KeyCount = $issue_list->RowIndex;

		// Init row class and style
		$issue->resetAttributes();
		$issue->CssClass = "";
		if ($issue_list->isGridAdd()) {
		} else {
			$issue_list->loadRowValues($issue_list->Recordset); // Load row values
		}
		$issue->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$issue->RowAttrs->merge(["data-rowindex" => $issue_list->RowCount, "id" => "r" . $issue_list->RowCount . "_issue", "data-rowtype" => $issue->RowType]);

		// Render row
		$issue_list->renderRow();

		// Render list options
		$issue_list->renderListOptions();
?>
	<tr <?php echo $issue->rowAttributes() ?>>
<?php

// Render list options (body, left)
$issue_list->ListOptions->render("body", "left", $issue_list->RowCount);
?>
	<?php if ($issue_list->fmea->Visible) { // fmea ?>
		<td data-name="fmea" <?php echo $issue_list->fmea->cellAttributes() ?>>
<span id="el<?php echo $issue_list->RowCount ?>_issue_fmea">
<span<?php echo $issue_list->fmea->viewAttributes() ?>><?php echo $issue_list->fmea->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($issue_list->issue->Visible) { // issue ?>
		<td data-name="issue" <?php echo $issue_list->issue->cellAttributes() ?>>
<span id="el<?php echo $issue_list->RowCount ?>_issue_issue">
<span<?php echo $issue_list->issue->viewAttributes() ?>><?php echo $issue_list->issue->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($issue_list->date->Visible) { // date ?>
		<td data-name="date" <?php echo $issue_list->date->cellAttributes() ?>>
<span id="el<?php echo $issue_list->RowCount ?>_issue_date">
<span<?php echo $issue_list->date->viewAttributes() ?>><?php echo $issue_list->date->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($issue_list->cause->Visible) { // cause ?>
		<td data-name="cause" <?php echo $issue_list->cause->cellAttributes() ?>>
<span id="el<?php echo $issue_list->RowCount ?>_issue_cause">
<span<?php echo $issue_list->cause->viewAttributes() ?>><?php echo $issue_list->cause->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($issue_list->leader->Visible) { // leader ?>
		<td data-name="leader" <?php echo $issue_list->leader->cellAttributes() ?>>
<span id="el<?php echo $issue_list->RowCount ?>_issue_leader">
<span<?php echo $issue_list->leader->viewAttributes() ?>><?php echo $issue_list->leader->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($issue_list->employee->Visible) { // employee ?>
		<td data-name="employee" <?php echo $issue_list->employee->cellAttributes() ?>>
<span id="el<?php echo $issue_list->RowCount ?>_issue_employee">
<span<?php echo $issue_list->employee->viewAttributes() ?>><?php echo $issue_list->employee->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$issue_list->ListOptions->render("body", "right", $issue_list->RowCount);
?>
	</tr>
<?php
	}
	if (!$issue_list->isGridAdd())
		$issue_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$issue->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($issue_list->Recordset)
	$issue_list->Recordset->Close();
?>
<?php if (!$issue_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$issue_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $issue_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $issue_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($issue_list->TotalRecords == 0 && !$issue->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $issue_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$issue_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$issue_list->isExport()) { ?>
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
$issue_list->terminate();
?>