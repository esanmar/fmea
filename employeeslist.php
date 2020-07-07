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
$employees_list = new employees_list();

// Run the page
$employees_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$employees_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$employees_list->isExport()) { ?>
<script>
var femployeeslist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	femployeeslist = currentForm = new ew.Form("femployeeslist", "list");
	femployeeslist.formKeyCountName = '<?php echo $employees_list->FormKeyCountName ?>';

	// Validate form
	femployeeslist.validate = function() {
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
			<?php if ($employees_list->idEmployee->Required) { ?>
				elm = this.getElements("x" + infix + "_idEmployee");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $employees_list->idEmployee->caption(), $employees_list->idEmployee->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($employees_list->name->Required) { ?>
				elm = this.getElements("x" + infix + "_name");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $employees_list->name->caption(), $employees_list->name->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($employees_list->surname->Required) { ?>
				elm = this.getElements("x" + infix + "_surname");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $employees_list->surname->caption(), $employees_list->surname->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($employees_list->idFactory->Required) { ?>
				elm = this.getElements("x" + infix + "_idFactory");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $employees_list->idFactory->caption(), $employees_list->idFactory->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($employees_list->userlevel->Required) { ?>
				elm = this.getElements("x" + infix + "_userlevel");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $employees_list->userlevel->caption(), $employees_list->userlevel->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($employees_list->password->Required) { ?>
				elm = this.getElements("x" + infix + "_password");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $employees_list->password->caption(), $employees_list->password->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($employees_list->workcenter->Required) { ?>
				elm = this.getElements("x" + infix + "_workcenter");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $employees_list->workcenter->caption(), $employees_list->workcenter->RequiredErrorMessage)) ?>");
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
	femployeeslist.emptyRow = function(infix) {
		var fobj = this._form;
		if (ew.valueChanged(fobj, infix, "idEmployee", false)) return false;
		if (ew.valueChanged(fobj, infix, "name", false)) return false;
		if (ew.valueChanged(fobj, infix, "surname", false)) return false;
		if (ew.valueChanged(fobj, infix, "idFactory", false)) return false;
		if (ew.valueChanged(fobj, infix, "userlevel", false)) return false;
		if (ew.valueChanged(fobj, infix, "password", false)) return false;
		if (ew.valueChanged(fobj, infix, "workcenter", false)) return false;
		return true;
	}

	// Form_CustomValidate
	femployeeslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	femployeeslist.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	femployeeslist.lists["x_idFactory"] = <?php echo $employees_list->idFactory->Lookup->toClientList($employees_list) ?>;
	femployeeslist.lists["x_idFactory"].options = <?php echo JsonEncode($employees_list->idFactory->lookupOptions()) ?>;
	femployeeslist.autoSuggests["x_idFactory"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
	femployeeslist.lists["x_userlevel"] = <?php echo $employees_list->userlevel->Lookup->toClientList($employees_list) ?>;
	femployeeslist.lists["x_userlevel"].options = <?php echo JsonEncode($employees_list->userlevel->options(FALSE, TRUE)) ?>;
	femployeeslist.lists["x_workcenter"] = <?php echo $employees_list->workcenter->Lookup->toClientList($employees_list) ?>;
	femployeeslist.lists["x_workcenter"].options = <?php echo JsonEncode($employees_list->workcenter->lookupOptions()) ?>;
	femployeeslist.autoSuggests["x_workcenter"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
	loadjs.done("femployeeslist");
});
var femployeeslistsrch;
loadjs.ready("head", function() {

	// Form object for search
	femployeeslistsrch = currentSearchForm = new ew.Form("femployeeslistsrch");

	// Dynamic selection lists
	// Filters

	femployeeslistsrch.filterList = <?php echo $employees_list->getFilterList() ?>;
	loadjs.done("femployeeslistsrch");
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
<?php if (!$employees_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($employees_list->TotalRecords > 0 && $employees_list->ExportOptions->visible()) { ?>
<?php $employees_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($employees_list->ImportOptions->visible()) { ?>
<?php $employees_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($employees_list->SearchOptions->visible()) { ?>
<?php $employees_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($employees_list->FilterOptions->visible()) { ?>
<?php $employees_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$employees_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$employees_list->isExport() && !$employees->CurrentAction) { ?>
<form name="femployeeslistsrch" id="femployeeslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="femployeeslistsrch-search-panel" class="<?php echo $employees_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="employees">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $employees_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($employees_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($employees_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $employees_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($employees_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($employees_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($employees_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($employees_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $employees_list->showPageHeader(); ?>
<?php
$employees_list->showMessage();
?>
<?php if ($employees_list->TotalRecords > 0 || $employees->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($employees_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> employees">
<?php if (!$employees_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$employees_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $employees_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $employees_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="femployeeslist" id="femployeeslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="employees">
<div id="gmp_employees" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($employees_list->TotalRecords > 0 || $employees_list->isGridEdit()) { ?>
<table id="tbl_employeeslist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$employees->RowType = ROWTYPE_HEADER;

// Render list options
$employees_list->renderListOptions();

// Render list options (header, left)
$employees_list->ListOptions->render("header", "left");
?>
<?php if ($employees_list->idEmployee->Visible) { // idEmployee ?>
	<?php if ($employees_list->SortUrl($employees_list->idEmployee) == "") { ?>
		<th data-name="idEmployee" class="<?php echo $employees_list->idEmployee->headerCellClass() ?>"><div id="elh_employees_idEmployee" class="employees_idEmployee"><div class="ew-table-header-caption"><?php echo $employees_list->idEmployee->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idEmployee" class="<?php echo $employees_list->idEmployee->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $employees_list->SortUrl($employees_list->idEmployee) ?>', 2);"><div id="elh_employees_idEmployee" class="employees_idEmployee">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $employees_list->idEmployee->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($employees_list->idEmployee->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($employees_list->idEmployee->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($employees_list->name->Visible) { // name ?>
	<?php if ($employees_list->SortUrl($employees_list->name) == "") { ?>
		<th data-name="name" class="<?php echo $employees_list->name->headerCellClass() ?>"><div id="elh_employees_name" class="employees_name"><div class="ew-table-header-caption"><?php echo $employees_list->name->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="name" class="<?php echo $employees_list->name->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $employees_list->SortUrl($employees_list->name) ?>', 2);"><div id="elh_employees_name" class="employees_name">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $employees_list->name->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($employees_list->name->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($employees_list->name->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($employees_list->surname->Visible) { // surname ?>
	<?php if ($employees_list->SortUrl($employees_list->surname) == "") { ?>
		<th data-name="surname" class="<?php echo $employees_list->surname->headerCellClass() ?>"><div id="elh_employees_surname" class="employees_surname"><div class="ew-table-header-caption"><?php echo $employees_list->surname->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="surname" class="<?php echo $employees_list->surname->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $employees_list->SortUrl($employees_list->surname) ?>', 2);"><div id="elh_employees_surname" class="employees_surname">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $employees_list->surname->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($employees_list->surname->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($employees_list->surname->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($employees_list->idFactory->Visible) { // idFactory ?>
	<?php if ($employees_list->SortUrl($employees_list->idFactory) == "") { ?>
		<th data-name="idFactory" class="<?php echo $employees_list->idFactory->headerCellClass() ?>"><div id="elh_employees_idFactory" class="employees_idFactory"><div class="ew-table-header-caption"><?php echo $employees_list->idFactory->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idFactory" class="<?php echo $employees_list->idFactory->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $employees_list->SortUrl($employees_list->idFactory) ?>', 2);"><div id="elh_employees_idFactory" class="employees_idFactory">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $employees_list->idFactory->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($employees_list->idFactory->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($employees_list->idFactory->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($employees_list->userlevel->Visible) { // userlevel ?>
	<?php if ($employees_list->SortUrl($employees_list->userlevel) == "") { ?>
		<th data-name="userlevel" class="<?php echo $employees_list->userlevel->headerCellClass() ?>"><div id="elh_employees_userlevel" class="employees_userlevel"><div class="ew-table-header-caption"><?php echo $employees_list->userlevel->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="userlevel" class="<?php echo $employees_list->userlevel->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $employees_list->SortUrl($employees_list->userlevel) ?>', 2);"><div id="elh_employees_userlevel" class="employees_userlevel">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $employees_list->userlevel->caption() ?></span><span class="ew-table-header-sort"><?php if ($employees_list->userlevel->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($employees_list->userlevel->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($employees_list->password->Visible) { // password ?>
	<?php if ($employees_list->SortUrl($employees_list->password) == "") { ?>
		<th data-name="password" class="<?php echo $employees_list->password->headerCellClass() ?>"><div id="elh_employees_password" class="employees_password"><div class="ew-table-header-caption"><?php echo $employees_list->password->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="password" class="<?php echo $employees_list->password->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $employees_list->SortUrl($employees_list->password) ?>', 2);"><div id="elh_employees_password" class="employees_password">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $employees_list->password->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($employees_list->password->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($employees_list->password->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($employees_list->workcenter->Visible) { // workcenter ?>
	<?php if ($employees_list->SortUrl($employees_list->workcenter) == "") { ?>
		<th data-name="workcenter" class="<?php echo $employees_list->workcenter->headerCellClass() ?>"><div id="elh_employees_workcenter" class="employees_workcenter"><div class="ew-table-header-caption"><?php echo $employees_list->workcenter->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="workcenter" class="<?php echo $employees_list->workcenter->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $employees_list->SortUrl($employees_list->workcenter) ?>', 2);"><div id="elh_employees_workcenter" class="employees_workcenter">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $employees_list->workcenter->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($employees_list->workcenter->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($employees_list->workcenter->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$employees_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($employees_list->ExportAll && $employees_list->isExport()) {
	$employees_list->StopRecord = $employees_list->TotalRecords;
} else {

	// Set the last record to display
	if ($employees_list->TotalRecords > $employees_list->StartRecord + $employees_list->DisplayRecords - 1)
		$employees_list->StopRecord = $employees_list->StartRecord + $employees_list->DisplayRecords - 1;
	else
		$employees_list->StopRecord = $employees_list->TotalRecords;
}

// Restore number of post back records
if ($CurrentForm && ($employees->isConfirm() || $employees_list->EventCancelled)) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($employees_list->FormKeyCountName) && ($employees_list->isGridAdd() || $employees_list->isGridEdit() || $employees->isConfirm())) {
		$employees_list->KeyCount = $CurrentForm->getValue($employees_list->FormKeyCountName);
		$employees_list->StopRecord = $employees_list->StartRecord + $employees_list->KeyCount - 1;
	}
}
$employees_list->RecordCount = $employees_list->StartRecord - 1;
if ($employees_list->Recordset && !$employees_list->Recordset->EOF) {
	$employees_list->Recordset->moveFirst();
	$selectLimit = $employees_list->UseSelectLimit;
	if (!$selectLimit && $employees_list->StartRecord > 1)
		$employees_list->Recordset->move($employees_list->StartRecord - 1);
} elseif (!$employees->AllowAddDeleteRow && $employees_list->StopRecord == 0) {
	$employees_list->StopRecord = $employees->GridAddRowCount;
}

// Initialize aggregate
$employees->RowType = ROWTYPE_AGGREGATEINIT;
$employees->resetAttributes();
$employees_list->renderRow();
if ($employees_list->isGridAdd())
	$employees_list->RowIndex = 0;
if ($employees_list->isGridEdit())
	$employees_list->RowIndex = 0;
while ($employees_list->RecordCount < $employees_list->StopRecord) {
	$employees_list->RecordCount++;
	if ($employees_list->RecordCount >= $employees_list->StartRecord) {
		$employees_list->RowCount++;
		if ($employees_list->isGridAdd() || $employees_list->isGridEdit() || $employees->isConfirm()) {
			$employees_list->RowIndex++;
			$CurrentForm->Index = $employees_list->RowIndex;
			if ($CurrentForm->hasValue($employees_list->FormActionName) && ($employees->isConfirm() || $employees_list->EventCancelled))
				$employees_list->RowAction = strval($CurrentForm->getValue($employees_list->FormActionName));
			elseif ($employees_list->isGridAdd())
				$employees_list->RowAction = "insert";
			else
				$employees_list->RowAction = "";
		}

		// Set up key count
		$employees_list->KeyCount = $employees_list->RowIndex;

		// Init row class and style
		$employees->resetAttributes();
		$employees->CssClass = "";
		if ($employees_list->isGridAdd()) {
			$employees_list->loadRowValues(); // Load default values
		} else {
			$employees_list->loadRowValues($employees_list->Recordset); // Load row values
		}
		$employees->RowType = ROWTYPE_VIEW; // Render view
		if ($employees_list->isGridAdd()) // Grid add
			$employees->RowType = ROWTYPE_ADD; // Render add
		if ($employees_list->isGridAdd() && $employees->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$employees_list->restoreCurrentRowFormValues($employees_list->RowIndex); // Restore form values
		if ($employees_list->isGridEdit()) { // Grid edit
			if ($employees->EventCancelled)
				$employees_list->restoreCurrentRowFormValues($employees_list->RowIndex); // Restore form values
			if ($employees_list->RowAction == "insert")
				$employees->RowType = ROWTYPE_ADD; // Render add
			else
				$employees->RowType = ROWTYPE_EDIT; // Render edit
			if (!$employees->EventCancelled)
				$employees_list->HashValue = $employees_list->getRowHash($employees_list->Recordset); // Get hash value for record
		}
		if ($employees_list->isGridEdit() && ($employees->RowType == ROWTYPE_EDIT || $employees->RowType == ROWTYPE_ADD) && $employees->EventCancelled) // Update failed
			$employees_list->restoreCurrentRowFormValues($employees_list->RowIndex); // Restore form values
		if ($employees->RowType == ROWTYPE_EDIT) // Edit row
			$employees_list->EditRowCount++;

		// Set up row id / data-rowindex
		$employees->RowAttrs->merge(["data-rowindex" => $employees_list->RowCount, "id" => "r" . $employees_list->RowCount . "_employees", "data-rowtype" => $employees->RowType]);

		// Render row
		$employees_list->renderRow();

		// Render list options
		$employees_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($employees_list->RowAction != "delete" && $employees_list->RowAction != "insertdelete" && !($employees_list->RowAction == "insert" && $employees->isConfirm() && $employees_list->emptyRow())) {
?>
	<tr <?php echo $employees->rowAttributes() ?>>
<?php

// Render list options (body, left)
$employees_list->ListOptions->render("body", "left", $employees_list->RowCount);
?>
	<?php if ($employees_list->idEmployee->Visible) { // idEmployee ?>
		<td data-name="idEmployee" <?php echo $employees_list->idEmployee->cellAttributes() ?>>
<?php if ($employees->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el<?php echo $employees_list->RowCount ?>_employees_idEmployee" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="employees" data-field="x_idEmployee" data-value-separator="<?php echo $employees_list->idEmployee->displayValueSeparatorAttribute() ?>" id="x<?php echo $employees_list->RowIndex ?>_idEmployee" name="x<?php echo $employees_list->RowIndex ?>_idEmployee"<?php echo $employees_list->idEmployee->editAttributes() ?>>
			<?php echo $employees_list->idEmployee->selectOptionListHtml("x{$employees_list->RowIndex}_idEmployee") ?>
		</select>
</div>
</span>
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$employees->userIDAllow($employees->CurrentAction)) { // Non system admin ?>
<span id="el<?php echo $employees_list->RowCount ?>_employees_idEmployee" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="employees" data-field="x_idEmployee" data-value-separator="<?php echo $employees_list->idEmployee->displayValueSeparatorAttribute() ?>" id="x<?php echo $employees_list->RowIndex ?>_idEmployee" name="x<?php echo $employees_list->RowIndex ?>_idEmployee"<?php echo $employees_list->idEmployee->editAttributes() ?>>
			<?php echo $employees_list->idEmployee->selectOptionListHtml("x{$employees_list->RowIndex}_idEmployee") ?>
		</select>
</div>
</span>
<?php } else { ?>
<span id="el<?php echo $employees_list->RowCount ?>_employees_idEmployee" class="form-group">
<input type="text" data-table="employees" data-field="x_idEmployee" name="x<?php echo $employees_list->RowIndex ?>_idEmployee" id="x<?php echo $employees_list->RowIndex ?>_idEmployee" size="30" maxlength="30" placeholder="<?php echo HtmlEncode($employees_list->idEmployee->getPlaceHolder()) ?>" value="<?php echo $employees_list->idEmployee->EditValue ?>"<?php echo $employees_list->idEmployee->editAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="employees" data-field="x_idEmployee" name="o<?php echo $employees_list->RowIndex ?>_idEmployee" id="o<?php echo $employees_list->RowIndex ?>_idEmployee" value="<?php echo HtmlEncode($employees_list->idEmployee->OldValue) ?>">
<?php } ?>
<?php if ($employees->RowType == ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-table="employees" data-field="x_idEmployee" name="x<?php echo $employees_list->RowIndex ?>_idEmployee" id="x<?php echo $employees_list->RowIndex ?>_idEmployee" size="30" maxlength="30" placeholder="<?php echo HtmlEncode($employees_list->idEmployee->getPlaceHolder()) ?>" value="<?php echo $employees_list->idEmployee->EditValue ?>"<?php echo $employees_list->idEmployee->editAttributes() ?>>
<input type="hidden" data-table="employees" data-field="x_idEmployee" name="o<?php echo $employees_list->RowIndex ?>_idEmployee" id="o<?php echo $employees_list->RowIndex ?>_idEmployee" value="<?php echo HtmlEncode($employees_list->idEmployee->OldValue != null ? $employees_list->idEmployee->OldValue : $employees_list->idEmployee->CurrentValue) ?>">
<?php } ?>
<?php if ($employees->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $employees_list->RowCount ?>_employees_idEmployee">
<span<?php echo $employees_list->idEmployee->viewAttributes() ?>><?php echo $employees_list->idEmployee->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($employees_list->name->Visible) { // name ?>
		<td data-name="name" <?php echo $employees_list->name->cellAttributes() ?>>
<?php if ($employees->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $employees_list->RowCount ?>_employees_name" class="form-group">
<input type="text" data-table="employees" data-field="x_name" name="x<?php echo $employees_list->RowIndex ?>_name" id="x<?php echo $employees_list->RowIndex ?>_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($employees_list->name->getPlaceHolder()) ?>" value="<?php echo $employees_list->name->EditValue ?>"<?php echo $employees_list->name->editAttributes() ?>>
</span>
<input type="hidden" data-table="employees" data-field="x_name" name="o<?php echo $employees_list->RowIndex ?>_name" id="o<?php echo $employees_list->RowIndex ?>_name" value="<?php echo HtmlEncode($employees_list->name->OldValue) ?>">
<?php } ?>
<?php if ($employees->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $employees_list->RowCount ?>_employees_name" class="form-group">
<input type="text" data-table="employees" data-field="x_name" name="x<?php echo $employees_list->RowIndex ?>_name" id="x<?php echo $employees_list->RowIndex ?>_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($employees_list->name->getPlaceHolder()) ?>" value="<?php echo $employees_list->name->EditValue ?>"<?php echo $employees_list->name->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($employees->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $employees_list->RowCount ?>_employees_name">
<span<?php echo $employees_list->name->viewAttributes() ?>><?php echo $employees_list->name->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($employees_list->surname->Visible) { // surname ?>
		<td data-name="surname" <?php echo $employees_list->surname->cellAttributes() ?>>
<?php if ($employees->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $employees_list->RowCount ?>_employees_surname" class="form-group">
<input type="text" data-table="employees" data-field="x_surname" name="x<?php echo $employees_list->RowIndex ?>_surname" id="x<?php echo $employees_list->RowIndex ?>_surname" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($employees_list->surname->getPlaceHolder()) ?>" value="<?php echo $employees_list->surname->EditValue ?>"<?php echo $employees_list->surname->editAttributes() ?>>
</span>
<input type="hidden" data-table="employees" data-field="x_surname" name="o<?php echo $employees_list->RowIndex ?>_surname" id="o<?php echo $employees_list->RowIndex ?>_surname" value="<?php echo HtmlEncode($employees_list->surname->OldValue) ?>">
<?php } ?>
<?php if ($employees->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $employees_list->RowCount ?>_employees_surname" class="form-group">
<input type="text" data-table="employees" data-field="x_surname" name="x<?php echo $employees_list->RowIndex ?>_surname" id="x<?php echo $employees_list->RowIndex ?>_surname" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($employees_list->surname->getPlaceHolder()) ?>" value="<?php echo $employees_list->surname->EditValue ?>"<?php echo $employees_list->surname->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($employees->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $employees_list->RowCount ?>_employees_surname">
<span<?php echo $employees_list->surname->viewAttributes() ?>><?php echo $employees_list->surname->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($employees_list->idFactory->Visible) { // idFactory ?>
		<td data-name="idFactory" <?php echo $employees_list->idFactory->cellAttributes() ?>>
<?php if ($employees->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $employees_list->RowCount ?>_employees_idFactory" class="form-group">
<?php
$onchange = $employees_list->idFactory->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$employees_list->idFactory->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $employees_list->RowIndex ?>_idFactory">
	<input type="text" class="form-control" name="sv_x<?php echo $employees_list->RowIndex ?>_idFactory" id="sv_x<?php echo $employees_list->RowIndex ?>_idFactory" value="<?php echo RemoveHtml($employees_list->idFactory->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($employees_list->idFactory->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($employees_list->idFactory->getPlaceHolder()) ?>"<?php echo $employees_list->idFactory->editAttributes() ?>>
</span>
<input type="hidden" data-table="employees" data-field="x_idFactory" data-value-separator="<?php echo $employees_list->idFactory->displayValueSeparatorAttribute() ?>" name="x<?php echo $employees_list->RowIndex ?>_idFactory" id="x<?php echo $employees_list->RowIndex ?>_idFactory" value="<?php echo HtmlEncode($employees_list->idFactory->CurrentValue) ?>"<?php echo $onchange ?>>
<script>
loadjs.ready(["femployeeslist"], function() {
	femployeeslist.createAutoSuggest({"id":"x<?php echo $employees_list->RowIndex ?>_idFactory","forceSelect":false});
});
</script>
<?php echo $employees_list->idFactory->Lookup->getParamTag($employees_list, "p_x" . $employees_list->RowIndex . "_idFactory") ?>
</span>
<input type="hidden" data-table="employees" data-field="x_idFactory" name="o<?php echo $employees_list->RowIndex ?>_idFactory" id="o<?php echo $employees_list->RowIndex ?>_idFactory" value="<?php echo HtmlEncode($employees_list->idFactory->OldValue) ?>">
<?php } ?>
<?php if ($employees->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $employees_list->RowCount ?>_employees_idFactory" class="form-group">
<?php
$onchange = $employees_list->idFactory->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$employees_list->idFactory->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $employees_list->RowIndex ?>_idFactory">
	<input type="text" class="form-control" name="sv_x<?php echo $employees_list->RowIndex ?>_idFactory" id="sv_x<?php echo $employees_list->RowIndex ?>_idFactory" value="<?php echo RemoveHtml($employees_list->idFactory->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($employees_list->idFactory->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($employees_list->idFactory->getPlaceHolder()) ?>"<?php echo $employees_list->idFactory->editAttributes() ?>>
</span>
<input type="hidden" data-table="employees" data-field="x_idFactory" data-value-separator="<?php echo $employees_list->idFactory->displayValueSeparatorAttribute() ?>" name="x<?php echo $employees_list->RowIndex ?>_idFactory" id="x<?php echo $employees_list->RowIndex ?>_idFactory" value="<?php echo HtmlEncode($employees_list->idFactory->CurrentValue) ?>"<?php echo $onchange ?>>
<script>
loadjs.ready(["femployeeslist"], function() {
	femployeeslist.createAutoSuggest({"id":"x<?php echo $employees_list->RowIndex ?>_idFactory","forceSelect":false});
});
</script>
<?php echo $employees_list->idFactory->Lookup->getParamTag($employees_list, "p_x" . $employees_list->RowIndex . "_idFactory") ?>
</span>
<?php } ?>
<?php if ($employees->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $employees_list->RowCount ?>_employees_idFactory">
<span<?php echo $employees_list->idFactory->viewAttributes() ?>><?php echo $employees_list->idFactory->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($employees_list->userlevel->Visible) { // userlevel ?>
		<td data-name="userlevel" <?php echo $employees_list->userlevel->cellAttributes() ?>>
<?php if ($employees->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el<?php echo $employees_list->RowCount ?>_employees_userlevel" class="form-group">
<input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($employees_list->userlevel->EditValue)) ?>">
</span>
<?php } else { ?>
<span id="el<?php echo $employees_list->RowCount ?>_employees_userlevel" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="employees" data-field="x_userlevel" data-value-separator="<?php echo $employees_list->userlevel->displayValueSeparatorAttribute() ?>" id="x<?php echo $employees_list->RowIndex ?>_userlevel" name="x<?php echo $employees_list->RowIndex ?>_userlevel"<?php echo $employees_list->userlevel->editAttributes() ?>>
			<?php echo $employees_list->userlevel->selectOptionListHtml("x{$employees_list->RowIndex}_userlevel") ?>
		</select>
</div>
</span>
<?php } ?>
<input type="hidden" data-table="employees" data-field="x_userlevel" name="o<?php echo $employees_list->RowIndex ?>_userlevel" id="o<?php echo $employees_list->RowIndex ?>_userlevel" value="<?php echo HtmlEncode($employees_list->userlevel->OldValue) ?>">
<?php } ?>
<?php if ($employees->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el<?php echo $employees_list->RowCount ?>_employees_userlevel" class="form-group">
<input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($employees_list->userlevel->EditValue)) ?>">
</span>
<?php } else { ?>
<span id="el<?php echo $employees_list->RowCount ?>_employees_userlevel" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="employees" data-field="x_userlevel" data-value-separator="<?php echo $employees_list->userlevel->displayValueSeparatorAttribute() ?>" id="x<?php echo $employees_list->RowIndex ?>_userlevel" name="x<?php echo $employees_list->RowIndex ?>_userlevel"<?php echo $employees_list->userlevel->editAttributes() ?>>
			<?php echo $employees_list->userlevel->selectOptionListHtml("x{$employees_list->RowIndex}_userlevel") ?>
		</select>
</div>
</span>
<?php } ?>
<?php } ?>
<?php if ($employees->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $employees_list->RowCount ?>_employees_userlevel">
<span<?php echo $employees_list->userlevel->viewAttributes() ?>><?php echo $employees_list->userlevel->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($employees_list->password->Visible) { // password ?>
		<td data-name="password" <?php echo $employees_list->password->cellAttributes() ?>>
<?php if ($employees->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $employees_list->RowCount ?>_employees_password" class="form-group">
<input type="text" data-table="employees" data-field="x_password" name="x<?php echo $employees_list->RowIndex ?>_password" id="x<?php echo $employees_list->RowIndex ?>_password" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($employees_list->password->getPlaceHolder()) ?>" value="<?php echo $employees_list->password->EditValue ?>"<?php echo $employees_list->password->editAttributes() ?>>
</span>
<input type="hidden" data-table="employees" data-field="x_password" name="o<?php echo $employees_list->RowIndex ?>_password" id="o<?php echo $employees_list->RowIndex ?>_password" value="<?php echo HtmlEncode($employees_list->password->OldValue) ?>">
<?php } ?>
<?php if ($employees->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $employees_list->RowCount ?>_employees_password" class="form-group">
<input type="text" data-table="employees" data-field="x_password" name="x<?php echo $employees_list->RowIndex ?>_password" id="x<?php echo $employees_list->RowIndex ?>_password" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($employees_list->password->getPlaceHolder()) ?>" value="<?php echo $employees_list->password->EditValue ?>"<?php echo $employees_list->password->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($employees->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $employees_list->RowCount ?>_employees_password">
<span<?php echo $employees_list->password->viewAttributes() ?>><?php echo $employees_list->password->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($employees_list->workcenter->Visible) { // workcenter ?>
		<td data-name="workcenter" <?php echo $employees_list->workcenter->cellAttributes() ?>>
<?php if ($employees->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $employees_list->RowCount ?>_employees_workcenter" class="form-group">
<?php
$onchange = $employees_list->workcenter->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$employees_list->workcenter->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $employees_list->RowIndex ?>_workcenter">
	<input type="text" class="form-control" name="sv_x<?php echo $employees_list->RowIndex ?>_workcenter" id="sv_x<?php echo $employees_list->RowIndex ?>_workcenter" value="<?php echo RemoveHtml($employees_list->workcenter->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($employees_list->workcenter->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($employees_list->workcenter->getPlaceHolder()) ?>"<?php echo $employees_list->workcenter->editAttributes() ?>>
</span>
<input type="hidden" data-table="employees" data-field="x_workcenter" data-value-separator="<?php echo $employees_list->workcenter->displayValueSeparatorAttribute() ?>" name="x<?php echo $employees_list->RowIndex ?>_workcenter" id="x<?php echo $employees_list->RowIndex ?>_workcenter" value="<?php echo HtmlEncode($employees_list->workcenter->CurrentValue) ?>"<?php echo $onchange ?>>
<script>
loadjs.ready(["femployeeslist"], function() {
	femployeeslist.createAutoSuggest({"id":"x<?php echo $employees_list->RowIndex ?>_workcenter","forceSelect":false});
});
</script>
<?php echo $employees_list->workcenter->Lookup->getParamTag($employees_list, "p_x" . $employees_list->RowIndex . "_workcenter") ?>
</span>
<input type="hidden" data-table="employees" data-field="x_workcenter" name="o<?php echo $employees_list->RowIndex ?>_workcenter" id="o<?php echo $employees_list->RowIndex ?>_workcenter" value="<?php echo HtmlEncode($employees_list->workcenter->OldValue) ?>">
<?php } ?>
<?php if ($employees->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $employees_list->RowCount ?>_employees_workcenter" class="form-group">
<?php
$onchange = $employees_list->workcenter->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$employees_list->workcenter->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $employees_list->RowIndex ?>_workcenter">
	<input type="text" class="form-control" name="sv_x<?php echo $employees_list->RowIndex ?>_workcenter" id="sv_x<?php echo $employees_list->RowIndex ?>_workcenter" value="<?php echo RemoveHtml($employees_list->workcenter->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($employees_list->workcenter->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($employees_list->workcenter->getPlaceHolder()) ?>"<?php echo $employees_list->workcenter->editAttributes() ?>>
</span>
<input type="hidden" data-table="employees" data-field="x_workcenter" data-value-separator="<?php echo $employees_list->workcenter->displayValueSeparatorAttribute() ?>" name="x<?php echo $employees_list->RowIndex ?>_workcenter" id="x<?php echo $employees_list->RowIndex ?>_workcenter" value="<?php echo HtmlEncode($employees_list->workcenter->CurrentValue) ?>"<?php echo $onchange ?>>
<script>
loadjs.ready(["femployeeslist"], function() {
	femployeeslist.createAutoSuggest({"id":"x<?php echo $employees_list->RowIndex ?>_workcenter","forceSelect":false});
});
</script>
<?php echo $employees_list->workcenter->Lookup->getParamTag($employees_list, "p_x" . $employees_list->RowIndex . "_workcenter") ?>
</span>
<?php } ?>
<?php if ($employees->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $employees_list->RowCount ?>_employees_workcenter">
<span<?php echo $employees_list->workcenter->viewAttributes() ?>><?php echo $employees_list->workcenter->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$employees_list->ListOptions->render("body", "right", $employees_list->RowCount);
?>
	</tr>
<?php if ($employees->RowType == ROWTYPE_ADD || $employees->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["femployeeslist", "load"], function() {
	femployeeslist.updateLists(<?php echo $employees_list->RowIndex ?>);
});
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$employees_list->isGridAdd())
		if (!$employees_list->Recordset->EOF)
			$employees_list->Recordset->moveNext();
}
?>
<?php
	if ($employees_list->isGridAdd() || $employees_list->isGridEdit()) {
		$employees_list->RowIndex = '$rowindex$';
		$employees_list->loadRowValues();

		// Set row properties
		$employees->resetAttributes();
		$employees->RowAttrs->merge(["data-rowindex" => $employees_list->RowIndex, "id" => "r0_employees", "data-rowtype" => ROWTYPE_ADD]);
		$employees->RowAttrs->appendClass("ew-template");
		$employees->RowType = ROWTYPE_ADD;

		// Render row
		$employees_list->renderRow();

		// Render list options
		$employees_list->renderListOptions();
		$employees_list->StartRowCount = 0;
?>
	<tr <?php echo $employees->rowAttributes() ?>>
<?php

// Render list options (body, left)
$employees_list->ListOptions->render("body", "left", $employees_list->RowIndex);
?>
	<?php if ($employees_list->idEmployee->Visible) { // idEmployee ?>
		<td data-name="idEmployee">
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el$rowindex$_employees_idEmployee" class="form-group employees_idEmployee">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="employees" data-field="x_idEmployee" data-value-separator="<?php echo $employees_list->idEmployee->displayValueSeparatorAttribute() ?>" id="x<?php echo $employees_list->RowIndex ?>_idEmployee" name="x<?php echo $employees_list->RowIndex ?>_idEmployee"<?php echo $employees_list->idEmployee->editAttributes() ?>>
			<?php echo $employees_list->idEmployee->selectOptionListHtml("x{$employees_list->RowIndex}_idEmployee") ?>
		</select>
</div>
</span>
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$employees->userIDAllow($employees->CurrentAction)) { // Non system admin ?>
<span id="el$rowindex$_employees_idEmployee" class="form-group employees_idEmployee">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="employees" data-field="x_idEmployee" data-value-separator="<?php echo $employees_list->idEmployee->displayValueSeparatorAttribute() ?>" id="x<?php echo $employees_list->RowIndex ?>_idEmployee" name="x<?php echo $employees_list->RowIndex ?>_idEmployee"<?php echo $employees_list->idEmployee->editAttributes() ?>>
			<?php echo $employees_list->idEmployee->selectOptionListHtml("x{$employees_list->RowIndex}_idEmployee") ?>
		</select>
</div>
</span>
<?php } else { ?>
<span id="el$rowindex$_employees_idEmployee" class="form-group employees_idEmployee">
<input type="text" data-table="employees" data-field="x_idEmployee" name="x<?php echo $employees_list->RowIndex ?>_idEmployee" id="x<?php echo $employees_list->RowIndex ?>_idEmployee" size="30" maxlength="30" placeholder="<?php echo HtmlEncode($employees_list->idEmployee->getPlaceHolder()) ?>" value="<?php echo $employees_list->idEmployee->EditValue ?>"<?php echo $employees_list->idEmployee->editAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="employees" data-field="x_idEmployee" name="o<?php echo $employees_list->RowIndex ?>_idEmployee" id="o<?php echo $employees_list->RowIndex ?>_idEmployee" value="<?php echo HtmlEncode($employees_list->idEmployee->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($employees_list->name->Visible) { // name ?>
		<td data-name="name">
<span id="el$rowindex$_employees_name" class="form-group employees_name">
<input type="text" data-table="employees" data-field="x_name" name="x<?php echo $employees_list->RowIndex ?>_name" id="x<?php echo $employees_list->RowIndex ?>_name" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($employees_list->name->getPlaceHolder()) ?>" value="<?php echo $employees_list->name->EditValue ?>"<?php echo $employees_list->name->editAttributes() ?>>
</span>
<input type="hidden" data-table="employees" data-field="x_name" name="o<?php echo $employees_list->RowIndex ?>_name" id="o<?php echo $employees_list->RowIndex ?>_name" value="<?php echo HtmlEncode($employees_list->name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($employees_list->surname->Visible) { // surname ?>
		<td data-name="surname">
<span id="el$rowindex$_employees_surname" class="form-group employees_surname">
<input type="text" data-table="employees" data-field="x_surname" name="x<?php echo $employees_list->RowIndex ?>_surname" id="x<?php echo $employees_list->RowIndex ?>_surname" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($employees_list->surname->getPlaceHolder()) ?>" value="<?php echo $employees_list->surname->EditValue ?>"<?php echo $employees_list->surname->editAttributes() ?>>
</span>
<input type="hidden" data-table="employees" data-field="x_surname" name="o<?php echo $employees_list->RowIndex ?>_surname" id="o<?php echo $employees_list->RowIndex ?>_surname" value="<?php echo HtmlEncode($employees_list->surname->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($employees_list->idFactory->Visible) { // idFactory ?>
		<td data-name="idFactory">
<span id="el$rowindex$_employees_idFactory" class="form-group employees_idFactory">
<?php
$onchange = $employees_list->idFactory->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$employees_list->idFactory->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $employees_list->RowIndex ?>_idFactory">
	<input type="text" class="form-control" name="sv_x<?php echo $employees_list->RowIndex ?>_idFactory" id="sv_x<?php echo $employees_list->RowIndex ?>_idFactory" value="<?php echo RemoveHtml($employees_list->idFactory->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($employees_list->idFactory->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($employees_list->idFactory->getPlaceHolder()) ?>"<?php echo $employees_list->idFactory->editAttributes() ?>>
</span>
<input type="hidden" data-table="employees" data-field="x_idFactory" data-value-separator="<?php echo $employees_list->idFactory->displayValueSeparatorAttribute() ?>" name="x<?php echo $employees_list->RowIndex ?>_idFactory" id="x<?php echo $employees_list->RowIndex ?>_idFactory" value="<?php echo HtmlEncode($employees_list->idFactory->CurrentValue) ?>"<?php echo $onchange ?>>
<script>
loadjs.ready(["femployeeslist"], function() {
	femployeeslist.createAutoSuggest({"id":"x<?php echo $employees_list->RowIndex ?>_idFactory","forceSelect":false});
});
</script>
<?php echo $employees_list->idFactory->Lookup->getParamTag($employees_list, "p_x" . $employees_list->RowIndex . "_idFactory") ?>
</span>
<input type="hidden" data-table="employees" data-field="x_idFactory" name="o<?php echo $employees_list->RowIndex ?>_idFactory" id="o<?php echo $employees_list->RowIndex ?>_idFactory" value="<?php echo HtmlEncode($employees_list->idFactory->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($employees_list->userlevel->Visible) { // userlevel ?>
		<td data-name="userlevel">
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el$rowindex$_employees_userlevel" class="form-group employees_userlevel">
<input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($employees_list->userlevel->EditValue)) ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_employees_userlevel" class="form-group employees_userlevel">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="employees" data-field="x_userlevel" data-value-separator="<?php echo $employees_list->userlevel->displayValueSeparatorAttribute() ?>" id="x<?php echo $employees_list->RowIndex ?>_userlevel" name="x<?php echo $employees_list->RowIndex ?>_userlevel"<?php echo $employees_list->userlevel->editAttributes() ?>>
			<?php echo $employees_list->userlevel->selectOptionListHtml("x{$employees_list->RowIndex}_userlevel") ?>
		</select>
</div>
</span>
<?php } ?>
<input type="hidden" data-table="employees" data-field="x_userlevel" name="o<?php echo $employees_list->RowIndex ?>_userlevel" id="o<?php echo $employees_list->RowIndex ?>_userlevel" value="<?php echo HtmlEncode($employees_list->userlevel->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($employees_list->password->Visible) { // password ?>
		<td data-name="password">
<span id="el$rowindex$_employees_password" class="form-group employees_password">
<input type="text" data-table="employees" data-field="x_password" name="x<?php echo $employees_list->RowIndex ?>_password" id="x<?php echo $employees_list->RowIndex ?>_password" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($employees_list->password->getPlaceHolder()) ?>" value="<?php echo $employees_list->password->EditValue ?>"<?php echo $employees_list->password->editAttributes() ?>>
</span>
<input type="hidden" data-table="employees" data-field="x_password" name="o<?php echo $employees_list->RowIndex ?>_password" id="o<?php echo $employees_list->RowIndex ?>_password" value="<?php echo HtmlEncode($employees_list->password->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($employees_list->workcenter->Visible) { // workcenter ?>
		<td data-name="workcenter">
<span id="el$rowindex$_employees_workcenter" class="form-group employees_workcenter">
<?php
$onchange = $employees_list->workcenter->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$employees_list->workcenter->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $employees_list->RowIndex ?>_workcenter">
	<input type="text" class="form-control" name="sv_x<?php echo $employees_list->RowIndex ?>_workcenter" id="sv_x<?php echo $employees_list->RowIndex ?>_workcenter" value="<?php echo RemoveHtml($employees_list->workcenter->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($employees_list->workcenter->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($employees_list->workcenter->getPlaceHolder()) ?>"<?php echo $employees_list->workcenter->editAttributes() ?>>
</span>
<input type="hidden" data-table="employees" data-field="x_workcenter" data-value-separator="<?php echo $employees_list->workcenter->displayValueSeparatorAttribute() ?>" name="x<?php echo $employees_list->RowIndex ?>_workcenter" id="x<?php echo $employees_list->RowIndex ?>_workcenter" value="<?php echo HtmlEncode($employees_list->workcenter->CurrentValue) ?>"<?php echo $onchange ?>>
<script>
loadjs.ready(["femployeeslist"], function() {
	femployeeslist.createAutoSuggest({"id":"x<?php echo $employees_list->RowIndex ?>_workcenter","forceSelect":false});
});
</script>
<?php echo $employees_list->workcenter->Lookup->getParamTag($employees_list, "p_x" . $employees_list->RowIndex . "_workcenter") ?>
</span>
<input type="hidden" data-table="employees" data-field="x_workcenter" name="o<?php echo $employees_list->RowIndex ?>_workcenter" id="o<?php echo $employees_list->RowIndex ?>_workcenter" value="<?php echo HtmlEncode($employees_list->workcenter->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$employees_list->ListOptions->render("body", "right", $employees_list->RowIndex);
?>
<script>
loadjs.ready(["femployeeslist", "load"], function() {
	femployeeslist.updateLists(<?php echo $employees_list->RowIndex ?>);
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
<?php if ($employees_list->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?php echo $employees_list->FormKeyCountName ?>" id="<?php echo $employees_list->FormKeyCountName ?>" value="<?php echo $employees_list->KeyCount ?>">
<?php echo $employees_list->MultiSelectKey ?>
<?php } ?>
<?php if ($employees_list->isGridEdit()) { ?>
<?php if ($employees->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="action" id="action" value="gridoverwrite">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<?php } ?>
<input type="hidden" name="<?php echo $employees_list->FormKeyCountName ?>" id="<?php echo $employees_list->FormKeyCountName ?>" value="<?php echo $employees_list->KeyCount ?>">
<?php echo $employees_list->MultiSelectKey ?>
<?php } ?>
<?php if (!$employees->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($employees_list->Recordset)
	$employees_list->Recordset->Close();
?>
<?php if (!$employees_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$employees_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $employees_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $employees_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($employees_list->TotalRecords == 0 && !$employees->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $employees_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$employees_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$employees_list->isExport()) { ?>
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
$employees_list->terminate();
?>