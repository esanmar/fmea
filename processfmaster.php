<?php
namespace PHPMaker2020\fmeaPRD;
?>
<?php if ($processf->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_processfmaster" class="table ew-view-table ew-master-table ew-vertical">
	<tbody>
<?php if ($processf->fmea->Visible) { // fmea ?>
		<tr id="r_fmea">
			<td class="<?php echo $processf->TableLeftColumnClass ?>"><?php echo $processf->fmea->caption() ?></td>
			<td <?php echo $processf->fmea->cellAttributes() ?>>
<span id="el_processf_fmea">
<span<?php echo $processf->fmea->viewAttributes() ?>><?php echo $processf->fmea->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($processf->step->Visible) { // step ?>
		<tr id="r_step">
			<td class="<?php echo $processf->TableLeftColumnClass ?>"><?php echo $processf->step->caption() ?></td>
			<td <?php echo $processf->step->cellAttributes() ?>>
<span id="el_processf_step">
<span<?php echo $processf->step->viewAttributes() ?>><?php echo $processf->step->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($processf->flowchartDesc->Visible) { // flowchartDesc ?>
		<tr id="r_flowchartDesc">
			<td class="<?php echo $processf->TableLeftColumnClass ?>"><?php echo $processf->flowchartDesc->caption() ?></td>
			<td <?php echo $processf->flowchartDesc->cellAttributes() ?>>
<span id="el_processf_flowchartDesc">
<span<?php echo $processf->flowchartDesc->viewAttributes() ?>><?php echo $processf->flowchartDesc->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($processf->partnumber->Visible) { // partnumber ?>
		<tr id="r_partnumber">
			<td class="<?php echo $processf->TableLeftColumnClass ?>"><?php echo $processf->partnumber->caption() ?></td>
			<td <?php echo $processf->partnumber->cellAttributes() ?>>
<span id="el_processf_partnumber">
<span<?php echo $processf->partnumber->viewAttributes() ?>><?php echo $processf->partnumber->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($processf->operation->Visible) { // operation ?>
		<tr id="r_operation">
			<td class="<?php echo $processf->TableLeftColumnClass ?>"><?php echo $processf->operation->caption() ?></td>
			<td <?php echo $processf->operation->cellAttributes() ?>>
<span id="el_processf_operation">
<span<?php echo $processf->operation->viewAttributes() ?>><?php echo $processf->operation->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($processf->derivedFromNC->Visible) { // derivedFromNC ?>
		<tr id="r_derivedFromNC">
			<td class="<?php echo $processf->TableLeftColumnClass ?>"><?php echo $processf->derivedFromNC->caption() ?></td>
			<td <?php echo $processf->derivedFromNC->cellAttributes() ?>>
<span id="el_processf_derivedFromNC">
<span<?php echo $processf->derivedFromNC->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_derivedFromNC" class="custom-control-input" value="<?php echo $processf->derivedFromNC->getViewValue() ?>" disabled<?php if (ConvertToBool($processf->derivedFromNC->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_derivedFromNC"></label></div></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($processf->numberOfNC->Visible) { // numberOfNC ?>
		<tr id="r_numberOfNC">
			<td class="<?php echo $processf->TableLeftColumnClass ?>"><?php echo $processf->numberOfNC->caption() ?></td>
			<td <?php echo $processf->numberOfNC->cellAttributes() ?>>
<span id="el_processf_numberOfNC">
<span<?php echo $processf->numberOfNC->viewAttributes() ?>><?php echo $processf->numberOfNC->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($processf->flowchart->Visible) { // flowchart ?>
		<tr id="r_flowchart">
			<td class="<?php echo $processf->TableLeftColumnClass ?>"><?php echo $processf->flowchart->caption() ?></td>
			<td <?php echo $processf->flowchart->cellAttributes() ?>>
<span id="el_processf_flowchart">
<span<?php echo $processf->flowchart->viewAttributes() ?>><?php echo $processf->flowchart->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($processf->subprocess->Visible) { // subprocess ?>
		<tr id="r_subprocess">
			<td class="<?php echo $processf->TableLeftColumnClass ?>"><?php echo $processf->subprocess->caption() ?></td>
			<td <?php echo $processf->subprocess->cellAttributes() ?>>
<span id="el_processf_subprocess">
<span<?php echo $processf->subprocess->viewAttributes() ?>><?php echo $processf->subprocess->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($processf->requirement->Visible) { // requirement ?>
		<tr id="r_requirement">
			<td class="<?php echo $processf->TableLeftColumnClass ?>"><?php echo $processf->requirement->caption() ?></td>
			<td <?php echo $processf->requirement->cellAttributes() ?>>
<span id="el_processf_requirement">
<span<?php echo $processf->requirement->viewAttributes() ?>><?php echo $processf->requirement->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($processf->potencialFailureMode->Visible) { // potencialFailureMode ?>
		<tr id="r_potencialFailureMode">
			<td class="<?php echo $processf->TableLeftColumnClass ?>"><?php echo $processf->potencialFailureMode->caption() ?></td>
			<td <?php echo $processf->potencialFailureMode->cellAttributes() ?>>
<span id="el_processf_potencialFailureMode">
<span<?php echo $processf->potencialFailureMode->viewAttributes() ?>><?php echo $processf->potencialFailureMode->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($processf->potencialFailurEffect->Visible) { // potencialFailurEffect ?>
		<tr id="r_potencialFailurEffect">
			<td class="<?php echo $processf->TableLeftColumnClass ?>"><?php echo $processf->potencialFailurEffect->caption() ?></td>
			<td <?php echo $processf->potencialFailurEffect->cellAttributes() ?>>
<span id="el_processf_potencialFailurEffect">
<span<?php echo $processf->potencialFailurEffect->viewAttributes() ?>><?php echo $processf->potencialFailurEffect->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($processf->kc->Visible) { // kc ?>
		<tr id="r_kc">
			<td class="<?php echo $processf->TableLeftColumnClass ?>"><?php echo $processf->kc->caption() ?></td>
			<td <?php echo $processf->kc->cellAttributes() ?>>
<span id="el_processf_kc">
<span<?php echo $processf->kc->viewAttributes() ?>><div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" id="x_kc" class="custom-control-input" value="<?php echo $processf->kc->getViewValue() ?>" disabled<?php if (ConvertToBool($processf->kc->CurrentValue)) { ?> checked<?php } ?>><label class="custom-control-label" for="x_kc"></label></div></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($processf->severity->Visible) { // severity ?>
		<tr id="r_severity">
			<td class="<?php echo $processf->TableLeftColumnClass ?>"><?php echo $processf->severity->caption() ?></td>
			<td <?php echo $processf->severity->cellAttributes() ?>>
<span id="el_processf_severity">
<span<?php echo $processf->severity->viewAttributes() ?>><?php echo $processf->severity->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>