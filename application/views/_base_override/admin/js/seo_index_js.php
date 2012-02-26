<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>


<?php 
	if (!isset($tab)) {
		$tab = 0;
	} 
	if (!isset($tab_general)) {
		$tab_general = 0;
	} 
?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#tabs').tabs();
		$('#tabs_general').tabs();
		$('#tabs').tabs('select', <?php echo $tab;?>);
		$('#tabs_general').tabs('select', <?php echo $tab_general;?>);

		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('#addmap').click(function(){
			$('#add-map-panel').slideDown();
			return false;
		});
		
		$('#addsec').click(function(){
			$('#add-sec-panel').slideDown();
			return false;
		});
		
		$("a[rel=facebox]").click(function() {
			var action = $(this).attr('myAction');
			var id = $(this).attr('myID');
			
			if (action == 'deletemap')
				var location = '<?php echo site_url('seoajax/del_sitemap');?>/' + id + '/<?php echo $string;?>';
			
			if (action == 'editmap')
				var location = '<?php echo site_url('seoajax/edit_sitemap');?>/' + id + '/<?php echo $string;?>';
			
			if (action == 'deletesec')
				var location = '<?php echo site_url('seoajax/del_section');?>/' + id + '/<?php echo $string;?>';
			
			if (action == 'editsec')
				var location = '<?php echo site_url('seoajax/edit_section');?>/' + id + '/<?php echo $string;?>';
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
		

	});
</script>