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
$reportfmea_list = new reportfmea_list();

// Run the page
$reportfmea_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$reportfmea_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$reportfmea_list->isExport()) { ?>
<script>
var freportfmealist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	freportfmealist = currentForm = new ew.Form("freportfmealist", "list");
	freportfmealist.formKeyCountName = '<?php echo $reportfmea_list->FormKeyCountName ?>';
	loadjs.done("freportfmealist");
});
var freportfmealistsrch;
loadjs.ready("head", function() {

	// Form object for search
	freportfmealistsrch = currentSearchForm = new ew.Form("freportfmealistsrch");

	// Dynamic selection lists
	// Filters

	freportfmealistsrch.filterList = <?php echo $reportfmea_list->getFilterList() ?>;
	loadjs.done("freportfmealistsrch");
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
<?php if (!$reportfmea_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($reportfmea_list->TotalRecords > 0 && $reportfmea_list->ExportOptions->visible()) { ?>
<?php $reportfmea_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($reportfmea_list->ImportOptions->visible()) { ?>
<?php $reportfmea_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($reportfmea_list->SearchOptions->visible()) { ?>
<?php $reportfmea_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($reportfmea_list->FilterOptions->visible()) { ?>
<?php $reportfmea_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$reportfmea_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$reportfmea_list->isExport() && !$reportfmea->CurrentAction) { ?>
<form name="freportfmealistsrch" id="freportfmealistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="freportfmealistsrch-search-panel" class="<?php echo $reportfmea_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="reportfmea">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $reportfmea_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($reportfmea_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($reportfmea_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $reportfmea_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($reportfmea_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($reportfmea_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($reportfmea_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($reportfmea_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $reportfmea_list->showPageHeader(); ?>
<?php
$reportfmea_list->showMessage();
?>
<?php if ($reportfmea_list->TotalRecords > 0 || $reportfmea->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($reportfmea_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> reportfmea">
<?php if (!$reportfmea_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$reportfmea_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $reportfmea_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $reportfmea_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="freportfmealist" id="freportfmealist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="reportfmea">
<div id="gmp_reportfmea" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($reportfmea_list->TotalRecords > 0 || $reportfmea_list->isGridEdit()) { ?>
<table id="tbl_reportfmealist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$reportfmea->RowType = ROWTYPE_HEADER;

// Render list options
$reportfmea_list->renderListOptions();

// Render list options (header, left)
$reportfmea_list->ListOptions->render("header", "left");
?>
<?php if ($reportfmea_list->fmea->Visible) { // fmea ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->fmea) == "") { ?>
		<th data-name="fmea" class="<?php echo $reportfmea_list->fmea->headerCellClass() ?>"><div id="elh_reportfmea_fmea" class="reportfmea_fmea"><div class="ew-table-header-caption"><?php echo $reportfmea_list->fmea->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fmea" class="<?php echo $reportfmea_list->fmea->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->fmea) ?>', 2);"><div id="elh_reportfmea_fmea" class="reportfmea_fmea">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->fmea->caption() ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->fmea->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->fmea->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->idFactory->Visible) { // idFactory ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->idFactory) == "") { ?>
		<th data-name="idFactory" class="<?php echo $reportfmea_list->idFactory->headerCellClass() ?>"><div id="elh_reportfmea_idFactory" class="reportfmea_idFactory"><div class="ew-table-header-caption"><?php echo $reportfmea_list->idFactory->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idFactory" class="<?php echo $reportfmea_list->idFactory->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->idFactory) ?>', 2);"><div id="elh_reportfmea_idFactory" class="reportfmea_idFactory">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->idFactory->caption() ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->idFactory->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->idFactory->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->dateFmea->Visible) { // dateFmea ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->dateFmea) == "") { ?>
		<th data-name="dateFmea" class="<?php echo $reportfmea_list->dateFmea->headerCellClass() ?>"><div id="elh_reportfmea_dateFmea" class="reportfmea_dateFmea"><div class="ew-table-header-caption"><?php echo $reportfmea_list->dateFmea->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="dateFmea" class="<?php echo $reportfmea_list->dateFmea->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->dateFmea) ?>', 2);"><div id="elh_reportfmea_dateFmea" class="reportfmea_dateFmea">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->dateFmea->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->dateFmea->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->dateFmea->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->partnumbers->Visible) { // partnumbers ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->partnumbers) == "") { ?>
		<th data-name="partnumbers" class="<?php echo $reportfmea_list->partnumbers->headerCellClass() ?>"><div id="elh_reportfmea_partnumbers" class="reportfmea_partnumbers"><div class="ew-table-header-caption"><?php echo $reportfmea_list->partnumbers->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="partnumbers" class="<?php echo $reportfmea_list->partnumbers->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->partnumbers) ?>', 2);"><div id="elh_reportfmea_partnumbers" class="reportfmea_partnumbers">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->partnumbers->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->partnumbers->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->partnumbers->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->description->Visible) { // description ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->description) == "") { ?>
		<th data-name="description" class="<?php echo $reportfmea_list->description->headerCellClass() ?>"><div id="elh_reportfmea_description" class="reportfmea_description"><div class="ew-table-header-caption"><?php echo $reportfmea_list->description->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="description" class="<?php echo $reportfmea_list->description->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->description) ?>', 2);"><div id="elh_reportfmea_description" class="reportfmea_description">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->description->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->description->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->description->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->idEmployee->Visible) { // idEmployee ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->idEmployee) == "") { ?>
		<th data-name="idEmployee" class="<?php echo $reportfmea_list->idEmployee->headerCellClass() ?>"><div id="elh_reportfmea_idEmployee" class="reportfmea_idEmployee"><div class="ew-table-header-caption"><?php echo $reportfmea_list->idEmployee->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idEmployee" class="<?php echo $reportfmea_list->idEmployee->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->idEmployee) ?>', 2);"><div id="elh_reportfmea_idEmployee" class="reportfmea_idEmployee">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->idEmployee->caption() ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->idEmployee->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->idEmployee->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->idworkcenter->Visible) { // idworkcenter ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->idworkcenter) == "") { ?>
		<th data-name="idworkcenter" class="<?php echo $reportfmea_list->idworkcenter->headerCellClass() ?>"><div id="elh_reportfmea_idworkcenter" class="reportfmea_idworkcenter"><div class="ew-table-header-caption"><?php echo $reportfmea_list->idworkcenter->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idworkcenter" class="<?php echo $reportfmea_list->idworkcenter->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->idworkcenter) ?>', 2);"><div id="elh_reportfmea_idworkcenter" class="reportfmea_idworkcenter">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->idworkcenter->caption() ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->idworkcenter->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->idworkcenter->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->idProcess->Visible) { // idProcess ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->idProcess) == "") { ?>
		<th data-name="idProcess" class="<?php echo $reportfmea_list->idProcess->headerCellClass() ?>"><div id="elh_reportfmea_idProcess" class="reportfmea_idProcess"><div class="ew-table-header-caption"><?php echo $reportfmea_list->idProcess->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idProcess" class="<?php echo $reportfmea_list->idProcess->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->idProcess) ?>', 2);"><div id="elh_reportfmea_idProcess" class="reportfmea_idProcess">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->idProcess->caption() ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->idProcess->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->idProcess->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->step->Visible) { // step ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->step) == "") { ?>
		<th data-name="step" class="<?php echo $reportfmea_list->step->headerCellClass() ?>"><div id="elh_reportfmea_step" class="reportfmea_step"><div class="ew-table-header-caption"><?php echo $reportfmea_list->step->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="step" class="<?php echo $reportfmea_list->step->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->step) ?>', 2);"><div id="elh_reportfmea_step" class="reportfmea_step">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->step->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->step->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->step->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->flowchartDesc->Visible) { // flowchartDesc ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->flowchartDesc) == "") { ?>
		<th data-name="flowchartDesc" class="<?php echo $reportfmea_list->flowchartDesc->headerCellClass() ?>"><div id="elh_reportfmea_flowchartDesc" class="reportfmea_flowchartDesc"><div class="ew-table-header-caption"><?php echo $reportfmea_list->flowchartDesc->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="flowchartDesc" class="<?php echo $reportfmea_list->flowchartDesc->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->flowchartDesc) ?>', 2);"><div id="elh_reportfmea_flowchartDesc" class="reportfmea_flowchartDesc">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->flowchartDesc->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->flowchartDesc->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->flowchartDesc->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->partnumber->Visible) { // partnumber ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->partnumber) == "") { ?>
		<th data-name="partnumber" class="<?php echo $reportfmea_list->partnumber->headerCellClass() ?>"><div id="elh_reportfmea_partnumber" class="reportfmea_partnumber"><div class="ew-table-header-caption"><?php echo $reportfmea_list->partnumber->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="partnumber" class="<?php echo $reportfmea_list->partnumber->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->partnumber) ?>', 2);"><div id="elh_reportfmea_partnumber" class="reportfmea_partnumber">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->partnumber->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->partnumber->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->partnumber->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->operation->Visible) { // operation ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->operation) == "") { ?>
		<th data-name="operation" class="<?php echo $reportfmea_list->operation->headerCellClass() ?>"><div id="elh_reportfmea_operation" class="reportfmea_operation"><div class="ew-table-header-caption"><?php echo $reportfmea_list->operation->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="operation" class="<?php echo $reportfmea_list->operation->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->operation) ?>', 2);"><div id="elh_reportfmea_operation" class="reportfmea_operation">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->operation->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->operation->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->operation->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->derivedFromNC->Visible) { // derivedFromNC ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->derivedFromNC) == "") { ?>
		<th data-name="derivedFromNC" class="<?php echo $reportfmea_list->derivedFromNC->headerCellClass() ?>"><div id="elh_reportfmea_derivedFromNC" class="reportfmea_derivedFromNC"><div class="ew-table-header-caption"><?php echo $reportfmea_list->derivedFromNC->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="derivedFromNC" class="<?php echo $reportfmea_list->derivedFromNC->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->derivedFromNC) ?>', 2);"><div id="elh_reportfmea_derivedFromNC" class="reportfmea_derivedFromNC">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->derivedFromNC->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->derivedFromNC->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->derivedFromNC->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->numberOfNC->Visible) { // numberOfNC ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->numberOfNC) == "") { ?>
		<th data-name="numberOfNC" class="<?php echo $reportfmea_list->numberOfNC->headerCellClass() ?>"><div id="elh_reportfmea_numberOfNC" class="reportfmea_numberOfNC"><div class="ew-table-header-caption"><?php echo $reportfmea_list->numberOfNC->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="numberOfNC" class="<?php echo $reportfmea_list->numberOfNC->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->numberOfNC) ?>', 2);"><div id="elh_reportfmea_numberOfNC" class="reportfmea_numberOfNC">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->numberOfNC->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->numberOfNC->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->numberOfNC->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->flowchart->Visible) { // flowchart ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->flowchart) == "") { ?>
		<th data-name="flowchart" class="<?php echo $reportfmea_list->flowchart->headerCellClass() ?>"><div id="elh_reportfmea_flowchart" class="reportfmea_flowchart"><div class="ew-table-header-caption"><?php echo $reportfmea_list->flowchart->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="flowchart" class="<?php echo $reportfmea_list->flowchart->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->flowchart) ?>', 2);"><div id="elh_reportfmea_flowchart" class="reportfmea_flowchart">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->flowchart->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->flowchart->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->flowchart->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->subprocess->Visible) { // subprocess ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->subprocess) == "") { ?>
		<th data-name="subprocess" class="<?php echo $reportfmea_list->subprocess->headerCellClass() ?>"><div id="elh_reportfmea_subprocess" class="reportfmea_subprocess"><div class="ew-table-header-caption"><?php echo $reportfmea_list->subprocess->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="subprocess" class="<?php echo $reportfmea_list->subprocess->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->subprocess) ?>', 2);"><div id="elh_reportfmea_subprocess" class="reportfmea_subprocess">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->subprocess->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->subprocess->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->subprocess->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->requirement->Visible) { // requirement ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->requirement) == "") { ?>
		<th data-name="requirement" class="<?php echo $reportfmea_list->requirement->headerCellClass() ?>"><div id="elh_reportfmea_requirement" class="reportfmea_requirement"><div class="ew-table-header-caption"><?php echo $reportfmea_list->requirement->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="requirement" class="<?php echo $reportfmea_list->requirement->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->requirement) ?>', 2);"><div id="elh_reportfmea_requirement" class="reportfmea_requirement">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->requirement->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->requirement->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->requirement->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->potencialFailureMode->Visible) { // potencialFailureMode ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->potencialFailureMode) == "") { ?>
		<th data-name="potencialFailureMode" class="<?php echo $reportfmea_list->potencialFailureMode->headerCellClass() ?>"><div id="elh_reportfmea_potencialFailureMode" class="reportfmea_potencialFailureMode"><div class="ew-table-header-caption"><?php echo $reportfmea_list->potencialFailureMode->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="potencialFailureMode" class="<?php echo $reportfmea_list->potencialFailureMode->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->potencialFailureMode) ?>', 2);"><div id="elh_reportfmea_potencialFailureMode" class="reportfmea_potencialFailureMode">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->potencialFailureMode->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->potencialFailureMode->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->potencialFailureMode->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->potencialFailurEffect->Visible) { // potencialFailurEffect ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->potencialFailurEffect) == "") { ?>
		<th data-name="potencialFailurEffect" class="<?php echo $reportfmea_list->potencialFailurEffect->headerCellClass() ?>"><div id="elh_reportfmea_potencialFailurEffect" class="reportfmea_potencialFailurEffect"><div class="ew-table-header-caption"><?php echo $reportfmea_list->potencialFailurEffect->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="potencialFailurEffect" class="<?php echo $reportfmea_list->potencialFailurEffect->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->potencialFailurEffect) ?>', 2);"><div id="elh_reportfmea_potencialFailurEffect" class="reportfmea_potencialFailurEffect">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->potencialFailurEffect->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->potencialFailurEffect->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->potencialFailurEffect->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->kc->Visible) { // kc ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->kc) == "") { ?>
		<th data-name="kc" class="<?php echo $reportfmea_list->kc->headerCellClass() ?>"><div id="elh_reportfmea_kc" class="reportfmea_kc"><div class="ew-table-header-caption"><?php echo $reportfmea_list->kc->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kc" class="<?php echo $reportfmea_list->kc->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->kc) ?>', 2);"><div id="elh_reportfmea_kc" class="reportfmea_kc">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->kc->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->kc->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->kc->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->severity->Visible) { // severity ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->severity) == "") { ?>
		<th data-name="severity" class="<?php echo $reportfmea_list->severity->headerCellClass() ?>"><div id="elh_reportfmea_severity" class="reportfmea_severity"><div class="ew-table-header-caption"><?php echo $reportfmea_list->severity->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="severity" class="<?php echo $reportfmea_list->severity->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->severity) ?>', 2);"><div id="elh_reportfmea_severity" class="reportfmea_severity">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->severity->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->severity->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->severity->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->idCause->Visible) { // idCause ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->idCause) == "") { ?>
		<th data-name="idCause" class="<?php echo $reportfmea_list->idCause->headerCellClass() ?>"><div id="elh_reportfmea_idCause" class="reportfmea_idCause"><div class="ew-table-header-caption"><?php echo $reportfmea_list->idCause->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idCause" class="<?php echo $reportfmea_list->idCause->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->idCause) ?>', 2);"><div id="elh_reportfmea_idCause" class="reportfmea_idCause">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->idCause->caption() ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->idCause->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->idCause->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->potentialCauses->Visible) { // potentialCauses ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->potentialCauses) == "") { ?>
		<th data-name="potentialCauses" class="<?php echo $reportfmea_list->potentialCauses->headerCellClass() ?>"><div id="elh_reportfmea_potentialCauses" class="reportfmea_potentialCauses"><div class="ew-table-header-caption"><?php echo $reportfmea_list->potentialCauses->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="potentialCauses" class="<?php echo $reportfmea_list->potentialCauses->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->potentialCauses) ?>', 2);"><div id="elh_reportfmea_potentialCauses" class="reportfmea_potentialCauses">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->potentialCauses->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->potentialCauses->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->potentialCauses->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->currentPreventiveControlMethod->Visible) { // currentPreventiveControlMethod ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->currentPreventiveControlMethod) == "") { ?>
		<th data-name="currentPreventiveControlMethod" class="<?php echo $reportfmea_list->currentPreventiveControlMethod->headerCellClass() ?>"><div id="elh_reportfmea_currentPreventiveControlMethod" class="reportfmea_currentPreventiveControlMethod"><div class="ew-table-header-caption"><?php echo $reportfmea_list->currentPreventiveControlMethod->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="currentPreventiveControlMethod" class="<?php echo $reportfmea_list->currentPreventiveControlMethod->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->currentPreventiveControlMethod) ?>', 2);"><div id="elh_reportfmea_currentPreventiveControlMethod" class="reportfmea_currentPreventiveControlMethod">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->currentPreventiveControlMethod->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->currentPreventiveControlMethod->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->currentPreventiveControlMethod->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->occurrence->Visible) { // occurrence ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->occurrence) == "") { ?>
		<th data-name="occurrence" class="<?php echo $reportfmea_list->occurrence->headerCellClass() ?>"><div id="elh_reportfmea_occurrence" class="reportfmea_occurrence"><div class="ew-table-header-caption"><?php echo $reportfmea_list->occurrence->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="occurrence" class="<?php echo $reportfmea_list->occurrence->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->occurrence) ?>', 2);"><div id="elh_reportfmea_occurrence" class="reportfmea_occurrence">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->occurrence->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->occurrence->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->occurrence->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->currentControlMethod->Visible) { // currentControlMethod ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->currentControlMethod) == "") { ?>
		<th data-name="currentControlMethod" class="<?php echo $reportfmea_list->currentControlMethod->headerCellClass() ?>"><div id="elh_reportfmea_currentControlMethod" class="reportfmea_currentControlMethod"><div class="ew-table-header-caption"><?php echo $reportfmea_list->currentControlMethod->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="currentControlMethod" class="<?php echo $reportfmea_list->currentControlMethod->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->currentControlMethod) ?>', 2);"><div id="elh_reportfmea_currentControlMethod" class="reportfmea_currentControlMethod">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->currentControlMethod->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->currentControlMethod->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->currentControlMethod->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->detection->Visible) { // detection ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->detection) == "") { ?>
		<th data-name="detection" class="<?php echo $reportfmea_list->detection->headerCellClass() ?>"><div id="elh_reportfmea_detection" class="reportfmea_detection"><div class="ew-table-header-caption"><?php echo $reportfmea_list->detection->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="detection" class="<?php echo $reportfmea_list->detection->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->detection) ?>', 2);"><div id="elh_reportfmea_detection" class="reportfmea_detection">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->detection->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->detection->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->detection->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->rpn->Visible) { // rpn ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->rpn) == "") { ?>
		<th data-name="rpn" class="<?php echo $reportfmea_list->rpn->headerCellClass() ?>"><div id="elh_reportfmea_rpn" class="reportfmea_rpn"><div class="ew-table-header-caption"><?php echo $reportfmea_list->rpn->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="rpn" class="<?php echo $reportfmea_list->rpn->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->rpn) ?>', 2);"><div id="elh_reportfmea_rpn" class="reportfmea_rpn">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->rpn->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->rpn->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->rpn->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->recomendedAction->Visible) { // recomendedAction ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->recomendedAction) == "") { ?>
		<th data-name="recomendedAction" class="<?php echo $reportfmea_list->recomendedAction->headerCellClass() ?>"><div id="elh_reportfmea_recomendedAction" class="reportfmea_recomendedAction"><div class="ew-table-header-caption"><?php echo $reportfmea_list->recomendedAction->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="recomendedAction" class="<?php echo $reportfmea_list->recomendedAction->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->recomendedAction) ?>', 2);"><div id="elh_reportfmea_recomendedAction" class="reportfmea_recomendedAction">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->recomendedAction->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->recomendedAction->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->recomendedAction->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->idResponsible->Visible) { // idResponsible ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->idResponsible) == "") { ?>
		<th data-name="idResponsible" class="<?php echo $reportfmea_list->idResponsible->headerCellClass() ?>"><div id="elh_reportfmea_idResponsible" class="reportfmea_idResponsible"><div class="ew-table-header-caption"><?php echo $reportfmea_list->idResponsible->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idResponsible" class="<?php echo $reportfmea_list->idResponsible->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->idResponsible) ?>', 2);"><div id="elh_reportfmea_idResponsible" class="reportfmea_idResponsible">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->idResponsible->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->idResponsible->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->idResponsible->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->targetDate->Visible) { // targetDate ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->targetDate) == "") { ?>
		<th data-name="targetDate" class="<?php echo $reportfmea_list->targetDate->headerCellClass() ?>"><div id="elh_reportfmea_targetDate" class="reportfmea_targetDate"><div class="ew-table-header-caption"><?php echo $reportfmea_list->targetDate->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="targetDate" class="<?php echo $reportfmea_list->targetDate->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->targetDate) ?>', 2);"><div id="elh_reportfmea_targetDate" class="reportfmea_targetDate">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->targetDate->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->targetDate->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->targetDate->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->revisedKc->Visible) { // revisedKc ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->revisedKc) == "") { ?>
		<th data-name="revisedKc" class="<?php echo $reportfmea_list->revisedKc->headerCellClass() ?>"><div id="elh_reportfmea_revisedKc" class="reportfmea_revisedKc"><div class="ew-table-header-caption"><?php echo $reportfmea_list->revisedKc->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="revisedKc" class="<?php echo $reportfmea_list->revisedKc->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->revisedKc) ?>', 2);"><div id="elh_reportfmea_revisedKc" class="reportfmea_revisedKc">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->revisedKc->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->revisedKc->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->revisedKc->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->expectedSeverity->Visible) { // expectedSeverity ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->expectedSeverity) == "") { ?>
		<th data-name="expectedSeverity" class="<?php echo $reportfmea_list->expectedSeverity->headerCellClass() ?>"><div id="elh_reportfmea_expectedSeverity" class="reportfmea_expectedSeverity"><div class="ew-table-header-caption"><?php echo $reportfmea_list->expectedSeverity->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="expectedSeverity" class="<?php echo $reportfmea_list->expectedSeverity->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->expectedSeverity) ?>', 2);"><div id="elh_reportfmea_expectedSeverity" class="reportfmea_expectedSeverity">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->expectedSeverity->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->expectedSeverity->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->expectedSeverity->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->expectedOccurrence->Visible) { // expectedOccurrence ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->expectedOccurrence) == "") { ?>
		<th data-name="expectedOccurrence" class="<?php echo $reportfmea_list->expectedOccurrence->headerCellClass() ?>"><div id="elh_reportfmea_expectedOccurrence" class="reportfmea_expectedOccurrence"><div class="ew-table-header-caption"><?php echo $reportfmea_list->expectedOccurrence->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="expectedOccurrence" class="<?php echo $reportfmea_list->expectedOccurrence->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->expectedOccurrence) ?>', 2);"><div id="elh_reportfmea_expectedOccurrence" class="reportfmea_expectedOccurrence">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->expectedOccurrence->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->expectedOccurrence->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->expectedOccurrence->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->expectedDetection->Visible) { // expectedDetection ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->expectedDetection) == "") { ?>
		<th data-name="expectedDetection" class="<?php echo $reportfmea_list->expectedDetection->headerCellClass() ?>"><div id="elh_reportfmea_expectedDetection" class="reportfmea_expectedDetection"><div class="ew-table-header-caption"><?php echo $reportfmea_list->expectedDetection->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="expectedDetection" class="<?php echo $reportfmea_list->expectedDetection->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->expectedDetection) ?>', 2);"><div id="elh_reportfmea_expectedDetection" class="reportfmea_expectedDetection">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->expectedDetection->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->expectedDetection->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->expectedDetection->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->expectedRpn->Visible) { // expectedRpn ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->expectedRpn) == "") { ?>
		<th data-name="expectedRpn" class="<?php echo $reportfmea_list->expectedRpn->headerCellClass() ?>"><div id="elh_reportfmea_expectedRpn" class="reportfmea_expectedRpn"><div class="ew-table-header-caption"><?php echo $reportfmea_list->expectedRpn->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="expectedRpn" class="<?php echo $reportfmea_list->expectedRpn->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->expectedRpn) ?>', 2);"><div id="elh_reportfmea_expectedRpn" class="reportfmea_expectedRpn">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->expectedRpn->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->expectedRpn->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->expectedRpn->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->expectedClosureDate->Visible) { // expectedClosureDate ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->expectedClosureDate) == "") { ?>
		<th data-name="expectedClosureDate" class="<?php echo $reportfmea_list->expectedClosureDate->headerCellClass() ?>"><div id="elh_reportfmea_expectedClosureDate" class="reportfmea_expectedClosureDate"><div class="ew-table-header-caption"><?php echo $reportfmea_list->expectedClosureDate->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="expectedClosureDate" class="<?php echo $reportfmea_list->expectedClosureDate->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->expectedClosureDate) ?>', 2);"><div id="elh_reportfmea_expectedClosureDate" class="reportfmea_expectedClosureDate">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->expectedClosureDate->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->expectedClosureDate->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->expectedClosureDate->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->recomendedActiondet->Visible) { // recomendedActiondet ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->recomendedActiondet) == "") { ?>
		<th data-name="recomendedActiondet" class="<?php echo $reportfmea_list->recomendedActiondet->headerCellClass() ?>"><div id="elh_reportfmea_recomendedActiondet" class="reportfmea_recomendedActiondet"><div class="ew-table-header-caption"><?php echo $reportfmea_list->recomendedActiondet->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="recomendedActiondet" class="<?php echo $reportfmea_list->recomendedActiondet->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->recomendedActiondet) ?>', 2);"><div id="elh_reportfmea_recomendedActiondet" class="reportfmea_recomendedActiondet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->recomendedActiondet->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->recomendedActiondet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->recomendedActiondet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->idResponsibleDet->Visible) { // idResponsibleDet ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->idResponsibleDet) == "") { ?>
		<th data-name="idResponsibleDet" class="<?php echo $reportfmea_list->idResponsibleDet->headerCellClass() ?>"><div id="elh_reportfmea_idResponsibleDet" class="reportfmea_idResponsibleDet"><div class="ew-table-header-caption"><?php echo $reportfmea_list->idResponsibleDet->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idResponsibleDet" class="<?php echo $reportfmea_list->idResponsibleDet->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->idResponsibleDet) ?>', 2);"><div id="elh_reportfmea_idResponsibleDet" class="reportfmea_idResponsibleDet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->idResponsibleDet->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->idResponsibleDet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->idResponsibleDet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->targetDatedet->Visible) { // targetDatedet ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->targetDatedet) == "") { ?>
		<th data-name="targetDatedet" class="<?php echo $reportfmea_list->targetDatedet->headerCellClass() ?>"><div id="elh_reportfmea_targetDatedet" class="reportfmea_targetDatedet"><div class="ew-table-header-caption"><?php echo $reportfmea_list->targetDatedet->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="targetDatedet" class="<?php echo $reportfmea_list->targetDatedet->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->targetDatedet) ?>', 2);"><div id="elh_reportfmea_targetDatedet" class="reportfmea_targetDatedet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->targetDatedet->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->targetDatedet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->targetDatedet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->kcdet->Visible) { // kcdet ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->kcdet) == "") { ?>
		<th data-name="kcdet" class="<?php echo $reportfmea_list->kcdet->headerCellClass() ?>"><div id="elh_reportfmea_kcdet" class="reportfmea_kcdet"><div class="ew-table-header-caption"><?php echo $reportfmea_list->kcdet->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kcdet" class="<?php echo $reportfmea_list->kcdet->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->kcdet) ?>', 2);"><div id="elh_reportfmea_kcdet" class="reportfmea_kcdet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->kcdet->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->kcdet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->kcdet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->expectedSeveritydet->Visible) { // expectedSeveritydet ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->expectedSeveritydet) == "") { ?>
		<th data-name="expectedSeveritydet" class="<?php echo $reportfmea_list->expectedSeveritydet->headerCellClass() ?>"><div id="elh_reportfmea_expectedSeveritydet" class="reportfmea_expectedSeveritydet"><div class="ew-table-header-caption"><?php echo $reportfmea_list->expectedSeveritydet->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="expectedSeveritydet" class="<?php echo $reportfmea_list->expectedSeveritydet->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->expectedSeveritydet) ?>', 2);"><div id="elh_reportfmea_expectedSeveritydet" class="reportfmea_expectedSeveritydet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->expectedSeveritydet->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->expectedSeveritydet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->expectedSeveritydet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->expectedOccurrencedet->Visible) { // expectedOccurrencedet ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->expectedOccurrencedet) == "") { ?>
		<th data-name="expectedOccurrencedet" class="<?php echo $reportfmea_list->expectedOccurrencedet->headerCellClass() ?>"><div id="elh_reportfmea_expectedOccurrencedet" class="reportfmea_expectedOccurrencedet"><div class="ew-table-header-caption"><?php echo $reportfmea_list->expectedOccurrencedet->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="expectedOccurrencedet" class="<?php echo $reportfmea_list->expectedOccurrencedet->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->expectedOccurrencedet) ?>', 2);"><div id="elh_reportfmea_expectedOccurrencedet" class="reportfmea_expectedOccurrencedet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->expectedOccurrencedet->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->expectedOccurrencedet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->expectedOccurrencedet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->expectedDetectiondet->Visible) { // expectedDetectiondet ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->expectedDetectiondet) == "") { ?>
		<th data-name="expectedDetectiondet" class="<?php echo $reportfmea_list->expectedDetectiondet->headerCellClass() ?>"><div id="elh_reportfmea_expectedDetectiondet" class="reportfmea_expectedDetectiondet"><div class="ew-table-header-caption"><?php echo $reportfmea_list->expectedDetectiondet->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="expectedDetectiondet" class="<?php echo $reportfmea_list->expectedDetectiondet->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->expectedDetectiondet) ?>', 2);"><div id="elh_reportfmea_expectedDetectiondet" class="reportfmea_expectedDetectiondet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->expectedDetectiondet->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->expectedDetectiondet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->expectedDetectiondet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->expectedRpndet->Visible) { // expectedRpndet ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->expectedRpndet) == "") { ?>
		<th data-name="expectedRpndet" class="<?php echo $reportfmea_list->expectedRpndet->headerCellClass() ?>"><div id="elh_reportfmea_expectedRpndet" class="reportfmea_expectedRpndet"><div class="ew-table-header-caption"><?php echo $reportfmea_list->expectedRpndet->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="expectedRpndet" class="<?php echo $reportfmea_list->expectedRpndet->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->expectedRpndet) ?>', 2);"><div id="elh_reportfmea_expectedRpndet" class="reportfmea_expectedRpndet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->expectedRpndet->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->expectedRpndet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->expectedRpndet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->revisedClosureDatedet->Visible) { // revisedClosureDatedet ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->revisedClosureDatedet) == "") { ?>
		<th data-name="revisedClosureDatedet" class="<?php echo $reportfmea_list->revisedClosureDatedet->headerCellClass() ?>"><div id="elh_reportfmea_revisedClosureDatedet" class="reportfmea_revisedClosureDatedet"><div class="ew-table-header-caption"><?php echo $reportfmea_list->revisedClosureDatedet->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="revisedClosureDatedet" class="<?php echo $reportfmea_list->revisedClosureDatedet->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->revisedClosureDatedet) ?>', 2);"><div id="elh_reportfmea_revisedClosureDatedet" class="reportfmea_revisedClosureDatedet">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->revisedClosureDatedet->caption() ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->revisedClosureDatedet->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->revisedClosureDatedet->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->revisedClosureDate->Visible) { // revisedClosureDate ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->revisedClosureDate) == "") { ?>
		<th data-name="revisedClosureDate" class="<?php echo $reportfmea_list->revisedClosureDate->headerCellClass() ?>"><div id="elh_reportfmea_revisedClosureDate" class="reportfmea_revisedClosureDate"><div class="ew-table-header-caption"><?php echo $reportfmea_list->revisedClosureDate->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="revisedClosureDate" class="<?php echo $reportfmea_list->revisedClosureDate->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->revisedClosureDate) ?>', 2);"><div id="elh_reportfmea_revisedClosureDate" class="reportfmea_revisedClosureDate">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->revisedClosureDate->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->revisedClosureDate->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->revisedClosureDate->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->perfomedAction->Visible) { // perfomedAction ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->perfomedAction) == "") { ?>
		<th data-name="perfomedAction" class="<?php echo $reportfmea_list->perfomedAction->headerCellClass() ?>"><div id="elh_reportfmea_perfomedAction" class="reportfmea_perfomedAction"><div class="ew-table-header-caption"><?php echo $reportfmea_list->perfomedAction->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="perfomedAction" class="<?php echo $reportfmea_list->perfomedAction->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->perfomedAction) ?>', 2);"><div id="elh_reportfmea_perfomedAction" class="reportfmea_perfomedAction">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->perfomedAction->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->perfomedAction->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->perfomedAction->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->revisedSeverity->Visible) { // revisedSeverity ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->revisedSeverity) == "") { ?>
		<th data-name="revisedSeverity" class="<?php echo $reportfmea_list->revisedSeverity->headerCellClass() ?>"><div id="elh_reportfmea_revisedSeverity" class="reportfmea_revisedSeverity"><div class="ew-table-header-caption"><?php echo $reportfmea_list->revisedSeverity->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="revisedSeverity" class="<?php echo $reportfmea_list->revisedSeverity->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->revisedSeverity) ?>', 2);"><div id="elh_reportfmea_revisedSeverity" class="reportfmea_revisedSeverity">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->revisedSeverity->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->revisedSeverity->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->revisedSeverity->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->revisedOccurrence->Visible) { // revisedOccurrence ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->revisedOccurrence) == "") { ?>
		<th data-name="revisedOccurrence" class="<?php echo $reportfmea_list->revisedOccurrence->headerCellClass() ?>"><div id="elh_reportfmea_revisedOccurrence" class="reportfmea_revisedOccurrence"><div class="ew-table-header-caption"><?php echo $reportfmea_list->revisedOccurrence->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="revisedOccurrence" class="<?php echo $reportfmea_list->revisedOccurrence->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->revisedOccurrence) ?>', 2);"><div id="elh_reportfmea_revisedOccurrence" class="reportfmea_revisedOccurrence">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->revisedOccurrence->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->revisedOccurrence->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->revisedOccurrence->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->revisedDetection->Visible) { // revisedDetection ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->revisedDetection) == "") { ?>
		<th data-name="revisedDetection" class="<?php echo $reportfmea_list->revisedDetection->headerCellClass() ?>"><div id="elh_reportfmea_revisedDetection" class="reportfmea_revisedDetection"><div class="ew-table-header-caption"><?php echo $reportfmea_list->revisedDetection->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="revisedDetection" class="<?php echo $reportfmea_list->revisedDetection->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->revisedDetection) ?>', 2);"><div id="elh_reportfmea_revisedDetection" class="reportfmea_revisedDetection">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->revisedDetection->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->revisedDetection->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->revisedDetection->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($reportfmea_list->revisedRpn->Visible) { // revisedRpn ?>
	<?php if ($reportfmea_list->SortUrl($reportfmea_list->revisedRpn) == "") { ?>
		<th data-name="revisedRpn" class="<?php echo $reportfmea_list->revisedRpn->headerCellClass() ?>"><div id="elh_reportfmea_revisedRpn" class="reportfmea_revisedRpn"><div class="ew-table-header-caption"><?php echo $reportfmea_list->revisedRpn->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="revisedRpn" class="<?php echo $reportfmea_list->revisedRpn->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $reportfmea_list->SortUrl($reportfmea_list->revisedRpn) ?>', 2);"><div id="elh_reportfmea_revisedRpn" class="reportfmea_revisedRpn">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $reportfmea_list->revisedRpn->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($reportfmea_list->revisedRpn->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($reportfmea_list->revisedRpn->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$reportfmea_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($reportfmea_list->ExportAll && $reportfmea_list->isExport()) {
	$reportfmea_list->StopRecord = $reportfmea_list->TotalRecords;
} else {

	// Set the last record to display
	if ($reportfmea_list->TotalRecords > $reportfmea_list->StartRecord + $reportfmea_list->DisplayRecords - 1)
		$reportfmea_list->StopRecord = $reportfmea_list->StartRecord + $reportfmea_list->DisplayRecords - 1;
	else
		$reportfmea_list->StopRecord = $reportfmea_list->TotalRecords;
}
$reportfmea_list->RecordCount = $reportfmea_list->StartRecord - 1;
if ($reportfmea_list->Recordset && !$reportfmea_list->Recordset->EOF) {
	$reportfmea_list->Recordset->moveFirst();
	$selectLimit = $reportfmea_list->UseSelectLimit;
	if (!$selectLimit && $reportfmea_list->StartRecord > 1)
		$reportfmea_list->Recordset->move($reportfmea_list->StartRecord - 1);
} elseif (!$reportfmea->AllowAddDeleteRow && $reportfmea_list->StopRecord == 0) {
	$reportfmea_list->StopRecord = $reportfmea->GridAddRowCount;
}

// Initialize aggregate
$reportfmea->RowType = ROWTYPE_AGGREGATEINIT;
$reportfmea->resetAttributes();
$reportfmea_list->renderRow();
while ($reportfmea_list->RecordCount < $reportfmea_list->StopRecord) {
	$reportfmea_list->RecordCount++;
	if ($reportfmea_list->RecordCount >= $reportfmea_list->StartRecord) {
		$reportfmea_list->RowCount++;

		// Set up key count
		$reportfmea_list->KeyCount = $reportfmea_list->RowIndex;

		// Init row class and style
		$reportfmea->resetAttributes();
		$reportfmea->CssClass = "";
		if ($reportfmea_list->isGridAdd()) {
		} else {
			$reportfmea_list->loadRowValues($reportfmea_list->Recordset); // Load row values
		}
		$reportfmea->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$reportfmea->RowAttrs->merge(["data-rowindex" => $reportfmea_list->RowCount, "id" => "r" . $reportfmea_list->RowCount . "_reportfmea", "data-rowtype" => $reportfmea->RowType]);

		// Render row
		$reportfmea_list->renderRow();

		// Render list options
		$reportfmea_list->renderListOptions();
?>
	<tr <?php echo $reportfmea->rowAttributes() ?>>
<?php

// Render list options (body, left)
$reportfmea_list->ListOptions->render("body", "left", $reportfmea_list->RowCount);
?>
	<?php if ($reportfmea_list->fmea->Visible) { // fmea ?>
		<td data-name="fmea" <?php echo $reportfmea_list->fmea->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_fmea">
<span<?php echo $reportfmea_list->fmea->viewAttributes() ?>><?php echo $reportfmea_list->fmea->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->idFactory->Visible) { // idFactory ?>
		<td data-name="idFactory" <?php echo $reportfmea_list->idFactory->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_idFactory">
<span<?php echo $reportfmea_list->idFactory->viewAttributes() ?>><?php echo $reportfmea_list->idFactory->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->dateFmea->Visible) { // dateFmea ?>
		<td data-name="dateFmea" <?php echo $reportfmea_list->dateFmea->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_dateFmea">
<span<?php echo $reportfmea_list->dateFmea->viewAttributes() ?>><?php echo $reportfmea_list->dateFmea->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->partnumbers->Visible) { // partnumbers ?>
		<td data-name="partnumbers" <?php echo $reportfmea_list->partnumbers->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_partnumbers">
<span<?php echo $reportfmea_list->partnumbers->viewAttributes() ?>><?php echo $reportfmea_list->partnumbers->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->description->Visible) { // description ?>
		<td data-name="description" <?php echo $reportfmea_list->description->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_description">
<span<?php echo $reportfmea_list->description->viewAttributes() ?>><?php echo $reportfmea_list->description->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->idEmployee->Visible) { // idEmployee ?>
		<td data-name="idEmployee" <?php echo $reportfmea_list->idEmployee->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_idEmployee">
<span<?php echo $reportfmea_list->idEmployee->viewAttributes() ?>><?php echo $reportfmea_list->idEmployee->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->idworkcenter->Visible) { // idworkcenter ?>
		<td data-name="idworkcenter" <?php echo $reportfmea_list->idworkcenter->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_idworkcenter">
<span<?php echo $reportfmea_list->idworkcenter->viewAttributes() ?>><?php echo $reportfmea_list->idworkcenter->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->idProcess->Visible) { // idProcess ?>
		<td data-name="idProcess" <?php echo $reportfmea_list->idProcess->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_idProcess">
<span<?php echo $reportfmea_list->idProcess->viewAttributes() ?>><?php echo $reportfmea_list->idProcess->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->step->Visible) { // step ?>
		<td data-name="step" <?php echo $reportfmea_list->step->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_step">
<span<?php echo $reportfmea_list->step->viewAttributes() ?>><?php echo $reportfmea_list->step->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->flowchartDesc->Visible) { // flowchartDesc ?>
		<td data-name="flowchartDesc" <?php echo $reportfmea_list->flowchartDesc->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_flowchartDesc">
<span<?php echo $reportfmea_list->flowchartDesc->viewAttributes() ?>><?php echo $reportfmea_list->flowchartDesc->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->partnumber->Visible) { // partnumber ?>
		<td data-name="partnumber" <?php echo $reportfmea_list->partnumber->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_partnumber">
<span<?php echo $reportfmea_list->partnumber->viewAttributes() ?>><?php echo $reportfmea_list->partnumber->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->operation->Visible) { // operation ?>
		<td data-name="operation" <?php echo $reportfmea_list->operation->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_operation">
<span<?php echo $reportfmea_list->operation->viewAttributes() ?>><?php echo $reportfmea_list->operation->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->derivedFromNC->Visible) { // derivedFromNC ?>
		<td data-name="derivedFromNC" <?php echo $reportfmea_list->derivedFromNC->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_derivedFromNC">
<span<?php echo $reportfmea_list->derivedFromNC->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_derivedFromNC" class="custom-control-input" value="<?php echo $reportfmea_list->derivedFromNC->getViewValue() ?>" disabled<?php if (ConvertToBool($reportfmea_list->derivedFromNC->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_derivedFromNC"></label></div></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->numberOfNC->Visible) { // numberOfNC ?>
		<td data-name="numberOfNC" <?php echo $reportfmea_list->numberOfNC->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_numberOfNC">
<span<?php echo $reportfmea_list->numberOfNC->viewAttributes() ?>><?php echo $reportfmea_list->numberOfNC->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->flowchart->Visible) { // flowchart ?>
		<td data-name="flowchart" <?php echo $reportfmea_list->flowchart->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_flowchart">
<span<?php echo $reportfmea_list->flowchart->viewAttributes() ?>><?php echo $reportfmea_list->flowchart->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->subprocess->Visible) { // subprocess ?>
		<td data-name="subprocess" <?php echo $reportfmea_list->subprocess->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_subprocess">
<span<?php echo $reportfmea_list->subprocess->viewAttributes() ?>><?php echo $reportfmea_list->subprocess->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->requirement->Visible) { // requirement ?>
		<td data-name="requirement" <?php echo $reportfmea_list->requirement->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_requirement">
<span<?php echo $reportfmea_list->requirement->viewAttributes() ?>><?php echo $reportfmea_list->requirement->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->potencialFailureMode->Visible) { // potencialFailureMode ?>
		<td data-name="potencialFailureMode" <?php echo $reportfmea_list->potencialFailureMode->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_potencialFailureMode">
<span<?php echo $reportfmea_list->potencialFailureMode->viewAttributes() ?>><?php echo $reportfmea_list->potencialFailureMode->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->potencialFailurEffect->Visible) { // potencialFailurEffect ?>
		<td data-name="potencialFailurEffect" <?php echo $reportfmea_list->potencialFailurEffect->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_potencialFailurEffect">
<span<?php echo $reportfmea_list->potencialFailurEffect->viewAttributes() ?>><?php echo $reportfmea_list->potencialFailurEffect->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->kc->Visible) { // kc ?>
		<td data-name="kc" <?php echo $reportfmea_list->kc->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_kc">
<span<?php echo $reportfmea_list->kc->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_kc" class="custom-control-input" value="<?php echo $reportfmea_list->kc->getViewValue() ?>" disabled<?php if (ConvertToBool($reportfmea_list->kc->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_kc"></label></div></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->severity->Visible) { // severity ?>
		<td data-name="severity" <?php echo $reportfmea_list->severity->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_severity">
<span<?php echo $reportfmea_list->severity->viewAttributes() ?>><?php echo $reportfmea_list->severity->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->idCause->Visible) { // idCause ?>
		<td data-name="idCause" <?php echo $reportfmea_list->idCause->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_idCause">
<span<?php echo $reportfmea_list->idCause->viewAttributes() ?>><?php echo $reportfmea_list->idCause->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->potentialCauses->Visible) { // potentialCauses ?>
		<td data-name="potentialCauses" <?php echo $reportfmea_list->potentialCauses->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_potentialCauses">
<span<?php echo $reportfmea_list->potentialCauses->viewAttributes() ?>><?php echo $reportfmea_list->potentialCauses->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->currentPreventiveControlMethod->Visible) { // currentPreventiveControlMethod ?>
		<td data-name="currentPreventiveControlMethod" <?php echo $reportfmea_list->currentPreventiveControlMethod->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_currentPreventiveControlMethod">
<span<?php echo $reportfmea_list->currentPreventiveControlMethod->viewAttributes() ?>><?php echo $reportfmea_list->currentPreventiveControlMethod->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->occurrence->Visible) { // occurrence ?>
		<td data-name="occurrence" <?php echo $reportfmea_list->occurrence->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_occurrence">
<span<?php echo $reportfmea_list->occurrence->viewAttributes() ?>><?php echo $reportfmea_list->occurrence->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->currentControlMethod->Visible) { // currentControlMethod ?>
		<td data-name="currentControlMethod" <?php echo $reportfmea_list->currentControlMethod->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_currentControlMethod">
<span<?php echo $reportfmea_list->currentControlMethod->viewAttributes() ?>><?php echo $reportfmea_list->currentControlMethod->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->detection->Visible) { // detection ?>
		<td data-name="detection" <?php echo $reportfmea_list->detection->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_detection">
<span<?php echo $reportfmea_list->detection->viewAttributes() ?>><?php echo $reportfmea_list->detection->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->rpn->Visible) { // rpn ?>
		<td data-name="rpn" <?php echo $reportfmea_list->rpn->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_rpn">
<span<?php echo $reportfmea_list->rpn->viewAttributes() ?>><?php echo $reportfmea_list->rpn->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->recomendedAction->Visible) { // recomendedAction ?>
		<td data-name="recomendedAction" <?php echo $reportfmea_list->recomendedAction->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_recomendedAction">
<span<?php echo $reportfmea_list->recomendedAction->viewAttributes() ?>><?php echo $reportfmea_list->recomendedAction->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->idResponsible->Visible) { // idResponsible ?>
		<td data-name="idResponsible" <?php echo $reportfmea_list->idResponsible->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_idResponsible">
<span<?php echo $reportfmea_list->idResponsible->viewAttributes() ?>><?php echo $reportfmea_list->idResponsible->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->targetDate->Visible) { // targetDate ?>
		<td data-name="targetDate" <?php echo $reportfmea_list->targetDate->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_targetDate">
<span<?php echo $reportfmea_list->targetDate->viewAttributes() ?>><?php echo $reportfmea_list->targetDate->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->revisedKc->Visible) { // revisedKc ?>
		<td data-name="revisedKc" <?php echo $reportfmea_list->revisedKc->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_revisedKc">
<span<?php echo $reportfmea_list->revisedKc->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_revisedKc" class="custom-control-input" value="<?php echo $reportfmea_list->revisedKc->getViewValue() ?>" disabled<?php if (ConvertToBool($reportfmea_list->revisedKc->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_revisedKc"></label></div></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->expectedSeverity->Visible) { // expectedSeverity ?>
		<td data-name="expectedSeverity" <?php echo $reportfmea_list->expectedSeverity->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_expectedSeverity">
<span<?php echo $reportfmea_list->expectedSeverity->viewAttributes() ?>><?php echo $reportfmea_list->expectedSeverity->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->expectedOccurrence->Visible) { // expectedOccurrence ?>
		<td data-name="expectedOccurrence" <?php echo $reportfmea_list->expectedOccurrence->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_expectedOccurrence">
<span<?php echo $reportfmea_list->expectedOccurrence->viewAttributes() ?>><?php echo $reportfmea_list->expectedOccurrence->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->expectedDetection->Visible) { // expectedDetection ?>
		<td data-name="expectedDetection" <?php echo $reportfmea_list->expectedDetection->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_expectedDetection">
<span<?php echo $reportfmea_list->expectedDetection->viewAttributes() ?>><?php echo $reportfmea_list->expectedDetection->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->expectedRpn->Visible) { // expectedRpn ?>
		<td data-name="expectedRpn" <?php echo $reportfmea_list->expectedRpn->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_expectedRpn">
<span<?php echo $reportfmea_list->expectedRpn->viewAttributes() ?>><?php echo $reportfmea_list->expectedRpn->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->expectedClosureDate->Visible) { // expectedClosureDate ?>
		<td data-name="expectedClosureDate" <?php echo $reportfmea_list->expectedClosureDate->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_expectedClosureDate">
<span<?php echo $reportfmea_list->expectedClosureDate->viewAttributes() ?>><?php echo $reportfmea_list->expectedClosureDate->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->recomendedActiondet->Visible) { // recomendedActiondet ?>
		<td data-name="recomendedActiondet" <?php echo $reportfmea_list->recomendedActiondet->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_recomendedActiondet">
<span<?php echo $reportfmea_list->recomendedActiondet->viewAttributes() ?>><?php echo $reportfmea_list->recomendedActiondet->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->idResponsibleDet->Visible) { // idResponsibleDet ?>
		<td data-name="idResponsibleDet" <?php echo $reportfmea_list->idResponsibleDet->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_idResponsibleDet">
<span<?php echo $reportfmea_list->idResponsibleDet->viewAttributes() ?>><?php echo $reportfmea_list->idResponsibleDet->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->targetDatedet->Visible) { // targetDatedet ?>
		<td data-name="targetDatedet" <?php echo $reportfmea_list->targetDatedet->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_targetDatedet">
<span<?php echo $reportfmea_list->targetDatedet->viewAttributes() ?>><?php echo $reportfmea_list->targetDatedet->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->kcdet->Visible) { // kcdet ?>
		<td data-name="kcdet" <?php echo $reportfmea_list->kcdet->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_kcdet">
<span<?php echo $reportfmea_list->kcdet->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_kcdet" class="custom-control-input" value="<?php echo $reportfmea_list->kcdet->getViewValue() ?>" disabled<?php if (ConvertToBool($reportfmea_list->kcdet->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_kcdet"></label></div></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->expectedSeveritydet->Visible) { // expectedSeveritydet ?>
		<td data-name="expectedSeveritydet" <?php echo $reportfmea_list->expectedSeveritydet->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_expectedSeveritydet">
<span<?php echo $reportfmea_list->expectedSeveritydet->viewAttributes() ?>><?php echo $reportfmea_list->expectedSeveritydet->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->expectedOccurrencedet->Visible) { // expectedOccurrencedet ?>
		<td data-name="expectedOccurrencedet" <?php echo $reportfmea_list->expectedOccurrencedet->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_expectedOccurrencedet">
<span<?php echo $reportfmea_list->expectedOccurrencedet->viewAttributes() ?>><?php echo $reportfmea_list->expectedOccurrencedet->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->expectedDetectiondet->Visible) { // expectedDetectiondet ?>
		<td data-name="expectedDetectiondet" <?php echo $reportfmea_list->expectedDetectiondet->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_expectedDetectiondet">
<span<?php echo $reportfmea_list->expectedDetectiondet->viewAttributes() ?>><?php echo $reportfmea_list->expectedDetectiondet->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->expectedRpndet->Visible) { // expectedRpndet ?>
		<td data-name="expectedRpndet" <?php echo $reportfmea_list->expectedRpndet->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_expectedRpndet">
<span<?php echo $reportfmea_list->expectedRpndet->viewAttributes() ?>><?php echo $reportfmea_list->expectedRpndet->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->revisedClosureDatedet->Visible) { // revisedClosureDatedet ?>
		<td data-name="revisedClosureDatedet" <?php echo $reportfmea_list->revisedClosureDatedet->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_revisedClosureDatedet">
<span<?php echo $reportfmea_list->revisedClosureDatedet->viewAttributes() ?>><?php echo $reportfmea_list->revisedClosureDatedet->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->revisedClosureDate->Visible) { // revisedClosureDate ?>
		<td data-name="revisedClosureDate" <?php echo $reportfmea_list->revisedClosureDate->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_revisedClosureDate">
<span<?php echo $reportfmea_list->revisedClosureDate->viewAttributes() ?>><?php echo $reportfmea_list->revisedClosureDate->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->perfomedAction->Visible) { // perfomedAction ?>
		<td data-name="perfomedAction" <?php echo $reportfmea_list->perfomedAction->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_perfomedAction">
<span<?php echo $reportfmea_list->perfomedAction->viewAttributes() ?>><?php echo $reportfmea_list->perfomedAction->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->revisedSeverity->Visible) { // revisedSeverity ?>
		<td data-name="revisedSeverity" <?php echo $reportfmea_list->revisedSeverity->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_revisedSeverity">
<span<?php echo $reportfmea_list->revisedSeverity->viewAttributes() ?>><?php echo $reportfmea_list->revisedSeverity->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->revisedOccurrence->Visible) { // revisedOccurrence ?>
		<td data-name="revisedOccurrence" <?php echo $reportfmea_list->revisedOccurrence->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_revisedOccurrence">
<span<?php echo $reportfmea_list->revisedOccurrence->viewAttributes() ?>><?php echo $reportfmea_list->revisedOccurrence->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->revisedDetection->Visible) { // revisedDetection ?>
		<td data-name="revisedDetection" <?php echo $reportfmea_list->revisedDetection->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_revisedDetection">
<span<?php echo $reportfmea_list->revisedDetection->viewAttributes() ?>><?php echo $reportfmea_list->revisedDetection->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($reportfmea_list->revisedRpn->Visible) { // revisedRpn ?>
		<td data-name="revisedRpn" <?php echo $reportfmea_list->revisedRpn->cellAttributes() ?>>
<span id="el<?php echo $reportfmea_list->RowCount ?>_reportfmea_revisedRpn">
<span<?php echo $reportfmea_list->revisedRpn->viewAttributes() ?>><?php echo $reportfmea_list->revisedRpn->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$reportfmea_list->ListOptions->render("body", "right", $reportfmea_list->RowCount);
?>
	</tr>
<?php
	}
	if (!$reportfmea_list->isGridAdd())
		$reportfmea_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$reportfmea->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($reportfmea_list->Recordset)
	$reportfmea_list->Recordset->Close();
?>
<?php if (!$reportfmea_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$reportfmea_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $reportfmea_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $reportfmea_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($reportfmea_list->TotalRecords == 0 && !$reportfmea->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $reportfmea_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$reportfmea_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$reportfmea_list->isExport()) { ?>
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
$reportfmea_list->terminate();
?>