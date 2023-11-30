<?php 
// localhost
error_reporting(0);

include 'db_connect.php';
session_start();

$folder_parent = isset($_GET['fid'])? $_GET['fid'] : 0;
$sort_option = "asc";
$sort_order = "name";

if(isset($_GET['sort_alphabet'])) {
  if($_GET['sort_alphabet'] == 'a-z') {
    $sort_option = 'ASC';
  } else if($_GET['sort_alphabet'] == 'z-a') {
    $sort_option = 'DESC';
  } else if($_GET['sort_alphabet'] == 'l') {  //latest upload
    $sort_option = 'DESC';
    $sort_order = 'id';
  }
}

$semester = isset($_GET['semester'])? $_GET['semester'] : '';

$query = "WITH RECURSIVE subfolders (id, parent_id, name, semester, user_id) AS (
    SELECT id, parent_id, name, semester, user_id FROM folders WHERE parent_id = $folder_parent
    UNION ALL
    SELECT f.id, f.parent_id, f.name, f.semester, f.user_id FROM subfolders s, folders f WHERE s.id = f.parent_id
)
SELECT * FROM subfolders WHERE user_id = '".$_SESSION['login_id']."'";

if ($semester == '1st_semester') {
    $query .= " AND semester = '1st Semester'";
} else if ($semester == '2nd_semester') {
    $query .= " AND semester = '2nd Semester'";
}
$query .= " ORDER BY $sort_order $sort_option";

$folders = $conn->query($query);


if($folders === false) {
    trigger_error('Wrong SQL: ' . $query . ' Error: ' . $conn->error, E_USER_ERROR);
}

$sort = "all";
if(isset($_GET['sort'])) {
    $sort = $_GET['sort'];
    if($sort == "all") {
      $files = $conn->query("SELECT * FROM files WHERE folder_id = $folder_parent and user_id = '".$_SESSION['login_id']."' order by $sort_order $sort_option ");
    } else if($sort == "internal") {
      $files = $conn->query("SELECT * FROM files WHERE type = 'internal' AND folder_id = $folder_parent and user_id = '".$_SESSION['login_id']."' order by $sort_order $sort_option ");
    } else if($sort == "external") {
      $files = $conn->query("SELECT * FROM files WHERE type = 'external' AND folder_id = $folder_parent and user_id = '".$_SESSION['login_id']."' order by $sort_order $sort_option ");
    } else if($sort == "best") {
      $files = $conn->query("SELECT * FROM files WHERE type = 'best' AND folder_id = $folder_parent and user_id = '".$_SESSION['login_id']."' order by $sort_order $sort_option ");
    }
  } else {
    $files = $conn->query("SELECT * FROM files where folder_id = $folder_parent and user_id = '".$_SESSION['login_id']."' order by $sort_order $sort_option ");
  }
?>

<style>
	.folder-item{
		cursor: pointer;
	}
	.folder-item:hover{
		background: #eaeaea;
	    color: black;
	    box-shadow: 3px 3px #0000000f;
	}
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
#menu-folder-clone,
#menu-file-clone{
	color:black;
}
.up{
	position:absolute;
	left:800px;
	bottom:5px;
}

