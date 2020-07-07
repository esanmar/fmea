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
$regulations_view = new regulations_view();

// Run the page
$regulations_view->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$regulations_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$regulations_view->isExport()) { ?>
<script>
var fregulationsview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	fregulationsview = currentForm = new ew.Form("fregulationsview", "view");
	loadjs.done("fregulationsview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$regulations_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $regulations_view->ExportOptions->render("body") ?>
<?php $regulations_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $regulations_view->showPageHeader(); ?>
<?php
$regulations_view->showMessage();
?>
<?php if (!$regulations_view->IsModal) { ?>
<?php if (!$regulations_view->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $regulations_view->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="fregulationsview" id="fregulationsview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="regulations">
<input type="hidden" name="modal" value="<?php echo (int)$regulations_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($regulations_view->regulation->Visible) { // regulation ?>
	<tr id="r_regulation">
		<td class="<?php echo $regulations_view->TableLeftColumnClass ?>"><span id="elh_regulations_regulation"><?php echo $regulations_view->regulation->caption() ?></span></td>
		<td data-name="regulation" <?php echo $regulations_view->regulation->cellAttributes() ?>>
<span id="el_regulations_regulation">
<span<?php echo $regulations_view->regulation->viewAttributes() ?>><?php echo $regulations_view->regulation->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$regulations_view->IsModal) { ?>
<?php if (!$regulations_view->isExport()) { ?>
<?php echo $regulations_view->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
</form>
<?php
$regulations_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$regulations_view->isExport()) { ?>
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
$regulations_view->terminate();
?>