<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo img($images['logo']); ?>
<?php echo text_output($header, 'h1', 'page-head');?>


<div id="tabs">
	<ul>
		<li><a href="#one"><span><?php echo $label['seo_header_one'];?></span></a></li>
		<li><a href="#two"><span><?php echo $label['seo_header_two'];?></span></a></li>
		<li><a href="#three"><span><?php echo $label['seo_header_three'];?></span></a></li>
		<li><a href="#four"><span><?php echo $label['seo_header_four'];?></span></a></li>
	</ul>
	
	<div id="one">
		<?php echo form_open('seo/index/settings');?>
			<?php echo text_output($label['seo_header_one'], 'h2', 'page-subhead');?>
			<p>
				<kbd>Meta Description</kbd>
				<textarea name="seo_desc" id="seo_desc" cols=50 rows=5><?php echo $data['seo_desc']; ?></textarea>
			</p>
			<p>
				<kbd>Meta Tags</kbd>
				<small>(separate by comma)</small><br />
				<textarea name="seo_tags" id="seo_tags" cols=50 rows=5><?php echo $data['seo_tags']; ?></textarea>
			</p>
				<p><?php echo form_button($buttons['add']);?></p>
		<?php echo form_close();?>
			
	</div>

	<div id="two">
		<?php echo text_output($label['seo_header_two'], 'h2', 'page-subhead');?>
		
		<div id="tabs_general">
			<ul>
				<li><a href="#maps"><span>Maps</span></a></li>
				<li><a href="#sections"><span>Custom Sections</span></a></li>
			</ul>
			
			
			
		</div>
		
		
		
		
			<p><strong><a href="#" id="addmap" class="image"><?php echo img($images['add']).' '.$label['add'];?></a></strong></p>


		<div id="add-map-panel" class="info-full hidden">
			<?php echo form_open('seo/index/addmap');?>
				<p>
					<kbd>Sitemap Name</kbd>
					<?php echo form_input($inputs['sitemaps']['name']);?>
				</p>
				<p>
					<kbd>Sitemap Type</kbd>
					<?php echo form_dropdown('map_type',$inputopts['sitemaps']['type']);?>
				</p>
				<p>
					<kbd>Parent Index</kbd>
					<?php echo form_dropdown('map_parent',$inputopts['sitemaps']['parent']);?>
				</p>
				<p><?php echo form_button($buttons['add']);?></p>
			<?php echo form_close();?>
		</div> 

		<hr />

		<?php if (isset($sitemaps)) { ?>
			<table class="zebra" width="400">
				<tbody>
				<?php foreach ($sitemaps as $m) { ?>
					<tr>
						<td colspan='2'>
							<strong>
								<?php if ($m['active'] == 'n'): ?>
									<span class="fontSmall red">[ <?php echo $label['off'];?> ]</span>
								<?php endif;?>
								<?php echo $m['name'];?>
						<?php 	if ($m['type']=='index') { ?>
									<span class="fontSmall gray">INDEX</span>
						<?php	} ?>
						<?php	if (!($m['sections']=='')) { ?>
									<br /><span class="fontSmall red">(<?php echo $m['sections'];?>)</span>
						<?php 	} ?>
							</strong>
						</td>
						<td class="col_75 align_right">
							<a href="#" rel="facebox" class="image" myAction="deletemap" myID="<?php echo $m['id'];?>"><?php echo img($images['delete']);?></a>
							&nbsp;
							<a href="#" rel="facebox" class="image" myAction="editmap" myID="<?php echo $m['id'];?>"><?php echo img($images['edit']);?></a>
						</td>
					</tr>
					<?php if (!empty($m['sub'])) { //has daughter sitemaps
						$submaps = $m['sub'];
						foreach ($submaps as $s) { ?>
							<tr>
								<td width="15">&nbsp;</td>
								<td>
									<strong>
										<?php if ($s['active'] == 'n'): ?>
											<span class="fontSmall red">[ <?php echo $label['off'];?> ]</span>
										<?php endif;?>
										<?php echo $s['name'];?>
						<?php 	if ($s['type']=='index') { ?>
									<span class="fontSmall gray">INDEX</span>
						<?php	} ?>
						<?php	if (!($s['sections']=='')) { ?>
									<br /><span class="fontSmall red">(<?php echo $s['sections'];?>)</span>
						<?php 	} ?>
									</strong>
								</td>
								<td class="col_75 align_right">
									<a href="#" rel="facebox" class="image" myAction="deletemap" myID="<?php echo $s['id'];?>"><?php echo img($images['delete']);?></a>
									&nbsp;
									<a href="#" rel="facebox" class="image" myAction="editmap" myID="<?php echo $s['id'];?>"><?php echo img($images['edit']);?></a>
								</td>
							</tr>
						<?php
							} //end foreach ?>
					<?php } ?>
			<?php } ?>
				</tbody>
			</table>
		<?php } else { ?>
			<p>No sitemaps.</p>
		<?php }?>
	</div>

	<div id="three">
		<?php echo text_output($label['seo_header_three'], 'h2', 'page-subhead');?>
		<p>Custom sections are where you can add your own links to a sitemap. To start, add a section and name it, then you can add custom links to your section and assign it to a specific sitemap.</p>
			<p><strong><a href="#" id="addsec" class="image"><?php echo img($images['add']).' Add Section';?></a></strong></p>

		<div id="add-sec-panel" class="info-full hidden">
			<?php echo form_open('seo/index/addsection');?>
				<p>
					<kbd>Section Name</kbd>
					<?php echo form_input($inputs['sections']['name']);?>
				</p>
				<p>
					<kbd>Section Description</kbd>
					<textarea name="sec_desc" id="sec_desc" cols=50 rows=5></textarea>
				</p>
				<p><?php echo form_button($buttons['add']);?></p>
			<?php echo form_close();?>
		</div> 

		<hr />

		<?php if (isset($sections['custom'])) { ?>
			<table class="zebra" width="400">
				<tbody>
				<?php foreach ($sections['custom'] as $sec) { ?>
					<tr>
						<td colspan='2'>
							<strong>
								<?php echo $sec['title'];?>
								<span class="fontSmall red">(<?php echo $sec['links'];?> Links)</span>
							</strong>
						</td>
						<td class="col_75 align_right">
							<a href="#" rel="facebox" class="image" myAction="deletesec" myID="<?php echo $sec['id'];?>"><?php echo img($images['delete']);?></a>
							&nbsp;
							<a href="#" rel="facebox" class="image" myAction="editsec" myID="<?php echo $sec['id'];?>"><?php echo img($images['edit']);?></a>
							<a href="<?php echo site_url('seo/sections').'/'.$sec['id'];?>" id="seclinks" class="image"><?php echo img($images['assign']);?></a>
						</td>
					</tr>
			<?php } ?>
				</tbody>
			</table>
		<?php } else { ?>
			<p>No custom sections.</p>
		<?php }?>
	</div>

	<div id="four">
	<?php echo form_open('seo/index/robots');?>
		<?php echo text_output($label['seo_header_four'], 'h2', 'page-subhead');?>
			<p>COMING SOON!</p>
	</div>
</div>