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
$userlevelpermissions_list = new userlevelpermissions_list();

// Run the page
$userlevelpermissions_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$userlevelpermissions_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$userlevelpermissions_list->isExport()) { ?>
<script>
var fuserlevelpermissionslist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	fuserlevelpermissionslist = currentForm = new ew.Form("fuserlevelpermissionslist", "list");
	fuserlevelpermissionslist.formKeyCountName = '<?php echo $userlevelpermissions_list->FormKeyCountName ?>';

	// Validate form
	fuserlevelpermissionslist.validate = function() {
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
			<?php if ($userlevelpermissions_list->userlevelid->Required) { ?>
				elm = this.getElements("x" + infix + "_userlevelid");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userlevelpermissions_list->userlevelid->caption(), $userlevelpermissions_list->userlevelid->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_userlevelid");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($userlevelpermissions_list->userlevelid->errorMessage()) ?>");
			<?php if ($userlevelpermissions_list->_tablename->Required) { ?>
				elm = this.getElements("x" + infix + "__tablename");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userlevelpermissions_list->_tablename->caption(), $userlevelpermissions_list->_tablename->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($userlevelpermissions_list->permission->Required) { ?>
				elm = this.getElements("x" + infix + "_permission");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $userlevelpermissions_list->permission->caption(), $userlevelpermissions_list->permission->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_permission");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($userlevelpermissions_list->permission->errorMessage()) ?>");

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
		}
		return true;
	}

	// Form_CustomValidate
	fuserlevelpermissionslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fuserlevelpermissionslist.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fuserlevelpermissionslist");
});
var fuserlevelpermissionslistsrch;
loadjs.ready("head", function() {

	// Form object for search
	fuserlevelpermissionslistsrch = currentSearchForm = new ew.Form("fuserlevelpermissionslistsrch");

	// Dynamic selection lists
	// Filters

	fuserlevelpermissionslistsrch.filterList = <?php echo $userlevelpermissions_list->getFilterList() ?>;
	loadjs.done("fuserlevelpermissionslistsrch");
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
<?php if (!$userlevelpermissions_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($userlevelpermissions_list->TotalRecords > 0 && $userlevelpermissions_list->ExportOptions->visible()) { ?>
<?php $userlevelpermissions_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($userlevelpermissions_list->ImportOptions->visible()) { ?>
<?php $userlevelpermissions_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($userlevelpermissions_list->SearchOptions->visible()) { ?>
<?php $userlevelpermissions_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($userlevelpermissions_list->FilterOptions->visible()) { ?>
<?php $userlevelpermissions_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$userlevelpermissions_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$userlevelpermissions_list->isExport() && !$userlevelpermissions->CurrentAction) { ?>
<form name="fuserlevelpermissionslistsrch" id="fuserlevelpermissionslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="fuserlevelpermissionslistsrch-search-panel" class="<?php echo $userlevelpermissions_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="userlevelpermissions">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $userlevelpermissions_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($userlevelpermissions_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($userlevelpermissions_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $userlevelpermissions_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($userlevelpermissions_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($userlevelpermissions_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($userlevelpermissions_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($userlevelpermissions_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $userlevelpermissions_list->showPageHeader(); ?>
<?php
$userlevelpermissions_list->showMessage();
?>
<?php if ($userlevelpermissions_list->TotalRecords > 0 || $userlevelpermissions->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($userlevelpermissions_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> userlevelpermissions">
<?php if (!$userlevelpermissions_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$userlevelpermissions_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $userlevelpermissions_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $userlevelpermissions_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fuserlevelpermissionslist" id="fuserlevelpermissionslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="userlevelpermissions">
<div id="gmp_userlevelpermissions" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($userlevelpermissions_list->TotalRecords > 0 || $userlevelpermissions_list->isGridEdit()) { ?>
<table id="tbl_userlevelpermissionslist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$userlevelpermissions->RowType = ROWTYPE_HEADER;

// Render list options
$userlevelpermissions_list->renderListOptions();

// Render list options (header, left)
$userlevelpermissions_list->ListOptions->render("header", "left");
?>
<?php if ($userlevelpermissions_list->userlevelid->Visible) { // userlevelid ?>
	<?php if ($userlevelpermissions_list->SortUrl($userlevelpermissions_list->userlevelid) == "") { ?>
		<th data-name="userlevelid" class="<?php echo $userlevelpermissions_list->userlevelid->headerCellClass() ?>"><div id="elh_userlevelpermissions_userlevelid" class="userlevelpermissions_userlevelid"><div class="ew-table-header-caption"><?php echo $userlevelpermissions_list->userlevelid->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="userlevelid" class="<?php echo $userlevelpermissions_list->userlevelid->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $userlevelpermissions_list->SortUrl($userlevelpermissions_list->userlevelid) ?>', 2);"><div id="elh_userlevelpermissions_userlevelid" class="userlevelpermissions_userlevelid">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $userlevelpermissions_list->userlevelid->caption() ?></span><span class="ew-table-header-sort"><?php if ($userlevelpermissions_list->userlevelid->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($userlevelpermissions_list->userlevelid->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($userlevelpermissions_list->_tablename->Visible) { // tablename ?>
	<?php if ($userlevelpermissions_list->SortUrl($userlevelpermissions_list->_tablename) == "") { ?>
		<th data-name="_tablename" class="<?php echo $userlevelpermissions_list->_tablename->headerCellClass() ?>"><div id="elh_userlevelpermissions__tablename" class="userlevelpermissions__tablename"><div class="ew-table-header-caption"><?php echo $userlevelpermissions_list->_tablename->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="_tablename" class="<?php echo $userlevelpermissions_list->_tablename->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $userlevelpermissions_list->SortUrl($userlevelpermissions_list->_tablename) ?>', 2);"><div id="elh_userlevelpermissions__tablename" class="userlevelpermissions__tablename">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $userlevelpermissions_list->_tablename->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($userlevelpermissions_list->_tablename->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($userlevelpermissions_list->_tablename->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($userlevelpermissions_list->permission->Visible) { // permission ?>
	<?php if ($userlevelpermissions_list->SortUrl($userlevelpermissions_list->permission) == "") { ?>
		<th data-name="permission" class="<?php echo $userlevelpermissions_list->permission->headerCellClass() ?>"><div id="elh_userlevelpermissions_permission" class="userlevelpermissions_permission"><div class="ew-table-header-caption"><?php echo $userlevelpermissions_list->permission->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="permission" class="<?php echo $userlevelpermissions_list->permission->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $userlevelpermissions_list->SortUrl($userlevelpermissions_list->permission) ?>', 2);"><div id="elh_userlevelpermissions_permission" class="userlevelpermissions_permission">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $userlevelpermissions_list->permission->caption() ?></span><span class="ew-table-header-sort"><?php if ($userlevelpermissions_list->permission->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($userlevelpermissions_list->permission->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$userlevelpermissions_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($userlevelpermissions_list->ExportAll && $userlevelpermissions_list->isExport()) {
	$userlevelpermissions_list->StopRecord = $userlevelpermissions_list->TotalRecords;
} else {

	// Set the last record to display
	if ($userlevelpermissions_list->TotalRecords > $userlevelpermissions_list->StartRecord + $userlevelpermissions_list->DisplayRecords - 1)
		$userlevelpermissions_list->StopRecord = $userlevelpermissions_list->StartRecord + $userlevelpermissions_list->DisplayRecords - 1;
	else
		$userlevelpermissions_list->StopRecord = $userlevelpermissions_list->TotalRecords;
}

// Restore number of post back records
if ($CurrentForm && ($userlevelpermissions->isConfirm() || $userlevelpermissions_list->EventCancelled)) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($userlevelpermissions_list->FormKeyCountName) && ($userlevelpermissions_list->isGridAdd() || $userlevelpermissions_list->isGridEdit() || $userlevelpermissions->isConfirm())) {
		$userlevelpermissions_list->KeyCount = $CurrentForm->getValue($userlevelpermissions_list->FormKeyCountName);
		$userlevelpermissions_list->StopRecord = $userlevelpermissions_list->StartRecord + $userlevelpermissions_list->KeyCount - 1;
	}
}
$userlevelpermissions_list->RecordCount = $userlevelpermissions_list->StartRecord - 1;
if ($userlevelpermissions_list->Recordset && !$userlevelpermissions_list->Recordset->EOF) {
	$userlevelpermissions_list->Recordset->moveFirst();
	$selectLimit = $userlevelpermissions_list->UseSelectLimit;
	if (!$selectLimit && $userlevelpermissions_list->StartRecord > 1)
		$userlevelpermissions_list->Recordset->move($userlevelpermissions_list->StartRecord - 1);
} elseif (!$userlevelpermissions->AllowAddDeleteRow && $userlevelpermissions_list->StopRecord == 0) {
	$userlevelpermissions_list->StopRecord = $userlevelpermissions->GridAddRowCount;
}

// Initialize aggregate
$userlevelpermissions->RowType = ROWTYPE_AGGREGATEINIT;
$userlevelpermissions->resetAttributes();
$userlevelpermissions_list->renderRow();
if ($userlevelpermissions_list->isGridEdit())
	$userlevelpermissions_list->RowIndex = 0;
while ($userlevelpermissions_list->RecordCount < $userlevelpermissions_list->StopRecord) {
	$userlevelpermissions_list->RecordCount++;
	if ($userlevelpermissions_list->RecordCount >= $userlevelpermissions_list->StartRecord) {
		$userlevelpermissions_list->RowCount++;
		if ($userlevelpermissions_list->isGridAdd() || $userlevelpermissions_list->isGridEdit() || $userlevelpermissions->isConfirm()) {
			$userlevelpermissions_list->RowIndex++;
			$CurrentForm->Index = $userlevelpermissions_list->RowIndex;
			if ($CurrentForm->hasValue($userlevelpermissions_list->FormActionName) && ($userlevelpermissions->isConfirm() || $userlevelpermissions_list->EventCancelled))
				$userlevelpermissions_list->RowAction = strval($CurrentForm->getValue($userlevelpermissions_list->FormActionName));
			elseif ($userlevelpermissions_list->isGridAdd())
				$userlevelpermissions_list->RowAction = "insert";
			else
				$userlevelpermissions_list->RowAction = "";
		}

		// Set up key count
		$userlevelpermissions_list->KeyCount = $userlevelpermissions_list->RowIndex;

		// Init row class and style
		$userlevelpermissions->resetAttributes();
		$userlevelpermissions->CssClass = "";
		if ($userlevelpermissions_list->isGridAdd()) {
			$userlevelpermissions_list->loadRowValues(); // Load default values
		} else {
			$userlevelpermissions_list->loadRowValues($userlevelpermissions_list->Recordset); // Load row values
		}
		$userlevelpermissions->RowType = ROWTYPE_VIEW; // Render view
		if ($userlevelpermissions_list->isGridEdit()) { // Grid edit
			if ($userlevelpermissions->EventCancelled)
				$userlevelpermissions_list->restoreCurrentRowFormValues($userlevelpermissions_list->RowIndex); // Restore form values
			if ($userlevelpermissions_list->RowAction == "insert")
				$userlevelpermissions->RowType = ROWTYPE_ADD; // Render add
			else
				$userlevelpermissions->RowType = ROWTYPE_EDIT; // Render edit
			if (!$userlevelpermissions->EventCancelled)
				$userlevelpermissions_list->HashValue = $userlevelpermissions_list->getRowHash($userlevelpermissions_list->Recordset); // Get hash value for record
		}
		if ($userlevelpermissions_list->isGridEdit() && ($userlevelpermissions->RowType == ROWTYPE_EDIT || $userlevelpermissions->RowType == ROWTYPE_ADD) && $userlevelpermissions->EventCancelled) // Update failed
			$userlevelpermissions_list->restoreCurrentRowFormValues($userlevelpermissions_list->RowIndex); // Restore form values
		if ($userlevelpermissions->RowType == ROWTYPE_EDIT) // Edit row
			$userlevelpermissions_list->EditRowCount++;

		// Set up row id / data-rowindex
		$userlevelpermissions->RowAttrs->merge(["data-rowindex" => $userlevelpermissions_list->RowCount, "id" => "r" . $userlevelpermissions_list->RowCount . "_userlevelpermissions", "data-rowtype" => $userlevelpermissions->RowType]);

		// Render row
		$userlevelpermissions_list->renderRow();

		// Render list options
		$userlevelpermissions_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($userlevelpermissions_list->RowAction != "delete" && $userlevelpermissions_list->RowAction != "insertdelete" && !($userlevelpermissions_list->RowAction == "insert" && $userlevelpermissions->isConfirm() && $userlevelpermissions_list->emptyRow())) {
?>
	<tr <?php echo $userlevelpermissions->rowAttributes() ?>>
<?php

// Render list options (body, left)
$userlevelpermissions_list->ListOptions->render("body", "left", $userlevelpermissions_list->RowCount);
?>
	<?php if ($userlevelpermissions_list->userlevelid->Visible) { // userlevelid ?>
		<td data-name="userlevelid" <?php echo $userlevelpermissions_list->userlevelid->cellAttributes() ?>>
<?php if ($userlevelpermissions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $userlevelpermissions_list->RowCount ?>_userlevelpermissions_userlevelid" class="form-group">
<input type="text" data-table="userlevelpermissions" data-field="x_userlevelid" name="x<?php echo $userlevelpermissions_list->RowIndex ?>_userlevelid" id="x<?php echo $userlevelpermissions_list->RowIndex ?>_userlevelid" size="30" placeholder="<?php echo HtmlEncode($userlevelpermissions_list->userlevelid->getPlaceHolder()) ?>" value="<?php echo $userlevelpermissions_list->userlevelid->EditValue ?>"<?php echo $userlevelpermissions_list->userlevelid->editAttributes() ?>>
</span>
<input type="hidden" data-table="userlevelpermissions" data-field="x_userlevelid" name="o<?php echo $userlevelpermissions_list->RowIndex ?>_userlevelid" id="o<?php echo $userlevelpermissions_list->RowIndex ?>_userlevelid" value="<?php echo HtmlEncode($userlevelpermissions_list->userlevelid->OldValue) ?>">
<?php } ?>
<?php if ($userlevelpermissions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-table="userlevelpermissions" data-field="x_userlevelid" name="x<?php echo $userlevelpermissions_list->RowIndex ?>_userlevelid" id="x<?php echo $userlevelpermissions_list->RowIndex ?>_userlevelid" size="30" placeholder="<?php echo HtmlEncode($userlevelpermissions_list->userlevelid->getPlaceHolder()) ?>" value="<?php echo $userlevelpermissions_list->userlevelid->EditValue ?>"<?php echo $userlevelpermissions_list->userlevelid->editAttributes() ?>>
<input type="hidden" data-table="userlevelpermissions" data-field="x_userlevelid" name="o<?php echo $userlevelpermissions_list->RowIndex ?>_userlevelid" id="o<?php echo $userlevelpermissions_list->RowIndex ?>_userlevelid" value="<?php echo HtmlEncode($userlevelpermissions_list->userlevelid->OldValue != null ? $userlevelpermissions_list->userlevelid->OldValue : $userlevelpermissions_list->userlevelid->CurrentValue) ?>">
<?php } ?>
<?php if ($userlevelpermissions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $userlevelpermissions_list->RowCount ?>_userlevelpermissions_userlevelid">
<span<?php echo $userlevelpermissions_list->userlevelid->viewAttributes() ?>><?php echo $userlevelpermissions_list->userlevelid->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($userlevelpermissions_list->_tablename->Visible) { // tablename ?>
		<td data-name="_tablename" <?php echo $userlevelpermissions_list->_tablename->cellAttributes() ?>>
<?php if ($userlevelpermissions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $userlevelpermissions_list->RowCount ?>_userlevelpermissions__tablename" class="form-group">
<input type="text" data-table="userlevelpermissions" data-field="x__tablename" name="x<?php echo $userlevelpermissions_list->RowIndex ?>__tablename" id="x<?php echo $userlevelpermissions_list->RowIndex ?>__tablename" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($userlevelpermissions_list->_tablename->getPlaceHolder()) ?>" value="<?php echo $userlevelpermissions_list->_tablename->EditValue ?>"<?php echo $userlevelpermissions_list->_tablename->editAttributes() ?>>
</span>
<input type="hidden" data-table="userlevelpermissions" data-field="x__tablename" name="o<?php echo $userlevelpermissions_list->RowIndex ?>__tablename" id="o<?php echo $userlevelpermissions_list->RowIndex ?>__tablename" value="<?php echo HtmlEncode($userlevelpermissions_list->_tablename->OldValue) ?>">
<?php } ?>
<?php if ($userlevelpermissions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<input type="text" data-table="userlevelpermissions" data-field="x__tablename" name="x<?php echo $userlevelpermissions_list->RowIndex ?>__tablename" id="x<?php echo $userlevelpermissions_list->RowIndex ?>__tablename" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($userlevelpermissions_list->_tablename->getPlaceHolder()) ?>" value="<?php echo $userlevelpermissions_list->_tablename->EditValue ?>"<?php echo $userlevelpermissions_list->_tablename->editAttributes() ?>>
<input type="hidden" data-table="userlevelpermissions" data-field="x__tablename" name="o<?php echo $userlevelpermissions_list->RowIndex ?>__tablename" id="o<?php echo $userlevelpermissions_list->RowIndex ?>__tablename" value="<?php echo HtmlEncode($userlevelpermissions_list->_tablename->OldValue != null ? $userlevelpermissions_list->_tablename->OldValue : $userlevelpermissions_list->_tablename->CurrentValue) ?>">
<?php } ?>
<?php if ($userlevelpermissions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $userlevelpermissions_list->RowCount ?>_userlevelpermissions__tablename">
<span<?php echo $userlevelpermissions_list->_tablename->viewAttributes() ?>><?php echo $userlevelpermissions_list->_tablename->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($userlevelpermissions_list->permission->Visible) { // permission ?>
		<td data-name="permission" <?php echo $userlevelpermissions_list->permission->cellAttributes() ?>>
<?php if ($userlevelpermissions->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $userlevelpermissions_list->RowCount ?>_userlevelpermissions_permission" class="form-group">
<input type="text" data-table="userlevelpermissions" data-field="x_permission" name="x<?php echo $userlevelpermissions_list->RowIndex ?>_permission" id="x<?php echo $userlevelpermissions_list->RowIndex ?>_permission" size="30" placeholder="<?php echo HtmlEncode($userlevelpermissions_list->permission->getPlaceHolder()) ?>" value="<?php echo $userlevelpermissions_list->permission->EditValue ?>"<?php echo $userlevelpermissions_list->permission->editAttributes() ?>>
</span>
<input type="hidden" data-table="userlevelpermissions" data-field="x_permission" name="o<?php echo $userlevelpermissions_list->RowIndex ?>_permission" id="o<?php echo $userlevelpermissions_list->RowIndex ?>_permission" value="<?php echo HtmlEncode($userlevelpermissions_list->permission->OldValue) ?>">
<?php } ?>
<?php if ($userlevelpermissions->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $userlevelpermissions_list->RowCount ?>_userlevelpermissions_permission" class="form-group">
<input type="text" data-table="userlevelpermissions" data-field="x_permission" name="x<?php echo $userlevelpermissions_list->RowIndex ?>_permission" id="x<?php echo $userlevelpermissions_list->RowIndex ?>_permission" size="30" placeholder="<?php echo HtmlEncode($userlevelpermissions_list->permission->getPlaceHolder()) ?>" value="<?php echo $userlevelpermissions_list->permission->EditValue ?>"<?php echo $userlevelpermissions_list->permission->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($userlevelpermissions->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $userlevelpermissions_list->RowCount ?>_userlevelpermissions_permission">
<span<?php echo $userlevelpermissions_list->permission->viewAttributes() ?>><?php echo $userlevelpermissions_list->permission->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$userlevelpermissions_list->ListOptions->render("body", "right", $userlevelpermissions_list->RowCount);
?>
	</tr>
<?php if ($userlevelpermissions->RowType == ROWTYPE_ADD || $userlevelpermissions->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fuserlevelpermissionslist", "load"], function() {
	fuserlevelpermissionslist.updateLists(<?php echo $userlevelpermissions_list->RowIndex ?>);
});
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$userlevelpermissions_list->isGridAdd())
		if (!$userlevelpermissions_list->Recordset->EOF)
			$userlevelpermissions_list->Recordset->moveNext();
}
?>
<?php
	if ($userlevelpermissions_list->isGridAdd() || $userlevelpermissions_list->isGridEdit()) {
		$userlevelpermissions_list->RowIndex = '$rowindex$';
		$userlevelpermissions_list->loadRowValues();

		// Set row properties
		$userlevelpermissions->resetAttributes();
		$userlevelpermissions->RowAttrs->merge(["data-rowindex" => $userlevelpermissions_list->RowIndex, "id" => "r0_userlevelpermissions", "data-rowtype" => ROWTYPE_ADD]);
		$userlevelpermissions->RowAttrs->appendClass("ew-template");
		$userlevelpermissions->RowType = ROWTYPE_ADD;

		// Render row
		$userlevelpermissions_list->renderRow();

		// Render list options
		$userlevelpermissions_list->renderListOptions();
		$userlevelpermissions_list->StartRowCount = 0;
?>
	<tr <?php echo $userlevelpermissions->rowAttributes() ?>>
<?php

// Render list options (body, left)
$userlevelpermissions_list->ListOptions->render("body", "left", $userlevelpermissions_list->RowIndex);
?>
	<?php if ($userlevelpermissions_list->userlevelid->Visible) { // userlevelid ?>
		<td data-name="userlevelid">
<span id="el$rowindex$_userlevelpermissions_userlevelid" class="form-group userlevelpermissions_userlevelid">
<input type="text" data-table="userlevelpermissions" data-field="x_userlevelid" name="x<?php echo $userlevelpermissions_list->RowIndex ?>_userlevelid" id="x<?php echo $userlevelpermissions_list->RowIndex ?>_userlevelid" size="30" placeholder="<?php echo HtmlEncode($userlevelpermissions_list->userlevelid->getPlaceHolder()) ?>" value="<?php echo $userlevelpermissions_list->userlevelid->EditValue ?>"<?php echo $userlevelpermissions_list->userlevelid->editAttributes() ?>>
</span>
<input type="hidden" data-table="userlevelpermissions" data-field="x_userlevelid" name="o<?php echo $userlevelpermissions_list->RowIndex ?>_userlevelid" id="o<?php echo $userlevelpermissions_list->RowIndex ?>_userlevelid" value="<?php echo HtmlEncode($userlevelpermissions_list->userlevelid->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($userlevelpermissions_list->_tablename->Visible) { // tablename ?>
		<td data-name="_tablename">
<span id="el$rowindex$_userlevelpermissions__tablename" class="form-group userlevelpermissions__tablename">
<input type="text" data-table="userlevelpermissions" data-field="x__tablename" name="x<?php echo $userlevelpermissions_list->RowIndex ?>__tablename" id="x<?php echo $userlevelpermissions_list->RowIndex ?>__tablename" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($userlevelpermissions_list->_tablename->getPlaceHolder()) ?>" value="<?php echo $userlevelpermissions_list->_tablename->EditValue ?>"<?php echo $userlevelpermissions_list->_tablename->editAttributes() ?>>
</span>
<input type="hidden" data-table="userlevelpermissions" data-field="x__tablename" name="o<?php echo $userlevelpermissions_list->RowIndex ?>__tablename" id="o<?php echo $userlevelpermissions_list->RowIndex ?>__tablename" value="<?php echo HtmlEncode($userlevelpermissions_list->_tablename->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($userlevelpermissions_list->permission->Visible) { // permission ?>
		<td data-name="permission">
<span id="el$rowindex$_userlevelpermissions_permission" class="form-group userlevelpermissions_permission">
<input type="text" data-table="userlevelpermissions" data-field="x_permission" name="x<?php echo $userlevelpermissions_list->RowIndex ?>_permission" id="x<?php echo $userlevelpermissions_list->RowIndex ?>_permission" size="30" placeholder="<?php echo HtmlEncode($userlevelpermissions_list->permission->getPlaceHolder()) ?>" value="<?php echo $userlevelpermissions_list->permission->EditValue ?>"<?php echo $userlevelpermissions_list->permission->editAttributes() ?>>
</span>
<input type="hidden" data-table="userlevelpermissions" data-field="x_permission" name="o<?php echo $userlevelpermissions_list->RowIndex ?>_permission" id="o<?php echo $userlevelpermissions_list->RowIndex ?>_permission" value="<?php echo HtmlEncode($userlevelpermissions_list->permission->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$userlevelpermissions_list->ListOptions->render("body", "right", $userlevelpermissions_list->RowIndex);
?>
<script>
loadjs.ready(["fuserlevelpermissionslist", "load"], function() {
	fuserlevelpermissionslist.updateLists(<?php echo $userlevelpermissions_list->RowIndex ?>);
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
<?php if ($userlevelpermissions_list->isGridEdit()) { ?>
<?php if ($userlevelpermissions->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="action" id="action" value="gridoverwrite">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<?php } ?>
<input type="hidden" name="<?php echo $userlevelpermissions_list->FormKeyCountName ?>" id="<?php echo $userlevelpermissions_list->FormKeyCountName ?>" value="<?php echo $userlevelpermissions_list->KeyCount ?>">
<?php echo $userlevelpermissions_list->MultiSelectKey ?>
<?php } ?>
<?php if (!$userlevelpermissions->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($userlevelpermissions_list->Recordset)
	$userlevelpermissions_list->Recordset->Close();
?>
<?php if (!$userlevelpermissions_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$userlevelpermissions_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $userlevelpermissions_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $userlevelpermissions_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($userlevelpermissions_list->TotalRecords == 0 && !$userlevelpermissions->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $userlevelpermissions_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$userlevelpermissions_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$userlevelpermissions_list->isExport()) { ?>
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
$userlevelpermissions_list->terminate();
?>