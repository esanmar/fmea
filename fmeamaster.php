<?php
namespace PHPMaker2020\fmeaPRD;
?>
<?php if ($fmea->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_fmeamaster" class="table ew-view-table ew-master-table ew-vertical">
	<tbody>
<?php if ($fmea->fmea->Visible) { // fmea ?>
		<tr id="r_fmea">
			<td class="<?php echo $fmea->TableLeftColumnClass ?>"><?php echo $fmea->fmea->caption() ?></td>
			<td <?php echo $fmea->fmea->cellAttributes() ?>>
<span id="el_fmea_fmea">
<span<?php echo $fmea->fmea->viewAttributes() ?>><?php echo $fmea->fmea->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($fmea->idFactory->Visible) { // idFactory ?>
		<tr id="r_idFactory">
			<td class="<?php echo $fmea->TableLeftColumnClass ?>"><?php echo $fmea->idFactory->caption() ?></td>
			<td <?php echo $fmea->idFactory->cellAttributes() ?>>
<span id="el_fmea_idFactory">
<span<?php echo $fmea->idFactory->viewAttributes() ?>><?php echo $fmea->idFactory->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($fmea->dateFmea->Visible) { // dateFmea ?>
		<tr id="r_dateFmea">
			<td class="<?php echo $fmea->TableLeftColumnClass ?>"><?php echo $fmea->dateFmea->caption() ?></td>
			<td <?php echo $fmea->dateFmea->cellAttributes() ?>>
<span id="el_fmea_dateFmea">
<span<?php echo $fmea->dateFmea->viewAttributes() ?>><?php echo $fmea->dateFmea->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($fmea->partnumbers->Visible) { // partnumbers ?>
		<tr id="r_partnumbers">
			<td class="<?php echo $fmea->TableLeftColumnClass ?>"><?php echo $fmea->partnumbers->caption() ?></td>
			<td <?php echo $fmea->partnumbers->cellAttributes() ?>>
<span id="el_fmea_partnumbers">
<span<?php echo $fmea->partnumbers->viewAttributes() ?>><?php echo $fmea->partnumbers->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($fmea->description->Visible) { // description ?>
		<tr id="r_description">
			<td class="<?php echo $fmea->TableLeftColumnClass ?>"><?php echo $fmea->description->caption() ?></td>
			<td <?php echo $fmea->description->cellAttributes() ?>>
<span id="el_fmea_description">
<span<?php echo $fmea->description->viewAttributes() ?>><?php echo $fmea->description->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($fmea->idEmployee->Visible) { // idEmployee ?>
		<tr id="r_idEmployee">
			<td class="<?php echo $fmea->TableLeftColumnClass ?>"><?php echo $fmea->idEmployee->caption() ?></td>
			<td <?php echo $fmea->idEmployee->cellAttributes() ?>>
<span id="el_fmea_idEmployee">
<span<?php echo $fmea->idEmployee->viewAttributes() ?>><?php echo $fmea->idEmployee->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($fmea->idworkcenter->Visible) { // idworkcenter ?>
		<tr id="r_idworkcenter">
			<td class="<?php echo $fmea->TableLeftColumnClass ?>"><?php echo $fmea->idworkcenter->caption() ?></td>
			<td <?php echo $fmea->idworkcenter->cellAttributes() ?>>
<span id="el_fmea_idworkcenter">
<span<?php echo $fmea->idworkcenter->viewAttributes() ?>><?php echo $fmea->idworkcenter->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>