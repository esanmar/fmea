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
$fmea_list = new fmea_list();

// Run the page
$fmea_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$fmea_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$fmea_list->isExport()) { ?>
<script>
var ffmealist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	ffmealist = currentForm = new ew.Form("ffmealist", "list");
	ffmealist.formKeyCountName = '<?php echo $fmea_list->FormKeyCountName ?>';

	// Validate form
	ffmealist.validate = function() {
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
			<?php if ($fmea_list->fmea->Required) { ?>
				elm = this.getElements("x" + infix + "_fmea");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $fmea_list->fmea->caption(), $fmea_list->fmea->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($fmea_list->idFactory->Required) { ?>
				elm = this.getElements("x" + infix + "_idFactory");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $fmea_list->idFactory->caption(), $fmea_list->idFactory->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($fmea_list->dateFmea->Required) { ?>
				elm = this.getElements("x" + infix + "_dateFmea");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $fmea_list->dateFmea->caption(), $fmea_list->dateFmea->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_dateFmea");
				if (elm && !ew.checkDateDef(elm.value))
					return this.onError(elm, "<?php echo JsEncode($fmea_list->dateFmea->errorMessage()) ?>");
			<?php if ($fmea_list->partnumbers->Required) { ?>
				elm = this.getElements("x" + infix + "_partnumbers");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $fmea_list->partnumbers->caption(), $fmea_list->partnumbers->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($fmea_list->description->Required) { ?>
				elm = this.getElements("x" + infix + "_description");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $fmea_list->description->caption(), $fmea_list->description->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($fmea_list->idEmployee->Required) { ?>
				elm = this.getElements("x" + infix + "_idEmployee[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $fmea_list->idEmployee->caption(), $fmea_list->idEmployee->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($fmea_list->idworkcenter->Required) { ?>
				elm = this.getElements("x" + infix + "_idworkcenter");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $fmea_list->idworkcenter->caption(), $fmea_list->idworkcenter->RequiredErrorMessage)) ?>");
			<?php } ?>

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
		}
		return true;
	}

	// Form_CustomValidate
	ffmealist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	ffmealist.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	ffmealist.lists["x_idFactory"] = <?php echo $fmea_list->idFactory->Lookup->toClientList($fmea_list) ?>;
	ffmealist.lists["x_idFactory"].options = <?php echo JsonEncode($fmea_list->idFactory->lookupOptions()) ?>;
	ffmealist.lists["x_idEmployee[]"] = <?php echo $fmea_list->idEmployee->Lookup->toClientList($fmea_list) ?>;
	ffmealist.lists["x_idEmployee[]"].options = <?php echo JsonEncode($fmea_list->idEmployee->lookupOptions()) ?>;
	ffmealist.lists["x_idworkcenter"] = <?php echo $fmea_list->idworkcenter->Lookup->toClientList($fmea_list) ?>;
	ffmealist.lists["x_idworkcenter"].options = <?php echo JsonEncode($fmea_list->idworkcenter->lookupOptions()) ?>;
	loadjs.done("ffmealist");
});
var ffmealistsrch;
loadjs.ready("head", function() {

	// Form object for search
	ffmealistsrch = currentSearchForm = new ew.Form("ffmealistsrch");

	// Dynamic selection lists
	// Filters

	ffmealistsrch.filterList = <?php echo $fmea_list->getFilterList() ?>;
	loadjs.done("ffmealistsrch");
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
<?php if (!$fmea_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($fmea_list->TotalRecords > 0 && $fmea_list->ExportOptions->visible()) { ?>
<?php $fmea_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($fmea_list->ImportOptions->visible()) { ?>
<?php $fmea_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($fmea_list->SearchOptions->visible()) { ?>
<?php $fmea_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($fmea_list->FilterOptions->visible()) { ?>
<?php $fmea_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$fmea_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$fmea_list->isExport() && !$fmea->CurrentAction) { ?>
<form name="ffmealistsrch" id="ffmealistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="ffmealistsrch-search-panel" class="<?php echo $fmea_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="fmea">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $fmea_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($fmea_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($fmea_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $fmea_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($fmea_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($fmea_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($fmea_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($fmea_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $fmea_list->showPageHeader(); ?>
<?php
$fmea_list->showMessage();
?>
<?php if ($fmea_list->TotalRecords > 0 || $fmea->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($fmea_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> fmea">
<?php if (!$fmea_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$fmea_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $fmea_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $fmea_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="ffmealist" id="ffmealist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="fmea">
<div id="gmp_fmea" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($fmea_list->TotalRecords > 0 || $fmea_list->isGridEdit()) { ?>
<table id="tbl_fmealist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$fmea->RowType = ROWTYPE_HEADER;

// Render list options
$fmea_list->renderListOptions();

// Render list options (header, left)
$fmea_list->ListOptions->render("header", "left");
?>
<?php if ($fmea_list->fmea->Visible) { // fmea ?>
	<?php if ($fmea_list->SortUrl($fmea_list->fmea) == "") { ?>
		<th data-name="fmea" class="<?php echo $fmea_list->fmea->headerCellClass() ?>"><div id="elh_fmea_fmea" class="fmea_fmea"><div class="ew-table-header-caption"><?php echo $fmea_list->fmea->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fmea" class="<?php echo $fmea_list->fmea->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $fmea_list->SortUrl($fmea_list->fmea) ?>', 2);"><div id="elh_fmea_fmea" class="fmea_fmea">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $fmea_list->fmea->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($fmea_list->fmea->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($fmea_list->fmea->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($fmea_list->idFactory->Visible) { // idFactory ?>
	<?php if ($fmea_list->SortUrl($fmea_list->idFactory) == "") { ?>
		<th data-name="idFactory" class="<?php echo $fmea_list->idFactory->headerCellClass() ?>"><div id="elh_fmea_idFactory" class="fmea_idFactory"><div class="ew-table-header-caption"><?php echo $fmea_list->idFactory->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idFactory" class="<?php echo $fmea_list->idFactory->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $fmea_list->SortUrl($fmea_list->idFactory) ?>', 2);"><div id="elh_fmea_idFactory" class="fmea_idFactory">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $fmea_list->idFactory->caption() ?></span><span class="ew-table-header-sort"><?php if ($fmea_list->idFactory->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($fmea_list->idFactory->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($fmea_list->dateFmea->Visible) { // dateFmea ?>
	<?php if ($fmea_list->SortUrl($fmea_list->dateFmea) == "") { ?>
		<th data-name="dateFmea" class="<?php echo $fmea_list->dateFmea->headerCellClass() ?>"><div id="elh_fmea_dateFmea" class="fmea_dateFmea"><div class="ew-table-header-caption"><?php echo $fmea_list->dateFmea->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="dateFmea" class="<?php echo $fmea_list->dateFmea->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $fmea_list->SortUrl($fmea_list->dateFmea) ?>', 2);"><div id="elh_fmea_dateFmea" class="fmea_dateFmea">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $fmea_list->dateFmea->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($fmea_list->dateFmea->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($fmea_list->dateFmea->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($fmea_list->partnumbers->Visible) { // partnumbers ?>
	<?php if ($fmea_list->SortUrl($fmea_list->partnumbers) == "") { ?>
		<th data-name="partnumbers" class="<?php echo $fmea_list->partnumbers->headerCellClass() ?>"><div id="elh_fmea_partnumbers" class="fmea_partnumbers"><div class="ew-table-header-caption"><?php echo $fmea_list->partnumbers->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="partnumbers" class="<?php echo $fmea_list->partnumbers->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $fmea_list->SortUrl($fmea_list->partnumbers) ?>', 2);"><div id="elh_fmea_partnumbers" class="fmea_partnumbers">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $fmea_list->partnumbers->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($fmea_list->partnumbers->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($fmea_list->partnumbers->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($fmea_list->description->Visible) { // description ?>
	<?php if ($fmea_list->SortUrl($fmea_list->description) == "") { ?>
		<th data-name="description" class="<?php echo $fmea_list->description->headerCellClass() ?>"><div id="elh_fmea_description" class="fmea_description"><div class="ew-table-header-caption"><?php echo $fmea_list->description->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="description" class="<?php echo $fmea_list->description->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $fmea_list->SortUrl($fmea_list->description) ?>', 2);"><div id="elh_fmea_description" class="fmea_description">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $fmea_list->description->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($fmea_list->description->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($fmea_list->description->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($fmea_list->idEmployee->Visible) { // idEmployee ?>
	<?php if ($fmea_list->SortUrl($fmea_list->idEmployee) == "") { ?>
		<th data-name="idEmployee" class="<?php echo $fmea_list->idEmployee->headerCellClass() ?>"><div id="elh_fmea_idEmployee" class="fmea_idEmployee"><div class="ew-table-header-caption"><?php echo $fmea_list->idEmployee->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idEmployee" class="<?php echo $fmea_list->idEmployee->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $fmea_list->SortUrl($fmea_list->idEmployee) ?>', 2);"><div id="elh_fmea_idEmployee" class="fmea_idEmployee">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $fmea_list->idEmployee->caption() ?></span><span class="ew-table-header-sort"><?php if ($fmea_list->idEmployee->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($fmea_list->idEmployee->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($fmea_list->idworkcenter->Visible) { // idworkcenter ?>
	<?php if ($fmea_list->SortUrl($fmea_list->idworkcenter) == "") { ?>
		<th data-name="idworkcenter" class="<?php echo $fmea_list->idworkcenter->headerCellClass() ?>"><div id="elh_fmea_idworkcenter" class="fmea_idworkcenter"><div class="ew-table-header-caption"><?php echo $fmea_list->idworkcenter->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idworkcenter" class="<?php echo $fmea_list->idworkcenter->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $fmea_list->SortUrl($fmea_list->idworkcenter) ?>', 2);"><div id="elh_fmea_idworkcenter" class="fmea_idworkcenter">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $fmea_list->idworkcenter->caption() ?></span><span class="ew-table-header-sort"><?php if ($fmea_list->idworkcenter->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($fmea_list->idworkcenter->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$fmea_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($fmea_list->ExportAll && $fmea_list->isExport()) {
	$fmea_list->StopRecord = $fmea_list->TotalRecords;
} else {

	// Set the last record to display
	if ($fmea_list->TotalRecords > $fmea_list->StartRecord + $fmea_list->DisplayRecords - 1)
		$fmea_list->StopRecord = $fmea_list->StartRecord + $fmea_list->DisplayRecords - 1;
	else
		$fmea_list->StopRecord = $fmea_list->TotalRecords;
}

// Restore number of post back records
if ($CurrentForm && ($fmea->isConfirm() || $fmea_list->EventCancelled)) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($fmea_list->FormKeyCountName) && ($fmea_list->isGridAdd() || $fmea_list->isGridEdit() || $fmea->isConfirm())) {
		$fmea_list->KeyCount = $CurrentForm->getValue($fmea_list->FormKeyCountName);
		$fmea_list->StopRecord = $fmea_list->StartRecord + $fmea_list->KeyCount - 1;
	}
}
$fmea_list->RecordCount = $fmea_list->StartRecord - 1;
if ($fmea_list->Recordset && !$fmea_list->Recordset->EOF) {
	$fmea_list->Recordset->moveFirst();
	$selectLimit = $fmea_list->UseSelectLimit;
	if (!$selectLimit && $fmea_list->StartRecord > 1)
		$fmea_list->Recordset->move($fmea_list->StartRecord - 1);
} elseif (!$fmea->AllowAddDeleteRow && $fmea_list->StopRecord == 0) {
	$fmea_list->StopRecord = $fmea->GridAddRowCount;
}

// Initialize aggregate
$fmea->RowType = ROWTYPE_AGGREGATEINIT;
$fmea->resetAttributes();
$fmea_list->renderRow();
if ($fmea_list->isGridEdit())
	$fmea_list->RowIndex = 0;
while ($fmea_list->RecordCount < $fmea_list->StopRecord) {
	$fmea_list->RecordCount++;
	if ($fmea_list->RecordCount >= $fmea_list->StartRecord) {
		$fmea_list->RowCount++;
		if ($fmea_list->isGridAdd() || $fmea_list->isGridEdit() || $fmea->isConfirm()) {
			$fmea_list->RowIndex++;
			$CurrentForm->Index = $fmea_list->RowIndex;
			if ($CurrentForm->hasValue($fmea_list->FormActionName) && ($fmea->isConfirm() || $fmea_list->EventCancelled))
				$fmea_list->RowAction = strval($CurrentForm->getValue($fmea_list->FormActionName));
			elseif ($fmea_list->isGridAdd())
				$fmea_list->RowAction = "insert";
			else
				$fmea_list->RowAction = "";
		}

		// Set up key count
		$fmea_list->KeyCount = $fmea_list->RowIndex;

		// Init row class and style
		$fmea->resetAttributes();
		$fmea->CssClass = "";
		if ($fmea_list->isGridAdd()) {
			$fmea_list->loadRowValues(); // Load default values
		} else {
			$fmea_list->loadRowValues($fmea_list->Recordset); // Load row values
		}
		$fmea->RowType = ROWTYPE_VIEW; // Render view
		if ($fmea_list->isGridEdit()) { // Grid edit
			if ($fmea->EventCancelled)
				$fmea_list->restoreCurrentRowFormValues($fmea_list->RowIndex); // Restore form values
			if ($fmea_list->RowAction == "insert")
				$fmea->RowType = ROWTYPE_ADD; // Render add
			else
				$fmea->RowType = ROWTYPE_EDIT; // Render edit
			if (!$fmea->EventCancelled)
				$fmea_list->HashValue = $fmea_list->getRowHash($fmea_list->Recordset); // Get hash value for record
		}
		if ($fmea_list->isGridEdit() && ($fmea->RowType == ROWTYPE_EDIT || $fmea->RowType == ROWTYPE_ADD) && $fmea->EventCancelled) // Update failed
			$fmea_list->restoreCurrentRowFormValues($fmea_list->RowIndex); // Restore form values
		if ($fmea->RowType == ROWTYPE_EDIT) // Edit row
			$fmea_list->EditRowCount++;

		// Set up row id / data-rowindex
		$fmea->RowAttrs->merge(["data-rowindex" => $fmea_list->RowCount, "id" => "r" . $fmea_list->RowCount . "_fmea", "data-rowtype" => $fmea->RowType]);

		// Render row
		$fmea_list->renderRow();

		// Render list options
		$fmea_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($fmea_list->RowAction != "delete" && $fmea_list->RowAction != "insertdelete" && !($fmea_list->RowAction == "insert" && $fmea->isConfirm() && $fmea_list->emptyRow())) {
?>
	<tr <?php echo $fmea->rowAttributes() ?>>
<?php

// Render list options (body, left)
$fmea_list->ListOptions->render("body", "left", $fmea_list->RowCount);
?>
	<?php if ($fmea_list->fmea->Visible) { // fmea ?>
		<td data-name="fmea" <?php echo $fmea_list->fmea->cellAttributes() ?>>
<?php if ($fmea->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $fmea_list->RowCount ?>_fmea_fmea" class="form-group">
<input type="text" data-table="fmea" data-field="x_fmea" name="x<?php echo $fmea_list->RowIndex ?>_fmea" id="x<?php echo $fmea_list->RowIndex ?>_fmea" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($fmea_list->fmea->getPlaceHolder()) ?>" value="<?php echo $fmea_list->fmea->EditValue ?>"<?php echo $fmea_list->fmea->editAttributes() ?>>
</span>
<input type="hidden" data-table="fmea" data-field="x_fmea" name="o<?php echo $fmea_list->RowIndex ?>_fmea" id="o<?php echo $fmea_list->RowIndex ?>_fmea" value="<?php echo HtmlEncode($fmea_list->fmea->OldValue) ?>">
<?php } ?>
<?php if ($fmea->RowType == ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-table="fmea" data-field="x_fmea" name="x<?php echo $fmea_list->RowIndex ?>_fmea" id="x<?php echo $fmea_list->RowIndex ?>_fmea" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($fmea_list->fmea->getPlaceHolder()) ?>" value="<?php echo $fmea_list->fmea->EditValue ?>"<?php echo $fmea_list->fmea->editAttributes() ?>>
<input type="hidden" data-table="fmea" data-field="x_fmea" name="o<?php echo $fmea_list->RowIndex ?>_fmea" id="o<?php echo $fmea_list->RowIndex ?>_fmea" value="<?php echo HtmlEncode($fmea_list->fmea->OldValue != null ? $fmea_list->fmea->OldValue : $fmea_list->fmea->CurrentValue) ?>">
<?php } ?>
<?php if ($fmea->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $fmea_list->RowCount ?>_fmea_fmea">
<span<?php echo $fmea_list->fmea->viewAttributes() ?>><?php echo $fmea_list->fmea->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($fmea_list->idFactory->Visible) { // idFactory ?>
		<td data-name="idFactory" <?php echo $fmea_list->idFactory->cellAttributes() ?>>
<?php if ($fmea->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $fmea_list->RowCount ?>_fmea_idFactory" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="fmea" data-field="x_idFactory" data-value-separator="<?php echo $fmea_list->idFactory->displayValueSeparatorAttribute() ?>" id="x<?php echo $fmea_list->RowIndex ?>_idFactory" name="x<?php echo $fmea_list->RowIndex ?>_idFactory"<?php echo $fmea_list->idFactory->editAttributes() ?>>
			<?php echo $fmea_list->idFactory->selectOptionListHtml("x{$fmea_list->RowIndex}_idFactory") ?>
		</select>
</div>
<?php echo $fmea_list->idFactory->Lookup->getParamTag($fmea_list, "p_x" . $fmea_list->RowIndex . "_idFactory") ?>
</span>
<input type="hidden" data-table="fmea" data-field="x_idFactory" name="o<?php echo $fmea_list->RowIndex ?>_idFactory" id="o<?php echo $fmea_list->RowIndex ?>_idFactory" value="<?php echo HtmlEncode($fmea_list->idFactory->OldValue) ?>">
<?php } ?>
<?php if ($fmea->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $fmea_list->RowCount ?>_fmea_idFactory" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="fmea" data-field="x_idFactory" data-value-separator="<?php echo $fmea_list->idFactory->displayValueSeparatorAttribute() ?>" id="x<?php echo $fmea_list->RowIndex ?>_idFactory" name="x<?php echo $fmea_list->RowIndex ?>_idFactory"<?php echo $fmea_list->idFactory->editAttributes() ?>>
			<?php echo $fmea_list->idFactory->selectOptionListHtml("x{$fmea_list->RowIndex}_idFactory") ?>
		</select>
</div>
<?php echo $fmea_list->idFactory->Lookup->getParamTag($fmea_list, "p_x" . $fmea_list->RowIndex . "_idFactory") ?>
</span>
<?php } ?>
<?php if ($fmea->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $fmea_list->RowCount ?>_fmea_idFactory">
<span<?php echo $fmea_list->idFactory->viewAttributes() ?>><?php echo $fmea_list->idFactory->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($fmea_list->dateFmea->Visible) { // dateFmea ?>
		<td data-name="dateFmea" <?php echo $fmea_list->dateFmea->cellAttributes() ?>>
<?php if ($fmea->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $fmea_list->RowCount ?>_fmea_dateFmea" class="form-group">
<input type="text" data-table="fmea" data-field="x_dateFmea" name="x<?php echo $fmea_list->RowIndex ?>_dateFmea" id="x<?php echo $fmea_list->RowIndex ?>_dateFmea" placeholder="<?php echo HtmlEncode($fmea_list->dateFmea->getPlaceHolder()) ?>" value="<?php echo $fmea_list->dateFmea->EditValue ?>"<?php echo $fmea_list->dateFmea->editAttributes() ?>>
<?php if (!$fmea_list->dateFmea->ReadOnly && !$fmea_list->dateFmea->Disabled && !isset($fmea_list->dateFmea->EditAttrs["readonly"]) && !isset($fmea_list->dateFmea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffmealist", "datetimepicker"], function() {
	ew.createDateTimePicker("ffmealist", "x<?php echo $fmea_list->RowIndex ?>_dateFmea", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="fmea" data-field="x_dateFmea" name="o<?php echo $fmea_list->RowIndex ?>_dateFmea" id="o<?php echo $fmea_list->RowIndex ?>_dateFmea" value="<?php echo HtmlEncode($fmea_list->dateFmea->OldValue) ?>">
<?php } ?>
<?php if ($fmea->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $fmea_list->RowCount ?>_fmea_dateFmea" class="form-group">
<input type="text" data-table="fmea" data-field="x_dateFmea" name="x<?php echo $fmea_list->RowIndex ?>_dateFmea" id="x<?php echo $fmea_list->RowIndex ?>_dateFmea" placeholder="<?php echo HtmlEncode($fmea_list->dateFmea->getPlaceHolder()) ?>" value="<?php echo $fmea_list->dateFmea->EditValue ?>"<?php echo $fmea_list->dateFmea->editAttributes() ?>>
<?php if (!$fmea_list->dateFmea->ReadOnly && !$fmea_list->dateFmea->Disabled && !isset($fmea_list->dateFmea->EditAttrs["readonly"]) && !isset($fmea_list->dateFmea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffmealist", "datetimepicker"], function() {
	ew.createDateTimePicker("ffmealist", "x<?php echo $fmea_list->RowIndex ?>_dateFmea", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($fmea->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $fmea_list->RowCount ?>_fmea_dateFmea">
<span<?php echo $fmea_list->dateFmea->viewAttributes() ?>><?php echo $fmea_list->dateFmea->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($fmea_list->partnumbers->Visible) { // partnumbers ?>
		<td data-name="partnumbers" <?php echo $fmea_list->partnumbers->cellAttributes() ?>>
<?php if ($fmea->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $fmea_list->RowCount ?>_fmea_partnumbers" class="form-group">
<textarea data-table="fmea" data-field="x_partnumbers" name="x<?php echo $fmea_list->RowIndex ?>_partnumbers" id="x<?php echo $fmea_list->RowIndex ?>_partnumbers" cols="35" rows="4" placeholder="<?php echo HtmlEncode($fmea_list->partnumbers->getPlaceHolder()) ?>"<?php echo $fmea_list->partnumbers->editAttributes() ?>><?php echo $fmea_list->partnumbers->EditValue ?></textarea>
</span>
<input type="hidden" data-table="fmea" data-field="x_partnumbers" name="o<?php echo $fmea_list->RowIndex ?>_partnumbers" id="o<?php echo $fmea_list->RowIndex ?>_partnumbers" value="<?php echo HtmlEncode($fmea_list->partnumbers->OldValue) ?>">
<?php } ?>
<?php if ($fmea->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $fmea_list->RowCount ?>_fmea_partnumbers" class="form-group">
<textarea data-table="fmea" data-field="x_partnumbers" name="x<?php echo $fmea_list->RowIndex ?>_partnumbers" id="x<?php echo $fmea_list->RowIndex ?>_partnumbers" cols="35" rows="4" placeholder="<?php echo HtmlEncode($fmea_list->partnumbers->getPlaceHolder()) ?>"<?php echo $fmea_list->partnumbers->editAttributes() ?>><?php echo $fmea_list->partnumbers->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($fmea->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $fmea_list->RowCount ?>_fmea_partnumbers">
<span<?php echo $fmea_list->partnumbers->viewAttributes() ?>><?php echo $fmea_list->partnumbers->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($fmea_list->description->Visible) { // description ?>
		<td data-name="description" <?php echo $fmea_list->description->cellAttributes() ?>>
<?php if ($fmea->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $fmea_list->RowCount ?>_fmea_description" class="form-group">
<textarea data-table="fmea" data-field="x_description" name="x<?php echo $fmea_list->RowIndex ?>_description" id="x<?php echo $fmea_list->RowIndex ?>_description" cols="35" rows="4" placeholder="<?php echo HtmlEncode($fmea_list->description->getPlaceHolder()) ?>"<?php echo $fmea_list->description->editAttributes() ?>><?php echo $fmea_list->description->EditValue ?></textarea>
</span>
<input type="hidden" data-table="fmea" data-field="x_description" name="o<?php echo $fmea_list->RowIndex ?>_description" id="o<?php echo $fmea_list->RowIndex ?>_description" value="<?php echo HtmlEncode($fmea_list->description->OldValue) ?>">
<?php } ?>
<?php if ($fmea->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $fmea_list->RowCount ?>_fmea_description" class="form-group">
<textarea data-table="fmea" data-field="x_description" name="x<?php echo $fmea_list->RowIndex ?>_description" id="x<?php echo $fmea_list->RowIndex ?>_description" cols="35" rows="4" placeholder="<?php echo HtmlEncode($fmea_list->description->getPlaceHolder()) ?>"<?php echo $fmea_list->description->editAttributes() ?>><?php echo $fmea_list->description->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($fmea->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $fmea_list->RowCount ?>_fmea_description">
<span<?php echo $fmea_list->description->viewAttributes() ?>><?php echo $fmea_list->description->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($fmea_list->idEmployee->Visible) { // idEmployee ?>
		<td data-name="idEmployee" <?php echo $fmea_list->idEmployee->cellAttributes() ?>>
<?php if ($fmea->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $fmea_list->RowCount ?>_fmea_idEmployee" class="form-group">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $fmea_list->RowIndex ?>_idEmployee"><?php echo EmptyValue(strval($fmea_list->idEmployee->ViewValue)) ? $Language->phrase("PleaseSelect") : $fmea_list->idEmployee->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($fmea_list->idEmployee->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($fmea_list->idEmployee->ReadOnly || $fmea_list->idEmployee->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $fmea_list->RowIndex ?>_idEmployee[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $fmea_list->idEmployee->Lookup->getParamTag($fmea_list, "p_x" . $fmea_list->RowIndex . "_idEmployee") ?>
<input type="hidden" data-table="fmea" data-field="x_idEmployee" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $fmea_list->idEmployee->displayValueSeparatorAttribute() ?>" name="x<?php echo $fmea_list->RowIndex ?>_idEmployee[]" id="x<?php echo $fmea_list->RowIndex ?>_idEmployee[]" value="<?php echo $fmea_list->idEmployee->CurrentValue ?>"<?php echo $fmea_list->idEmployee->editAttributes() ?>>
</span>
<input type="hidden" data-table="fmea" data-field="x_idEmployee" name="o<?php echo $fmea_list->RowIndex ?>_idEmployee[]" id="o<?php echo $fmea_list->RowIndex ?>_idEmployee[]" value="<?php echo HtmlEncode($fmea_list->idEmployee->OldValue) ?>">
<?php } ?>
<?php if ($fmea->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $fmea_list->RowCount ?>_fmea_idEmployee" class="form-group">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $fmea_list->RowIndex ?>_idEmployee"><?php echo EmptyValue(strval($fmea_list->idEmployee->ViewValue)) ? $Language->phrase("PleaseSelect") : $fmea_list->idEmployee->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($fmea_list->idEmployee->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($fmea_list->idEmployee->ReadOnly || $fmea_list->idEmployee->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $fmea_list->RowIndex ?>_idEmployee[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $fmea_list->idEmployee->Lookup->getParamTag($fmea_list, "p_x" . $fmea_list->RowIndex . "_idEmployee") ?>
<input type="hidden" data-table="fmea" data-field="x_idEmployee" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $fmea_list->idEmployee->displayValueSeparatorAttribute() ?>" name="x<?php echo $fmea_list->RowIndex ?>_idEmployee[]" id="x<?php echo $fmea_list->RowIndex ?>_idEmployee[]" value="<?php echo $fmea_list->idEmployee->CurrentValue ?>"<?php echo $fmea_list->idEmployee->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($fmea->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $fmea_list->RowCount ?>_fmea_idEmployee">
<span<?php echo $fmea_list->idEmployee->viewAttributes() ?>><?php echo $fmea_list->idEmployee->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($fmea_list->idworkcenter->Visible) { // idworkcenter ?>
		<td data-name="idworkcenter" <?php echo $fmea_list->idworkcenter->cellAttributes() ?>>
<?php if ($fmea->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $fmea_list->RowCount ?>_fmea_idworkcenter" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="fmea" data-field="x_idworkcenter" data-value-separator="<?php echo $fmea_list->idworkcenter->displayValueSeparatorAttribute() ?>" id="x<?php echo $fmea_list->RowIndex ?>_idworkcenter" name="x<?php echo $fmea_list->RowIndex ?>_idworkcenter"<?php echo $fmea_list->idworkcenter->editAttributes() ?>>
			<?php echo $fmea_list->idworkcenter->selectOptionListHtml("x{$fmea_list->RowIndex}_idworkcenter") ?>
		</select>
</div>
<?php echo $fmea_list->idworkcenter->Lookup->getParamTag($fmea_list, "p_x" . $fmea_list->RowIndex . "_idworkcenter") ?>
</span>
<input type="hidden" data-table="fmea" data-field="x_idworkcenter" name="o<?php echo $fmea_list->RowIndex ?>_idworkcenter" id="o<?php echo $fmea_list->RowIndex ?>_idworkcenter" value="<?php echo HtmlEncode($fmea_list->idworkcenter->OldValue) ?>">
<?php } ?>
<?php if ($fmea->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $fmea_list->RowCount ?>_fmea_idworkcenter" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="fmea" data-field="x_idworkcenter" data-value-separator="<?php echo $fmea_list->idworkcenter->displayValueSeparatorAttribute() ?>" id="x<?php echo $fmea_list->RowIndex ?>_idworkcenter" name="x<?php echo $fmea_list->RowIndex ?>_idworkcenter"<?php echo $fmea_list->idworkcenter->editAttributes() ?>>
			<?php echo $fmea_list->idworkcenter->selectOptionListHtml("x{$fmea_list->RowIndex}_idworkcenter") ?>
		</select>
</div>
<?php echo $fmea_list->idworkcenter->Lookup->getParamTag($fmea_list, "p_x" . $fmea_list->RowIndex . "_idworkcenter") ?>
</span>
<?php } ?>
<?php if ($fmea->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $fmea_list->RowCount ?>_fmea_idworkcenter">
<span<?php echo $fmea_list->idworkcenter->viewAttributes() ?>><?php echo $fmea_list->idworkcenter->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$fmea_list->ListOptions->render("body", "right", $fmea_list->RowCount);
?>
	</tr>
<?php if ($fmea->RowType == ROWTYPE_ADD || $fmea->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["ffmealist", "load"], function() {
	ffmealist.updateLists(<?php echo $fmea_list->RowIndex ?>);
});
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$fmea_list->isGridAdd())
		if (!$fmea_list->Recordset->EOF)
			$fmea_list->Recordset->moveNext();
}
?>
<?php
	if ($fmea_list->isGridAdd() || $fmea_list->isGridEdit()) {
		$fmea_list->RowIndex = '$rowindex$';
		$fmea_list->loadRowValues();

		// Set row properties
		$fmea->resetAttributes();
		$fmea->RowAttrs->merge(["data-rowindex" => $fmea_list->RowIndex, "id" => "r0_fmea", "data-rowtype" => ROWTYPE_ADD]);
		$fmea->RowAttrs->appendClass("ew-template");
		$fmea->RowType = ROWTYPE_ADD;

		// Render row
		$fmea_list->renderRow();

		// Render list options
		$fmea_list->renderListOptions();
		$fmea_list->StartRowCount = 0;
?>
	<tr <?php echo $fmea->rowAttributes() ?>>
<?php

// Render list options (body, left)
$fmea_list->ListOptions->render("body", "left", $fmea_list->RowIndex);
?>
	<?php if ($fmea_list->fmea->Visible) { // fmea ?>
		<td data-name="fmea">
<span id="el$rowindex$_fmea_fmea" class="form-group fmea_fmea">
<input type="text" data-table="fmea" data-field="x_fmea" name="x<?php echo $fmea_list->RowIndex ?>_fmea" id="x<?php echo $fmea_list->RowIndex ?>_fmea" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($fmea_list->fmea->getPlaceHolder()) ?>" value="<?php echo $fmea_list->fmea->EditValue ?>"<?php echo $fmea_list->fmea->editAttributes() ?>>
</span>
<input type="hidden" data-table="fmea" data-field="x_fmea" name="o<?php echo $fmea_list->RowIndex ?>_fmea" id="o<?php echo $fmea_list->RowIndex ?>_fmea" value="<?php echo HtmlEncode($fmea_list->fmea->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($fmea_list->idFactory->Visible) { // idFactory ?>
		<td data-name="idFactory">
<span id="el$rowindex$_fmea_idFactory" class="form-group fmea_idFactory">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="fmea" data-field="x_idFactory" data-value-separator="<?php echo $fmea_list->idFactory->displayValueSeparatorAttribute() ?>" id="x<?php echo $fmea_list->RowIndex ?>_idFactory" name="x<?php echo $fmea_list->RowIndex ?>_idFactory"<?php echo $fmea_list->idFactory->editAttributes() ?>>
			<?php echo $fmea_list->idFactory->selectOptionListHtml("x{$fmea_list->RowIndex}_idFactory") ?>
		</select>
</div>
<?php echo $fmea_list->idFactory->Lookup->getParamTag($fmea_list, "p_x" . $fmea_list->RowIndex . "_idFactory") ?>
</span>
<input type="hidden" data-table="fmea" data-field="x_idFactory" name="o<?php echo $fmea_list->RowIndex ?>_idFactory" id="o<?php echo $fmea_list->RowIndex ?>_idFactory" value="<?php echo HtmlEncode($fmea_list->idFactory->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($fmea_list->dateFmea->Visible) { // dateFmea ?>
		<td data-name="dateFmea">
<span id="el$rowindex$_fmea_dateFmea" class="form-group fmea_dateFmea">
<input type="text" data-table="fmea" data-field="x_dateFmea" name="x<?php echo $fmea_list->RowIndex ?>_dateFmea" id="x<?php echo $fmea_list->RowIndex ?>_dateFmea" placeholder="<?php echo HtmlEncode($fmea_list->dateFmea->getPlaceHolder()) ?>" value="<?php echo $fmea_list->dateFmea->EditValue ?>"<?php echo $fmea_list->dateFmea->editAttributes() ?>>
<?php if (!$fmea_list->dateFmea->ReadOnly && !$fmea_list->dateFmea->Disabled && !isset($fmea_list->dateFmea->EditAttrs["readonly"]) && !isset($fmea_list->dateFmea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffmealist", "datetimepicker"], function() {
	ew.createDateTimePicker("ffmealist", "x<?php echo $fmea_list->RowIndex ?>_dateFmea", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="fmea" data-field="x_dateFmea" name="o<?php echo $fmea_list->RowIndex ?>_dateFmea" id="o<?php echo $fmea_list->RowIndex ?>_dateFmea" value="<?php echo HtmlEncode($fmea_list->dateFmea->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($fmea_list->partnumbers->Visible) { // partnumbers ?>
		<td data-name="partnumbers">
<span id="el$rowindex$_fmea_partnumbers" class="form-group fmea_partnumbers">
<textarea data-table="fmea" data-field="x_partnumbers" name="x<?php echo $fmea_list->RowIndex ?>_partnumbers" id="x<?php echo $fmea_list->RowIndex ?>_partnumbers" cols="35" rows="4" placeholder="<?php echo HtmlEncode($fmea_list->partnumbers->getPlaceHolder()) ?>"<?php echo $fmea_list->partnumbers->editAttributes() ?>><?php echo $fmea_list->partnumbers->EditValue ?></textarea>
</span>
<input type="hidden" data-table="fmea" data-field="x_partnumbers" name="o<?php echo $fmea_list->RowIndex ?>_partnumbers" id="o<?php echo $fmea_list->RowIndex ?>_partnumbers" value="<?php echo HtmlEncode($fmea_list->partnumbers->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($fmea_list->description->Visible) { // description ?>
		<td data-name="description">
<span id="el$rowindex$_fmea_description" class="form-group fmea_description">
<textarea data-table="fmea" data-field="x_description" name="x<?php echo $fmea_list->RowIndex ?>_description" id="x<?php echo $fmea_list->RowIndex ?>_description" cols="35" rows="4" placeholder="<?php echo HtmlEncode($fmea_list->description->getPlaceHolder()) ?>"<?php echo $fmea_list->description->editAttributes() ?>><?php echo $fmea_list->description->EditValue ?></textarea>
</span>
<input type="hidden" data-table="fmea" data-field="x_description" name="o<?php echo $fmea_list->RowIndex ?>_description" id="o<?php echo $fmea_list->RowIndex ?>_description" value="<?php echo HtmlEncode($fmea_list->description->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($fmea_list->idEmployee->Visible) { // idEmployee ?>
		<td data-name="idEmployee">
<span id="el$rowindex$_fmea_idEmployee" class="form-group fmea_idEmployee">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?php echo $fmea_list->RowIndex ?>_idEmployee"><?php echo EmptyValue(strval($fmea_list->idEmployee->ViewValue)) ? $Language->phrase("PleaseSelect") : $fmea_list->idEmployee->ViewValue ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($fmea_list->idEmployee->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo ($fmea_list->idEmployee->ReadOnly || $fmea_list->idEmployee->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?php echo $fmea_list->RowIndex ?>_idEmployee[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
	</div>
</div>
<?php echo $fmea_list->idEmployee->Lookup->getParamTag($fmea_list, "p_x" . $fmea_list->RowIndex . "_idEmployee") ?>
<input type="hidden" data-table="fmea" data-field="x_idEmployee" data-multiple="1" data-lookup="1" data-value-separator="<?php echo $fmea_list->idEmployee->displayValueSeparatorAttribute() ?>" name="x<?php echo $fmea_list->RowIndex ?>_idEmployee[]" id="x<?php echo $fmea_list->RowIndex ?>_idEmployee[]" value="<?php echo $fmea_list->idEmployee->CurrentValue ?>"<?php echo $fmea_list->idEmployee->editAttributes() ?>>
</span>
<input type="hidden" data-table="fmea" data-field="x_idEmployee" name="o<?php echo $fmea_list->RowIndex ?>_idEmployee[]" id="o<?php echo $fmea_list->RowIndex ?>_idEmployee[]" value="<?php echo HtmlEncode($fmea_list->idEmployee->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($fmea_list->idworkcenter->Visible) { // idworkcenter ?>
		<td data-name="idworkcenter">
<span id="el$rowindex$_fmea_idworkcenter" class="form-group fmea_idworkcenter">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="fmea" data-field="x_idworkcenter" data-value-separator="<?php echo $fmea_list->idworkcenter->displayValueSeparatorAttribute() ?>" id="x<?php echo $fmea_list->RowIndex ?>_idworkcenter" name="x<?php echo $fmea_list->RowIndex ?>_idworkcenter"<?php echo $fmea_list->idworkcenter->editAttributes() ?>>
			<?php echo $fmea_list->idworkcenter->selectOptionListHtml("x{$fmea_list->RowIndex}_idworkcenter") ?>
		</select>
</div>
<?php echo $fmea_list->idworkcenter->Lookup->getParamTag($fmea_list, "p_x" . $fmea_list->RowIndex . "_idworkcenter") ?>
</span>
<input type="hidden" data-table="fmea" data-field="x_idworkcenter" name="o<?php echo $fmea_list->RowIndex ?>_idworkcenter" id="o<?php echo $fmea_list->RowIndex ?>_idworkcenter" value="<?php echo HtmlEncode($fmea_list->idworkcenter->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$fmea_list->ListOptions->render("body", "right", $fmea_list->RowIndex);
?>
<script>
loadjs.ready(["ffmealist", "load"], function() {
	ffmealist.updateLists(<?php echo $fmea_list->RowIndex ?>);
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
<?php if ($fmea_list->isGridEdit()) { ?>
<?php if ($fmea->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="action" id="action" value="gridoverwrite">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<?php } ?>
<input type="hidden" name="<?php echo $fmea_list->FormKeyCountName ?>" id="<?php echo $fmea_list->FormKeyCountName ?>" value="<?php echo $fmea_list->KeyCount ?>">
<?php echo $fmea_list->MultiSelectKey ?>
<?php } ?>
<?php if (!$fmea->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($fmea_list->Recordset)
	$fmea_list->Recordset->Close();
?>
<?php if (!$fmea_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$fmea_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $fmea_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $fmea_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($fmea_list->TotalRecords == 0 && !$fmea->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $fmea_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$fmea_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$fmea_list->isExport()) { ?>
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
$fmea_list->terminate();
?>