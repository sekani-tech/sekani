<?php 
include('../../../functions/connect.php');

if(isset($_POST['id'])){
	$id=$_POST['id'];
	$cache_id = $_POST["redca"];
	?>
	<input type="text" value="<?php echo $cache_id?>" hidden id="cache_id_res">
	<?php
   // redca is cache id that needs to be reloaded into post_client_group.php

	$query =delete('group_client_cache',$id,'id');  
	
	if ($query) {
	    // If Good - Run a javascript that page (postclient group) to refresh and display to add group member id="erio"
		?>
		<!-- Load Javascript (Passing Previous data on action) -->
		<script type="text/javascript">
			var group_cache_id = $('#cache_id_res').val();
			$.ajax({
				url: "ajax_post/post_client_group.php", 
				method: "POST",
				data:{cache_id:group_cache_id},
				success: function(data) {
					$('#erio').html(data);
				}
			});
		</script>
		<!-- End Javascript -->

		<script type="text/javascript">alert( "Member was successfully removed");</script>
	<?php	} else {
		?>
		<script type="text/javascript">alert( "Error removing member");</script>
	<?php	}		
}

?>