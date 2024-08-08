<?php

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$Err = "";
$name = $email = $phone = $website = $comment = "";

//Function for  Checking if field is empty or not
function fieldValidation($data)
{
    if (empty($data)) {
        $Err = "Field is required";
    } else {
        return $data;
    }
}

// Validation Function
function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = validate(fieldValidation($_POST["Name"]));
    $email = filter_var(fieldValidation($_POST["Email"]), FILTER_VALIDATE_EMAIL);
    $phone = validate(fieldValidation($_POST["Phone"]));
    $website = validate(fieldValidation($_POST["Website"]));
    $comment = validate(fieldValidation($_POST["Comment"]));
}

if ($email === false) {
    echo "Enter a valid email!";
} else {
    if (!empty($email) && !empty($comment)) {
        $receiver = "hassaanmuneer854@gmail.com";
        $subject = "From: $name <$email>";
        $body = "Name: $name\nEmail: $email\nPhone: $phone\nWebsite: $website\nComment: $comment\n";

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = 'd509b0b0dcc6fa';
            $mail->Password = '9367ff66de9232';

            // Recipients
            $mail->setFrom($email, $name);
            $mail->addAddress($receiver);

            // Content
            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            echo "Your message has been sent!";
        } catch (Exception) {
            echo "Sorry, failed to send your message. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Please fill out all required fields.";
    }
}
