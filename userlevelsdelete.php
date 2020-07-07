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
$userlevels_delete = new userlevels_delete();

// Run the page
$userlevels_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$userlevels_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fuserlevelsdelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	fuserlevelsdelete = currentForm = new ew.Form("fuserlevelsdelete", "delete");
	loadjs.done("fuserlevelsdelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $userlevels_delete->showPageHeader(); ?>
<?php
$userlevels_delete->showMessage();
?>
<form name="fuserlevelsdelete" id="fuserlevelsdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="userlevels">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($userlevels_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($userlevels_delete->userlevelid->Visible) { // userlevelid ?>
		<th class="<?php echo $userlevels_delete->userlevelid->headerCellClass() ?>"><span id="elh_userlevels_userlevelid" class="userlevels_userlevelid"><?php echo $userlevels_delete->userlevelid->caption() ?></span></th>
<?php } ?>
<?php if ($userlevels_delete->userlevelname->Visible) { // userlevelname ?>
		<th class="<?php echo $userlevels_delete->userlevelname->headerCellClass() ?>"><span id="elh_userlevels_userlevelname" class="userlevels_userlevelname"><?php echo $userlevels_delete->userlevelname->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$userlevels_delete->RecordCount = 0;
$i = 0;
while (!$userlevels_delete->Recordset->EOF) {
	$userlevels_delete->RecordCount++;
	$userlevels_delete->RowCount++;

	// Set row properties
	$userlevels->resetAttributes();
	$userlevels->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$userlevels_delete->loadRowValues($userlevels_delete->Recordset);

	// Render row
	$userlevels_delete->renderRow();
?>
	<tr <?php echo $userlevels->rowAttributes() ?>>
<?php if ($userlevels_delete->userlevelid->Visible) { // userlevelid ?>
		<td <?php echo $userlevels_delete->userlevelid->cellAttributes() ?>>
<span id="el<?php echo $userlevels_delete->RowCount ?>_userlevels_userlevelid" class="userlevels_userlevelid">
<span<?php echo $userlevels_delete->userlevelid->viewAttributes() ?>><?php echo $userlevels_delete->userlevelid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($userlevels_delete->userlevelname->Visible) { // userlevelname ?>
		<td <?php echo $userlevels_delete->userlevelname->cellAttributes() ?>>
<span id="el<?php echo $userlevels_delete->RowCount ?>_userlevels_userlevelname" class="userlevels_userlevelname">
<span<?php echo $userlevels_delete->userlevelname->viewAttributes() ?>><?php echo $userlevels_delete->userlevelname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$userlevels_delete->Recordset->moveNext();
}
$userlevels_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $userlevels_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$userlevels_delete->showPageFooter();
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
$userlevels_delete->terminate();
?>