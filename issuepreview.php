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
WriteHeader(FALSE, "utf-8");

// Create page object
$issue_preview = new issue_preview();

// Run the page
$issue_preview->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$issue_preview->Page_Render();
?>
<?php $issue_preview->showPageHeader(); ?>
<?php if ($issue_preview->TotalRecords > 0) { ?>
<div class="card ew-grid issue"><!-- .card -->
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel ew-preview-middle-panel"><!-- .table-responsive -->
<table class="table ew-table ew-preview-table"><!-- .table -->
	<thead><!-- Table header -->
		<tr class="ew-table-header">
<?php

// Render list options
$issue_preview->renderListOptions();

// Render list options (header, left)
$issue_preview->ListOptions->render("header", "left");
?>
<?php if ($issue_preview->fmea->Visible) { // fmea ?>
	<?php if ($issue->SortUrl($issue_preview->fmea) == "") { ?>
		<th class="<?php echo $issue_preview->fmea->headerCellClass() ?>"><?php echo $issue_preview->fmea->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $issue_preview->fmea->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($issue_preview->fmea->Name) ?>" data-sort-order="<?php echo $issue_preview->SortField == $issue_preview->fmea->Name && $issue_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $issue_preview->fmea->caption() ?></span><span class="ew-table-header-sort"><?php if ($issue_preview->SortField == $issue_preview->fmea->Name) { ?><?php if ($issue_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($issue_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($issue_preview->issue->Visible) { // issue ?>
	<?php if ($issue->SortUrl($issue_preview->issue) == "") { ?>
		<th class="<?php echo $issue_preview->issue->headerCellClass() ?>"><?php echo $issue_preview->issue->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $issue_preview->issue->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($issue_preview->issue->Name) ?>" data-sort-order="<?php echo $issue_preview->SortField == $issue_preview->issue->Name && $issue_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $issue_preview->issue->caption() ?></span><span class="ew-table-header-sort"><?php if ($issue_preview->SortField == $issue_preview->issue->Name) { ?><?php if ($issue_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($issue_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($issue_preview->date->Visible) { // date ?>
	<?php if ($issue->SortUrl($issue_preview->date) == "") { ?>
		<th class="<?php echo $issue_preview->date->headerCellClass() ?>"><?php echo $issue_preview->date->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $issue_preview->date->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($issue_preview->date->Name) ?>" data-sort-order="<?php echo $issue_preview->SortField == $issue_preview->date->Name && $issue_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $issue_preview->date->caption() ?></span><span class="ew-table-header-sort"><?php if ($issue_preview->SortField == $issue_preview->date->Name) { ?><?php if ($issue_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($issue_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($issue_preview->cause->Visible) { // cause ?>
	<?php if ($issue->SortUrl($issue_preview->cause) == "") { ?>
		<th class="<?php echo $issue_preview->cause->headerCellClass() ?>"><?php echo $issue_preview->cause->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $issue_preview->cause->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($issue_preview->cause->Name) ?>" data-sort-order="<?php echo $issue_preview->SortField == $issue_preview->cause->Name && $issue_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $issue_preview->cause->caption() ?></span><span class="ew-table-header-sort"><?php if ($issue_preview->SortField == $issue_preview->cause->Name) { ?><?php if ($issue_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($issue_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($issue_preview->leader->Visible) { // leader ?>
	<?php if ($issue->SortUrl($issue_preview->leader) == "") { ?>
		<th class="<?php echo $issue_preview->leader->headerCellClass() ?>"><?php echo $issue_preview->leader->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $issue_preview->leader->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($issue_preview->leader->Name) ?>" data-sort-order="<?php echo $issue_preview->SortField == $issue_preview->leader->Name && $issue_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $issue_preview->leader->caption() ?></span><span class="ew-table-header-sort"><?php if ($issue_preview->SortField == $issue_preview->leader->Name) { ?><?php if ($issue_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($issue_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($issue_preview->employee->Visible) { // employee ?>
	<?php if ($issue->SortUrl($issue_preview->employee) == "") { ?>
		<th class="<?php echo $issue_preview->employee->headerCellClass() ?>"><?php echo $issue_preview->employee->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $issue_preview->employee->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($issue_preview->employee->Name) ?>" data-sort-order="<?php echo $issue_preview->SortField == $issue_preview->employee->Name && $issue_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $issue_preview->employee->caption() ?></span><span class="ew-table-header-sort"><?php if ($issue_preview->SortField == $issue_preview->employee->Name) { ?><?php if ($issue_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($issue_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$issue_preview->ListOptions->render("header", "right");
?>
		</tr>
	</thead>
	<tbody><!-- Table body -->
<?php
$issue_preview->RecCount = 0;
$issue_preview->RowCount = 0;
while ($issue_preview->Recordset && !$issue_preview->Recordset->EOF) {

	// Init row class and style
	$issue_preview->RecCount++;
	$issue_preview->RowCount++;
	$issue_preview->CssStyle = "";
	$issue_preview->loadListRowValues($issue_preview->Recordset);

	// Render row
	$issue->RowType = ROWTYPE_PREVIEW; // Preview record
	$issue_preview->resetAttributes();
	$issue_preview->renderListRow();

	// Render list options
	$issue_preview->renderListOptions();
?>
	<tr <?php echo $issue->rowAttributes() ?>>
<?php

// Render list options (body, left)
$issue_preview->ListOptions->render("body", "left", $issue_preview->RowCount);
?>
<?php if ($issue_preview->fmea->Visible) { // fmea ?>
		<!-- fmea -->
		<td<?php echo $issue_preview->fmea->cellAttributes() ?>>
<span<?php echo $issue_preview->fmea->viewAttributes() ?>><?php echo $issue_preview->fmea->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($issue_preview->issue->Visible) { // issue ?>
		<!-- issue -->
		<td<?php echo $issue_preview->issue->cellAttributes() ?>>
<span<?php echo $issue_preview->issue->viewAttributes() ?>><?php echo $issue_preview->issue->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($issue_preview->date->Visible) { // date ?>
		<!-- date -->
		<td<?php echo $issue_preview->date->cellAttributes() ?>>
<span<?php echo $issue_preview->date->viewAttributes() ?>><?php echo $issue_preview->date->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($issue_preview->cause->Visible) { // cause ?>
		<!-- cause -->
		<td<?php echo $issue_preview->cause->cellAttributes() ?>>
<span<?php echo $issue_preview->cause->viewAttributes() ?>><?php echo $issue_preview->cause->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($issue_preview->leader->Visible) { // leader ?>
		<!-- leader -->
		<td<?php echo $issue_preview->leader->cellAttributes() ?>>
<span<?php echo $issue_preview->leader->viewAttributes() ?>><?php echo $issue_preview->leader->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($issue_preview->employee->Visible) { // employee ?>
		<!-- employee -->
		<td<?php echo $issue_preview->employee->cellAttributes() ?>>
<span<?php echo $issue_preview->employee->viewAttributes() ?>><?php echo $issue_preview->employee->getViewValue() ?></span>
</td>
<?php } ?>
<?php

// Render list options (body, right)
$issue_preview->ListOptions->render("body", "right", $issue_preview->RowCount);
?>
	</tr>
<?php
	$issue_preview->Recordset->MoveNext();
} // while
?>
	</tbody>
</table><!-- /.table -->
</div><!-- /.table-responsive -->
<div class="card-footer ew-grid-lower-panel ew-preview-lower-panel"><!-- .card-footer -->
<?php echo $issue_preview->Pager->render() ?>
<?php } else { // No record ?>
<div class="card no-border">
<div class="ew-detail-count"><?php echo $Language->phrase("NoRecord") ?></div>
<?php } ?>
<div class="ew-preview-other-options">
<?php
	foreach ($issue_preview->OtherOptions as $option)
		$option->render("body");
?>
</div>
<?php if ($issue_preview->TotalRecords > 0) { ?>
<div class="clearfix"></div>
</div><!-- /.card-footer -->
<?php } ?>
</div><!-- /.card -->
<?php
$issue_preview->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php
if ($issue_preview->Recordset)
	$issue_preview->Recordset->Close();

// Output
$content = ob_get_contents();
ob_end_clean();
echo ConvertToUtf8($content);
?>
<?php
$issue_preview->terminate();
?>