<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<p><strong><?php echo anchor('seo/index', '<< Back to SEO Mod Configuration', array('class' => 'image'));?></strong></p><br />

<?php echo img($images['logo']); ?>
<?php echo text_output($header, 'h1', 'page-head');?>

<?php
	if (!empty($err)) {
		echo text_output($err, 'h3');
	} else {
?>
<p><strong><?php echo anchor('seo/sections/'.$section['id'], img($images['refresh']).' Refresh Page', array('class' => 'image'));?></strong></p><br />


<p><strong><a href="#" id="add" class="image"><?php echo img($images['add']).' '.$label['add'];?></a></strong></p>


		<div id="add-panel" class="info-full hidden">
			<?php echo form_open('seo/sections/'.$section['id'].'/addlink');?>
				<p>
					<kbd>Link Title</kbd>
					<?php echo form_input($inputs['title']);?>
				</p>
				<p>
					<kbd>Link URL</kbd>
					<span class="fontSmall grey">(internal URLs, such as 'main/index' and 'personnel/index')</span><br />
					<?php echo form_input($inputs['link']);?>
				</p>
				<?php echo form_hidden('secid', $section['id']);?>
				<p><?php echo form_button($inputs['button']);?></p>
			<?php echo form_close();?>
		</div> 

		<?php if (isset($links)) { ?>
			<table class="zebra" width="400">
				<tbody>
				<?php foreach ($links as $link) { ?>
					<tr>
						<td colspan='2'>
							<strong>
								<?php echo $link['title'];?>
							</strong><br />
							<span class="fontSmall grey">(<?php echo $link['link'];?>)</span>
						</td>
						<td class="col_75 align_right">
							<a href="#" rel="facebox" class="image" myAction="delete" myID="<?php echo $link['id'];?>" mySecID="<?php echo $section['id'];?>"><?php echo img($images['delete']);?></a>
							&nbsp;
							<a href="#" rel="facebox" class="image" myAction="edit" myID="<?php echo $link['id'];?>" mySecID="<?php echo $section['id'];?>"><?php echo img($images['edit']);?></a>
						</td>
					</tr>
			<?php } ?>
				</tbody>
			</table>
		<?php } else { ?>
			<p>No links in this section.</p>
		<?php }?>



<?php
	} //end if -- if (!empty($err)) 
?>