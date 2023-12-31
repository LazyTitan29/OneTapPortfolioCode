<style>
	.logo {

    
}
span{
    text-indent: 0.1cm;
    color: white;
    text-align:center;
    font-size:22px;;
}
.blue {
  background-color: #08245b;
}


@media screen and (min-width: 992px) {
  .navbar .col-lg-12 {
    display: flex;
    justify-content: space-between;
  }

  .navbar .col-md-1.float-right {
    flex: 0 0 auto;
    display: flex;
    justify-content: flex-end;
    align-items: center;
  }

  .logout-admin {
    color:white;
    display: flex;
    align-items: center;
    justify-content: center;
  }
}

@media screen and (max-width: 991px) {
  .navbar .col-lg-12 {
    flex-direction: column;
  }

  .logout-admin {
    display: block;
    width: 100%;
    text-align: center;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
  }
}

.logout-admin:hover{
  color:#993333;
}

.logout-user{
  color:white;
  padding-top:20px;
  position: absolute;
  top:-10px;

}

.logout-user:hover{
  color:#993333;
}

</style>

<nav class="navbar navbar-dark blue fixed-top " style="padding:0;">
  <div class="container-fluid mt-2 mb-2">
  	<div class="col-lg-12">
  		<div class="col-md-1 float-left" style="display: flex;">
  			<div class="logo">
              <img src="assets/img/team/chmsclogo.png" width="40" height="40" />
              
  			</div>
              <span>One</span> <span>Tap</span> <span>Portfolio</span>

  		</div>
      <?php if($_SESSION['login_type'] == 1): ?>
	  	<div class="col-md-1 float-right">
	  		<a href="ajax.php?action=logout" class="logout-admin"><?php echo $_SESSION['login_username'] ?> <i class="fa fa-power-off"></i></a>
	    </div>
      <?php endif; ?>

      <?php if($_SESSION['login_type'] == 2): ?>
	  	<div class="col-md-1 float-right">
	  		<a href="ajax.php?action=logout" class="logout-user"><?php echo $_SESSION['login_username'] ?> <i class="fa fa-power-off"></i></a>
	    </div>
      <?php endif; ?>
    </div>
  </div>
  
</nav>