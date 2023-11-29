<?php
error_reporting(0);
$name = $_POST['name'];
$email = $_POST['email'];
$subject = "Feedback";
$message = $_POST['message'];

$mailheader = "From:".$name."<".$email.">\r\n";

$recipient = "feedback@example.com"; //Hard-coded recipient email address

if(isset($_POST['recipient_email']))
{
  $recipient = $_POST['recipient_email'];
}

if(mail($recipient, $subject, $message, $mailheader)){
  header("Location: contacts.php?success=1", true, 302);
}
else{
  die("Error!");
}

?>
