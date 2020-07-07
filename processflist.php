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
$processf_list = new processf_list();

// Run the page
$processf_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$processf_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$processf_list->isExport()) { ?>
<script>
var fprocessflist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	fprocessflist = currentForm = new ew.Form("fprocessflist", "list");
	fprocessflist.formKeyCountName = '<?php echo $processf_list->FormKeyCountName ?>';

	// Validate form
	fprocessflist.validate = function() {
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
			<?php if ($processf_list->fmea->Required) { ?>
				elm = this.getElements("x" + infix + "_fmea");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_list->fmea->caption(), $processf_list->fmea->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_list->step->Required) { ?>
				elm = this.getElements("x" + infix + "_step");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_list->step->caption(), $processf_list->step->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_step");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($processf_list->step->errorMessage()) ?>");
			<?php if ($processf_list->flowchartDesc->Required) { ?>
				elm = this.getElements("x" + infix + "_flowchartDesc");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_list->flowchartDesc->caption(), $processf_list->flowchartDesc->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_list->partnumber->Required) { ?>
				elm = this.getElements("x" + infix + "_partnumber");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_list->partnumber->caption(), $processf_list->partnumber->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_list->operation->Required) { ?>
				elm = this.getElements("x" + infix + "_operation");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_list->operation->caption(), $processf_list->operation->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_list->derivedFromNC->Required) { ?>
				elm = this.getElements("x" + infix + "_derivedFromNC[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_list->derivedFromNC->caption(), $processf_list->derivedFromNC->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_list->numberOfNC->Required) { ?>
				elm = this.getElements("x" + infix + "_numberOfNC");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_list->numberOfNC->caption(), $processf_list->numberOfNC->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_list->flowchart->Required) { ?>
				elm = this.getElements("x" + infix + "_flowchart");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_list->flowchart->caption(), $processf_list->flowchart->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_list->subprocess->Required) { ?>
				elm = this.getElements("x" + infix + "_subprocess");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_list->subprocess->caption(), $processf_list->subprocess->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_list->requirement->Required) { ?>
				elm = this.getElements("x" + infix + "_requirement");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_list->requirement->caption(), $processf_list->requirement->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_list->potencialFailureMode->Required) { ?>
				elm = this.getElements("x" + infix + "_potencialFailureMode");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_list->potencialFailureMode->caption(), $processf_list->potencialFailureMode->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_list->potencialFailurEffect->Required) { ?>
				elm = this.getElements("x" + infix + "_potencialFailurEffect");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_list->potencialFailurEffect->caption(), $processf_list->potencialFailurEffect->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_list->kc->Required) { ?>
				elm = this.getElements("x" + infix + "_kc[]");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_list->kc->caption(), $processf_list->kc->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($processf_list->severity->Required) { ?>
				elm = this.getElements("x" + infix + "_severity");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $processf_list->severity->caption(), $processf_list->severity->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_severity");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($processf_list->severity->errorMessage()) ?>");

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
		}
		return true;
	}

	// Form_CustomValidate
	fprocessflist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fprocessflist.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fprocessflist.lists["x_fmea"] = <?php echo $processf_list->fmea->Lookup->toClientList($processf_list) ?>;
	fprocessflist.lists["x_fmea"].options = <?php echo JsonEncode($processf_list->fmea->lookupOptions()) ?>;
	fprocessflist.lists["x_derivedFromNC[]"] = <?php echo $processf_list->derivedFromNC->Lookup->toClientList($processf_list) ?>;
	fprocessflist.lists["x_derivedFromNC[]"].options = <?php echo JsonEncode($processf_list->derivedFromNC->options(FALSE, TRUE)) ?>;
	fprocessflist.lists["x_kc[]"] = <?php echo $processf_list->kc->Lookup->toClientList($processf_list) ?>;
	fprocessflist.lists["x_kc[]"].options = <?php echo JsonEncode($processf_list->kc->options(FALSE, TRUE)) ?>;
	loadjs.done("fprocessflist");
});
var fprocessflistsrch;
loadjs.ready("head", function() {

	// Form object for search
	fprocessflistsrch = currentSearchForm = new ew.Form("fprocessflistsrch");

	// Dynamic selection lists
	// Filters

	fprocessflistsrch.filterList = <?php echo $processf_list->getFilterList() ?>;
	loadjs.done("fprocessflistsrch");
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
<?php if (!$processf_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($processf_list->TotalRecords > 0 && $processf_list->ExportOptions->visible()) { ?>
<?php $processf_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($processf_list->ImportOptions->visible()) { ?>
<?php $processf_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($processf_list->SearchOptions->visible()) { ?>
<?php $processf_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($processf_list->FilterOptions->visible()) { ?>
<?php $processf_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (!$processf_list->isExport() || Config("EXPORT_MASTER_RECORD") && $processf_list->isExport("print")) { ?>
<?php
if ($processf_list->DbMasterFilter != "" && $processf->getCurrentMasterTable() == "fmea") {
	if ($processf_list->MasterRecordExists) {
		include_once "fmeamaster.php";
	}
}
?>
<?php } ?>
<?php
$processf_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$processf_list->isExport() && !$processf->CurrentAction) { ?>
<form name="fprocessflistsrch" id="fprocessflistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="fprocessflistsrch-search-panel" class="<?php echo $processf_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="processf">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $processf_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($processf_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($processf_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $processf_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($processf_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($processf_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($processf_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($processf_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $processf_list->showPageHeader(); ?>
<?php
$processf_list->showMessage();
?>
<?php if ($processf_list->TotalRecords > 0 || $processf->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($processf_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> processf">
<?php if (!$processf_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$processf_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $processf_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $processf_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fprocessflist" id="fprocessflist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="processf">
<?php if ($processf->getCurrentMasterTable() == "fmea" && $processf->CurrentAction) { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="fmea">
<input type="hidden" name="fk_fmea" value="<?php echo $processf_list->fmea->getSessionValue() ?>">
<?php } ?>
<div id="gmp_processf" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($processf_list->TotalRecords > 0 || $processf_list->isAdd() || $processf_list->isCopy() || $processf_list->isGridEdit()) { ?>
<table id="tbl_processflist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$processf->RowType = ROWTYPE_HEADER;

// Render list options
$processf_list->renderListOptions();

// Render list options (header, left)
$processf_list->ListOptions->render("header", "left");
?>
<?php if ($processf_list->fmea->Visible) { // fmea ?>
	<?php if ($processf_list->SortUrl($processf_list->fmea) == "") { ?>
		<th data-name="fmea" class="<?php echo $processf_list->fmea->headerCellClass() ?>"><div id="elh_processf_fmea" class="processf_fmea"><div class="ew-table-header-caption"><?php echo $processf_list->fmea->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fmea" class="<?php echo $processf_list->fmea->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $processf_list->SortUrl($processf_list->fmea) ?>', 2);"><div id="elh_processf_fmea" class="processf_fmea">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_list->fmea->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_list->fmea->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_list->fmea->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_list->step->Visible) { // step ?>
	<?php if ($processf_list->SortUrl($processf_list->step) == "") { ?>
		<th data-name="step" class="<?php echo $processf_list->step->headerCellClass() ?>"><div id="elh_processf_step" class="processf_step"><div class="ew-table-header-caption"><?php echo $processf_list->step->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="step" class="<?php echo $processf_list->step->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $processf_list->SortUrl($processf_list->step) ?>', 2);"><div id="elh_processf_step" class="processf_step">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_list->step->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_list->step->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_list->step->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_list->flowchartDesc->Visible) { // flowchartDesc ?>
	<?php if ($processf_list->SortUrl($processf_list->flowchartDesc) == "") { ?>
		<th data-name="flowchartDesc" class="<?php echo $processf_list->flowchartDesc->headerCellClass() ?>"><div id="elh_processf_flowchartDesc" class="processf_flowchartDesc"><div class="ew-table-header-caption"><?php echo $processf_list->flowchartDesc->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="flowchartDesc" class="<?php echo $processf_list->flowchartDesc->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $processf_list->SortUrl($processf_list->flowchartDesc) ?>', 2);"><div id="elh_processf_flowchartDesc" class="processf_flowchartDesc">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_list->flowchartDesc->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($processf_list->flowchartDesc->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_list->flowchartDesc->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_list->partnumber->Visible) { // partnumber ?>
	<?php if ($processf_list->SortUrl($processf_list->partnumber) == "") { ?>
		<th data-name="partnumber" class="<?php echo $processf_list->partnumber->headerCellClass() ?>"><div id="elh_processf_partnumber" class="processf_partnumber"><div class="ew-table-header-caption"><?php echo $processf_list->partnumber->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="partnumber" class="<?php echo $processf_list->partnumber->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $processf_list->SortUrl($processf_list->partnumber) ?>', 2);"><div id="elh_processf_partnumber" class="processf_partnumber">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_list->partnumber->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($processf_list->partnumber->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_list->partnumber->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_list->operation->Visible) { // operation ?>
	<?php if ($processf_list->SortUrl($processf_list->operation) == "") { ?>
		<th data-name="operation" class="<?php echo $processf_list->operation->headerCellClass() ?>"><div id="elh_processf_operation" class="processf_operation"><div class="ew-table-header-caption"><?php echo $processf_list->operation->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="operation" class="<?php echo $processf_list->operation->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $processf_list->SortUrl($processf_list->operation) ?>', 2);"><div id="elh_processf_operation" class="processf_operation">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_list->operation->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($processf_list->operation->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_list->operation->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_list->derivedFromNC->Visible) { // derivedFromNC ?>
	<?php if ($processf_list->SortUrl($processf_list->derivedFromNC) == "") { ?>
		<th data-name="derivedFromNC" class="<?php echo $processf_list->derivedFromNC->headerCellClass() ?>"><div id="elh_processf_derivedFromNC" class="processf_derivedFromNC"><div class="ew-table-header-caption"><?php echo $processf_list->derivedFromNC->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="derivedFromNC" class="<?php echo $processf_list->derivedFromNC->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $processf_list->SortUrl($processf_list->derivedFromNC) ?>', 2);"><div id="elh_processf_derivedFromNC" class="processf_derivedFromNC">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_list->derivedFromNC->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($processf_list->derivedFromNC->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_list->derivedFromNC->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_list->numberOfNC->Visible) { // numberOfNC ?>
	<?php if ($processf_list->SortUrl($processf_list->numberOfNC) == "") { ?>
		<th data-name="numberOfNC" class="<?php echo $processf_list->numberOfNC->headerCellClass() ?>"><div id="elh_processf_numberOfNC" class="processf_numberOfNC"><div class="ew-table-header-caption"><?php echo $processf_list->numberOfNC->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="numberOfNC" class="<?php echo $processf_list->numberOfNC->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $processf_list->SortUrl($processf_list->numberOfNC) ?>', 2);"><div id="elh_processf_numberOfNC" class="processf_numberOfNC">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_list->numberOfNC->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($processf_list->numberOfNC->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_list->numberOfNC->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_list->flowchart->Visible) { // flowchart ?>
	<?php if ($processf_list->SortUrl($processf_list->flowchart) == "") { ?>
		<th data-name="flowchart" class="<?php echo $processf_list->flowchart->headerCellClass() ?>"><div id="elh_processf_flowchart" class="processf_flowchart"><div class="ew-table-header-caption"><?php echo $processf_list->flowchart->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="flowchart" class="<?php echo $processf_list->flowchart->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $processf_list->SortUrl($processf_list->flowchart) ?>', 2);"><div id="elh_processf_flowchart" class="processf_flowchart">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_list->flowchart->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($processf_list->flowchart->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_list->flowchart->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_list->subprocess->Visible) { // subprocess ?>
	<?php if ($processf_list->SortUrl($processf_list->subprocess) == "") { ?>
		<th data-name="subprocess" class="<?php echo $processf_list->subprocess->headerCellClass() ?>"><div id="elh_processf_subprocess" class="processf_subprocess"><div class="ew-table-header-caption"><?php echo $processf_list->subprocess->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="subprocess" class="<?php echo $processf_list->subprocess->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $processf_list->SortUrl($processf_list->subprocess) ?>', 2);"><div id="elh_processf_subprocess" class="processf_subprocess">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_list->subprocess->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($processf_list->subprocess->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_list->subprocess->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_list->requirement->Visible) { // requirement ?>
	<?php if ($processf_list->SortUrl($processf_list->requirement) == "") { ?>
		<th data-name="requirement" class="<?php echo $processf_list->requirement->headerCellClass() ?>"><div id="elh_processf_requirement" class="processf_requirement"><div class="ew-table-header-caption"><?php echo $processf_list->requirement->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="requirement" class="<?php echo $processf_list->requirement->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $processf_list->SortUrl($processf_list->requirement) ?>', 2);"><div id="elh_processf_requirement" class="processf_requirement">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_list->requirement->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($processf_list->requirement->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_list->requirement->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_list->potencialFailureMode->Visible) { // potencialFailureMode ?>
	<?php if ($processf_list->SortUrl($processf_list->potencialFailureMode) == "") { ?>
		<th data-name="potencialFailureMode" class="<?php echo $processf_list->potencialFailureMode->headerCellClass() ?>"><div id="elh_processf_potencialFailureMode" class="processf_potencialFailureMode"><div class="ew-table-header-caption"><?php echo $processf_list->potencialFailureMode->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="potencialFailureMode" class="<?php echo $processf_list->potencialFailureMode->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $processf_list->SortUrl($processf_list->potencialFailureMode) ?>', 2);"><div id="elh_processf_potencialFailureMode" class="processf_potencialFailureMode">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_list->potencialFailureMode->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($processf_list->potencialFailureMode->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_list->potencialFailureMode->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_list->potencialFailurEffect->Visible) { // potencialFailurEffect ?>
	<?php if ($processf_list->SortUrl($processf_list->potencialFailurEffect) == "") { ?>
		<th data-name="potencialFailurEffect" class="<?php echo $processf_list->potencialFailurEffect->headerCellClass() ?>"><div id="elh_processf_potencialFailurEffect" class="processf_potencialFailurEffect"><div class="ew-table-header-caption"><?php echo $processf_list->potencialFailurEffect->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="potencialFailurEffect" class="<?php echo $processf_list->potencialFailurEffect->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $processf_list->SortUrl($processf_list->potencialFailurEffect) ?>', 2);"><div id="elh_processf_potencialFailurEffect" class="processf_potencialFailurEffect">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_list->potencialFailurEffect->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($processf_list->potencialFailurEffect->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_list->potencialFailurEffect->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_list->kc->Visible) { // kc ?>
	<?php if ($processf_list->SortUrl($processf_list->kc) == "") { ?>
		<th data-name="kc" class="<?php echo $processf_list->kc->headerCellClass() ?>"><div id="elh_processf_kc" class="processf_kc"><div class="ew-table-header-caption"><?php echo $processf_list->kc->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kc" class="<?php echo $processf_list->kc->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $processf_list->SortUrl($processf_list->kc) ?>', 2);"><div id="elh_processf_kc" class="processf_kc">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_list->kc->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($processf_list->kc->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_list->kc->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_list->severity->Visible) { // severity ?>
	<?php if ($processf_list->SortUrl($processf_list->severity) == "") { ?>
		<th data-name="severity" class="<?php echo $processf_list->severity->headerCellClass() ?>"><div id="elh_processf_severity" class="processf_severity"><div class="ew-table-header-caption"><?php echo $processf_list->severity->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="severity" class="<?php echo $processf_list->severity->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $processf_list->SortUrl($processf_list->severity) ?>', 2);"><div id="elh_processf_severity" class="processf_severity">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_list->severity->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($processf_list->severity->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_list->severity->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$processf_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($processf_list->isAdd() || $processf_list->isCopy()) {
		$processf_list->RowIndex = 0;
		$processf_list->KeyCount = $processf_list->RowIndex;
		if ($processf_list->isAdd())
			$processf_list->loadRowValues();
		if ($processf->EventCancelled) // Insert failed
			$processf_list->restoreFormValues(); // Restore form values

		// Set row properties
		$processf->resetAttributes();
		$processf->RowAttrs->merge(["data-rowindex" => 0, "id" => "r0_processf", "data-rowtype" => ROWTYPE_ADD]);
		$processf->RowType = ROWTYPE_ADD;

		// Render row
		$processf_list->renderRow();

		// Render list options
		$processf_list->renderListOptions();
		$processf_list->StartRowCount = 0;
?>
	<tr <?php echo $processf->rowAttributes() ?>>
<?php

// Render list options (body, left)
$processf_list->ListOptions->render("body", "left", $processf_list->RowCount);
?>
	<?php if ($processf_list->fmea->Visible) { // fmea ?>
		<td data-name="fmea">
<?php if ($processf_list->fmea->getSessionValue() != "") { ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_fmea" class="form-group processf_fmea">
<span<?php echo $processf_list->fmea->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($processf_list->fmea->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $processf_list->RowIndex ?>_fmea" name="x<?php echo $processf_list->RowIndex ?>_fmea" value="<?php echo HtmlEncode($processf_list->fmea->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_fmea" class="form-group processf_fmea">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="processf" data-field="x_fmea" data-value-separator="<?php echo $processf_list->fmea->displayValueSeparatorAttribute() ?>" id="x<?php echo $processf_list->RowIndex ?>_fmea" name="x<?php echo $processf_list->RowIndex ?>_fmea"<?php echo $processf_list->fmea->editAttributes() ?>>
			<?php echo $processf_list->fmea->selectOptionListHtml("x{$processf_list->RowIndex}_fmea") ?>
		</select>
</div>
<?php echo $processf_list->fmea->Lookup->getParamTag($processf_list, "p_x" . $processf_list->RowIndex . "_fmea") ?>
</span>
<?php } ?>
<input type="hidden" data-table="processf" data-field="x_fmea" name="o<?php echo $processf_list->RowIndex ?>_fmea" id="o<?php echo $processf_list->RowIndex ?>_fmea" value="<?php echo HtmlEncode($processf_list->fmea->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->step->Visible) { // step ?>
		<td data-name="step">
<span id="el<?php echo $processf_list->RowCount ?>_processf_step" class="form-group processf_step">
<input type="text" data-table="processf" data-field="x_step" name="x<?php echo $processf_list->RowIndex ?>_step" id="x<?php echo $processf_list->RowIndex ?>_step" size="30" maxlength="6" placeholder="<?php echo HtmlEncode($processf_list->step->getPlaceHolder()) ?>" value="<?php echo $processf_list->step->EditValue ?>"<?php echo $processf_list->step->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_step" name="o<?php echo $processf_list->RowIndex ?>_step" id="o<?php echo $processf_list->RowIndex ?>_step" value="<?php echo HtmlEncode($processf_list->step->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->flowchartDesc->Visible) { // flowchartDesc ?>
		<td data-name="flowchartDesc">
<span id="el<?php echo $processf_list->RowCount ?>_processf_flowchartDesc" class="form-group processf_flowchartDesc">
<textarea data-table="processf" data-field="x_flowchartDesc" name="x<?php echo $processf_list->RowIndex ?>_flowchartDesc" id="x<?php echo $processf_list->RowIndex ?>_flowchartDesc" cols="35" rows="2" placeholder="<?php echo HtmlEncode($processf_list->flowchartDesc->getPlaceHolder()) ?>"<?php echo $processf_list->flowchartDesc->editAttributes() ?>><?php echo $processf_list->flowchartDesc->EditValue ?></textarea>
</span>
<input type="hidden" data-table="processf" data-field="x_flowchartDesc" name="o<?php echo $processf_list->RowIndex ?>_flowchartDesc" id="o<?php echo $processf_list->RowIndex ?>_flowchartDesc" value="<?php echo HtmlEncode($processf_list->flowchartDesc->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->partnumber->Visible) { // partnumber ?>
		<td data-name="partnumber">
<span id="el<?php echo $processf_list->RowCount ?>_processf_partnumber" class="form-group processf_partnumber">
<input type="text" data-table="processf" data-field="x_partnumber" name="x<?php echo $processf_list->RowIndex ?>_partnumber" id="x<?php echo $processf_list->RowIndex ?>_partnumber" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->partnumber->getPlaceHolder()) ?>" value="<?php echo $processf_list->partnumber->EditValue ?>"<?php echo $processf_list->partnumber->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_partnumber" name="o<?php echo $processf_list->RowIndex ?>_partnumber" id="o<?php echo $processf_list->RowIndex ?>_partnumber" value="<?php echo HtmlEncode($processf_list->partnumber->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->operation->Visible) { // operation ?>
		<td data-name="operation">
<span id="el<?php echo $processf_list->RowCount ?>_processf_operation" class="form-group processf_operation">
<input type="text" data-table="processf" data-field="x_operation" name="x<?php echo $processf_list->RowIndex ?>_operation" id="x<?php echo $processf_list->RowIndex ?>_operation" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->operation->getPlaceHolder()) ?>" value="<?php echo $processf_list->operation->EditValue ?>"<?php echo $processf_list->operation->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_operation" name="o<?php echo $processf_list->RowIndex ?>_operation" id="o<?php echo $processf_list->RowIndex ?>_operation" value="<?php echo HtmlEncode($processf_list->operation->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->derivedFromNC->Visible) { // derivedFromNC ?>
		<td data-name="derivedFromNC">
<span id="el<?php echo $processf_list->RowCount ?>_processf_derivedFromNC" class="form-group processf_derivedFromNC">
<?php
$selwrk = ConvertToBool($processf_list->derivedFromNC->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="processf" data-field="x_derivedFromNC" name="x<?php echo $processf_list->RowIndex ?>_derivedFromNC[]" id="x<?php echo $processf_list->RowIndex ?>_derivedFromNC[]" value="1"<?php echo $selwrk ?><?php echo $processf_list->derivedFromNC->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $processf_list->RowIndex ?>_derivedFromNC[]"></label>
</div>
</span>
<input type="hidden" data-table="processf" data-field="x_derivedFromNC" name="o<?php echo $processf_list->RowIndex ?>_derivedFromNC[]" id="o<?php echo $processf_list->RowIndex ?>_derivedFromNC[]" value="<?php echo HtmlEncode($processf_list->derivedFromNC->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->numberOfNC->Visible) { // numberOfNC ?>
		<td data-name="numberOfNC">
<span id="el<?php echo $processf_list->RowCount ?>_processf_numberOfNC" class="form-group processf_numberOfNC">
<input type="text" data-table="processf" data-field="x_numberOfNC" name="x<?php echo $processf_list->RowIndex ?>_numberOfNC" id="x<?php echo $processf_list->RowIndex ?>_numberOfNC" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->numberOfNC->getPlaceHolder()) ?>" value="<?php echo $processf_list->numberOfNC->EditValue ?>"<?php echo $processf_list->numberOfNC->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_numberOfNC" name="o<?php echo $processf_list->RowIndex ?>_numberOfNC" id="o<?php echo $processf_list->RowIndex ?>_numberOfNC" value="<?php echo HtmlEncode($processf_list->numberOfNC->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->flowchart->Visible) { // flowchart ?>
		<td data-name="flowchart">
<span id="el<?php echo $processf_list->RowCount ?>_processf_flowchart" class="form-group processf_flowchart">
<input type="text" data-table="processf" data-field="x_flowchart" name="x<?php echo $processf_list->RowIndex ?>_flowchart" id="x<?php echo $processf_list->RowIndex ?>_flowchart" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->flowchart->getPlaceHolder()) ?>" value="<?php echo $processf_list->flowchart->EditValue ?>"<?php echo $processf_list->flowchart->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_flowchart" name="o<?php echo $processf_list->RowIndex ?>_flowchart" id="o<?php echo $processf_list->RowIndex ?>_flowchart" value="<?php echo HtmlEncode($processf_list->flowchart->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->subprocess->Visible) { // subprocess ?>
		<td data-name="subprocess">
<span id="el<?php echo $processf_list->RowCount ?>_processf_subprocess" class="form-group processf_subprocess">
<input type="text" data-table="processf" data-field="x_subprocess" name="x<?php echo $processf_list->RowIndex ?>_subprocess" id="x<?php echo $processf_list->RowIndex ?>_subprocess" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->subprocess->getPlaceHolder()) ?>" value="<?php echo $processf_list->subprocess->EditValue ?>"<?php echo $processf_list->subprocess->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_subprocess" name="o<?php echo $processf_list->RowIndex ?>_subprocess" id="o<?php echo $processf_list->RowIndex ?>_subprocess" value="<?php echo HtmlEncode($processf_list->subprocess->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->requirement->Visible) { // requirement ?>
		<td data-name="requirement">
<span id="el<?php echo $processf_list->RowCount ?>_processf_requirement" class="form-group processf_requirement">
<input type="text" data-table="processf" data-field="x_requirement" name="x<?php echo $processf_list->RowIndex ?>_requirement" id="x<?php echo $processf_list->RowIndex ?>_requirement" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->requirement->getPlaceHolder()) ?>" value="<?php echo $processf_list->requirement->EditValue ?>"<?php echo $processf_list->requirement->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_requirement" name="o<?php echo $processf_list->RowIndex ?>_requirement" id="o<?php echo $processf_list->RowIndex ?>_requirement" value="<?php echo HtmlEncode($processf_list->requirement->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->potencialFailureMode->Visible) { // potencialFailureMode ?>
		<td data-name="potencialFailureMode">
<span id="el<?php echo $processf_list->RowCount ?>_processf_potencialFailureMode" class="form-group processf_potencialFailureMode">
<input type="text" data-table="processf" data-field="x_potencialFailureMode" name="x<?php echo $processf_list->RowIndex ?>_potencialFailureMode" id="x<?php echo $processf_list->RowIndex ?>_potencialFailureMode" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->potencialFailureMode->getPlaceHolder()) ?>" value="<?php echo $processf_list->potencialFailureMode->EditValue ?>"<?php echo $processf_list->potencialFailureMode->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_potencialFailureMode" name="o<?php echo $processf_list->RowIndex ?>_potencialFailureMode" id="o<?php echo $processf_list->RowIndex ?>_potencialFailureMode" value="<?php echo HtmlEncode($processf_list->potencialFailureMode->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->potencialFailurEffect->Visible) { // potencialFailurEffect ?>
		<td data-name="potencialFailurEffect">
<span id="el<?php echo $processf_list->RowCount ?>_processf_potencialFailurEffect" class="form-group processf_potencialFailurEffect">
<input type="text" data-table="processf" data-field="x_potencialFailurEffect" name="x<?php echo $processf_list->RowIndex ?>_potencialFailurEffect" id="x<?php echo $processf_list->RowIndex ?>_potencialFailurEffect" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->potencialFailurEffect->getPlaceHolder()) ?>" value="<?php echo $processf_list->potencialFailurEffect->EditValue ?>"<?php echo $processf_list->potencialFailurEffect->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_potencialFailurEffect" name="o<?php echo $processf_list->RowIndex ?>_potencialFailurEffect" id="o<?php echo $processf_list->RowIndex ?>_potencialFailurEffect" value="<?php echo HtmlEncode($processf_list->potencialFailurEffect->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->kc->Visible) { // kc ?>
		<td data-name="kc">
<span id="el<?php echo $processf_list->RowCount ?>_processf_kc" class="form-group processf_kc">
<?php
$selwrk = ConvertToBool($processf_list->kc->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="processf" data-field="x_kc" name="x<?php echo $processf_list->RowIndex ?>_kc[]" id="x<?php echo $processf_list->RowIndex ?>_kc[]" value="1"<?php echo $selwrk ?><?php echo $processf_list->kc->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $processf_list->RowIndex ?>_kc[]"></label>
</div>
</span>
<input type="hidden" data-table="processf" data-field="x_kc" name="o<?php echo $processf_list->RowIndex ?>_kc[]" id="o<?php echo $processf_list->RowIndex ?>_kc[]" value="<?php echo HtmlEncode($processf_list->kc->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->severity->Visible) { // severity ?>
		<td data-name="severity">
<span id="el<?php echo $processf_list->RowCount ?>_processf_severity" class="form-group processf_severity">
<input type="text" data-table="processf" data-field="x_severity" name="x<?php echo $processf_list->RowIndex ?>_severity" id="x<?php echo $processf_list->RowIndex ?>_severity" size="3" placeholder="<?php echo HtmlEncode($processf_list->severity->getPlaceHolder()) ?>" value="<?php echo $processf_list->severity->EditValue ?>"<?php echo $processf_list->severity->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_severity" name="o<?php echo $processf_list->RowIndex ?>_severity" id="o<?php echo $processf_list->RowIndex ?>_severity" value="<?php echo HtmlEncode($processf_list->severity->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$processf_list->ListOptions->render("body", "right", $processf_list->RowCount);
?>
<script>
loadjs.ready(["fprocessflist", "load"], function() {
	fprocessflist.updateLists(<?php echo $processf_list->RowIndex ?>);
});
</script>
	</tr>
<?php
	}
?>
<?php
if ($processf_list->ExportAll && $processf_list->isExport()) {
	$processf_list->StopRecord = $processf_list->TotalRecords;
} else {

	// Set the last record to display
	if ($processf_list->TotalRecords > $processf_list->StartRecord + $processf_list->DisplayRecords - 1)
		$processf_list->StopRecord = $processf_list->StartRecord + $processf_list->DisplayRecords - 1;
	else
		$processf_list->StopRecord = $processf_list->TotalRecords;
}

// Restore number of post back records
if ($CurrentForm && ($processf->isConfirm() || $processf_list->EventCancelled)) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($processf_list->FormKeyCountName) && ($processf_list->isGridAdd() || $processf_list->isGridEdit() || $processf->isConfirm())) {
		$processf_list->KeyCount = $CurrentForm->getValue($processf_list->FormKeyCountName);
		$processf_list->StopRecord = $processf_list->StartRecord + $processf_list->KeyCount - 1;
	}
}
$processf_list->RecordCount = $processf_list->StartRecord - 1;
if ($processf_list->Recordset && !$processf_list->Recordset->EOF) {
	$processf_list->Recordset->moveFirst();
	$selectLimit = $processf_list->UseSelectLimit;
	if (!$selectLimit && $processf_list->StartRecord > 1)
		$processf_list->Recordset->move($processf_list->StartRecord - 1);
} elseif (!$processf->AllowAddDeleteRow && $processf_list->StopRecord == 0) {
	$processf_list->StopRecord = $processf->GridAddRowCount;
}

// Initialize aggregate
$processf->RowType = ROWTYPE_AGGREGATEINIT;
$processf->resetAttributes();
$processf_list->renderRow();
if ($processf_list->isGridEdit())
	$processf_list->RowIndex = 0;
while ($processf_list->RecordCount < $processf_list->StopRecord) {
	$processf_list->RecordCount++;
	if ($processf_list->RecordCount >= $processf_list->StartRecord) {
		$processf_list->RowCount++;
		if ($processf_list->isGridAdd() || $processf_list->isGridEdit() || $processf->isConfirm()) {
			$processf_list->RowIndex++;
			$CurrentForm->Index = $processf_list->RowIndex;
			if ($CurrentForm->hasValue($processf_list->FormActionName) && ($processf->isConfirm() || $processf_list->EventCancelled))
				$processf_list->RowAction = strval($CurrentForm->getValue($processf_list->FormActionName));
			elseif ($processf_list->isGridAdd())
				$processf_list->RowAction = "insert";
			else
				$processf_list->RowAction = "";
		}

		// Set up key count
		$processf_list->KeyCount = $processf_list->RowIndex;

		// Init row class and style
		$processf->resetAttributes();
		$processf->CssClass = "";
		if ($processf_list->isGridAdd()) {
			$processf_list->loadRowValues(); // Load default values
		} else {
			$processf_list->loadRowValues($processf_list->Recordset); // Load row values
		}
		$processf->RowType = ROWTYPE_VIEW; // Render view
		if ($processf_list->isGridEdit()) { // Grid edit
			if ($processf->EventCancelled)
				$processf_list->restoreCurrentRowFormValues($processf_list->RowIndex); // Restore form values
			if ($processf_list->RowAction == "insert")
				$processf->RowType = ROWTYPE_ADD; // Render add
			else
				$processf->RowType = ROWTYPE_EDIT; // Render edit
			if (!$processf->EventCancelled)
				$processf_list->HashValue = $processf_list->getRowHash($processf_list->Recordset); // Get hash value for record
		}
		if ($processf_list->isGridEdit() && ($processf->RowType == ROWTYPE_EDIT || $processf->RowType == ROWTYPE_ADD) && $processf->EventCancelled) // Update failed
			$processf_list->restoreCurrentRowFormValues($processf_list->RowIndex); // Restore form values
		if ($processf->RowType == ROWTYPE_EDIT) // Edit row
			$processf_list->EditRowCount++;

		// Set up row id / data-rowindex
		$processf->RowAttrs->merge(["data-rowindex" => $processf_list->RowCount, "id" => "r" . $processf_list->RowCount . "_processf", "data-rowtype" => $processf->RowType]);

		// Render row
		$processf_list->renderRow();

		// Render list options
		$processf_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($processf_list->RowAction != "delete" && $processf_list->RowAction != "insertdelete" && !($processf_list->RowAction == "insert" && $processf->isConfirm() && $processf_list->emptyRow())) {
?>
	<tr <?php echo $processf->rowAttributes() ?>>
<?php

// Render list options (body, left)
$processf_list->ListOptions->render("body", "left", $processf_list->RowCount);
?>
	<?php if ($processf_list->fmea->Visible) { // fmea ?>
		<td data-name="fmea" <?php echo $processf_list->fmea->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($processf_list->fmea->getSessionValue() != "") { ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_fmea" class="form-group">
<span<?php echo $processf_list->fmea->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($processf_list->fmea->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $processf_list->RowIndex ?>_fmea" name="x<?php echo $processf_list->RowIndex ?>_fmea" value="<?php echo HtmlEncode($processf_list->fmea->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_fmea" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="processf" data-field="x_fmea" data-value-separator="<?php echo $processf_list->fmea->displayValueSeparatorAttribute() ?>" id="x<?php echo $processf_list->RowIndex ?>_fmea" name="x<?php echo $processf_list->RowIndex ?>_fmea"<?php echo $processf_list->fmea->editAttributes() ?>>
			<?php echo $processf_list->fmea->selectOptionListHtml("x{$processf_list->RowIndex}_fmea") ?>
		</select>
</div>
<?php echo $processf_list->fmea->Lookup->getParamTag($processf_list, "p_x" . $processf_list->RowIndex . "_fmea") ?>
</span>
<?php } ?>
<input type="hidden" data-table="processf" data-field="x_fmea" name="o<?php echo $processf_list->RowIndex ?>_fmea" id="o<?php echo $processf_list->RowIndex ?>_fmea" value="<?php echo HtmlEncode($processf_list->fmea->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($processf_list->fmea->getSessionValue() != "") { ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_fmea" class="form-group">
<span<?php echo $processf_list->fmea->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($processf_list->fmea->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $processf_list->RowIndex ?>_fmea" name="x<?php echo $processf_list->RowIndex ?>_fmea" value="<?php echo HtmlEncode($processf_list->fmea->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_fmea" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="processf" data-field="x_fmea" data-value-separator="<?php echo $processf_list->fmea->displayValueSeparatorAttribute() ?>" id="x<?php echo $processf_list->RowIndex ?>_fmea" name="x<?php echo $processf_list->RowIndex ?>_fmea"<?php echo $processf_list->fmea->editAttributes() ?>>
			<?php echo $processf_list->fmea->selectOptionListHtml("x{$processf_list->RowIndex}_fmea") ?>
		</select>
</div>
<?php echo $processf_list->fmea->Lookup->getParamTag($processf_list, "p_x" . $processf_list->RowIndex . "_fmea") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_fmea">
<span<?php echo $processf_list->fmea->viewAttributes() ?>><?php echo $processf_list->fmea->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="processf" data-field="x_idProcess" name="x<?php echo $processf_list->RowIndex ?>_idProcess" id="x<?php echo $processf_list->RowIndex ?>_idProcess" value="<?php echo HtmlEncode($processf_list->idProcess->CurrentValue) ?>">
<input type="hidden" data-table="processf" data-field="x_idProcess" name="o<?php echo $processf_list->RowIndex ?>_idProcess" id="o<?php echo $processf_list->RowIndex ?>_idProcess" value="<?php echo HtmlEncode($processf_list->idProcess->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT || $processf->CurrentMode == "edit") { ?>
<input type="hidden" data-table="processf" data-field="x_idProcess" name="x<?php echo $processf_list->RowIndex ?>_idProcess" id="x<?php echo $processf_list->RowIndex ?>_idProcess" value="<?php echo HtmlEncode($processf_list->idProcess->CurrentValue) ?>">
<?php } ?>
	<?php if ($processf_list->step->Visible) { // step ?>
		<td data-name="step" <?php echo $processf_list->step->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_step" class="form-group">
<input type="text" data-table="processf" data-field="x_step" name="x<?php echo $processf_list->RowIndex ?>_step" id="x<?php echo $processf_list->RowIndex ?>_step" size="30" maxlength="6" placeholder="<?php echo HtmlEncode($processf_list->step->getPlaceHolder()) ?>" value="<?php echo $processf_list->step->EditValue ?>"<?php echo $processf_list->step->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_step" name="o<?php echo $processf_list->RowIndex ?>_step" id="o<?php echo $processf_list->RowIndex ?>_step" value="<?php echo HtmlEncode($processf_list->step->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_step" class="form-group">
<input type="text" data-table="processf" data-field="x_step" name="x<?php echo $processf_list->RowIndex ?>_step" id="x<?php echo $processf_list->RowIndex ?>_step" size="30" maxlength="6" placeholder="<?php echo HtmlEncode($processf_list->step->getPlaceHolder()) ?>" value="<?php echo $processf_list->step->EditValue ?>"<?php echo $processf_list->step->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_step">
<span<?php echo $processf_list->step->viewAttributes() ?>><?php echo $processf_list->step->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($processf_list->flowchartDesc->Visible) { // flowchartDesc ?>
		<td data-name="flowchartDesc" <?php echo $processf_list->flowchartDesc->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_flowchartDesc" class="form-group">
<textarea data-table="processf" data-field="x_flowchartDesc" name="x<?php echo $processf_list->RowIndex ?>_flowchartDesc" id="x<?php echo $processf_list->RowIndex ?>_flowchartDesc" cols="35" rows="2" placeholder="<?php echo HtmlEncode($processf_list->flowchartDesc->getPlaceHolder()) ?>"<?php echo $processf_list->flowchartDesc->editAttributes() ?>><?php echo $processf_list->flowchartDesc->EditValue ?></textarea>
</span>
<input type="hidden" data-table="processf" data-field="x_flowchartDesc" name="o<?php echo $processf_list->RowIndex ?>_flowchartDesc" id="o<?php echo $processf_list->RowIndex ?>_flowchartDesc" value="<?php echo HtmlEncode($processf_list->flowchartDesc->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_flowchartDesc" class="form-group">
<textarea data-table="processf" data-field="x_flowchartDesc" name="x<?php echo $processf_list->RowIndex ?>_flowchartDesc" id="x<?php echo $processf_list->RowIndex ?>_flowchartDesc" cols="35" rows="2" placeholder="<?php echo HtmlEncode($processf_list->flowchartDesc->getPlaceHolder()) ?>"<?php echo $processf_list->flowchartDesc->editAttributes() ?>><?php echo $processf_list->flowchartDesc->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_flowchartDesc">
<span<?php echo $processf_list->flowchartDesc->viewAttributes() ?>><?php echo $processf_list->flowchartDesc->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($processf_list->partnumber->Visible) { // partnumber ?>
		<td data-name="partnumber" <?php echo $processf_list->partnumber->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_partnumber" class="form-group">
<input type="text" data-table="processf" data-field="x_partnumber" name="x<?php echo $processf_list->RowIndex ?>_partnumber" id="x<?php echo $processf_list->RowIndex ?>_partnumber" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->partnumber->getPlaceHolder()) ?>" value="<?php echo $processf_list->partnumber->EditValue ?>"<?php echo $processf_list->partnumber->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_partnumber" name="o<?php echo $processf_list->RowIndex ?>_partnumber" id="o<?php echo $processf_list->RowIndex ?>_partnumber" value="<?php echo HtmlEncode($processf_list->partnumber->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_partnumber" class="form-group">
<input type="text" data-table="processf" data-field="x_partnumber" name="x<?php echo $processf_list->RowIndex ?>_partnumber" id="x<?php echo $processf_list->RowIndex ?>_partnumber" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->partnumber->getPlaceHolder()) ?>" value="<?php echo $processf_list->partnumber->EditValue ?>"<?php echo $processf_list->partnumber->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_partnumber">
<span<?php echo $processf_list->partnumber->viewAttributes() ?>><?php echo $processf_list->partnumber->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($processf_list->operation->Visible) { // operation ?>
		<td data-name="operation" <?php echo $processf_list->operation->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_operation" class="form-group">
<input type="text" data-table="processf" data-field="x_operation" name="x<?php echo $processf_list->RowIndex ?>_operation" id="x<?php echo $processf_list->RowIndex ?>_operation" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->operation->getPlaceHolder()) ?>" value="<?php echo $processf_list->operation->EditValue ?>"<?php echo $processf_list->operation->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_operation" name="o<?php echo $processf_list->RowIndex ?>_operation" id="o<?php echo $processf_list->RowIndex ?>_operation" value="<?php echo HtmlEncode($processf_list->operation->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_operation" class="form-group">
<input type="text" data-table="processf" data-field="x_operation" name="x<?php echo $processf_list->RowIndex ?>_operation" id="x<?php echo $processf_list->RowIndex ?>_operation" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->operation->getPlaceHolder()) ?>" value="<?php echo $processf_list->operation->EditValue ?>"<?php echo $processf_list->operation->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_operation">
<span<?php echo $processf_list->operation->viewAttributes() ?>><?php echo $processf_list->operation->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($processf_list->derivedFromNC->Visible) { // derivedFromNC ?>
		<td data-name="derivedFromNC" <?php echo $processf_list->derivedFromNC->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_derivedFromNC" class="form-group">
<?php
$selwrk = ConvertToBool($processf_list->derivedFromNC->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="processf" data-field="x_derivedFromNC" name="x<?php echo $processf_list->RowIndex ?>_derivedFromNC[]" id="x<?php echo $processf_list->RowIndex ?>_derivedFromNC[]" value="1"<?php echo $selwrk ?><?php echo $processf_list->derivedFromNC->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $processf_list->RowIndex ?>_derivedFromNC[]"></label>
</div>
</span>
<input type="hidden" data-table="processf" data-field="x_derivedFromNC" name="o<?php echo $processf_list->RowIndex ?>_derivedFromNC[]" id="o<?php echo $processf_list->RowIndex ?>_derivedFromNC[]" value="<?php echo HtmlEncode($processf_list->derivedFromNC->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_derivedFromNC" class="form-group">
<?php
$selwrk = ConvertToBool($processf_list->derivedFromNC->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="processf" data-field="x_derivedFromNC" name="x<?php echo $processf_list->RowIndex ?>_derivedFromNC[]" id="x<?php echo $processf_list->RowIndex ?>_derivedFromNC[]" value="1"<?php echo $selwrk ?><?php echo $processf_list->derivedFromNC->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $processf_list->RowIndex ?>_derivedFromNC[]"></label>
</div>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_derivedFromNC">
<span<?php echo $processf_list->derivedFromNC->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_derivedFromNC" class="custom-control-input" value="<?php echo $processf_list->derivedFromNC->getViewValue() ?>" disabled<?php if (ConvertToBool($processf_list->derivedFromNC->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_derivedFromNC"></label></div></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($processf_list->numberOfNC->Visible) { // numberOfNC ?>
		<td data-name="numberOfNC" <?php echo $processf_list->numberOfNC->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_numberOfNC" class="form-group">
<input type="text" data-table="processf" data-field="x_numberOfNC" name="x<?php echo $processf_list->RowIndex ?>_numberOfNC" id="x<?php echo $processf_list->RowIndex ?>_numberOfNC" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->numberOfNC->getPlaceHolder()) ?>" value="<?php echo $processf_list->numberOfNC->EditValue ?>"<?php echo $processf_list->numberOfNC->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_numberOfNC" name="o<?php echo $processf_list->RowIndex ?>_numberOfNC" id="o<?php echo $processf_list->RowIndex ?>_numberOfNC" value="<?php echo HtmlEncode($processf_list->numberOfNC->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_numberOfNC" class="form-group">
<input type="text" data-table="processf" data-field="x_numberOfNC" name="x<?php echo $processf_list->RowIndex ?>_numberOfNC" id="x<?php echo $processf_list->RowIndex ?>_numberOfNC" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->numberOfNC->getPlaceHolder()) ?>" value="<?php echo $processf_list->numberOfNC->EditValue ?>"<?php echo $processf_list->numberOfNC->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_numberOfNC">
<span<?php echo $processf_list->numberOfNC->viewAttributes() ?>><?php echo $processf_list->numberOfNC->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($processf_list->flowchart->Visible) { // flowchart ?>
		<td data-name="flowchart" <?php echo $processf_list->flowchart->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_flowchart" class="form-group">
<input type="text" data-table="processf" data-field="x_flowchart" name="x<?php echo $processf_list->RowIndex ?>_flowchart" id="x<?php echo $processf_list->RowIndex ?>_flowchart" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->flowchart->getPlaceHolder()) ?>" value="<?php echo $processf_list->flowchart->EditValue ?>"<?php echo $processf_list->flowchart->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_flowchart" name="o<?php echo $processf_list->RowIndex ?>_flowchart" id="o<?php echo $processf_list->RowIndex ?>_flowchart" value="<?php echo HtmlEncode($processf_list->flowchart->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_flowchart" class="form-group">
<input type="text" data-table="processf" data-field="x_flowchart" name="x<?php echo $processf_list->RowIndex ?>_flowchart" id="x<?php echo $processf_list->RowIndex ?>_flowchart" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->flowchart->getPlaceHolder()) ?>" value="<?php echo $processf_list->flowchart->EditValue ?>"<?php echo $processf_list->flowchart->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_flowchart">
<span<?php echo $processf_list->flowchart->viewAttributes() ?>><?php echo $processf_list->flowchart->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($processf_list->subprocess->Visible) { // subprocess ?>
		<td data-name="subprocess" <?php echo $processf_list->subprocess->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_subprocess" class="form-group">
<input type="text" data-table="processf" data-field="x_subprocess" name="x<?php echo $processf_list->RowIndex ?>_subprocess" id="x<?php echo $processf_list->RowIndex ?>_subprocess" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->subprocess->getPlaceHolder()) ?>" value="<?php echo $processf_list->subprocess->EditValue ?>"<?php echo $processf_list->subprocess->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_subprocess" name="o<?php echo $processf_list->RowIndex ?>_subprocess" id="o<?php echo $processf_list->RowIndex ?>_subprocess" value="<?php echo HtmlEncode($processf_list->subprocess->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_subprocess" class="form-group">
<input type="text" data-table="processf" data-field="x_subprocess" name="x<?php echo $processf_list->RowIndex ?>_subprocess" id="x<?php echo $processf_list->RowIndex ?>_subprocess" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->subprocess->getPlaceHolder()) ?>" value="<?php echo $processf_list->subprocess->EditValue ?>"<?php echo $processf_list->subprocess->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_subprocess">
<span<?php echo $processf_list->subprocess->viewAttributes() ?>><?php echo $processf_list->subprocess->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($processf_list->requirement->Visible) { // requirement ?>
		<td data-name="requirement" <?php echo $processf_list->requirement->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_requirement" class="form-group">
<input type="text" data-table="processf" data-field="x_requirement" name="x<?php echo $processf_list->RowIndex ?>_requirement" id="x<?php echo $processf_list->RowIndex ?>_requirement" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->requirement->getPlaceHolder()) ?>" value="<?php echo $processf_list->requirement->EditValue ?>"<?php echo $processf_list->requirement->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_requirement" name="o<?php echo $processf_list->RowIndex ?>_requirement" id="o<?php echo $processf_list->RowIndex ?>_requirement" value="<?php echo HtmlEncode($processf_list->requirement->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_requirement" class="form-group">
<input type="text" data-table="processf" data-field="x_requirement" name="x<?php echo $processf_list->RowIndex ?>_requirement" id="x<?php echo $processf_list->RowIndex ?>_requirement" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->requirement->getPlaceHolder()) ?>" value="<?php echo $processf_list->requirement->EditValue ?>"<?php echo $processf_list->requirement->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_requirement">
<span<?php echo $processf_list->requirement->viewAttributes() ?>><?php echo $processf_list->requirement->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($processf_list->potencialFailureMode->Visible) { // potencialFailureMode ?>
		<td data-name="potencialFailureMode" <?php echo $processf_list->potencialFailureMode->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_potencialFailureMode" class="form-group">
<input type="text" data-table="processf" data-field="x_potencialFailureMode" name="x<?php echo $processf_list->RowIndex ?>_potencialFailureMode" id="x<?php echo $processf_list->RowIndex ?>_potencialFailureMode" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->potencialFailureMode->getPlaceHolder()) ?>" value="<?php echo $processf_list->potencialFailureMode->EditValue ?>"<?php echo $processf_list->potencialFailureMode->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_potencialFailureMode" name="o<?php echo $processf_list->RowIndex ?>_potencialFailureMode" id="o<?php echo $processf_list->RowIndex ?>_potencialFailureMode" value="<?php echo HtmlEncode($processf_list->potencialFailureMode->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_potencialFailureMode" class="form-group">
<input type="text" data-table="processf" data-field="x_potencialFailureMode" name="x<?php echo $processf_list->RowIndex ?>_potencialFailureMode" id="x<?php echo $processf_list->RowIndex ?>_potencialFailureMode" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->potencialFailureMode->getPlaceHolder()) ?>" value="<?php echo $processf_list->potencialFailureMode->EditValue ?>"<?php echo $processf_list->potencialFailureMode->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_potencialFailureMode">
<span<?php echo $processf_list->potencialFailureMode->viewAttributes() ?>><?php echo $processf_list->potencialFailureMode->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($processf_list->potencialFailurEffect->Visible) { // potencialFailurEffect ?>
		<td data-name="potencialFailurEffect" <?php echo $processf_list->potencialFailurEffect->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_potencialFailurEffect" class="form-group">
<input type="text" data-table="processf" data-field="x_potencialFailurEffect" name="x<?php echo $processf_list->RowIndex ?>_potencialFailurEffect" id="x<?php echo $processf_list->RowIndex ?>_potencialFailurEffect" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->potencialFailurEffect->getPlaceHolder()) ?>" value="<?php echo $processf_list->potencialFailurEffect->EditValue ?>"<?php echo $processf_list->potencialFailurEffect->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_potencialFailurEffect" name="o<?php echo $processf_list->RowIndex ?>_potencialFailurEffect" id="o<?php echo $processf_list->RowIndex ?>_potencialFailurEffect" value="<?php echo HtmlEncode($processf_list->potencialFailurEffect->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_potencialFailurEffect" class="form-group">
<input type="text" data-table="processf" data-field="x_potencialFailurEffect" name="x<?php echo $processf_list->RowIndex ?>_potencialFailurEffect" id="x<?php echo $processf_list->RowIndex ?>_potencialFailurEffect" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->potencialFailurEffect->getPlaceHolder()) ?>" value="<?php echo $processf_list->potencialFailurEffect->EditValue ?>"<?php echo $processf_list->potencialFailurEffect->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_potencialFailurEffect">
<span<?php echo $processf_list->potencialFailurEffect->viewAttributes() ?>><?php echo $processf_list->potencialFailurEffect->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($processf_list->kc->Visible) { // kc ?>
		<td data-name="kc" <?php echo $processf_list->kc->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_kc" class="form-group">
<?php
$selwrk = ConvertToBool($processf_list->kc->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="processf" data-field="x_kc" name="x<?php echo $processf_list->RowIndex ?>_kc[]" id="x<?php echo $processf_list->RowIndex ?>_kc[]" value="1"<?php echo $selwrk ?><?php echo $processf_list->kc->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $processf_list->RowIndex ?>_kc[]"></label>
</div>
</span>
<input type="hidden" data-table="processf" data-field="x_kc" name="o<?php echo $processf_list->RowIndex ?>_kc[]" id="o<?php echo $processf_list->RowIndex ?>_kc[]" value="<?php echo HtmlEncode($processf_list->kc->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_kc" class="form-group">
<?php
$selwrk = ConvertToBool($processf_list->kc->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="processf" data-field="x_kc" name="x<?php echo $processf_list->RowIndex ?>_kc[]" id="x<?php echo $processf_list->RowIndex ?>_kc[]" value="1"<?php echo $selwrk ?><?php echo $processf_list->kc->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $processf_list->RowIndex ?>_kc[]"></label>
</div>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_kc">
<span<?php echo $processf_list->kc->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_kc" class="custom-control-input" value="<?php echo $processf_list->kc->getViewValue() ?>" disabled<?php if (ConvertToBool($processf_list->kc->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_kc"></label></div></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($processf_list->severity->Visible) { // severity ?>
		<td data-name="severity" <?php echo $processf_list->severity->cellAttributes() ?>>
<?php if ($processf->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_severity" class="form-group">
<input type="text" data-table="processf" data-field="x_severity" name="x<?php echo $processf_list->RowIndex ?>_severity" id="x<?php echo $processf_list->RowIndex ?>_severity" size="3" placeholder="<?php echo HtmlEncode($processf_list->severity->getPlaceHolder()) ?>" value="<?php echo $processf_list->severity->EditValue ?>"<?php echo $processf_list->severity->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_severity" name="o<?php echo $processf_list->RowIndex ?>_severity" id="o<?php echo $processf_list->RowIndex ?>_severity" value="<?php echo HtmlEncode($processf_list->severity->OldValue) ?>">
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_severity" class="form-group">
<input type="text" data-table="processf" data-field="x_severity" name="x<?php echo $processf_list->RowIndex ?>_severity" id="x<?php echo $processf_list->RowIndex ?>_severity" size="3" placeholder="<?php echo HtmlEncode($processf_list->severity->getPlaceHolder()) ?>" value="<?php echo $processf_list->severity->EditValue ?>"<?php echo $processf_list->severity->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($processf->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $processf_list->RowCount ?>_processf_severity">
<span<?php echo $processf_list->severity->viewAttributes() ?>><?php echo $processf_list->severity->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$processf_list->ListOptions->render("body", "right", $processf_list->RowCount);
?>
	</tr>
<?php if ($processf->RowType == ROWTYPE_ADD || $processf->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fprocessflist", "load"], function() {
	fprocessflist.updateLists(<?php echo $processf_list->RowIndex ?>);
});
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$processf_list->isGridAdd())
		if (!$processf_list->Recordset->EOF)
			$processf_list->Recordset->moveNext();
}
?>
<?php
	if ($processf_list->isGridAdd() || $processf_list->isGridEdit()) {
		$processf_list->RowIndex = '$rowindex$';
		$processf_list->loadRowValues();

		// Set row properties
		$processf->resetAttributes();
		$processf->RowAttrs->merge(["data-rowindex" => $processf_list->RowIndex, "id" => "r0_processf", "data-rowtype" => ROWTYPE_ADD]);
		$processf->RowAttrs->appendClass("ew-template");
		$processf->RowType = ROWTYPE_ADD;

		// Render row
		$processf_list->renderRow();

		// Render list options
		$processf_list->renderListOptions();
		$processf_list->StartRowCount = 0;
?>
	<tr <?php echo $processf->rowAttributes() ?>>
<?php

// Render list options (body, left)
$processf_list->ListOptions->render("body", "left", $processf_list->RowIndex);
?>
	<?php if ($processf_list->fmea->Visible) { // fmea ?>
		<td data-name="fmea">
<?php if ($processf_list->fmea->getSessionValue() != "") { ?>
<span id="el$rowindex$_processf_fmea" class="form-group processf_fmea">
<span<?php echo $processf_list->fmea->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($processf_list->fmea->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $processf_list->RowIndex ?>_fmea" name="x<?php echo $processf_list->RowIndex ?>_fmea" value="<?php echo HtmlEncode($processf_list->fmea->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_processf_fmea" class="form-group processf_fmea">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="processf" data-field="x_fmea" data-value-separator="<?php echo $processf_list->fmea->displayValueSeparatorAttribute() ?>" id="x<?php echo $processf_list->RowIndex ?>_fmea" name="x<?php echo $processf_list->RowIndex ?>_fmea"<?php echo $processf_list->fmea->editAttributes() ?>>
			<?php echo $processf_list->fmea->selectOptionListHtml("x{$processf_list->RowIndex}_fmea") ?>
		</select>
</div>
<?php echo $processf_list->fmea->Lookup->getParamTag($processf_list, "p_x" . $processf_list->RowIndex . "_fmea") ?>
</span>
<?php } ?>
<input type="hidden" data-table="processf" data-field="x_fmea" name="o<?php echo $processf_list->RowIndex ?>_fmea" id="o<?php echo $processf_list->RowIndex ?>_fmea" value="<?php echo HtmlEncode($processf_list->fmea->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->step->Visible) { // step ?>
		<td data-name="step">
<span id="el$rowindex$_processf_step" class="form-group processf_step">
<input type="text" data-table="processf" data-field="x_step" name="x<?php echo $processf_list->RowIndex ?>_step" id="x<?php echo $processf_list->RowIndex ?>_step" size="30" maxlength="6" placeholder="<?php echo HtmlEncode($processf_list->step->getPlaceHolder()) ?>" value="<?php echo $processf_list->step->EditValue ?>"<?php echo $processf_list->step->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_step" name="o<?php echo $processf_list->RowIndex ?>_step" id="o<?php echo $processf_list->RowIndex ?>_step" value="<?php echo HtmlEncode($processf_list->step->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->flowchartDesc->Visible) { // flowchartDesc ?>
		<td data-name="flowchartDesc">
<span id="el$rowindex$_processf_flowchartDesc" class="form-group processf_flowchartDesc">
<textarea data-table="processf" data-field="x_flowchartDesc" name="x<?php echo $processf_list->RowIndex ?>_flowchartDesc" id="x<?php echo $processf_list->RowIndex ?>_flowchartDesc" cols="35" rows="2" placeholder="<?php echo HtmlEncode($processf_list->flowchartDesc->getPlaceHolder()) ?>"<?php echo $processf_list->flowchartDesc->editAttributes() ?>><?php echo $processf_list->flowchartDesc->EditValue ?></textarea>
</span>
<input type="hidden" data-table="processf" data-field="x_flowchartDesc" name="o<?php echo $processf_list->RowIndex ?>_flowchartDesc" id="o<?php echo $processf_list->RowIndex ?>_flowchartDesc" value="<?php echo HtmlEncode($processf_list->flowchartDesc->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->partnumber->Visible) { // partnumber ?>
		<td data-name="partnumber">
<span id="el$rowindex$_processf_partnumber" class="form-group processf_partnumber">
<input type="text" data-table="processf" data-field="x_partnumber" name="x<?php echo $processf_list->RowIndex ?>_partnumber" id="x<?php echo $processf_list->RowIndex ?>_partnumber" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->partnumber->getPlaceHolder()) ?>" value="<?php echo $processf_list->partnumber->EditValue ?>"<?php echo $processf_list->partnumber->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_partnumber" name="o<?php echo $processf_list->RowIndex ?>_partnumber" id="o<?php echo $processf_list->RowIndex ?>_partnumber" value="<?php echo HtmlEncode($processf_list->partnumber->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->operation->Visible) { // operation ?>
		<td data-name="operation">
<span id="el$rowindex$_processf_operation" class="form-group processf_operation">
<input type="text" data-table="processf" data-field="x_operation" name="x<?php echo $processf_list->RowIndex ?>_operation" id="x<?php echo $processf_list->RowIndex ?>_operation" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->operation->getPlaceHolder()) ?>" value="<?php echo $processf_list->operation->EditValue ?>"<?php echo $processf_list->operation->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_operation" name="o<?php echo $processf_list->RowIndex ?>_operation" id="o<?php echo $processf_list->RowIndex ?>_operation" value="<?php echo HtmlEncode($processf_list->operation->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->derivedFromNC->Visible) { // derivedFromNC ?>
		<td data-name="derivedFromNC">
<span id="el$rowindex$_processf_derivedFromNC" class="form-group processf_derivedFromNC">
<?php
$selwrk = ConvertToBool($processf_list->derivedFromNC->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="processf" data-field="x_derivedFromNC" name="x<?php echo $processf_list->RowIndex ?>_derivedFromNC[]" id="x<?php echo $processf_list->RowIndex ?>_derivedFromNC[]" value="1"<?php echo $selwrk ?><?php echo $processf_list->derivedFromNC->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $processf_list->RowIndex ?>_derivedFromNC[]"></label>
</div>
</span>
<input type="hidden" data-table="processf" data-field="x_derivedFromNC" name="o<?php echo $processf_list->RowIndex ?>_derivedFromNC[]" id="o<?php echo $processf_list->RowIndex ?>_derivedFromNC[]" value="<?php echo HtmlEncode($processf_list->derivedFromNC->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->numberOfNC->Visible) { // numberOfNC ?>
		<td data-name="numberOfNC">
<span id="el$rowindex$_processf_numberOfNC" class="form-group processf_numberOfNC">
<input type="text" data-table="processf" data-field="x_numberOfNC" name="x<?php echo $processf_list->RowIndex ?>_numberOfNC" id="x<?php echo $processf_list->RowIndex ?>_numberOfNC" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->numberOfNC->getPlaceHolder()) ?>" value="<?php echo $processf_list->numberOfNC->EditValue ?>"<?php echo $processf_list->numberOfNC->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_numberOfNC" name="o<?php echo $processf_list->RowIndex ?>_numberOfNC" id="o<?php echo $processf_list->RowIndex ?>_numberOfNC" value="<?php echo HtmlEncode($processf_list->numberOfNC->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->flowchart->Visible) { // flowchart ?>
		<td data-name="flowchart">
<span id="el$rowindex$_processf_flowchart" class="form-group processf_flowchart">
<input type="text" data-table="processf" data-field="x_flowchart" name="x<?php echo $processf_list->RowIndex ?>_flowchart" id="x<?php echo $processf_list->RowIndex ?>_flowchart" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->flowchart->getPlaceHolder()) ?>" value="<?php echo $processf_list->flowchart->EditValue ?>"<?php echo $processf_list->flowchart->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_flowchart" name="o<?php echo $processf_list->RowIndex ?>_flowchart" id="o<?php echo $processf_list->RowIndex ?>_flowchart" value="<?php echo HtmlEncode($processf_list->flowchart->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->subprocess->Visible) { // subprocess ?>
		<td data-name="subprocess">
<span id="el$rowindex$_processf_subprocess" class="form-group processf_subprocess">
<input type="text" data-table="processf" data-field="x_subprocess" name="x<?php echo $processf_list->RowIndex ?>_subprocess" id="x<?php echo $processf_list->RowIndex ?>_subprocess" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->subprocess->getPlaceHolder()) ?>" value="<?php echo $processf_list->subprocess->EditValue ?>"<?php echo $processf_list->subprocess->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_subprocess" name="o<?php echo $processf_list->RowIndex ?>_subprocess" id="o<?php echo $processf_list->RowIndex ?>_subprocess" value="<?php echo HtmlEncode($processf_list->subprocess->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->requirement->Visible) { // requirement ?>
		<td data-name="requirement">
<span id="el$rowindex$_processf_requirement" class="form-group processf_requirement">
<input type="text" data-table="processf" data-field="x_requirement" name="x<?php echo $processf_list->RowIndex ?>_requirement" id="x<?php echo $processf_list->RowIndex ?>_requirement" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->requirement->getPlaceHolder()) ?>" value="<?php echo $processf_list->requirement->EditValue ?>"<?php echo $processf_list->requirement->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_requirement" name="o<?php echo $processf_list->RowIndex ?>_requirement" id="o<?php echo $processf_list->RowIndex ?>_requirement" value="<?php echo HtmlEncode($processf_list->requirement->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->potencialFailureMode->Visible) { // potencialFailureMode ?>
		<td data-name="potencialFailureMode">
<span id="el$rowindex$_processf_potencialFailureMode" class="form-group processf_potencialFailureMode">
<input type="text" data-table="processf" data-field="x_potencialFailureMode" name="x<?php echo $processf_list->RowIndex ?>_potencialFailureMode" id="x<?php echo $processf_list->RowIndex ?>_potencialFailureMode" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->potencialFailureMode->getPlaceHolder()) ?>" value="<?php echo $processf_list->potencialFailureMode->EditValue ?>"<?php echo $processf_list->potencialFailureMode->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_potencialFailureMode" name="o<?php echo $processf_list->RowIndex ?>_potencialFailureMode" id="o<?php echo $processf_list->RowIndex ?>_potencialFailureMode" value="<?php echo HtmlEncode($processf_list->potencialFailureMode->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->potencialFailurEffect->Visible) { // potencialFailurEffect ?>
		<td data-name="potencialFailurEffect">
<span id="el$rowindex$_processf_potencialFailurEffect" class="form-group processf_potencialFailurEffect">
<input type="text" data-table="processf" data-field="x_potencialFailurEffect" name="x<?php echo $processf_list->RowIndex ?>_potencialFailurEffect" id="x<?php echo $processf_list->RowIndex ?>_potencialFailurEffect" size="30" maxlength="255" placeholder="<?php echo HtmlEncode($processf_list->potencialFailurEffect->getPlaceHolder()) ?>" value="<?php echo $processf_list->potencialFailurEffect->EditValue ?>"<?php echo $processf_list->potencialFailurEffect->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_potencialFailurEffect" name="o<?php echo $processf_list->RowIndex ?>_potencialFailurEffect" id="o<?php echo $processf_list->RowIndex ?>_potencialFailurEffect" value="<?php echo HtmlEncode($processf_list->potencialFailurEffect->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->kc->Visible) { // kc ?>
		<td data-name="kc">
<span id="el$rowindex$_processf_kc" class="form-group processf_kc">
<?php
$selwrk = ConvertToBool($processf_list->kc->CurrentValue) ? " checked" : "";
?>
<div class="custom-control custom-checkbox d-inline-block">
	<input type="checkbox" class="custom-control-input" data-table="processf" data-field="x_kc" name="x<?php echo $processf_list->RowIndex ?>_kc[]" id="x<?php echo $processf_list->RowIndex ?>_kc[]" value="1"<?php echo $selwrk ?><?php echo $processf_list->kc->editAttributes() ?>>
	<label class="custom-control-label" for="x<?php echo $processf_list->RowIndex ?>_kc[]"></label>
</div>
</span>
<input type="hidden" data-table="processf" data-field="x_kc" name="o<?php echo $processf_list->RowIndex ?>_kc[]" id="o<?php echo $processf_list->RowIndex ?>_kc[]" value="<?php echo HtmlEncode($processf_list->kc->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($processf_list->severity->Visible) { // severity ?>
		<td data-name="severity">
<span id="el$rowindex$_processf_severity" class="form-group processf_severity">
<input type="text" data-table="processf" data-field="x_severity" name="x<?php echo $processf_list->RowIndex ?>_severity" id="x<?php echo $processf_list->RowIndex ?>_severity" size="3" placeholder="<?php echo HtmlEncode($processf_list->severity->getPlaceHolder()) ?>" value="<?php echo $processf_list->severity->EditValue ?>"<?php echo $processf_list->severity->editAttributes() ?>>
</span>
<input type="hidden" data-table="processf" data-field="x_severity" name="o<?php echo $processf_list->RowIndex ?>_severity" id="o<?php echo $processf_list->RowIndex ?>_severity" value="<?php echo HtmlEncode($processf_list->severity->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$processf_list->ListOptions->render("body", "right", $processf_list->RowIndex);
?>
<script>
loadjs.ready(["fprocessflist", "load"], function() {
	fprocessflist.updateLists(<?php echo $processf_list->RowIndex ?>);
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
<?php if ($processf_list->isAdd() || $processf_list->isCopy()) { ?>
<input type="hidden" name="<?php echo $processf_list->FormKeyCountName ?>" id="<?php echo $processf_list->FormKeyCountName ?>" value="<?php echo $processf_list->KeyCount ?>">
<?php } ?>
<?php if ($processf_list->isGridEdit()) { ?>
<?php if ($processf->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="action" id="action" value="gridoverwrite">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<?php } ?>
<input type="hidden" name="<?php echo $processf_list->FormKeyCountName ?>" id="<?php echo $processf_list->FormKeyCountName ?>" value="<?php echo $processf_list->KeyCount ?>">
<?php echo $processf_list->MultiSelectKey ?>
<?php } ?>
<?php if (!$processf->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($processf_list->Recordset)
	$processf_list->Recordset->Close();
?>
<?php if (!$processf_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$processf_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $processf_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $processf_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($processf_list->TotalRecords == 0 && !$processf->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $processf_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$processf_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$processf_list->isExport()) { ?>
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
$processf_list->terminate();
?>