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
$occurrence_delete = new occurrence_delete();

// Run the page
$occurrence_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$occurrence_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var foccurrencedelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	foccurrencedelete = currentForm = new ew.Form("foccurrencedelete", "delete");
	loadjs.done("foccurrencedelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $occurrence_delete->showPageHeader(); ?>
<?php
$occurrence_delete->showMessage();
?>
<form name="foccurrencedelete" id="foccurrencedelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="occurrence">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($occurrence_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($occurrence_delete->idOccurrence->Visible) { // idOccurrence ?>
		<th class="<?php echo $occurrence_delete->idOccurrence->headerCellClass() ?>"><span id="elh_occurrence_idOccurrence" class="occurrence_idOccurrence"><?php echo $occurrence_delete->idOccurrence->caption() ?></span></th>
<?php } ?>
<?php if ($occurrence_delete->probability->Visible) { // probability ?>
		<th class="<?php echo $occurrence_delete->probability->headerCellClass() ?>"><span id="elh_occurrence_probability" class="occurrence_probability"><?php echo $occurrence_delete->probability->caption() ?></span></th>
<?php } ?>
<?php if ($occurrence_delete->description->Visible) { // description ?>
		<th class="<?php echo $occurrence_delete->description->headerCellClass() ?>"><span id="elh_occurrence_description" class="occurrence_description"><?php echo $occurrence_delete->description->caption() ?></span></th>
<?php } ?>
<?php if ($occurrence_delete->likelihood->Visible) { // likelihood ?>
		<th class="<?php echo $occurrence_delete->likelihood->headerCellClass() ?>"><span id="elh_occurrence_likelihood" class="occurrence_likelihood"><?php echo $occurrence_delete->likelihood->caption() ?></span></th>
<?php } ?>
<?php if ($occurrence_delete->timebased->Visible) { // timebased ?>
		<th class="<?php echo $occurrence_delete->timebased->headerCellClass() ?>"><span id="elh_occurrence_timebased" class="occurrence_timebased"><?php echo $occurrence_delete->timebased->caption() ?></span></th>
<?php } ?>
<?php if ($occurrence_delete->color->Visible) { // color ?>
		<th class="<?php echo $occurrence_delete->color->headerCellClass() ?>"><span id="elh_occurrence_color" class="occurrence_color"><?php echo $occurrence_delete->color->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$occurrence_delete->RecordCount = 0;
$i = 0;
while (!$occurrence_delete->Recordset->EOF) {
	$occurrence_delete->RecordCount++;
	$occurrence_delete->RowCount++;

	// Set row properties
	$occurrence->resetAttributes();
	$occurrence->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$occurrence_delete->loadRowValues($occurrence_delete->Recordset);

	// Render row
	$occurrence_delete->renderRow();
?>
	<tr <?php echo $occurrence->rowAttributes() ?>>
<?php if ($occurrence_delete->idOccurrence->Visible) { // idOccurrence ?>
		<td <?php echo $occurrence_delete->idOccurrence->cellAttributes() ?>>
<span id="el<?php echo $occurrence_delete->RowCount ?>_occurrence_idOccurrence" class="occurrence_idOccurrence">
<span<?php echo $occurrence_delete->idOccurrence->viewAttributes() ?>><?php echo $occurrence_delete->idOccurrence->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($occurrence_delete->probability->Visible) { // probability ?>
		<td <?php echo $occurrence_delete->probability->cellAttributes() ?>>
<span id="el<?php echo $occurrence_delete->RowCount ?>_occurrence_probability" class="occurrence_probability">
<span<?php echo $occurrence_delete->probability->viewAttributes() ?>><?php echo $occurrence_delete->probability->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($occurrence_delete->description->Visible) { // description ?>
		<td <?php echo $occurrence_delete->description->cellAttributes() ?>>
<span id="el<?php echo $occurrence_delete->RowCount ?>_occurrence_description" class="occurrence_description">
<span<?php echo $occurrence_delete->description->viewAttributes() ?>><?php echo $occurrence_delete->description->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($occurrence_delete->likelihood->Visible) { // likelihood ?>
		<td <?php echo $occurrence_delete->likelihood->cellAttributes() ?>>
<span id="el<?php echo $occurrence_delete->RowCount ?>_occurrence_likelihood" class="occurrence_likelihood">
<span<?php echo $occurrence_delete->likelihood->viewAttributes() ?>><?php echo $occurrence_delete->likelihood->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($occurrence_delete->timebased->Visible) { // timebased ?>
		<td <?php echo $occurrence_delete->timebased->cellAttributes() ?>>
<span id="el<?php echo $occurrence_delete->RowCount ?>_occurrence_timebased" class="occurrence_timebased">
<span<?php echo $occurrence_delete->timebased->viewAttributes() ?>><?php echo $occurrence_delete->timebased->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($occurrence_delete->color->Visible) { // color ?>
		<td <?php echo $occurrence_delete->color->cellAttributes() ?>>
<span id="el<?php echo $occurrence_delete->RowCount ?>_occurrence_color" class="occurrence_color">
<span<?php echo $occurrence_delete->color->viewAttributes() ?>><?php echo $occurrence_delete->color->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$occurrence_delete->Recordset->moveNext();
}
$occurrence_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $occurrence_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$occurrence_delete->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function() {

	// Startup script
	// Write your table-specific startup script here
	// console.log("page loaded");

});
</script>
<?php include_once "footer.php"; ?>
<?php
$occurrence_delete->terminate();
?>