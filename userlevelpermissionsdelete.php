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
$userlevelpermissions_delete = new userlevelpermissions_delete();

// Run the page
$userlevelpermissions_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$userlevelpermissions_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fuserlevelpermissionsdelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	fuserlevelpermissionsdelete = currentForm = new ew.Form("fuserlevelpermissionsdelete", "delete");
	loadjs.done("fuserlevelpermissionsdelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $userlevelpermissions_delete->showPageHeader(); ?>
<?php
$userlevelpermissions_delete->showMessage();
?>
<form name="fuserlevelpermissionsdelete" id="fuserlevelpermissionsdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="userlevelpermissions">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($userlevelpermissions_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($userlevelpermissions_delete->userlevelid->Visible) { // userlevelid ?>
		<th class="<?php echo $userlevelpermissions_delete->userlevelid->headerCellClass() ?>"><span id="elh_userlevelpermissions_userlevelid" class="userlevelpermissions_userlevelid"><?php echo $userlevelpermissions_delete->userlevelid->caption() ?></span></th>
<?php } ?>
<?php if ($userlevelpermissions_delete->_tablename->Visible) { // tablename ?>
		<th class="<?php echo $userlevelpermissions_delete->_tablename->headerCellClass() ?>"><span id="elh_userlevelpermissions__tablename" class="userlevelpermissions__tablename"><?php echo $userlevelpermissions_delete->_tablename->caption() ?></span></th>
<?php } ?>
<?php if ($userlevelpermissions_delete->permission->Visible) { // permission ?>
		<th class="<?php echo $userlevelpermissions_delete->permission->headerCellClass() ?>"><span id="elh_userlevelpermissions_permission" class="userlevelpermissions_permission"><?php echo $userlevelpermissions_delete->permission->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$userlevelpermissions_delete->RecordCount = 0;
$i = 0;
while (!$userlevelpermissions_delete->Recordset->EOF) {
	$userlevelpermissions_delete->RecordCount++;
	$userlevelpermissions_delete->RowCount++;

	// Set row properties
	$userlevelpermissions->resetAttributes();
	$userlevelpermissions->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$userlevelpermissions_delete->loadRowValues($userlevelpermissions_delete->Recordset);

	// Render row
	$userlevelpermissions_delete->renderRow();
?>
	<tr <?php echo $userlevelpermissions->rowAttributes() ?>>
<?php if ($userlevelpermissions_delete->userlevelid->Visible) { // userlevelid ?>
		<td <?php echo $userlevelpermissions_delete->userlevelid->cellAttributes() ?>>
<span id="el<?php echo $userlevelpermissions_delete->RowCount ?>_userlevelpermissions_userlevelid" class="userlevelpermissions_userlevelid">
<span<?php echo $userlevelpermissions_delete->userlevelid->viewAttributes() ?>><?php echo $userlevelpermissions_delete->userlevelid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($userlevelpermissions_delete->_tablename->Visible) { // tablename ?>
		<td <?php echo $userlevelpermissions_delete->_tablename->cellAttributes() ?>>
<span id="el<?php echo $userlevelpermissions_delete->RowCount ?>_userlevelpermissions__tablename" class="userlevelpermissions__tablename">
<span<?php echo $userlevelpermissions_delete->_tablename->viewAttributes() ?>><?php echo $userlevelpermissions_delete->_tablename->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($userlevelpermissions_delete->permission->Visible) { // permission ?>
		<td <?php echo $userlevelpermissions_delete->permission->cellAttributes() ?>>
<span id="el<?php echo $userlevelpermissions_delete->RowCount ?>_userlevelpermissions_permission" class="userlevelpermissions_permission">
<span<?php echo $userlevelpermissions_delete->permission->viewAttributes() ?>><?php echo $userlevelpermissions_delete->permission->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$userlevelpermissions_delete->Recordset->moveNext();
}
$userlevelpermissions_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $userlevelpermissions_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$userlevelpermissions_delete->showPageFooter();
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
$userlevelpermissions_delete->terminate();
?>