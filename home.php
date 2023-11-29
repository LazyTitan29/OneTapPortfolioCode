
<style>
	.custom-menu {
        z-index: 1000;
	    position: absolute;
	    background-color: #ffffff;
	    border: 1px solid #0000001c;
	    border-radius: 5px;
	    padding: 8px;
	    min-width: 13vw;
}
a.custom-menu-list {
    width: 100%;
    display: flex;
    color: #4c4b4b;
    font-weight: 600;
    font-size: 1em;
    padding: 1px 11px;
}
	span.card-icon {
    position: absolute;
    font-size: 3em;
    bottom: .2em;
    color: #ffffff80;
}
.file-item{
	cursor: pointer;
}
a.custom-menu-list:hover,.file-item:hover,.file-item.active {
    background: #80808024;
}
table th,td{
	/*border-left:1px solid gray;*/
}
a.custom-menu-list span.icon{
		width:1em;
		margin-right: 5px
}
</style>

<div class="containe-fluid">
	<?php include('db_connect.php') ;
	
	$sort_option = "asc";
	$files = $conn->query("SELECT f.*,u.name as uname FROM files f inner join users u on u.id = f.user_id where  f.is_public = 1  ");

	if(isset($_GET['sort'])) {
		$sort = $_GET['sort'];
		if($sort == "all") {
		  $query = "SELECT f.*,u.name as uname FROM files f inner join users u on u.id = f.user_id where  f.is_public = 1 order by date(f.date_updated) $sort_option";
		} else if($sort == "internal") {
		  $query = "SELECT f.*,u.name as uname FROM files f inner join users u on u.id = f.user_id where  f.is_public = 1 and f.type = 'internal' order by date(f.date_updated) $sort_option";
		} else if($sort == "external") {
		  $query = "SELECT f.*,u.name as uname FROM files f inner join users u on u.id = f.user_id where  f.is_public = 1 and f.type = 'external' order by date(f.date_updated) $sort_option";
		} else if($sort == "best") {
		  $query = "SELECT f.*,u.name as uname FROM files f inner join users u on u.id = f.user_id where  f.is_public = 1 and f.type = 'best' order by date(f.date_updated) $sort_option";
		}
	} else {
		$query = "SELECT f.*,u.name as uname FROM files f inner join users u on u.id = f.user_id where  f.is_public = 1 order by date(f.date_updated) $sort_option";
	}
	
	$files = $conn->query($query);
	?>

	<?php if($_SESSION['login_type'] == 1): ?>
	<div class="row ml-1" style="margin-top:40px;">
		<div class="col-lg-12">
			<div class="card col-md-4 bg-info float-left" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
				<div class="card-body text-white">
					<h4><b>Users</b></h4>
					<hr>
					<span class="card-icon"><i class="fa fa-users"></i></span>
					<h3 class="text-right"><b><?php echo $conn->query('SELECT * FROM users')->num_rows ?></b></h3>
				</div>
			</div>
			<div class="card col-md-4 offset-2 bg-primary ml-4 float-left" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
				<div class="card-body text-white">
					<h4><b>Files</b></h4>
					<hr>
					<span class="card-icon"><i class="fa fa-file"></i></span>
					<h3 class="text-right"><b><?php echo $conn->query('SELECT * FROM files')->num_rows ?></b></h3>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<div class="row mt-3 ml-3 mr-3">
			<div class="card col-md-12">
				<div class="card-body">
				<h2>Keep up to date</h2>
					<table width="100%">
						<tr style="background:#08245b;">
							<th width="20%"  style="color:#ffff;text-indent:15px;padding:10px 0;" class="">Uploader</th>
							<th width="30%"  style="color:#ffff;text-indent:15px;padding:10px 0;" class="">Filename</th>
							<th width="20%"  style="color:#ffff;text-indent:15px;padding:10px 0;" class="">Date</th>
							<th width="30%"  style="color:#ffff;text-indent:15px;padding:10px 0;" class="">Description</th>
							<th  class="">
							<form method="get" action="index.php">
							<input type="hidden" name="page" value="home">
							<input type="hidden" name="fid" value="<?php echo $folder_parent; ?>">
							<select name="sort" onchange='this.form.submit()' id="sort" style="margin-right:15px;">
								<option>Sorting</option>
								<option value="all">All</option>
								<option value="internal">Internal</option>
								<option value="external">External</option>
								<option value="best">Best</option>
							</select>
							
							
							<noscript> <button type="submit" class="btn btn-primary">Sort</button> </noscript>
							</form>

							</th>
						</tr>
						<?php 
					while($row=$files->fetch_assoc()):
						$name = explode(' ||',$row['name']);
						$name = isset($name[1]) ? $name[0] ." (".$name[1].").".$row['file_type'] : $name[0] .".".$row['file_type'];
						$img_arr = array('png','jpg','jpeg','gif','psd','tif');
						$doc_arr =array('doc','docx');
						$pdf_arr =array('pdf','ps','eps','prn');
						$icon ='fa-file';
						if(in_array(strtolower($row['file_type']),$img_arr))
							$icon ='fa-image';
						if(in_array(strtolower($row['file_type']),$doc_arr))
							$icon ='fa-file-word';
						if(in_array(strtolower($row['file_type']),$pdf_arr))
							$icon ='fa-file-pdf';
						if(in_array(strtolower($row['file_type']),['xlsx','xls','xlsm','xlsb','xltm','xlt','xla','xlr']))
							$icon ='fa-file-excel';
						if(in_array(strtolower($row['file_type']),['zip','rar','tar']))
							$icon ='fa-file-archive';

					?>
						<tr class='file-item' data-id="<?php echo $row['id'] ?>" data-name="<?php echo $name ?>" style="border-bottom: 1px solid #5A5A5A;">
							<td style="padding:10px 0;"><i><?php echo ucwords($row['uname']) ?></i></td> 
							<td style="padding:10px 0;"><large><span style="color:#17a2b8;"><i class="fa <?php echo $icon ?>"></i></span><b>&nbsp;&nbsp; <?php echo $name ?></b></large>
							<input type="text" class="rename_file" value="<?php echo $row['name'] ?>" data-id="<?php echo $row['id'] ?>" data-type="<?php echo $row['file_type'] ?>" style="display: none">

							</td>
							<td style="padding:10px 0;"><i><?php echo date('Y/m/d h:i A',strtotime($row['date_updated'])) ?></i></td>
							<td style="padding:10px 0;"><i><?php echo $row['description'] ?></i></td>
							<td style="padding:10px 0;"><i class="to_file"><?php echo $row['type'] ?></i></td>
						</tr>
							
					<?php endwhile; ?>
					</table>
					
				</div>
			</div>
			
		</div>
	</div>

