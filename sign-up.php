<?php 
session_start();
include("db_connect.php");
include("function.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $type = 2;

    if (!empty($name) && !empty($username) && !empty($email) && !empty($password)) {
        if (strlen($password) >= 8 && preg_match("#[a-zA-Z]+#", $password) && preg_match("#[^a-zA-Z0-9]+#", $password)) {
            $user_id = random_num(20);
            $query = "insert into users (user_id,name,username,email,password,type) values( '$user_id','$name','$username','$email','$password','$type')";
            mysqli_query($conn, $query);
            echo "<script>alert('Successfully signed up! Redirecting to login...'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Password must contain a special character and at least 8 characters.');</script>";
        }
    } else {
        echo "<script>alert('Please fill in all the required fields.');</script>";
    }
}

?>
<!DOCTYPE html>
<?php

?>
<html lang="en">
    <head>
        <link rel="icon" href="assets/img/team/chmsclogo.png" type="image/x-icon">
        <title>Signup | One Tap Portfolio</title>
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

        <div class="center" style="margin-top:70px; width:100%; max-width: 400px; background-color:white;"> 

            <h1><img src="assets/img/team/chmsclogo.png" width="100" height="100"/><br> Signup </h1>
    
           <form action="" method='POST'>
            <div class="txt_field">
                <input type="text" name="full_name" required>
                <span></span>
                <label>Fullname</label>
            </div>
            <div class="txt_field">
                <input type="text" name="username" required>
                <span></span>
                <label>Username</label>
            </div>
            <div class="txt_field">
                <input type="text" name="email" required>
                <span></span>
                <label>Email</label>
            </div>
            <div class="txt_field">
                <input type="Password" name="password" id="password" required>
                <span></span>
                <label>Password</label>
            </div>
            <br>
            <!--end of txt_field class-->

    
            <input type="submit" value="Signup">

              <div class="signup_link">
                Already have an account? Login <a href="login.php">here</a>
                <?php
                  $terms_and_conditions_url = 'terms_and_conditions.php';
                  echo '<a href="' . $terms_and_conditions_url . '">Terms and Condition</a>';
                ?>
              </div>

           </form> 
    
        </div>
        <!--end of center class-->
    </body>
</html>







