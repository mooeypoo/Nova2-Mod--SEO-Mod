<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo form_open('seo/index/editsection');?>
			<table class="table100">
		<tbody>
			<tr>
				<td class="cell-label">Section Name</td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['title']);?></td>
			</tr>
			<tr>
				<td class="cell-label">Section Description</td>
				<td class="cell-spacer"></td>
				<td><textarea name="sec_desc" id="sec_desc" cols=50 rows=5><?php echo $inputs['desc']; ?></textarea></td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
		</tbody>
	</table>
	<?php echo form_hidden('id', $id);?>

