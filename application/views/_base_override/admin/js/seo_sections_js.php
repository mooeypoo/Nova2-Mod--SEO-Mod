<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>



<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');

		$('#add').click(function(){
			$('#add-panel').slideDown();
			return false;
		});
		

		$("a[rel=facebox]").click(function() {
			var action = $(this).attr('myAction');
			var id = $(this).attr('myID');
			var secid = $(this).attr('mySecID');

			if (action == 'delete')
				var location = '<?php echo site_url('seoajax/del_link');?>/' + id + '/' + secid + '/<?php echo $string;?>';
			
			if (action == 'edit')
				var location = '<?php echo site_url('seoajax/edit_link');?>/' + id + '/' + secid + '/<?php echo $string;?>';
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});


	});
</script>