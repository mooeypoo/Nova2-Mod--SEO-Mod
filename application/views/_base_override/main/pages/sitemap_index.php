<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo img($images['logo']); ?>
<?php echo text_output($header, 'h1', 'page-head');?>

<?php /*print_r($sitemaps); ?>


<?php print_r($sections);*/ ?>

				<?php if (isset($sitemaps)) { ?>
					<table class="zebra" width="400">
						<tbody>
						<?php foreach ($sitemaps as $m) { ?>
							<tr>
								<td colspan="2">
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
								<td>[ <?php print anchor('sitemap/html/'.$m['id'], 'HTML'); ?> ]</td>
								<td>[ <?php print anchor('sitemap/xml/'.$m['id'], 'XML'); ?> ]</td>
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
										<td>[ <?php print anchor('sitemap/html/'.$s['id'], 'HTML'); ?> ]</td>
										<td>[ <?php print anchor('sitemap/xml/'.$s['id'], 'XML'); ?> ]</td>
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
