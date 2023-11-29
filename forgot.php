<?php 
session_start();
$error = array();

require "mail.php";



	if(!$conn = mysqli_connect("localhost","root","","fms_db")){
	// if(!$conn = mysqli_connect("localhost","root","","laco2_db")){

		die("could not connect");
	}

	$mode = "enter_email";
	if(isset($_GET['mode'])){
		$mode = $_GET['mode'];
	}

	//something is posted
	if(count($_POST) > 0){

		switch ($mode) {
			case 'enter_email':
				// code...
				$email = $_POST['email'];
				//validate email
				if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
					$error[] = "Please enter a valid email";
				}elseif(!valid_email($email)){
					$error[] = "That email was not found";
				}else{

					$_SESSION['forgot']['email'] = $email;
					send_email($email);
					header("Location: forgot.php?mode=enter_code");
					die;
				}
				break;

			case 'enter_code':
				// code...
				$code = $_POST['code'];
				$result = is_code_correct($code);

				if($result == "the code is correct"){

					$_SESSION['forgot']['code'] = $code;
					header("Location: forgot.php?mode=enter_password");
					die;
				}else{
					$error[] = $result;
				}
				break;

			case 'enter_password':
				// code...
				$password = $_POST['password'];
				$password2 = $_POST['password2'];
				if(strLen($password) < 8)
				{
					$error[] = "Password must be at least 8 characters long"; //error message
				}
				elseif($password !== $password2){
					$error[] = "Passwords do not match";
				}elseif(!isset($_SESSION['forgot']['email']) || !isset($_SESSION['forgot']['code'])){
					header("Location: forgot.php");
					die;
				}else{
					
					save_password($password);
					if(isset($_SESSION['forgot'])){
						unset($_SESSION['forgot']);
					}

					echo "<script>alert('Password successfully changed. You may now log in.'); window.location.href = 'login.php';</script>";
					die;
				}
				break;
			
			default:
				// code...
				break;
		}
	}

	function send_email($email){
		
		global $conn;

		$expire = time() + (60 * 5);
		$code = rand(10000,99999);
		$email = addslashes($email);

		$query = "insert into codes (email,code,expire) value ('$email','$code','$expire')";
		mysqli_query($conn,$query);

		//send email here
		send_mail($email,'Password reset',"
		<b>A Password reset was requested. In order to proceed, use the code below:</b><br>"
				."<h1>".$code."</h1>".
	"<br><br><b>If you did not make this request then please ignore this email.</b>" );
	}
	
	function save_password($password){
		
		global $conn;

		// $password = password_hash($password, PASSWORD_DEFAULT);
		$email = addslashes($_SESSION['forgot']['email']);

		$query = "update users set password = '$password' where email = '$email' limit 1";
		mysqli_query($conn,$query);

	}
	
	function valid_email($email){
		global $conn;

		$email = addslashes($email);

		$query = "select * from users where email = '$email' limit 1";		
		$result = mysqli_query($conn,$query);
		if($result){
			if(mysqli_num_rows($result) > 0)
			{
				return true;
 			}
		}

		return false;

	}

	function is_code_correct($code){
		global $conn;

		$code = addslashes($code);
		$expire = time();
		$email = addslashes($_SESSION['forgot']['email']);

		$query = "select * from codes where code = '$code' && email = '$email' order by id desc limit 1";
		$result = mysqli_query($conn,$query);
		if($result){
			if(mysqli_num_rows($result) > 0)
			{
				$row = mysqli_fetch_assoc($result);
				if($row['expire'] > $expire){

					return "the code is correct";
				}else{
					return "the code is expired";
				}
			}else{
				return "the code is incorrect";
			}
		}

		return "the code is incorrect";
	}

	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Forgot</title>
	 <link rel="stylesheet" type="text/css" 
    href="bootstrapfile/bootstrap.min.css">    <!--- this is boostrap file -bry -->
	<link rel="icon" href="assets/img/team/chmsclogo.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css"  
    href="bootstrapfile/all.min.css">
	<link rel="stylesheet" href="signup.css?v=<?php echo time()?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap" />
</head>
<body>
<nav class="navbar navbar-light navbar-expand-md sticky-top navbar-shrink py-3" id="mainNav" style="background: rgb(8, 36, 91);">
            <div class="container-fluid px-5">
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
<style>

