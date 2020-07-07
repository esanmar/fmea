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
$employees_view = new employees_view();

// Run the page
$employees_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$employees_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$employees_view->isExport()) { ?>
<script>
var femployeesview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	femployeesview = currentForm = new ew.Form("femployeesview", "view");
	loadjs.done("femployeesview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$employees_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $employees_view->ExportOptions->render("body") ?>
<?php $employees_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $employees_view->showPageHeader(); ?>
<?php
$employees_view->showMessage();
?>
<?php if (!$employees_view->IsModal) { ?>
<?php if (!$employees_view->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $employees_view->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="femployeesview" id="femployeesview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="employees">
<input type="hidden" name="modal" value="<?php echo (int)$employees_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($employees_view->idEmployee->Visible) { // idEmployee ?>
	<tr id="r_idEmployee">
		<td class="<?php echo $employees_view->TableLeftColumnClass ?>"><span id="elh_employees_idEmployee"><?php echo $employees_view->idEmployee->caption() ?></span></td>
		<td data-name="idEmployee" <?php echo $employees_view->idEmployee->cellAttributes() ?>>
<span id="el_employees_idEmployee">
<span<?php echo $employees_view->idEmployee->viewAttributes() ?>><?php echo $employees_view->idEmployee->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($employees_view->name->Visible) { // name ?>
	<tr id="r_name">
		<td class="<?php echo $employees_view->TableLeftColumnClass ?>"><span id="elh_employees_name"><?php echo $employees_view->name->caption() ?></span></td>
		<td data-name="name" <?php echo $employees_view->name->cellAttributes() ?>>
<span id="el_employees_name">
<span<?php echo $employees_view->name->viewAttributes() ?>><?php echo $employees_view->name->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($employees_view->surname->Visible) { // surname ?>
	<tr id="r_surname">
		<td class="<?php echo $employees_view->TableLeftColumnClass ?>"><span id="elh_employees_surname"><?php echo $employees_view->surname->caption() ?></span></td>
		<td data-name="surname" <?php echo $employees_view->surname->cellAttributes() ?>>
<span id="el_employees_surname">
<span<?php echo $employees_view->surname->viewAttributes() ?>><?php echo $employees_view->surname->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($employees_view->idFactory->Visible) { // idFactory ?>
	<tr id="r_idFactory">
		<td class="<?php echo $employees_view->TableLeftColumnClass ?>"><span id="elh_employees_idFactory"><?php echo $employees_view->idFactory->caption() ?></span></td>
		<td data-name="idFactory" <?php echo $employees_view->idFactory->cellAttributes() ?>>
<span id="el_employees_idFactory">
<span<?php echo $employees_view->idFactory->viewAttributes() ?>><?php echo $employees_view->idFactory->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($employees_view->userlevel->Visible) { // userlevel ?>
	<tr id="r_userlevel">
		<td class="<?php echo $employees_view->TableLeftColumnClass ?>"><span id="elh_employees_userlevel"><?php echo $employees_view->userlevel->caption() ?></span></td>
		<td data-name="userlevel" <?php echo $employees_view->userlevel->cellAttributes() ?>>
<span id="el_employees_userlevel">
<span<?php echo $employees_view->userlevel->viewAttributes() ?>><?php echo $employees_view->userlevel->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($employees_view->password->Visible) { // password ?>
	<tr id="r_password">
		<td class="<?php echo $employees_view->TableLeftColumnClass ?>"><span id="elh_employees_password"><?php echo $employees_view->password->caption() ?></span></td>
		<td data-name="password" <?php echo $employees_view->password->cellAttributes() ?>>
<span id="el_employees_password">
<span<?php echo $employees_view->password->viewAttributes() ?>><?php echo $employees_view->password->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($employees_view->workcenter->Visible) { // workcenter ?>
	<tr id="r_workcenter">
		<td class="<?php echo $employees_view->TableLeftColumnClass ?>"><span id="elh_employees_workcenter"><?php echo $employees_view->workcenter->caption() ?></span></td>
		<td data-name="workcenter" <?php echo $employees_view->workcenter->cellAttributes() ?>>
<span id="el_employees_workcenter">
<span<?php echo $employees_view->workcenter->viewAttributes() ?>><?php echo $employees_view->workcenter->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$employees_view->IsModal) { ?>
<?php if (!$employees_view->isExport()) { ?>
<?php echo $employees_view->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
</form>
<?php
$employees_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$employees_view->isExport()) { ?>
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
$employees_view->terminate();
?>