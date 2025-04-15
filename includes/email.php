<?php
// email.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Ensure Composer's autoloader is included



function sendEmail($to, $subject, $message) {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Set your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'gaganshriwas5@gmail.com'; // SMTP username
        $mail->Password   = 'csiczfntjofbkcjy'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port       = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom('gaganshriwas5@gmail.com.com', 'LearnToCode');
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function sendRegistrationEmail($userEmail) {
    $subject = "Welcome to LearnToCode!";
    $message = "<h1>Thank you for registering!</h1>";
    $message .= "<p>We're excited to have you on board.</p>";
    
    return sendEmail($userEmail, $subject, $message);
}

function sendPasswordResetEmail($userEmail, $resetLink) {
    $subject = "Password Reset Request";
    $message = "<h1>Password Reset Request</h1>";
    $message .= "<p>Click the link below to reset your password:</p>";
    $message .= "<p><a href='$resetLink'>Reset Password</a></p>";
    
    return sendEmail($userEmail, $subject, $message);
}

// New function to send notification emails
function sendNotificationEmail($userEmail, $notificationMessage) {
    $subject = "New Notification from LearnToCode";
    
	// Constructing the HTML message body
	$message = "<h1>You have a new notification!</h1>";
	$message .= "<p>$notificationMessage</p>"; 

	return sendEmail($userEmail, $subject, nl2br($message));
}

?>


