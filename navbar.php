<style>
	.blue {
  background-color: #08245b;
}
.icon-field{
	color:lightblue;
}
.nav-item nav-email{
margin-right:100px;     
}
</style>

<nav id="sidebar" class='mx-lt-5 blue' style="border-bottom-right-radius:120px;">

        <div class="sidebar-list" style="margin-top:50px;">
                
                <a href="index.php?page=home" class="nav-item nav-home" style="border-radius:10px;border:none;margin-top:10px;"><span class='icon-field'><i class="fa fa-home"></i></span> Dashboard</a>
                <a href="index.php?page=files" class="nav-item nav-files" style="border-radius:10px;border:none;margin-top:10px;"><span class='icon-field'><i class="fa fa-file"></i></span> Files</a>
                <a href="index.php?page=email" class="nav-item nav-email" style="border-radius:10px;border:none;margin-top:10px;"><span class='icon-field'><i class="fa fa-envelope"></i></span> File Sender</a>
                <?php if($_SESSION['login_type'] == 1): ?>
                <a href="index.php?page=users" class="nav-item nav-users" style="border-radius:10px;border:none;margin-top:10px;"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
                <?php endif; ?>
        </div>

</nav>
<script>
    $('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>