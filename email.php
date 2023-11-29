<?php
if (isset($_SESSION['email_sent'])) {
    echo "<script>alert('".$_SESSION['email_sent']."');</script>";
    unset($_SESSION['email_sent']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <title>Document</title>

</head>
<body>
<style>

      html, body {
      overflow: hidden;
      min-height: 100vh;
      padding-top: 50px;
      color: #666;
      }
      input, textarea { 
      outline: none;
      }
      body {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      
      }
      h1 {
      margin-top: 0;
      font-weight: 500;
      }
      .center{
        margin-top:-10vh;
      }
      form {
      margin:0 auto;
      width: 80%;
      border-radius: 30px;
      background: #fff;
      }
      .form-left-decoration,
      .form-right-decoration {
      content: "";
      position: absolute;
      width: 50px;
      height: 20px;
      border-radius: 20px;
      background: #08245b;
      }
      .form-left-decoration {
      bottom: 60px;
      left: -30px;
      }
      .form-right-decoration {
      top: 60px;
      right: -30px;
      }
      .form-left-decoration:before,
      .form-left-decoration:after,
      .form-right-decoration:before,
      .form-right-decoration:after {
      content: "";
      position: absolute;
      width: 50px;
      height: 20px;
      border-radius: 30px;
      background: #fff;
      }
      .form-left-decoration:before {
      top: -20px;
      }
      .form-left-decoration:after {
      top: 20px;
      left: 10px;
      }
      .form-right-decoration:before {
      top: -20px;
      right: 0;
      }
      .form-right-decoration:after {
      top: 20px;
      right: 10px;
      }
      .circle {
      position: absolute;
      bottom: 80px;
      left: -55px;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      background: #fff;
      }
      .form-inner {
      padding: 40px;
      }
      .form-inner input,
      .form-inner textarea {
      display: block;
      width: 100%;
      padding: 15px;
      margin-bottom: 10px;
      border: none;
      border-radius: 20px;
      background: #d0dfe8;
      }
      .form-inner textarea {
      resize: none;
      }
      button {
      width: 100%;
      padding: 10px;
      margin-top: 20px;
      border-radius: 20px;
      border: none;
      border-bottom: 4px solid #3e4f24;
      background: #08245b; 
      font-size: 16px;
      font-weight: 400;
      color: #fff;
      }
      button:hover {
      background: #2691d9;
      transition: .5s;
      } 
      @media (min-width: 568px) {
      form {
      width: 40%;
      }
      }
</style>
<div class="center"> 



<form action="sender.php" class="decor" method="post" enctype="multipart/form-data">
      <div class="form-left-decoration"></div>
      <div class="form-right-decoration"></div>
      <div class="circle"></div>
      <div class="form-inner">
        <h1>File Sender</h1>
        <input type="text" placeholder="From" name="name" required>
        <input type="email" placeholder="To(Email):" name="email" required>
        <textarea placeholder="Message..." rows="5" name="message"></textarea>
        <input type="file" name="file">
        <button type="submit" href="/">Submit</button>
      </div>
    </form>

</div>
</body>
</html>
</div>
</body>
</html>