</style>
<div class="container-fluid px-5">
	<div class="col-lg-12">
		<div class="row" style="margin-top:40px;">
			<div class="card col-lg-12">
				<div class="card-body" id="paths">
				<!-- <a href="index.php?page=files" class="">..</a>/ -->
				<?php 
				$id=$folder_parent;

			while($id > 0){

					$path = $conn->query("SELECT * FROM folders where id = $id  order by name $sort_option ")->fetch_array();
					echo '<script>
						$("#paths").prepend("<a href=\"index.php?page=files&fid='.$path['id'].'\">'.$path['name'].'</a>/")
					</script>';
					$id = $path['parent_id'];

				}

			
		echo '<script>
						$("#paths").prepend("<a href=\"index.php?page=files\">..</a>/")
					</script>';
				?>
					
				</div>
			</div>
		</div>

		<div class="row" style="margin-top:20px;" >
			<button class="btn btn-primary btn-sm" id="new_folder"><i class="fa fa-plus"></i> New Folder</button>
			<button class="btn btn-primary btn-sm ml-4" id="new_file"><i class="fa fa-upload"></i> Upload File</button>
		</div>
		<hr class="row">
		<div class="row">
			<div class="col-lg-12" style="padding:0;">
			 <div class="col-md-4 input-group" style=" padding:0; float: right;">
				
					<input type="text" class="form-control" id="search" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
					<div class="input-group-append">
						<span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa fa-search"></i></span>
					</div>
			 </div>

				</div>
			</div>
		</div>
			</div>
		</div>
            <div class="container-fluid px-5" style="margin-top:20px;">
              <div class="col-md-12"  style="padding:0;"><h4><b>Folders</b></h4>
                <button style="margin-right:10px;" class="btn btn-secondary" id="all" onclick="location.href='?page=files&fid=<?php echo $folder_parent; ?>'">All</button>
                <button style="margin-right:10px;" class="btn btn-primary" id="1st_semester" onclick="location.href='?page=files&semester=1st_semester&fid=<?php echo $folder_parent; ?>'">1st Semester</button>
                <button style="margin-right:10px;" class="btn btn-secondary" id="2nd_semester" onclick="location.href='?page=files&semester=2nd_semester&fid=<?php echo $folder_parent; ?>'">2nd Semester</button>
              </div>
            </div>
		</div>

		<div class="row px-5" style="margin-top:10px;">
			<?php 
			while($row=$folders->fetch_assoc()):
			?>
				<div class="card col-md-3 mt-2  mr-2 mb-2 folder-item" data-id="<?php echo $row['id'] ?>" style="margin-left:14px;">
					<div class="card-body">
							<large><span style="color:#08245b;"><i class="fa fa-folder"></i></span><b class="to_folder"> <?php echo $row['name'] ?></b></large>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
		<hr>
		<div class="container-fluid px-5" style="margin-bottom:40px; margin-top:40px;">
			<div class="card col-md-12">
				<div class="card-body">
				<table width="100%">
						<tr style="background:#08245b;">
							<th style="color:#ffff;text-indent:15px;padding:10px 0;" width="40%">Filename</th>
							<th style="color:#ffff;text-indent:15px;padding:10px 0;" width="20%">Date</th>
							<th style="color:#ffff;text-indent:15px;padding:10px 0;" width="30%">Description</th>
							<?php if($_SESSION['login_type'] == 2): ?>
							<th style="color:#ffff;padding:10px; text-align:left;" width="10%">Types</th>
							<?php endif; ?>
							<?php if($_SESSION['login_type'] == 1): ?>
								<th style="padding:10px; background-color:#08245b; color:#FFFFFF; text-align:left;">
									<form method="get" action="index.php">
										<input type="hidden" name="page" value="files">
										<input type="hidden" name="fid" value="<?php echo $folder_parent; ?>">
										<select name="sort" onchange='this.form.submit()' id="sort" style="background-color:#FFFFFF; color:#000000; border:1px solid #08245b; padding-left:15px;">
											<option selected disabled style="display: none; color:#FFFFFF; color:#08245b;">Types</option>
											<option value="all" style="color:#000000;">All</option>
											<option value="internal" style="color:#000000;">Internal</option>
											<option value="external" style="color:#000000;">External</option>
											<option value="best" style="color:#000000;">Best</option>
										</select>
										
										<noscript><button type="submit" class="btn btn-primary">Sort</button></noscript>
									</form>
								</th>
							<?php endif; ?>

						</tr>
						<?php        //  file name
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
						<tr class='file-item' data-id="<?php echo $row['id'] ?>" data-name="<?php echo $name ?>"  style="border-bottom: 1px solid #5A5A5A;">
							<td style="padding:10px 0;"><large><span style="color:#17a2b8;"><i class="fa <?php echo $icon ?>"></i></span><b class="to_file">&nbsp;&nbsp; <?php echo $name ?></b></large>
							<input type="text" class="rename_file" value="<?php echo $row['name'] ?>" data-id="<?php echo $row['id'] ?>" data-type="<?php echo $row['file_type'] ?>" style="display: none">

							</td>
							<td style="padding:10px 0;"><i class="to_file"><?php echo date('Y/m/d h:i A',strtotime($row['date_updated'])) ?></i></td>
							<td style="padding:10px 0;"><i class="to_file"><?php echo $row['description'] ?></i></td>
							<td style="padding:10px 0;"><i class="to_file"><?php echo $row['type'] ?></i></td>
						</tr>
							
					<?php endwhile; ?>
					</table>
					
				</div>
			</div>
			
		</div>
	</div>
</div>
<div id="menu-folder-clone" style="display: none;">
	<a href="javascript:void(0)" class="custom-menu-list file-option edit">Rename</a>
	<a href="javascript:void(0)" class="custom-menu-list file-option delete">Delete</a>
</div>
<div id="menu-file-clone" style="display: none;">
	<a href="javascript:void(0)" class="custom-menu-list file-option view"><span><i class="fa fa-eye" style="color:black;"></i> </span>View</a>
	<a href="javascript:void(0)" class="custom-menu-list file-option edit"><span style="color:black;"><i class="fa fa-edit"></i> </span>Rename</a>
	<a href="javascript:void(0)" class="custom-menu-list file-option download"><span style="color:black;"><i class="fa fa-download"></i> </span>Download</a>
	<a href="javascript:void(0)" class="custom-menu-list file-option delete"><span style="color:black;"><i class="fa fa-trash"></i> </span>Delete</a>
