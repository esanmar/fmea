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
$factories_view = new factories_view();

// Run the page
$factories_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$factories_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$factories_view->isExport()) { ?>
<script>
var ffactoriesview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	ffactoriesview = currentForm = new ew.Form("ffactoriesview", "view");
	loadjs.done("ffactoriesview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$factories_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $factories_view->ExportOptions->render("body") ?>
<?php $factories_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $factories_view->showPageHeader(); ?>
<?php
$factories_view->showMessage();
?>
<?php if (!$factories_view->IsModal) { ?>
<?php if (!$factories_view->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $factories_view->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="ffactoriesview" id="ffactoriesview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="factories">
<input type="hidden" name="modal" value="<?php echo (int)$factories_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($factories_view->idFactory->Visible) { // idFactory ?>
	<tr id="r_idFactory">
		<td class="<?php echo $factories_view->TableLeftColumnClass ?>"><span id="elh_factories_idFactory"><?php echo $factories_view->idFactory->caption() ?></span></td>
		<td data-name="idFactory" <?php echo $factories_view->idFactory->cellAttributes() ?>>
<span id="el_factories_idFactory">
<span<?php echo $factories_view->idFactory->viewAttributes() ?>><?php echo $factories_view->idFactory->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($factories_view->factory->Visible) { // factory ?>
	<tr id="r_factory">
		<td class="<?php echo $factories_view->TableLeftColumnClass ?>"><span id="elh_factories_factory"><?php echo $factories_view->factory->caption() ?></span></td>
		<td data-name="factory" <?php echo $factories_view->factory->cellAttributes() ?>>
<span id="el_factories_factory">
<span<?php echo $factories_view->factory->viewAttributes() ?>><?php echo $factories_view->factory->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$factories_view->IsModal) { ?>
<?php if (!$factories_view->isExport()) { ?>
<?php echo $factories_view->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
</form>
<?php
$factories_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$factories_view->isExport()) { ?>
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
$factories_view->terminate();
?>