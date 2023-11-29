<?php

$filenameee =  $_FILES['file']['name'];
$fileName = $_FILES['file']['tmp_name']; 
$name = $_POST['name'];
$email = $_POST['email'];
$usermessage = $_POST['message'];

$message ="Name = ". $name . "\r\n  Email = " . $email . "\r\n Message =" . $usermessage; 

$subject ="Contact From";
$fromname ="One tap Portfolio";
$fromemail = 'janreimalgapo@gmail.com';  //if u dont have an email create one on your cpanel

$mailto = $email;  //the email which u want to recv this email

if(!empty($fileName)){
    $content = file_get_contents($fileName);
    $content = chunk_split(base64_encode($content));

    // a random hash will be necessary to send mixed content
    $separator = md5(time());

    // carriage return type (RFC)
    $eol = "\r\n";

    // main header (multipart mandatory)
    $headers = "From: ".$fromname." <".$fromemail.">" . $eol;
    $headers .= "MIME-Version: 1.0" . $eol;
    $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
    $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
    $headers .= "This is a MIME encoded message." . $eol;

    // message
    $body = "--" . $separator . $eol;
    $body .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;
    $body .= "Content-Transfer-Encoding: 8bit" . $eol;
    $body .= $message . $eol;

    // attachment
    $body .= "--" . $separator . $eol;
    $body .= "Content-Type: application/octet-stream; name=\"" . $filenameee . "\"" . $eol;
    $body .= "Content-Transfer-Encoding: base64" . $eol;
    $body .= "Content-Disposition: attachment" . $eol;
    $body .= $content . $eol;
    $body .= "--" . $separator . "--";
}
    //SEND Mail
    if (mail($mailto, $subject, $body, $headers)) {
        session_start();
        $_SESSION['email_sent'] = "Email sent successfully to $email from $fromname";
        header("Location: index.php?page=email");
        
    }else {
    echo "<script>alert('Error sending email.');</script>";
    echo "mail send ... ERROR!";
    print_r( error_get_last() );
}
    