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
$severity_delete = new severity_delete();

// Run the page
$severity_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$severity_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fseveritydelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	fseveritydelete = currentForm = new ew.Form("fseveritydelete", "delete");
	loadjs.done("fseveritydelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $severity_delete->showPageHeader(); ?>
<?php
$severity_delete->showMessage();
?>
<form name="fseveritydelete" id="fseveritydelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="severity">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($severity_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($severity_delete->idSeverity->Visible) { // idSeverity ?>
		<th class="<?php echo $severity_delete->idSeverity->headerCellClass() ?>"><span id="elh_severity_idSeverity" class="severity_idSeverity"><?php echo $severity_delete->idSeverity->caption() ?></span></th>
<?php } ?>
<?php if ($severity_delete->effect->Visible) { // effect ?>
		<th class="<?php echo $severity_delete->effect->headerCellClass() ?>"><span id="elh_severity_effect" class="severity_effect"><?php echo $severity_delete->effect->caption() ?></span></th>
<?php } ?>
<?php if ($severity_delete->severityonclient->Visible) { // severityonclient ?>
		<th class="<?php echo $severity_delete->severityonclient->headerCellClass() ?>"><span id="elh_severity_severityonclient" class="severity_severityonclient"><?php echo $severity_delete->severityonclient->caption() ?></span></th>
<?php } ?>
<?php if ($severity_delete->internalseverity->Visible) { // internalseverity ?>
		<th class="<?php echo $severity_delete->internalseverity->headerCellClass() ?>"><span id="elh_severity_internalseverity" class="severity_internalseverity"><?php echo $severity_delete->internalseverity->caption() ?></span></th>
<?php } ?>
<?php if ($severity_delete->color->Visible) { // color ?>
		<th class="<?php echo $severity_delete->color->headerCellClass() ?>"><span id="elh_severity_color" class="severity_color"><?php echo $severity_delete->color->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$severity_delete->RecordCount = 0;
$i = 0;
while (!$severity_delete->Recordset->EOF) {
	$severity_delete->RecordCount++;
	$severity_delete->RowCount++;

	// Set row properties
	$severity->resetAttributes();
	$severity->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$severity_delete->loadRowValues($severity_delete->Recordset);

	// Render row
	$severity_delete->renderRow();
?>
	<tr <?php echo $severity->rowAttributes() ?>>
<?php if ($severity_delete->idSeverity->Visible) { // idSeverity ?>
		<td <?php echo $severity_delete->idSeverity->cellAttributes() ?>>
<span id="el<?php echo $severity_delete->RowCount ?>_severity_idSeverity" class="severity_idSeverity">
<span<?php echo $severity_delete->idSeverity->viewAttributes() ?>><?php echo $severity_delete->idSeverity->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($severity_delete->effect->Visible) { // effect ?>
		<td <?php echo $severity_delete->effect->cellAttributes() ?>>
<span id="el<?php echo $severity_delete->RowCount ?>_severity_effect" class="severity_effect">
<span<?php echo $severity_delete->effect->viewAttributes() ?>><?php echo $severity_delete->effect->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($severity_delete->severityonclient->Visible) { // severityonclient ?>
		<td <?php echo $severity_delete->severityonclient->cellAttributes() ?>>
<span id="el<?php echo $severity_delete->RowCount ?>_severity_severityonclient" class="severity_severityonclient">
<span<?php echo $severity_delete->severityonclient->viewAttributes() ?>><?php echo $severity_delete->severityonclient->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($severity_delete->internalseverity->Visible) { // internalseverity ?>
		<td <?php echo $severity_delete->internalseverity->cellAttributes() ?>>
<span id="el<?php echo $severity_delete->RowCount ?>_severity_internalseverity" class="severity_internalseverity">
<span<?php echo $severity_delete->internalseverity->viewAttributes() ?>><?php echo $severity_delete->internalseverity->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($severity_delete->color->Visible) { // color ?>
		<td <?php echo $severity_delete->color->cellAttributes() ?>>
<span id="el<?php echo $severity_delete->RowCount ?>_severity_color" class="severity_color">
<span<?php echo $severity_delete->color->viewAttributes() ?>><?php echo $severity_delete->color->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$severity_delete->Recordset->moveNext();
}
$severity_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $severity_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$severity_delete->showPageFooter();
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
$severity_delete->terminate();
?>