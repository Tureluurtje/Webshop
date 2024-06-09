<?php
// Load Composer's autoloader
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$to = 'arthurmichielkwak@gmail.com';

function url() {
    return sprintf(
        "%s://%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME']
    );
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = trim(stripslashes($_POST['fname']));
    $lname = trim(stripslashes($_POST['lname']));
    $email = trim(stripslashes($_POST['email']));
    $subject = trim(stripslashes($_POST['subject']));
    $contact_message = trim(stripslashes($_POST['message']));

    $name = $fname . ' ' . $lname;

    if ($subject == '') { $subject = "Contact Form Submission"; }

    // Set Message
    $message = ""; // initialize $message
    $message .= "Email from: " . $name . "<br />";
    $message .= "Email address: " . $email . "<br />";
    $message .= "Message: <br />";
    $message .= nl2br($contact_message);
    $message .= "<br /> ----- <br /> This email was sent from your site " . url() . " contact form. <br />";

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'arthurmichielkwak@gmail.com'; // Replace with your Gmail address
        $mail->Password   = 'your_app_password'; // Replace with your Gmail app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        // Send email
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
