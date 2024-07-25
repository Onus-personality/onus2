<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/PHPMailer.php';

error_reporting(E_ALL);

// Function to get a specific cookie value by name
function getCookieValue($name) {
    $value = null;
    if (isset($_COOKIE[$name])) {
        $value = $_COOKIE[$name];
    }
    return $value;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $fullName = $_POST['fname'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $score = getCookieValue('scorePercentage');
    $attachmentPath = 'Demo Items/data.txt'; // Get path to attachment from the form

    // Create a PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Set up server settings
        $mail->SMTPDebug = 2; // Enable verbose debug output
        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'pretentraven@gmail.com';
        $mail->Password = 'pvfeqchvrmcuvelj';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Set up email content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "Name: $fullName<br>Email: $email<br>Message: $message<br>Score: $score%";
        $mail->AltBody = "Name: $fullName\nEmail: $email\nMessage: $message\Score: $score%";

        // Add the attachment
        $mail->addAttachment($attachmentPath);

        // Set up recipient
        $mail->addAddress("pretentraven@gmail.com", "$fullName");

        $mail->send();
        // Redirect to thank you page using JavaScript
        echo '<script>window.location.href = "thank_you.html";</script>';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request method.";
}