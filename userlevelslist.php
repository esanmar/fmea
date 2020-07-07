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
$userlevels_list = new userlevels_list();

// Run the page
$userlevels_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$userlevels_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$userlevels_list->isExport()) { ?>
<script>
var fuserlevelslist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	fuserlevelslist = currentForm = new ew.Form("fuserlevelslist", "list");
	fuserlevelslist.formKeyCountName = '<?php echo $userlevels_list->FormKeyCountName ?>';
	loadjs.done("fuserlevelslist");
});
var fuserlevelslistsrch;
loadjs.ready("head", function() {

	// Form object for search
	fuserlevelslistsrch = currentSearchForm = new ew.Form("fuserlevelslistsrch");

	// Dynamic selection lists
	// Filters

	fuserlevelslistsrch.filterList = <?php echo $userlevels_list->getFilterList() ?>;
	loadjs.done("fuserlevelslistsrch");
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
<?php if (!$userlevels_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($userlevels_list->TotalRecords > 0 && $userlevels_list->ExportOptions->visible()) { ?>
<?php $userlevels_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($userlevels_list->ImportOptions->visible()) { ?>
<?php $userlevels_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($userlevels_list->SearchOptions->visible()) { ?>
<?php $userlevels_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($userlevels_list->FilterOptions->visible()) { ?>
<?php $userlevels_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$userlevels_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$userlevels_list->isExport() && !$userlevels->CurrentAction) { ?>
<form name="fuserlevelslistsrch" id="fuserlevelslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="fuserlevelslistsrch-search-panel" class="<?php echo $userlevels_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="userlevels">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $userlevels_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($userlevels_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($userlevels_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $userlevels_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($userlevels_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($userlevels_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($userlevels_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($userlevels_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $userlevels_list->showPageHeader(); ?>
<?php
$userlevels_list->showMessage();
?>
<?php if ($userlevels_list->TotalRecords > 0 || $userlevels->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($userlevels_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> userlevels">
<?php if (!$userlevels_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$userlevels_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $userlevels_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $userlevels_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fuserlevelslist" id="fuserlevelslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="userlevels">
<div id="gmp_userlevels" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($userlevels_list->TotalRecords > 0 || $userlevels_list->isGridEdit()) { ?>
<table id="tbl_userlevelslist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$userlevels->RowType = ROWTYPE_HEADER;

// Render list options
$userlevels_list->renderListOptions();

// Render list options (header, left)
$userlevels_list->ListOptions->render("header", "left");
?>
<?php if ($userlevels_list->userlevelid->Visible) { // userlevelid ?>
	<?php if ($userlevels_list->SortUrl($userlevels_list->userlevelid) == "") { ?>
		<th data-name="userlevelid" class="<?php echo $userlevels_list->userlevelid->headerCellClass() ?>"><div id="elh_userlevels_userlevelid" class="userlevels_userlevelid"><div class="ew-table-header-caption"><?php echo $userlevels_list->userlevelid->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="userlevelid" class="<?php echo $userlevels_list->userlevelid->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $userlevels_list->SortUrl($userlevels_list->userlevelid) ?>', 2);"><div id="elh_userlevels_userlevelid" class="userlevels_userlevelid">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $userlevels_list->userlevelid->caption() ?></span><span class="ew-table-header-sort"><?php if ($userlevels_list->userlevelid->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($userlevels_list->userlevelid->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($userlevels_list->userlevelname->Visible) { // userlevelname ?>
	<?php if ($userlevels_list->SortUrl($userlevels_list->userlevelname) == "") { ?>
		<th data-name="userlevelname" class="<?php echo $userlevels_list->userlevelname->headerCellClass() ?>"><div id="elh_userlevels_userlevelname" class="userlevels_userlevelname"><div class="ew-table-header-caption"><?php echo $userlevels_list->userlevelname->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="userlevelname" class="<?php echo $userlevels_list->userlevelname->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $userlevels_list->SortUrl($userlevels_list->userlevelname) ?>', 2);"><div id="elh_userlevels_userlevelname" class="userlevels_userlevelname">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $userlevels_list->userlevelname->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($userlevels_list->userlevelname->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($userlevels_list->userlevelname->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$userlevels_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($userlevels_list->ExportAll && $userlevels_list->isExport()) {
	$userlevels_list->StopRecord = $userlevels_list->TotalRecords;
} else {

	// Set the last record to display
	if ($userlevels_list->TotalRecords > $userlevels_list->StartRecord + $userlevels_list->DisplayRecords - 1)
		$userlevels_list->StopRecord = $userlevels_list->StartRecord + $userlevels_list->DisplayRecords - 1;
	else
		$userlevels_list->StopRecord = $userlevels_list->TotalRecords;
}
$userlevels_list->RecordCount = $userlevels_list->StartRecord - 1;
if ($userlevels_list->Recordset && !$userlevels_list->Recordset->EOF) {
	$userlevels_list->Recordset->moveFirst();
	$selectLimit = $userlevels_list->UseSelectLimit;
	if (!$selectLimit && $userlevels_list->StartRecord > 1)
		$userlevels_list->Recordset->move($userlevels_list->StartRecord - 1);
} elseif (!$userlevels->AllowAddDeleteRow && $userlevels_list->StopRecord == 0) {
	$userlevels_list->StopRecord = $userlevels->GridAddRowCount;
}

// Initialize aggregate
$userlevels->RowType = ROWTYPE_AGGREGATEINIT;
$userlevels->resetAttributes();
$userlevels_list->renderRow();
while ($userlevels_list->RecordCount < $userlevels_list->StopRecord) {
	$userlevels_list->RecordCount++;
	if ($userlevels_list->RecordCount >= $userlevels_list->StartRecord) {
		$userlevels_list->RowCount++;

		// Set up key count
		$userlevels_list->KeyCount = $userlevels_list->RowIndex;

		// Init row class and style
		$userlevels->resetAttributes();
		$userlevels->CssClass = "";
		if ($userlevels_list->isGridAdd()) {
		} else {
			$userlevels_list->loadRowValues($userlevels_list->Recordset); // Load row values
		}
		$userlevels->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$userlevels->RowAttrs->merge(["data-rowindex" => $userlevels_list->RowCount, "id" => "r" . $userlevels_list->RowCount . "_userlevels", "data-rowtype" => $userlevels->RowType]);

		// Render row
		$userlevels_list->renderRow();

		// Render list options
		$userlevels_list->renderListOptions();
?>
	<tr <?php echo $userlevels->rowAttributes() ?>>
<?php

// Render list options (body, left)
$userlevels_list->ListOptions->render("body", "left", $userlevels_list->RowCount);
?>
	<?php if ($userlevels_list->userlevelid->Visible) { // userlevelid ?>
		<td data-name="userlevelid" <?php echo $userlevels_list->userlevelid->cellAttributes() ?>>
<span id="el<?php echo $userlevels_list->RowCount ?>_userlevels_userlevelid">
<span<?php echo $userlevels_list->userlevelid->viewAttributes() ?>><?php echo $userlevels_list->userlevelid->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($userlevels_list->userlevelname->Visible) { // userlevelname ?>
		<td data-name="userlevelname" <?php echo $userlevels_list->userlevelname->cellAttributes() ?>>
<span id="el<?php echo $userlevels_list->RowCount ?>_userlevels_userlevelname">
<span<?php echo $userlevels_list->userlevelname->viewAttributes() ?>><?php echo $userlevels_list->userlevelname->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$userlevels_list->ListOptions->render("body", "right", $userlevels_list->RowCount);
?>
	</tr>
<?php
	}
	if (!$userlevels_list->isGridAdd())
		$userlevels_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$userlevels->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($userlevels_list->Recordset)
	$userlevels_list->Recordset->Close();
?>
<?php if (!$userlevels_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$userlevels_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $userlevels_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $userlevels_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($userlevels_list->TotalRecords == 0 && !$userlevels->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $userlevels_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$userlevels_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$userlevels_list->isExport()) { ?>
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
$userlevels_list->terminate();
?>