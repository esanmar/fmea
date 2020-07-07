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
$occurrence_view = new occurrence_view();

// Run the page
$occurrence_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$occurrence_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$occurrence_view->isExport()) { ?>
<script>
var foccurrenceview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	foccurrenceview = currentForm = new ew.Form("foccurrenceview", "view");
	loadjs.done("foccurrenceview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$occurrence_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $occurrence_view->ExportOptions->render("body") ?>
<?php $occurrence_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $occurrence_view->showPageHeader(); ?>
<?php
$occurrence_view->showMessage();
?>
<?php if (!$occurrence_view->IsModal) { ?>
<?php if (!$occurrence_view->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $occurrence_view->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="foccurrenceview" id="foccurrenceview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="occurrence">
<input type="hidden" name="modal" value="<?php echo (int)$occurrence_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($occurrence_view->idOccurrence->Visible) { // idOccurrence ?>
	<tr id="r_idOccurrence">
		<td class="<?php echo $occurrence_view->TableLeftColumnClass ?>"><span id="elh_occurrence_idOccurrence"><?php echo $occurrence_view->idOccurrence->caption() ?></span></td>
		<td data-name="idOccurrence" <?php echo $occurrence_view->idOccurrence->cellAttributes() ?>>
<span id="el_occurrence_idOccurrence">
<span<?php echo $occurrence_view->idOccurrence->viewAttributes() ?>><?php echo $occurrence_view->idOccurrence->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($occurrence_view->probability->Visible) { // probability ?>
	<tr id="r_probability">
		<td class="<?php echo $occurrence_view->TableLeftColumnClass ?>"><span id="elh_occurrence_probability"><?php echo $occurrence_view->probability->caption() ?></span></td>
		<td data-name="probability" <?php echo $occurrence_view->probability->cellAttributes() ?>>
<span id="el_occurrence_probability">
<span<?php echo $occurrence_view->probability->viewAttributes() ?>><?php echo $occurrence_view->probability->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($occurrence_view->description->Visible) { // description ?>
	<tr id="r_description">
		<td class="<?php echo $occurrence_view->TableLeftColumnClass ?>"><span id="elh_occurrence_description"><?php echo $occurrence_view->description->caption() ?></span></td>
		<td data-name="description" <?php echo $occurrence_view->description->cellAttributes() ?>>
<span id="el_occurrence_description">
<span<?php echo $occurrence_view->description->viewAttributes() ?>><?php echo $occurrence_view->description->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($occurrence_view->likelihood->Visible) { // likelihood ?>
	<tr id="r_likelihood">
		<td class="<?php echo $occurrence_view->TableLeftColumnClass ?>"><span id="elh_occurrence_likelihood"><?php echo $occurrence_view->likelihood->caption() ?></span></td>
		<td data-name="likelihood" <?php echo $occurrence_view->likelihood->cellAttributes() ?>>
<span id="el_occurrence_likelihood">
<span<?php echo $occurrence_view->likelihood->viewAttributes() ?>><?php echo $occurrence_view->likelihood->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($occurrence_view->timebased->Visible) { // timebased ?>
	<tr id="r_timebased">
		<td class="<?php echo $occurrence_view->TableLeftColumnClass ?>"><span id="elh_occurrence_timebased"><?php echo $occurrence_view->timebased->caption() ?></span></td>
		<td data-name="timebased" <?php echo $occurrence_view->timebased->cellAttributes() ?>>
<span id="el_occurrence_timebased">
<span<?php echo $occurrence_view->timebased->viewAttributes() ?>><?php echo $occurrence_view->timebased->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($occurrence_view->color->Visible) { // color ?>
	<tr id="r_color">
		<td class="<?php echo $occurrence_view->TableLeftColumnClass ?>"><span id="elh_occurrence_color"><?php echo $occurrence_view->color->caption() ?></span></td>
		<td data-name="color" <?php echo $occurrence_view->color->cellAttributes() ?>>
<span id="el_occurrence_color">
<span<?php echo $occurrence_view->color->viewAttributes() ?>><?php echo $occurrence_view->color->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$occurrence_view->IsModal) { ?>
<?php if (!$occurrence_view->isExport()) { ?>
<?php echo $occurrence_view->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
</form>
<?php
$occurrence_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$occurrence_view->isExport()) { ?>
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
$occurrence_view->terminate();
?>