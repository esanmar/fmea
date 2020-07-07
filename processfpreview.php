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
$processf_preview = new processf_preview();

// Run the page
$processf_preview->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$processf_preview->Page_Render();
?>
<?php $processf_preview->showPageHeader(); ?>
<?php if ($processf_preview->TotalRecords > 0) { ?>
<div class="card ew-grid processf"><!-- .card -->
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel ew-preview-middle-panel"><!-- .table-responsive -->
<table class="table ew-table ew-preview-table"><!-- .table -->
	<thead><!-- Table header -->
		<tr class="ew-table-header">
<?php

// Render list options
$processf_preview->renderListOptions();

// Render list options (header, left)
$processf_preview->ListOptions->render("header", "left");
?>
<?php if ($processf_preview->fmea->Visible) { // fmea ?>
	<?php if ($processf->SortUrl($processf_preview->fmea) == "") { ?>
		<th class="<?php echo $processf_preview->fmea->headerCellClass() ?>"><?php echo $processf_preview->fmea->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $processf_preview->fmea->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($processf_preview->fmea->Name) ?>" data-sort-order="<?php echo $processf_preview->SortField == $processf_preview->fmea->Name && $processf_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_preview->fmea->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_preview->SortField == $processf_preview->fmea->Name) { ?><?php if ($processf_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_preview->step->Visible) { // step ?>
	<?php if ($processf->SortUrl($processf_preview->step) == "") { ?>
		<th class="<?php echo $processf_preview->step->headerCellClass() ?>"><?php echo $processf_preview->step->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $processf_preview->step->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($processf_preview->step->Name) ?>" data-sort-order="<?php echo $processf_preview->SortField == $processf_preview->step->Name && $processf_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_preview->step->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_preview->SortField == $processf_preview->step->Name) { ?><?php if ($processf_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_preview->flowchartDesc->Visible) { // flowchartDesc ?>
	<?php if ($processf->SortUrl($processf_preview->flowchartDesc) == "") { ?>
		<th class="<?php echo $processf_preview->flowchartDesc->headerCellClass() ?>"><?php echo $processf_preview->flowchartDesc->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $processf_preview->flowchartDesc->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($processf_preview->flowchartDesc->Name) ?>" data-sort-order="<?php echo $processf_preview->SortField == $processf_preview->flowchartDesc->Name && $processf_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_preview->flowchartDesc->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_preview->SortField == $processf_preview->flowchartDesc->Name) { ?><?php if ($processf_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_preview->partnumber->Visible) { // partnumber ?>
	<?php if ($processf->SortUrl($processf_preview->partnumber) == "") { ?>
		<th class="<?php echo $processf_preview->partnumber->headerCellClass() ?>"><?php echo $processf_preview->partnumber->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $processf_preview->partnumber->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($processf_preview->partnumber->Name) ?>" data-sort-order="<?php echo $processf_preview->SortField == $processf_preview->partnumber->Name && $processf_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_preview->partnumber->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_preview->SortField == $processf_preview->partnumber->Name) { ?><?php if ($processf_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_preview->operation->Visible) { // operation ?>
	<?php if ($processf->SortUrl($processf_preview->operation) == "") { ?>
		<th class="<?php echo $processf_preview->operation->headerCellClass() ?>"><?php echo $processf_preview->operation->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $processf_preview->operation->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($processf_preview->operation->Name) ?>" data-sort-order="<?php echo $processf_preview->SortField == $processf_preview->operation->Name && $processf_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_preview->operation->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_preview->SortField == $processf_preview->operation->Name) { ?><?php if ($processf_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_preview->derivedFromNC->Visible) { // derivedFromNC ?>
	<?php if ($processf->SortUrl($processf_preview->derivedFromNC) == "") { ?>
		<th class="<?php echo $processf_preview->derivedFromNC->headerCellClass() ?>"><?php echo $processf_preview->derivedFromNC->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $processf_preview->derivedFromNC->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($processf_preview->derivedFromNC->Name) ?>" data-sort-order="<?php echo $processf_preview->SortField == $processf_preview->derivedFromNC->Name && $processf_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_preview->derivedFromNC->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_preview->SortField == $processf_preview->derivedFromNC->Name) { ?><?php if ($processf_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_preview->numberOfNC->Visible) { // numberOfNC ?>
	<?php if ($processf->SortUrl($processf_preview->numberOfNC) == "") { ?>
		<th class="<?php echo $processf_preview->numberOfNC->headerCellClass() ?>"><?php echo $processf_preview->numberOfNC->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $processf_preview->numberOfNC->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($processf_preview->numberOfNC->Name) ?>" data-sort-order="<?php echo $processf_preview->SortField == $processf_preview->numberOfNC->Name && $processf_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_preview->numberOfNC->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_preview->SortField == $processf_preview->numberOfNC->Name) { ?><?php if ($processf_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_preview->flowchart->Visible) { // flowchart ?>
	<?php if ($processf->SortUrl($processf_preview->flowchart) == "") { ?>
		<th class="<?php echo $processf_preview->flowchart->headerCellClass() ?>"><?php echo $processf_preview->flowchart->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $processf_preview->flowchart->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($processf_preview->flowchart->Name) ?>" data-sort-order="<?php echo $processf_preview->SortField == $processf_preview->flowchart->Name && $processf_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_preview->flowchart->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_preview->SortField == $processf_preview->flowchart->Name) { ?><?php if ($processf_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_preview->subprocess->Visible) { // subprocess ?>
	<?php if ($processf->SortUrl($processf_preview->subprocess) == "") { ?>
		<th class="<?php echo $processf_preview->subprocess->headerCellClass() ?>"><?php echo $processf_preview->subprocess->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $processf_preview->subprocess->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($processf_preview->subprocess->Name) ?>" data-sort-order="<?php echo $processf_preview->SortField == $processf_preview->subprocess->Name && $processf_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_preview->subprocess->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_preview->SortField == $processf_preview->subprocess->Name) { ?><?php if ($processf_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_preview->requirement->Visible) { // requirement ?>
	<?php if ($processf->SortUrl($processf_preview->requirement) == "") { ?>
		<th class="<?php echo $processf_preview->requirement->headerCellClass() ?>"><?php echo $processf_preview->requirement->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $processf_preview->requirement->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($processf_preview->requirement->Name) ?>" data-sort-order="<?php echo $processf_preview->SortField == $processf_preview->requirement->Name && $processf_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_preview->requirement->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_preview->SortField == $processf_preview->requirement->Name) { ?><?php if ($processf_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_preview->potencialFailureMode->Visible) { // potencialFailureMode ?>
	<?php if ($processf->SortUrl($processf_preview->potencialFailureMode) == "") { ?>
		<th class="<?php echo $processf_preview->potencialFailureMode->headerCellClass() ?>"><?php echo $processf_preview->potencialFailureMode->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $processf_preview->potencialFailureMode->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($processf_preview->potencialFailureMode->Name) ?>" data-sort-order="<?php echo $processf_preview->SortField == $processf_preview->potencialFailureMode->Name && $processf_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_preview->potencialFailureMode->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_preview->SortField == $processf_preview->potencialFailureMode->Name) { ?><?php if ($processf_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_preview->potencialFailurEffect->Visible) { // potencialFailurEffect ?>
	<?php if ($processf->SortUrl($processf_preview->potencialFailurEffect) == "") { ?>
		<th class="<?php echo $processf_preview->potencialFailurEffect->headerCellClass() ?>"><?php echo $processf_preview->potencialFailurEffect->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $processf_preview->potencialFailurEffect->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($processf_preview->potencialFailurEffect->Name) ?>" data-sort-order="<?php echo $processf_preview->SortField == $processf_preview->potencialFailurEffect->Name && $processf_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_preview->potencialFailurEffect->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_preview->SortField == $processf_preview->potencialFailurEffect->Name) { ?><?php if ($processf_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_preview->kc->Visible) { // kc ?>
	<?php if ($processf->SortUrl($processf_preview->kc) == "") { ?>
		<th class="<?php echo $processf_preview->kc->headerCellClass() ?>"><?php echo $processf_preview->kc->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $processf_preview->kc->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($processf_preview->kc->Name) ?>" data-sort-order="<?php echo $processf_preview->SortField == $processf_preview->kc->Name && $processf_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_preview->kc->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_preview->SortField == $processf_preview->kc->Name) { ?><?php if ($processf_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($processf_preview->severity->Visible) { // severity ?>
	<?php if ($processf->SortUrl($processf_preview->severity) == "") { ?>
		<th class="<?php echo $processf_preview->severity->headerCellClass() ?>"><?php echo $processf_preview->severity->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $processf_preview->severity->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($processf_preview->severity->Name) ?>" data-sort-order="<?php echo $processf_preview->SortField == $processf_preview->severity->Name && $processf_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $processf_preview->severity->caption() ?></span><span class="ew-table-header-sort"><?php if ($processf_preview->SortField == $processf_preview->severity->Name) { ?><?php if ($processf_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($processf_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$processf_preview->ListOptions->render("header", "right");
?>
		</tr>
	</thead>
	<tbody><!-- Table body -->
<?php
$processf_preview->RecCount = 0;
$processf_preview->RowCount = 0;
while ($processf_preview->Recordset && !$processf_preview->Recordset->EOF) {

	// Init row class and style
	$processf_preview->RecCount++;
	$processf_preview->RowCount++;
	$processf_preview->CssStyle = "";
	$processf_preview->loadListRowValues($processf_preview->Recordset);

	// Render row
	$processf->RowType = ROWTYPE_PREVIEW; // Preview record
	$processf_preview->resetAttributes();
	$processf_preview->renderListRow();

	// Render list options
	$processf_preview->renderListOptions();
?>
	<tr <?php echo $processf->rowAttributes() ?>>
<?php

// Render list options (body, left)
$processf_preview->ListOptions->render("body", "left", $processf_preview->RowCount);
?>
<?php if ($processf_preview->fmea->Visible) { // fmea ?>
		<!-- fmea -->
		<td<?php echo $processf_preview->fmea->cellAttributes() ?>>
<span<?php echo $processf_preview->fmea->viewAttributes() ?>><?php echo $processf_preview->fmea->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($processf_preview->step->Visible) { // step ?>
		<!-- step -->
		<td<?php echo $processf_preview->step->cellAttributes() ?>>
<span<?php echo $processf_preview->step->viewAttributes() ?>><?php echo $processf_preview->step->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($processf_preview->flowchartDesc->Visible) { // flowchartDesc ?>
		<!-- flowchartDesc -->
		<td<?php echo $processf_preview->flowchartDesc->cellAttributes() ?>>
<span<?php echo $processf_preview->flowchartDesc->viewAttributes() ?>><?php echo $processf_preview->flowchartDesc->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($processf_preview->partnumber->Visible) { // partnumber ?>
		<!-- partnumber -->
		<td<?php echo $processf_preview->partnumber->cellAttributes() ?>>
<span<?php echo $processf_preview->partnumber->viewAttributes() ?>><?php echo $processf_preview->partnumber->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($processf_preview->operation->Visible) { // operation ?>
		<!-- operation -->
		<td<?php echo $processf_preview->operation->cellAttributes() ?>>
<span<?php echo $processf_preview->operation->viewAttributes() ?>><?php echo $processf_preview->operation->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($processf_preview->derivedFromNC->Visible) { // derivedFromNC ?>
		<!-- derivedFromNC -->
		<td<?php echo $processf_preview->derivedFromNC->cellAttributes() ?>>
<span<?php echo $processf_preview->derivedFromNC->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_derivedFromNC" class="custom-control-input" value="<?php echo $processf_preview->derivedFromNC->getViewValue() ?>" disabled<?php if (ConvertToBool($processf_preview->derivedFromNC->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_derivedFromNC"></label></div></span>
</td>
<?php } ?>
<?php if ($processf_preview->numberOfNC->Visible) { // numberOfNC ?>
		<!-- numberOfNC -->
		<td<?php echo $processf_preview->numberOfNC->cellAttributes() ?>>
<span<?php echo $processf_preview->numberOfNC->viewAttributes() ?>><?php echo $processf_preview->numberOfNC->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($processf_preview->flowchart->Visible) { // flowchart ?>
		<!-- flowchart -->
		<td<?php echo $processf_preview->flowchart->cellAttributes() ?>>
<span<?php echo $processf_preview->flowchart->viewAttributes() ?>><?php echo $processf_preview->flowchart->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($processf_preview->subprocess->Visible) { // subprocess ?>
		<!-- subprocess -->
		<td<?php echo $processf_preview->subprocess->cellAttributes() ?>>
<span<?php echo $processf_preview->subprocess->viewAttributes() ?>><?php echo $processf_preview->subprocess->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($processf_preview->requirement->Visible) { // requirement ?>
		<!-- requirement -->
		<td<?php echo $processf_preview->requirement->cellAttributes() ?>>
<span<?php echo $processf_preview->requirement->viewAttributes() ?>><?php echo $processf_preview->requirement->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($processf_preview->potencialFailureMode->Visible) { // potencialFailureMode ?>
		<!-- potencialFailureMode -->
		<td<?php echo $processf_preview->potencialFailureMode->cellAttributes() ?>>
<span<?php echo $processf_preview->potencialFailureMode->viewAttributes() ?>><?php echo $processf_preview->potencialFailureMode->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($processf_preview->potencialFailurEffect->Visible) { // potencialFailurEffect ?>
		<!-- potencialFailurEffect -->
		<td<?php echo $processf_preview->potencialFailurEffect->cellAttributes() ?>>
<span<?php echo $processf_preview->potencialFailurEffect->viewAttributes() ?>><?php echo $processf_preview->potencialFailurEffect->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($processf_preview->kc->Visible) { // kc ?>
		<!-- kc -->
		<td<?php echo $processf_preview->kc->cellAttributes() ?>>
<span<?php echo $processf_preview->kc->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_kc" class="custom-control-input" value="<?php echo $processf_preview->kc->getViewValue() ?>" disabled<?php if (ConvertToBool($processf_preview->kc->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_kc"></label></div></span>
</td>
<?php } ?>
<?php if ($processf_preview->severity->Visible) { // severity ?>
		<!-- severity -->
		<td<?php echo $processf_preview->severity->cellAttributes() ?>>
<span<?php echo $processf_preview->severity->viewAttributes() ?>><?php echo $processf_preview->severity->getViewValue() ?></span>
</td>
<?php } ?>
<?php

// Render list options (body, right)
$processf_preview->ListOptions->render("body", "right", $processf_preview->RowCount);
?>
	</tr>
<?php
	$processf_preview->Recordset->MoveNext();
} // while
?>
	</tbody>
</table><!-- /.table -->
</div><!-- /.table-responsive -->
<div class="card-footer ew-grid-lower-panel ew-preview-lower-panel"><!-- .card-footer -->
<?php echo $processf_preview->Pager->render() ?>
<?php } else { // No record ?>
<div class="card no-border">
<div class="ew-detail-count"><?php echo $Language->phrase("NoRecord") ?></div>
<?php } ?>
<div class="ew-preview-other-options">
<?php
	foreach ($processf_preview->OtherOptions as $option)
		$option->render("body");
?>
</div>
<?php if ($processf_preview->TotalRecords > 0) { ?>
<div class="clearfix"></div>
</div><!-- /.card-footer -->
<?php } ?>
</div><!-- /.card -->
<?php
$processf_preview->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php
if ($processf_preview->Recordset)
	$processf_preview->Recordset->Close();

// Output
$content = ob_get_contents();
ob_end_clean();
echo ConvertToUtf8($content);
?>
<?php
$processf_preview->terminate();
?>