</div>

<script>
	
	$('#new_folder').click(function(){
		uni_modal('','manage_folder.php?fid=<?php echo $folder_parent ?>')
	})
	$('#new_file').click(function(){
		uni_modal('','manage_files.php?fid=<?php echo $folder_parent ?>')
	})
	$('.folder-item').dblclick(function(){
		location.href = 'index.php?page=files&fid='+$(this).attr('data-id')
	})
	$('.folder-item').bind("contextmenu", function(event) { 
    event.preventDefault();
    $("div.custom-menu").hide();
    var custom =$("<div class='custom-menu'></div>")
        custom.append($('#menu-folder-clone').html())
        custom.find('.edit').attr('data-id',$(this).attr('data-id'))
        custom.find('.delete').attr('data-id',$(this).attr('data-id'))
    custom.appendTo("body")
	custom.css({top: event.pageY + "px", left: event.pageX + "px"});

	$("div.custom-menu .edit").click(function(e){
		e.preventDefault()
		uni_modal('Rename Folder','manage_folder.php?fid=<?php echo $folder_parent ?>&id='+$(this).attr('data-id') )
	})
	$("div.custom-menu .delete").click(function(e){
		e.preventDefault()
		_conf("Are you sure to delete this Folder?",'delete_folder',[$(this).attr('data-id')])
	})
})

	//FILE
	$('.file-item').bind("contextmenu", function(event) { 
    event.preventDefault();

    $('.file-item').removeClass('active')
    $(this).addClass('active')
    $("div.custom-menu").hide();
    var custom =$("<div class='custom-menu file'></div>")
        custom.append($('#menu-file-clone').html())
		custom.find('.view').attr('data-id',$(this).attr('data-id'))
        custom.find('.edit').attr('data-id',$(this).attr('data-id'))
        custom.find('.delete').attr('data-id',$(this).attr('data-id'))
        custom.find('.download').attr('data-id',$(this).attr('data-id'))
    custom.appendTo("body")
	custom.css({top: event.pageY + "px", left: event.pageX + "px"});

	$("div.file.custom-menu .edit").click(function(e){
		e.preventDefault()
		$('.rename_file[data-id="'+$(this).attr('data-id')+'"]').siblings('large').hide();
		$('.rename_file[data-id="'+$(this).attr('data-id')+'"]').show();
	})
	$("div.file.custom-menu .delete").click(function(e){
		e.preventDefault()
		_conf("Are you sure to delete this file?",'delete_file',[$(this).attr('data-id')])
	})
	$("div.file.custom-menu .download").click(function(e){
		e.preventDefault()
		window.open('download.php?id='+$(this).attr('data-id'))
	})
	$("div.file.custom-menu .view").click(function(e){
	e.preventDefault()
	window.open('view.php?id='+$(this).attr('data-id'))
	})

	$('.rename_file').keypress(function(e){
		var _this = $(this)
		if(e.which == 13){
			start_load()
			$.ajax({
				url:'ajax.php?action=file_rename',
				method:'POST',
				data:{id:$(this).attr('data-id'),name:$(this).val(),type:$(this).attr('data-type'),folder_id:'<?php echo $folder_parent ?>'},
				success:function(resp){
					if(typeof resp != undefined){
						resp = JSON.parse(resp);
						if(resp.status== 1){
								_this.siblings('large').find('b').html(resp.new_name);
								end_load();
								_this.hide()
								_this.siblings('large').show()
						}
					}
				}
			})
		}
	})

})
//FILE


	$('.file-item').click(function(){
		if($(this).find('input.rename_file').is(':visible') == true)
    	return false;
		uni_modal($(this).attr('data-name'),'manage_files.php?<?php echo $folder_parent ?>&id='+$(this).attr('data-id'))
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

});
$(document).ready(function(){
    $('#search').keyup(function(){
        var search_query = $(this).val().toLowerCase();
        $('.card, tr').each(function(){
            var val  = $(this).text().toLowerCase();
            if(val.includes(search_query)){
                $(this).show();
            }else{
                $(this).hide();
            }
        });
    });
});
	function delete_folder($id){
		start_load();
		$.ajax({
			url:'ajax.php?action=delete_folder',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp == 1){
					alert_toast("Folder successfully deleted.",'success')
						setTimeout(function(){
							location.reload()
						},1500)
				}
			}
		})
	}
	function delete_file($id){
		start_load();
		$.ajax({
			url:'ajax.php?action=delete_file',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp == 1){
					alert_toast("Folder successfully deleted.",'success')
						setTimeout(function(){
							location.reload()
						},1500)
				}
			}
		})
	}

</script>