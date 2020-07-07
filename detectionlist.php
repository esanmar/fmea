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
$detection_list = new detection_list();

// Run the page
$detection_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$detection_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$detection_list->isExport()) { ?>
<script>
var fdetectionlist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	fdetectionlist = currentForm = new ew.Form("fdetectionlist", "list");
	fdetectionlist.formKeyCountName = '<?php echo $detection_list->FormKeyCountName ?>';

	// Validate form
	fdetectionlist.validate = function() {
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
			<?php if ($detection_list->idDetection->Required) { ?>
				elm = this.getElements("x" + infix + "_idDetection");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $detection_list->idDetection->caption(), $detection_list->idDetection->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($detection_list->detection->Required) { ?>
				elm = this.getElements("x" + infix + "_detection");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $detection_list->detection->caption(), $detection_list->detection->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($detection_list->description->Required) { ?>
				elm = this.getElements("x" + infix + "_description");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $detection_list->description->caption(), $detection_list->description->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($detection_list->methods->Required) { ?>
				elm = this.getElements("x" + infix + "_methods");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $detection_list->methods->caption(), $detection_list->methods->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($detection_list->errorProofed->Required) { ?>
				elm = this.getElements("x" + infix + "_errorProofed[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $detection_list->errorProofed->caption(), $detection_list->errorProofed->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($detection_list->gonogo->Required) { ?>
				elm = this.getElements("x" + infix + "_gonogo[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $detection_list->gonogo->caption(), $detection_list->gonogo->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($detection_list->visualInspection->Required) { ?>
				elm = this.getElements("x" + infix + "_visualInspection[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $detection_list->visualInspection->caption(), $detection_list->visualInspection->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($detection_list->color->Required) { ?>
				elm = this.getElements("x" + infix + "_color");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $detection_list->color->caption(), $detection_list->color->RequiredErrorMessage)) ?>");
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
	fdetectionlist.emptyRow = function(infix) {
		var fobj = this._form;
		if (ew.valueChanged(fobj, infix, "detection", false)) return false;
		if (ew.valueChanged(fobj, infix, "description", false)) return false;
		if (ew.valueChanged(fobj, infix, "methods", false)) return false;
		if (ew.valueChanged(fobj, infix, "errorProofed[]", true)) return false;
		if (ew.valueChanged(fobj, infix, "gonogo[]", true)) return false;
		if (ew.valueChanged(fobj, infix, "visualInspection[]", true)) return false;
		if (ew.valueChanged(fobj, infix, "color", false)) return false;
		return true;
	}

	// Form_CustomValidate
	fdetectionlist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fdetectionlist.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fdetectionlist.lists["x_errorProofed[]"] = <?php echo $detection_list->errorProofed->Lookup->toClientList($detection_list) ?>;
	fdetectionlist.lists["x_errorProofed[]"].options = <?php echo JsonEncode($detection_list->errorProofed->options(FALSE, TRUE)) ?>;
	fdetectionlist.lists["x_gonogo[]"] = <?php echo $detection_list->gonogo->Lookup->toClientList($detection_list) ?>;
	fdetectionlist.lists["x_gonogo[]"].options = <?php echo JsonEncode($detection_list->gonogo->options(FALSE, TRUE)) ?>;
	fdetectionlist.lists["x_visualInspection[]"] = <?php echo $detection_list->visualInspection->Lookup->toClientList($detection_list) ?>;
	fdetectionlist.lists["x_visualInspection[]"].options = <?php echo JsonEncode($detection_list->visualInspection->options(FALSE, TRUE)) ?>;
	loadjs.done("fdetectionlist");
});
var fdetectionlistsrch;
loadjs.ready("head", function() {

	// Form object for search
	fdetectionlistsrch = currentSearchForm = new ew.Form("fdetectionlistsrch");

	// Dynamic selection lists
	// Filters

	fdetectionlistsrch.filterList = <?php echo $detection_list->getFilterList() ?>;
	loadjs.done("fdetectionlistsrch");
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
<?php if (!$detection_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($detection_list->TotalRecords > 0 && $detection_list->ExportOptions->visible()) { ?>
<?php $detection_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($detection_list->ImportOptions->visible()) { ?>
<?php $detection_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($detection_list->SearchOptions->visible()) { ?>
<?php $detection_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($detection_list->FilterOptions->visible()) { ?>
<?php $detection_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$detection_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$detection_list->isExport() && !$detection->CurrentAction) { ?>
<form name="fdetectionlistsrch" id="fdetectionlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="fdetectionlistsrch-search-panel" class="<?php echo $detection_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="detection">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $detection_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($detection_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($detection_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $detection_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($detection_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($detection_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($detection_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($detection_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $detection_list->showPageHeader(); ?>
<?php
$detection_list->showMessage();
?>
<?php if ($detection_list->TotalRecords > 0 || $detection->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($detection_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> detection">
<?php if (!$detection_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$detection_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $detection_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $detection_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fdetectionlist" id="fdetectionlist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="detection">
<div id="gmp_detection" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($detection_list->TotalRecords > 0 || $detection_list->isGridEdit()) { ?>
<table id="tbl_detectionlist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$detection->RowType = ROWTYPE_HEADER;

// Render list options
$detection_list->renderListOptions();

// Render list options (header, left)
$detection_list->ListOptions->render("header", "left");
?>
<?php if ($detection_list->idDetection->Visible) { // idDetection ?>
	<?php if ($detection_list->SortUrl($detection_list->idDetection) == "") { ?>
		<th data-name="idDetection" class="<?php echo $detection_list->idDetection->headerCellClass() ?>"><div id="elh_detection_idDetection" class="detection_idDetection"><div class="ew-table-header-caption"><?php echo $detection_list->idDetection->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idDetection" class="<?php echo $detection_list->idDetection->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $detection_list->SortUrl($detection_list->idDetection) ?>', 2);"><div id="elh_detection_idDetection" class="detection_idDetection">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $detection_list->idDetection->caption() ?></span><span class="ew-table-header-sort"><?php if ($detection_list->idDetection->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($detection_list->idDetection->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($detection_list->detection->Visible) { // detection ?>
	<?php if ($detection_list->SortUrl($detection_list->detection) == "") { ?>
		<th data-name="detection" class="<?php echo $detection_list->detection->headerCellClass() ?>"><div id="elh_detection_detection" class="detection_detection"><div class="ew-table-header-caption"><?php echo $detection_list->detection->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="detection" class="<?php echo $detection_list->detection->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $detection_list->SortUrl($detection_list->detection) ?>', 2);"><div id="elh_detection_detection" class="detection_detection">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $detection_list->detection->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($detection_list->detection->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($detection_list->detection->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($detection_list->description->Visible) { // description ?>
	<?php if ($detection_list->SortUrl($detection_list->description) == "") { ?>
		<th data-name="description" class="<?php echo $detection_list->description->headerCellClass() ?>"><div id="elh_detection_description" class="detection_description"><div class="ew-table-header-caption"><?php echo $detection_list->description->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="description" class="<?php echo $detection_list->description->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $detection_list->SortUrl($detection_list->description) ?>', 2);"><div id="elh_detection_description" class="detection_description">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $detection_list->description->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($detection_list->description->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($detection_list->description->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($detection_list->methods->Visible) { // methods ?>
	<?php if ($detection_list->SortUrl($detection_list->methods) == "") { ?>
		<th data-name="methods" class="<?php echo $detection_list->methods->headerCellClass() ?>"><div id="elh_detection_methods" class="detection_methods"><div class="ew-table-header-caption"><?php echo $detection_list->methods->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="methods" class="<?php echo $detection_list->methods->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $detection_list->SortUrl($detection_list->methods) ?>', 2);"><div id="elh_detection_methods" class="detection_methods">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $detection_list->methods->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($detection_list->methods->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($detection_list->methods->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($detection_list->errorProofed->Visible) { // errorProofed ?>
	<?php if ($detection_list->SortUrl($detection_list->errorProofed) == "") { ?>
		<th data-name="errorProofed" class="<?php echo $detection_list->errorProofed->headerCellClass() ?>"><div id="elh_detection_errorProofed" class="detection_errorProofed"><div class="ew-table-header-caption"><?php echo $detection_list->errorProofed->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="errorProofed" class="<?php echo $detection_list->errorProofed->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $detection_list->SortUrl($detection_list->errorProofed) ?>', 2);"><div id="elh_detection_errorProofed" class="detection_errorProofed">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $detection_list->errorProofed->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($detection_list->errorProofed->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($detection_list->errorProofed->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($detection_list->gonogo->Visible) { // gonogo ?>
	<?php if ($detection_list->SortUrl($detection_list->gonogo) == "") { ?>
		<th data-name="gonogo" class="<?php echo $detection_list->gonogo->headerCellClass() ?>"><div id="elh_detection_gonogo" class="detection_gonogo"><div class="ew-table-header-caption"><?php echo $detection_list->gonogo->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="gonogo" class="<?php echo $detection_list->gonogo->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $detection_list->SortUrl($detection_list->gonogo) ?>', 2);"><div id="elh_detection_gonogo" class="detection_gonogo">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $detection_list->gonogo->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($detection_list->gonogo->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($detection_list->gonogo->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($detection_list->visualInspection->Visible) { // visualInspection ?>
	<?php if ($detection_list->SortUrl($detection_list->visualInspection) == "") { ?>
		<th data-name="visualInspection" class="<?php echo $detection_list->visualInspection->headerCellClass() ?>"><div id="elh_detection_visualInspection" class="detection_visualInspection"><div class="ew-table-header-caption"><?php echo $detection_list->visualInspection->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="visualInspection" class="<?php echo $detection_list->visualInspection->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $detection_list->SortUrl($detection_list->visualInspection) ?>', 2);"><div id="elh_detection_visualInspection" class="detection_visualInspection">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $detection_list->visualInspection->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($detection_list->visualInspection->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($detection_list->visualInspection->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($detection_list->color->Visible) { // color ?>
	<?php if ($detection_list->SortUrl($detection_list->color) == "") { ?>
		<th data-name="color" class="<?php echo $detection_list->color->headerCellClass() ?>"><div id="elh_detection_color" class="detection_color"><div class="ew-table-header-caption"><?php echo $detection_list->color->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="color" class="<?php echo $detection_list->color->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $detection_list->SortUrl($detection_list->color) ?>', 2);"><div id="elh_detection_color" class="detection_color">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $detection_list->color->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($detection_list->color->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($detection_list->color->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$detection_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($detection_list->ExportAll && $detection_list->isExport()) {
	$detection_list->StopRecord = $detection_list->TotalRecords;
} else {

	// Set the last record to display
	if ($detection_list->TotalRecords > $detection_list->StartRecord + $detection_list->DisplayRecords - 1)
		$detection_list->StopRecord = $detection_list->StartRecord + $detection_list->DisplayRecords - 1;
	else
		$detection_list->StopRecord = $detection_list->TotalRecords;
}

// Restore number of post back records
if ($CurrentForm && ($detection->isConfirm() || $detection_list->EventCancelled)) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($detection_list->FormKeyCountName) && ($detection_list->isGridAdd() || $detection_list->isGridEdit() || $detection->isConfirm())) {
		$detection_list->KeyCount = $CurrentForm->getValue($detection_list->FormKeyCountName);
		$detection_list->StopRecord = $detection_list->StartRecord + $detection_list->KeyCount - 1;
	}
}
$detection_list->RecordCount = $detection_list->StartRecord - 1;
if ($detection_list->Recordset && !$detection_list->Recordset->EOF) {
	$detection_list->Recordset->moveFirst();
	$selectLimit = $detection_list->UseSelectLimit;
	if (!$selectLimit && $detection_list->StartRecord > 1)
		$detection_list->Recordset->move($detection_list->StartRecord - 1);
} elseif (!$detection->AllowAddDeleteRow && $detection_list->StopRecord == 0) {
	$detection_list->StopRecord = $detection->GridAddRowCount;
}

// Initialize aggregate
$detection->RowType = ROWTYPE_AGGREGATEINIT;
$detection->resetAttributes();
$detection_list->renderRow();
$detection_list->EditRowCount = 0;
if ($detection_list->isEdit())
	$detection_list->RowIndex = 1;
if ($detection_list->isGridAdd())
	$detection_list->RowIndex = 0;
if ($detection_list->isGridEdit())
	$detection_list->RowIndex = 0;
while ($detection_list->RecordCount < $detection_list->StopRecord) {
	$detection_list->RecordCount++;
	if ($detection_list->RecordCount >= $detection_list->StartRecord) {
		$detection_list->RowCount++;
		if ($detection_list->isGridAdd() || $detection_list->isGridEdit() || $detection->isConfirm()) {
			$detection_list->RowIndex++;
			$CurrentForm->Index = $detection_list->RowIndex;
			if ($CurrentForm->hasValue($detection_list->FormActionName) && ($detection->isConfirm() || $detection_list->EventCancelled))
				$detection_list->RowAction = strval($CurrentForm->getValue($detection_list->FormActionName));
			elseif ($detection_list->isGridAdd())
				$detection_list->RowAction = "insert";
			else
				$detection_list->RowAction = "";
		}

		// Set up key count
		$detection_list->KeyCount = $detection_list->RowIndex;

		// Init row class and style
		$detection->resetAttributes();
		$detection->CssClass = "";
		if ($detection_list->isGridAdd()) {
			$detection_list->loadRowValues(); // Load default values
		} else {
			$detection_list->loadRowValues($detection_list->Recordset); // Load row values
		}
		$detection->RowType = ROWTYPE_VIEW; // Render view
		if ($detection_list->isGridAdd()) // Grid add
			$detection->RowType = ROWTYPE_ADD; // Render add
		if ($detection_list->isGridAdd() && $detection->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$detection_list->restoreCurrentRowFormValues($detection_list->RowIndex); // Restore form values
		if ($detection_list->isEdit()) {
			if ($detection_list->checkInlineEditKey() && $detection_list->EditRowCount == 0) { // Inline edit
				$detection->RowType = ROWTYPE_EDIT; // Render edit
				if (!$detection->EventCancelled)
					$detection_list->HashValue = $detection_list->getRowHash($detection_list->Recordset); // Get hash value for record
			}
		}
		if ($detection_list->isGridEdit()) { // Grid edit
			if ($detection->EventCancelled)
				$detection_list->restoreCurrentRowFormValues($detection_list->RowIndex); // Restore form values
			if ($detection_list->RowAction == "insert")
				$detection->RowType = ROWTYPE_ADD; // Render add
			else
				$detection->RowType = ROWTYPE_EDIT; // Render edit
			if (!$detection->EventCancelled)
				$detection_list->HashValue = $detection_list->getRowHash($detection_list->Recordset); // Get hash value for record
		}
		if ($detection_list->isEdit() && $detection->RowType == ROWTYPE_EDIT && $detection->EventCancelled) { // Update failed
			$CurrentForm->Index = 1;
			$detection_list->restoreFormValues(); // Restore form values
		}
		if ($detection_list->isGridEdit() && ($detection->RowType == ROWTYPE_EDIT || $detection->RowType == ROWTYPE_ADD) && $detection->EventCancelled) // Update failed
			$detection_list->restoreCurrentRowFormValues($detection_list->RowIndex); // Restore form values
		if ($detection->RowType == ROWTYPE_EDIT) // Edit row
			$detection_list->EditRowCount++;

		// Set up row id / data-rowindex
		$detection->RowAttrs->merge(["data-rowindex" => $detection_list->RowCount, "id" => "r" . $detection_list->RowCount . "_detection", "data-rowtype" => $detection->RowType]);

		// Render row
		$detection_list->renderRow();

		// Render list options
		$detection_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($detection_list->RowAction != "delete" && $detection_list->RowAction != "insertdelete" && !($detection_list->RowAction == "insert" && $detection->isConfirm() && $detection_list->emptyRow())) {
?>
	<tr <?php echo $detection->rowAttributes() ?>>
<?php

// Render list options (body, left)
$detection_list->ListOptions->render("body", "left", $detection_list->RowCount);
?>
	<?php if ($detection_list->idDetection->Visible) { // idDetection ?>
		<td data-name="idDetection" <?php echo $detection_list->idDetection->cellAttributes() ?>>
<?php if ($detection->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detection_list->RowCount ?>_detection_idDetection" class="form-group"></span>
<input type="hidden" data-table="detection" data-field="x_idDetection" name="o<?php echo $detection_list->RowIndex ?>_idDetection" id="o<?php echo $detection_list->RowIndex ?>_idDetection" value="<?php echo HtmlEncode($detection_list->idDetection->OldValue) ?>">
<?php } ?>
<?php if ($detection->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detection_list->RowCount ?>_detection_idDetection" class="form-group">
<span<?php echo $detection_list->idDetection->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($detection_list->idDetection->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="detection" data-field="x_idDetection" name="x<?php echo $detection_list->RowIndex ?>_idDetection" id="x<?php echo $detection_list->RowIndex ?>_idDetection" value="<?php echo HtmlEncode($detection_list->idDetection->CurrentValue) ?>">
<?php } ?>
<?php if ($detection->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detection_list->RowCount ?>_detection_idDetection">
<span<?php echo $detection_list->idDetection->viewAttributes() ?>><?php echo $detection_list->idDetection->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detection_list->detection->Visible) { // detection ?>
		<td data-name="detection" <?php echo $detection_list->detection->cellAttributes() ?>>
<?php if ($detection->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detection_list->RowCount ?>_detection_detection" class="form-group">
<input type="text" data-table="detection" data-field="x_detection" name="x<?php echo $detection_list->RowIndex ?>_detection" id="x<?php echo $detection_list->RowIndex ?>_detection" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($detection_list->detection->getPlaceHolder()) ?>" value="<?php echo $detection_list->detection->EditValue ?>"<?php echo $detection_list->detection->editAttributes() ?>>
</span>
<input type="hidden" data-table="detection" data-field="x_detection" name="o<?php echo $detection_list->RowIndex ?>_detection" id="o<?php echo $detection_list->RowIndex ?>_detection" value="<?php echo HtmlEncode($detection_list->detection->OldValue) ?>">
<?php } ?>
<?php if ($detection->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detection_list->RowCount ?>_detection_detection" class="form-group">
<input type="text" data-table="detection" data-field="x_detection" name="x<?php echo $detection_list->RowIndex ?>_detection" id="x<?php echo $detection_list->RowIndex ?>_detection" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($detection_list->detection->getPlaceHolder()) ?>" value="<?php echo $detection_list->detection->EditValue ?>"<?php echo $detection_list->detection->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($detection->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detection_list->RowCount ?>_detection_detection">
<span<?php echo $detection_list->detection->viewAttributes() ?>><?php echo $detection_list->detection->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detection_list->description->Visible) { // description ?>
		<td data-name="description" <?php echo $detection_list->description->cellAttributes() ?>>
<?php if ($detection->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detection_list->RowCount ?>_detection_description" class="form-group">
<textarea data-table="detection" data-field="x_description" name="x<?php echo $detection_list->RowIndex ?>_description" id="x<?php echo $detection_list->RowIndex ?>_description" cols="35" rows="4" placeholder="<?php echo HtmlEncode($detection_list->description->getPlaceHolder()) ?>"<?php echo $detection_list->description->editAttributes() ?>><?php echo $detection_list->description->EditValue ?></textarea>
</span>
<input type="hidden" data-table="detection" data-field="x_description" name="o<?php echo $detection_list->RowIndex ?>_description" id="o<?php echo $detection_list->RowIndex ?>_description" value="<?php echo HtmlEncode($detection_list->description->OldValue) ?>">
<?php } ?>
<?php if ($detection->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detection_list->RowCount ?>_detection_description" class="form-group">
<textarea data-table="detection" data-field="x_description" name="x<?php echo $detection_list->RowIndex ?>_description" id="x<?php echo $detection_list->RowIndex ?>_description" cols="35" rows="4" placeholder="<?php echo HtmlEncode($detection_list->description->getPlaceHolder()) ?>"<?php echo $detection_list->description->editAttributes() ?>><?php echo $detection_list->description->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($detection->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detection_list->RowCount ?>_detection_description">
<span<?php echo $detection_list->description->viewAttributes() ?>><?php echo $detection_list->description->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detection_list->methods->Visible) { // methods ?>
		<td data-name="methods" <?php echo $detection_list->methods->cellAttributes() ?>>
<?php if ($detection->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detection_list->RowCount ?>_detection_methods" class="form-group">
<textarea data-table="detection" data-field="x_methods" name="x<?php echo $detection_list->RowIndex ?>_methods" id="x<?php echo $detection_list->RowIndex ?>_methods" cols="35" rows="4" placeholder="<?php echo HtmlEncode($detection_list->methods->getPlaceHolder()) ?>"<?php echo $detection_list->methods->editAttributes() ?>><?php echo $detection_list->methods->EditValue ?></textarea>
</span>
<input type="hidden" data-table="detection" data-field="x_methods" name="o<?php echo $detection_list->RowIndex ?>_methods" id="o<?php echo $detection_list->RowIndex ?>_methods" value="<?php echo HtmlEncode($detection_list->methods->OldValue) ?>">
<?php } ?>
<?php if ($detection->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detection_list->RowCount ?>_detection_methods" class="form-group">
<textarea data-table="detection" data-field="x_methods" name="x<?php echo $detection_list->RowIndex ?>_methods" id="x<?php echo $detection_list->RowIndex ?>_methods" cols="35" rows="4" placeholder="<?php echo HtmlEncode($detection_list->methods->getPlaceHolder()) ?>"<?php echo $detection_list->methods->editAttributes() ?>><?php echo $detection_list->methods->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($detection->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detection_list->RowCount ?>_detection_methods">
<span<?php echo $detection_list->methods->viewAttributes() ?>><?php echo $detection_list->methods->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detection_list->errorProofed->Visible) { // errorProofed ?>
		<td data-name="errorProofed" <?php echo $detection_list->errorProofed->cellAttributes() ?>>
<?php if ($detection->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detection_list->RowCount ?>_detection_errorProofed" class="form-group">
<?php
$selwrk = ConvertToBool($detection_list->errorProofed->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="detection" data-field="x_errorProofed" name="x<?php echo $detection_list->RowIndex ?>_errorProofed[]" id="x<?php echo $detection_list->RowIndex ?>_errorProofed[]" value="1"<?php echo $selwrk ?><?php echo $detection_list->errorProofed->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $detection_list->RowIndex ?>_errorProofed[]"></label>
</div>
</span>
<input type="hidden" data-table="detection" data-field="x_errorProofed" name="o<?php echo $detection_list->RowIndex ?>_errorProofed[]" id="o<?php echo $detection_list->RowIndex ?>_errorProofed[]" value="<?php echo HtmlEncode($detection_list->errorProofed->OldValue) ?>">
<?php } ?>
<?php if ($detection->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detection_list->RowCount ?>_detection_errorProofed" class="form-group">
<?php
$selwrk = ConvertToBool($detection_list->errorProofed->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="detection" data-field="x_errorProofed" name="x<?php echo $detection_list->RowIndex ?>_errorProofed[]" id="x<?php echo $detection_list->RowIndex ?>_errorProofed[]" value="1"<?php echo $selwrk ?><?php echo $detection_list->errorProofed->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $detection_list->RowIndex ?>_errorProofed[]"></label>
</div>
</span>
<?php } ?>
<?php if ($detection->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detection_list->RowCount ?>_detection_errorProofed">
<span<?php echo $detection_list->errorProofed->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_errorProofed" class="custom-control-input" value="<?php echo $detection_list->errorProofed->getViewValue() ?>" disabled<?php if (ConvertToBool($detection_list->errorProofed->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_errorProofed"></label></div></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detection_list->gonogo->Visible) { // gonogo ?>
		<td data-name="gonogo" <?php echo $detection_list->gonogo->cellAttributes() ?>>
<?php if ($detection->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detection_list->RowCount ?>_detection_gonogo" class="form-group">
<?php
$selwrk = ConvertToBool($detection_list->gonogo->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="detection" data-field="x_gonogo" name="x<?php echo $detection_list->RowIndex ?>_gonogo[]" id="x<?php echo $detection_list->RowIndex ?>_gonogo[]" value="1"<?php echo $selwrk ?><?php echo $detection_list->gonogo->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $detection_list->RowIndex ?>_gonogo[]"></label>
</div>
</span>
<input type="hidden" data-table="detection" data-field="x_gonogo" name="o<?php echo $detection_list->RowIndex ?>_gonogo[]" id="o<?php echo $detection_list->RowIndex ?>_gonogo[]" value="<?php echo HtmlEncode($detection_list->gonogo->OldValue) ?>">
<?php } ?>
<?php if ($detection->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detection_list->RowCount ?>_detection_gonogo" class="form-group">
<?php
$selwrk = ConvertToBool($detection_list->gonogo->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="detection" data-field="x_gonogo" name="x<?php echo $detection_list->RowIndex ?>_gonogo[]" id="x<?php echo $detection_list->RowIndex ?>_gonogo[]" value="1"<?php echo $selwrk ?><?php echo $detection_list->gonogo->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $detection_list->RowIndex ?>_gonogo[]"></label>
</div>
</span>
<?php } ?>
<?php if ($detection->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detection_list->RowCount ?>_detection_gonogo">
<span<?php echo $detection_list->gonogo->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_gonogo" class="custom-control-input" value="<?php echo $detection_list->gonogo->getViewValue() ?>" disabled<?php if (ConvertToBool($detection_list->gonogo->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_gonogo"></label></div></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detection_list->visualInspection->Visible) { // visualInspection ?>
		<td data-name="visualInspection" <?php echo $detection_list->visualInspection->cellAttributes() ?>>
<?php if ($detection->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detection_list->RowCount ?>_detection_visualInspection" class="form-group">
<?php
$selwrk = ConvertToBool($detection_list->visualInspection->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="detection" data-field="x_visualInspection" name="x<?php echo $detection_list->RowIndex ?>_visualInspection[]" id="x<?php echo $detection_list->RowIndex ?>_visualInspection[]" value="1"<?php echo $selwrk ?><?php echo $detection_list->visualInspection->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $detection_list->RowIndex ?>_visualInspection[]"></label>
</div>
</span>
<input type="hidden" data-table="detection" data-field="x_visualInspection" name="o<?php echo $detection_list->RowIndex ?>_visualInspection[]" id="o<?php echo $detection_list->RowIndex ?>_visualInspection[]" value="<?php echo HtmlEncode($detection_list->visualInspection->OldValue) ?>">
<?php } ?>
<?php if ($detection->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detection_list->RowCount ?>_detection_visualInspection" class="form-group">
<?php
$selwrk = ConvertToBool($detection_list->visualInspection->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="detection" data-field="x_visualInspection" name="x<?php echo $detection_list->RowIndex ?>_visualInspection[]" id="x<?php echo $detection_list->RowIndex ?>_visualInspection[]" value="1"<?php echo $selwrk ?><?php echo $detection_list->visualInspection->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $detection_list->RowIndex ?>_visualInspection[]"></label>
</div>
</span>
<?php } ?>
<?php if ($detection->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detection_list->RowCount ?>_detection_visualInspection">
<span<?php echo $detection_list->visualInspection->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_visualInspection" class="custom-control-input" value="<?php echo $detection_list->visualInspection->getViewValue() ?>" disabled<?php if (ConvertToBool($detection_list->visualInspection->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_visualInspection"></label></div></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detection_list->color->Visible) { // color ?>
		<td data-name="color" <?php echo $detection_list->color->cellAttributes() ?>>
<?php if ($detection->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detection_list->RowCount ?>_detection_color" class="form-group">
<input type="text" data-table="detection" data-field="x_color" name="x<?php echo $detection_list->RowIndex ?>_color" id="x<?php echo $detection_list->RowIndex ?>_color" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($detection_list->color->getPlaceHolder()) ?>" value="<?php echo $detection_list->color->EditValue ?>"<?php echo $detection_list->color->editAttributes() ?>>

<script>
loadjs.ready("head", function() {
	jQuery("[id='x<?php echo $detection_list->RowIndex ?>_color']:not([id*='$rowindex$'])").colorpicker({ format: "hex" });
});
</script>

</span>
<input type="hidden" data-table="detection" data-field="x_color" name="o<?php echo $detection_list->RowIndex ?>_color" id="o<?php echo $detection_list->RowIndex ?>_color" value="<?php echo HtmlEncode($detection_list->color->OldValue) ?>">
<?php } ?>
<?php if ($detection->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detection_list->RowCount ?>_detection_color" class="form-group">
<input type="text" data-table="detection" data-field="x_color" name="x<?php echo $detection_list->RowIndex ?>_color" id="x<?php echo $detection_list->RowIndex ?>_color" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($detection_list->color->getPlaceHolder()) ?>" value="<?php echo $detection_list->color->EditValue ?>"<?php echo $detection_list->color->editAttributes() ?>>

<script>
loadjs.ready("head", function() {
	jQuery("[id='x<?php echo $detection_list->RowIndex ?>_color']:not([id*='$rowindex$'])").colorpicker({ format: "hex" });
});
</script>

</span>
<?php } ?>
<?php if ($detection->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detection_list->RowCount ?>_detection_color">
<span<?php echo $detection_list->color->viewAttributes() ?>><?php echo $detection_list->color->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$detection_list->ListOptions->render("body", "right", $detection_list->RowCount);
?>
	</tr>
<?php if ($detection->RowType == ROWTYPE_ADD || $detection->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fdetectionlist", "load"], function() {
	fdetectionlist.updateLists(<?php echo $detection_list->RowIndex ?>);
});
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$detection_list->isGridAdd())
		if (!$detection_list->Recordset->EOF)
			$detection_list->Recordset->moveNext();
}
?>
<?php
	if ($detection_list->isGridAdd() || $detection_list->isGridEdit()) {
		$detection_list->RowIndex = '$rowindex$';
		$detection_list->loadRowValues();

		// Set row properties
		$detection->resetAttributes();
		$detection->RowAttrs->merge(["data-rowindex" => $detection_list->RowIndex, "id" => "r0_detection", "data-rowtype" => ROWTYPE_ADD]);
		$detection->RowAttrs->appendClass("ew-template");
		$detection->RowType = ROWTYPE_ADD;

		// Render row
		$detection_list->renderRow();

		// Render list options
		$detection_list->renderListOptions();
		$detection_list->StartRowCount = 0;
?>
	<tr <?php echo $detection->rowAttributes() ?>>
<?php

// Render list options (body, left)
$detection_list->ListOptions->render("body", "left", $detection_list->RowIndex);
?>
	<?php if ($detection_list->idDetection->Visible) { // idDetection ?>
		<td data-name="idDetection">
<span id="el$rowindex$_detection_idDetection" class="form-group detection_idDetection"></span>
<input type="hidden" data-table="detection" data-field="x_idDetection" name="o<?php echo $detection_list->RowIndex ?>_idDetection" id="o<?php echo $detection_list->RowIndex ?>_idDetection" value="<?php echo HtmlEncode($detection_list->idDetection->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detection_list->detection->Visible) { // detection ?>
		<td data-name="detection">
<span id="el$rowindex$_detection_detection" class="form-group detection_detection">
<input type="text" data-table="detection" data-field="x_detection" name="x<?php echo $detection_list->RowIndex ?>_detection" id="x<?php echo $detection_list->RowIndex ?>_detection" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($detection_list->detection->getPlaceHolder()) ?>" value="<?php echo $detection_list->detection->EditValue ?>"<?php echo $detection_list->detection->editAttributes() ?>>
</span>
<input type="hidden" data-table="detection" data-field="x_detection" name="o<?php echo $detection_list->RowIndex ?>_detection" id="o<?php echo $detection_list->RowIndex ?>_detection" value="<?php echo HtmlEncode($detection_list->detection->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detection_list->description->Visible) { // description ?>
		<td data-name="description">
<span id="el$rowindex$_detection_description" class="form-group detection_description">
<textarea data-table="detection" data-field="x_description" name="x<?php echo $detection_list->RowIndex ?>_description" id="x<?php echo $detection_list->RowIndex ?>_description" cols="35" rows="4" placeholder="<?php echo HtmlEncode($detection_list->description->getPlaceHolder()) ?>"<?php echo $detection_list->description->editAttributes() ?>><?php echo $detection_list->description->EditValue ?></textarea>
</span>
<input type="hidden" data-table="detection" data-field="x_description" name="o<?php echo $detection_list->RowIndex ?>_description" id="o<?php echo $detection_list->RowIndex ?>_description" value="<?php echo HtmlEncode($detection_list->description->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detection_list->methods->Visible) { // methods ?>
		<td data-name="methods">
<span id="el$rowindex$_detection_methods" class="form-group detection_methods">
<textarea data-table="detection" data-field="x_methods" name="x<?php echo $detection_list->RowIndex ?>_methods" id="x<?php echo $detection_list->RowIndex ?>_methods" cols="35" rows="4" placeholder="<?php echo HtmlEncode($detection_list->methods->getPlaceHolder()) ?>"<?php echo $detection_list->methods->editAttributes() ?>><?php echo $detection_list->methods->EditValue ?></textarea>
</span>
<input type="hidden" data-table="detection" data-field="x_methods" name="o<?php echo $detection_list->RowIndex ?>_methods" id="o<?php echo $detection_list->RowIndex ?>_methods" value="<?php echo HtmlEncode($detection_list->methods->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detection_list->errorProofed->Visible) { // errorProofed ?>
		<td data-name="errorProofed">
<span id="el$rowindex$_detection_errorProofed" class="form-group detection_errorProofed">
<?php
$selwrk = ConvertToBool($detection_list->errorProofed->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="detection" data-field="x_errorProofed" name="x<?php echo $detection_list->RowIndex ?>_errorProofed[]" id="x<?php echo $detection_list->RowIndex ?>_errorProofed[]" value="1"<?php echo $selwrk ?><?php echo $detection_list->errorProofed->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $detection_list->RowIndex ?>_errorProofed[]"></label>
</div>
</span>
<input type="hidden" data-table="detection" data-field="x_errorProofed" name="o<?php echo $detection_list->RowIndex ?>_errorProofed[]" id="o<?php echo $detection_list->RowIndex ?>_errorProofed[]" value="<?php echo HtmlEncode($detection_list->errorProofed->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detection_list->gonogo->Visible) { // gonogo ?>
		<td data-name="gonogo">
<span id="el$rowindex$_detection_gonogo" class="form-group detection_gonogo">
<?php
$selwrk = ConvertToBool($detection_list->gonogo->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="detection" data-field="x_gonogo" name="x<?php echo $detection_list->RowIndex ?>_gonogo[]" id="x<?php echo $detection_list->RowIndex ?>_gonogo[]" value="1"<?php echo $selwrk ?><?php echo $detection_list->gonogo->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $detection_list->RowIndex ?>_gonogo[]"></label>
</div>
</span>
<input type="hidden" data-table="detection" data-field="x_gonogo" name="o<?php echo $detection_list->RowIndex ?>_gonogo[]" id="o<?php echo $detection_list->RowIndex ?>_gonogo[]" value="<?php echo HtmlEncode($detection_list->gonogo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detection_list->visualInspection->Visible) { // visualInspection ?>
		<td data-name="visualInspection">
<span id="el$rowindex$_detection_visualInspection" class="form-group detection_visualInspection">
<?php
$selwrk = ConvertToBool($detection_list->visualInspection->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="detection" data-field="x_visualInspection" name="x<?php echo $detection_list->RowIndex ?>_visualInspection[]" id="x<?php echo $detection_list->RowIndex ?>_visualInspection[]" value="1"<?php echo $selwrk ?><?php echo $detection_list->visualInspection->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $detection_list->RowIndex ?>_visualInspection[]"></label>
</div>
</span>
<input type="hidden" data-table="detection" data-field="x_visualInspection" name="o<?php echo $detection_list->RowIndex ?>_visualInspection[]" id="o<?php echo $detection_list->RowIndex ?>_visualInspection[]" value="<?php echo HtmlEncode($detection_list->visualInspection->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detection_list->color->Visible) { // color ?>
		<td data-name="color">
<span id="el$rowindex$_detection_color" class="form-group detection_color">
<input type="text" data-table="detection" data-field="x_color" name="x<?php echo $detection_list->RowIndex ?>_color" id="x<?php echo $detection_list->RowIndex ?>_color" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($detection_list->color->getPlaceHolder()) ?>" value="<?php echo $detection_list->color->EditValue ?>"<?php echo $detection_list->color->editAttributes() ?>>

<script>
loadjs.ready("head", function() {
	jQuery("[id='x<?php echo $detection_list->RowIndex ?>_color']:not([id*='$rowindex$'])").colorpicker({ format: "hex" });
});
</script>

</span>
<input type="hidden" data-table="detection" data-field="x_color" name="o<?php echo $detection_list->RowIndex ?>_color" id="o<?php echo $detection_list->RowIndex ?>_color" value="<?php echo HtmlEncode($detection_list->color->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$detection_list->ListOptions->render("body", "right", $detection_list->RowIndex);
?>
<script>
loadjs.ready(["fdetectionlist", "load"], function() {
	fdetectionlist.updateLists(<?php echo $detection_list->RowIndex ?>);
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
<?php if ($detection_list->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?php echo $detection_list->FormKeyCountName ?>" id="<?php echo $detection_list->FormKeyCountName ?>" value="<?php echo $detection_list->KeyCount ?>">
<?php echo $detection_list->MultiSelectKey ?>
<?php } ?>
<?php if ($detection_list->isEdit()) { ?>
<input type="hidden" name="<?php echo $detection_list->FormKeyCountName ?>" id="<?php echo $detection_list->FormKeyCountName ?>" value="<?php echo $detection_list->KeyCount ?>">
<?php } ?>
<?php if ($detection_list->isGridEdit()) { ?>
<?php if ($detection->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="action" id="action" value="gridoverwrite">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<?php } ?>
<input type="hidden" name="<?php echo $detection_list->FormKeyCountName ?>" id="<?php echo $detection_list->FormKeyCountName ?>" value="<?php echo $detection_list->KeyCount ?>">
<?php echo $detection_list->MultiSelectKey ?>
<?php } ?>
<?php if (!$detection->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($detection_list->Recordset)
	$detection_list->Recordset->Close();
?>
<?php if (!$detection_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$detection_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $detection_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $detection_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($detection_list->TotalRecords == 0 && !$detection->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $detection_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$detection_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$detection_list->isExport()) { ?>
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
$detection_list->terminate();
?>