body{
    margin: 0;
    padding: 0;
    height: 100vh;
    
}

.card {
    ...
    background-color: rgba(0, 0, 0, 0.2);
    ...
}
.danger{
	 
	margin-top:-100px;
}
	</style>


		<?php 

			switch ($mode) {
				case 'enter_email':
					// code...
					?>
						<form method="post" action="forgot.php?mode=enter_email"> 
						<div class="p-4 mx-auto shadow rounded" style="margin-top:70px; width:100%; max-width: 400px; background-color:white;">
							<h2 class="text-center">Forgot Password</h2>
							<img src="assets/img/team/chmsclogo.png" class="border border-success d-block mx-auto rounded-circle" style="width:120px;">
							<br>
							<h6 class="text-center">Enter your email to send the  verification code</h6>
							
							<span style="font-size: 15px;color:red;">
							<?php 
								foreach ($error as $err) {
									// code...
									echo $err . "<br>";
								}
							?>
							</span>
							<input class="form-control" style="border-radius:5px;" type="email" name="email" placeholder="Email">
							<br>
							<div class="alert alert-success" role="alert" style="border-radius:5px;">
								Please allow 2-3 minutes for the code to be sent.
							</div>
							<br>
							<br style="clear: both;">
							<input class="btn text-light" type="submit" value="Next"  style="background-color:#2F56AA; border-radius:10px;">
							<div><a class="float-end text-reset" href="login.php" ><h7 style="color:#08245b;text-decoration:underline;">Return to Login<h7></a></div>
							<br>
						</div>

						</div>
						</form>
					<?php				
					break;

				case 'enter_code':
					// code...
					?>
						<form method="post" action="forgot.php?mode=enter_code"> 
						<div class="p-4 mx-auto shadow rounded" style="margin-top:50px; width:100%; max-width: 400px; background-color:white;">
							<h2>Forgot Password</h2>
							<img src="assets/img/team/chmsclogo.png" class="border border-success d-block mx-auto rounded-circle" style="width:120px;">
							<br>
							<h6>Enter your the code sent to your email</h6>
							<span style="font-size: 15px;color:red;">
							<?php 
								foreach ($error as $err) {
									// code...
								       	echo $err . "<br>";
								}
							?>
							</span>

							<input class="form-control" type="text" name="code" placeholder="12345" style="border-radius:5px;"><br>

							<div class="alert alert-success" role="alert">
								Please allow 2-3 minutes for the code to be sent.
							</div>
						
							<input class="btn text-light" type="submit" value="Next"  style="background-color:#2F56AA; margin-top:50px; border-radius:10px;">
							<a href="forgot.php">
								<center><input class="btn btn-danger" type="button" value="Start Over"></center>
							</a>
							<br>
							<!-- <div><a href="login.php">Login</a></div> -->
						</div>
						</form>
					<?php
					break;

				case 'enter_password':
					// code...
					?>
						<form method="post" action="forgot.php?mode=enter_password"> 
						<div class="p-4 mx-auto shadow rounded" style="margin-top:50px; width:100%; max-width: 400px; background-color:white; margin-top:30px; height:590px;">
							<h2>Forgot Password</h2>
							<img src="assets/img/team/chmsclogo.png" class="border border-success d-block mx-auto rounded-circle" style="width:120px;">
							<h6>Enter your new password</h6>
							<span style="font-size: 15px;color:red;">
							<?php 
								foreach ($error as $err) {
									// code...
									echo $err . "<br>";
								}
							?>
							</span>

							<input class="form-control" type="text" name="password" placeholder="Password" style="border-radius:5px;"><br>
							<input class="form-control" type="text" name="password2" placeholder="Retype Password" style="border-radius:5px;">
							<br style="clear: both;">
							<input class="btn text-light" type="submit" value="Next"  style="background-color:#2F56AA; margin-top:40px; border-radius:5px;">
							
							<a href="forgot.php">
							<center><input class="btn btn-danger" type="button" value="Start Over" style="border-radius:5px;"></center>
							</a>
							<br> <br>
							<div ><a class="float-end text-reset" href="login.php"><h7 style="margin-top:-40px;color:#08245b;text-decoration:underline;">Return to Login<h7></a></div>
							<br>
							</div>
						</form>
					<?php
					break;
				
				default:
					// code...
					break;
			}

		?>


</body>
</html>