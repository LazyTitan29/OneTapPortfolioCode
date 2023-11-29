<?php 
include 'db_connect.php';
include 'admin_class.php';
?>
<div class="container-fluid">
  <form action="" id="manage-files">
    <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] :'' ?>">
    <input type="hidden" name="folder_id" value="<?php echo isset($_GET['fid']) ? $_GET['fid'] :'' ?>">
    <!-- <div class="form-group">
      <label for="name" class="control-label">File Name</label>
      <input type="text" name="name" id="name" value="<?php echo isset($meta['name']) ? $meta['name'] :'' ?>" class="form-control">
    </div> -->
    <?php if(!isset($_GET['id']) || empty($_GET['id'])): ?>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">Upload</span>
      </div>
      <div class="custom-file">
        <input type="file" class="custom-file-input" name="upload" id="upload" onchange="displayname(this,$(this))">
        <label class="custom-file-label" for="upload">Choose file</label>
      </div>
    </div>
  <?php endif; ?>
    <div class="form-group">
      <label for="" class="control-label">Description</label>
      <textarea name="description" id="" cols="100" rows="10" class="form-control"><?php echo isset($meta['description']) ? $meta['description'] :'' ?></textarea>
    </div>
	<?php if($_SESSION['login_type'] == 1): ?>
    <div class="form-group">
      <label for="is_public" class="control-label"><input type="checkbox" name="is_public" id="is_public"><i> Share to All Users</i></label>
    </div>
	<?php endif; ?>
    <div class="form-group" id="msg"></div>

  
    <select name="type" class="form-control">
  <option value="">Option</option>         
  <option value="internal" <?php if(isset($meta['type']) && $meta['type'] == 'internal') {echo 'selected';} ?>>Internal</option>
  <option value="external" <?php if(isset($meta['type']) && $meta['type'] == 'external') {echo 'selected';} ?>>External</option>
  <option value="best" <?php if(isset($meta['type']) && $meta['type'] == 'best') {echo 'selected';} ?>>Best</option>
</select>
<?php echo isset($meta['type']) ? $meta['type'] :'' ?>
  <!-- <input type="checkbox" id="show-options" onclick="toggleOptions()">
  <label for="show-options">Show options</label>
  <option value="">Option</option>
  <br>
  <br>

  <div id="options" style="display: none;">
    <label for="internal">Internal</label>
    <input type="radio" id="internal" name="type" value="internal">
    <br>
    <label for="external">External</label>
    <input type="radio" id="external" name="type" value="external">
    <br>
    <label for="best">Best Work</label>
    <input type="radio" id="best" name="type" value="best">
  </div>
 -->
</form>

</div>
<script>
  function toggleOptions() {
    var options = document.getElementById("options");
    if (options.style.display === "none") {
      options.style.display = "block";
    } else {
      options.style.display = "none";
    }
  }
  $(document).ready(function(){
    $('#manage-files').submit(function(e){
      e.preventDefault()
      start_load();
    $('#msg').html('')
    $.ajax({
      url:'ajax.php?action=save_files',
      data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
      success:function(resp){
        if(typeof resp != undefined){
          resp = JSON.parse(resp);
          if(resp.status == 1){
            alert_toast("New File successfully added.",'success')
            setTimeout(function(){
              location.reload()
            },1500)
          }else{
            $('#msg').html('<div class="alert alert-danger">'+resp.msg+'</div>')
            end_load()
          }
        }
      }
    })
    })
  })
  function displayname(input,_this) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function(e) {
                  _this.parent().parent().find('.custom-file-label').html(input.files[0].name)
              }
              reader.readAsDataURL(input.files[0]);
          }
      }
</script>