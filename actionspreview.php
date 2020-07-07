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
$actions_preview = new actions_preview();

// Run the page
$actions_preview->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$actions_preview->Page_Render();
?>
<?php $actions_preview->showPageHeader(); ?>
<?php if ($actions_preview->TotalRecords > 0) { ?>
<div class="card ew-grid actions"><!-- .card -->
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel ew-preview-middle-panel"><!-- .table-responsive -->
<table class="table ew-table ew-preview-table"><!-- .table -->
	<thead><!-- Table header -->
		<tr class="ew-table-header">
<?php

// Render list options
$actions_preview->renderListOptions();

// Render list options (header, left)
$actions_preview->ListOptions->render("header", "left");
?>
<?php if ($actions_preview->idProcess->Visible) { // idProcess ?>
	<?php if ($actions->SortUrl($actions_preview->idProcess) == "") { ?>
		<th class="<?php echo $actions_preview->idProcess->headerCellClass() ?>"><?php echo $actions_preview->idProcess->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->idProcess->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->idProcess->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->idProcess->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->idProcess->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->idProcess->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->idCause->Visible) { // idCause ?>
	<?php if ($actions->SortUrl($actions_preview->idCause) == "") { ?>
		<th class="<?php echo $actions_preview->idCause->headerCellClass() ?>"><?php echo $actions_preview->idCause->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->idCause->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->idCause->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->idCause->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->idCause->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->idCause->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->potentialCauses->Visible) { // potentialCauses ?>
	<?php if ($actions->SortUrl($actions_preview->potentialCauses) == "") { ?>
		<th class="<?php echo $actions_preview->potentialCauses->headerCellClass() ?>"><?php echo $actions_preview->potentialCauses->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->potentialCauses->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->potentialCauses->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->potentialCauses->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->potentialCauses->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->potentialCauses->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->currentPreventiveControlMethod->Visible) { // currentPreventiveControlMethod ?>
	<?php if ($actions->SortUrl($actions_preview->currentPreventiveControlMethod) == "") { ?>
		<th class="<?php echo $actions_preview->currentPreventiveControlMethod->headerCellClass() ?>"><?php echo $actions_preview->currentPreventiveControlMethod->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->currentPreventiveControlMethod->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->currentPreventiveControlMethod->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->currentPreventiveControlMethod->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->currentPreventiveControlMethod->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->currentPreventiveControlMethod->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->severity->Visible) { // severity ?>
	<?php if ($actions->SortUrl($actions_preview->severity) == "") { ?>
		<th class="<?php echo $actions_preview->severity->headerCellClass() ?>"><?php echo $actions_preview->severity->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->severity->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->severity->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->severity->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->severity->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->severity->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->occurrence->Visible) { // occurrence ?>
	<?php if ($actions->SortUrl($actions_preview->occurrence) == "") { ?>
		<th class="<?php echo $actions_preview->occurrence->headerCellClass() ?>"><?php echo $actions_preview->occurrence->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->occurrence->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->occurrence->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->occurrence->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->occurrence->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->occurrence->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->currentControlMethod->Visible) { // currentControlMethod ?>
	<?php if ($actions->SortUrl($actions_preview->currentControlMethod) == "") { ?>
		<th class="<?php echo $actions_preview->currentControlMethod->headerCellClass() ?>"><?php echo $actions_preview->currentControlMethod->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->currentControlMethod->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->currentControlMethod->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->currentControlMethod->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->currentControlMethod->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->currentControlMethod->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->detection->Visible) { // detection ?>
	<?php if ($actions->SortUrl($actions_preview->detection) == "") { ?>
		<th class="<?php echo $actions_preview->detection->headerCellClass() ?>"><?php echo $actions_preview->detection->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->detection->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->detection->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->detection->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->detection->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->detection->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->RPNCalc->Visible) { // RPNCalc ?>
	<?php if ($actions->SortUrl($actions_preview->RPNCalc) == "") { ?>
		<th class="<?php echo $actions_preview->RPNCalc->headerCellClass() ?>"><?php echo $actions_preview->RPNCalc->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->RPNCalc->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->RPNCalc->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->RPNCalc->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->RPNCalc->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->RPNCalc->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->recomendedAction->Visible) { // recomendedAction ?>
	<?php if ($actions->SortUrl($actions_preview->recomendedAction) == "") { ?>
		<th class="<?php echo $actions_preview->recomendedAction->headerCellClass() ?>"><?php echo $actions_preview->recomendedAction->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->recomendedAction->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->recomendedAction->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->recomendedAction->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->recomendedAction->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->recomendedAction->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->idResponsible->Visible) { // idResponsible ?>
	<?php if ($actions->SortUrl($actions_preview->idResponsible) == "") { ?>
		<th class="<?php echo $actions_preview->idResponsible->headerCellClass() ?>"><?php echo $actions_preview->idResponsible->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->idResponsible->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->idResponsible->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->idResponsible->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->idResponsible->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->idResponsible->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->targetDate->Visible) { // targetDate ?>
	<?php if ($actions->SortUrl($actions_preview->targetDate) == "") { ?>
		<th class="<?php echo $actions_preview->targetDate->headerCellClass() ?>"><?php echo $actions_preview->targetDate->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->targetDate->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->targetDate->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->targetDate->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->targetDate->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->targetDate->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->revisedKc->Visible) { // revisedKc ?>
	<?php if ($actions->SortUrl($actions_preview->revisedKc) == "") { ?>
		<th class="<?php echo $actions_preview->revisedKc->headerCellClass() ?>"><?php echo $actions_preview->revisedKc->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->revisedKc->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->revisedKc->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->revisedKc->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->revisedKc->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->revisedKc->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->expectedSeverity->Visible) { // expectedSeverity ?>
	<?php if ($actions->SortUrl($actions_preview->expectedSeverity) == "") { ?>
		<th class="<?php echo $actions_preview->expectedSeverity->headerCellClass() ?>"><?php echo $actions_preview->expectedSeverity->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->expectedSeverity->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->expectedSeverity->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->expectedSeverity->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->expectedSeverity->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->expectedSeverity->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->expectedOccurrence->Visible) { // expectedOccurrence ?>
	<?php if ($actions->SortUrl($actions_preview->expectedOccurrence) == "") { ?>
		<th class="<?php echo $actions_preview->expectedOccurrence->headerCellClass() ?>"><?php echo $actions_preview->expectedOccurrence->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->expectedOccurrence->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->expectedOccurrence->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->expectedOccurrence->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->expectedOccurrence->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->expectedOccurrence->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->expectedDetection->Visible) { // expectedDetection ?>
	<?php if ($actions->SortUrl($actions_preview->expectedDetection) == "") { ?>
		<th class="<?php echo $actions_preview->expectedDetection->headerCellClass() ?>"><?php echo $actions_preview->expectedDetection->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->expectedDetection->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->expectedDetection->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->expectedDetection->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->expectedDetection->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->expectedDetection->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->expectedRPNPAO->Visible) { // expectedRPNPAO ?>
	<?php if ($actions->SortUrl($actions_preview->expectedRPNPAO) == "") { ?>
		<th class="<?php echo $actions_preview->expectedRPNPAO->headerCellClass() ?>"><?php echo $actions_preview->expectedRPNPAO->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->expectedRPNPAO->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->expectedRPNPAO->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->expectedRPNPAO->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->expectedRPNPAO->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->expectedRPNPAO->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->expectedClosureDate->Visible) { // expectedClosureDate ?>
	<?php if ($actions->SortUrl($actions_preview->expectedClosureDate) == "") { ?>
		<th class="<?php echo $actions_preview->expectedClosureDate->headerCellClass() ?>"><?php echo $actions_preview->expectedClosureDate->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->expectedClosureDate->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->expectedClosureDate->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->expectedClosureDate->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->expectedClosureDate->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->expectedClosureDate->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->recomendedActiondet->Visible) { // recomendedActiondet ?>
	<?php if ($actions->SortUrl($actions_preview->recomendedActiondet) == "") { ?>
		<th class="<?php echo $actions_preview->recomendedActiondet->headerCellClass() ?>"><?php echo $actions_preview->recomendedActiondet->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->recomendedActiondet->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->recomendedActiondet->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->recomendedActiondet->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->recomendedActiondet->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->recomendedActiondet->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->idResponsibleDet->Visible) { // idResponsibleDet ?>
	<?php if ($actions->SortUrl($actions_preview->idResponsibleDet) == "") { ?>
		<th class="<?php echo $actions_preview->idResponsibleDet->headerCellClass() ?>"><?php echo $actions_preview->idResponsibleDet->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->idResponsibleDet->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->idResponsibleDet->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->idResponsibleDet->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->idResponsibleDet->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->idResponsibleDet->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->targetDatedet->Visible) { // targetDatedet ?>
	<?php if ($actions->SortUrl($actions_preview->targetDatedet) == "") { ?>
		<th class="<?php echo $actions_preview->targetDatedet->headerCellClass() ?>"><?php echo $actions_preview->targetDatedet->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->targetDatedet->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->targetDatedet->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->targetDatedet->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->targetDatedet->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->targetDatedet->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->kcdet->Visible) { // kcdet ?>
	<?php if ($actions->SortUrl($actions_preview->kcdet) == "") { ?>
		<th class="<?php echo $actions_preview->kcdet->headerCellClass() ?>"><?php echo $actions_preview->kcdet->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->kcdet->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->kcdet->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->kcdet->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->kcdet->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->kcdet->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->expectedSeveritydet->Visible) { // expectedSeveritydet ?>
	<?php if ($actions->SortUrl($actions_preview->expectedSeveritydet) == "") { ?>
		<th class="<?php echo $actions_preview->expectedSeveritydet->headerCellClass() ?>"><?php echo $actions_preview->expectedSeveritydet->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->expectedSeveritydet->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->expectedSeveritydet->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->expectedSeveritydet->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->expectedSeveritydet->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->expectedSeveritydet->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->expectedOccurrencedet->Visible) { // expectedOccurrencedet ?>
	<?php if ($actions->SortUrl($actions_preview->expectedOccurrencedet) == "") { ?>
		<th class="<?php echo $actions_preview->expectedOccurrencedet->headerCellClass() ?>"><?php echo $actions_preview->expectedOccurrencedet->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->expectedOccurrencedet->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->expectedOccurrencedet->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->expectedOccurrencedet->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->expectedOccurrencedet->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->expectedOccurrencedet->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->expectedDetectiondet->Visible) { // expectedDetectiondet ?>
	<?php if ($actions->SortUrl($actions_preview->expectedDetectiondet) == "") { ?>
		<th class="<?php echo $actions_preview->expectedDetectiondet->headerCellClass() ?>"><?php echo $actions_preview->expectedDetectiondet->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->expectedDetectiondet->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->expectedDetectiondet->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->expectedDetectiondet->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->expectedDetectiondet->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->expectedDetectiondet->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->expectedRPNPAD->Visible) { // expectedRPNPAD ?>
	<?php if ($actions->SortUrl($actions_preview->expectedRPNPAD) == "") { ?>
		<th class="<?php echo $actions_preview->expectedRPNPAD->headerCellClass() ?>"><?php echo $actions_preview->expectedRPNPAD->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->expectedRPNPAD->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->expectedRPNPAD->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->expectedRPNPAD->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->expectedRPNPAD->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->expectedRPNPAD->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->revisedClosureDatedet->Visible) { // revisedClosureDatedet ?>
	<?php if ($actions->SortUrl($actions_preview->revisedClosureDatedet) == "") { ?>
		<th class="<?php echo $actions_preview->revisedClosureDatedet->headerCellClass() ?>"><?php echo $actions_preview->revisedClosureDatedet->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->revisedClosureDatedet->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->revisedClosureDatedet->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->revisedClosureDatedet->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->revisedClosureDatedet->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->revisedClosureDatedet->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->revisedSeverity->Visible) { // revisedSeverity ?>
	<?php if ($actions->SortUrl($actions_preview->revisedSeverity) == "") { ?>
		<th class="<?php echo $actions_preview->revisedSeverity->headerCellClass() ?>"><?php echo $actions_preview->revisedSeverity->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->revisedSeverity->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->revisedSeverity->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->revisedSeverity->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->revisedSeverity->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->revisedSeverity->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->revisedOccurrence->Visible) { // revisedOccurrence ?>
	<?php if ($actions->SortUrl($actions_preview->revisedOccurrence) == "") { ?>
		<th class="<?php echo $actions_preview->revisedOccurrence->headerCellClass() ?>"><?php echo $actions_preview->revisedOccurrence->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->revisedOccurrence->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->revisedOccurrence->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->revisedOccurrence->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->revisedOccurrence->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->revisedOccurrence->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->revisedDetection->Visible) { // revisedDetection ?>
	<?php if ($actions->SortUrl($actions_preview->revisedDetection) == "") { ?>
		<th class="<?php echo $actions_preview->revisedDetection->headerCellClass() ?>"><?php echo $actions_preview->revisedDetection->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->revisedDetection->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->revisedDetection->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->revisedDetection->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->revisedDetection->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->revisedDetection->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($actions_preview->revisedRPNCalc->Visible) { // revisedRPNCalc ?>
	<?php if ($actions->SortUrl($actions_preview->revisedRPNCalc) == "") { ?>
		<th class="<?php echo $actions_preview->revisedRPNCalc->headerCellClass() ?>"><?php echo $actions_preview->revisedRPNCalc->caption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $actions_preview->revisedRPNCalc->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?php echo HtmlEncode($actions_preview->revisedRPNCalc->Name) ?>" data-sort-order="<?php echo $actions_preview->SortField == $actions_preview->revisedRPNCalc->Name && $actions_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $actions_preview->revisedRPNCalc->caption() ?></span><span class="ew-table-header-sort"><?php if ($actions_preview->SortField == $actions_preview->revisedRPNCalc->Name) { ?><?php if ($actions_preview->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($actions_preview->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$actions_preview->ListOptions->render("header", "right");
?>
		</tr>
	</thead>
	<tbody><!-- Table body -->
<?php
$actions_preview->RecCount = 0;
$actions_preview->RowCount = 0;
while ($actions_preview->Recordset && !$actions_preview->Recordset->EOF) {

	// Init row class and style
	$actions_preview->RecCount++;
	$actions_preview->RowCount++;
	$actions_preview->CssStyle = "";
	$actions_preview->loadListRowValues($actions_preview->Recordset);

	// Render row
	$actions->RowType = ROWTYPE_PREVIEW; // Preview record
	$actions_preview->resetAttributes();
	$actions_preview->renderListRow();

	// Render list options
	$actions_preview->renderListOptions();
?>
	<tr <?php echo $actions->rowAttributes() ?>>
<?php

// Render list options (body, left)
$actions_preview->ListOptions->render("body", "left", $actions_preview->RowCount);
?>
<?php if ($actions_preview->idProcess->Visible) { // idProcess ?>
		<!-- idProcess -->
		<td<?php echo $actions_preview->idProcess->cellAttributes() ?>>
<span<?php echo $actions_preview->idProcess->viewAttributes() ?>><?php echo $actions_preview->idProcess->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->idCause->Visible) { // idCause ?>
		<!-- idCause -->
		<td<?php echo $actions_preview->idCause->cellAttributes() ?>>
<span<?php echo $actions_preview->idCause->viewAttributes() ?>><?php echo $actions_preview->idCause->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->potentialCauses->Visible) { // potentialCauses ?>
		<!-- potentialCauses -->
		<td<?php echo $actions_preview->potentialCauses->cellAttributes() ?>>
<span<?php echo $actions_preview->potentialCauses->viewAttributes() ?>><?php echo $actions_preview->potentialCauses->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->currentPreventiveControlMethod->Visible) { // currentPreventiveControlMethod ?>
		<!-- currentPreventiveControlMethod -->
		<td<?php echo $actions_preview->currentPreventiveControlMethod->cellAttributes() ?>>
<span<?php echo $actions_preview->currentPreventiveControlMethod->viewAttributes() ?>><?php echo $actions_preview->currentPreventiveControlMethod->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->severity->Visible) { // severity ?>
		<!-- severity -->
		<td<?php echo $actions_preview->severity->cellAttributes() ?>>
<span<?php echo $actions_preview->severity->viewAttributes() ?>><?php echo $actions_preview->severity->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->occurrence->Visible) { // occurrence ?>
		<!-- occurrence -->
		<td<?php echo $actions_preview->occurrence->cellAttributes() ?>>
<span<?php echo $actions_preview->occurrence->viewAttributes() ?>><?php echo $actions_preview->occurrence->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->currentControlMethod->Visible) { // currentControlMethod ?>
		<!-- currentControlMethod -->
		<td<?php echo $actions_preview->currentControlMethod->cellAttributes() ?>>
<span<?php echo $actions_preview->currentControlMethod->viewAttributes() ?>><?php echo $actions_preview->currentControlMethod->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->detection->Visible) { // detection ?>
		<!-- detection -->
		<td<?php echo $actions_preview->detection->cellAttributes() ?>>
<span<?php echo $actions_preview->detection->viewAttributes() ?>><?php echo $actions_preview->detection->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->RPNCalc->Visible) { // RPNCalc ?>
		<!-- RPNCalc -->
		<td<?php echo $actions_preview->RPNCalc->cellAttributes() ?>>
<span<?php echo $actions_preview->RPNCalc->viewAttributes() ?>><?php echo $actions_preview->RPNCalc->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->recomendedAction->Visible) { // recomendedAction ?>
		<!-- recomendedAction -->
		<td<?php echo $actions_preview->recomendedAction->cellAttributes() ?>>
<span<?php echo $actions_preview->recomendedAction->viewAttributes() ?>><?php echo $actions_preview->recomendedAction->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->idResponsible->Visible) { // idResponsible ?>
		<!-- idResponsible -->
		<td<?php echo $actions_preview->idResponsible->cellAttributes() ?>>
<span<?php echo $actions_preview->idResponsible->viewAttributes() ?>><?php echo $actions_preview->idResponsible->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->targetDate->Visible) { // targetDate ?>
		<!-- targetDate -->
		<td<?php echo $actions_preview->targetDate->cellAttributes() ?>>
<span<?php echo $actions_preview->targetDate->viewAttributes() ?>><?php echo $actions_preview->targetDate->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->revisedKc->Visible) { // revisedKc ?>
		<!-- revisedKc -->
		<td<?php echo $actions_preview->revisedKc->cellAttributes() ?>>
<span<?php echo $actions_preview->revisedKc->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_revisedKc" class="custom-control-input" value="<?php echo $actions_preview->revisedKc->getViewValue() ?>" disabled<?php if (ConvertToBool($actions_preview->revisedKc->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_revisedKc"></label></div></span>
</td>
<?php } ?>
<?php if ($actions_preview->expectedSeverity->Visible) { // expectedSeverity ?>
		<!-- expectedSeverity -->
		<td<?php echo $actions_preview->expectedSeverity->cellAttributes() ?>>
<span<?php echo $actions_preview->expectedSeverity->viewAttributes() ?>><?php echo $actions_preview->expectedSeverity->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->expectedOccurrence->Visible) { // expectedOccurrence ?>
		<!-- expectedOccurrence -->
		<td<?php echo $actions_preview->expectedOccurrence->cellAttributes() ?>>
<span<?php echo $actions_preview->expectedOccurrence->viewAttributes() ?>><?php echo $actions_preview->expectedOccurrence->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->expectedDetection->Visible) { // expectedDetection ?>
		<!-- expectedDetection -->
		<td<?php echo $actions_preview->expectedDetection->cellAttributes() ?>>
<span<?php echo $actions_preview->expectedDetection->viewAttributes() ?>><?php echo $actions_preview->expectedDetection->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->expectedRPNPAO->Visible) { // expectedRPNPAO ?>
		<!-- expectedRPNPAO -->
		<td<?php echo $actions_preview->expectedRPNPAO->cellAttributes() ?>>
<span<?php echo $actions_preview->expectedRPNPAO->viewAttributes() ?>><?php echo $actions_preview->expectedRPNPAO->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->expectedClosureDate->Visible) { // expectedClosureDate ?>
		<!-- expectedClosureDate -->
		<td<?php echo $actions_preview->expectedClosureDate->cellAttributes() ?>>
<span<?php echo $actions_preview->expectedClosureDate->viewAttributes() ?>><?php echo $actions_preview->expectedClosureDate->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->recomendedActiondet->Visible) { // recomendedActiondet ?>
		<!-- recomendedActiondet -->
		<td<?php echo $actions_preview->recomendedActiondet->cellAttributes() ?>>
<span<?php echo $actions_preview->recomendedActiondet->viewAttributes() ?>><?php echo $actions_preview->recomendedActiondet->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->idResponsibleDet->Visible) { // idResponsibleDet ?>
		<!-- idResponsibleDet -->
		<td<?php echo $actions_preview->idResponsibleDet->cellAttributes() ?>>
<span<?php echo $actions_preview->idResponsibleDet->viewAttributes() ?>><?php echo $actions_preview->idResponsibleDet->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->targetDatedet->Visible) { // targetDatedet ?>
		<!-- targetDatedet -->
		<td<?php echo $actions_preview->targetDatedet->cellAttributes() ?>>
<span<?php echo $actions_preview->targetDatedet->viewAttributes() ?>><?php echo $actions_preview->targetDatedet->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->kcdet->Visible) { // kcdet ?>
		<!-- kcdet -->
		<td<?php echo $actions_preview->kcdet->cellAttributes() ?>>
<span<?php echo $actions_preview->kcdet->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_kcdet" class="custom-control-input" value="<?php echo $actions_preview->kcdet->getViewValue() ?>" disabled<?php if (ConvertToBool($actions_preview->kcdet->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_kcdet"></label></div></span>
</td>
<?php } ?>
<?php if ($actions_preview->expectedSeveritydet->Visible) { // expectedSeveritydet ?>
		<!-- expectedSeveritydet -->
		<td<?php echo $actions_preview->expectedSeveritydet->cellAttributes() ?>>
<span<?php echo $actions_preview->expectedSeveritydet->viewAttributes() ?>><?php echo $actions_preview->expectedSeveritydet->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->expectedOccurrencedet->Visible) { // expectedOccurrencedet ?>
		<!-- expectedOccurrencedet -->
		<td<?php echo $actions_preview->expectedOccurrencedet->cellAttributes() ?>>
<span<?php echo $actions_preview->expectedOccurrencedet->viewAttributes() ?>><?php echo $actions_preview->expectedOccurrencedet->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->expectedDetectiondet->Visible) { // expectedDetectiondet ?>
		<!-- expectedDetectiondet -->
		<td<?php echo $actions_preview->expectedDetectiondet->cellAttributes() ?>>
<span<?php echo $actions_preview->expectedDetectiondet->viewAttributes() ?>><?php echo $actions_preview->expectedDetectiondet->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->expectedRPNPAD->Visible) { // expectedRPNPAD ?>
		<!-- expectedRPNPAD -->
		<td<?php echo $actions_preview->expectedRPNPAD->cellAttributes() ?>>
<span<?php echo $actions_preview->expectedRPNPAD->viewAttributes() ?>><?php echo $actions_preview->expectedRPNPAD->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->revisedClosureDatedet->Visible) { // revisedClosureDatedet ?>
		<!-- revisedClosureDatedet -->
		<td<?php echo $actions_preview->revisedClosureDatedet->cellAttributes() ?>>
<span<?php echo $actions_preview->revisedClosureDatedet->viewAttributes() ?>><?php echo $actions_preview->revisedClosureDatedet->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->revisedSeverity->Visible) { // revisedSeverity ?>
		<!-- revisedSeverity -->
		<td<?php echo $actions_preview->revisedSeverity->cellAttributes() ?>>
<span<?php echo $actions_preview->revisedSeverity->viewAttributes() ?>><?php echo $actions_preview->revisedSeverity->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->revisedOccurrence->Visible) { // revisedOccurrence ?>
		<!-- revisedOccurrence -->
		<td<?php echo $actions_preview->revisedOccurrence->cellAttributes() ?>>
<span<?php echo $actions_preview->revisedOccurrence->viewAttributes() ?>><?php echo $actions_preview->revisedOccurrence->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->revisedDetection->Visible) { // revisedDetection ?>
		<!-- revisedDetection -->
		<td<?php echo $actions_preview->revisedDetection->cellAttributes() ?>>
<span<?php echo $actions_preview->revisedDetection->viewAttributes() ?>><?php echo $actions_preview->revisedDetection->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($actions_preview->revisedRPNCalc->Visible) { // revisedRPNCalc ?>
		<!-- revisedRPNCalc -->
		<td<?php echo $actions_preview->revisedRPNCalc->cellAttributes() ?>>
<span<?php echo $actions_preview->revisedRPNCalc->viewAttributes() ?>><?php echo $actions_preview->revisedRPNCalc->getViewValue() ?></span>
</td>
<?php } ?>
<?php

// Render list options (body, right)
$actions_preview->ListOptions->render("body", "right", $actions_preview->RowCount);
?>
	</tr>
<?php
	$actions_preview->Recordset->MoveNext();
} // while
?>
	</tbody>
</table><!-- /.table -->
</div><!-- /.table-responsive -->
<div class="card-footer ew-grid-lower-panel ew-preview-lower-panel"><!-- .card-footer -->
<?php echo $actions_preview->Pager->render() ?>
<?php } else { // No record ?>
<div class="card no-border">
<div class="ew-detail-count"><?php echo $Language->phrase("NoRecord") ?></div>
<?php } ?>
<div class="ew-preview-other-options">
<?php
	foreach ($actions_preview->OtherOptions as $option)
		$option->render("body");
?>
</div>
<?php if ($actions_preview->TotalRecords > 0) { ?>
<div class="clearfix"></div>
</div><!-- /.card-footer -->
<?php } ?>
</div><!-- /.card -->
<?php
$actions_preview->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php
if ($actions_preview->Recordset)
	$actions_preview->Recordset->Close();

// Output
$content = ob_get_contents();
ob_end_clean();
echo ConvertToUtf8($content);
?>
<?php
$actions_preview->terminate();
?>