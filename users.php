<?php 

?>

<div class="container-fluid">
	
	<div class="row px-5" style="margin-top:30px;">
	<div class="col-lg-12" style="padding:0;">
			<button class="btn btn-primary float-right btn-sm" id="new_user"><i class="fa fa-plus"></i> New user</button>
	</div>
	</div>
	<br>
	<div class="row px-5" style="margin-bottom:30px;">
		<div class="card col-lg-12">
			<div class="card-body">
				<table class="table-striped table-bordered col-md-12">
			<thead>
				<tr style="background:#08245b;">
					<th style="color:#ffff;text-indent:15px;padding:10px 0; border:none;" class="text-center">#</th>
					<th style="color:#ffff;text-indent:15px;padding:10px 0; border:none;" class="text-center">Name</th>
					<th style="color:#ffff;text-indent:15px;padding:10px 0; border:none;" class="text-center">Username</th>
					<th style="color:#ffff;text-indent:15px;padding:10px 0; border:none;" class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
 					include 'db_connect.php';
 					$users = $conn->query("SELECT * FROM users order by name asc");
 					$i = 1;
 					while($row= $users->fetch_assoc()):
				 ?>
				 <tr>
				 	<td style="text-align:center; padding: 15px 0;">
				 		<?php echo $i++ ?>
				 	</td>
				 	<td style="text-align:center; padding: 15px 0;">
				 		<?php echo $row['name'] ?>
				 	</td>
				 	<td style="text-align:center; padding: 15px 0;">
				 		<?php echo $row['username'] ?>
				 	</td>
				 	<td style="text-align:center; padding: 15px 0;">
				 		<center>
								<div class="btn-group">
								  <button type="button" class="btn btn-primary">Action</button>
								  <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    <span class="sr-only">Toggle Dropdown</span>
								  </button>
								  <div class="dropdown-menu">
								  <?php if($_SESSION['login_type'] == 0): ?>
								    <a class="dropdown-item edit_user" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Edit</a>
								    <div class="dropdown-divider"></div>
									<?php endif; ?>
								    <a class="dropdown-item delete_user" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Delete</a>
								  </div>
								</div>
								</center>
				 	</td>
				 </tr>
				<?php endwhile; ?>
			</tbody>
		</table>
			</div>
		</div>
	</div>

</div>
<script>
	
$('#new_user').click(function(){
	uni_modal('🕵 New User','manage_user.php')
})
$('.edit_user').click(function(){
	uni_modal('🕵 Edit User','manage_user.php?id='+$(this).attr('data-id'))
})
$('.delete_user').click(function(){
    var user_id = $(this).attr('data-id');
    var confirm_delete = confirm("Are you sure you want to delete this user?");
    if(confirm_delete){
        // Add an ajax request here to delete the user from the database
        $.ajax({
            url: 'delete_user.php',
            method: 'post',
            data: {'user_id': user_id},
            success: function(response){
				alert('User has been deleted successfully');
        		location.reload();
            }
        });
    }
});
</script>