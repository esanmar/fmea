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
$fmea_view = new fmea_view();

// Run the page
$fmea_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$fmea_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$fmea_view->isExport()) { ?>
<script>
var ffmeaview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	ffmeaview = currentForm = new ew.Form("ffmeaview", "view");
	loadjs.done("ffmeaview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$fmea_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $fmea_view->ExportOptions->render("body") ?>
<?php $fmea_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $fmea_view->showPageHeader(); ?>
<?php
$fmea_view->showMessage();
?>
<?php if (!$fmea_view->IsModal) { ?>
<?php if (!$fmea_view->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $fmea_view->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="ffmeaview" id="ffmeaview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="fmea">
<input type="hidden" name="modal" value="<?php echo (int)$fmea_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($fmea_view->fmea->Visible) { // fmea ?>
	<tr id="r_fmea">
		<td class="<?php echo $fmea_view->TableLeftColumnClass ?>"><span id="elh_fmea_fmea"><?php echo $fmea_view->fmea->caption() ?></span></td>
		<td data-name="fmea" <?php echo $fmea_view->fmea->cellAttributes() ?>>
<span id="el_fmea_fmea">
<span<?php echo $fmea_view->fmea->viewAttributes() ?>><?php echo $fmea_view->fmea->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($fmea_view->idFactory->Visible) { // idFactory ?>
	<tr id="r_idFactory">
		<td class="<?php echo $fmea_view->TableLeftColumnClass ?>"><span id="elh_fmea_idFactory"><?php echo $fmea_view->idFactory->caption() ?></span></td>
		<td data-name="idFactory" <?php echo $fmea_view->idFactory->cellAttributes() ?>>
<span id="el_fmea_idFactory">
<span<?php echo $fmea_view->idFactory->viewAttributes() ?>><?php echo $fmea_view->idFactory->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($fmea_view->dateFmea->Visible) { // dateFmea ?>
	<tr id="r_dateFmea">
		<td class="<?php echo $fmea_view->TableLeftColumnClass ?>"><span id="elh_fmea_dateFmea"><?php echo $fmea_view->dateFmea->caption() ?></span></td>
		<td data-name="dateFmea" <?php echo $fmea_view->dateFmea->cellAttributes() ?>>
<span id="el_fmea_dateFmea">
<span<?php echo $fmea_view->dateFmea->viewAttributes() ?>><?php echo $fmea_view->dateFmea->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($fmea_view->partnumbers->Visible) { // partnumbers ?>
	<tr id="r_partnumbers">
		<td class="<?php echo $fmea_view->TableLeftColumnClass ?>"><span id="elh_fmea_partnumbers"><?php echo $fmea_view->partnumbers->caption() ?></span></td>
		<td data-name="partnumbers" <?php echo $fmea_view->partnumbers->cellAttributes() ?>>
<span id="el_fmea_partnumbers">
<span<?php echo $fmea_view->partnumbers->viewAttributes() ?>><?php echo $fmea_view->partnumbers->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($fmea_view->description->Visible) { // description ?>
	<tr id="r_description">
		<td class="<?php echo $fmea_view->TableLeftColumnClass ?>"><span id="elh_fmea_description"><?php echo $fmea_view->description->caption() ?></span></td>
		<td data-name="description" <?php echo $fmea_view->description->cellAttributes() ?>>
<span id="el_fmea_description">
<span<?php echo $fmea_view->description->viewAttributes() ?>><?php echo $fmea_view->description->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($fmea_view->idEmployee->Visible) { // idEmployee ?>
	<tr id="r_idEmployee">
		<td class="<?php echo $fmea_view->TableLeftColumnClass ?>"><span id="elh_fmea_idEmployee"><?php echo $fmea_view->idEmployee->caption() ?></span></td>
		<td data-name="idEmployee" <?php echo $fmea_view->idEmployee->cellAttributes() ?>>
<span id="el_fmea_idEmployee">
<span<?php echo $fmea_view->idEmployee->viewAttributes() ?>><?php echo $fmea_view->idEmployee->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($fmea_view->idworkcenter->Visible) { // idworkcenter ?>
	<tr id="r_idworkcenter">
		<td class="<?php echo $fmea_view->TableLeftColumnClass ?>"><span id="elh_fmea_idworkcenter"><?php echo $fmea_view->idworkcenter->caption() ?></span></td>
		<td data-name="idworkcenter" <?php echo $fmea_view->idworkcenter->cellAttributes() ?>>
<span id="el_fmea_idworkcenter">
<span<?php echo $fmea_view->idworkcenter->viewAttributes() ?>><?php echo $fmea_view->idworkcenter->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$fmea_view->IsModal) { ?>
<?php if (!$fmea_view->isExport()) { ?>
<?php echo $fmea_view->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
<?php if ($fmea->getCurrentDetailTable() != "") { ?>
<?php
	$fmea_view->DetailPages->ValidKeys = explode(",", $fmea->getCurrentDetailTable());
	$firstActiveDetailTable = $fmea_view->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav-tabs" id="fmea_view_details"><!-- tabs -->
	<ul class="<?php echo $fmea_view->DetailPages->navStyle() ?>"><!-- .nav -->
<?php
	if (in_array("processf", explode(",", $fmea->getCurrentDetailTable())) && $processf->DetailView) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "processf") {
			$firstActiveDetailTable = "processf";
		}
?>
		<li class="nav-item"><a class="nav-link <?php echo $fmea_view->DetailPages->pageStyle("processf") ?>" href="#tab_processf" data-toggle="tab"><?php echo $Language->tablePhrase("processf", "TblCaption") ?>&nbsp;<?php echo str_replace("%c", $fmea_view->processf_Count, $Language->phrase("DetailCount")) ?></a></li>
<?php
	}
?>
<?php
	if (in_array("issue", explode(",", $fmea->getCurrentDetailTable())) && $issue->DetailView) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "issue") {
			$firstActiveDetailTable = "issue";
		}
?>
		<li class="nav-item"><a class="nav-link <?php echo $fmea_view->DetailPages->pageStyle("issue") ?>" href="#tab_issue" data-toggle="tab"><?php echo $Language->tablePhrase("issue", "TblCaption") ?>&nbsp;<?php echo str_replace("%c", $fmea_view->issue_Count, $Language->phrase("DetailCount")) ?></a></li>
<?php
	}
?>
	</ul><!-- /.nav -->
	<div class="tab-content"><!-- .tab-content -->
<?php
	if (in_array("processf", explode(",", $fmea->getCurrentDetailTable())) && $processf->DetailView) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "processf")
			$firstActiveDetailTable = "processf";
?>
		<div class="tab-pane <?php echo $fmea_view->DetailPages->pageStyle("processf") ?>" id="tab_processf"><!-- page* -->
<?php include_once "processfgrid.php" ?>
		</div><!-- /page* -->
<?php } ?>
<?php
	if (in_array("issue", explode(",", $fmea->getCurrentDetailTable())) && $issue->DetailView) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "issue")
			$firstActiveDetailTable = "issue";
?>
		<div class="tab-pane <?php echo $fmea_view->DetailPages->pageStyle("issue") ?>" id="tab_issue"><!-- page* -->
<?php include_once "issuegrid.php" ?>
		</div><!-- /page* -->
<?php } ?>
	</div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
<?php } ?>
</form>
<?php
$fmea_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$fmea_view->isExport()) { ?>
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
$fmea_view->terminate();
?>