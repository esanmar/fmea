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
$suppliers_view = new suppliers_view();

// Run the page
$suppliers_view->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$suppliers_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$suppliers_view->isExport()) { ?>
<script>
var fsuppliersview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	fsuppliersview = currentForm = new ew.Form("fsuppliersview", "view");
	loadjs.done("fsuppliersview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$suppliers_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $suppliers_view->ExportOptions->render("body") ?>
<?php $suppliers_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $suppliers_view->showPageHeader(); ?>
<?php
$suppliers_view->showMessage();
?>
<?php if (!$suppliers_view->IsModal) { ?>
<?php if (!$suppliers_view->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $suppliers_view->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="fsuppliersview" id="fsuppliersview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="suppliers">
<input type="hidden" name="modal" value="<?php echo (int)$suppliers_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($suppliers_view->supplier->Visible) { // supplier ?>
	<tr id="r_supplier">
		<td class="<?php echo $suppliers_view->TableLeftColumnClass ?>"><span id="elh_suppliers_supplier"><?php echo $suppliers_view->supplier->caption() ?></span></td>
		<td data-name="supplier" <?php echo $suppliers_view->supplier->cellAttributes() ?>>
<span id="el_suppliers_supplier">
<span<?php echo $suppliers_view->supplier->viewAttributes() ?>><?php echo $suppliers_view->supplier->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$suppliers_view->IsModal) { ?>
<?php if (!$suppliers_view->isExport()) { ?>
<?php echo $suppliers_view->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
</form>
<?php
$suppliers_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$suppliers_view->isExport()) { ?>
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
$suppliers_view->terminate();
?>