</div>
<div id="menu-file-clone" style="display: none;">
	<a href="javascript:void(0)" class="custom-menu-list file-option download"><span><i class="fa fa-download" style="color:black;"></i> </span>Download</a>
	<a href="javascript:void(0)" class="custom-menu-list file-option view"><span><i class="fa fa-eye" style="color:black;"></i> </span>View</a>
</div>
<script>
	//FILE
	$('.file-item').bind("contextmenu", function(event) { 
    event.preventDefault();

$('.file-item').removeClass('active')
$(this).addClass('active')
$("div.custom-menu").hide();
var custom =$("<div class='custom-menu file'></div>")
    custom.append($('#menu-file-clone').html())
    custom.find('.download').attr('data-id',$(this).attr('data-id'))
    custom.find('.view').attr('data-id',$(this).attr('data-id'))
custom.appendTo("body")
custom.css({top: event.pageY + "px", left: event.pageX + "px"});


$("div.file.custom-menu .download").click(function(e){
	e.preventDefault()
	window.open('download.php?id='+$(this).attr('data-id'))
})
$("div.file.custom-menu .view").click(function(e){
	e.preventDefault()
	window.open('view.php?id='+$(this).attr('data-id'))
})

})
$(document).bind("click", function(event) {
$("div.custom-menu").hide();
$('#file-item').removeClass('active')

});
$(document).keyup(function(e){


if(e.keyCode === 27){
    $("div.custom-menu").hide();
$('#file-item').removeClass('active')

}
})
</script>