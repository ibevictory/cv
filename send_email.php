<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_var($_POST['yourName'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['yourEmail'], FILTER_SANITIZE_EMAIL);
    $message = filter_var($_POST['yourMessage'], FILTER_SANITIZE_STRING);

    // Validate inputs
    if (empty($name) || empty($email) || empty($message)) {
        echo "All fields are required.";
        exit;
    }

    // Initialize PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ibevictory50@gmail.com'; // Your Gmail address
        $mail->Password = 'your-app-password'; // Gmail App Password (see below)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress('ibevictory50@gmail.com'); // Your Gmail address

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body    = "<h3>Contact Form Submission</h3>
                          <p><strong>Name:</strong> $name</p>
                          <p><strong>Email:</strong> $email</p>
                          <p><strong>Message:</strong><br>$message</p>";

        $mail->send();
        echo "Message sent successfully! Redirecting...";
        header("refresh:3;url=contact.html"); // Redirect after 3 seconds
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
