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
$issue_view = new issue_view();

// Run the page
$issue_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$issue_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$issue_view->isExport()) { ?>
<script>
var fissueview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	fissueview = currentForm = new ew.Form("fissueview", "view");
	loadjs.done("fissueview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$issue_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $issue_view->ExportOptions->render("body") ?>
<?php $issue_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $issue_view->showPageHeader(); ?>
<?php
$issue_view->showMessage();
?>
<?php if (!$issue_view->IsModal) { ?>
<?php if (!$issue_view->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $issue_view->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="fissueview" id="fissueview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="issue">
<input type="hidden" name="modal" value="<?php echo (int)$issue_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($issue_view->fmea->Visible) { // fmea ?>
	<tr id="r_fmea">
		<td class="<?php echo $issue_view->TableLeftColumnClass ?>"><span id="elh_issue_fmea"><?php echo $issue_view->fmea->caption() ?></span></td>
		<td data-name="fmea" <?php echo $issue_view->fmea->cellAttributes() ?>>
<span id="el_issue_fmea">
<span<?php echo $issue_view->fmea->viewAttributes() ?>><?php echo $issue_view->fmea->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($issue_view->issue->Visible) { // issue ?>
	<tr id="r_issue">
		<td class="<?php echo $issue_view->TableLeftColumnClass ?>"><span id="elh_issue_issue"><?php echo $issue_view->issue->caption() ?></span></td>
		<td data-name="issue" <?php echo $issue_view->issue->cellAttributes() ?>>
<span id="el_issue_issue">
<span<?php echo $issue_view->issue->viewAttributes() ?>><?php echo $issue_view->issue->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($issue_view->date->Visible) { // date ?>
	<tr id="r_date">
		<td class="<?php echo $issue_view->TableLeftColumnClass ?>"><span id="elh_issue_date"><?php echo $issue_view->date->caption() ?></span></td>
		<td data-name="date" <?php echo $issue_view->date->cellAttributes() ?>>
<span id="el_issue_date">
<span<?php echo $issue_view->date->viewAttributes() ?>><?php echo $issue_view->date->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($issue_view->cause->Visible) { // cause ?>
	<tr id="r_cause">
		<td class="<?php echo $issue_view->TableLeftColumnClass ?>"><span id="elh_issue_cause"><?php echo $issue_view->cause->caption() ?></span></td>
		<td data-name="cause" <?php echo $issue_view->cause->cellAttributes() ?>>
<span id="el_issue_cause">
<span<?php echo $issue_view->cause->viewAttributes() ?>><?php echo $issue_view->cause->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($issue_view->leader->Visible) { // leader ?>
	<tr id="r_leader">
		<td class="<?php echo $issue_view->TableLeftColumnClass ?>"><span id="elh_issue_leader"><?php echo $issue_view->leader->caption() ?></span></td>
		<td data-name="leader" <?php echo $issue_view->leader->cellAttributes() ?>>
<span id="el_issue_leader">
<span<?php echo $issue_view->leader->viewAttributes() ?>><?php echo $issue_view->leader->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($issue_view->employee->Visible) { // employee ?>
	<tr id="r_employee">
		<td class="<?php echo $issue_view->TableLeftColumnClass ?>"><span id="elh_issue_employee"><?php echo $issue_view->employee->caption() ?></span></td>
		<td data-name="employee" <?php echo $issue_view->employee->cellAttributes() ?>>
<span id="el_issue_employee">
<span<?php echo $issue_view->employee->viewAttributes() ?>><?php echo $issue_view->employee->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$issue_view->IsModal) { ?>
<?php if (!$issue_view->isExport()) { ?>
<?php echo $issue_view->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
</form>
<?php
$issue_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$issue_view->isExport()) { ?>
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
$issue_view->terminate();
?>