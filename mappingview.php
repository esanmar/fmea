<?php
namespace PHPMaker2020\SupplierMapping;

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
$mapping_view = new mapping_view();

// Run the page
$mapping_view->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$mapping_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$mapping_view->isExport()) { ?>
<script>
var fmappingview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	fmappingview = currentForm = new ew.Form("fmappingview", "view");
	loadjs.done("fmappingview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$mapping_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $mapping_view->ExportOptions->render("body") ?>
<?php $mapping_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $mapping_view->showPageHeader(); ?>
<?php
$mapping_view->showMessage();
?>
<?php if (!$mapping_view->IsModal) { ?>
<?php if (!$mapping_view->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $mapping_view->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="fmappingview" id="fmappingview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="mapping">
<input type="hidden" name="modal" value="<?php echo (int)$mapping_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($mapping_view->idProcess->Visible) { // idProcess ?>
	<tr id="r_idProcess">
		<td class="<?php echo $mapping_view->TableLeftColumnClass ?>"><span id="elh_mapping_idProcess"><?php echo $mapping_view->idProcess->caption() ?></span></td>
		<td data-name="idProcess" <?php echo $mapping_view->idProcess->cellAttributes() ?>>
<span id="el_mapping_idProcess">
<span<?php echo $mapping_view->idProcess->viewAttributes() ?>><?php echo $mapping_view->idProcess->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($mapping_view->process->Visible) { // process ?>
	<tr id="r_process">
		<td class="<?php echo $mapping_view->TableLeftColumnClass ?>"><span id="elh_mapping_process"><?php echo $mapping_view->process->caption() ?></span></td>
		<td data-name="process" <?php echo $mapping_view->process->cellAttributes() ?>>
<span id="el_mapping_process">
<span<?php echo $mapping_view->process->viewAttributes() ?>><?php echo $mapping_view->process->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($mapping_view->regulation->Visible) { // regulation ?>
	<tr id="r_regulation">
		<td class="<?php echo $mapping_view->TableLeftColumnClass ?>"><span id="elh_mapping_regulation"><?php echo $mapping_view->regulation->caption() ?></span></td>
		<td data-name="regulation" <?php echo $mapping_view->regulation->cellAttributes() ?>>
<span id="el_mapping_regulation">
<span<?php echo $mapping_view->regulation->viewAttributes() ?>><?php echo $mapping_view->regulation->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($mapping_view->qualification->Visible) { // qualification ?>
	<tr id="r_qualification">
		<td class="<?php echo $mapping_view->TableLeftColumnClass ?>"><span id="elh_mapping_qualification"><?php echo $mapping_view->qualification->caption() ?></span></td>
		<td data-name="qualification" <?php echo $mapping_view->qualification->cellAttributes() ?>>
<span id="el_mapping_qualification">
<span<?php echo $mapping_view->qualification->viewAttributes() ?>><?php echo $mapping_view->qualification->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($mapping_view->supplierLevel2->Visible) { // supplierLevel2 ?>
	<tr id="r_supplierLevel2">
		<td class="<?php echo $mapping_view->TableLeftColumnClass ?>"><span id="elh_mapping_supplierLevel2"><?php echo $mapping_view->supplierLevel2->caption() ?></span></td>
		<td data-name="supplierLevel2" <?php echo $mapping_view->supplierLevel2->cellAttributes() ?>>
<span id="el_mapping_supplierLevel2">
<span<?php echo $mapping_view->supplierLevel2->viewAttributes() ?>><?php echo $mapping_view->supplierLevel2->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($mapping_view->supplierLevel3->Visible) { // supplierLevel3 ?>
	<tr id="r_supplierLevel3">
		<td class="<?php echo $mapping_view->TableLeftColumnClass ?>"><span id="elh_mapping_supplierLevel3"><?php echo $mapping_view->supplierLevel3->caption() ?></span></td>
		<td data-name="supplierLevel3" <?php echo $mapping_view->supplierLevel3->cellAttributes() ?>>
<span id="el_mapping_supplierLevel3">
<span<?php echo $mapping_view->supplierLevel3->viewAttributes() ?>><?php echo $mapping_view->supplierLevel3->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$mapping_view->IsModal) { ?>
<?php if (!$mapping_view->isExport()) { ?>
<?php echo $mapping_view->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
</form>
<?php
$mapping_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$mapping_view->isExport()) { ?>
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
$mapping_view->terminate();
?>