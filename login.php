<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link rel="icon" href="assets/img/team/chmsclogo.png" type="image/x-icon">
        <title>Login | One Tap Portfolio</title>
        <link rel="stylesheet" href="login1.css?v=<?php echo time()?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap" />

<?php include('./header.php'); ?>
<?php 
session_start();
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");
?>

</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    /*background: #007bff;*/
	}
	main#main{
		width:100%;
		height: calc(100%);
		background:white;
	}
	#login-right{
		position: absolute;
		right:0;
		width:40%;
		height: calc(100%);
		background:white;
		display: flex;
		align-items: center;
	}
	#login-left{
		position: absolute;
		left:0;
		width:60%;
		height: calc(100%);
		background:#08245b;
		display: flex;
		align-items: center;
	}
	#login-right .card{
		margin: auto
	}
	.logo {
    margin: auto;
    font-size: 8rem;
    background: white;
    padding: .5em ;
    border-radius: 50%;
    color: #000000b3;
}
.center form{
    padding: 0 40px;
    box-sizing: border-box;
}
form .txt_field{
    position: relative;
    border-bottom: 2px solid #adadad;
    margin: 30px 0;
}
.txt_field input{
   width: 100%;
   padding: 0 5px; 
   height: 40px;
   font-size: 16px;
   border: none;
   background: none;
   outline: none;
}
.txt_field label{
    position: absolute;
    top: 50%;
    left: 5px;
    color: #adadad;
    transform: translateY(-50%);
    font-size: 16px;
    pointer-events: none;
    transition: .5s;

}
.txt_field span::before{
    content: '';
    position: absolute;
    top: 40px;
    left: 0;
    width: 0%;
    height: 2px;
    background: #2691d9;
    transition: .5s;
}
.txt_field input:focus ~ label,
.txt_field input:valid ~ label{
    top: -5px;
    color: #2691d9;
}
.txt_field input:focus ~ span::before,
.txt_field input:valid ~ span::before{
    width: 100%;
}
.pass{
    margin: -5px 0 20px 5px;
    color: #2691d9;
    cursor: pointer;
}
.pass:hover{
    text-decoration: underline;
    
    transition: .5s;
    
}
input[type="submit"]{
    width: 100%;
    height: 50px;
    border: 2px solid;
    background: #08245b;
    font-size: 18px;
    color: #e9f4fb ;
    font-weight: 700;
    cursor: pointer;
    outline: none;
}
input[type="submit"]:hover{
    border-color: #2691d9;
    transition: .5s;
}
.signup_link{
    margin: 30px 0;
    text-align: center;
    font-size: 16px;
    color: #666666;
}
.signup_link a{
    color: #2691d9;
    text-decoration: none;
}
.signup_link a:hover{
    text-decoration: underline;
}
@media only screen and (max-width: 768px) {
            #login-left {
                display: none;
            }

     #login-right{
        position: absolute;
        right:0;
        width:100%;
        height: calc(100%);
        background:white;
        display: flex;
        align-items: center;
    }
        }
</style>

  <main id="main" class=" alert-info">
  		<div id="login-left">
  			<div class="logo">
			  <img src="assets/img/team/chmsclogo.png" width="300" height="300" />
  			</div>
  		</div>
  		<div id="login-right">
  			<div class="card col-md-8">
  				<div class="card-body">
				  <form action="" method="post" id="login-form">
							<div class="txt_field">
								<input type="text" id="username" name="username" required>
								<span></span>
								<label for="username" class="control-label">Username</label>
							</div>

							<div class="txt_field">
								<input type="password" id="password" name="password" required>
								<span></span>
								<label for="password" class="control-label">Password</label>
							</div>
							<!--end of txt_field class-->

							<div class="pass"><a href="forgot.php">Forget Password?</a></div>
							<!--end of pass class-->

							<input type="submit" value="Login">

							<div class="signup_link">
								You dont have an account? Sign up <a href="sign-up.php">here</a>
							</div>
							<!--end of signup_link class-->

       </form> 

  				</div>
  			</div>
  		</div>
   

  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form input[type="submit"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#login-form input[type="submit"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1){
					location.reload('index.php?page=home');
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#login-form input[type="submit"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>	
</html>



    <body>

        <nav class="navbar navbar-light navbar-expand-md sticky-top navbar-shrink py-3" id="mainNav" style="background: rgb(8, 36, 91);">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="homepage.php">
                    <span class="bs-icon-sm bs-icon-circle bs-icon-primary shadow d-flex justify-content-center align-items-center me-2 bs-icon">
                        <img src="assets/img/team/chmsclogo.png" width="42" height="44" />
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-bezier">
                            <path
                                fill-rule="evenodd"
                                d="M0 10.5A1.5 1.5 0 0 1 1.5 9h1A1.5 1.5 0 0 1 4 10.5v1A1.5 1.5 0 0 1 2.5 13h-1A1.5 1.5 0 0 1 0 11.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm10.5.5A1.5 1.5 0 0 1 13.5 9h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM6 4.5A1.5 1.5 0 0 1 7.5 3h1A1.5 1.5 0 0 1 10 4.5v1A1.5 1.5 0 0 1 8.5 7h-1A1.5 1.5 0 0 1 6 5.5v-1zM7.5 4a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"
                            ></path>
                            <path
                                d="M6 4.5H1.866a1 1 0 1 0 0 1h2.668A6.517 6.517 0 0 0 1.814 9H2.5c.123 0 .244.015.358.043a5.517 5.517 0 0 1 3.185-3.185A1.503 1.503 0 0 1 6 5.5v-1zm3.957 1.358A1.5 1.5 0 0 0 10 5.5v-1h4.134a1 1 0 1 1 0 1h-2.668a6.517 6.517 0 0 1 2.72 3.5H13.5c-.123 0-.243.015-.358.043a5.517 5.517 0 0 0-3.185-3.185z"
                            ></path>
                        </svg>
                    </span>
                    <span style="color: #ffffff;">One Tap Portfolio</span>
                </a>
                <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1" style="margin-right: 210px;">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a class="nav-link" href="homepage.php" style="color: #ffffff;">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="services.php" style="color: #ffffff;">Features</a></li>
                        <li class="nav-item"><a class="nav-link" href="contacts.php" style="color: #ffffff;">Contacts</a></li>
                    </ul>
                    
                    
                </div>
            </div>
        </nav>
        <header class="bg-primary-gradient"></header>
        <footer class="bg-primary-gradient"></footer>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/script.min.js"></script>