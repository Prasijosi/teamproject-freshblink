<?php
$to_email = "bibek8872@gmail.com";
$subject = "xxx";
$headers = "From: goCart  <gocartuk@gmail.com>";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";



if (mail($to_email, $subject, $message, $headers)) {
    echo "Email successfully sent to $to_email...";
} else {
    echo "Email sending failed...";
}

?>