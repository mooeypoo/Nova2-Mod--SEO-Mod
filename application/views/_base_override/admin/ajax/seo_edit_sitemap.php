<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo form_open('seo/index/editmap');?>
			<table class="table100">
		<tbody>
			<tr>
				<td class="cell-label">Sitemap Name</td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['name']);?></td>
			</tr>
			<tr>
				<td class="cell-label">Sitemap Type</td>
				<td class="cell-spacer"></td>
				<td><?php echo form_dropdown('map_type',$inputopts['type'],$selval['map_type']);?></td>
			</tr>
			<tr>
				<td class="cell-label">Parent Index</td>
				<td class="cell-spacer"></td>
				<td><?php echo form_dropdown('map_parent',$inputopts['parent'],$selval['map_parent']); ?></td>
			</tr>

			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
<?php
		if ($map_type != 'index') {
?>

			<tr>
				<td colspan="3">
					<?php if (!empty($inputs['checkboxes'])) { 
							foreach ($inputs['checkboxes'] as $sec) {
								echo form_checkbox($sec);
								$st = "(User Defined)";
								$stl = "";
								if ($sec['isLocked'] == 'y') {
									$st = "(System)";
									$stl = " grey";
								}
							?>
								<label for='<?php echo $sec['name']; ?>'><?php echo $sec['isTitle']; ?> <span class="fontSmall <?php echo $stl; ?>"><?php echo $st; ?></span></label><br />
<?php						}
						}
					?>
				</td>
			</tr>
<?php
		}
?>
		</tbody>
	</table>
	<?php /*echo form_button($inputs['button']);*/?>
	<?php echo form_hidden('id', $id);?>

