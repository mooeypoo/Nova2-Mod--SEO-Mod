<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo form_open('seo/sections/'.$section['id'].'/editlink');?>
			<table class="table100">
		<tbody>
			<tr>
				<td class="cell-label">Link Title</td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['title']);?></td>
			</tr>
			<tr>
				<td class="cell-label">Link URL</td>
				<td class="cell-spacer"></td>
				<td><span class="fontSmall">(internal URLs, such as 'main/index' and 'personnel/index')</span>
					<br />
					<?php echo form_input($inputs['link']);?>
				</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
		</tbody>
	</table>
	<?php echo form_hidden('id', $id);?>
	<?php echo form_hidden('secid', $section['id']);?>

