<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo text_output($text);?>

<?php echo form_open('seo/index/delmap');?>
	<?php echo form_hidden('mapid', $id);?>